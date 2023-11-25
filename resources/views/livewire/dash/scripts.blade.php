<script>
  Highcharts.chart('grafico1', {
    chart: {
        type: 'column' // Cambiar el tipo de gráfico a columnas (barras)
    },
    title: {
        text: 'Compras por MES'
    },
    subtitle: {
        text: 'Source: Tu fuente de datos'
    },
    xAxis: {
        categories: {!! json_encode($comprasPorMes->pluck('mes')) !!},
        title: {
            text: 'Meses del año'
        }
    },
    yAxis: {
        title: {
            text: 'Número de compras'
        }
    },
    tooltip: {
        pointFormat: 'Hay <b>{point.y:,.0f}</b> compras en el MES'
    },
    series: [{
        name: 'Compras',
        data: {!! json_encode($comprasPorMes->pluck('total')) !!},
        color: 'lightgreen' // Cambia este color según tu preferencia
        
    }]
});

Highcharts.chart('grafico2', {

title: {
    text: 'U.S Solar Employment Growth',
    align: 'left'
},

subtitle: {
    text: 'By Job Category. Source: <a href="https://irecusa.org/programs/solar-jobs-census/" target="_blank">IREC</a>.',
    align: 'left'
},

yAxis: {
    title: {
        text: 'Number of Employees'
    }
},

xAxis: {
    accessibility: {
        rangeDescription: 'Range: 2010 to 2020'
    }
},

legend: {
    layout: 'vertical',
    align: 'right',
    verticalAlign: 'middle'
},

plotOptions: {
    series: {
        label: {
            connectorAllowed: false
        },
        pointStart: 2010
    }
},

series: [{
    name: 'Installation & Developers',
    data: [43934, 48656, 65165, 81827, 112143, 142383,
        171533, 165174, 155157, 161454, 154610]
}, {
    name: 'Manufacturing',
    data: [24916, 37941, 29742, 29851, 32490, 30282,
        38121, 36885, 33726, 34243, 31050]
}, {
    name: 'Sales & Distribution',
    data: [11744, 30000, 16005, 19771, 20185, 24377,
        32147, 30912, 29243, 29213, 25663]
}, {
    name: 'Operations & Maintenance',
    data: [null, null, null, null, null, null, null,
        null, 11164, 11218, 10077]
}, {
    name: 'Other',
    data: [21908, 5548, 8105, 11248, 8989, 11816, 18274,
        17300, 13053, 11906, 10073]
}],

responsive: {
    rules: [{
        condition: {
            maxWidth: 500
        },
        chartOptions: {
            legend: {
                layout: 'horizontal',
                align: 'center',
                verticalAlign: 'bottom'
            }
        }
    }]
}

});


Highcharts.chart('grafico3', {
    chart: {
        type: 'bar'
    },
    title: {
        text: 'Historic World Population by Region',
        align: 'left'
    },
    subtitle: {
        text: 'Source: <a ' +
            'href="https://en.wikipedia.org/wiki/List_of_continents_and_continental_subregions_by_population"' +
            'target="_blank">Wikipedia.org</a>',
        align: 'left'
    },
    xAxis: {
        categories: ['Africa', 'America', 'Asia', 'Europe'],
        title: {
            text: null
        },
        gridLineWidth: 1,
        lineWidth: 0
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Population (millions)',
            align: 'high'
        },
        labels: {
            overflow: 'justify'
        },
        gridLineWidth: 0
    },
    tooltip: {
        valueSuffix: ' millions'
    },
    plotOptions: {
        bar: {
            borderRadius: '50%',
            dataLabels: {
                enabled: true
            },
            groupPadding: 0.1
        }
    },
    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'top',
        x: -40,
        y: 80,
        floating: true,
        borderWidth: 1,
        backgroundColor:
            Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',
        shadow: true
    },
    credits: {
        enabled: false
    },
    series: [{
        name: 'Year 1990',
        data: [631, 727, 3202, 721]
    }, {
        name: 'Year 2000',
        data: [814, 841, 3714, 726]
    }, {
        name: 'Year 2018',
        data: [1276, 1007, 4561, 746]
    }]
});


</script>


<!-- <script>
    document.addEventListener('livewire:load', function() {
        const ctx = document.getElementById('myChart');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'],
                datasets: [{
                        label: 'Egresos',
                        data: [
                            @this.salesWeek[0],
                            @this.salesWeek[1],
                            @this.salesWeek[2],
                            @this.salesWeek[3],
                            @this.salesWeek[4],
                            @this.salesWeek[5],
                            @this.salesWeek[6],
                        ],
                        borderWidth: 2,
                        borderRadius: 15,
                        borderSkipped: false,

                    },
                    {
                        label: 'Compras',
                        data: [
                            @this.purchasesWeek[0],
                            @this.purchasesWeek[1],
                            @this.purchasesWeek[2],
                            @this.purchasesWeek[3],
                            @this.purchasesWeek[4],
                            @this.purchasesWeek[5],
                            @this.purchasesWeek[6],
                        ],
                        borderWidth: 2,
                        borderRadius: 15,
                        borderSkipped: false,
                    }
                ]
            },
            options: {
                responsive: true,
                aspectRatio: 4,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    })
</script>

<script>
    document.addEventListener('livewire:load', function() {
        const ctx = document.getElementById('myChart2');

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: [
                    @this.top10Products[0]['producto'],
                    @this.top10Products[1]['producto'],
                    @this.top10Products[2]['producto'],
                    @this.top10Products[3]['producto'],
                    @this.top10Products[4]['producto'],
                ],
                datasets: [{

                        data: [
                            @this.top10Products[0]['cantidad'],
                            @this.top10Products[1]['cantidad'],
                            @this.top10Products[2]['cantidad'],
                            @this.top10Products[3]['cantidad'],
                            @this.top10Products[4]['cantidad'],
                        ],


                    },

                ]
            },
            options: {
                responsive: true,
                aspectRatio: 2,
                plugins: {
                    legend: {
                        position: 'top',
                    },

                }
            },
        });


    })
</script>


<script>
    document.addEventListener('livewire:load', function() {
        const ctx = document.getElementById('myChart4');

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: [
                    @this.top11Products[0]['producto'],
                    @this.top11Products[1]['producto'],
                    @this.top11Products[2]['producto'],
                    @this.top11Products[3]['producto'],
                    @this.top11Products[4]['producto'],
                ],
                datasets: [{

                        data: [
                            @this.top11Products[0]['cantidad'],
                            @this.top11Products[1]['cantidad'],
                            @this.top11Products[2]['cantidad'],
                            @this.top11Products[3]['cantidad'],
                            @this.top11Products[4]['cantidad'],
                        ],


                    },

                ]
            },
            options: {
                responsive: true,
                aspectRatio: 2,
                plugins: {
                    legend: {
                        position: 'top',
                    },

                }
            },
        });


    })
</script>

<script>
    document.addEventListener('livewire:load', function() {
        const ctx = document.getElementById('myChart3');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto',
                    'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
                ],
                datasets: [{
                        label: 'Ventas',
                        data: [
                            @this.salesMonth[0],
                            @this.salesMonth[1],
                            @this.salesMonth[2],
                            @this.salesMonth[3],
                            @this.salesMonth[4],
                            @this.salesMonth[5],
                            @this.salesMonth[6],
                            @this.salesMonth[7],
                            @this.salesMonth[8],
                            @this.salesMonth[9],
                            @this.salesMonth[10],
                            @this.salesMonth[11],
                        ],
                        borderWidth: 2,
                        borderRadius: 15,
                        borderSkipped: false,

                    },
                    {
                        label: 'Compras',
                        data: [
                            @this.purchasesMotnh[0],
                            @this.purchasesMotnh[1],
                            @this.purchasesMotnh[2],
                            @this.purchasesMotnh[3],
                            @this.purchasesMotnh[4],
                            @this.purchasesMotnh[5],
                            @this.purchasesMotnh[6],
                            @this.purchasesMotnh[7],
                            @this.purchasesMotnh[8],
                            @this.purchasesMotnh[9],
                            @this.purchasesMotnh[10],
                            @this.purchasesMotnh[11],
                        ],
                        borderWidth: 2,
                        borderRadius: 15,
                        borderSkipped: false,
                    }
                ]
            },
            options: {
                responsive: true,
                aspectRatio: 3,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    })
</script>


 -->

 