$('document').ready(function(){
	$('#startDate').datepicker({dateFormat:'yy-mm-dd',maxDate:'<?php print $date?>',onSelect:getDataTable});
	$('#endDate').datepicker({dateFormat:'yy-mm-dd',maxDate:'<?php print $date?>',onSelect:getDataTable});
		
	$('#season').change(function(){
		var seasonId = $('#season').val();
		$.post("modules/mod_crateViewer/class/GetProject.php",{seasonId : seasonId},function(data){
			$('#project').html(data);
			
		});		
	});
	
	$('#project').change(function(){		
		getDataTable();		
	});
	
	getDataTable();
	
});

function getDataTable(){
	var project = $('#project').val();
	var startDate = $('#startDate').val();
	var endDate = $('#endDate').val();
	
	var dataTable = "<table id='dataTable' cellpadding='0' cellspacing='0' border='1'>" +
			"<tr style='background-color: #627AAD;font-weight:bold;height:25px;color:#fff'>" +
			"<td width='210'>Project</td>" +
			"<td width='210'>Date</td>" +
			"<td width='210'>Vehicle No</td>" +
			"<td width='210'>Station</td>" +
			"<td>No. of Bags</td>" +
			"<td>No. of Crates</td>" +
			"</tr>";
	
	$('#waiting-div').show();
	$.post("modules/mod_crateViewer/SetTable.php",{project:project,startDate:startDate,endDate:endDate}, function(data){
			
		console.log(data);
		data=data.trim()
			if(data == 0){
				$('#tableDiv').hide();
				$('#submitmsg').show();
			}else{
			var result=jQuery.parseJSON(data);
			
			var resultRaw = "";
			
			for(var i=0;i<result.length;i++){				
				
				resultRaw += "<tr><td>"+result[i][0]+"</td><td>"+result[i][1]+"</td><td>"+result[i][2]+"</td><td>"+result[i][3]+"</td><td>"+result[i][4]+"</td><td>"+result[i][5]+"</td></tr>";			
			}
			 
					resultRaw +="</table>";
					dataTable += resultRaw; 	
					$('#tableDiv').html(dataTable);
					$('#submitmsg').hide();
					$('#tableDiv').show();
					
			}
			$('#waiting-div').hide();
	});
	
}
