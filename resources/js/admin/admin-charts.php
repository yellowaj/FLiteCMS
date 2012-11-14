chart1 = new Highcharts.Chart({
 chart: {
    renderTo: 'ga-container',
    type: 'line',
    marginRight: 45
 },
 title: {
    text: 'Site Visits'
 },
 xAxis: {
 	title: {
 		text: 'Date'
 	},
    type: 'datetime',
    tickInterval: 24 * 3600 * 1000
 },
 yAxis: {
    title: {
       text: 'Visits'
    },
    min: 0
 },
 series: [{
    showInLegend: false,
    data: [<?php echo '1, 2, 3'; ?>],
    pointStart: Date.UTC(2012, 4, 5),
    pointInterval: 24 * 3600 * 1000 // one day
 }]
});