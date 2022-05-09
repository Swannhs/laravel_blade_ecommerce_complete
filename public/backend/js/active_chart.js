/* -------------------------------------------------------------------------- */
/*                                 CRM CHARTS                                 */
/* -------------------------------------------------------------------------- */

(function($) {
    "use strict";
    $(function() {
      Chart.defaults.global.legend.labels.usePointStyle = true;
      
      if ($("#visit-sale-chart").length) {
        Chart.defaults.global.legend.labels.usePointStyle = true;
        var ctx = document.getElementById('visit-sale-chart').getContext("2d");
  
        var gradientStrokeViolet = ctx.createLinearGradient(0, 0, 0, 90);
        gradientStrokeViolet.addColorStop(0, 'rgba(124, 50, 255,1)');
        gradientStrokeViolet.addColorStop(1, 'rgba(199, 56, 216,1)');
        var gradientLegendViolet = 'linear-gradient(to right, rgba(124, 50, 255,1), rgba(199, 56, 216,1))';
        
        var gradientStrokeBlue = ctx.createLinearGradient(0, 0, 0, 90);
        gradientStrokeBlue.addColorStop(0, '#C738D8');
        gradientStrokeBlue.addColorStop(1, ' #D7598F');
        var gradientLegendBlue = 'linear-gradient(90deg, #C738D8 0.47%, #D7598F 100%)';
  
        var gradientStrokeRed = ctx.createLinearGradient(0, 0, 0, 90);
        gradientStrokeRed.addColorStop(0, '#F13D80');
        gradientStrokeRed.addColorStop(1, '#F48464');
        var gradientLegendRed = 'linear-gradient(90deg, #F13D80 0%, #F48464 100%);';
  
        var myChart = new Chart(ctx, {
          type: 'bar',
          data: {
              labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August','September','October','November','December'],
              datasets: [
                {
                  label: "Paid",
                  borderColor: gradientStrokeViolet,
                  backgroundColor: gradientStrokeViolet,
                  hoverBackgroundColor: gradientStrokeViolet,
                  legendColor: gradientLegendViolet,
                  pointRadius: 0,
                  fill: false,
                  borderWidth: 2,
                  fill: 'origin',
                  data: [20, 40, 15, 35, 25, 50, 30, 20,90,10,11,12]
                },
                {
                  label: "Pertially Paid",
                  borderColor: gradientStrokeRed,
                  backgroundColor: gradientStrokeRed,
                  hoverBackgroundColor: gradientStrokeRed,
                  legendColor: gradientLegendRed,
                  pointRadius: 0,
                  fill: false,
                  borderWidth: 2,
                  fill: 'origin',
                  data: [60, 40, 33, 33, 11, 19, 38, 60,70,80,56,32]
                },
                {
                  label: "Expanse",
                  borderColor: gradientStrokeBlue,
                  backgroundColor: gradientStrokeBlue,
                  hoverBackgroundColor: gradientStrokeBlue,
                  legendColor: gradientLegendBlue,
                  pointRadius: 0,
                  fill: false,
                  borderWidth: 2,
                  fill: 'origin',
                  data: [21, 45, 65, 75, 35, 56, 77, 44,22,13,43,49]
                }
            ]
          },
          options: {
            responsive: true,
            legend: false,
            legendCallback: function(chart) {
              var text = []; 
              text.push('<ul>'); 
              for (var i = 0; i < chart.data.datasets.length; i++) { 
                  text.push('<li><span class="legend-dots" style="background:' + 
                             chart.data.datasets[i].legendColor + 
                             '"></span>'); 
                  if (chart.data.datasets[i].label) { 
                      text.push(chart.data.datasets[i].label); 
                  } 
                  text.push('</li>'); 
              } 
              text.push('</ul>'); 
              return text.join('');
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        max: 100, 
                        min: 0, 
                        stepSize: 10
                    },
                    gridLines: {
                        drawBorder: false,
                        color: 'rgba(235,237,242,1)',
                        zeroLineColor: 'rgba(235,237,242,1)'
                      }
                }],
                xAxes: [{
                    // Change here
                    barPercentage: 0.3
                }]
            }
            },
            elements: {
              point: {
                radius: 0
              }
            }
        })
        $("#visit-sale-chart-legend").html(myChart.generateLegend());
      }
    });
  })(jQuery);
  

  (function($) {
    "use strict";
    $(function() {
      Chart.defaults.global.legend.labels.usePointStyle = true;
      
      if ($("#Income_Expanse-chart").length) {
        Chart.defaults.global.legend.labels.usePointStyle = true;
        var ctx = document.getElementById('Income_Expanse-chart').getContext("2d");
  
        var gradientStrokeViolet = ctx.createLinearGradient(0, 0, 0, 90);
        gradientStrokeViolet.addColorStop(0, 'rgba(124, 50, 255,1)');
        gradientStrokeViolet.addColorStop(1, 'rgba(199, 56, 216,1)');
        var gradientLegendViolet = 'linear-gradient(to right, rgba(124, 50, 255,1), rgba(199, 56, 216,1))';
        
        var gradientStrokeBlue = ctx.createLinearGradient(0, 0, 0, 90);
        gradientStrokeBlue.addColorStop(0, '#C738D8');
        gradientStrokeBlue.addColorStop(1, ' #D7598F');
        var gradientLegendBlue = 'linear-gradient(90deg, #C738D8 0.47%, #D7598F 100%)';
  
        var gradientStrokeRed = ctx.createLinearGradient(0, 0, 0, 90);
        gradientStrokeRed.addColorStop(0, '#F13D80');
        gradientStrokeRed.addColorStop(1, '#F48464');
        var gradientLegendRed = 'linear-gradient(90deg, #F13D80 0%, #F48464 100%);';
  
        var myChart = new Chart(ctx, {
          type: 'bar',
          responsive: true,
          data: {
              labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August','September','October','November','December'],
              datasets: [
                {
                  label: "Income",
                  borderColor: gradientStrokeViolet,
                  backgroundColor: gradientStrokeViolet,
                  hoverBackgroundColor: gradientStrokeViolet,
                  legendColor: gradientLegendViolet,
                  pointRadius: 0,
                  fill: false,
                  borderWidth: 2,
                  fill: 'origin',
                  data: [60, 40, 15, 35, 25, 50, 30, 20,90,10,11,12]
                },
                {
                  label: "Expanse",
                  borderColor: gradientStrokeRed,
                  backgroundColor: gradientStrokeRed,
                  hoverBackgroundColor: gradientStrokeRed,
                  legendColor: gradientLegendRed,
                  pointRadius: 0,
                  fill: false,
                  borderWidth: 2,
                  fill: 'origin',
                  data: [20, 25, 33, 33, 11, 19, 38, 60,70,80,56,32]
                },
                // {
                //   label: "Expanse",
                //   borderColor: gradientStrokeBlue,
                //   backgroundColor: gradientStrokeBlue,
                //   hoverBackgroundColor: gradientStrokeBlue,
                //   legendColor: gradientLegendBlue,
                //   pointRadius: 0,
                //   fill: false,
                //   borderWidth: 2,
                //   fill: 'origin',
                //   data: [21, 45, 65, 75, 35, 56, 77, 44,22,13,43,49]
                // }
            ]
          },
          options: {
            responsive: true,
            legend: false,
            legendCallback: function(chart) {
              var text = []; 
              text.push('<ul>'); 
              for (var i = 0; i < chart.data.datasets.length; i++) { 
                  text.push('<li><span class="legend-dots" style="background:' + 
                             chart.data.datasets[i].legendColor + 
                             '"></span>'); 
                  if (chart.data.datasets[i].label) { 
                      text.push(chart.data.datasets[i].label); 
                  } 
                  text.push('</li>'); 
              } 
              text.push('</ul>'); 
              return text.join('');
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        max: 100, 
                        min: 0, 
                        stepSize: 10
                    },
                    gridLines: {
                        drawBorder: false,
                        color: 'rgba(235,237,242,1)',
                        zeroLineColor: 'rgba(235,237,242,1)'
                      }
                }],
                xAxes: [{
                    // Change here
                    barPercentage: 0.4
                }]
            }
            },
            elements: {
              point: {
                radius: 0
              }
            }
        })
        $("#Income_Expanse-chart-legend").html(myChart.generateLegend());
      }
    });
  })(jQuery);
  (function($) {
    "use strict";
    $(function() {
      Chart.defaults.global.legend.labels.usePointStyle = true;
      
      if ($("#showroom_chart1").length) {
        Chart.defaults.global.legend.labels.usePointStyle = true;
        var ctx = document.getElementById('showroom_chart1').getContext("2d");
  
        var gradientStrokeViolet = ctx.createLinearGradient(0, 0, 0, 90);
        gradientStrokeViolet.addColorStop(0, 'rgba(124, 50, 255,1)');
        gradientStrokeViolet.addColorStop(1, 'rgba(199, 56, 216,1)');
        var gradientLegendViolet = 'linear-gradient(to right, rgba(124, 50, 255,1), rgba(199, 56, 216,1))';
        
        var gradientStrokeBlue = ctx.createLinearGradient(0, 0, 0, 90);
        gradientStrokeBlue.addColorStop(0, '#C738D8');
        gradientStrokeBlue.addColorStop(1, ' #D7598F');
        var gradientLegendBlue = 'linear-gradient(90deg, #C738D8 0.47%, #D7598F 100%)';
  
        var gradientStrokeRed = ctx.createLinearGradient(0, 0, 0, 90);
        gradientStrokeRed.addColorStop(0, '#F13D80');
        gradientStrokeRed.addColorStop(1, '#F48464');
        var gradientLegendRed = 'linear-gradient(90deg, #F13D80 0%, #F48464 100%);';
  
        var myChart = new Chart(ctx, {
          type: 'bar',
          responsive: true,
          data: {
              labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August','September','October','November','December'],
              datasets: [
                {
                  label: "Income",
                  borderColor: gradientStrokeViolet,
                  backgroundColor: gradientStrokeViolet,
                  hoverBackgroundColor: gradientStrokeViolet,
                  legendColor: gradientLegendViolet,
                  pointRadius: 0,
                  fill: false,
                  borderWidth: 2,
                  fill: 'origin',
                  data: [60, 40, 15, 35, 25, 50, 30, 20,90,10,11,12]
                },
                {
                  label: "Expanse",
                  borderColor: gradientStrokeRed,
                  backgroundColor: gradientStrokeRed,
                  hoverBackgroundColor: gradientStrokeRed,
                  legendColor: gradientLegendRed,
                  pointRadius: 0,
                  fill: false,
                  borderWidth: 2,
                  fill: 'origin',
                  data: [20, 25, 33, 33, 11, 19, 38, 60,70,80,56,32]
                },
                
            ]
          },
          options: {
            responsive: true,
            legend: false,
            legendCallback: function(chart) {
              var text = []; 
              text.push('<ul>'); 
              for (var i = 0; i < chart.data.datasets.length; i++) { 
                  text.push('<li><span class="legend-dots" style="background:' + 
                             chart.data.datasets[i].legendColor + 
                             '"></span>'); 
                  if (chart.data.datasets[i].label) { 
                      text.push(chart.data.datasets[i].label); 
                  } 
                  text.push('</li>'); 
              } 
              text.push('</ul>'); 
              return text.join('');
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        max: 100, 
                        min: 0, 
                        stepSize: 10
                    },
                    gridLines: {
                        drawBorder: false,
                        color: 'rgba(235,237,242,1)',
                        zeroLineColor: 'rgba(235,237,242,1)'
                      }
                }],
                xAxes: [{
                    // Change here
                    barPercentage: 0.4
                }]
            }
            },
            elements: {
              point: {
                radius: 0
              }
            }
        })
        $("#showroom_chart1-legend").html(myChart.generateLegend());
      }
    });
  })(jQuery);
  (function($) {
    "use strict";
    $(function() {
      Chart.defaults.global.legend.labels.usePointStyle = true;
      
      if ($("#showroom_chart2").length) {
        Chart.defaults.global.legend.labels.usePointStyle = true;
        var ctx = document.getElementById('showroom_chart2').getContext("2d");
  
        var gradientStrokeViolet = ctx.createLinearGradient(0, 0, 0, 90);
        gradientStrokeViolet.addColorStop(0, 'rgba(124, 50, 255,1)');
        gradientStrokeViolet.addColorStop(1, 'rgba(199, 56, 216,1)');
        var gradientLegendViolet = 'linear-gradient(to right, rgba(124, 50, 255,1), rgba(199, 56, 216,1))';
        
        var gradientStrokeBlue = ctx.createLinearGradient(0, 0, 0, 90);
        gradientStrokeBlue.addColorStop(0, '#C738D8');
        gradientStrokeBlue.addColorStop(1, ' #D7598F');
        var gradientLegendBlue = 'linear-gradient(90deg, #C738D8 0.47%, #D7598F 100%)';
  
        var gradientStrokeRed = ctx.createLinearGradient(0, 0, 0, 90);
        gradientStrokeRed.addColorStop(0, '#F13D80');
        gradientStrokeRed.addColorStop(1, '#F48464');
        var gradientLegendRed = 'linear-gradient(90deg, #F13D80 0%, #F48464 100%);';
  
        var myChart = new Chart(ctx, {
          type: 'bar',
          responsive: true,
          data: {
              labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August','September','October','November','December'],
              datasets: [
                {
                  label: "Income",
                  borderColor: gradientStrokeViolet,
                  backgroundColor: gradientStrokeViolet,
                  hoverBackgroundColor: gradientStrokeViolet,
                  legendColor: gradientLegendViolet,
                  pointRadius: 0,
                  fill: false,
                  borderWidth: 2,
                  fill: 'origin',
                  data: [60, 40, 15, 35, 25, 50, 30, 20,90,10,11,12]
                },
                {
                  label: "Expanse",
                  borderColor: gradientStrokeRed,
                  backgroundColor: gradientStrokeRed,
                  hoverBackgroundColor: gradientStrokeRed,
                  legendColor: gradientLegendRed,
                  pointRadius: 0,
                  fill: false,
                  borderWidth: 2,
                  fill: 'origin',
                  data: [20, 25, 33, 33, 11, 19, 38, 60,70,80,56,32]
                }
                
            ]
          },
          options: {
            responsive: true,
            legend: false,
            legendCallback: function(chart) {
              var text = []; 
              text.push('<ul>'); 
              for (var i = 0; i < chart.data.datasets.length; i++) { 
                  text.push('<li><span class="legend-dots" style="background:' + 
                             chart.data.datasets[i].legendColor + 
                             '"></span>'); 
                  if (chart.data.datasets[i].label) { 
                      text.push(chart.data.datasets[i].label); 
                  } 
                  text.push('</li>'); 
              } 
              text.push('</ul>'); 
              return text.join('');
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        max: 100, 
                        min: 0, 
                        stepSize: 10
                    },
                    gridLines: {
                        drawBorder: false,
                        color: 'rgba(235,237,242,1)',
                        zeroLineColor: 'rgba(235,237,242,1)'
                      }
                }],
                xAxes: [{
                    // Change here
                    barPercentage: 0.4
                }]
            }
            },
            elements: {
              point: {
                radius: 0
              }
            }
        })
        $("#showroom_chart2-legend").html(myChart.generateLegend());
      }
    });
  })(jQuery);
  (function($) {
    "use strict";
    $(function() {
      Chart.defaults.global.legend.labels.usePointStyle = true;
      
      if ($("#leads-chart").length) {
        Chart.defaults.global.legend.labels.usePointStyle = true;
        var ctx = document.getElementById('leads-chart').getContext("2d");
  
        var gradientStrokeViolet = ctx.createLinearGradient(0, 0, 0, 90);
        gradientStrokeViolet.addColorStop(0, 'rgba(124, 50, 255,1)');
        gradientStrokeViolet.addColorStop(1, 'rgba(199, 56, 216,1)');
        var gradientLegendViolet = 'linear-gradient(to right, rgba(124, 50, 255,1), rgba(199, 56, 216,1))';
        
        var gradientStrokeBlue = ctx.createLinearGradient(0, 0, 0, 90);
        gradientStrokeBlue.addColorStop(0, '#C738D8');
        gradientStrokeBlue.addColorStop(1, ' #D7598F');
        var gradientLegendBlue = 'linear-gradient(90deg, #C738D8 0.47%, #D7598F 100%)';
  
        var gradientStrokeRed = ctx.createLinearGradient(0, 0, 0, 90);
        gradientStrokeRed.addColorStop(0, '#F13D80');
        gradientStrokeRed.addColorStop(1, '#F48464');
        var gradientLegendRed = 'linear-gradient(90deg, #F13D80 0%, #F48464 100%);';
  
        var myChart = new Chart(ctx, {
          type: 'bar',
          data: {
              labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August','September','October','November','December'],
              datasets: [
                {
                  label: "Generated",
                  borderColor: gradientStrokeRed,
                  backgroundColor: gradientStrokeRed,
                  hoverBackgroundColor: gradientStrokeRed,
                  legendColor: gradientLegendRed,
                  pointRadius: 0,
                  fill: false,
                  borderWidth: 2,
                  fill: 'origin',
                  data: [60, 75, 63, 33, 71, 19, 38, 60,70,80,56,32]
                },
                {
                  label: "Converted",
                  borderColor: gradientStrokeViolet,
                  backgroundColor: gradientStrokeViolet,
                  hoverBackgroundColor: gradientStrokeViolet,
                  legendColor: gradientLegendViolet,
                  pointRadius: 0,
                  fill: false,
                  borderWidth: 2,
                  fill: 'origin',
                  data: [30, 40, 15, 35, 25, 50, 30, 20,90,10,11,12]
                }

                
            ]
          },
          options: {
            responsive: true,
            legend: false,
            legendCallback: function(chart) {
              var text = []; 
              text.push('<ul>'); 
              for (var i = 0; i < chart.data.datasets.length; i++) { 
                  text.push('<li><span class="legend-dots" style="background:' + 
                             chart.data.datasets[i].legendColor + 
                             '"></span>'); 
                  if (chart.data.datasets[i].label) { 
                      text.push(chart.data.datasets[i].label); 
                  } 
                  text.push('</li>'); 
              } 
              text.push('</ul>'); 
              return text.join('');
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        max: 100, 
                        min: 0, 
                        stepSize: 10
                    },
                    gridLines: {
                        drawBorder: false,
                        color: 'rgba(235,237,242,1)',
                        zeroLineColor: 'rgba(235,237,242,1)'
                      },
                }],
                xAxes: [{
                    // Change here
                    barPercentage: 0.4
                }]
            }
            },
            elements: {
              point: {
                radius: 0
              }
            }
        })
        $("#leads-chart-legend").html(myChart.generateLegend());
      }
    });
  })(jQuery);



  (function($) {
    "use strict";
    $(function() {
      Chart.defaults.global.legend.labels.usePointStyle = true;
      
      if ($("#Project_Statistics-chart").length) {
        Chart.defaults.global.legend.labels.usePointStyle = true;
        var ctx = document.getElementById('Project_Statistics-chart').getContext("2d");
  
        var gradientStrokeViolet = ctx.createLinearGradient(0, 0, 0, 90);
        gradientStrokeViolet.addColorStop(0, 'rgba(124, 50, 255,1)');
        gradientStrokeViolet.addColorStop(1, 'rgba(199, 56, 216,1)');
        var gradientLegendViolet = 'linear-gradient(to right, rgba(124, 50, 255,1), rgba(199, 56, 216,1))';
        
        var gradientStrokeBlue = ctx.createLinearGradient(0, 0, 0, 90);
        gradientStrokeBlue.addColorStop(0, '#C738D8');
        gradientStrokeBlue.addColorStop(1, ' #D7598F');
        var gradientLegendBlue = 'linear-gradient(90deg, #C738D8 0.47%, #D7598F 100%)';
  
        var gradientStrokeRed = ctx.createLinearGradient(0, 0, 0, 90);
        gradientStrokeRed.addColorStop(0, '#F13D80');
        gradientStrokeRed.addColorStop(1, '#F48464');
        var gradientLegendRed = 'linear-gradient(90deg, #F13D80 0%, #F48464 100%);';
  
        var myChart = new Chart(ctx, {
          type: 'bar',
          data: {
              labels: ['01', '02', '03', '04', '05', '06', '07', '08','09','11','12','13'],
              datasets: [
                {
                  label: "Task Completed this month",
                  borderColor: gradientStrokeViolet,
                  backgroundColor: gradientStrokeViolet,
                  hoverBackgroundColor: gradientStrokeViolet,
                  legendColor: gradientLegendViolet,
                  pointRadius: 0,
                  fill: false,
                  borderWidth: 2,
                  fill: 'origin',
                  data: [60, 40, 15, 35, 25, 50, 30, 20,90,10,11,12]
                },
                {
                  label: "Expanse",
                  borderColor: gradientStrokeRed,
                  backgroundColor: gradientStrokeRed,
                  hoverBackgroundColor: gradientStrokeRed,
                  legendColor: gradientLegendRed,
                  pointRadius: 0,
                  fill: false,
                  borderWidth: 2,
                  fill: 'origin',
                  data: [20, 25, 33, 33, 11, 19, 38, 60,70,80,56,32]
                },
                
            ]
          },
          options: {
            responsive: true,
            legend: false,
            legendCallback: function(chart) {
              var text = []; 
              text.push('<ul>'); 
              for (var i = 0; i < 1; i++) { 
                  text.push('<li><span class="legend-dots" style="background:' + 
                             chart.data.datasets[i].legendColor + 
                             '"></span>'); 
                  if (chart.data.datasets[i].label) { 
                      text.push(chart.data.datasets[i].label); 
                  } 
                  text.push('</li>'); 
              } 
              text.push('</ul>'); 
              return text.join('');
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        max: 100, 
                        min: 0, 
                        stepSize: 10
                    },
                    gridLines: {
                        drawBorder: false,
                        color: 'rgba(235,237,242,1)',
                        zeroLineColor: 'rgba(235,237,242,1)'
                      }
                }],
                xAxes: [{
                    // Change here
                    barPercentage: 0.4
                }]
            }
            },
            elements: {
              point: {
                radius: 0
              }
            }
        })
        $("#Project_Statistics-chart-legend").html(myChart.generateLegend());
      }
    });
  })(jQuery);

  
/* -------------------------------------------------------------------------- */
/*                                  PM CHARTS                                 */
/* -------------------------------------------------------------------------- */
if($('#line_chart').length > 0){
  const monthNames = ["", "Jan", "Feb", "Mar", "Apr", "May", "Jun",
  "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
  ];
  Morris.Area({
  element: 'line_chart',
  data: [
      {y: 1, a: 30},
      {y: 2, a: 50},
      {y: 3, a: 30},
      {y: 4, a: 35},
      {y: 5, a: 45},
      {y: 6, a: 50},
      {y: 7, a: 30},
      {y: 8, a: 20},
      {y: 9, a: 40},
      {y: 10, a: 30},
      {y:11, a: 40},
      {y: 12, a: 60}
  ],
  xkey: 'y',
  parseTime: false,
  ykeys: ['a'],
  xLabelFormat: function (x) {
      var index = parseInt(x.src.y);
      return monthNames[index];
  },
  xLabels: "month",
  labels: ['Series A'],
  lineColors: ['#7C32FF', '#7C32FF'],
  hideHover: 'auto',
  pointSize: 0,
  pointFillColors: ['#ffffff'],
  pointStrokeColors:['#7C32FF'],
  lineWidth: 3,
  fillOpacity: 0.5,
  smooth:false
  });
}
// pie 
if($('#traffic-chart').length > 0){
(function($) {
  "use strict";
  $(function() {

    Chart.defaults.global.legend.labels.usePointStyle = true;
    var ctx = document.getElementById('traffic-chart').getContext("2d");
    if ($("#traffic-chart").length) {      

      var trafficChartData = {
        datasets: [{
          data: [18236, 9083, 6738],
          backgroundColor: [
            "#4BCF90",
            "#FF6D68",
            "#FFAD1F"
          ],
          hoverBackgroundColor: [
            "#4BCF90",
            "#FF6D68",
            "#FFAD1F"
          ],
          borderColor: [
            "transparent",
            "transparent",
            "transparent"
          ],
          legendColor: [
            "#4BCF90",
            "#FF6D68",
            "#FFAD1F"
          ]
        }],
    
        // These labels appear in the legend and in the tooltips when hovering different arcs
        labels: [
          'Dhanmondi',
          'Gulshan',
          'Mirpur',
        ]
      };
      
      var trafficChartOptions = {
        responsive: true,
        cutoutPercentage: 65,
        animation: {
          animateScale: true,
          animateRotate: true
        },
        legend: false,
        legendCallback: function(chart) {
          var text = []; 
          text.push('<ul>'); 
          for (var i = 0; i < trafficChartData.datasets[0].data.length; i++) { 
              text.push('<li><span class="legend-dots" style="background:' + 
              trafficChartData.datasets[0].legendColor[i] + 
                          '"></span><div class="legend_name"><span>'); 
              if (trafficChartData.labels[i]) { 
                  text.push(trafficChartData.labels[i]); 
              }
              text.push('</span><span class="value_legend">'+"$"+trafficChartData.datasets[0].data[i]+'</span>')
              text.push('</div></li>'); 
          } 
          text.push('</ul>'); 
          return text.join('');
        }
      };
      var trafficChartCanvas = $("#traffic-chart").get(0).getContext("2d");
      var trafficChart = new Chart(trafficChartCanvas, {
        type: 'doughnut',
        data: trafficChartData,
        options: trafficChartOptions
      });
      $("#traffic-chart-legend").html(trafficChart.generateLegend());      
    }
  });
})(jQuery);
}

// analitic chart 
if($('#analitic-chart').length > 0){
  (function($) {
    "use strict";
    $(function() {
  
      Chart.defaults.global.legend.labels.usePointStyle = true;
      var ctx = document.getElementById('analitic-chart').getContext("2d");
      if ($("#analitic-chart").length) {      
  
        var trafficChartData = {
          datasets: [{
            data: [18236, 9083, 6738],
            backgroundColor: [
              "#4BCF90",
              "#FF6D68",
              "#FFAD1F"
            ],
            hoverBackgroundColor: [
              "#4BCF90",
              "#FF6D68",
              "#FFAD1F"
            ],
            borderColor: [
              "transparent",
              "transparent",
              "transparent"
            ],
            legendColor: [
              "#4BCF90",
              "#FF6D68",
              "#FFAD1F"
            ]
          }],
      
          // These labels appear in the legend and in the tooltips when hovering different arcs
          labels: [
            'Dhanmondi',
            'Gulshan',
            'Mirpur',
          ]
        };
        
        var trafficChartOptions = {
          responsive: true,
          cutoutPercentage: 65,
          animation: {
            animateScale: true,
            animateRotate: true
          },
          legend: false,
          legendCallback: function(chart) {
            var text = []; 
            text.push('<ul>'); 
            for (var i = 0; i < trafficChartData.datasets[0].data.length; i++) { 
                text.push('<li><span class="legend-dots" style="background:' + 
                trafficChartData.datasets[0].legendColor[i] + 
                            '"></span><div class="legend_name"><span>'); 
                if (trafficChartData.labels[i]) { 
                    text.push(trafficChartData.labels[i]); 
                }
                text.push('</span><span class="value_legend">'+"$"+trafficChartData.datasets[0].data[i]+'</span>')
                text.push('</div></li>'); 
            } 
            text.push('</ul>'); 
            return text.join('');
          }
        };
        var trafficChartCanvas = $("#analitic-chart").get(0).getContext("2d");
        var trafficChart = new Chart(trafficChartCanvas, {
          type: 'doughnut',
          data: trafficChartData,
          options: trafficChartOptions
        });
        $("#analitic-chart-legend").html(trafficChart.generateLegend());      
      }
    });
  })(jQuery);
  }
if($('#brand-chart').length > 0){
  (function($) {
    "use strict";
    $(function() {
  
      Chart.defaults.global.legend.labels.usePointStyle = true;
      var ctx = document.getElementById('brand-chart').getContext("2d");
      if ($("#brand-chart").length) {      
  
        var trafficChartData = {
          datasets: [{
            data: [18236, 9083, 6738],
            backgroundColor: [
              "#4BCF90",
              "#FF6D68",
              "#FFAD1F"
            ],
            hoverBackgroundColor: [
              "#4BCF90",
              "#FF6D68",
              "#FFAD1F"
            ],
            borderColor: [
              "transparent",
              "transparent",
              "transparent"
            ],
            legendColor: [
              "#4BCF90",
              "#FF6D68",
              "#FFAD1F"
            ]
          }],
      
          // These labels appear in the legend and in the tooltips when hovering different arcs
          labels: [
            'Dell',
            'Asus',
            'Hp',
          ]
        };
        
        var trafficChartOptions = {
          responsive: true,
          cutoutPercentage: 65,
          animation: {
            animateScale: true,
            animateRotate: true
          },
          legend: false,
          legendCallback: function(chart) {
            var text = []; 
            text.push('<ul>'); 
            for (var i = 0; i < trafficChartData.datasets[0].data.length; i++) { 
                text.push('<li><span class="legend-dots" style="background:' + 
                trafficChartData.datasets[0].legendColor[i] + 
                            '"></span><div class="legend_name"><span>'); 
                if (trafficChartData.labels[i]) { 
                    text.push(trafficChartData.labels[i]); 
                }
                text.push('</span><span class="value_legend">'+"$"+trafficChartData.datasets[0].data[i]+'</span>')
                text.push('</div></li>'); 
            } 
            text.push('</ul>'); 
            return text.join('');
          }
        };
        var trafficChartCanvas = $("#brand-chart").get(0).getContext("2d");
        var trafficChart = new Chart(trafficChartCanvas, {
          type: 'doughnut',
          data: trafficChartData,
          options: trafficChartOptions
        });
        $("#brand-chart-legend").html(trafficChart.generateLegend());      
      }
    });
  })(jQuery);
  }
if($('#Supplier-chart').length > 0){
  (function($) {
    "use strict";
    $(function() {
  
      Chart.defaults.global.legend.labels.usePointStyle = true;
      var ctx = document.getElementById('Supplier-chart').getContext("2d");
      if ($("#Supplier-chart").length) {      
  
        var trafficChartData = {
          datasets: [{
            data: [18236, 9083, 6738],
            backgroundColor: [
              "#4BCF90",
              "#FF6D68",
              "#FFAD1F"
            ],
            hoverBackgroundColor: [
              "#4BCF90",
              "#FF6D68",
              "#FFAD1F"
            ],
            borderColor: [
              "transparent",
              "transparent",
              "transparent"
            ],
            legendColor: [
              "#4BCF90",
              "#FF6D68",
              "#FFAD1F"
            ]
          }],
      
          // These labels appear in the legend and in the tooltips when hovering different arcs
          labels: [
            'Supplier Name',
            'Supplier Name',
            'Supplier Name',
          ]
        };
        
        var trafficChartOptions = {
          responsive: true,
          cutoutPercentage: 65,
          animation: {
            animateScale: true,
            animateRotate: true
          },
          legend: false,
          legendCallback: function(chart) {
            var text = []; 
            text.push('<ul>'); 
            for (var i = 0; i < trafficChartData.datasets[0].data.length; i++) { 
                text.push('<li><span class="legend-dots" style="background:' + 
                trafficChartData.datasets[0].legendColor[i] + 
                            '"></span><div class="legend_name"><span>'); 
                if (trafficChartData.labels[i]) { 
                    text.push(trafficChartData.labels[i]); 
                }
                text.push('</span><span class="value_legend">'+"$"+trafficChartData.datasets[0].data[i]+'</span>')
                text.push('</div></li>'); 
            } 
            text.push('</ul>'); 
            return text.join('');
          }
        };
        var trafficChartCanvas = $("#Supplier-chart").get(0).getContext("2d");
        var trafficChart = new Chart(trafficChartCanvas, {
          type: 'doughnut',
          data: trafficChartData,
          options: trafficChartOptions
        });
        $("#Supplier-chart-legend").html(trafficChart.generateLegend());      
      }
    });
  })(jQuery);
  }