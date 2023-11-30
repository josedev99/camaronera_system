<script>
  Highcharts.chart('grafico1', {
    chart: {
        type: 'column' // Cambiar el tipo de gráfico a columnas (barras)
    },
    title: {
        text: 'Compras por mes'
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
    chart: {
        type: 'pie'
    },
    title: {
        text: 'Distribución de ventas mensuales'
    },
    subtitle: {
        text: 'Fuente: Tu fuente aquí'
    },
    tooltip: {
        pointFormat: '<b>{point.name}:</b> {point.y} ventas'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}:</b> {point.y} ventas'
            }
        }
    },
    series: [{
        name: 'Ventas',
        colorByPoint: true,
        data: {!! json_encode($ventasMensuales->map(function($venta) { 
            $nombreMes = \Carbon\Carbon::create()->month($venta->mes)->locale('es_ES')->monthName;
            return ['name' => $nombreMes, 'y' => $venta->total];
        })) !!}
    }]
});


Highcharts.chart('grafico3', {
    chart: {
        type: 'bar'
    },
    title: {
        text: 'Distribución de tipos de pago',
        align: 'left'
    },
    subtitle: {
        text: 'Tipo de pagos',
        align: 'left'
    },
    xAxis: {
        categories: {!! json_encode($TipoPagoDeCompraFrecuente) !!}.map(item => item.name),
        title: {
            text: null
        },
        gridLineWidth: 1,
        lineWidth: 0,
        labels: {
            formatter: function() {
                // Mapear números a etiquetas específicas
                switch (this.value) {
                    case 0:
                        return 'Efectivo';
                    case 1:
                        return 'Cheque';
                    case 2:
                        return 'Transferencia';
                    case 3:
                        return 'Otro';
                    default:
                        return 'Desconocido';
                }
            }
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Cantidad',
            align: 'high'
        },
        labels: {
            overflow: 'justify',
            formatter: function () {
                return this.value.toFixed(0); // Redondear y mostrar como entero
            }
        },
        gridLineWidth: 0
    },
    tooltip: {
        valueSuffix: ''
    },
    plotOptions: {
        bar: {
            borderRadius: 0, // Sin redondeo en las barras
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
        backgroundColor: Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',
        shadow: true
    },
    credits: {
        enabled: false
    },
    series: [{
        name: 'Cantidad de Pagos',
        color: 'orange',
        data: {!! json_encode($TipoPagoDeCompraFrecuente) !!}.map(item => item.y),
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

 