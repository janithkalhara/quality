<?php 
defined("HEXEC") or die("Restrited Access.");
?>
<script language="javascript" type="text/javascript" src="libraries/highcharts/js/highcharts.js"></script>
<script language="javascript" type="text/javascript" src="libraries/highcharts/js/highcharts.src.js"></script>
<link href="modules/mod_graphGenerator/graphGenerator.css" rel="stylesheet"	type="text/css" />
<script type="text/javascript">
	var supplier="";
	var gradeCategory;
	var seasonId;
	$('document').ready(function(){
			$.post("modules/mod_graphGenerator/getSuppliers.php",{suppliers: 'suppliers'}, function(data){
						$('#supplierNamesView').html(data);	
			});
			$('#gradeDiv').change(function(){				
				var grade = $('#gradeDiv').val();												
				setSubGrade(grade);
				});
 			});
			$('document').click(function(){
				$('.dropDownMenu').each(function(){
					if($(this).css('height')!=0){
						$(this).hide('slow');
						}
					});
				});

	function setSubGrade(grade){	
			$.post("modules/mod_graphGenerator/getSuppliers.php",{supplier : supplier,grade : grade, seasonId : seasonId}, function(data){
				var centerViewDiv = '<ul id="centerDiv" >'+data+'</ul>';
				$('#centerView').html(centerViewDiv);
			});							
			$.post("modules/mod_graphGenerator/getSuppliers.php",{gradeCategory :grade }, function(data){
				$('#subGrade').html(data);		
				var subGrade = $('#subGrade').val();					
				setData(grade,subGrade);					
			});
	}

	function setData(project,subGrade){
		$.post("modules/mod_graphGenerator/getSuppliers.php",{graph1:'graph1', supplierArrival :supplier,subGrade : subGrade, project:project,seasonId: seasonId}, function(data){
			
			var receivedData = data.split(":");
			var arrivalData = receivedData[1].split("-");						
						
			var arr = new Array;
			for(var j=0;j< arrivalData.length-1; j++ ){
					arr[j] = parseFloat(arrivalData[j]);	
			}
			
			var finalData = receivedData[0].split("-");
			var fin = new Array;
			for(var i=0;i<finalData.length-1;i++){
				fin[i] = parseFloat(finalData[i]);	
			}

			var dateArray = receivedData[2].split("^");
			
			setArrivalValues(fin, arr,dateArray);				
			
		});
				
		$.post("modules/mod_graphGenerator/getSuppliers.php",{graph2:'graph2', supplierQuantity :supplier,subGrade : subGrade, project: project,seasonId: seasonId}, function(data){
			var weights = data.split(":");
			var DQ = parseFloat(weights[0]);
			var AQ = parseFloat(weights[1]);
			var PQ = parseFloat(weights[2]);							
			setValues(AQ,PQ,DQ);
			var roundWeightLoss = Math.round((DQ-AQ)*100)/100;
			$('#weightLoss').html(roundWeightLoss);
			var perWeightLoss = Math.round(((DQ-AQ)*100/DQ)*100)/100;
			$('#perWeightLoss').html(perWeightLoss);
			$('#reject').html(Math.round((AQ-PQ)*100)/100);
			var perReject = Math.round(((AQ-PQ)*100/AQ)*100)/100;
			$('#perReject').html(perReject);										
					
			});	
		
		$.post("modules/mod_graphGenerator/getSuppliers.php",{graph3:'graph3', supplierDefects :supplier,subGrade : subGrade,project: project,seasonId: seasonId}, function(data){
			var defectsArray = data.split("-");
			var defectValues = new Array;
			
			for(var j=0;j<defectsArray.length-1;j++){
				defectValues[j]= Math.round(parseFloat(defectsArray[j])*100)/100;					
				}
			setDefectData(defectValues);
		});			

	}

	function dropDown(divId){

		$('.dropDownMenu').each(function(){
			if($(this).css('height')!=0){
				$(this).hide('slow');
				}
			});
		$('#'+divId).toggle("slow");					

	}

	// showing supplier profiles and graphs
	function showProfile(gradeCat,userId,supplierName,id){
		seasonId = id;
		gradeCategory = gradeCat;
		var userId = userId;
		$('#supplierName').html(": "+supplierName);
		supplier = supplierName;
				
		$.post("modules/mod_graphGenerator/getSuppliers.php",{supplierName :supplierName,seasonId : seasonId},function(data){
			var details = data.split(";");
			var areaNameArray = details[0];
			var centerNameArray = details[1];
		
			var projects = areaNameArray.split(":");
			var projectNames="";
								
			for(var i=0; i<projects.length-1;i++){				
				projectNames += '<option value="'+projects[i]+'">'+ projects[i] + '</option>';								
			}
			
			var centerNames = centerNameArray.split(":");
			var centerNew = centerNames[0].split("_");
			var centers="";
				
			for(var j=0; j<centerNew.length-1;j++){
				centers += '<li >'+centerNew[j] +'</li>';	
			}
			
			$('#gradeDiv').html(projectNames);
			
			var centerViewDiv = '<ul id="centerDiv" >'+centers+'</ul>';
			$('#centerView').html(centerViewDiv);
			
			var gradeNew = $('#gradeDiv').val();					
			$.post("modules/mod_graphGenerator/getSuppliers.php",{gradeCategory :gradeNew }, function(data){
				
				$('#subGrade').html(data);
				var subGrade = $('#subGrade').val();

				$.post("modules/mod_graphGenerator/getSuppliers.php",{graph1:'graph1', supplierArrival :supplier,subGrade : subGrade, project:gradeNew, seasonId: seasonId}, function(data){
					
					var receivedData = data.split(":");
					var arrivalData = receivedData[1].split("-");						
										
					var arr = new Array;
					for(var j=0;j< arrivalData.length-1; j++ ){
							arr[j] = parseFloat(arrivalData[j]);	
					}
					
					var finalData = receivedData[0].split("-");
					var fin = new Array;
					for(var i=0;i<finalData.length-1;i++){
						fin[i] = parseFloat(finalData[i]);	
					}
					var dateArray = receivedData[2].split("^");
					
					setArrivalValues(fin, arr,dateArray);					
					
		});	

				if(gradeCategory != "Small"){ 
			$.post("modules/mod_graphGenerator/getSuppliers.php",{graph2:'graph2', supplierQuantity :supplier,subGrade : subGrade,project: gradeNew, seasonId: seasonId}, function(data){
						
						var weights = data.split(":");
						var DQ = parseFloat(weights[0]);
						var AQ = parseFloat(weights[1]);
						var PQ = parseFloat(weights[2]);	
						//alert(DQ);						
						setValues(AQ,PQ,DQ);
						var roundWeightLoss = Math.round((DQ-AQ)*100)/100;
						$('#weightLoss').html(roundWeightLoss);
						var perWeightLoss = Math.round(((DQ-AQ)*100/DQ)*100)/100;
						$('#perWeightLoss').html(perWeightLoss);
						$('#reject').html(Math.round((AQ-PQ)*100)/100);
						var perReject = Math.round(((AQ-PQ)*100/AQ)*100)/100;
						$('#perReject').html(perReject);
						
				});					

			$.post("modules/mod_graphGenerator/getSuppliers.php",{graph3:'graph3', supplierDefects :supplier,subGrade : subGrade, project: gradeNew, seasonId: seasonId}, function(data){
						var defectsArray = data.split("-");
						var defectValues = new Array;
						
						for(var j=0;j<defectsArray.length-1;j++){
							defectValues[j]= Math.round(parseFloat(defectsArray[j])*100)/100;	
								
							}
						setDefectData(defectValues);
				});

				}else{	
					$.post("modules/mod_graphGenerator/getSuppliers.php",{graph2Small:'graph2Small', supplierQuantity :supplier,subGrade : subGrade,project: gradeNew, seasonId:seasonId}, function(data){
							
							var weights = data.split(":");
							var DQ = parseFloat(weights[0]);
							var AQ = parseFloat(weights[1]);
							var PQ = parseFloat(weights[2]);	
							//alert(DQ);						
							setValues(AQ,PQ,DQ);
							var roundWeightLoss = Math.round((DQ-AQ)*100)/100;
							$('#weightLoss').html(roundWeightLoss);
							var perWeightLoss = Math.round(((DQ-AQ)*100/DQ)*100)/100;
							$('#perWeightLoss').html(perWeightLoss);
							$('#reject').html(Math.round((AQ-PQ)*100)/100);
							var perReject = Math.round(((AQ-PQ)*100/AQ)*100)/100;
							$('#perReject').html(perReject);
							
					});	
						if(subGrade == "CRS"){
							$.post("modules/mod_graphGenerator/getSuppliers.php",{graph3Small:'graph2Small', supplierQuantity :supplier,subGrade : subGrade,project: gradeNew, seasonId: seasonId}, function(data){
									

							});	
						}

					}
				
				});
			
			
			$('#supplierNamesView').fadeOut('fast');
			$('#supplierProfile').fadeIn('slow');				

		});

		$.post("modules/mod_graphGenerator/getSuppliers.php",{userId: userId}, function(data){
					var userData = data.split("-");
					var avatar = userData[0];
					var area = userData[1];
					
					$('#supplierAddress').html(": "+area);
					var profPic = '<img src="files/users/avatars/'+avatar+ '" width="120px" height="120px" />';
					$('#profPic').html(profPic);
			});
	}
	
	function setValues(AQ,PQ,DQ){
		
		chart = new Highcharts.Chart({
			chart: {
				renderTo: 'graph1',
				defaultSeriesType: 'column',marginRight: 0,
				marginBottom:40,
				width:900,
				height:350
			},
			title: {
				text: 'Total Supplied Quantity'
			},
			subtitle: {
				text: ''
			},
			xAxis: {
				title:{
					text:'Quantity Type'
					},
				categories: [
					'DQ',
					'AQ',
					'PQ'
				]
			},
			yAxis: {
				min: 0,
				title: {
					text: '<b>Quantity (MT)</b>'
				}
			},
			legend: {
				layout: 'horizontal',
				backgroundColor: '#FFFFFF',
				align: 'right',
				verticalAlign: 'top',
				x: 0,
				y: 10,
				floating: true,
				shadow: true,enabled:false
				
			},
			tooltip: {
				formatter: function() {
					return ''+
						this.x +':<b> '+ this.y +'(MT)</b>';
				}
			},
			plotOptions: {
				column: {
					pointPadding: 0.2,
					borderWidth: 0
				}
			},
		        series: [{
				name: '',						
				data:[DQ,AQ,PQ]
		
			
			}]
		});
		}

	function resolveWeeks(lastWeekSet,weekcount){
		
		//re-arrange week string 
		
		var week_split=lastWeekSet.split('/');
		
		var year=week_split[2];
		var fw=week_split[0].split('-');
		var lw=week_split[1].split('-');
	
		var startWeek=year+"-"+fw[1]+"-"+fw[0];
		lastweek=year+"-"+lw[1]+"-"+lw[0];
		//getting week
		var nextWeek;
		weeksArray=Array();
		for(var i=0;i<weekcount;i++){
			//getting the next week
			nextWeek=getNextWeek(lastweek);
			
			weekStart=new Date(nextWeek[0]);	
			weekEnd=new Date(nextWeek[1]);
			
			var sd,sm,ed,em;
			if(weekStart.getDate()<10)sd="0"+weekStart.getDate();else sd=weekStart.getDate();
			if(weekStart.getMonth()<10)sm="0"+(weekStart.getMonth()+1);else sm=(weekStart.getMonth()+1);
			if(weekEnd.getDate()<10)ed="0"+weekEnd.getDate();else ed=weekEnd.getDate();
			if(weekEnd.getMonth()<10)em="0"+(weekEnd.getMonth()+1);else em=(weekEnd.getMonth()+1);
			
			 tempWeek=sd+"-"+sm+"/"+ed+"-"+em+"/"+year;
			 var tmp_mnth,tmp_day;
			 //setting last week
			 if(weekEnd.getMonth()<10)tmp_mnth="0"+(weekEnd.getMonth()+1);else tmp_mnth=weekEnd.getMonth()+1;
			 if(weekEnd.getDate()<10)tmp_day="0"+weekEnd.getDate();else tmp_day=weekEnd.getDate();
			lastweek=year+"-"+tmp_mnth+"-"+tmp_day;
			//pushing week to week array
			weeksArray.push(tempWeek);
			}
		
		return weeksArray;	
		}

	function getNextWeek(current){
		/*
		 var nextday=new Date(lastDate);
		    var nextStartDate=new Date(lastDate);
		    nextDate=new Date(lastDate);
		    nextStartDate.setDate(nextday.getDate()+1);
		    nextDate.setDate(nextday.getDate()+7);*/
		currentDate=new Date(current);

		weekStartDay=new Date(current);
		weekStartDay.setDate(currentDate.getDate()+1);
		weekEndDay=new Date(current);
		weekEndDay.setDate(weekStartDay.getDate()+6);
	    ret=Array(weekStartDay,weekEndDay);

		return ret;

		
	}
		function getseperateWeek(w){
		var week_split=w.split('/');
		
		var year=week_split[2];
		var fw=week_split[0].split('-');
		var lw=week_split[1].split('-');
	
		var startWeek=year+"-"+fw[1]+"-"+fw[0];
		lastweek=year+"-"+lw[1]+"-"+lw[0];

		return Array(startWeek,lastweek);

		}
	
	function setArrivalValues(values,arrivalValues,dateValues){
		//remove un-needed array last element
		dateValues.pop();
		/* getting the season end date */
		seasonEndDate=getSeasonEndDate(seasonId);
		endDate=seasonEndDate['endDate'];
		
		var countValues = dateValues.length;
		var roundedValues=Array();
		neededWeekCount=values.length-arrivalValues.length;
		var realWeeks;
		if(neededWeekCount>0){
			realWeeks=$.merge(dateValues,resolveWeeks(dateValues[dateValues.length-1],neededWeekCount));
			}
		else{
			realWeeks=dateValues;

			}
			
			//limit - the season end week number 
		limit=0;
		//tracking the limit week
		///* search the limit date  of the dateValues array */
		for (var k=0;k<realWeeks.length;k++){
			var week=getseperateWeek(dateValues[k]);
			weekEnddate=new Date(week[1]);
			criticalEndDate=new Date(endDate);
			if(weekEnddate>=criticalEndDate){
				limit=k;
				break;
				}
			
			
			
		}
		realWeeks=realWeeks.slice(0,limit+1);
		arrivalValues=arrivalValues.slice(0,limit+1);
		
		
		
		for(i=0;i<values.length;i++){
			
			temp=values[i]/1000;
			roundedValues[i]=Math.round(temp*100)/100;
		
		}
		roundedValues=roundedValues.slice(0,limit+1);

		var rotationValue =0;

		if(countValues > 6){
			rotationValue = -90;	
		}

		var chart;
		chart = new Highcharts.Chart({
			chart: {
				renderTo: 'graph2',
				defaultSeriesType: 'line',
				marginRight: 0,
				marginBottom:60,
				width:900,
				height:350
			},
			title: {
				text: 'Arrival Pattern of Crops',
				x: -20 //center
			},
			subtitle: {
				text: '',
				x: -20
			},
			xAxis: {
				categories: realWeeks,
				labels : { rotation : rotationValue, 
						   style : {
								font : "Normal 10px verdhana,sans-serif"
							   }
			   }
				
			},
			yAxis: {
				title: {
					text: '<b>Quantity (MT)</b>'
				},
				plotLines: [{
					value: 0,
					width: 1,
					color: '#808080'
				}]
			},
			tooltip: {
				formatter: function() {
		                return '<b>'+ this.series.name +'</b><br/>'+
						this.x +': <b>'+ this.y +' MT</b>';
				}
			},
			legend: {
				layout: 'horizontal',
				align: 'right',
				verticalAlign: 'top',
				x: -20,
				y: 0,
				borderWidth: 0
			},
			series: [{
				name: 'Estimated',
				data: arrivalValues
			}, {
				name: 'Actual',
				data: roundedValues
			}]
		});
		
	}

	function setDefectData(defectValues){
		var chart;
		chart = new Highcharts.Chart({
			chart: {
				renderTo: 'graph3',
				defaultSeriesType: 'column',marginRight: 0,
				marginBottom:30,
				width:900,
				height:350
			},
			title: {
				text: 'Total Defects'
			},
			subtitle: {
				text: ''
			},
			xAxis: {
				
				categories: [
					'Small Fruit', 
					'Large Fruit', 
					'Melon Fly Attacked', 
					'Peeled Off', 
					'Bore Attacked', 
					'Sand Embedded', 
					'Shrivelled', 
					'Deformed', 
					'Virus Attacked', 
					'Mechanical Damaged', 
					'Yellowish', 
					'Rust Patches'
					
				]
			},
			yAxis: {
				min: 0,
				title: {
					text: 'Quantity (%)'
				}
			},
			legend: {
				layout: 'horizontal',
				backgroundColor: '#FFFFFF',
				align: 'right',
				verticalAlign: 'top',
				x:0,
				y: 10,
				floating: true,
				shadow: true
			},
			tooltip: {
				formatter: function() {
					
						var report = this.x +': '+ this.y + '%';
						return report;
				}
			},
			plotOptions: {
				column: {
					pointPadding: 0.2,
					borderWidth: 0,
					allowPointSelect: true,
					cursor: 'pointer'
				}
			},
		        series: [{
				name: 'Defected Quantity',
				data: defectValues
			    		
			}, ]
		});
		

	}

	function setDefectDataSmall(defectValues){
		
		var chart;
		chart = new Highcharts.Chart({
			chart: {
				renderTo: 'graph3',
				defaultSeriesType: 'column',marginRight: 0,
				marginBottom:30,
				width:900,
				height:350
			},
			title: {
				text: 'Total Defects'
			},
			subtitle: {
				text: ''
			},
			xAxis: {
				
				categories: [
					'Small Fruit', 
					'Large Fruit', 
					'Melon Fly Attacked', 
					'Peeled Off', 
					'Bore Attacked', 
					'Sand Embedded', 
					'Shrivelled', 
					'Mechanical Damaged', 
					'Yellowish', 
					'Rust Patches',
					'Spoiled'
					
				]
			},
			yAxis: {
				min: 0,
				title: {
					text: 'Quantity (%)'
				}
			},
			legend: {
				layout: 'horizontal',
				backgroundColor: '#FFFFFF',
				align: 'right',
				verticalAlign: 'top',
				x:0,
				y: 10,
				floating: true,
				shadow: true
			},
			tooltip: {
				formatter: function() {
					
						var report = this.x +': '+ this.y + '%';
						return report;
				}
			},
			plotOptions: {
				column: {
					pointPadding: 0.2,
					borderWidth: 0,
					allowPointSelect: true,
					cursor: 'pointer'
				}
			},
		        series: [{
				name: 'Defected Quantity',
				data: defectValues
			    		
			}, ]
		});
		

	}
	function getSeasonEndDate(id){
		var result;
		$.ajax({
			url:"modules/mod_graphGenerator/getSuppliers.php",
			type:'post',
			dataType:"html",
			data:{"flag":"getSeason","sid":id},
			async:false,
			success:function(d){
		
				result=jQuery.parseJSON(d); 
			 	//result=d;
				}
		
		});
		return result;

		
		}
	
</script>

<!--start graph scripts -->

<script type="text/javascript">
		
			var chart;
									
			$(document).ready(function() {
				
				
				$('#subGrade').change(function(){
				var project = $('#gradeDiv').val();
				var subGrade = $('#subGrade').val();
				 
				if(subGrade != "Total"){

				$.post("modules/mod_graphGenerator/getSuppliers.php",{graph1:'graph1', supplierArrival :supplier,subGrade : subGrade, project:project,seasonId: seasonId}, function(data){
					
					var receivedData = data.split(":");
					var arrivalData = receivedData[1].split("-");						
					
					var arr = new Array;
					for(var j=0;j< arrivalData.length-1; j++ ){
							arr[j] = parseFloat(arrivalData[j]);	
					}
					
					var finalData = receivedData[0].split("-");
					var fin = new Array;
					for(var i=0;i<finalData.length-1;i++){
						fin[i] = parseFloat(finalData[i]);	
					}
					var dateArray = receivedData[2].split("^");
					
					setArrivalValues(fin, arr,dateArray);							
				});
				
				if(gradeCategory != "Small"){ 
					$.post("modules/mod_graphGenerator/getSuppliers.php",{graph2:'graph2', supplierQuantity :supplier,subGrade : subGrade,project: project,seasonId: seasonId}, function(data){
								
								var weights = data.split(":");
								var DQ = parseFloat(weights[0]);
								var AQ = parseFloat(weights[1]);
								var PQ = parseFloat(weights[2]);	
								//alert(DQ);						
								setValues(AQ,PQ,DQ);
								var roundWeightLoss = Math.round((DQ-AQ)*100)/100;
								$('#weightLoss').html(roundWeightLoss);
								var perWeightLoss = Math.round(((DQ-AQ)*100/DQ)*100)/100;
								$('#perWeightLoss').html(perWeightLoss);
								$('#reject').html(Math.round((AQ-PQ)*100)/100);
								var perReject = Math.round(((AQ-PQ)*100/AQ)*100)/100;
								$('#perReject').html(perReject);
								
						});					

					$.post("modules/mod_graphGenerator/getSuppliers.php",{graph3:'graph3', supplierDefects :supplier,subGrade : subGrade, project: project,seasonId: seasonId}, function(data){
								var defectsArray = data.split("-");
								var defectValues = new Array;
								
								for(var j=0;j<defectsArray.length-1;j++){
									defectValues[j]= Math.round(parseFloat(defectsArray[j])*100)/100;	
										
									}
								setDefectData(defectValues);
						});

						}else{	
							$.post("modules/mod_graphGenerator/getSuppliers.php",{graph2Small:'graph2Small', supplierQuantity :supplier,subGrade : subGrade,project: project,seasonId: seasonId}, function(data){
									
									var weights = data.split(":");
									var DQ = parseFloat(weights[0]);
									var AQ = parseFloat(weights[1]);
									var PQ = parseFloat(weights[2]);	
									//alert(DQ);						
									setValues(AQ,PQ,DQ);
									var roundWeightLoss = Math.round((DQ-AQ)*100)/100;
									$('#weightLoss').html(roundWeightLoss);
									var perWeightLoss = Math.round(((DQ-AQ)*100/DQ)*100)/100;
									$('#perWeightLoss').html(perWeightLoss);
									$('#reject').html(Math.round((AQ-PQ)*100)/100);
									var perReject = Math.round(((AQ-PQ)*100/AQ)*100)/100;
									$('#perReject').html(perReject);
									
							});	
								if(subGrade == "CRS"){
									$.post("modules/mod_graphGenerator/getSuppliers.php",{graph3Small:'graph3Small', supplierQuantity :supplier,subGrade : subGrade,project: project,seasonId: seasonId}, function(data){
											var defectData = data.split("-");
											var defectValues = new Array;
											
											for(var j=0;j<defectData.length-1;j++){
												defectValues[j]= Math.round(parseFloat(defectData[j])*100)/100;	
													
												}
											setDefectDataSmall(defectValues);

									});	
								}

							}

				
				}else{
					$.post("modules/mod_graphGenerator/getSuppliers.php",{graph1:'graph1', supplierArrival :supplier,project:project,seasonId: seasonId}, function(data){
						
						var receivedData = data.split(":");
						var arrivalData = receivedData[1].split("-");						
						
						var arr = new Array;
						for(var j=0;j< arrivalData.length-1; j++ ){
								arr[j] = parseFloat(arrivalData[j]);	
						}
						
						var finalData = receivedData[0].split("-");
						var fin = new Array;
						for(var i=0;i<finalData.length-1;i++){
							fin[i] = parseFloat(finalData[i]);	
						}
						var dateArray = receivedData[2].split("^");
						
						setArrivalValues(fin, arr,dateArray);						
					});


					if(gradeCategory != "Small"){ 
						$.post("modules/mod_graphGenerator/getSuppliers.php",{graph2:'graph2', supplierQuantity :supplier,project: project,seasonId: seasonId}, function(data){
									
									var weights = data.split(":");
									var DQ = parseFloat(weights[0]);
									var AQ = parseFloat(weights[1]);
									var PQ = parseFloat(weights[2]);	
									//alert(DQ);						
									setValues(AQ,PQ,DQ);
									var roundWeightLoss = Math.round((DQ-AQ)*100)/100;
									$('#weightLoss').html(roundWeightLoss);
									var perWeightLoss = Math.round(((DQ-AQ)*100/DQ)*100)/100;
									$('#perWeightLoss').html(perWeightLoss);
									$('#reject').html(Math.round((AQ-PQ)*100)/100);
									var perReject = Math.round(((AQ-PQ)*100/AQ)*100)/100;
									$('#perReject').html(perReject);
									
							});					

						$.post("modules/mod_graphGenerator/getSuppliers.php",{graph3:'graph3', supplierDefects :supplier, project: project,seasonId: seasonId}, function(data){
									
									var defectsArray = data.split("-");
									var defectValues = new Array;
									
									for(var j=0;j<defectsArray.length-1;j++){
										defectValues[j]= Math.round(parseFloat(defectsArray[j])*100)/100;	
											
										}
									setDefectData(defectValues);
							});

							}else{	
								$.post("modules/mod_graphGenerator/getSuppliers.php",{graph2Small:'graph2Small', supplierQuantity :supplier,project: project,seasonId: seasonId}, function(data){
										
										var weights = data.split(":");
										var DQ = parseFloat(weights[0]);
										var AQ = parseFloat(weights[1]);
										var PQ = parseFloat(weights[2]);	
										//alert(DQ);						
										setValues(AQ,PQ,DQ);
										var roundWeightLoss = Math.round((DQ-AQ)*100)/100;
										$('#weightLoss').html(roundWeightLoss);
										var perWeightLoss = Math.round(((DQ-AQ)*100/DQ)*100)/100;
										$('#perWeightLoss').html(perWeightLoss);
										$('#reject').html(Math.round((AQ-PQ)*100)/100);
										var perReject = Math.round(((AQ-PQ)*100/AQ)*100)/100;
										$('#perReject').html(perReject);
										
								});	
										$.post("modules/mod_graphGenerator/getSuppliers.php",{graph3Small:'graph3Small', supplierQuantity :supplier,project: project,seasonId: seasonId}, function(data){
														//alert(data);	
												var defectData = data.split("-");
												var defectValues = new Array;
												
												for(var j=0;j<defectData.length-1;j++){
													defectValues[j]= Math.round(parseFloat(defectData[j])*100)/100;	
														
													}
												setDefectDataSmall(defectValues);

										});						

								}				
					
					}
										
				});
			});				

			function back(){
				window.location = "home.php?option=mod_graphGenerator";
			}
		</script>



<!-- end graph Scripts -->

<div id="supplierNamesView"></div>

<div id="supplierProfile">
	<h2
		style="position: relative; left: 0px; background-color: #627AAD; width: 920px; text-align: center; color: #fff">
		Supplier Profile <input type="button" value="back" id="backButton"
			onclick="back()" />

	</h2>

	<div id="detailsArea">
		<div id="profPic"></div>
		<table height="50px"
			style="position: relative; top: -120px; left: 130px;">
			<tr class="trValidater">
				<td width="60px"><b>Name</b></td>
				<td id="supplierName"></td>
			</tr>
			<tr class="trValidater">
				<td width="60px"><b>Area</b></td>
				<td id="supplierAddress"></td>
			</tr>
			<tr class="trValidater">
				<td width="60px"><b>Email</b></td>
				<td id="supplierEmail">:</td>
			</tr>
			<tr class="trValidater">
				<td width="60px"><b>Grades</b></td>
				<td width="280px">: <select id="gradeDiv"></select> <select
					id="subGrade"></select></td>
			</tr>
		</table>

		<div id="centerName">Centers :</div>
		<div id="centerView"></div>
	</div>

	<div id="graphArea">
		<hr style="border: 1px solid #666666; position: relative; top: -10px" />

		<h2 style="position: relative; left: 330px;">Arrival Pattern of Crops</h2>
		<div id="graph2">&nbsp;</div>
		<hr style="border: 1px solid #666666; margin-bottom: 20px" />
		<div style="z-index: 20000; width: 900px; margin: 0 auto 0 auto"
			id="graph1">&nbsp;</div>

		<table align="center" cellpadding='0' cellspacing='1'
			style="border-spacing: 0px; border: 0px solid #666666; margin-top: 5px; font-size: 12px">
			<tr height="20px">
				<td width="200px" class="tdClass head">Category Type</td>
				<td width="200px" class="tdClass head">Quantity (kg)</td>
				<td width="200px" class="tdClass head">Percentage (%)</td>
			</tr>
			<tr height="20px">
				<td width="200px" class="tdClass"
					style="text-align: left; padding-left: 10px"><b>Weight Loss</b></td>
				<td class="tdClass" id="weightLoss"></td>
				<td class="tdClass" id="perWeightLoss"></td>
			</tr>
			<tr height="20px">
				<td width="200px" class="tdClass"
					style="text-align: left; padding-left: 10px"><b>Rejected</b>
				</td>
				<td class="tdClass" id="reject"></td>
				<td class="tdClass" id="perReject"></td>
			</tr>
		</table>
		<hr style="border: 1px solid #666666; margin-bottom: 20px" />
		<div style="z-index: 20000; width: 900px; margin: 0 auto 0 auto"
			id="graph3">&nbsp;</div>
			
			
			
	</div>
</div>