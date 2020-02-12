<?php 
defined("HEXEC") or die("Restrited Access.");
?>
<link rel="stylesheet"
	href="modules/mod_stockByDateSmall/css/stockByDateSmall.css"
	type="text/css" />

<?php
global $import;
$import->importLib('season');
$seasons = new Season();
$season = $seasons->getSeasons();

?>

<script type="text/javascript">
<?php $date=date("Y-m-d"); 
require_once 'includes/HDatabase.php';

?>
var existData1="";
var existData2="";

var existData1Print="";
var existData2Print="";

var sign;
var selectedSeason = "";

var projectName = "";

$(document).ready(function(){
	getGraphData();

	$.post("modules/mod_stockByDateSmall/getGraphDataSmall.php",{getSeason : selectedSeason}, function(data){
		selectedSeason = data;
		$('#season').val(selectedSeason);
	});
	
	$('#season').change(function(){
		selectedSeason = $('#season').val();
	});
	
	$('#startDate').datepicker({dateFormat: 'yy-mm-dd',maxDate:'<?php print $date?>',onSelect: getGraphData});
	$('#endDate').datepicker({dateFormat: 'yy-mm-dd',maxDate:'<?php print $date?>',onSelect: getGraphData});

	existData1 = $('#dataTable').html();
	existData2 = $('#dataTable2').html();

	existData1Print = $('#dataTablePrint').html();
	existData2Print = $('#dataTable2Print').html();

	sign = $('#signTable').html();
	
		
$('#project').keyup(function(){
	//$('#showSug').fadeOut('fast');
	var project = $('#project').val();
		
	if(project != ""){
	$.post("modules/mod_stockByDateSmall/getGraphDataSmall.php", {project : project , seasonId : selectedSeason},function(data){
		//alert(data);
		$('#showSug').html(data);
		$('#showSug').fadeIn('fast');
			 
		});
	}else{
		$('#showSug').fadeOut('fast');
	}
});

$('#project').blur(function(){
	$('#showSug').fadeOut('fast');
});

$('#stationId').change(function(){
	getGraphData();

});

$('#printButton').click(function(){
	clickHereToPprint();
	
});	

});

function showAlert(proId,proName){		
	$('#project').val(proName);
	$('#project-hidden-id').val(proId);
	$('#showSug').fadeOut('fast');

	projectName = proName;
	getGraphData();		
}

function clickHereToPprint()
{
	var disp_setting="toolbar=yes,location=no,directories=yes,menubar=yes,";
	disp_setting +="scrollbars=yes,width=1112, height=790, left=100, top=25";
	var content_vlue = document.getElementById("printDiv").innerHTML;

	var docprint=window.open("","",disp_setting);
	docprint.document.open();
	docprint.document.write('<link rel="stylesheet" href="css/insertionData.css" type="text/css">');
	docprint.document.write('<body onLoad="self.print()">');
	docprint.document.write(content_vlue);
	docprint.document.write('</body>');
	docprint.document.close();
	docprint.focus();

}


function getGraphData(){
	if($('#project').val() != "")
	{
		var project = $('#project-hidden-id').val();
	}else
	{
		var project = "";
		$('#project-hidden-id').val("");
	}	
	
	var firstDate = $('#startDate').val();
	var endDate = $('#endDate').val();
	var season = $('#season').val();	
	var stationId = $('#stationId').val();	
	var printProject = "";
	var period = firstDate + " : " + endDate;
	var printSeason =""; 
	
	if(project == ""){
		printProject = "All";
	}else{
		printProject = projectName;
	}
	var seasonName = $("#season option:selected").text();
	
	$.post("modules/mod_stockByDateSmall/getGraphDataSmall.php", {season : season,stationId:stationId,projectData: project, firstDate:firstDate,endDate : endDate},function(data){
		//alert(data);
		if(data.trim() != "0"){
				var tableData = data.split(";");
				$('#tableDiv').fadeIn('fast');
				$('#totalData').fadeIn('fast');

				var table1 = existData1 + tableData[0] + '<tr style="background-color:#808080">';
				var table2 = existData2 + tableData[1] + '<tr style="background-color:#808080">';
				
				var td ="";
				var td2 = "";
				
				for(var i=0;i<16;i++){
					  td += '<td class="raw'+i+'"></td>'; 
				}

				for(var i=0;i<12;i++){
					  td2 += '<td class="raw2'+i+'"></td>'; 
				}
				
				table1 += td + '</tr>';
				table2 += td2 + '</tr>';
				
				$('#dataTable').html(table1);
				$('#dataTable2').html(table2);			
				
				$('#dataTablePrint').html(existData1Print + tableData[0] + '<tr style="text-align:center">' + td + '</tr>');
				$('#dataTable2Print').html(existData2Print + tableData[1] + '<tr style="text-align:center">' + td2 + '</tr>');

				for(var i=3;i<16;i++){
					  $('.raw' + i).html(getValues(i)); 
				}
				for(var i=3;i<12;i++){
					  $('.raw2' + i).html(getValues2(i)); 
				}

				$('.raw2').html("<b>Total</b>");
				$('.raw22').html("<b>Total</b>");
				
				$('#printArea').fadeIn('fast');
				$('#submitmsg').fadeOut('fast');
				
				//alert($('#dataTable').html());
				$('#printDiv').html('<p id="headerName"	style="text-align: center; font-weight: bold; top: 20px; text-decoration: underline;">BASE DOCUMENT FOR GRN</p>'
						+ '<table>'
						+'<tr><td>Season </td><td id="seasonPrint"> : '+seasonName +'</td></tr>'
						+'<tr><td>Project</td><td id="projectPrint"> : '+printProject+'</td></tr>'
						+'<tr><td>Peroid</td><td id="periodPrint"> : '+period+'</td></tr>'
						+'<tr><td>Product</td><td id="productPrint"> : Gherkins Fresh</td></tr>'
						+'<tr><td>GRN No</td><td id="grnPrint"> : </td></tr>'
						+'</table>'
						 + '<table id="dataTablePrint" border="1" cellpadding="0" cellspacing="0"'
						+'width="1040" style="display: block;margin-top:20px">'+ $('#dataTablePrint').html()						
						+'</table>'
						+ '<hr style="height:2px";margin-top:5px; margin-bottom:5px />'
						+ '<table id="dataTable2Print" border="1" cellpadding="0" cellspacing="0"'
						+'width="1040" style="display: block">'+ $('#dataTable2Print').html()+'</table>'
						 + sign );

				 setData();
				 setData2();
				 setData3();
								
			}else{				
				$('#printArea').fadeOut('fast');
				$('#tableDiv').fadeOut('fast');
				$('#totalData').fadeOut('fast');
				$('#submitmsg').fadeIn('fast');
			}
	});
	
}

function getValues(cell){
	
	var result=0;
    var tableElem = window.document.getElementById("dataTable"); 
    var howManyRows = tableElem.rows.length;
  
    for (i=1; i<(howManyRows-1); i++) 
    {
    var thisTrElem = tableElem.rows[i+1];
    var thisTdElem = thisTrElem.cells[cell];			
    var thisTextNode = thisTdElem.childNodes.item(0);

    var thisNumber =0;
    
    if(thisTextNode != null){
	       thisNumber = parseFloat(thisTextNode.data);
	}

	result += thisNumber;
   
    }
    
	var resultNew =  result.toFixed(2); 
    
	return resultNew;
	
}

function getValues2(cell){
	var result=0;
    var tableElem = window.document.getElementById("dataTable2"); 
    var howManyRows = tableElem.rows.length;
	
    for (i=1; i<(howManyRows-1); i++) // skip first and last row (hence i=1, and howManyRows-1)
    {
    var thisTrElem = tableElem.rows[i+1];
    var thisTdElem = thisTrElem.cells[cell];			
    var thisTextNode = thisTdElem.childNodes.item(0);

    var thisNumber =0;
    
    if(thisTextNode != null){
	       thisNumber = parseFloat(thisTextNode.data);
	}

	result += thisNumber;
    
    }
	var resultNew =  result.toFixed(2);  
    return resultNew;
	
}

// setting total values in print view

function setData(){
	var debugScript = true;
		  
		  var result = 0;
			  
		    var tableElem = window.document.getElementById("dataTable"); 
		    var tableElem2 = window.document.getElementById("dataTable2");		   
		    var tableBody = tableElem.getElementsByTagName("tbody").item(0);
		    var i;
		    var howManyRows = tableElem.rows.length;
			
		    for (i=1; i<(howManyRows-1); i++) // skip first and last row (hence i=1, and howManyRows-1)
		    {
		       var thisTrElem = tableElem.rows[i+1];
		       var thisTdElem = thisTrElem.cells[5];			
		       var thisTextNode = thisTdElem.childNodes.item(0);

		       var thisTdElem2 = thisTrElem.cells[9];		
		       var thisTextNode2 = thisTdElem2.childNodes.item(0);

		       var thisTdElem5 = thisTrElem.cells[13];		
		       var thisTextNode5 = thisTdElem5.childNodes.item(0);
			   		       
		       var thisTrElem2 = tableElem2.rows[i+1];
		       var thisTdElem3 = thisTrElem2.cells[5];			
		       var thisTextNode3 = thisTdElem3.childNodes.item(0);

		       var thisTdElem4 = thisTrElem2.cells[9];		
		       var thisTextNode4 = thisTdElem4.childNodes.item(0);
			   		       
		       var thisNumber = 0;
		       var thisNumber2 = 0;
		       var thisNumber3 = 0;
		       var thisNumber4 = 0;
		       var thisNumber5 = 0;
		      		       
		       if(thisTextNode != null){
		       thisNumber = parseFloat(thisTextNode.data);
		       }
		       if(thisTextNode2 != null){
		       thisNumber2 = parseFloat(thisTextNode2.data);
		       }
		       if(thisTextNode3 != null){
			       thisNumber3 = parseFloat(thisTextNode3.data);
			   }
			   if(thisTextNode4 != null){
			       thisNumber4 = parseFloat(thisTextNode4.data);
			   }
			   if(thisTextNode5 != null){
			       thisNumber5 = parseFloat(thisTextNode5.data);
			   }
		       
		        
			 } // end for

			 if (!isNaN(thisNumber) && !isNaN(thisNumber2) && !isNaN(thisNumber3) && !isNaN(thisNumber4) && !isNaN(thisNumber5))
		         result += thisNumber + thisNumber2 + thisNumber3 + thisNumber4 + thisNumber5;
		
				//result = Math.round(result/100)*100;
			var resultNew = result.toFixed(2);	
			$('.tAQ').html(" : "+ resultNew);		
		 				
}

function setData2(){
	var debugScript = true;
		  
		  var result = 0;
			  
		    var tableElem = window.document.getElementById("dataTable"); 
		    var tableElem2 = window.document.getElementById("dataTable2");		   
		    var tableBody = tableElem.getElementsByTagName("tbody").item(0);
		    var i;
		    var howManyRows = tableElem.rows.length;
			
		    for (i=1; i<(howManyRows-1); i++) // skip first and last row (hence i=1, and howManyRows-1)
		    {
		       var thisTrElem = tableElem.rows[i+1];
		       var thisTdElem = thisTrElem.cells[6];			
		       var thisTextNode = thisTdElem.childNodes.item(0);

		       var thisTdElem2 = thisTrElem.cells[10];		
		       var thisTextNode2 = thisTdElem2.childNodes.item(0);

		       var thisTdElem5 = thisTrElem.cells[14];		
		       var thisTextNode5 = thisTdElem5.childNodes.item(0);
			   		       
		       var thisTrElem2 = tableElem2.rows[i+1];
		       var thisTdElem3 = thisTrElem2.cells[6];			
		       var thisTextNode3 = thisTdElem3.childNodes.item(0);

		       var thisTdElem4 = thisTrElem2.cells[10];		
		       var thisTextNode4 = thisTdElem4.childNodes.item(0);
			   		       
		       var thisNumber = 0;
		       var thisNumber2 = 0;
		       var thisNumber3 = 0;
		       var thisNumber4 = 0;
		       var thisNumber5 = 0;
		      		       
		       if(thisTextNode != null){
		       thisNumber = parseFloat(thisTextNode.data);
		       }
		       if(thisTextNode2 != null){
		       thisNumber2 = parseFloat(thisTextNode2.data);
		       }
		       if(thisTextNode3 != null){
			       thisNumber3 = parseFloat(thisTextNode3.data);
			   }
			   if(thisTextNode4 != null){
			       thisNumber4 = parseFloat(thisTextNode4.data);
			   }
			   if(thisTextNode5 != null){
			       thisNumber5 = parseFloat(thisTextNode5.data);
			   }
		       
		        
			 } // end for

			 if (!isNaN(thisNumber) && !isNaN(thisNumber2) && !isNaN(thisNumber3) && !isNaN(thisNumber4) && !isNaN(thisNumber5))
		         result += thisNumber + thisNumber2 + thisNumber3 + thisNumber4 + thisNumber5;
		
				//result = Math.round(result/100)*100;
			var resultNew = result.toFixed(2);	
			$('.tRQ').html(" : "+ resultNew);		
		 				
}

function setData3(){
	var debugScript = true;
		  
		  var result = 0;
			  
		    var tableElem = window.document.getElementById("dataTable"); 
		    var tableElem2 = window.document.getElementById("dataTable2");		   
		    var tableBody = tableElem.getElementsByTagName("tbody").item(0);
		    var i;
		    var howManyRows = tableElem.rows.length;
			
		    for (i=1; i<(howManyRows-1); i++) // skip first and last row (hence i=1, and howManyRows-1)
		    {
		       var thisTrElem = tableElem.rows[i+1];
		       var thisTdElem = thisTrElem.cells[7];			
		       var thisTextNode = thisTdElem.childNodes.item(0);

		       var thisTdElem2 = thisTrElem.cells[11];		
		       var thisTextNode2 = thisTdElem2.childNodes.item(0);

		       var thisTdElem5 = thisTrElem.cells[15];		
		       var thisTextNode5 = thisTdElem5.childNodes.item(0);
			   		       
		       var thisTrElem2 = tableElem2.rows[i+1];
		       var thisTdElem3 = thisTrElem2.cells[7];			
		       var thisTextNode3 = thisTdElem3.childNodes.item(0);

		       var thisTdElem4 = thisTrElem2.cells[11];		
		       var thisTextNode4 = thisTdElem4.childNodes.item(0);
			   		       
		       var thisNumber = 0;
		       var thisNumber2 = 0;
		       var thisNumber3 = 0;
		       var thisNumber4 = 0;
		       var thisNumber5 = 0;
		      		       
		       if(thisTextNode != null){
		       thisNumber = parseFloat(thisTextNode.data);
		       }
		       if(thisTextNode2 != null){
		       thisNumber2 = parseFloat(thisTextNode2.data);
		       }
		       if(thisTextNode3 != null){
			       thisNumber3 = parseFloat(thisTextNode3.data);
			   }
			   if(thisTextNode4 != null){
			       thisNumber4 = parseFloat(thisTextNode4.data);
			   }
			   if(thisTextNode5 != null){
			       thisNumber5 = parseFloat(thisTextNode5.data);
			   }
		       
		        
			 } // end for

			 if (!isNaN(thisNumber) && !isNaN(thisNumber2) && !isNaN(thisNumber3) && !isNaN(thisNumber4) && !isNaN(thisNumber5))
		         result += thisNumber + thisNumber2 + thisNumber3 + thisNumber4 + thisNumber5;
		
				//result = Math.round(result/100)*100;
			var resultNew = result.toFixed(2);	
			$('.tPQ').html(" : "+ resultNew);		
		 				
}









</script>

<div id="showSug"></div>

<div id="outerDiv">
<h3>Stocks by Date</h3>

<div id="selectTable">Season : <select id="season">
	
	<?php
	foreach ($season as $s){
		print "<option value='".$s['seasonId']."'>".$s['seasonName']."</option>";
			
	}

	?>

</select> Station : <select id="stationId">
	<option value="1">HJS</option>
	<option value="2">Alawwa</option>
	<option value="3">Padiyathalawa</option>
	<option value="Total">Total</option>
</select> Project : <input type="text" id="project" /> from : <input
	type="text" id="startDate" value="<?php echo $date;?>"
	style="width: 90px;" />
	<input type="hidden" id="project-hidden-id" />
	
<div style="position: relative; left: 796px; top: -30px">to : <input
	type="text" id="endDate" value="<?php echo $date;?>"
	style="width: 90px" /></div>
</div>

<hr />
<div id="tableDiv">

<table id="dataTable">

	<tr style="background-color: #627AAD; color: #fff; font-weight: bold;">
		<td rowspan="2">Date</td>
		<td rowspan="2">Center</td>
		<td rowspan="2">TMNo</td>
		<td rowspan="2">Total DQ</td>
		<td rowspan="1" colspan="4" class="gr1">11-14</td>
		<td rowspan="1" colspan="4" class="gr2">14-17</td>
		<td rowspan="1" colspan="4" class="gr3">17-29</td>
	</tr>

	<tr style="background-color: #627AAD; color: #fff; font-weight: bold;">
		<td>DQ</td>
		<td>AQ</td>
		<td>RQ</td>
		<td>PQ</td>

		<td>DQ</td>
		<td>AQ</td>
		<td>RQ</td>
		<td>PQ</td>

		<td>DQ</td>
		<td>AQ</td>
		<td>RQ</td>
		<td>PQ</td>

	</tr>

</table>
<hr />
<table id="dataTable2">

	<tr style="background-color: #627AAD; color: #fff; font-weight: bold;">
		<td rowspan="2">Date</td>
		<td rowspan="2">Center</td>
		<td rowspan="2">TMNo</td>
		<td rowspan="2">Total DQ</td>
		<td rowspan="1" colspan="4" class="gr4">29-44</td>
		<td rowspan="1" colspan="4" class="gr5">CRS</td>
	</tr>

	<tr style="background-color: #627AAD; color: #fff; font-weight: bold;">
		<td>DQ</td>
		<td>AQ</td>
		<td>RQ</td>
		<td>PQ</td>

		<td>DQ</td>
		<td>AQ</td>
		<td>RQ</td>
		<td>PQ</td>

	</tr>

</table>
</div>
<div id="totalData">
<table style="width: 300px">
	<tr>
		<td>Total AQ</td>
		<td class="tAQ"></td>
	</tr>
	<tr>
		<td>Total RQ</td>
		<td class="tRQ"></td>
	</tr>

	<tr>
		<td>Total PQ</td>
		<td class="tPQ"></td>
	</tr>
</table>

</div>

<div id="printArea"><input type="button" value="Print the report"
	id="printButton"></div>
<table id="showDiv">
</table>
<div id="submitmsg" class="ui-state-highlight ui-corner-all"
	style="margin-top: 10px; margin-bottom: 5px; padding: 5px; display: none; position: relative;">
<span class="ui-icon ui-icon-info"
	style="float: left; margin-right: .3em; margin-top: 1px"></span> No
Stocks</div>

</div>

<table id="dataTablePrint" border="1" cellpadding="0" cellspacing="0"
	width="1040" style="display: none">

	<tr style="font-weight: bold; font-size: 14px; text-align: center">
		<td rowspan="2" width="400px">Date</td>
		<td rowspan="2" width="400px">Center</td>
		<td rowspan="2" width="400px">TMNo</td>
		<td rowspan="2" width="400px">Total DQ</td>
		<td rowspan="1" colspan="4" class="gr1" width="400px">11-14</td>
		<td rowspan="1" colspan="4" class="gr2" width="400px">14-17</td>
		<td rowspan="1" colspan="4" class="gr3" width="400px">17-29</td>
	</tr>

	<tr style="font-weight: bold; font-size: 14px; text-align: center">
		<td width="400px">DQ</td>
		<td width="400px">AQ</td>
		<td width="400px">RQ</td>
		<td width="400px">PQ</td>

		<td width="400px">DQ</td>
		<td width="400px">AQ</td>
		<td width="400px">RQ</td>
		<td width="400px">PQ</td>

		<td width="400px">DQ</td>
		<td width="400px">AQ</td>
		<td width="400px">RQ</td>
		<td width="400px">PQ</td>

	</tr>

</table>
<hr />
<table id="dataTable2Print" border="1" cellpadding="0" cellspacing="0"
	width="1040" style="display: none">

	<tr style="font-weight: bold; font-size: 14px; text-align: center">
		<td rowspan="2" width="400px">Date</td>
		<td rowspan="2" width="400px">Center</td>
		<td rowspan="2" width="400px">TMNo</td>
		<td rowspan="2" width="400px">Total DQ</td>
		<td rowspan="1" colspan="4" class="gr4" width="400px">29-44</td>
		<td rowspan="1" colspan="4" class="gr5" width="400px">CRS</td>
	</tr>

	<tr style="font-weight: bold; font-size: 14px; text-align: center">
		<td width="400px">DQ</td>
		<td width="400px">AQ</td>
		<td width="400px">RQ</td>
		<td width="400px">PQ</td>

		<td width="400px">DQ</td>
		<td width="400px">AQ</td>
		<td width="400px">RQ</td>
		<td width="400px">PQ</td>

	</tr>

</table>



<div id="printDiv" style="display: none;">

<div id="signTable">

<div id="totTable" style="position: relative; top: 20px; left: 200px">
<table style="width: 300px">
	<tr>
		<td>Total AQ</td>
		<td class="tAQ"></td>
	</tr>
	<tr>
		<td>Total RQ</td>
		<td class="tRQ"></td>
	</tr>

	<tr>
		<td>Total PQ</td>
		<td class="tPQ"></td>
	</tr>

	<tr>
		<td>Total value</td>
		<td></td>
	</tr>

</table>

</div>


<table
	style="width: 700px; position: relative; left: 200px; text-align: center; top: 50px; margin-bottom: 50px">
	<tr>
		<td>.................................</td>
		<td>.................................</td>

	</tr>
	<tr>
		<td>Executive's Signature <br />
		Checked by</td>
		<td>Factory Manager's Signature</td>

	</tr>
</table>
</div>

</div>
