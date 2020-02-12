var active='';

function displayBSheet(ids) {
	
	$('#window').show();
	$('#printables-wrapper').show();
	$('#printer-toolbar').show();
	$('#printable-bsheet').show();
	$('#printable-bsheet').empty();
	$('#printable-bsheet').load('modules/mod_smallFruitStockViewer/ajax/renderer.php',{'id':ids,'type':'bsheet'});
	active='printable-bsheet';
}

function displayReport(id) {
	$('#window').show();
	$('#printables-wrapper').show();
	$('#printer-toolbar').show();
	$('#printable-qreport').show();
	$('#printable-qreport').empty();
	$('#printable-qreport').load('modules/mod_smallFruitStockViewer/ajax/renderer.php',{'id':id,'type':'qreport'});
	active='printable-qreport';
}

function closePrinter() {
	$('#printables-wrapper').hide();
	$('#printer-toolbar').hide();
	$('#printable-qreport').hide();
	$('#printable-bsheet').hide();
	active='';
}


function printPrinter() {
	printMySheet(active);
}

function printMySheet(a){
	
	var disp_setting2="toolbar=yes,location=no,directories=yes,menubar=yes,"; 
    disp_setting2+="scrollbars=yes,width=1112, height=790, left=100, top=25"; 
var content_vlue2 = document.getElementById(a).innerHTML; 

var docprint2=window.open("","",disp_setting2); 
 docprint2.document.open(); 
  docprint2.document.write('<body onLoad="self.print()">');          
 docprint2.document.write(content_vlue2);          
 docprint2.document.write('</body>');
 docprint2.document.close(); 
 docprint2.focus(); 
	
	
}
function deleteStock(id){

if(confirm('Are you sure ?')){

var ids=id.split('|');
var array=jQuery.parseJSON(ids[0]);
	var project=array[0];
	
	var vehicleNo=array[1];
	var date=array[2];
	var parentId=ids[1];
	var dataArray={'project':project,'vehicleNo':vehicleNo,'date':date};
	$('#waiting-div').show();
	
	
	$.post('modules/mod_smallFruitStockViewer/ajax/deleter.php',{'flag':'deleteFromCrop','data':dataArray},function(data){
		data=data.trim();
		if(data=='1'){
			
			alert('Stock Deleted Succeccfully!');
			$('#'+parentId).remove();
		}else{
			alert('Unable to Delete Stock.Please Try again later');
		}
		$('#waiting-div').hide();
	});
	
	
	
}
	
	
	
	
	
	
	
	
}






