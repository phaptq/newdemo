var miniChartBarOptions = {
                type: 'bar',
                barWidth: 6,
                barSpacing: 5,
                height: '50px',
                tooltipOffsetX: -25,
                tooltipOffsetY: 20,
                barColor: '#9b59b6',
                tooltipPrefix: '',
                tooltipSuffix: ' Projects',
                tooltipFormat: '{{prefix}}{{value}}{{suffix}}'
            };
$('#mini-chart-bar1').sparkline([10,8,5,7,4,4,1], miniChartBarOptions);

miniChartBarOptions['barColor'] = '#2ecc71';
miniChartBarOptions['tooltipPrefix'] = '$ ';
miniChartBarOptions['tooltipSuffix'] = '';
$('#mini-chart-bar2').sparkline('html', miniChartBarOptions);

miniChartBarOptions['barColor'] = '#1bbae1';
miniChartBarOptions['tooltipPrefix'] = '';
miniChartBarOptions['tooltipSuffix'] = ' Updates';
$('#mini-chart-bar3').sparkline('html', miniChartBarOptions);