

$(function () {
    'use strict'
   
    
   
    $('#periodStart').datepicker({
        format: 'mm/yyyy',
        startView: 2,

        maxViewMode: 2,
        minViewMode: 1,
        autoclose: true,
        orientation: 'bottom',
        startDate: new Date('01-01-2007'),
        orientation: 'top',
        endDate: new Date()
    });
    $("#periodStart").change(function () {

        var startDate = $('#periodStart').val()
        var dateInfo = startDate.split('/');
        var endStartDate = new Date(dateInfo[0] + '-01-' + dateInfo[1])
        endStartDate = endStartDate.setMonth(endStartDate.getMonth() + 1);

        $('#periodEnd').val('');

        $('#periodEnd').datepicker({
            format: 'mm/yyyy',
            startView: 2,
            maxViewMode: 2,
            minViewMode: 1,
            autoclose: true,
            orientation: 'top',
            startDate: new Date(endStartDate),
            endDate: new Date('12-31-' + dateInfo[1])
        })

        $('#periodEnd').datepicker('setFormat', 'mm/yyyy').datepicker('setStartView', 1).datepicker('setMaxViewMode', 2).datepicker('setMinViewMode', 1).datepicker('setAutoclose', true).datepicker('setOrientation', 'bottom').datepicker('setMaxViewMode', 2).datepicker('setStartDate', new Date(endStartDate)).datepicker('setEndDate', new Date('12-31-' + dateInfo[1]))






    });
    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox({

        filterPlaceHolder: 'Filtro', // Marcador de posición del cuadro de entrada de la condición del filtro, contenido personalizable, el valor predeterminado es 'Filter',
        moveAllLabel: 'Agregar todas las opciones', // Agregar la etiqueta de todos los botones de opción, el valor predeterminado es 'Mover todo'
        moveSelectedLabel: 'Adicionar todas as opções', // Agregar etiqueta del botón de opción seleccionado, predeterminado 'Mover seleccionado'
        removeAllLabel: 'Remover todas as opções', // Eliminar la etiqueta de todos los botones de opciones, el valor predeterminado es 'Eliminar todo'

        infoText: 'Total de elementos seleccionados / não seleccionado {0} opções', // Cuando no se filtra, elementos totales de opciones seleccionadas / no seleccionadas; el valor predeterminado es 'Mostrar todo {0}';
        infoTextFiltered: 'Vazados {0} elementos de {1} elementos',
        infoTextEmpty: 'Lista vazia', // cuando la condición del filtro es '', y el contenido que se muestra cuando la lista seleccionada / no seleccionada no tiene opciones; el valor predeterminado es 'Lista vacía';
        filterOnValues: false, // No sé el rol específico por el momento
    });

    $("#report").click(function () {
        
        if ($("#searchConsultants").valid()) {
            let consultants = $("#consultantsSelect").val()
            let startDateVal = $('#periodStart').val()
            let endDateVal = $('#periodEnd').val()


            $("#reportDiv").html('');
            clearCanvas();


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
                        message: '<h6>carga</h6>'
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

        if ($("#searchConsultants").valid()) {
            let consultants = $("#consultantsSelect").val()
            let startDateVal = $('#periodStart').val()
            let endDateVal = $('#periodEnd').val()

            $("#reportDiv").html('');
            clearCanvas();

            var canvas = document.getElementById("charts");
            var ctx = canvas.getContext('2d');

           
            
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
                        message: '<h6>Carga</h6>'
                    });

                },
                success: function (response) {

                    $.unblockUI()
                    var data = {
                        labels: response[1],
                        datasets: generateDataSets(response)
                    };
                   
                    var myBarChart = new Chart(ctx, {
                        type: 'bar',
                        data: data,
                        options: {
                            scales: {
                                xAxes: [{
                                    barPercentage: 1,
                                    categoryPercentage: 0.5,
                                    gridLines: {
                                        display: false
                                    },
                                    ticks: {
                                        fontColor: "#8f9092"
                                    }
                                }],
                                yAxes: [{
                                    display: true,
                                    ticks: {
                                        beginAtZero: true,
                                        callback: function (value) {
                                            return new Intl.NumberFormat('pt', { style: 'currency', currency: 'BRL' }).format(Number(value))
                                        }
                                    }
                                }]
                            },
                            tooltips: {
                                callbacks: {
                                    label: function (tooltipItem) {
                                        return new Intl.NumberFormat('pt', { style: 'currency', currency: 'BRL' }).format(Number(tooltipItem.yLabel))
                                        
                                    }
                                }
                            },
                            legend: {
                                position: 'bottom'
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

        if ($("#searchConsultants").valid()) {

            let consultants = $("#consultantsSelect").val()
            let startDateVal = $('#periodStart').val()
            let endDateVal = $('#periodEnd').val()
            let test = $("#searchConsultants").validate();

            $("#reportDiv").html('');
            clearCanvas();

            var canvas = document.getElementById("charts");
            var ctx = canvas.getContext('2d');


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
                        message: '<h6>Carga</h6>'
                    });

                },
                success: function (response) {
                    $.unblockUI()

                    const graficData = generatePieDatasets(response)
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
                        },
                        tooltips: {
                            callbacks: {
                                label: function (tooltipItem, data) {
                                    return Number(data.datasets[0].data[tooltipItem.index]).toFixed(1) + "%";
                                }
                            }
                        },
                    };
                    var chart1 = new Chart(ctx, {
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

function generateDataSets(data) {
    let result = [];
    let barData = []
    for (let i = 0; i < data[1].length; i++) {
        barData.push(data[0])
    }
    result.push({
        type: 'line',
        data: barData,
        label: 'Custo Fixo',
        backgroundColor: '#252850',
        borderColor: '#252850',
        fill: false,
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Promedio Costo Fijo'
                }
            }
        },
    })
    data = data[2]
    for (let i = 0; i < data.length; i++) {
        let rc = '#' + Math.floor(Math.random() * 16777215).toString(16);
        result.push({
            label: data[i][0],
            data: data[i][1],
            backgroundColor: rc,
            borderWidth: 1

        })
    }
    return result;
}

function generatePieDatasets(dataPie) {
    let data = []
    let labels = []
    let colors = []
    let result = []


    for (let i = 1; i < dataPie.length; i++) {
        labels.push(dataPie[i][1])
        data.push(dataPie[i][0])
        colors.push('#' + Math.floor(Math.random() * 16777215).toString(16))
    }

    result.push(labels);
    result.push(data);
    result.push(colors);

    return result;

}


function clearCanvas() {

   
   
    document.getElementById("chartDiv").innerHTML = "";
    document.getElementById("chartDiv").innerHTML = ' <canvas id="charts"> </canvas>';
  
    /*var canvas = document.getElementById(canvasId);
    var ctx = canvas.getContext('2d');
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    var w = canvas.width;
    canvas.width = 1;
    canvas.width = w;*/
}




$.validator.addMethod("containsElements", function (value, element, arg) {
    return element.length != 0
}, "Must contain elements");

$.validator.addMethod("validDate", function (value, element, arg) {
    var reg = new RegExp("(((0[123456789]|10|11|12)/(([1][9][0-9][0-9])|([2][0-9][0-9][0-9]))))");

    if (value.length <= 7 && reg.test(value))
        return true;

    return false;

}, "Must have valid date");

$("#searchConsultants").validate({
    // Specify validation rules
    rules: {
        // The key name on the left side is the name attribute
        // of an input field. Validation rules are defined
        // on the right side
        periodStart: {
            required: true,
            validDate: true
        },
        periodEnd: {
            required: true,
            validDate: true
        },
        consultantsSelect_helper2: { containsElements: true }

    },
    errorClass: 'error form-check-label',
    // Specify validation error messages
    messages: {

        periodStart: {
            required: "* Campo Obrigatório",
            validDate: "* Data Inválida"
        },
        periodEnd: {
            required: "* Campo Obrigatório",
            validDate: "* Data Inválida"
        },
        consultantsSelect_helper2: { containsElements: "* Campo Obrigatório" }

    },
    errorPlacement: function (error, element) {
        if (element[0].type == "text") {
            error.insertAfter(element.parent());
        }

        else {
            error.insertAfter(element.parent().parent().parent());
        }
    },

});

