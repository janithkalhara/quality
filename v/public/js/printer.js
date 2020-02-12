$(function(){
	$(document).on('click','#print-button',function(e){
		e.preventDefault();
		/* tables */
		var container = getPaymentSheetContainer();
		var docprint=window.open("","_blank"); 
		docprint.document.open(); 
		docprint.document.write('<link rel="stylesheet" href="css/print.css" type="text/css">');    
		docprint.document.write('<link rel="stylesheet" href="css/bootstrap.css" type="text/css">');  
		docprint.document.write('<link rel="stylesheet" href="css/font-awesome.css" type="text/css">');  
		docprint.document.write('<body onLoad="self.print()">');  
		docprint.document.write(container.html());          
		docprint.document.write('</body>');
		docprint.document.close(); 
		docprint.focus(); 
	});
	
});

function getPaymentSheetContainer(){
	var headerTable = getPrintableElement($('#table-header').clone());
	var stockTable = getPrintableElement($('#table-stocks').clone());
	var incentiveTable = getPrintableElement($('#table-incentive').clone());
	var weeklyIncentiveTable = getPrintableElement($('#table-weekly-incentive').clone());
	var schemeValueTable = getPrintableElement($('#table-scheme-value').clone());
	var summaryTable = getPrintableElement($('#table-summary').clone());
	var advanceSummaryTable = getPrintableElement($('#table-advance-summary').clone());
	var stSummaryTable = getPrintableElement($('#table-st-summary').clone());
	var transportSummaryTable = getPrintableElement($('#table-transport-summary').clone());
	var container = $('<div></div>');
	container.append(headerTable);
	container.append(stockTable);
	var row1=$('<div class="row"></div>');
	var col=$('<div class="col-md-6"></div>');
	var col_cloned_i = col.clone();
	col_cloned_i.append(incentiveTable)
	col_cloned_i.append(weeklyIncentiveTable)
	col_cloned_i.append(summaryTable);
	row1.append(col_cloned_i);
	var col_cloned_s = col.clone();
	col_cloned_s.append(schemeValueTable)
	col_cloned_s.append(advanceSummaryTable)
	col_cloned_s.append(stSummaryTable);
	col_cloned_s.append(transportSummaryTable);
	row1.append(col_cloned_s);
	container.append(row1);
	var row2=$('<div class="row"></div>');
	var col_cloned_summary = col.clone();
	row2.append(col_cloned_summary);
	var col_cloned_ad = col.clone();
	col_cloned_ad.append(getProofTable());
	row2.append(col_cloned_ad);
	container.append(row2);
	return container;
}

function getPrintableElement($element) {
	$element.find('a').replaceWith('');
	return $element;
}

function getProofTable() {
	return $('<table width="100%" border="1"><tr>'+
			'<td><b>Checked By</b></td>'+
			'<td><b>Passed for pmt By</b></td>'+
			'<td><b>Cheque Signed By</b></td>'+
			'</tr><tr><td></td><td></td><td></td></tr></table>');
}

