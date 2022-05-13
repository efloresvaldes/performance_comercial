

$(function () {
    'use strict'



 /*   var ctx2 = $("#pieChart");
    var data1 = {
        labels: ["match1", "match2", "match3", "match4", "match5"],
        datasets: [{
            label: "TeamA Score",
            data: [10, 50, 25, 70, 40],
            backgroundColor: [
                "#DEB887",
                "#A9A9A9",
                "#DC143C",
                "#F4A460",
                "#2E8B57"
            ],
            borderColor: [
                "#CDA776",
                "#989898",
                "#CB252B",
                "#E39371",
                "#1D7A46"
            ],
            borderWidth: [1, 1, 1, 1, 1]
        }]
    };
    var options = {
        responsive: true,
        title: {
            display: true,
            position: "top",
            text: "Pie Chart",
            fontSize: 18,
            fontColor: "#111"
        },
        legend: {
            display: true,
            position: "bottom",
            labels: {
                fontColor: "#333",
                fontSize: 16
            }
        }
    };
    var chart1 = new Chart(ctx2, {
        type: "pie",
        data: data1,
        options: options
    });*/

    $('#periodStart').datepicker({
        format: 'mm/yyyy',
        startView: 2,
        minViewMode: 1,
        autoclose: true,
        orientation: 'bottom',
        startDate: new Date('10-01-2020'),
        endDate: new Date()
    });
    $("#periodStart").change(function () {
        var startDate = $('#periodStart').val()
        var dateInfo = startDate.split('/');
        var endStartDate = new Date(dateInfo[0] + '-01-' + dateInfo[1])
        endStartDate = endStartDate.setMonth(endStartDate.getMonth()+1);

        $('#periodEnd').datepicker({
            format: 'mm/yyyy',
            startView: 2,
            minViewMode: 1,
            autoclose: true,
            orientation: 'bottom',
            startDate: new Date(endStartDate),
            endDate: new Date()
        })


    });
    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox({



        filterPlaceHolder: 'Filtro', // Marcador de posición del cuadro de entrada de la condición del filtro, contenido personalizable, el valor predeterminado es 'Filter',
        moveAllLabel: 'Agregar todas las opciones', // Agregar la etiqueta de todos los botones de opción, el valor predeterminado es 'Mover todo'
        moveSelectedLabel: 'Adicionar todas as opções', // Agregar etiqueta del botón de opción seleccionado, predeterminado 'Mover seleccionado'
        removeAllLabel: 'Remover todas as opções', // Eliminar la etiqueta de todos los botones de opciones, el valor predeterminado es 'Eliminar todo'

        infoText: 'Total de opções seleccionadas / não seleccionado {0} elementos', // Cuando no se filtra, elementos totales de opciones seleccionadas / no seleccionadas; el valor predeterminado es 'Mostrar todo {0}';
        infoTextFiltered: 'Vazados {0} elementos de {1} elementos',
        infoTextEmpty: 'Lista vazia', // cuando la condición del filtro es '', y el contenido que se muestra cuando la lista seleccionada / no seleccionada no tiene opciones; el valor predeterminado es 'Lista vacía';
        filterOnValues: false, // No sé el rol específico por el momento
    });

    $("#report").click(function () {


        let consultants = $("#consultantsSelect").val()
        let startDateVal = $('#periodStart').val();
        let endDateVal = $('#periodEnd').val()
        if (startDateVal === '') {
            alert('Por favor, seleccione a data de início do período');
        }
        else if (endDateVal === '') {
            alert('Por favor, seleccione a data final do período');
        }
        else if (consultants.length == 0) {
            alert('Por favor, seleccione consultores para discutir');
        }
        else if (new Date('01-' + startDateVal).getTime() > new Date('01-' + endDateVal).getTime()) {
            alert('seleccione a data final do período mais longa do que a data inicial');
        }
        else {
            $.ajax({

                type: 'post',
                dataType: 'html',
                url: './con_desempenho_res',
                data: {
                    "_token": $("meta[name='csrf-token']").attr("content"),
                    'consultants': consultants,
                    'startDate': startDateVal,
                    'endDate': endDateVal,

                },
                beforeSend: function () {
                    $.blockUI({
                        message: '<h6>Relatório de carregamento</h6>'
                    });

                },
                success: function (response) {
                    $.unblockUI()
                    $("#reportDiv").html(response)

                },
                error: function (jqXHR) {
                    $.unblockUI()
                    alert(jqXHR.responseText)
                }

            });
        }



    });

    $("#barchartBtn").click(function () {


        let consultants = $("#consultantsSelect").val()
        let startDateVal = $('#periodStart').val();
        let endDateVal = $('#periodEnd').val()
        if (startDateVal === '') {
            alert('Por favor, seleccione a data de início do período');
        }
        else if (endDateVal === '') {
            alert('Por favor, seleccione a data final do período');
        }
        else if (consultants.length == 0) {
            alert('Por favor, seleccione consultores para discutir');
        }
        else if (new Date('01-' + startDateVal).getTime() > new Date('01-' + endDateVal).getTime()) {
            alert('seleccione a data final do período mais longa do que a data inicial');
        }
        else {
            $.ajax({

                type: 'post',
                dataType: 'json',
                url: './con_desempenho_graf',
                data: {
                    "_token": $("meta[name='csrf-token']").attr("content"),
                    'consultants': consultants,
                    'startDate': startDateVal,
                    'endDate': endDateVal,

                },
                beforeSend: function () {
                    $.blockUI({
                        message: '<h6>Gráfico de carregamento</h6>'
                    });

                },
                success: function (response) {
                    $.unblockUI()
                    const ctx = document.getElementById('barchart');
                    const myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                            datasets: [
                                {
                                    label: '# of Votes',
                                    data: [12, 19, 3, 5, 2, 3],
                                    backgroundColor: [
                                        'rgba(255, 99, 132, 0.2)',
                                        'rgba(54, 162, 235, 0.2)',
                                        'rgba(255, 206, 86, 0.2)',
                                        'rgba(75, 192, 192, 0.2)',
                                        'rgba(153, 102, 255, 0.2)',
                                        'rgba(255, 159, 64, 0.2)'
                                    ],
                                    borderColor: [
                                        'rgba(255, 99, 132, 1)',
                                        'rgba(54, 162, 235, 1)',
                                        'rgba(255, 206, 86, 1)',
                                        'rgba(75, 192, 192, 1)',
                                        'rgba(153, 102, 255, 1)',
                                        'rgba(255, 159, 64, 1)'
                                    ],
                                    borderWidth: 1
                                },
                                {
                                    label: '# of Votes',
                                    data: [12, 19, 3, 5, 2, 3],
                                    backgroundColor: [
                                        'rgba(255, 99, 132, 0.2)',
                                        'rgba(54, 162, 235, 0.2)',
                                        'rgba(255, 206, 86, 0.2)',
                                        'rgba(75, 192, 192, 0.2)',
                                        'rgba(153, 102, 255, 0.2)',
                                        'rgba(255, 159, 64, 0.2)'
                                    ],
                                    borderColor: [
                                        'rgba(255, 99, 132, 1)',
                                        'rgba(54, 162, 235, 1)',
                                        'rgba(255, 206, 86, 1)',
                                        'rgba(75, 192, 192, 1)',
                                        'rgba(153, 102, 255, 1)',
                                        'rgba(255, 159, 64, 1)'
                                    ],
                                    borderWidth: 1
                                }
                            ]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });

                },
                error: function (jqXHR) {
                    $.unblockUI()
                    alert(jqXHR.responseText)
                }

            });
        }



    });




})

