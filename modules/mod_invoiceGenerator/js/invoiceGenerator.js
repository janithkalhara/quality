var months = ['January','February','March','April','May','June','July','August','September','October','November','December'];

$("document").ready(function(){
	$('#start-date').datepicker({dateFormat:'yy-mm-dd',maxDate: '<?php print $date;?>'});
	$('#end-date').datepicker({dateFormat:'yy-mm-dd',maxDate: '<?php print $date;?>>'});
	
	//$('#stat-month-sale').hide();
	/*
	$('.pArea').click(function(){
		var parent = $(this).parent();
		var id = $(this).attr('id');
		var input = '<input type="text" class="inputArea" id="'+id+'"/>';
		$(this).remove();
		
		parent.append(input);
		$('#'+id).focus();
		$('#'+id).bind('blur',function(){
			console.log("dsds	d");
			var parent = $(this).parent();
			var id = $(this).attr('id');
			var value = $(this).val();
			var p = '<p class="pArea" id="'+id+'">'+value+'</p>';
			$(this).remove();
			
			parent.append(p);
		});
	});
	
	$('.inputArea').on('blur',function(){
		console.log("dsdsd");
		var parent = $(this).parent();
		var id = $(this).attr('id');
		var value = $(this).val();
		var p = '<p class="pArea" id="'+id+'">'+value+'</p>';
		$(this).remove();
		
		parent.append(p);
	});*/
	
});

function genP(node){
	var elem = $('#'+node.id);
	var parent = elem.parent();
	var p = '<p onclick="genI(this)" class="editable" id="'+node.id+'">'+node.value	+'</p>';
	var dateAttr = elem.attr('data_id');
	if( dateAttr && dateAttr == 'date' ){
		var splitted = elem.val().split('-');
		var month = months[parseInt(splitted[1])-1];
		$('#stat-month-sale').show();
		$('span#month-sales').html(month);
		$('span#month-sales-s').html($('#start-date').val());
		$('span#month-sales-e').html($('#end-date').val());
	}
	elem.remove();
	parent.prepend(p);
	//$('#'+node.id).focus();
	
}
function genI(node){
	
	var elem = $('#'+node.id);
	var parent = elem.parent();
	var dateAttr = elem.attr('data_id');
	
	
	var input = '<input type="text" onblur="genP(this)" id="'+node.id+'" value="'+elem.html()+'" data_id="date"/>';
	elem.remove();
	
	parent.prepend(input);
	
	$('#'+node.id).focus();	
}
function genT(node){
	var elem = $('#'+node.id);
	var parent = elem.parent();
	var input = '<textarea onblur="genP2(this)" id="'+node.id+'">'+elem.html()+'</textarea>';
	elem.remove();
	
	parent.append(input);
	$('#'+node.id).focus();	
}

function genP2(node){
	var elem = $('#'+node.id);
	var parent = elem.parent();
	var p = '<p onclick="genT(this)" id="'+node.id+'">'+node.value	+'</p>';
	
	
	elem.remove();
	parent.append(p);
	//$('#'+node.id).focus();	
}
function genTotalInput(node,index){
	var elem = $('#'+node.id);
	var parent = elem.parent();
	var input = '<input type="text" onblur="genTotal(this,\''+index+'\')" id="'+node.id+'" value="'+elem.html()+'"/>';
	elem.remove();
	
	parent.append(input);
	$('#'+node.id).focus();
}
function genTotal(node,index){
	var elem = $('#'+node.id);
	var parent = elem.parent();
	var p = '<p onclick="genTotalInput(this,\''+index+'\')" id="'+node.id+'" class="editable">'+node.value	+' </p>';
	elem.remove();
	parent.append(p);
	var qty = $('#qty'+index).html();
	var total = parseFloat(qty * node.value);
	$('#totPrice'+index).html(Math.round(total*100)/100);
	
	var rowCount = document.getElementById("valueTable").getElementsByTagName("tr").length;
	
	
	var totalValue = 0;
	for(i=1;i<(rowCount-2);i++){
		
		console.log($('#totPrice'+i).html());
		totalValue += parseFloat($('#totPrice'+i).html());		
	}
	console.log(totalValue);
	$('#totalAmount').html(Math.round(totalValue*100)/100);
}

function printInvoice(){
	var disp_setting="toolbar=yes,location=no,directories=yes,menubar=yes,"; 
	disp_setting+="scrollbars=yes,width=1112, height=790, left=100, top=25"; 
	var content_vlue = document.getElementById("letterArea").innerHTML; 
	var docprint=window.open("","",disp_setting); 
	docprint.document.open(); 
	docprint.document.write('<body onLoad="self.print()">');          
	docprint.document.write(content_vlue);          
	docprint.document.write('</body>');
	docprint.document.close(); 
	docprint.focus(); 
	
	
}

