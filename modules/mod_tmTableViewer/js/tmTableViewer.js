$(document).ready(function(){
	//getGraphData();
	$('#startDate').datepicker({dateFormat: 'yy-mm-dd',maxDate:'<?php print $date?>'});
	$('#endDate').datepicker({dateFormat: 'yy-mm-dd',maxDate:'<?php print $date?>'});

	existData1 = $('#dataTable').html();
	existData2 = $('#dataTable2').html();

	existData1Print = $('#dataTablePrint').html();
	existData2Print = $('#dataTable2Print').html();

	sign = $('#signTable').html();
	
	
$('#season').change(function(){
	
	var season = $('#season').val();
	if(season != "not selected"){
		$.post("modules/mod_tmTableViewer/ajax/getGraphData.php",{season:season},function(data){
			var res = jQuery.parseJSON(data);			
			
			var projects = "";
			for(i=0;i<res.length;i++){				
				projects += "<option value='"+ res[i]['areaId'] +"'>" + res[i]['areaName'] + "</option>";				
			}	
			$('#project').html(projects);
			if(project) {
				$('#project').val(project);
			}
			
		});
		
	}
	
});


$('#printButton').click(function(){
	clickHereToPprint();
	
});

$('#printButtonSmall').click(function(){
	clickHereToPprintSmall();
	
});

$('#submitBut').click(function(){	
	getGraphData();	
});

});


function getGraphData(){	
	$('#myform').submit();	
	$('#waiting-div').show();
}

function clickHereToPprint()
{ 
	var data = $('#dataDiv').html();
	var tableData = $('#dataTable').html();
	var signData = $('#signTable').html();
	$('#printDiv').html('<div><center><b><u> Daily Receiving Summary - Scheme Payment </u></b></center></div><br/>'+ data +'<br/><table cellpadding="0" cellspacing="0" border="1" >'+tableData+'</table><table style="width: 700px; position: relative; left: 200px; text-align: center; top: 60px">'+signData+'</table>');
	
	
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

function clickHereToPprintSmall()
{ 
	var data = $('#dataDiv').html();
	var tableData = $('#smallDataTable').html();
	var signData = $('#signTable').html();
	$('#printDiv').html('<div><center><b><u> Daily Receiving Summary - Scheme Payment </u></b></center></div><br/>'+ data+'<br/><table cellpadding="0" cellspacing="0" border="1" >'+tableData+'</table><table style="width: 700px; position: relative; left: 200px; text-align: center; top: 60px">'+signData+'</table>');
	
	
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

