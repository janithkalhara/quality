<?php 
defined("HEXEC") or die("Restrited Access.");
?>
<link rel="stylesheet" href="modules/mod_totalStockViewer/totalStockViewer.css" type="text/css" />
<script
	type="text/javascript"
	src="libraries/highcharts/js/highcharts.js"></script>
<script
	type="text/javascript"
	src="libraries/highcharts/js/modules/exporting.js"></script>
<script
	type="text/javascript" src="modules/mod_totalStockViewer/js/buttonHover.js"></script>	
	
<script type="text/javascript">
	$('document').ready(function(){

		generateGraphs();
		$('#internalButton').click(function(){
				$.post("modules/mod_totalStockViewer/getGraphData.php",{graph1:'graph1'}, function(data){
					
						var quantities = jQuery.parseJSON(data);
						quantities[0] = parseFloat(quantities[0]);
						quantities[1] = parseFloat(quantities[1]);
						quantities[2] = parseFloat(quantities[2]);
						setValues(quantities);

						if(quantities[0] != 0){
							$('#weightLoss').html(Math.round((quantities[0]-quantities[1])*100)/100);
							var perWeightLoss = Math.round(((quantities[0]-quantities[1])*100/quantities[0])*100)/100;
							$('#perWeightLoss').html(perWeightLoss);
							$('#reject').html(Math.round((quantities[1]-quantities[2])*100)/100);
							var perReject = Math.round(((quantities[1]-quantities[2])*100/quantities[1])*100)/100;
							$('#perReject').html(perReject);
						}else{
							$('#weightLoss').html("");
							$('#perWeightLoss').html("");
							$('#reject').html("");
							$('#perReject').html("");
						}
						
				});

				$.post("modules/mod_totalStockViewer/getGraphData.php",{graph3:'graph3'}, function(data){
							
							var defectsArraySet = data;// jQuery.parseJSON(data);
							var defectsArray = new Array();
							for(var i=0;i<(defectsArraySet.length);i++){
								defectsArray[i] = parseFloat(defectsArraySet[i]);
								defectsArray[i] = Math.round(defectsArray[i]*100)/100;
							}		
							setDefectData(defectsArray);			
				});

				$.post("modules/mod_totalStockViewer/getGraphData.php",{graph2:'graph2'}, function(data){
										
					var result=data;//jQuery.parseJSON(data);
			        setArrivalValues(result['pattern'],result['weeks'],result['stocks']);
				});				
			});

			$('#externalButton').click(function(){				
					$.post("modules/mod_totalStockViewer/getGraphData.php",{graph1EX:'graph1EX'}, function(data){
						var quantitiesEx = jQuery.parseJSON(data);
						quantitiesEx[0] = parseFloat(quantitiesEx[0]);
						quantitiesEx[1] = parseFloat(quantitiesEx[1]);
						quantitiesEx[2] = parseFloat(quantitiesEx[2]);
						setValues(quantitiesEx);
						$('#weightLoss').html(Math.round((quantitiesEx[0]-quantitiesEx[1])*100)/100);
						var perWeightLoss = Math.round(((quantitiesEx[0]-quantitiesEx[1])*100/quantitiesEx[0])*100)/100;
						$('#perWeightLoss').html(perWeightLoss);
						$('#reject').html(Math.round((quantitiesEx[1]-quantitiesEx[2])*100)/100);
						var perReject = Math.round(((quantitiesEx[1]-quantitiesEx[2])*100/quantitiesEx[1])*100)/100;
						$('#perReject').html(perReject);
						
					});
					$.post("modules/mod_totalStockViewer/getGraphData.php",{graph3EX:'graph3EX'}, function(data){
						var defectsArraySetEX = jQuery.parseJSON(data);
						var defectsArrayEX = new Array();
						for(var i=0;i<(defectsArraySetEX.length);i++){
							defectsArrayEX[i] = parseFloat(defectsArraySetEX[i]);
							defectsArrayEX[i] = Math.round(defectsArrayEX[i]*100)/100;
						}		
						setDefectData(defectsArrayEX);	
					});

					$.post("modules/mod_totalStockViewer/getGraphData.php",{graph2EX:'graph2EX'}, function(data){
						var result=jQuery.parseJSON(data);
				         setArrivalValues(result['pattern'],result['weeks'],result['stocks']);
					});	
			});

			$('#totalButton').click(function(){				
				$.post("modules/mod_totalStockViewer/getGraphData.php",{graph1Tot:'graph1Tot'}, function(data){
					var quantitiesTot = jQuery.parseJSON(data);
					quantitiesTot[0] = parseFloat(quantitiesTot[0]);
					quantitiesTot[1] = parseFloat(quantitiesTot[1]);
					quantitiesTot[2] = parseFloat(quantitiesTot[2]);
					setValues(quantitiesTot);
					$('#weightLoss').html(Math.round((quantitiesTot[0]-quantitiesTot[1])*100)/100);
					var perWeightLoss = Math.round(((quantitiesTot[0]-quantitiesTot[1])*100/quantitiesTot[0])*100)/100;
					$('#perWeightLoss').html(perWeightLoss);
					$('#reject').html(Math.round((quantitiesTot[1]-quantitiesTot[2])*100)/100);
					var perReject = Math.round(((quantitiesTot[1]-quantitiesTot[2])*100/quantitiesTot[1])*100)/100;
					$('#perReject').html(perReject);
					
				});

				$.post("modules/mod_totalStockViewer/getGraphData.php",{graph3Tot:'graph3Tot'}, function(data){
					
					var defectsArraySetTot = jQuery.parseJSON(data);
					var defectsArrayTot = new Array();
					for(var i=0;i<(defectsArraySetTot.length);i++){
						defectsArrayTot[i] = parseFloat(defectsArraySetTot[i]);
						defectsArrayTot[i] = Math.round(defectsArrayTot[i]*100)/100;
					}		
					setDefectData(defectsArrayTot);	
				});
				$.post("modules/mod_totalStockViewer/getGraphData.php",{graph2Tot:'graph2Tot'}, function(data){
					var result=jQuery.parseJSON(data);		
					
			        setArrivalValues(result['pattern'],result['weeks'],result['stocks']);
				});					
			});			
					
	});	

	function generateGraphs(){
		$.post("modules/mod_totalStockViewer/getGraphData.php",{graph1:'graph1'}, function(data){
			var quantities = jQuery.parseJSON(data);
			quantities[0] = parseFloat(quantities[0]);
			quantities[1] = parseFloat(quantities[1]);
			quantities[2] = parseFloat(quantities[2]);
			setValues(quantities);

			if(quantities[0] != 0){
				$('#weightLoss').html(Math.round((quantities[0]-quantities[1])*100)/100);
				var perWeightLoss = Math.round(((quantities[0]-quantities[1])*100/quantities[0])*100)/100;
				$('#perWeightLoss').html(perWeightLoss);
				$('#reject').html(Math.round((quantities[1]-quantities[2])*100)/100);
				var perReject = Math.round(((quantities[1]-quantities[2])*100/quantities[1])*100)/100;
				$('#perReject').html(perReject);
			}else{
				$('#weightLoss').html("");
				$('#perWeightLoss').html("");
				$('#reject').html("");
				$('#perReject').html("");
			}
		});

		$.post("modules/mod_totalStockViewer/getGraphData.php",{graph3:'graph3'}, function(data){	
	
			var defectsArraySet = data;//jQuery.parseJSON(data);
			var defectsArray = new Array();
			for(var i=0;i<(defectsArraySet.length);i++){
				defectsArray[i] = parseFloat(defectsArraySet[i]);
				defectsArray[i] = Math.round(defectsArray[i]*100)/100;
			}			
			setDefectData(defectsArray);			
		});

		$.post("modules/mod_totalStockViewer/getGraphData.php",{graph2:'graph2'}, function(data){
					 //alert(data);
					var result=data;//jQuery.parseJSON(data);

                    setArrivalValues(result['pattern'],result['weeks'],result['stocks']);
		});
	}
	
	function setValues(quantities){
		
		chart = new Highcharts.Chart({
			chart: {
				renderTo: 'graph1Total',
				events:{load:function(ev){$(document).resize();}},
				defaultSeriesType: 'column',marginRight: 0,
				marginBottom:40,
				width:900,
				height:360
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
					text: 'Quantity (Mt)'
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
						this.x +': '+ this.y +'kg';
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
				data:quantities
		
			
			}]
		});
		}

function setArrivalValues(arrivalValues,weeks,stocks){
		
		var chart;
		chart = new Highcharts.Chart({
			chart: {
				renderTo: 'graph2Total',
				events:{load:function(ev){$(document).resize();}},
				defaultSeriesType: 'line',
				marginRight: 0,
				marginBottom:30,
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
				categories:weeks
			},
			yAxis: {
				title: {
					text: 'Quantity (MT)'
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
						this.x +':<b> '+ this.y +'MT</b>';
				}
			},
			legend: {
				layout: 'horizontal',
				align: 'right',
				verticalAlign: 'top',
				x: 0,
				y: 0,
				borderWidth: 0
			},
			series: [{
				name: 'Estimated',
				data: arrivalValues
			}, {
				name: 'Actual',
				data:stocks
			}]
		});
		
	}

function setDefectData(defects){
	var chart;
	chart = new Highcharts.Chart({
		chart: {
			renderTo: 'graph3Total',
			events:{load:function(ev){$(document).resize();}},
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
				'Rust Patches',
				'Spoiled/Rotten',
				'>45mm Fruits'
				
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
			x:-60,
			y: 0,
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
			data: defects
		    		
		}, ]
	});
	

}

</script>	
	
	
	<?php 
		
	global $import;
	$import->importLib('season');
		
	?>
	

<div id="totalStockDiv">
	<h2 style="position: relative; left: 0px; background-color: #627AAD; width: 920px; text-align: center; color: #fff" > Total Stocks </h2>
	
	<div id="selectArea">		
			<input type="button" id="internalButton" value="Internal" />
			<input type="button" id="externalButton" value="External" />
			<input type="button" id="totalButton" value="Total" />	
								
	</div>
	
	<div id="graphAreaTotal">
	<hr style="border: 1px solid #666666; position: relative; top: -10px" />

	<h2 style="position: relative; left: 330px;">Arrival Pattern of Crops</h2>
	<div id="graph2Total">&nbsp;</div>
	<hr style="border: 1px solid #666666; margin-bottom: 20px" />
	<div style="z-index: 20000; width: 900px; margin: 0 auto 0 auto"
		id="graph1Total">&nbsp;</div>

	<table align="center" cellpadding='0' cellspacing='1'
		style="border-spacing: 0px; border:0px solid #666666;margin-top:5px;font-size: 12px">
		<tr height="20px">
			<td width="200px" class="tdClass head">Category Type</td>
			<td width="200px" class="tdClass head">Quantity</td>
			<td width="200px" class="tdClass head">Percentage</td>
		</tr>
		<tr height="20px">
			<td width="200px" class="tdClass" style="text-align: left;padding-left:10px"><b>Weight
					Loss</b></td>
			<td class="tdClass" id="weightLoss"></td>
			<td class="tdClass" id="perWeightLoss"></td>
		</tr>
		<tr height="20px">
			<td width="200px" class="tdClass" style="text-align: left;padding-left:10px"><b>Recjected</b>
			</td>
			<td class="tdClass" id="reject"></td>
			<td class="tdClass" id="perReject"></td>
		</tr>
	</table>
	<hr style="border: 1px solid #666666; margin-bottom: 20px" />
	<div style="z-index: 20000; width: 900px; margin: 0 auto 0 auto"
		id="graph3Total">&nbsp;</div>
</div>
</div>

