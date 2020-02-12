<?php 
defined("HEXEC") or die("Restrited Access.");
?>
<link rel="stylesheet" href="modules/mod_stockByDate/stockByDate.css"
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

var selectedSeason = "";

$('document').ready(function(){	
	getTable();	
	$.post("modules/mod_stockByDate/getGraphData.php",{getSeason : selectedSeason}, function(data){
				//selectedSeason = data;
				//console.log(selectedSeason);
				//$('#season').val(selectedSeason);

		});
	$(document).on('click','.list-trigger',function(){
		
		$('#project').val($(this).data('aname'));
		$('#project-hidden-id').val($(this).data('id'));
		$('#showSug').fadeOut('fast');
		$('#grade').val($(this).data('date'));

		getTable();
		});
	

	
	$('#season').change(function(){
			selectedSeason = $('#season').val();
		});
	
	$('#startDate').datepicker({dateFormat: 'yy-mm-dd',maxDate:'<?php print $date?>',onSelect: getTable});
	$('#endDate').datepicker({dateFormat: 'yy-mm-dd',maxDate:'<?php print $date?>',onSelect: getTable});

	existData1 = $('#dataTable').html();
	existData2 = $('#dataTable2').html();

	existData1Print = $('#dataTablePrint').html();
	existData2Print = $('#dataTable2Print').html();

	$('#project').keyup(function(){
		//$('#showSug').fadeOut('slow');
		var project = $('#project').val();
		
		if(project != ""){
		$.post("modules/mod_stockByDate/getGraphData.php", {projectName : project,seasonId : selectedSeason},function(data){
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
			getTable();
		});	
	
	$('#grade').change(function(){
		getTable();
	});	

	$('#printButton').click(function(){	
		clickHereToPprint();
		
	});		

});

function clickHereToPprint()
{ 
  var disp_setting="toolbar=yes,location=no,directories=yes,menubar=yes,"; 
      disp_setting+="scrollbars=yes,width=1112, height=790, left=100, top=25"; 
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

function showAlert(proId,gradeCategory,proName){	
	$('#project').val(proName);
	$('#project-hidden-id').val(proId);
	$('#showSug').fadeOut('fast');
	$('#grade').val(gradeCategory);

	getTable();
	
}

function getTable(){
		if($('#project').val() != ""){
			var project = $('#project-hidden-id').val();	
		}else{
			var project = "";	
		}
	
		var firstDate = $('#startDate').val();
		var endDate = $('#endDate').val();
		var season = $('#season').val();
		
		var stationId = $('#stationId').val();
		var grade = $('#grade').val();	
		selectedSeason = season;
				
			$('#waiting-div').show();
			$.post("modules/mod_stockByDate/getGraphData.php",{season : season,stationId:stationId,grade:grade ,project: project, firstDate:firstDate,endDate : endDate}, function(data){
				if(data != ""){
				var tables = data.split("*");

				var resp = new Array;
				resp[0] = "";
				resp[1] = "";
				
				for(var i=0;i<tables.length-1;i++){
					var respNew = tables[i].split(";");					

					resp[0] += respNew[0];
					resp[1] += respNew[1]; 					
				}

				$('#dataTable').html(existData1 + resp[0]);
				$('#dataTable2').html(existData2 + resp[1]);
		
				$.post("modules/mod_stockByDate/GetSeason.php",{printSeason:selectedSeason},function(data){
					$('#seasonPrint').html(" : "+data);
				});
				if(project != ""){
				$('#projectPrint').html(" : "+ $('#project').val());
				}else{
				$('#projectPrint').html(" : All");
				}
				$('#periodPrint').html(" : "+firstDate + " : " + endDate);

				$('#submitmsg').fadeOut('fast');	
				$('#showDiv').fadeIn('fast');
				$('#showDiv').html(existData1 + resp[0] + "<tr style='background-color:#808080'><td></td><td></td><td><b>Total</b></td><td>"+getValues(3) +"</td><td>"+getValues(4)+"</td><td>"+getValues(5)+"</td><td>"+getValues(6)+"</td><td>"+getValues(7)+"</td><td>"+getValues(8)+"</td><td>"+getValues(9)+"</td><td>"+getValues(10)+"</td><td>"+getValues(11)+"</td></tr> <tr style='background-color: #fff'></tr>" + existData2 + resp[1]+"<tr style='background-color:#808080'><td></td><td></td><td><b>Total</b></td><td>"+getValues2(3)+"</td><td>"+getValues2(4)+"</td><td>"+getValues2(5)+"</td><td>"+getValues2(6)+"</td><td>"+getValues2(7)+"</td><td>"+getValues2(8)+"</td><td>"+getValues2(9)+"</td><td>"+getValues2(10)+"</td><td>"+getValues2(11)+"</td></tr>" );
				$('#printDivArea').html(existData1Print + resp[0] + "<tr style='text-align:center'><td></td><td></td><td><b>Total</b></td><td>"+ getValues(3)+"</td><td>"+getValues(4)+"</td><td>"+getValues(5)+"</td><td>"+getValues(6)+"</td><td>"+getValues(7)+"</td><td>"+getValues(8)+"</td><td>"+getValues(9)+"</td><td>"+getValues(10)+"</td><td>"+getValues(11)+"</td></tr><tr style='background-color: #fff; height: 10px'></tr>" + existData2Print + resp[1] + "<tr style='text-align:center' ><td></td><td></td><td><b>Total</b></td><td>"+getValues2(3)+"</td><td>"+getValues2(4)+"</td><td>"+getValues2(5)+"</td><td>"+getValues2(6)+"</td><td>"+getValues2(7)+"</td><td>"+getValues2(8)+"</td><td>"+getValues2(9)+"</td><td>"+getValues2(10)+"</td><td>"+getValues2(11)+"</td></tr>" );
				$('#printArea').fadeIn('fast');
					
				setGrades();	
				setData();
				setData2();
				setData3();		
				}else{
				$('#submitmsg').fadeIn('fast');	
				$('#showDiv').fadeOut('fast');
				$('#printArea').fadeOut('fast');
				}
				$('#waiting-div').hide();
			});			
}

function setGrades(){
	var grade = $('#grade').val();

	$.post("modules/mod_stockByDate/getGraphData.php",{gradeCat : grade}, function(data){
		
		var grades = jQuery.parseJSON(data);
			for(var i=0;i<grades.length;i++){				
				$('.gr'+(i+1)).html(grades[i]);

				if(grades.length < 4){
					$('.gr4').html("");
				}
			}
		});	
}

function getValues(cell){
	var result=0;
    var tableElem = window.document.getElementById("dataTable"); 
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
	var resultNew =  result.toFixed(2);  //Math.round(result/100)*100;    
    
	if(resultNew != 0){  
	    return resultNew;
	}else{
		return "";
	}
	
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
	var resultNew =  result.toFixed(2);  //Math.round(result/100)*100;  

	if(resultNew != 0){  
    return resultNew;
	}else{
	return "";
	}
	
}

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
			   		       
		       var thisTrElem2 = tableElem2.rows[i+1];
		       var thisTdElem3 = thisTrElem2.cells[5];			
		       var thisTextNode3 = thisTdElem3.childNodes.item(0);

		       var thisTdElem4 = thisTrElem2.cells[9];		
		       var thisTextNode4 = thisTdElem4.childNodes.item(0);
			   		       
		       var thisNumber = 0;
		       var thisNumber2 = 0;
		       var thisNumber3 = 0;
		       var thisNumber4 = 0;
		      		       
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
		       
		       if (!isNaN(thisNumber) && !isNaN(thisNumber2) && !isNaN(thisNumber3) && !isNaN(thisNumber4))
		         result += thisNumber + thisNumber2 + thisNumber3 + thisNumber4;
		        
			 } // end for

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
			 
		       var thisTrElem2 = tableElem2.rows[i+1];
		       var thisTdElem3 = thisTrElem2.cells[6];			
		       var thisTextNode3 = thisTdElem3.childNodes.item(0);

		       var thisTdElem4 = thisTrElem2.cells[10];		
		       var thisTextNode4 = thisTdElem4.childNodes.item(0);
			   		       
		       var thisNumber = 0;
		       var thisNumber2 = 0;
		       var thisNumber3 = 0;
		       var thisNumber4 = 0;
		      		       
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
		       
		       if (!isNaN(thisNumber) && !isNaN(thisNumber2) && !isNaN(thisNumber3) && !isNaN(thisNumber4))
		         result += thisNumber + thisNumber2 + thisNumber3 + thisNumber4;
		        
			 } // end for
			 
			 //result = Math.round(result/100)*100;
			 var resultNew = result.toFixed(2);	
		    $('.tRQ').html(" : "+ resultNew);		
		 				
}


function setData3(){
	var debugScript = true;
		  
		  var result = 0;
		  result = parseFloat(result);
			  
		    var tableElem = window.document.getElementById("dataTable"); 
		    var tableElem2 = window.document.getElementById("dataTable2");		   
		    var tableBody = tableElem.getElementsByTagName("tbody").item(0);
		    var i;
		    var howManyRows = tableElem.rows.length;
						
		    for (i=2; i<(howManyRows); i++) // skip first and last row (hence i=1, and howManyRows-1)
		    {
		       var thisTrElem = tableElem.rows[i];
		       var thisTdElem = thisTrElem.cells[7];			
		       var thisTextNode = thisTdElem.childNodes.item(0);

		       var thisTdElem2 = thisTrElem.cells[11];		
		       var thisTextNode2 = thisTdElem2.childNodes.item(0);
		       var thisTrElem2 = tableElem2.rows[i];
		       var thisTdElem3 = thisTrElem2.cells[7];			
		       var thisTextNode3 = thisTdElem3.childNodes.item(0);

		       var thisTdElem4 = thisTrElem2.cells[11];		
		       var thisTextNode4 = thisTdElem4.childNodes.item(0);
			   		       
		       var thisNumber = 0;
		       var thisNumber2 = 0;
		       var thisNumber3 = 0;
		       var thisNumber4 = 0;
		      		       
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
		       
		       if (!isNaN(thisNumber) && !isNaN(thisNumber2) && !isNaN(thisNumber3) && !isNaN(thisNumber4))
		         result += thisNumber + thisNumber2 + thisNumber3 + thisNumber4;
		         		        
			 } // end for

			 //result = parseFloat(result);
			 //result = Math.round(result/100)*100;
				 
			var resultNew = result.toFixed(2);	
		    $('.tPQ').html(" : "+ resultNew);
		
		 				
}


</script>
	
	
<div id="showSug"></div>
<div id="outerDiv">
	<h3>Stocks by Date</h3>
	<div id="selectTable">
		Season : <select id="season">		
		<?php 
		foreach ($season as $s){ var_dump($s);
			$selected = (int)$s['flag'] == 1 ? 'selected' : '';
			echo '<option value="'.$s['seasonId'].'" '.$selected.'>'.$s['seasonName'].'</option>';
		}		
		?>
		</select>
		Station : <select
			id="stationId">
			<option value="1">HJS</option>
			<option value="2">Alawwa</option>
			<option value="3">Padiyathalawa</option>
			<option value="Total">Total</option>
		</select> 
		Project : <input type="text" id="project" autocomplete="off" />
		<input type="hidden" id="project-hidden-id" />
		 Grade : <select
			id="grade" style="width: 100px" >
			<?php
			$db = new HDatabase();
			$db->connect();
			$db->select('qa_gradeCategory',"*");
			$result = $db->getResult();

			foreach ($result as $r){
				$catName = $r['name'];
				$catId = $r['id'];
				if($catName != "Small"){
					echo '<option value="'.$catId.'">'.$catName.'</option>';
				}
			}

			?>


		</select> from : <input type="text" id="startDate"
			value="<?php echo $date;?>" style="width: 90px;" />
		<div style="position: relative; left: 796px">
			to : <input type="text" id="endDate" value="<?php echo $date;?>"
				style="width: 90px" />
		</div>
	</div>

	<hr />
	<div id="tableDiv">

		<table id="dataTable">

			<tr
				style="background-color: #627AAD; color: #fff; font-weight: bold;">
				<td rowspan="2">Date</td>
				<td rowspan="2">Center</td>
				<td rowspan="2">TMNo</td>
				<td rowspan="2">Total DQ</td>
				<td rowspan="1" colspan="4" class="gr1"></td>
				<td rowspan="1" colspan="4" class="gr2"></td>
			</tr>

			<tr
				style="background-color: #627AAD; color: #fff; font-weight: bold;">
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
				<td rowspan="1" colspan="4" class="gr3"></td>
				<td rowspan="1" colspan="4" class="gr4"></td>
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
	<table id="showDiv">
	</table>
	<table width="350"
		style="margin-left: 100px; font-weight: bold; margin-bottom: 30px">
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
	<div id="submitmsg" class="ui-state-highlight ui-corner-all" style="margin-top: 10px;margin-bottom:5px; padding:5px;display: none;position: relative;">
		<span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;margin-top:1px"></span>
		No Stocks</div>

	<div id="printArea">
		<input type="button" value="Print the report" id="printButton">
	</div>

</div>



<div id="printDiv" style="position: absolute; display: none">

	<p
		style="text-align: center; font-weight: bold; top: 20px; text-decoration: underline;">BASE
		DOCUMENT FOR GRN</p>
	<table width="300"
		style="margin-left: 100px; font-weight: bold; margin-bottom: 30px">
		<tr>
			<td>Season</td>
			<td id="seasonPrint"></td>
		</tr>
		<tr>
			<td>Project</td>
			<td id="projectPrint"></td>
		</tr>
		<tr>
			<td>Period</td>
			<td id="periodPrint"></td>
		</tr>
		<tr>
			<td>Product</td>
			<td>: Gherkins Fresh</td>
		</tr>
		<tr>
			<td>GRN no</td>
			<td>: </td>
		</tr>

	</table>

	<table id="printDivArea" border="1" cellpadding="0" cellspacing="0"
		width="1040" style="margin-bottom: 30px"></table>

	<table width="350"
		style="margin-left: 100px; font-weight: bold; margin-bottom: 30px">
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
			<td>Total Value</td>
			<td>:</td>
		</tr>
	</table>

	<table id="signTable"
		style="width: 700px; position: relative; left: 200px; text-align: center; top: 20px">
		<tr>
			<td>.................................</td>
			<td>.................................</td>

		</tr>
		<tr>
			<td>Executive's Signature <br /> Checked by</td>
			<td>Factory Manager's Signature</td>

		</tr>
	</table>

</div>
<table id="dataTablePrint" border="1" cellpadding="0" cellspacing="0"
	width="1040" style="display: none">

	<tr style="font-weight: bold; font-size: 14px; text-align: center">
		<td rowspan="2" width="400px">Date</td>
		<td rowspan="2" width="400px">Center</td>
		<td rowspan="2" width="400px">TMNo</td>
		<td rowspan="2" width="400px">Total DQ</td>
		<td rowspan="1" colspan="4" class="gr1" width="400px">No.3</td>
		<td rowspan="1" colspan="4" class="gr2" width="400px">No.4</td>
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
<hr />
<table id="dataTable2Print" border="1" cellpadding="0" cellspacing="0"
	width="1040" style="display: none">

	<tr style="font-weight: bold; font-size: 14px; text-align: center">
		<td rowspan="2" width="400px">Date</td>
		<td rowspan="2" width="400px">Center</td>
		<td rowspan="2" width="400px">TMNo</td>
		<td rowspan="2" width="400px">Total DQ</td>
		<td rowspan="1" colspan="4" class="gr3" width="400px">N0.2</td>
		<td rowspan="1" colspan="4" class="gr4" width="400px">CRS</td>
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
