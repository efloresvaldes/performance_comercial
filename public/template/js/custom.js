


$(function () {
    'use strict'





    $('#periodStart').datepicker({
        format: 'mm/yyyy',
        startView: 2,
        minViewMode: 1,
        autoclose: true,
        orientation: 'bottom',
        startDate: new Date('01-01-2007'),
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
        let startDateVal = $('#periodStart').val()
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
            $('#reportDiv').html('');
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
                    let period = response[1]
                    let datasets = generateDataSets(response)
                    const ctx = document.getElementById('charts');
                    const myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: period,
                            datasets: datasets
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                },
                                x: {
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

    $("#piechartBtn").click(function () {

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
                url: './con_desempenho_pie',
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
                    let graficData = generatePieDatasets(response)
                    var ctx2 = $("#charts");
                    var data1 = {
                        labels: graficData[0],
                        datasets: [{
                            data: graficData[1],
                            backgroundColor: graficData[2],

                        }]
                    };
                    var options = {
                        responsive: true,
                        title: {
                            display: true,
                            position: "top",
                            text: "Participação na Receita líquida",
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



function generateDataSets(data){
    let result = [];
    let barData=[]
    for(let i = 0; i< data[1].length;i++){
        barData.push(data[0])
    }
    result.push({
        type: 'line',
        data: barData,
        options: {
          plugins: {
            title: {
              display: true,
              text: 'Promedio Costo Fijo'
            }
          },
          fill: false,
          borderColor: 'rgb(75, 192, 192)',
          scales: {
            y: {
              stacked: true
            }
          }
        },
      })
    data = data[2]
    for(let i = 0; i < data.length; i++){
        let rc='#'+ Math.floor(Math.random()*16777215).toString(16);
        result.push({
            label:data[i][0],
            data: data[i][1],
            backgroundColor:rc,
            borderWidth:1

        })
    }
    return result;
}
 function generatePieDatasets(dataPie){
     let data = []
     let labels = []
     let colors=[]
     let result=[]


     for(let i = 1; i<dataPie.length; i++){
         labels.push(dataPie[i][1])
         data.push(dataPie[i][0])
         colors.push('#'+ Math.floor(Math.random()*16777215).toString(16))
     }

     result.push(labels);
     result.push(data);
     result.push(colors);

     return result;

 }


