
<script>
    // Data retrieved from https://fas.org/issues/nuclear-weapons/status-world-nuclear-forces/
Highcharts.chart('grafico1', {
    chart: {
        type: 'area'
    },
    accessibility: {
        description: 'Image description: An area chart compares the nuclear stockpiles of the USA and the USSR/Russia between 1945 and 2017. The number of nuclear weapons is plotted on the Y-axis and the years on the X-axis. The chart is interactive, and the year-on-year stockpile levels can be traced for each country. The US has a stockpile of 6 nuclear weapons at the dawn of the nuclear age in 1945. This number has gradually increased to 369 by 1950 when the USSR enters the arms race with 6 weapons. At this point, the US starts to rapidly build its stockpile culminating in 32,040 warheads by 1966 compared to the USSR’s 7,089. From this peak in 1966, the US stockpile gradually decreases as the USSR’s stockpile expands. By 1978 the USSR has closed the nuclear gap at 25,393. The USSR stockpile continues to grow until it reaches a peak of 45,000 in 1986 compared to the US arsenal of 24,401. From 1986, the nuclear stockpiles of both countries start to fall. By 2000, the numbers have fallen to 10,577 and 21,000 for the US and Russia, respectively. The decreases continue until 2017 at which point the US holds 4,018 weapons compared to Russia’s 4,500.'
    },
    title: {
        text: 'US and USSR nuclear stockpiles'
    },
    subtitle: {
        text: 'Source: <a href="https://fas.org/issues/nuclear-weapons/status-world-nuclear-forces/" ' +
            'target="_blank">FAS</a>'
    },
    xAxis: {
        allowDecimals: false,
        accessibility: {
            rangeDescription: 'Range: 1940 to 2017.'
        }
    },
    yAxis: {
        title: {
            text: 'Nuclear weapon states'
        }
    },
    tooltip: {
        pointFormat: '{series.name} had stockpiled <b>{point.y:,.0f}</b><br/>warheads in {point.x}'
    },
    plotOptions: {
        area: {
            pointStart: 1940,
            marker: {
                enabled: false,
                symbol: 'circle',
                radius: 2,
                states: {
                    hover: {
                        enabled: true
                    }
                }
            }
        }
    },
    series: [{
        name: 'USA',
        data: [
            null, null, null, null, null, 2, 9, 13, 50, 170, 299, 438, 841,
            1169, 1703, 2422, 3692, 5543, 7345, 12298, 18638, 22229, 25540,
            28133, 29463, 31139, 31175, 31255, 29561, 27552, 26008, 25830,
            26516, 27835, 28537, 27519, 25914, 25542, 24418, 24138, 24104,
            23208, 22886, 23305, 23459, 23368, 23317, 23575, 23205, 22217,
            21392, 19008, 13708, 11511, 10979, 10904, 11011, 10903, 10732,
            10685, 10577, 10526, 10457, 10027, 8570, 8360, 7853, 5709, 5273,
            5113, 5066, 4897, 4881, 4804, 4717, 4571, 4018, 3822, 3785, 3805,
            3750, 3708, 3708
        ]
    }, {
        name: 'USSR/Russia',
        data: [null, null, null, null, null, null, null, null, null,
            1, 5, 25, 50, 120, 150, 200, 426, 660, 863, 1048, 1627, 2492,
            3346, 4259, 5242, 6144, 7091, 8400, 9490, 10671, 11736, 13279,
            14600, 15878, 17286, 19235, 22165, 24281, 26169, 28258, 30665,
            32146, 33486, 35130, 36825, 38582, 40159, 38107, 36538, 35078,
            32980, 29154, 26734, 24403, 21339, 18179, 15942, 15442, 14368,
            13188, 12188, 11152, 10114, 9076, 8038, 7000, 6643, 6286, 5929,
            5527, 5215, 4858, 4750, 4650, 4600, 4500, 4490, 4300, 4350, 4330,
            4310, 4495, 4477
        ]
    }]
});

   // Data retrieved from https://fas.org/issues/nuclear-weapons/status-world-nuclear-forces/
Highcharts.chart('grafico1', {
    chart: {
        type: 'area'
    },
    accessibility: {
        description: 'Image description: An area chart compares the nuclear stockpiles of the USA and the USSR/Russia between 1945 and 2017. The number of nuclear weapons is plotted on the Y-axis and the years on the X-axis. The chart is interactive, and the year-on-year stockpile levels can be traced for each country. The US has a stockpile of 6 nuclear weapons at the dawn of the nuclear age in 1945. This number has gradually increased to 369 by 1950 when the USSR enters the arms race with 6 weapons. At this point, the US starts to rapidly build its stockpile culminating in 32,040 warheads by 1966 compared to the USSR’s 7,089. From this peak in 1966, the US stockpile gradually decreases as the USSR’s stockpile expands. By 1978 the USSR has closed the nuclear gap at 25,393. The USSR stockpile continues to grow until it reaches a peak of 45,000 in 1986 compared to the US arsenal of 24,401. From 1986, the nuclear stockpiles of both countries start to fall. By 2000, the numbers have fallen to 10,577 and 21,000 for the US and Russia, respectively. The decreases continue until 2017 at which point the US holds 4,018 weapons compared to Russia’s 4,500.'
    },
    title: {
        text: 'US and USSR nuclear stockpiles'
    },
    subtitle: {
        text: 'Source: <a href="https://fas.org/issues/nuclear-weapons/status-world-nuclear-forces/" ' +
            'target="_blank">FAS</a>'
    },
    xAxis: {
        allowDecimals: false,
        accessibility: {
            rangeDescription: 'Range: 1940 to 2017.'
        }
    },
    yAxis: {
        title: {
            text: 'Nuclear weapon states'
        }
    },
    tooltip: {
        pointFormat: '{series.name} had stockpiled <b>{point.y:,.0f}</b><br/>warheads in {point.x}'
    },
    plotOptions: {
        area: {
            pointStart: 1940,
            marker: {
                enabled: false,
                symbol: 'circle',
                radius: 2,
                states: {
                    hover: {
                        enabled: true
                    }
                }
            }
        }
    },
    series: [{
        name: 'USA',
        data: [
            null, null, null, null, null, 2, 9, 13, 50, 170, 299, 438, 841,
            1169, 1703, 2422, 3692, 5543, 7345, 12298, 18638, 22229, 25540,
            28133, 29463, 31139, 31175, 31255, 29561, 27552, 26008, 25830,
            26516, 27835, 28537, 27519, 25914, 25542, 24418, 24138, 24104,
            23208, 22886, 23305, 23459, 23368, 23317, 23575, 23205, 22217,
            21392, 19008, 13708, 11511, 10979, 10904, 11011, 10903, 10732,
            10685, 10577, 10526, 10457, 10027, 8570, 8360, 7853, 5709, 5273,
            5113, 5066, 4897, 4881, 4804, 4717, 4571, 4018, 3822, 3785, 3805,
            3750, 3708, 3708
        ]
    }, {
        name: 'USSR/Russia',
        data: [null, null, null, null, null, null, null, null, null,
            1, 5, 25, 50, 120, 150, 200, 426, 660, 863, 1048, 1627, 2492,
            3346, 4259, 5242, 6144, 7091, 8400, 9490, 10671, 11736, 13279,
            14600, 15878, 17286, 19235, 22165, 24281, 26169, 28258, 30665,
            32146, 33486, 35130, 36825, 38582, 40159, 38107, 36538, 35078,
            32980, 29154, 26734, 24403, 21339, 18179, 15942, 15442, 14368,
            13188, 12188, 11152, 10114, 9076, 8038, 7000, 6643, 6286, 5929,
            5527, 5215, 4858, 4750, 4650, 4600, 4500, 4490, 4300, 4350, 4330,
            4310, 4495, 4477
        ]
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

 