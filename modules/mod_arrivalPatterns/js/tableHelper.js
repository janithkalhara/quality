/**
 * 
 */

var tableHelper=function(rows,cols,id){
	
	this.rows=rows;
	this.cols=cols;
	this.id=id;
	
	this.getTable=function(){
		var table=document.createElement("table");
		table.setAttribute("id", this.id);
		table.setAttribute("border",1);
		table.setAttribute("cellpadding",0);
		table.setAttribute("cellspacing",0);
		table.setAttribute("style","width:100%; border-collapse:collapse");
		for(var i=0;i<this.rows;i++){
			var tr=document.createElement("tr");
			for(var j=0;j<this.cols;j++){
			
				var td=document.createElement("td");
				if(i==0){
					td.setAttribute("class","header");
					td.setAttribute("id",this.id+"-header-"+j);
					td.setAttribute("align","center");
				}
				else{
					td.setAttribute("id",this.id+"-body-"+i+"-"+j);
					td.setAttribute("align","center");
				}
				tr.appendChild(td);
			}
			table.appendChild(tr);
		}
		return table;
		
		
		
	};
	
	this.setHeaders=function(headers){
		
		for(var i=0;i<this.cols;i++){
			//table1-header-0
			$('#'+this.id+"-header-"+i).html(headers[i]);	
			
		}
		
		
		
	};
	
	this.setRows=function(row,data){
		
		for(var i=0;i<this.cols;i++){
					
					$('#'+this.id+"-body-"+row+'-'+i).html(data[i]);	
					
				}
				
		
		
	};
	
};

$(document).ready(function(){
	
	$('#tentaive-wrapper').hover(
			function(){
				$('#print-toobar-tentative').fadeIn('slow');
			},
			function(){
				$('#print-toobar-tentative').fadeOut('slow');
			});
	
	
});
	
function printReport(){
	
	var disp_setting="toolbar=yes,location=no,directories=yes,menubar=yes,"; 
    disp_setting+="scrollbars=yes,width=870, height=790, left=100, top=25"; 
var content_vlue = document.getElementById("wrapper-tentReport").innerHTML; 

var docprint=window.open("","",disp_setting); 
 docprint.document.open(); 
 docprint.document.write('<link rel="stylesheet" href="css/insertionData.css" type="text/css">');    
 docprint.document.write('<body onLoad="self.print()">');          
 docprint.document.write(content_vlue);          
 docprint.document.write('</body>');
 docprint.document.close(); 
 docprint.focus(); 
	
	
	
}
