var transportData = [0,0,0,0,0,0];
var store_headerData = {};
var store_tableData = [];
for(var i=0;i<4;i++){
	store_tableData[i] = {mode:false,data:{samples:[],sums:[],pers:[]}}
	/*for(j=0;j<13;j++){
		store_tableData[i][j]=Array(10);
	}*/
}

var store_balanceSheet = [];

for(var i=0;i<6;i++){
	store_balanceSheet[i] = [];
	
}

var store_crsData = [];

for(var i=0;i<15;i++){
	store_crsData[i] = Array(13);
	
}
var store_balanceSheetOffGrade = Array(6);

function displayTable(){
         $('#transportCondition').toggle("blind",{},500);
}

function closeTransportCondition(){
	 $('#transportCondition').hide("blind",{},500);
} 

function viewImageUploader() {
	  $('#imageUploaderDiv').toggle("blind",{},500);
}

function keepAway(){
	 $('#imageUploaderDiv').hide("blind",{},500);
}

function resetMe() {
	for(var i=0;i<6;i++){
		if($('#form'+i)[0]!=null){
			$('#form'+i)[0].reset();
			continue;
		}else{
			continue;
		}
	}
}

function printMe(){
	setDataToManipulate();
	printBalanceSheet();
	printReport();
}

function submitMe(){
	setDataToManipulate();
	submitData();
}

function setDataToManipulate(){
	setHeaderData();
	setTableData();
	setCRSData();
	setTransportData();
	setBalanceSheetData();
}


function setHeaderData() {
	// project
	$('#print-project').html($('#project-toppane').val());
	// centers
	$('#print-centers').html($('#center-toppane').val());
	// date
	$('#print-date').html($('#date-toppane').val());
	// Batch-No
	$('#print-batchNo').html($('#batchNo-toppane').val());
	// vehicle No
	$('#print-vehicleNo').html($('#vehicleNo-toppane').val());
	// ITM No
	$('#print-itmNo').html($('#itmNo-toppane').val());
	
	store_headerData['project'] = $('#project-toppane').val();
	store_headerData['centers'] = $('#center-toppane').val();
	store_headerData['date'] = $('#date-toppane').val();
	store_headerData['batchNo'] = $('#batchNo-toppane').val();
	store_headerData['vehicleNo'] = $('#vehicleNo-toppane').val();
	store_headerData['itmNo'] = $('#itmNo-toppane').val();
}

function setTableData(){
	for(var i=0;i<4;i++){
		var flag = $('#toggler-'+i).is(':checked');
		store_tableData[i].mode = flag;
		/*for(var j=0;j<13;j++){
			for(var k=0;k<10;k++){
		*/		/*$('#'+i+'-'+k+'-'+j).html($('#table-'+i+'-'+k+'-'+j).val());
				store_tableData[i][j][k]=$('#table-'+i+'-'+k+'-'+j).val();*/
				var length = 18;//no limiting . data will submit to server.flag?18:10;
				store_tableData[i].data.samples = [];
				store_tableData[i].data.sums = [];
				store_tableData[i].data.pers = [];
				var storablesample = false;
				for(var j=0;j<13;j++){
					storablesample = false;
					var t = [];
					var val = 0;
					for(var k=0;k<length;k++) {
						val = $('#table-'+i+'-'+k+'-'+j).val();
						val = typeof(val)!=='undefined' && val!='' ? val : 0;
						if(val != 0) {
							storablesample = true;
						}
						t[k] = val;
					}
					if(storablesample) {
						store_tableData[i].data.samples.push(t);
					}
				}
				for(var k=1;k<length;k++){
			//per and sum
					var val = $('#table-'+i+'-'+k+'-13').val();
					val = typeof(val)!=='undefined'&& val!=''?val:0;
					val = parseFloat(val);
					store_tableData[i].data.sums.push(val);
					val = $('#table-'+i+'-'+k+'-14').val();
					val = typeof(val)!=='undefined'&& val!=''?val:0;
					val = parseFloat(val);
					store_tableData[i].data.pers.push(val);
				}
			}
			printGrades = ["11-14.5","14.5-17","17-29","29-44","CRS"];
			for(var i=0;i<5;i++){
				$('#'+i+"-grade").html(printGrades[i]);
			}
}
function setCRSData(){
	for(var i=0;i<15;i++){
		for(var j=0;j<13;j++){
			// get from table-4-1-1 set to crs-0-0
			$('#crs-'+j+'-'+i).html($('#table-4-'+j+'-'+i).val());
			store_crsData[i][j]=$('#table-4-'+j+'-'+i).val();
		}
	}
}

function setTransportData(){
	var index=Array('ඇත','නැත');
	transportData[0]= $("input[name='delivery']:checked").val();
	transportData[1]= $("input[name='cover']:checked").val();
	transportData[2]= $("input[name='smell']:checked").val();
	transportData[3]= $("input[name='otherThings']:checked").val();
	transportData[4]= $("input[name='colorcode']:checked").val();
	transportData[5]= $("input[name='qualityReport']:checked").val();
	
	$('#transport-delivery').html(index[transportData[0]]);
	$('#transport-cover').html(index[transportData[1]]);
	$('#transport-smell').html(index[transportData[2]]);
	$('#transport-otherthings').html(index[transportData[3]]);
	$('#transport-labels').html(index[transportData[4]]);
	$('#transport-qualityReport').html(index[transportData[5]]);	
} 

function setBalanceSheetData(){
	$('#date-balancesheet').html($('#date-toppane').val());
	$('#project-balancesheet').html($('#project-toppane').val());
	for(var i=0;i<6;i++){
		for(var j=0;j<10;j++){
			$('#printBsheet-'+i+'-'+j).html($('#bsheet-'+(i+1)+'-'+(j)).val());
			store_balanceSheet[i][j]=$('#bsheet-'+(i+1)+'-'+(j)).val();
		}
	}
	for (var j=0;j<6;j++){
		$('#'+j+'-print-offgrade').html($('#'+(j+1)+'-offgrade').val());
		store_balanceSheetOffGrade[j]=$('#'+(j+1)+'-offgrade').val();
	}
	for(var i=2;i<10;i++){
		$("#printBsheet-6-"+i).html($('#bsheet-7-'+(i+1)).val());
		
	}
}

function submitData(){
	/* save small gherkin crop */
	var submit=true;
	if($('#project-toppane').val()==""){
		alert('Please enter the Project!');
		$('#project-toppane').focus();
		submit=false;
		return false;
	}
	
	if($('#date-toppane').val()==""){
		alert('Please enter the date!');
		$('#date-toppane').focus();
		submit=false;
		return false;
		
	}
	
	if($('#batchNo-toppane').val()==""){
		alert('Please enter the Batch Number!');
		$('#batchNo-toppane').focus();
		submit=false;
		return false;
		
	}

	if($('#center-toppane').val()==""){
		alert('Please enter the Centers!');
		$('#center-toppane').focus();
		submit=false;
		return false;
		
	}
	
	if($('#vehicleNo-toppane').val() == ""){
		alert('Please enter the Vehicle Number!');
		$('#vehicleNo-toppane').focus();
		submit = false;
		return false;
		
	}
	
	if($('#itmNo-toppane').val() == ""){
		alert('Please enter the ITM number!');
		$('#itmNo-toppane').focus();
		submit = false;
		return false;
	}

	if(submit == false){
		return false;
	}
	else{
		$('#loading-div').show('500');
		var cropArray = [];
		for(var i=0;i<10;i++){
			cropArray[i] = store_balanceSheet[5][i];
		}
		var numOfCrates = $('#numofcrates').val();
		var tmnumbers = $('#tmNumbers').val();
		var pid = $('#project-toppane').val();
		var saveCrop = {'projectId':pid,
				'project':store_headerData['project'],
				'centers':store_headerData['centers'],
				'date':store_headerData['date'],
				'batchNo':store_headerData['batchNo'],
				'vehicleNo':store_headerData['vehicleNo'],
				'itmNo':store_headerData['itmNo'],
				'totalOffGrade':store_balanceSheetOffGrade[5],
				'totalData':cropArray,
				'numOfCrates':numOfCrates,
				'tmnumbers':tmnumbers,
				'transport':transportData
				};
		var gradeArray = [];
		for(var i = 0;i < 5;i++){
			var flag = $('#toggler-'+i).is(':checked');
			var afc = $('#avg-fc-'+(parseInt(i))).html();
			gradeArray[i] = {mode:flag, data:Array(11),afc:typeof(afc)!='undefined'?afc:0};
			for(var j = 0;j < 11;j++){
				if(j == 10){
					gradeArray[i]['data'][j] = store_balanceSheetOffGrade[i];
				}
				else{
					gradeArray[i]['data'][j] = store_balanceSheet[i][j];
				}
			}
		}
		var percentages = [];
		for(var i = k;k<11;k++){
			percentages[k] = Number($('#bsheet-7-'+k).val());
		}
	
		var saveGradeData = {
				'projectId':pid,
				'project':store_headerData['project'],
				'date':store_headerData['date'],
				'vehicleNo':store_headerData['vehicleNo'],
				'totalData':gradeArray,
				'offGrades':store_balanceSheetOffGrade,
				'percentages':percentages
			};
		var saveGradeSampleData = {
			'projectId':pid,
			'project':store_headerData['project'],
			'date':store_headerData['date'],
			'vehicleNo':store_headerData['vehicleNo'],
			'samples':store_tableData
		};
		var saveGradeSampleCRSData = {
			'projectId':pid,
			'project':store_headerData['project'],
			'date':store_headerData['date'],
			'vehicleNo':store_headerData['vehicleNo'],
			'crs_samples':store_crsData
		};
		var dataArray = [];
		var images = [];
		var images_desc = [];
		var exts = [];
		for(var i=0;i<3;i++){
			if($('#file-nm-'+i).val()){
				images[i] = $('#file-nm-'+i).val();
				var extension = images[i].substr(images[i].lastIndexOf('.'));
				exts[i] = extension;
				images[i] = i;
			}else{
				images[i] = "";
				exts[i] = "";
			}
		}	
		for(var k = 0;k<3;k++){
			images[k] = images[k]+exts[k];
		}
		for(var i = 0;i<3; i++){
			if($('#file-'+i).val()){
				images_desc[i] = $('#file-'+i).val();
			}else{
				images_desc[i] = "";
			}
		}
	
		var saveImageData = {
				'projectId':pid,
				'project':store_headerData['project'],
				'date':store_headerData['date'],
				'vehicleNo':store_headerData['vehicleNo'],
				'imagesDesc':images_desc,
				'images':images
				};
		var quantityArraySet = new Array;
		for(var i=0;i<20;i++){
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
		var saveCenterQuantity = quantityArraySet;
		var user = $('#userId').val();
		var station = $('#print-centerName').val();
		var saveUserData = {'flag':'saveUserData',
			'projectId':pid,
			'project':store_headerData['project'],
			'date':store_headerData['date'],
			'vehicleNo':store_headerData['vehicleNo'],
			'user':user,
			'station':station
			}
		var sendingArray = {"flag":"save",
					"saveCrop":saveCrop,
					"saveGradeData":saveGradeData,
					"saveGradeSampleData":saveGradeSampleData,
					"saveGradeSampleCRSData":saveGradeSampleCRSData,
					"saveImageData":saveImageData,
					"saveCenterQuantity":saveCenterQuantity,
					"saveUserData":saveUserData
				}
	//console.log(sendingArray);
	$.post('modules/mod_smallFruitInsertion/ajax/dataHandlerv2.php',sendingArray,function(data){
		alert(data.message);
		$('#loading-div').hide('500');
	});
	}
}

function printReport(){
	
	console.log('qreport');
	
	var disp_setting = "toolbar=yes,location=no,directories=yes,menubar=yes,"; 
    disp_setting += "scrollbars=yes,width=1112, height=790, left=100, top=25"; 
    var content_vlue = document.getElementById("printContainer").innerHTML; 
    var docprint = window.open("","",disp_setting); 
    docprint.document.open(); 
    docprint.document.write('<link rel="stylesheet" href="css/insertionData.css" type="text/css">');    
    docprint.document.write('<body onLoad="self.print()">');          
    docprint.document.write(content_vlue);          
    docprint.document.write('</body>');
    docprint.document.close(); 
    docprint.focus(); 
}

function printBalanceSheet(){
	var disp_setting2 = "toolbar=yes,location=no,directories=yes,menubar=yes,"; 
    disp_setting2 += "scrollbars=yes,width=1112, height=790, left=100, top=25"; 
    var content_vlue2 = document.getElementById("print-BalanceSheetContainer").innerHTML; 
    var docprint2 = window.open("","",disp_setting2); 
    docprint2.document.open(); 
    docprint2.document.write('<body onLoad="self.print()">');          
    docprint2.document.write(content_vlue2);          
    docprint2.document.write('</body>');
    docprint2.document.close(); 
    docprint2.focus(); 
}
