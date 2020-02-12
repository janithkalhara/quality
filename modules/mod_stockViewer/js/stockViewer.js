function deleteStock(id){
	if(confirm("Are you sure ? ")){
	var ids=id.split('|');
	var array=jQuery.parseJSON(ids[0]);
		var project=array[0];
		var vehicleNo=array[1];
		var date=array[2];
		var parentId=ids[1];
		var dataArray={'project':project,'vehicleNo':vehicleNo,'date':date};
		$('#waiting-div').show();
		$.post('modules/mod_stockViewer/ajax/deleter.php',{'flag':'deleteFromCrop','data':dataArray},function(data){
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

function displayQualityReport(id) {
	$('#window').show();
	$('#printer-toolbar').show();
	$('#printable-report').empty();
	$('#printable-report').load('modules/mod_stockViewer/ajax/renderer.php',{'id':id});	
}

function closePrinter() {
	$('#window').hide();
	$('#printer-toolbar').hide();
}

function printPrinter() {
	printMySheet();
}

function printMySheet(){
	var disp_setting2="toolbar=yes,location=no,directories=yes,menubar=yes,"; 
    disp_setting2+="scrollbars=yes,width=1112, height=790, left=100, top=25"; 
    var content_vlue2 = document.getElementById('printable-report').innerHTML; 

    var docprint2=window.open("","",disp_setting2); 
    docprint2.document.open(); 
    docprint2.document.write('<body onLoad="self.print()">');          
    docprint2.document.write(content_vlue2);          
    docprint2.document.write('</body>');
    docprint2.document.close(); 
    docprint2.focus(); 
}