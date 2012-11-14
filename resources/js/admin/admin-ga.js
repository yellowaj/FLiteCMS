(function() {   

var base = '/ranch/',
    baseUrl = base + 'admin/';


/* =============================================================================
   google analytics dashboard data
   ========================================================================== */

var initChart = function(data) {
	new Highcharts.Chart({
		chart: {
			renderTo: "ga-container",
			type: "line",
			marginRight: 45,
			marginLeft: 50,
			height: 300
		},
		title: {
			text: "Site Traffic",
			margin: 45
		},
		xAxis: {
			type: "datetime",
			dateTimeLabelFormats: {
				day: "%b %e"
			},
			tickInterval: 48 * 3600 * 1000
		},
		yAxis: {
			min: 0,
			title: {
				text: ""
			}
		},
		plotOptions: {
            series: {
                pointStart: Date.UTC(data.firstDate.year, data.firstDate.month, data.firstDate.day),
				        pointInterval: 24 * 3600 * 1000 // one day
            }
        },
		series: [{
			name: "Total Visits",
			data: data.visits
		}, { 
			name: "Visitors",
			data: data.visitors
		}]
	});
}; // end initChart

$('#ga-container').append('<div class="ga-loading"><img src="'+ base +'resources/img/admin/ajax-loader.gif"> loading...</div>');
$.ajax({
	type: 'GET',
	url: baseUrl + 'admin/analytics_data',
	success: function(res) {
		var data = JSON.parse(res);
		if(data.success) {
			$('#ga-container .ga-loading').hide();
			initChart(data);
		} else {
			if(data.message == 'oAuth') {
				$('#ga-container .ga-loading').html(data.oauthUrl);
			} else {
				$('#ga-container .ga-loading').html('<div class="alert">'+data.message+'</div>');
			}
		}
	},
	error: function(res) {
		alert('Error connecting to server');
	}
});


})(); // end