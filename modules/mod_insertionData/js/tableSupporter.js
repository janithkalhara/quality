var analyzer=new tableAnalyzer();

var dataKeeper=function(){
	this.keepArray=Array();
	this.storeArray=function(arrayName,arr){
		this.keepArray[arrayName]=arr;
	};
	this.getArray=function(arrayName){
		return this.keepArray[arrayName];
	};
};
var arrayKeeper=new dataKeeper();

function addToSum(id,val) {
		var idExpanded=id.split('-');
		var cell=idExpanded[3];
		var row=idExpanded[2];
		var table=idExpanded[0];
		if(checkSampleCount(id)){
			var value=val;
			if(!value){
				value=0;
			}
			if( row==15){
				if(value=='AC' || value=='RE'){
				}
				else {$('#'+id).val("")};
			}
			else{
				if(isNaN(value)){
					alert("please Enter a number !");
					$('#'+id).val("");
					$('#'+id).focus();
					
				}else {
					analyzer.fillSumColumn(table,parseFloat(value),row,cell);
					analyzer.setAverageFruitCount();
					analyzer.setSampleValues(id,value);
					analyzer.setPercentages(row);
					analyzer.setGeneralValues();
					analyzer.fillPercentageTable();
					analyzer.reArrangePercentages(table);
				}
			}
		
		}else {
			if(val){
				alert('Please Fill the Sample Count field !');
				$('#'+table+'-slot-'+row+'-'+cell).val("");
				$('#'+table+'-slot-'+1+'-'+cell).focus();
			}else{
			}
		}
}

function checkSampleCount(id){
	var expanded=id.split('-');
	var table=expanded[0];
	var row=expanded[2];
	var cell=expanded[3];
	if($('#'+table+'-slot-'+1+'-'+cell).val()){
		return true;
	}else return false;
}

function validateTopTable(){
	}

function findPayable(id,value){
	var textId=id;
	var idArray=textId.split('-');
	var table=idArray[0];

	var fieldId=idArray[2];
	if(fieldId=="trueWeight"){
		if($('#'+table+"-sum-noCrates").val()==""){
			alert("Please Fill the Number of Crates field!");
			$('#'+table+"-sum-noCrates").focus();
			//1-sum-notedWeight
		}else if($('#'+table+"-sum-notedWeight").val()==""){
			alert("Please Fill the Declared Quantity field!");
			$('#'+table+"-sum-notedWeight").focus();
			
		}else if($('#'+table+"-sum-trueWeight").val()==""){
			alert("Please Fill the True Weight field!");
			$('#'+table+"-sum-trueWeight").focus();
			
		}else if($('#date-toppane').val()==""){
			alert("Please Fill the Date field!");
			$("#date-toppane").focus();
			
		}else if($('#project-toppane').val()==""){
			alert("Please Fill the Project field!");
			$("#project-toppane").focus();
			
		}else if($('#vehicle-toppane').val()==""){
			alert("Please Fill the Vehicle number field!");
			$("#vehicle-toppane").focus();
			
		}else if($('#centerName1').val()=="" && $('#centerName2').val()=="" && $('#centerName3').val()=="" && 
				$('#centerName4').val()=="" && $('#centerName5').val()=="" && $('#centerName6').val()==""){
			alert("There should be at least 1 center field filled !");
			$("#centerName1").focus();
		}
		
		else{
			analyzer.completeCalculation(table);
		}
	}
}

function submitMe() {	
	var flag=true;
	if($('#date-toppane').val()==''|| $('#project-toppane').val()==''||$('#vehicle-toppane').val()==''){
		flag=false;
	}
	for(var i=1;i<5;i++){
		if($('#'+i+'-sum-notedWeight').val()!="" && $('#'+i+'-sum-notedWeight').val()!="0" ){
			if($('#'+i+'-sum-noCrates').val()=="" || $('#'+i+'-sum-trueWeight').val()=="" ){
				flag=false;
			}
		}
	}
	if(flag){
		analyzer.submitData();
	}else{
		alert('Please fill required data correctly.\nYou may missed vehicle number, project name,date ..etc ');
	}
}

function resetMe(){
	window.location.reload();
	alert("Resetting.....");
}

function resetForm(id) {
	$('#'+id).each(function(){
	        this.reset();
	});
}

function printMe() {
	analyzer.fillPrintTable(1);
	analyzer.fillPrintTable(2);
	analyzer.fillPrintTable(3);
	analyzer.fillPrintTable(4);
	clickHereToPprint();
}

function clickHereToPprint(){ 
  var disp_setting="toolbar=yes,location=no,directories=yes,menubar=yes,scrollbars=yes,width=1112, height=790, left=100, top=25"; 
  var content_vlue = document.getElementById("printArea").innerHTML; 
  var docprint=window.open("","",disp_setting); 
   docprint.document.open(); 
   docprint.document.write('<link rel="stylesheet" href="css/insertionData.css" type="text/css">');    
   docprint.document.write('<body onLoad="self.print()">');          
   docprint.document.write(content_vlue);          
   docprint.document.write('</body>');
   docprint.document.close(); 
   docprint.focus(); 

}

function handleQuantityData(){
	var numOfGrades=$('#numberOfGrades').val();
	for(var i=1;i<=numOfGrades;i++){
		var AQ=0;
		for(var j=0;j<20;j++){
			AQ+=Number( $('#gr-'+j+'-'+i).val());
		}
		arrayKeeper.storeArray("grade"+i,AQ);
		$('#'+i+'-sum-notedWeight').val(arrayKeeper.getArray("grade"+i));
	}
}
