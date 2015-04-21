$App.DataBox = (function() {					
	var CHDays = {
		chart: {
			renderTo: 'container',
			type: 'column'
		},
		title: {
			text: 'Cooling Days/Heating Days'                 
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
				text: 'Days'
			}
		},
		 plotOptions: {
			column: {
				stacking: 'normal'
				}
		},
		series: [{
			"type": "column",
			"name": "CD",
			"color": "#d92b00",
			"stack": true
			}, {
				"type": "column",
					"name": "HD",
					"color": "#51626d",
					"stack": true
			}
		]
	};
			
	var dataCDD = [];
	var dataHDD = [];
	var time = [];
	var max_value;
	var startValue = 0;
	var endValue = 0;
	var chartType = CHDays;
	
	//************************
	//************************
	//put the json data here
	//************************
	//************************
	$.getJSON("data.json", function(json) {
		$.each(json, function(key, value) {
			dataCDD.push(value.CDD);
			dataHDD.push(value.HDD);
			time.push(value.YEARMONTH);	
		});
		max_value = parseInt(time.length);
		chartType.series[0].data = dataCDD;
		chartType.series[1].data = dataHDD;
		chartType.xAxis.categories = time;
		var chart = new Highcharts.Chart(chartType); 
		
		$( "#slider1" ).slider({
			min: 2,
			max: max_value,
			animate: "fast",
			slide: function(event, ui) {
				startValue = ui.value;
				chartType.series[0].data  = dataCDD.slice(endValue, ui.value);
				chartType.series[1].data  = dataHDD.slice(endValue, ui.value);
				chartType.xAxis.categories = time.slice(endValue, ui.value);
				var chart = new Highcharts.Chart(chartType);
			}
		});
		
		$( "#slider2" ).slider({
			min: 2,
			max: max_value,
			animate: "fast",
			slide: function(event, ui) {
				endValue = ui.value;
				chartType.series[0].data  = dataCDD.slice(ui.value, startValue);
				chartType.series[1].data  = dataHDD.slice(ui.value, startValue);
				chartType.xAxis.categories = time.slice(ui.value, startValue);
				var chart = new Highcharts.Chart(chartType);
			}
		});
	});					
});
