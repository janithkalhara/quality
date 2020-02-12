$("document").ready(function(){
	var seasonId = $('#select-season').val();
	var type = $("#select-type").val();
		
	$('#start-date').datepicker({dateFormat:'yy-mm-dd',maxDate: '<?php print $date;?>'});
	$('#end-date').datepicker({dateFormat:'yy-mm-dd',maxDate: '<?php print $date;?>>'});
	
	$('#select-season').change(function(){
		var seasonId = $('#select-season').val();
		var type = $("#select-type").val();
		getProjects(seasonId,type);
	});
	
	$("#select-type").change(function(){
		var seasonId = $('#select-season').val();
		var type = $("#select-type").val();
		getProjects(seasonId,type);
	});
	
	$('#submitBut').click(function(){
		$('#dataForm').submit();
		$('#waiting-div').show();
	});
	
	$('#printBut').click(function(){
		clickHereToPprint();
	});
	
});

function getProjects(seasonId,type){	
	$.post("modules/mod_totalQuantityProject/ajax/DataManupulator.php",{flag:'first',seasonId:seasonId,type:type},function(data){
		var projects = jQuery.parseJSON(data);		
		$('#select-project').html(projects);
	});
}

function clickHereToPprint()
{ 
	var data = $('#detailArea').html();
//	var tableData = $('#dataTable').html();
//	var signData = $('#signTable').html();
//	$('#printDiv').html('<div><center><b><u> Detail Quantity Summary - Scheme Payment </u></b></center></div><br/>'+ data +'<br/><table cellpadding="0" cellspacing="0" border="1" >'+tableData+'</table><table style="width: 700px; position: relative; left: 200px; text-align: center; top: 60px">'+signData+'</table>');
	$('#printDiv').html('<div><center><b><u> Detail Quantity Summary - Scheme Payment </u></b></center></div><br/><br/>'+ data );
	
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