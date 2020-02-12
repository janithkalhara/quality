$(document).ready(function(){
	
	$('#forecast-report').hover(
			function(){
				$('#print-toobar-forecast').fadeIn('slow');
			},
			function(){
				$('#print-toobar-forecast').fadeOut('slow');
			});
	
	
});
function printReport(){
	
	var disp_setting="toolbar=yes,location=no,directories=yes,menubar=yes,"; 
    disp_setting+="scrollbars=yes,width=870, height=790, left=100, top=25"; 
var content_vlue = document.getElementById("forecast-report").innerHTML; 

var docprint=window.open("","",disp_setting); 
 docprint.document.open(); 
 docprint.document.write('<link rel="stylesheet" href="css/insertionData.css" type="text/css">');    
 docprint.document.write('<body onLoad="self.print()">');          
 docprint.document.write(content_vlue);          
 docprint.document.write('</body>');
 docprint.document.close(); 
 docprint.focus(); 
	
	
	
}