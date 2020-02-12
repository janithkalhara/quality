$(document).ready(function(){
	manageTableColumns(0);
	$('.toggler').change(function(){
		var idString = $(this).attr('id');
		var ids = idString.split('-');
		var id = ids.pop();
		manageTableColumns(id);
		
	});
});

var accepted=false;
var finalCRSReduction;

function manageTableColumns(id){
		if(!$('#toggler-'+id).is(':checked')){
			$('#avg-fc-'+id).parent().hide();
			var fields = dataFields['off'];
			for(j in fields){
				$('#row-'+id+'-'+fields[j]).hide();
			}
		}else{
			showAll(id);
		}
}

function showAll(id){
	$('#avg-fc-'+id).parent().show();
	var fields = dataFields['on'];
	for(j in fields){
		$('#row-'+id+'-'+fields[j]).show();
	}
}
function showHighlight(){
$('#highlight-text').fadeIn();
}

function hideHighlight(){
	$('#highlight-text').fadeOut();
}

function calculateQuality(id,value) {
	var i = id.split('-');
	var tableNo = i[1];
	var row = i[2];
	var column = i[3];
	if(tableNo == 4){
		crsCalculation(tableNo,row,column,value);
	}else{
		
		handleCellData(tableNo,row,column,value);
		/*scanColumnAndsetSum(tableNo,column);*/
	}
}

function scanColumnAndsetSum(table,column) {
	//table-0-7-0
	var target = 'table-'+table+'-9-'+column;
	var sum = 0;
	for(var i=1;i<9;i++){
		if($('#table-'+table+'-'+i+'-'+column).val()!=""){
		var val = $('#table-'+table+'-'+i+'-'+column).val();
		sum += parseInt(val);
		}
	}
	$('#'+target).val(sum);
}

function crsCalculation(tableNo,row,column,value) {
	
	if(row!=0){
		if(checkFC(tableNo, row, column, value)){
			setSumPerColumns(tableNo,row);
		}
		else{
			}
	}
}

function checkFC(tableNo,row,column,value) {
	var fc = $('#table-'+tableNo+'-'+0+'-'+column).val();
	if($('#table-'+tableNo+'-'+row+'-'+column).val() != ""){

		if(fc == "" && row!=0 && !(column==13||column==14)){
			alert('Please fill Fruit Count Data!');
			$('#table-'+tableNo+'-'+row+'-'+column).val('');
			$('#table-'+tableNo+'-'+0+'-'+column).focus()
			return false;
		}
		else return true;
	}
	
}

function setSumPerColumns(tableNo,row) {
	var sum = 0;
	var grade = getGrade('CRS');
	for(var i = 0;i<13;i++){
		//table-4-4-7
		var val = $('#table-'+tableNo+'-'+row+'-'+i).val();
		if(val != ""){
			sum += parseInt(val);
		}
		
	}
	if(row!=11){$('#table-'+tableNo+'-'+row+'-'+13).val(sum);}
	//set percenteges
	
	var ret = getAverageFC(tableNo);
	var sampleSize = grade.sampleWeight;
	console.log('Sample size => ' + sampleSize);
	var retArray = ret.split('-');
	var avgFC = retArray[0];
	var sampleCount = retArray[1];
	var divider = avgFC*sampleCount*sampleSize;
	var percentage = (sum/divider)*100;
	percentage = Math.round(percentage*100)/100;
	if(row != 11){$('#table-'+tableNo+'-'+row+'-'+14).val(percentage);}
	
	
}
function getGrade(name) {
	for(i in metadata.grades) {
		if(metadata.grades[i].fruitCount == name) {
			return metadata.grades[i];
		}
	}
}

function getAverageFC(table) {
	var sum=0;var count=0;
	for(var i=0;i<13;i++){
		//table-4-4-7
		var val = $('#table-'+table+'-'+0+'-'+i).val();
		if(val != ""){
			sum += parseInt(val);
			count++;
		}
	}
	var percentage = sum/count;
	percentage = Math.round(percentage*100)/100;
	var ret = percentage+'-'+count;
	return ret;
}

/* balance sheet*/	
function showBalanceSheet() {
	var balanceSheet = 0;
    
    if($('#show-balanceSheet').val() == "Show Balance Sheet"){
        if(balanceSheet == 0){
        	
        //$('#balanceSheetDiv').load('modules/mod_smallFruitInsertion/smallFruitInsertionBalanceSheet.php #wrapperDiv');
        	$('#balanceSheetDiv').show();
        	balanceSheet = 1;
        }
    $('#sliderContainerSmall').css('height','1000px');
    $('#show-balanceSheet').val("Hide Balance Sheet");
    //$('#balanceSheetDiv').show();
    }else{
        $('#balanceSheetDiv').hide();
        $('#sliderContainerSmall').css('height','465px');
        $('#show-balanceSheet').val("Show Balance Sheet");
    }
    if(edit){
    	for(var i=1;i<=5;i++){
    		//bsheet-1-2
    		$('#bsheet-'+i+'-2').trigger('blur');
    	}
    }
    setData();
}

function handleCellData(table,row,column,value){
	
	var sumCalculation = $('#toggler-'+table).is(':checked');
	var fc = $('#table-'+table+'-1-'+column).val();
	if(!isNaN(value)){
		if(!sumCalculation){
			var fields = dataFields['calc_fields_off'];
			var sum = 0;
			for(i in fields){
				var node=$('#table-'+table+'-'+fields[i]+'-'+column);
				
				if(node.val()!='' && !isNaN(node.val())){
					sum+=parseInt(node.val());
				}
			}
			$('#table-'+table+'-17-'+column).val(sum);
		}else if(row!=0){

			if((isNaN(fc) || fc=='')&& value!= '' && row!=0 && !(column==13|| column==14)){
				alert("Please insert fruit count.");
				$('#table-'+table+'-1-'+column).focus();
				$('#table-'+table+'-'+row+'-'+column).val('');
			}else{
				for(var i=0;i<dataFields['on_calcable'].length;i++){
					handleCellDataInSum(table, dataFields['on_calcable'][i], column, value);
				}
			}
		}
	}
	else{
		alert("Please insert numeric value.");
		$('#table-'+table+'-'+row+'-'+column).val('');
	}
}

function handleCellDataInSum(table,row,column,value){
	var fc = $('#table-'+table+'-1-'+column).val();
	var sampleFc = parseFloat($('#sample-fc-'+table).val());
	
		//calculation goes from here
		//make FC
		var fc = rowSum = 0;
		var counterFc = counter = 0;
		for(var i=0;i<13;i++){
			//table-1-4-0
			
			var node = $('#table-'+table+'-1-'+i);
			var cellNode = $('#table-'+table+'-'+row+'-'+i);
			if(!isNaN(node.val()) && node.val()!=''){
				fc +=parseInt(node.val());counterFc++;
			}
			if(!isNaN(cellNode.val()) && cellNode.val()!=''){
				rowSum +=parseInt(cellNode.val());counter++;	
			}
		}
		fc = parseInt(fc/counterFc);
		per = Math.round((rowSum/(fc*sampleFc*counterFc))*100*100)/100;
		$('#avg-fc-'+table).html(!isNaN(fc)?fc:0);
		$('#table-'+table+'-'+row+'-13').val(rowSum>0?rowSum:'');
		$('#table-'+table+'-'+row+'-14').val((per>0&&row!=1)?per:'');
		//making sum and per
		
}

function setData() {
	$('#5-7-test').val(finalCRSReduction);
}

function exportDataToBalanceSheet() {
	
	exportGradeData();
	exportCrsData();
	alert('Quality report data exported to balance sheet.');
}

function exportGradeData(){
	var defects = {
				offGrade:[2,3],
				defects:[4,5,6,7,8,9,10,11,12,13,14],
				rotten:16
			}
	var grades = metadata.grades;
	for(var i=0;i < 4;i++){
		
		if($('#toggler-'+i).is(':checked')){	
			//count defects table-3-1-14
			var defectReduction = parseFloat(grades[i].offgradereduce);
			var ogSum = dfSum = rotSum = capture = 0;
			for(var j=0;j<defects.offGrade.length;j++ ){
				var val = $('#table-'+i+'-'+defects.offGrade[j]+'-14').val();
				if(typeof val !== 'undefined' && val!='' && !isNaN(val) ){
					ogSum += parseFloat(val);
				}
			}
			ogSum = Math.round(ogSum*100)/100;
			for(var j=0;j<defects.defects.length;j++ ){
				var val = $('#table-'+i+'-'+defects.defects[j]+'-14').val();
				if(typeof val !== 'undefined' && val!='' && !isNaN(val) ){
					dfSum += parseFloat(val);
				}
			}
			dfSum = Math.round(dfSum*100)/100;
			rotSum = !isNaN(rot = parseFloat($('#table-'+i+'-'+defects.rotten+'-14').val()))?rot:0;
			rotSum = Math.round(rotSum*100)/100;
			
			capture += (ogSum > 10) ? ogSum - 10:0;
			capture += (dfSum > defectReduction) ? dfSum-defectReduction : 0;
			capture += (rotSum > 0) ? rotSum : 0;
			
			capturable['table_'+i] = Math.round(capture*100)/100;
			console.log(capturable);
		}
	}
}

function exportCrsData(){
	var defectsPercentage = 0;
	var offGradePercentage = 0;
	for(var i=1;i<11;i++){
		if(i == 1||i == 2){
			var val = $('#table-4-'+i+'-14').val();
			offGradePercentage += parseFloat(val);
		}else{
			var val=$('#table-4-'+i+'-14').val();
			if(val!=""){
				defectsPercentage += parseFloat(val);
			}
		}		
	}
	var v = $('#table-4-12-14').val();
	
	var finalRec = 0.00;
	if(offGradePercentage > 10){
		finalRec = offGradePercentage-10;
	}
	if(defectsPercentage > 7){
		finalRec = defectsPercentage-7;
	}
	if(v!=""){
		finalRec += parseFloat(v);
	}
	finalRec = Math.round(finalRec*100)/100;
	if(Number(finalRec)){
		finalCRSReduction = finalRec;
	}
	else{
		finalCRSReduction = 0;
	}

	return true;

}

function setAccepted() {
	var table = 4;
	
	for(var j = 0;j<13;j++){
		
		var sum = 0;
		
		for (k=3;k<11;k++){
			var target = '#table-'+table+'-'+k+'-'+j;
			
			var val = $(target).val();
			
			if(val != ""){
				sum += parseInt(val);
			}
		}	
		
		if(sum>0){
			var ret = getAverageFC(4);
			var sampleSize = 5;
			var retArray = ret.split('-');
			var avgFC = retArray[0];
			var sampleCount = retArray[1];
			var divider = avgFC*5;
			var average = sum/divider;
			average = average*100;
			average = Math.round(average*100)/100;
			var respond;
			if(average > 7){
				respond="RE";
			}else{
				respond="AC";
			}
			
			$('#table-'+table+'-'+11+'-'+j).val(respond);
			
		}else if(sum == 0){
			var fc=$('#table-'+table+'-'+0+'-'+j).val();
			if(fc!=""){
				
				$('#table-'+table+'-'+11+'-'+j).val('AC');
			}
		}
	}
	accepted = true;
}

/* Set the data of balance sheet*/

function calculate_Bsheet(id,value) {
	
	var tables = [[0,0,0,0,0,0,0,0,0,0,0],[0,0,0,0,0,0,0,0,0,0,0],[0,0,0,0,0,0,0,0,0,0,0],
	            [0,0,0,0,0,0,0,0,0,0,0],[0,0,0,0,0,0,0,0,0,0,0],[0,0,0,0,0,0,0,0,0,0,0]];
	var ids = id.split('-');
		//bsheet-1-4
		var table = parseInt(ids[1]);
		var column = parseInt(ids[2]);
		var DQ = $('#bsheet-'+table+'-'+0).val();
		var AQ = $('#bsheet-'+table+'-'+1).val();
		var flag = $('#toggler-'+(table-1)).is(':checked');
		
		if(column == 1 || column == 0){
			
			if(DQ != ''){
				var weightloss = DQ-AQ;
				weightloss = Math.round(weightloss*100)/100;
				$('#bsheet-'+table+'-'+9).val(weightloss);
			}
			else{
				
			}
			/*Setting total Hidden loss*/
			var totalWeightLoss = 0.00;
			for(var i=0;i<5;i++){
				if($('#bsheet-'+i+'-10').val()!=''){
					totalWeightLoss += parseFloat($('#bsheet-'+(i+1)+'-10').val());
				}
			}
			$('#bsheet-6-10').val(totalWeightLoss);
			//setting total reduce 
			var reduced = 0;
			if(column==1 && flag){
				var rejection = parseFloat(AQ)*capturable['table_'+(table-1)]/100
				reduced = parseFloat(AQ) - rejection;
				if(reduced != 0 ){
					reduced = Math.round(reduced*100)/100;
					rejection = Math.round(rejection*100)/100;
					$('#bsheet-'+table+'-'+(parseInt(table)+1)).val(reduced);
					$('#bsheet-'+table+'-7').val(rejection);
				}
			}
			//setting totals 
			for(var i=2;i<10;i++){
				var sum = val = 0;
				for(var j=0;j<5;j++){
					//bsheet-6-3
					val = parseFloat($('#bsheet-'+j+'-'+i).val());
					sum+= !isNaN(val)?val:0;
				}
				$('#bsheet-6-'+i).val(sum);
			}
			
		}
		if(column > 2){
			if(value != ""){
				if(DQ == ''){
					alert('Please Enter Declared Quantity !');
					$('#'+id).val('');
					$('#bsheet-'+table+'-'+1).focus();
					
				}else if(AQ == ''){
					alert('Please Enter Actual Quantity !');
					$('#'+id).val('');
					$('#bsheet-'+table+'-'+2).focus();
				}
			}
		}
		/* Numerical validation*/
		if(isNaN(value)){
			alert('Please Enter a Numeric Value!');
			$('#'+id).val('');
			$('#'+id).focus();
		}
		
		/* Setting Off Grade % */
		var offGrades = offGradePer = [];
		offGrades[table] = 0;
		for(i=2;i<7;i++){
			
			if(i != (Number(table)+1)){
				var val = $('#bsheet-'+table+'-'+i).val();
				offGrades[table] += Number(val);
			}
			else{
			}
		}
		if(AQ != ""){
			offGradePer[table] = (offGrades[table]/Number(AQ))*100;
			offGradePer[table] = Math.round(offGradePer[table]*100)/100;
			$('#'+table+'-offgrade').val(offGradePer[table]);
		}
		/* setting total*/
		var total = 0;
		for(i=1;i<6;i++){
			total += Number($('#bsheet-'+i+'-'+column).val());
		}
		total = Math.round(total*100)/100;
		$('#bsheet-6-'+column).val(total);
		
		/*setting off grade total*/
		var counter = 0;
		var offgradetotal = 0;
		for(var i=1;i<6;i++){
			if( $('#'+i+'-offgrade').val()!=""){
				offgradetotal += Number( $('#'+i+'-offgrade').val());
				counter++;
			}
		}
		var finalOffGrade = offgradetotal/counter;
		finalOffGrade = Math.round(finalOffGrade*100)/100;
		if(isNaN(finalOffGrade)){
			
		}else{
			$('#6-offgrade').val(finalOffGrade);
		}
		if(table == 5 && (column == 1 ||column == 0)){
			if(isNaN(finalCRSReduction) || !finalCRSReduction){
				finalCRSReduction = 0;
			}
			var crs = AQ-((AQ*finalCRSReduction)/100);
			crs = Math.round(crs*100)/100;
			$('#bsheet-5-6').val(crs);
		}
		/*setting weight loss and hidden loss*/
		var pendingHiddenLoss = 0;
		for(var i=2;i<8;i++){
			if($('#bsheet-'+table+'-'+i).val()!='' && table!=5){
				pendingHiddenLoss += Number($('#bsheet-'+table+'-'+i).val());
			}
			else if(table == 5){
				//setting CRS reject amount
				if($("#bsheet-5-7").val()!=""){
					var crs = parseFloat($("#bsheet-5-7").val());
					var reject = AQ-crs;
					reject = Math.round(reject*100)/100;
					$("#bsheet-5-8").val(reject);
				}else{
					
				}
			}
		}
		
		var hiddenLoss = AQ-pendingHiddenLoss;
		hiddenLoss = Math.round(hiddenLoss*100)/100;
		//avoiding CRS
		if(table != 5){
			$('#bsheet-'+table+'-'+8).val(hiddenLoss);
		}
		//setting reject total
		rejectTotal = 0;
		for(var k = 1;k<6;k++){
			if($('#bsheet-'+k+'-7').val()!=""){
				rejectTotal += Number($('#bsheet-'+k+'-7').val());
			}
		}
		rejectTotal = Math.round(rejectTotal*100)/100;
		$('#bsheet-6-7').val(rejectTotal);
		
		/* Setting the total hidden loss*/
		var hiddenLossTotal = 0;
		for(var i=1;i<6;i++){
			//bsheet-3-9
			hiddenLossTotal += Number($('#bsheet-'+i+'-8').val());
		}		
		hiddenLossTotal = !isNaN(hiddenLossTotal) ? Math.round(hiddenLossTotal*100)/100 : 0;
		$('#bsheet-6-8').val(hiddenLossTotal);
		crsTotal=0;
		for(var m=1;m<6;m++){
			//bsheet-3-9
			if($('#bsheet-'+m+'-6').val()!=""){
				crsTotal += Number($('#bsheet-'+m+'-6').val());
			}
		}
		crsTotal = Math.round(crsTotal*100)/100;
		$('#bsheet-6-6').val(crsTotal);
		setPercentages();
}

function setPercentages() {
	
	//bsheet-6-1
	totalDQ = Number($('#bsheet-6-0').val());
	totalAQ = Number($('#bsheet-6-1').val());
	totalG1 = Number($('#bsheet-6-2').val());
	totalG2 = Number($('#bsheet-6-3').val());
	totalG3 = Number($('#bsheet-6-4').val());
	totalG4 = Number($('#bsheet-6-5').val());
	totalCRS = Number($('#bsheet-6-6').val());
	totalReject = Number($('#bsheet-6-7').val());
	totalHL = Number($('#bsheet-6-8').val());
	totalWL = Number($('#bsheet-6-9').val());
	
	perG1 = Number((totalG1/totalAQ)*100);
	if(Number(perG1)){
		perG1=Math.round(perG1*100)/100;
		$('#bsheet-7-2').val(perG1);
	}
	else{
		$('#bsheet-7-2').val(0);
		
	}
	perG2 = Number((totalG2/totalAQ)*100);
	if(Number(perG2)){
		perG2 = Math.round(perG2*100)/100;
		$('#bsheet-7-3').val(perG2);
	}else{
		$('#bsheet-7-3').val(0);
	}
	perG3 = Number((totalG3/totalAQ)*100);
	if(Number(perG3)){
		perG3 = Math.round(perG3*100)/100;
		$('#bsheet-7-4').val(perG3);
	}else{
		$('#bsheet-7-4').val(0);
		
	}
	perG4 = Number((totalG4/totalAQ)*100);
	if(Number(perG4)){
		perG4 = Math.round(perG4*100)/100;
		$('#bsheet-7-5').val(perG4);
	}
	else{
		$('#bsheet-7-5').val(0);
		
	}
	perCRS = Number((totalCRS/totalAQ)*100);
	if(Number(perCRS)){
		perCRS = Math.round(perCRS*100)/100;
		$('#bsheet-7-6').val(perCRS);
	}
	else{
		$('#bsheet-7-6').val(0);
		
	}
	perReject = Number((totalReject/totalAQ)*100);
	if(Number(perReject)){
		perReject = Math.round(perReject*100)/100;
		$('#bsheet-7-7').val(perReject);
	}else{
		$('#bsheet-7-7').val(0);
		
	}
	perHL = Number((totalHL/totalAQ)*100);
	if(Number(perHL)){
		perHL = Math.round(perHL*100)/100;
		$('#bsheet-7-8').val(perHL);
	}else{
		$('#bsheet-7-8').val(0);
		
	}
	perWL = Number((totalWL/totalDQ)*100);
	if(Number(perWL)){
		perWL = Math.round(perWL*100)/100;
		$('#bsheet-7-9').val(perWL);
	}else{
		$('#bsheet-7-9').val(0);
		
	}
}

function submitQuantity(){
	
	var quantityArraySet = new Array;
	
	for(var i=0;i<10;i++){
		
		if($('#center'+i).val() != ""){
			quantityArraySet[i] = [
			$('#project-toppane').val(),                
			$('#project-toppane').val(),
			$('#date-toppane').val(),
			$('#vehicleNo-toppane').val(),
			$('#center'+i).val(),
			$('#tm'+i).val(),
			$('#gr-'+i+'-1').val(),
			$('#gr-'+i+'-2').val(),
			$('#gr-'+i+'-3').val(),
			$('#gr-'+i+'-4').val(),
			$('#gr-'+i+'-5').val(),
			];				
		}
	}
	
	$.post("modules/mod_smallFruitInsertion/ajax/dataHandler.php",{"flag":"saveCenterQuantity","quantityArraySet":quantityArraySet} ,function(data){
				
		}); 
	
}