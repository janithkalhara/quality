<?php 
defined("HEXEC") or die("Restrited Access.");
?>
<?php 
global $mainframe;
	$mainframe->setTitle("Stock Viewer(Small) ");

global $import;
$import->importLib('season');
$seasons = new Season();
$season = $seasons->getSeasons();

?>
<script type="text/javascript" src="libraries/fancyboxv2/jquery.fancybox.js"></script>
<link rel="stylesheet" type="text/css" href="libraries/fancyboxv2/jquery.fancybox.css" media="screen" />
<script type="text/javascript" src="modules/mod_smallFruitStockViewer/js/imagehandler.js"></script>
<script type="text/javascript" src="modules/mod_smallFruitStockViewer/js/smallFruitStockViewer.js"></script>
<link rel="stylesheet" href="modules/mod_smallFruitStockViewer/css/smallFruitStockViewer.css" type="text/css"/>
<script type="text/javascript">
$(document).ready(function(){
document.getElementById('project').selectedIndex=0;
    $('#date-select').val("");
    $('#print-button').click(function(){

        printDiv();
        });
    $('#close-button').click(function(){
        $('#toolbar').hide();
         window.history.go(-1);
             });
    $("a[rel=stockImageGroup]").fancybox({
        'transitionIn'      : 'none',
        'transitionOut'     : 'none',
        'titlePosition'     : 'over',
        'titleFormat'       : function(title, currentArray, currentIndex, currentOpts) {
            return '<span id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
        }

    });
$('#close-imagearea-button').click(function() {
    $('#imageArea').hide('blind',{},800);
    });

$('#season').change(function(){
	
	var season = $('#season').val();
	if(season != "-1"){
		$.post("modules/mod_smallFruitStockViewer/ajax/getProject.php",{season:season},function(data){
					
			if(data.success == true){
				var projects = "<option selected='selected' value=''>Select a project</option>";
				for(i=0;i<data.data.length;i++){				
					projects += "<option value='"+ data.data[i]['areaId'] +"'>" + data.data[i]['areaName'] + "</option>";				
				}			
				$('#project').html(projects);

			}
			else{
				$('#project').html("<option selected='selected' value=''>Select a project</option>");
				}
			
		});		
	}	
});


    });


function printDiv()
{ 
  var disp_setting="toolbar=yes,location=no,directories=yes,menubar=yes,"; 
      disp_setting+="scrollbars=yes,width=1112, height=790, left=100, top=25"; 
  var content_vlue = document.getElementById("printable-report").innerHTML; 
  
  var docprint=window.open("","",disp_setting); 
   docprint.document.open(); 
   docprint.document.write('<link rel="stylesheet" href="css/insertionData.css" type="text/css">');    
   docprint.document.write('<body onLoad="self.print()">');          
   docprint.document.write(content_vlue);          
   docprint.document.write('</body>');
   docprint.document.close(); 
   docprint.focus(); 

}







</script>

<script type="text/javascript">
<?php 

require_once 'modules/mod_stockViewer/class/stockViewer.class.php';
//require_once 'modules/mod_stockViewer/class/stockHelper.php';
?>
$(document).ready(function(){
    $('#date-select').datepicker({ dateFormat: 'yy-mm-dd',onSelect:findbydate });
    
        
});

//handle the inteface




function findbydate() {

    var dt=$( "#date-select" ).datepicker('getDate');
    var date=dt.getFullYear()+'-'+(dt.getMonth()+1)+'-'+dt.getDate();
    var project = $('#project').val();
    var vehicleNo = $('#vehicleNo').val();
    
    $('#waiting-div').show();
    $.post('modules/mod_smallFruitStockViewer/ajax/dataShop.php',{'flag':'selectStockByDate','date':date, 'vehicleNo':vehicleNo,'project':project},function(data){
      
$('#report-wrapper').html(data);

   $('#waiting-div').hide();
});

  
    
}

///show stocks

function findStockWithArea(value){

    var date=$('#date-select').val();
    var date_status;
    var vehicleNo = $('#vehicleNo').val();
    
    if(date==""){

        date_status="empty";
        }
    else{
        date_status="not-empty";
        }   

     $('#waiting-div').show();
    $.post('modules/mod_smallFruitStockViewer/ajax/dataShop.php',{'flag':'selectStockByProject','project':value,
                                    'date_status':date_status,'date':date, 'vehicleNo':vehicleNo },function(data){
          
        $('#report-wrapper').html(data);

            $('#waiting-div').hide();
        });


    
}

function findStockWithVehicle(value){

    var date=$('#date-select').val();
    var project=$('#project').val();
        
    var date_status;
    var project_status;
    if(date==""){
        date_status="empty";
        }else{
        date_status="not-empty";
            }
     $('#waiting-div').show();
    $.post('modules/mod_smallFruitStockViewer/ajax/dataShop.php',{'flag':'selectStockByVehicleNo','vehicleNo':value,
        'date_status':date_status,'date':date, 'project':project },function(data){

$('#report-wrapper').html(data);
 $('#waiting-div').hide();

});
    
}







//function


</script>

<h3>Quality Report Viewing window</h3>
<p>Select a filter key</p>
<div id='filter'>
<table border="0" cellpadding="2" class="datatable" width="8
00">
 <tr>
 	<td>Season :<select id="season">
 	<option value="-1">Select season</option> 
 	
 	<?php 
 					foreach ($season as $s){
						print "<option value='".$s['seasonId']."'>".$s['seasonName']."</option>";
					}
 	
 	?>
 		
 	</select></td> 
    <td>Date :<input type="text" id="date-select"  /></td>
    <td>Project :<select onchange="findStockWithArea(this.value)" id="project">
    
    
    <option selected="selected" value="">Select a project</option>
  
  </select> </td>
    <td>Vehicle No :  <input type="text" id="vehicleNo" onblur="findStockWithVehicle(this.value);" /></td>
   
   
   
  </tr>
</table>
</div>
<div id="report-wrapper">
</div>

<div id="window" align="center">

<div id="printer-toolbar" style="display:none">
&nbsp;<h4>Quality Report and Balance Sheet Viewer </h4>
<ul>

<li onclick="closePrinter()"><img src="images/close.png" height="35" width="48"  ><p>Close</p></li>

<li onclick="printPrinter()"><img src="images/print_printer.png" height="35" width="48" ><p>Print</p></li></ul>


</div>

<div id="printables-wrapper" style="display:none">
<div id="printable-qreport" style="display:none">&nbsp;
</div>

<div id="printable-bsheet"  style="display:none">
&nbsp;
</div>
</div>
</div>
<div id="imageArea" style="display: none">
<p class='header'>Stock Images Gallery</p>

<table align="center" width="700">
<tr><td id="image1" align="center"></td><td id="image2" align="center"></td><td id="image3" align="center"></td></tr>
<tr><td  align="center" ><span id="imgDesc1" class='description'></span></td><td  align="center"   class='description'><span id="imgDesc2"></span></td><td align="center"   class='description'><span id="imgDesc3"></span></td></tr>

</table>


&nbsp;
<p id="close-imagearea-button"></p>
</div>


