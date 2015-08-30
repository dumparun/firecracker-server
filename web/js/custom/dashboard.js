$(function() {
	$('#studentDetails').highcharts({
		chart : {
			type : 'bar'
		},
		title : {
			text : 'Student Attendance'
		},
		xAxis : {
			categories : [ 'Attendance' ]
		},
		yAxis : {
			title : {
				text : 'Attendance'
			}
		},
		series : [ {
			name : 'Boys',
			data : [ 1, 0, 4 ]
		}, {
			name : 'Girls',
			data : [ 5, 7, 3 ]
		}, {
			name : 'Total',
			data : [ 5, 7, 3 ]
		} ]
	});

	$('#facultyDetails').highcharts({
		chart : {
			type : 'bar'
		},
		title : {
			text : 'Faculty Attendance'
		},
		xAxis : {
			categories : [ 'Attendance' ]
		},
		yAxis : {
			title : {
				text : 'Attendance'
			}
		},
		series : [ {
			name : 'Teaching',
			data : [ 1, 0, 4 ]
		}, {
			name : 'Non Teaching',
			data : [ 5, 7, 3 ]
		}, {
			name : 'Total',
			data : [ 5, 7, 3 ]
		} ]
	});
	$('#academicCalender')
			.highcharts(
					{
						chart : {
							plotBackgroundColor : null,
							plotBorderWidth : null,
							plotShadow : false,
							type : 'pie'
						},
						title : {
							text : 'Academic Calender 2015-2016'
						},
						tooltip : {
							pointFormat : '{series.name}: <b>{point.percentage:.1f}%</b>'
						},
						plotOptions : {
							pie : {
								allowPointSelect : true,
								cursor : 'pointer',
								dataLabels : {
									enabled : true,
									format : '<b>{point.name}</b>: {point.percentage:.1f} %',
									style : {
										color : (Highcharts.theme && Highcharts.theme.contrastTextColor)
												|| 'black'
									}
								}
							}
						},
						series : [ {
							name : "Brands",
							colorByPoint : true,
							data : [ {
								name : "Holidays",
								color : 'white',
								y : 15
							}, {
								name : "Working Days",
								y : 85,
								sliced : true,
								selected : true
							} ]
						} ]
					});
	$('#newsAndUpdates').highcharts({
		chart : {
			plotBackgroundColor : null,
			plotBorderWidth : null,
			plotShadow : false,
			type : 'pie'
		},
		title : {
			text : 'News / Updates'
		},
		tooltip : {
			pointFormat : '{series.name}: <b>{point.percentage:.1f}%</b>'
		},
		plotOptions : {
			pie : {
				allowPointSelect : true,
				cursor : 'pointer',
				dataLabels : {
					enabled : false
				},
				showInLegend : true
			}
		},
		series : [ {
			name : "Brands",
			colorByPoint : true,
			data : [ {
				name : "Old",
				color : 'red',
				y : 60
			}, {
				name : "New",
				y : 40,
				color : 'green',
				sliced : true,
				selected : true
			} ]
		} ]
	});

});