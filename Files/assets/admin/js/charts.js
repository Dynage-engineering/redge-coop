// doughnut
function piChart(element, labels, data) {

     var myChart = new Chart(element, {
          type: 'doughnut',
          data: {
               labels: labels,
               datasets: [{
                    data: data,
                    backgroundColor: [
                         '#ff7675',
                         '#6c5ce7',
                         '#ffa62b',
                         '#ffeaa7',
                         '#D980FA',
                         '#fccbcb',
                         '#45aaf2',
                         '#05dfd7',
                         '#FF00F6',
                         '#1e90ff',
                         '#2ed573',
                         '#eccc68',
                         '#ff5200',
                         '#cd84f1',
                         '#7efff5',
                         '#7158e2',
                         '#fff200',
                         '#ff9ff3',
                         '#08ffc8',
                         '#3742fa',
                         '#1089ff',
                         '#70FF61',
                         '#bf9fee',
                         '#574b90'
                    ],
                    borderColor: [
                         'rgba(231, 80, 90, 0.75)'
                    ],
                    borderWidth: 0,

               }]
          },
          options: {
               aspectRatio: 1,
               responsive: true,
               maintainAspectRatio: true,
               elements: {
                    line: {
                         tension: 0 // disables bezier curves
                    }
               },
               scales: {
                    xAxes: [{
                         display: false
                    }],
                    yAxes: [{
                         display: false
                    }]
               },
               legend: {
                    display: false,
               }
          }
     });
}

function barChart(element, currency, series, categories, height = 450) {

     let options = {
          series: series,
          chart: {
               type: 'bar',
               height: height,
               toolbar: {
                    show: false
               }
          },
          plotOptions: {
               bar: {
                    horizontal: false,
                    columnWidth: '50%',
                    endingShape: 'rounded'
               },
          },
          dataLabels: {
               enabled: false
          },
          stroke: {
               show: true,
               width: 2,
               colors: ['transparent']
          },
          xaxis: {
               categories: categories,
          },
          yaxis: {
               title: {
                    text: currency,
                    style: {
                         color: '#7c97bb'
                    }
               }
          },
          grid: {
               xaxis: {
                    lines: {
                         show: false
                    }
               },
               yaxis: {
                    lines: {
                         show: false
                    }
               },
          },
          fill: {
               opacity: 1
          },
          tooltip: {
               y: {
                    formatter: function (val) {
                         return currency + val + " "
                    }
               }
          }
     };

     let chart = new ApexCharts(element, options);
     chart.render();
}

function lineChart(element, series, categories, height = 450) {
     var options = {
          chart: {
               height: height,
               type: "area",
               toolbar: {
                    show: false
               },
               dropShadow: {
                    enabled: true,
                    enabledSeries: [0],
                    top: -2,
                    left: 0,
                    blur: 10,
                    opacity: 0.08
               },
               animations: {
                    enabled: true,
                    easing: 'linear',
                    dynamicAnimation: {
                         speed: 1000
                    }
               },
          },
          dataLabels: {
               enabled: false
          },
          series: series,
          fill: {
               type: "gradient",
               gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.7,
                    opacityTo: 0.9,
                    stops: [0, 90, 100]
               }
          },
          xaxis: {
               categories: categories
          },
          grid: {
               padding: {
                    left: 5,
                    right: 5
               },
               xaxis: {
                    lines: {
                         show: false
                    }
               },
               yaxis: {
                    lines: {
                         show: false
                    }
               },
          },
     };

     var chart = new ApexCharts(element, options);

     chart.render();
}