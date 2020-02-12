var supplier = "";
var gradeCategory = "";
var seasonId;
var gradeFC;

$('document').ready(function() {

	$('p.supplier-name').click(function(e){
		$(this).closest('#supplierNamesView').find('.details').slideUp();
		$(this).closest('.supplier-list').find('.details').slideToggle();
		
	});
	
	$('.show-profile').change(function(){
		showProfile($(this).data('name'), $(this).data('id'), $(this).val());
		
	});
	
	$('#projectDiv').change(function() {
		var projectId = $('#projectDiv').val();
		gradeCategory = "";
		$.ajax({
			url:"modules/mod_supplierProfile/getSuppliers.php",
			data:{'gradeCat':'gradeCat',proId:projectId},
			type:'post',
			async:false,
			success:function(data){
			
			gradeCategory = data.trim();
			
				}});
		
		setSubGrade(projectId,gradeCategory);

	});

});

$('document').click(function() {
	$('.dropDownMenu').each(function() {
		if ($(this).css('height') != 0) {
			$(this).hide('slow');
		}
	});
});

function setSubGrade(projectId,gradeCat) {
	/*
	 * setting center names in the profile view 
	 */
	var centers="";
	$.post("modules/mod_supplierProfile/getSuppliers.php", {supplier : supplier,projectId : projectId,seasonId : seasonId}, function(data) {
								
								var centerNameArray = jQuery.parseJSON(data);
																
								if (centerNameArray != null) {
									/* center name array is not null */
									if (centerNameArray != null) {
										for ( var j = 0; j < centerNameArray.length; j++) {
											centers += '<li >' + centerNameArray[j]+ '</li>';
										}
										
										var centerViewDiv = '<ul id="centerDiv" >'+ centers + '</ul>';
										$('#centerView').html(centerViewDiv);
									} else {
										/* center name array is null */
										$('#centerView').html("No centers are registered for this Project");
									}

								}
	});
	/*
	 *setting the subgrades according to the selected project 
	 */
	$.post("modules/mod_supplierProfile/getSuppliers.php", {'selectedProject' : projectId
					}, function(data) {
				var dataArray = jQuery.parseJSON(data);
				$('#subGrade').html(dataArray[0]);
				var subGrade = $('#subGrade').val();
				setData(projectId, subGrade,gradeCat);
	});
}

function setData(selectedProject, subGrade,gradeCat) {
	/*
	 * sending request to retrieve arrival data 
	 */
	$.post("modules/mod_supplierProfile/getSuppliers.php", {
					flag:'genPattern',
					graph1 : 'graph1',
					supplierArrival : supplier,
					subGrade : subGrade,
					project : selectedProject,
					seasonId : seasonId
									}, function(data) {

						var arrays=jQuery.parseJSON(data);
						var pattern=new Array();
						var actual=new Array();
						var weeks=new Array();
						for(var i=0;i<arrays.length;i++){
							pattern[i]=parseFloat(arrays[i]['pattern_q']);
							actual[i]=parseFloat(arrays[i]['a_q']);
							weeks[i]=arrays[i]['from']+"/"+arrays[i]['to'];
						}
						/*
						 * calling to set graphs.
						 */
						setArrivalValues(actual,pattern,weeks);


	});

	
	if (gradeCat != "5") {
		/*
		 * grade category is not small.
		 * 
		 */
		$.post("modules/mod_supplierProfile/getSuppliers.php",
						{
							graph2 : 'graph2',
							supplierQuantity : supplier,
							subGrade : subGrade,
							project : selectedProject,
							seasonId : seasonId
						},
						function(data) {
						/*
						 * setting second graph data
						 */
							var dataArray = jQuery.parseJSON(data);

							var DQ = parseFloat(dataArray[0]);
							var AQ = parseFloat(dataArray[1]);
							var PQ = parseFloat(dataArray[2]);
							// alert(DQ);
							
							if(DQ != 0){
								setValues(AQ,PQ,DQ);
							}else{
								showNoDataGraph('graph1');
							}
							
							var roundWeightLoss = Math.round((DQ - AQ) * 100) / 100;
							$('#weightLoss').html(roundWeightLoss);
							var perWeightLoss = Math.round(((DQ - AQ) * 100 / DQ) * 100) / 100;
							$('#perWeightLoss').html(perWeightLoss);
							$('#reject').html(Math.round((AQ - PQ) * 100) / 100);
							var perReject = Math.round(((AQ - PQ) * 100 / AQ) * 100) / 100;
							$('#perReject').html(perReject);

						});

		$.post("modules/mod_supplierProfile/getSuppliers.php",
						{
							graph3 : 'graph3',
							supplierDefects : supplier,
							subGrade : subGrade,
							project : selectedProject,
							seasonId : seasonId
						},
						function(data) {
							
							var defectsArray = jQuery.parseJSON(data);
							var defectValues = new Array;

							for ( var j = 0; j < defectsArray.length; j++) {
								defectValues[j] = Math.round(parseFloat(defectsArray[j]) * 100) / 100;

							}
							setDefectData(defectValues);
						});

	} else {	
		/*
		 * grade category is small
		 */
		$.post("modules/mod_supplierProfile/getSuppliers.php",
						{
							graph2Small : 'graph2Small',
							supplierQuantity : supplier,
							subGrade : subGrade,
							project : selectedProject,
							seasonId : seasonId
						},
						function(data) {
							if(data){		
									var weights = jQuery.parseJSON(data);
									var DQ = parseFloat(weights[0]);
									var AQ = parseFloat(weights[1]);
									var PQ = parseFloat(weights[2]);
									// alert(DQ);
									if(DQ != 0){
										setValues(AQ,PQ,DQ);
									}else{
										showNoDataGraph('graph1');
									}
									//setValues(AQ,PQ,DQ);
									var roundWeightLoss = Math.round((DQ - AQ) * 100) / 100;
									$('#weightLoss').html(roundWeightLoss);
									var perWeightLoss = Math.round(((DQ - AQ) * 100 / DQ) * 100) / 100;
									$('#perWeightLoss').html(perWeightLoss);
									$('#reject').html(Math.round((AQ - PQ) * 100) / 100);
									var perReject = Math.round(((AQ - PQ) * 100 / AQ) * 100) / 100;
									$('#perReject').html(perReject);
							}

						});
		
			$.post("modules/mod_supplierProfile/getSuppliers.php",
							{
								graph3Small : 'graph3Small',
								supplierQuantity : supplier,
								subGrade : subGrade,
								project : selectedProject,
								seasonId : seasonId,
								'Total' : 'NotTotal'
							},
							function(data) {
								
								
								if(!data){
									setDefectDataSmall(0);
								}	
							});
		

	}
/*
 * end of set Data function. 
 */
}

function dropDown(divId) {
	/*
	 * handling ui 
	 */
	$('.dropDownMenu').each(function() {
		if ($(this).css('height') != 0) {
			$(this).hide('slow');
		}
	});
	$('#' + divId).toggle("slow");

}
/*
 * Showing supplier profile .
 * @ the bigining this function will be called.
 */
function showProfile(supplierName, userId, id) {
	/*
	 * setting relavant data 
	 */
	seasonId = id;
	gradeCategory = "";
	var userId = userId;
	$('#supplierName').html(":" + supplierName);
	supplier = supplierName;

	$.post("modules/mod_supplierProfile/getSuppliers.php",{supplierId : userId,	seasonId : seasonId
					},
					function(data) {
						
						/*
	 * Calling server to get centers and in next relevant centers will be set. 	 */				
												
						var areaNameArray = jQuery.parseJSON(data);
						var projectNames = "";
	/*
	 * setting project name option input
	 */
						for ( var i = 0; i < areaNameArray.length; i++) {
							projectNames += '<option value="'+ areaNameArray[i][0] + '">'+ areaNameArray[i][1] + '</option>';
						}
					
					
			$('#projectDiv').html(projectNames);
			var selectedProject = $('#projectDiv').val();
			
			/*
			 * method calling for setting up the centers for the center area 
			 */
			setCenters(userId, selectedProject, seasonId);		
			
			
			/*
			 * begining to get grade category and subgrades 
			 */
			$.post("modules/mod_supplierProfile/getSuppliers.php",{selectedProject : selectedProject},
							function(data) {
				
								var returnArr = jQuery.parseJSON(data);
								gradeCategory = returnArr[1];
								
								$('#subGrade').html(returnArr[0]);
								var subGrade = $('#subGrade').val();
			/*
			 * calling server to get arrival pattern data.
			 */							
								$.post("modules/mod_supplierProfile/getSuppliers.php",
												{	flag:'genPattern',
													graph1 : 'graph1',
													supplierArrival : supplier,
													subGrade : subGrade,
													project : selectedProject,
													seasonId : seasonId
												},
												function(data) {
													if(data){
														var arrays=jQuery.parseJSON(data);
														var pattern=new Array();
														var actual=new Array();
														var weeks=new Array();
														for(var i=0;i<arrays.length;i++){
															pattern[i]=parseFloat(arrays[i]['pattern_q']);
															actual[i]=parseFloat(arrays[i]['a_q']);
															weeks[i]=arrays[i]['from']+"/"+arrays[i]['to'];
														}
																setArrivalValues(actual,pattern,weeks);
													}

												});
								if (gradeCategory != "5") {
									/*
									 * grade category is not small.
									 * 
									 */
									$.post("modules/mod_supplierProfile/getSuppliers.php",
													{
														graph2 : 'graph2',
														supplierQuantity : supplier,
														subGrade : subGrade,
														project : selectedProject,
														seasonId : seasonId
													},
													function(data) {
													/*
													 * setting second graph data
													 */
														var dataArray = jQuery.parseJSON(data);

														var DQ = parseFloat(dataArray[0]);
														var AQ = parseFloat(dataArray[1]);
														var PQ = parseFloat(dataArray[2]);
														// alert(DQ);
														if(DQ != 0){
															setValues(AQ,PQ,DQ);
														}else{
															showNoDataGraph('graph1');
														}
														//setValues(AQ,PQ,DQ);
														var roundWeightLoss = Math.round((DQ - AQ) * 100) / 100;
														$('#weightLoss').html(roundWeightLoss);
														var perWeightLoss = Math.round(((DQ - AQ) * 100 / DQ) * 100) / 100;
														$('#perWeightLoss').html(perWeightLoss);
														$('#reject').html(Math.round((AQ - PQ) * 100) / 100);
														var perReject = Math.round(((AQ - PQ) * 100 / AQ) * 100) / 100;
														$('#perReject').html(perReject);

													});

									$.post("modules/mod_supplierProfile/getSuppliers.php",
													{
														graph3 : 'graph3',
														supplierDefects : supplier,
														subGrade : subGrade,
														project : selectedProject,
														seasonId : seasonId
													},
													function(data) {

														var defectsArray = jQuery.parseJSON(data);
														var defectValues = new Array;

														for ( var j = 0; j < defectsArray.length; j++) {
															defectValues[j] = Math.round(parseFloat(defectsArray[j]) * 100) / 100;

														}
														setDefectData(defectValues);
													});

								} else {	
									/*
									 * grade category is small
									 */
									$.post("modules/mod_supplierProfile/getSuppliers.php",
													{
														graph2Small : 'graph2Small',
														supplierQuantity : supplier,
														subGrade : subGrade,
														project : selectedProject,
														seasonId : seasonId
													},
													function(data) {																
																var weights = jQuery.parseJSON(data);
																var DQ = parseFloat(weights[0]);
																var AQ = parseFloat(weights[1]);
																var PQ = parseFloat(weights[2]);
																// alert(DQ);
																if(DQ != 0){
																	setValues(AQ,PQ,DQ);
																}else{
																	showNoDataGraph('graph1');
																}
																//setValues(AQ,PQ,DQ);
																var roundWeightLoss = Math.round((DQ - AQ) * 100) / 100;
																$('#weightLoss').html(roundWeightLoss);
																var perWeightLoss = Math.round(((DQ - AQ) * 100 / DQ) * 100) / 100;
																$('#perWeightLoss').html(perWeightLoss);
																$('#reject').html(Math.round((AQ - PQ) * 100) / 100);
																var perReject = Math.round(((AQ - PQ) * 100 / AQ) * 100) / 100;
																$('#perReject').html(perReject);														

													});
								}
			});

			$('#supplierNamesView').fadeOut('fast');
			$('#supplierProfile').fadeIn('slow');

		});

	$.post("modules/mod_supplierProfile/getSuppliers.php", {
		userId : userId
	}, function(data) {
		var userData = jQuery.parseJSON(data);
		var avatar = userData[0];
		var area = userData[1];

		$('#supplierAddress').html(":" + area);
		var profPic = '<img src="files/users/avatars/' + avatar
				+ '" width="120px" height="120px" />';
		$('#detailsArea .profPic').html(profPic);
	});
	/*
	 * End of showProfile function . 
	 */
}

/*
 * filling the center area
 */

function setCenters(supplier,projectId,seasonId){
	var centers="";
	$.post("modules/mod_supplierProfile/getSuppliers.php", {supplier : supplier,projectId : projectId,seasonId : seasonId}, function(data) {
								var centerNameArray = jQuery.parseJSON(data);
								if (centerNameArray != null) {
									if (centerNameArray != null) {
										for ( var j = 0; j < centerNameArray.length; j++) {
											centers += '<li >' + centerNameArray[j]+ '</li>';
										}
										var centerViewDiv = '<ul id="centerDiv" >'+ centers + '</ul>';
										$('#detailsArea .centerView').html(centerViewDiv);
									} else {
										$('#detailsArea .centerView').html("No centers are registered for this Project");
									}

								}
	});
	
}


function setValues(AQ, PQ, DQ) {

	chart = new Highcharts.Chart({
		chart : {
			renderTo : 'graph1',
		    events:{load:function(){$(document).resize()}},
			defaultSeriesType : 'column',
			marginRight : 0,
			marginBottom : 40,
			width : 900,
			height : 350
		},
		title : {
			text : 'Total Supplied Quantity'
		},
		subtitle : {
			text : ''
		},
		xAxis : {
			title : {
				text : 'Quantity Type'
			},
			categories : [ 'DQ', 'AQ', 'PQ' ]
		},
		yAxis : {
			min : 0,
			title : {
				text : '<b>Quantity (MT)</b>'
			}
		},
		legend : {
			layout : 'horizontal',
			backgroundColor : '#FFFFFF',
			align : 'right',
			verticalAlign : 'top',
			x : 0,
			y : 10,
			floating : true,
			shadow : true,
			enabled : false

		},
		tooltip : {
			formatter : function() {
				return '' + this.x + ':<b> ' + this.y + '(MT)</b>';
			}
		},
		plotOptions : {
			column : {
				pointPadding : 0.2,
				borderWidth : 0
			}
		},
		series : [ {
			name : '',
			data : [ DQ, AQ, PQ ]

		} ]
	});
}

function resolveWeeks(lastWeekSet, weekcount) {

	// re-arrange week string

	var week_split = lastWeekSet.split('/');

	var year = week_split[2];
	var fw = week_split[0].split('-');
	var lw = week_split[1].split('-');

	var startWeek = year + "-" + fw[1] + "-" + fw[0];
	lastweek = year + "-" + lw[1] + "-" + lw[0];
	// getting week
	var nextWeek;
	weeksArray = Array();
	for ( var i = 0; i < weekcount; i++) {
		// getting the next week
		nextWeek = getNextWeek(lastweek);

		weekStart = new Date(nextWeek[0]);
		weekEnd = new Date(nextWeek[1]);

		var sd, sm, ed, em;
		if (weekStart.getDate() < 10)
			sd = "0" + weekStart.getDate();
		else
			sd = weekStart.getDate();
		if (weekStart.getMonth() < 10)
			sm = "0" + (weekStart.getMonth() + 1);
		else
			sm = (weekStart.getMonth() + 1);
		if (weekEnd.getDate() < 10)
			ed = "0" + weekEnd.getDate();
		else
			ed = weekEnd.getDate();
		if (weekEnd.getMonth() < 10)
			em = "0" + (weekEnd.getMonth() + 1);
		else
			em = (weekEnd.getMonth() + 1);

		tempWeek = sd + "-" + sm + "/" + ed + "-" + em + "/" + year;
		var tmp_mnth, tmp_day;
		// setting last week
		if (weekEnd.getMonth() < 10)
			tmp_mnth = "0" + (weekEnd.getMonth() + 1);
		else
			tmp_mnth = weekEnd.getMonth() + 1;
		if (weekEnd.getDate() < 10)
			tmp_day = "0" + weekEnd.getDate();
		else
			tmp_day = weekEnd.getDate();
		lastweek = year + "-" + tmp_mnth + "-" + tmp_day;
		// pushing week to week array
		weeksArray.push(tempWeek);
	}

	return weeksArray;
}

function getNextWeek(current) {
	currentDate = new Date(current);

	weekStartDay = new Date(current);
	weekStartDay.setDate(currentDate.getDate() + 1);
	weekEndDay = new Date(current);
	weekEndDay.setDate(weekStartDay.getDate() + 6);
	ret = Array(weekStartDay, weekEndDay);

	return ret;

}
function getseperateWeek(w) {
	var week_split = w.split('/');

	var year = week_split[2];
	var fw = week_split[0].split('-');
	var lw = week_split[1].split('-');

	var startWeek = year + "-" + fw[1] + "-" + fw[0];
	lastweek = year + "-" + lw[1] + "-" + lw[0];

	return Array(startWeek, lastweek);

}

function setArrivalValues(values, arrivalValues, weeks) {

	var chart;
	chart = new Highcharts.Chart({
		chart : {
			renderTo : 'graph2',
		    events:{load:function(){$(document).resize()}},
			defaultSeriesType : 'line',
			marginRight : 0,
			marginBottom :80,
			width : 980,
			height : 450,
			paddingRight:30
		},
		title : {
			text : 'Arrival Pattern of Crops',
			x : -20
		// center
		},
		subtitle : {
			text : '',
			x : -20
		},
		xAxis : {
			categories : weeks,
			labels : {
				rotation :60,
				style : {
					font : "Normal 10px verdhana,sans-serif"
				}
			},
			y:30

		},
		yAxis : {
			title : {
				text : '<b>Quantity (MT)</b>'
			},
			plotLines : [ {
				value : 0,
				width : 1,
				color : '#808080'
			} ]
		},
		tooltip : {
			formatter : function() {
				return '<b>' + this.series.name + '</b><br/>' + this.x
						+ ': <b>' + this.y + ' MT</b>';
			}
		},
		legend : {
			layout : 'horizontal',
			align : 'right',
			verticalAlign : 'top',
			x : -50,
			y : 0,
			borderWidth : 0
		},
		series : [ {
			name : 'Estimated',
			data : arrivalValues
		}, {
			name : 'Actual',
			data : values
		} ]
	});

}

function setDefectData(defectValues) {
	var chart;
	chart = new Highcharts.Chart({
		chart : {
			renderTo : 'graph3',
		    events:{load:function(){$(document).resize()}},
			defaultSeriesType : 'column',
			marginRight : 0,
			marginBottom : 30,
			width : 900,
			height : 350
		},
		title : {
			text : 'Total Defects'
		},
		subtitle : {
			text : ''
		},
		xAxis : {

			categories : [ 'Small Fruit', 'Large Fruit', 'Melon Fly Attacked',
					'Peeled Off', 'Bore Attacked', 'Sand Embedded',
					'Shrivelled', 'Deformed', 'Virus Attacked',
					'Mechanical Damaged', 'Yellowish', 'Rust Patches','Spoiled/Rotten',
					'> 45mm Fruits'

			]
		},
		yAxis : {
			min : 0,
			title : {
				text : 'Quantity (%)'
			}
		},
		legend : {
			layout : 'horizontal',
			backgroundColor : '#FFFFFF',
			align : 'right',
			verticalAlign : 'top',
			x : 0,
			y : 10,
			floating : true,
			shadow : true
		},
		tooltip : {
			formatter : function() {

				var report = this.x + ': ' + this.y + '%';
				return report;
			}
		},
		plotOptions : {
			column : {
				pointPadding : 0.2,
				borderWidth : 0,
				allowPointSelect : true,
				cursor : 'pointer'
			}
		},
		series : [ {
			name : 'Defected Quantity',
			data : defectValues

		}, ]
	});
	
}

function setDefectDataSmall(defectValues) {

	var chart;
	chart = new Highcharts.Chart({
		chart : {
			renderTo : 'graph3',
			events:{load:function(ev){$(document).resize();}},
			defaultSeriesType : 'column',
			marginRight : 0,
			marginBottom : 30,
			width : 900,
			height : 350
		},
		title : {
			text : 'Total Defects'
		},
		subtitle : {
			text : ''
		},
		xAxis : {

			categories : [ 'Small Fruit', 'Large Fruit', 'Melon Fly Attacked',
					'Peeled Off', 'Bore Attacked', 'Sand Embedded',
					'Shrivelled', 'Mechanical Damaged', 'Yellowish',
					'Rust Patches', 'Spoiled'

			]
		},
		yAxis : {
			min : 0,
			title : {
				text : 'Quantity (%)'
			}
		},
		legend : {
			layout : 'horizontal',
			backgroundColor : '#FFFFFF',
			align : 'right',
			verticalAlign : 'top',
			x : 0,
			y : 10,
			floating : true,
			shadow : true
		},
		tooltip : {
			formatter : function() {

				var report = this.x + ': ' + this.y + '%';
				return report;
			}
		},
		plotOptions : {
			column : {
				pointPadding : 0.2,
				borderWidth : 0,
				allowPointSelect : true,
				cursor : 'pointer'
			}
		},
		series : [ {
			name : 'Defected Quantity',
			data : defectValues

		}, ]
	});

}
function getSeasonEndDate(id) {
	var result;
	$.ajax({
		url : "modules/mod_supplierProfile/getSuppliers.php",
		type : 'post',
		dataType : "html",
		data : {
			"flag" : "getSeason",
			"sid" : id
		},
		async : false,
		success : function(d) {

			result = jQuery.parseJSON(d);
			// result=d;
		}

	});
	return result;

}

var chart;

$(document).ready(function() {
	$('#subGrade').change(function() {
		var project = $('#projectDiv').val();
		var subGrade = $('#subGrade').val();
								
		$.ajax({
			url : "modules/mod_supplierProfile/getSuppliers.php",
			type : "post",
			data : {'gradeCat':'gradeCat',proId:project},
			async : false,
			success : function(data){
				gradeCategory = data.trim();
			}
		});
				
		if (subGrade != "Total") {
			$.post("modules/mod_supplierProfile/getSuppliers.php",
				{'flag':'genPattern',
					graph1 : 'graph1',
					supplierArrival : supplier,
					subGrade : subGrade,
					project : project,
					seasonId : seasonId
					},function(data) {
					
						if(data){
							var arrays=jQuery.parseJSON(data);
							var pattern=new Array();
							var actual=new Array();
							var weeks=new Array();
							for(var i=0;i<arrays.length;i++){
								pattern[i]=parseFloat(arrays[i]['pattern_q']);
								actual[i]=parseFloat(arrays[i]['a_q']);
								weeks[i]=arrays[i]['from']+"/"+arrays[i]['to'];
							}
									setArrivalValues(actual,pattern,weeks);
						}
						
					});
			
			
					if (gradeCategory != "5") {
						$.post("modules/mod_supplierProfile/getSuppliers.php",
								{graph2 : 'graph2',
								supplierQuantity : supplier,
								subGrade : subGrade,
								project : project,
								seasonId : seasonId
								},function(data) {									
											var dataArray = jQuery.parseJSON(data);
											var DQ = parseFloat(dataArray[0]);
											var AQ = parseFloat(dataArray[1]);
											var PQ = parseFloat(dataArray[2]);
																			// alert(DQ);
											if(DQ != 0){
												setValues(AQ,PQ,DQ);
											}else{
												showNoDataGraph('graph2');
											}
																						
											var roundWeightLoss = Math.round((DQ - AQ) * 100) / 100;
											$('#weightLoss').html(roundWeightLoss);
											var perWeightLoss = Math.round(((DQ - AQ) * 100 / DQ) * 100) / 100;
											$('#perWeightLoss').html(perWeightLoss);
											$('#reject').html(Math.round((AQ - PQ) * 100) / 100);
											var perReject = Math.round(((AQ - PQ) * 100 / AQ) * 100) / 100;
											$('#perReject').html(perReject);									
								});
						
						$.post("modules/mod_supplierProfile/getSuppliers.php",
									{graph3 : 'graph3',
									supplierDefects : supplier,
									subGrade : subGrade,
									project : project,
									seasonId : seasonId
									},
									function(data) {									
										var defectsArray = jQuery.parseJSON(data);
										var defectValues = new Array;
										for ( var j = 0; j < defectsArray.length; j++) {
												defectValues[j] = Math.round(parseFloat(defectsArray[j]) * 100) / 100;

										}
										setDefectData(defectValues);
									});

						} else {
							$.post("modules/mod_supplierProfile/getSuppliers.php",
									{graph2Small : 'graph2Small',
									supplierQuantity : supplier,
									subGrade : subGrade,
									project : project,
									seasonId : seasonId
											},
									function(data) {
											var weights = jQuery.parseJSON(data);
											var DQ = parseFloat(weights[0]);
											var AQ = parseFloat(weights[1]);
											var PQ = parseFloat(weights[2]);
																	// alert(DQ);
											if(DQ != 0){
												setValues(AQ,PQ,DQ);
											}else{
												showNoDataGraph('graph1');
											}
											//setValues(AQ,PQ,DQ);
											var roundWeightLoss = Math.round((DQ - AQ) * 100) / 100;
											$('#weightLoss').html(roundWeightLoss);
											var perWeightLoss = Math.round(((DQ - AQ) * 100 / DQ) * 100) / 100;
											$('#perWeightLoss').html(perWeightLoss);
											$('#reject').html(Math.round((AQ - PQ) * 100) / 100);
											var perReject = Math.round(((AQ - PQ) * 100 / AQ) * 100) / 100;
											$('#perReject').html(perReject);

											});

							$.post("modules/mod_supplierProfile/getSuppliers.php",
									{
										graph3Small : 'graph3Small',
										supplierQuantity : supplier,
										subGrade : subGrade,
										project : project,
										seasonId : seasonId,
										'Total' : '0'
									},
									function(data) {										
												var defectData = jQuery.parseJSON(data);
												var defectValues = new Array;

												for ( var j = 0; j < defectData.length - 1; j++) {
													defectValues[j] = Math.round(parseFloat(defectData[j]) * 100) / 100;

												}
												setDefectDataSmall(defectValues);										
									});
								}
		} else {
			//not setting sub grades 
			$.post("modules/mod_supplierProfile/getSuppliers.php",
					{	"flag":"genPattern",
						graph1 : 'graph1',
						supplierArrival : supplier,
						project : project,
						seasonId : seasonId
						},function(data) {							
								//setting graph data and rendering 

							var arrays=jQuery.parseJSON(data);
							var pattern=new Array();
							var actual=new Array();
							var weeks=new Array();
							for(var i=0;i<arrays.length;i++){
								pattern[i]=parseFloat(arrays[i]['pattern_q']);
								actual[i]=parseFloat(arrays[i]['a_q']);
								weeks[i]=arrays[i]['from']+"/"+arrays[i]['to'];
							}
							
								setArrivalValues(actual,pattern,weeks);
															});
						//category large.medium
				if (gradeCategory != "5") {
					$.post("modules/mod_supplierProfile/getSuppliers.php",
									{graph2 : 'graph2',
									supplierQuantity : supplier,
									project : project,
									seasonId : seasonId
									},function(data) {

														var dataArray = jQuery.parseJSON(data);
														var DQ = parseFloat(dataArray[0]);
														var AQ = parseFloat(dataArray[1]);
														var PQ = parseFloat(dataArray[2]);
																	// alert(DQ);
														if(DQ != 0){
															setValues(AQ,PQ,DQ);
														}else{
															showNoDataGraph('graph1');
														}
														//setValues(AQ,PQ,DQ);
														var roundWeightLoss = Math.round((DQ - AQ) * 100) / 100;
														var roundWeightLoss = Math.round((DQ - AQ) * 100) / 100;
														$('#weightLoss').html(roundWeightLoss);
														var perWeightLoss = Math.round(((DQ - AQ) * 100 / DQ) * 100) / 100;
														$('#perWeightLoss').html(perWeightLoss);
														$('#reject').html(Math.round((AQ - PQ) * 100) / 100);
														var perReject = Math.round(((AQ - PQ) * 100 / AQ) * 100) / 100;
														$('#perReject').html(perReject);
														
													});

								$.post("modules/mod_supplierProfile/getSuppliers.php",
												{
													graph3 : 'graph3',
													supplierDefects : supplier,
													project : project,
													seasonId : seasonId
												},
												function(data) {
													
													var defectsArray = jQuery.parseJSON(data);
													var defectValues = new Array;

													for ( var j = 0; j < defectsArray.length; j++) {
														defectValues[j] = Math.round(parseFloat(defectsArray[j]) * 100) / 100;

													}
													setDefectData(defectValues);
												});

							} else {
								$.post("modules/mod_supplierProfile/getSuppliers.php",
												{
													graph2Small : 'graph2Small',
													supplierQuantity : supplier,
													project : project,
													seasonId : seasonId
												},
												function(data) {													
															var weights = jQuery.parseJSON(data);
															var DQ = parseFloat(weights[0]);
															var AQ = parseFloat(weights[1]);
															var PQ = parseFloat(weights[2]);
															// alert(DQ);
															if(DQ != 0){
																setValues(AQ,PQ,DQ);
															}else{
																showNoDataGraph('graph1');
															}
															//setValues(AQ,PQ,DQ);
															var roundWeightLoss = Math.round((DQ - AQ) * 100) / 100;
															$('#weightLoss').html(roundWeightLoss);
															var perWeightLoss = Math.round(((DQ - AQ) * 100 / DQ) * 100) / 100;
															$('#perWeightLoss').html(perWeightLoss);
															$('#reject').html(Math.round((AQ - PQ) * 100) / 100);
															var perReject = Math.round(((AQ - PQ) * 100 / AQ) * 100) / 100;
															$('#perReject').html(perReject);
													
												});
								$.post("modules/mod_supplierProfile/getSuppliers.php",
												{
													graph3Small : 'graph3Small',
													supplierQuantity : supplier,
													project : project,
													seasonId : seasonId,
													'Total' : '1'
												},
												function(data) {													
															var defectData = jQuery.parseJSON(data);
															var defectValues = new Array;
		
															for ( var j = 0; j < defectData.length - 1; j++) {
																defectValues[j] = Math.round(parseFloat(defectData[j]) * 100) / 100;
		
															}
															setDefectDataSmall(defectValues);													
												});
							}

						}

					});
				});

function back() {
	window.location = "home.php?option=mod_supplierProfile";
}

function getSubGradeFruitCount(gradeId) {
	$.post("modules/mod_supplierProfile/getSuppliers.php", {
		gradeIdForName : gradeId
	}, function(data) {
		gradeFC = data;

	});

}

function showNoDataGraph(graph){
	$(function () {
	    var chart = new Highcharts.Chart({
	        chart: {
	            renderTo: graph,
	            events:{load:function(ev){$(document).resize();}},
	            defaultSeriesType : 'column',
    			marginRight : 0,
    			marginBottom : 40,
    			width : 900,
    			height : 350            	
	        },
	        title : {
				text : 'Total Supplied Quantity'
			},
			subtitle : {
				text : ''
			},
			xAxis : {
				title : {
					text : 'Quantity Type'
				},
				categories : [ 'DQ', 'AQ', 'PQ' ]
			},
			yAxis : {
				min : 0,
				title : {
					text : '<b>Quantity (MT)</b>'
				}
			},
	        labels: {
	            items: [{
	                html: '<b>No data for this Graph</b>',
	                style: {
	                    top: '50px',
	                    left: '50px',
	                    font : 'normal 14px Verdana, sans-serif'
	                }
	            }]	            
	        },
	        series: [{
	        	name : '',
	            data : [0,0,0]
	        }]
	    });
	});	
	
}

