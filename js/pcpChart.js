App.PrecipitationChart = (function() {		
	var Precipitation = {
		chart: {
			renderTo: 'chartRegion',
			type: 'line'
		},
		title: {
			text: 'Precipitation'                 
		},
		subtitle: {
			text: ''
		},
		xAxis: {
			categories: [],
			title: {
				text: 'Time'
			}
		},
		yAxis: {
			title: {
				text: 'Precipitation'
			}
		},
		series: [
		{showInLegend: false}
		]
	};
	
	var data = [];
	var time = [];
	var max_value;
	var startValue = 0;
	var endValue = 0;
	var chartType = Precipitation;
	
	
	//************************
	//************************
	//put the json data here
	//************************
	//************************
	this.start = function(json) {
		$.each(json, function(key, value) {
			data.push(value.PCP);
			time.push(value.YEARMONTH);	
		});
		max_value = parseInt(time.length);
		chartType.series[0].data = data;
		chartType.xAxis.categories = time;
		var chart = new Highcharts.Chart(chartType); 
		
		$( "#slider1" ).slider({
			min: 2,
			max: max_value,
			animate: "fast",
			slide: function(event, ui) {
				startValue = ui.value;
				newStartData = data.slice(endValue, ui.value);
				newStartTime = time.slice(endValue, ui.value);
				chartType.series[0].data  = newStartData;
				chartType.xAxis.categories = newStartTime;
				var chart = new Highcharts.Chart(chartType);
			}
		});
		
		$( "#slider2" ).slider({
			min: 2,
			max: max_value,
			animate: "fast",
			slide: function(event, ui) {
				endValue = ui.value;
				newEndData = data.slice(ui.value, startValue);
				newEndTime = time.slice(ui.value, startValue);
				chartType.series[0].data  = newEndData;
				chartType.xAxis.categories = newEndTime;
				var chart = new Highcharts.Chart(chartType);
			}
		});
	};	
});