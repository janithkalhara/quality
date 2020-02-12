var editWeekCount=0;
var lastWeekCount = 0;
var p=0;
$('document').ready(function(){

	$('#addForm').css('display','block');
	
	$('#addText').click(function(){
		//$('#dataForm').html($('#addForm').html());
		$('#addForm').css('display','block');
		$('#editForm').css('display','none');
	});
	$('#editText').click(function(){
		//$('#dataForm').html($('#editForm').html());
		$('#addForm').css('display','none');
		$('#editForm').css('display','block');
			
	});
	
	$('#editSeason').blur(function(){
		var projectNameEdit = $('#editSupplierArrival').val();
				
		if(projectNameEdit !=""){
			var subGradeEdit = $('#editGradeArrival').val();
			var seasonEdit = $('#editSeason').val();
			$.post("modules/mod_mainPanel/ArrivalPatternManager.php",{projectNameEdit:projectNameEdit, subGradeEdit : subGradeEdit, seasonEdit : seasonEdit}, function(data){
				if(data != "No Arrival Pattern found"){
					$('#editDataTable').html(data);
					$('#editDataTableNew').html("");
					$('#editDataTableDiv').fadeIn('fast');
					$('#submitButEditArrival').show();
					$('#resetButEditArrival').show();
					$('#weekButEditArrival').show();
					$('#submitButArrival').hide();
					$('#resetButArrival').hide();
					getTableRows();
				}else{
					alert(data);
				}
			});			
		}
	});
	
	
$('#start-date').datepicker({ dateFormat: 'yy-mm-dd',onSelect: setDate });
	$('#end-date').datepicker({ dateFormat: 'yy-mm-dd'});
	
	$('#txtQuantity').blur(function(){
		if($('#start-date').val() != ""){
		var quantity = $('#txtQuantity').val();

		if(!isNumber(quantity)){
			$('#txtQuantity').val("");
			$('#txtQuantity').focus();
			alert("Invalid Value");			
		}
		
		if(quantity != "" && isNumber(quantity)){
		weekCount++;
		
		var viewTable = $('#dataTable3').html();
		var startDate = $('#start-date').val();
		var endDate = $('#end-date').val();
		var quantity = $('#txtQuantity').val();
		
		var startDateNew = new Date(startDate);
		
		if(startDateNew.getDate()<10){
			var startDateNow = startDateNew.getFullYear()+"-"+(startDateNew.getMonth()+1)+"-"+("0"+ startDateNew.getDate());
		}else{		
			var startDateNow = startDateNew.getFullYear()+"-"+(startDateNew.getMonth()+1)+"-"+startDateNew.getDate();
		}

		var tableHeader = '<tr style="background-color: none;text-align: center; font-weight: bold;" >'
			+'<th>Week</th>'
			+ '<th>From</th>'
			+ '<th>To</th>'
			+ '<th>Quantity</th>'
			+ '</tr>' ;
		
		var weekValue = "<tr style='background-color:#ccc;text-align:center;' ><td id='week-"+weekCount+"'> week - "+weekCount+"</td>" +
				"<td id='from-"+weekCount+"'>" + startDateNow + "</td>" +
				"<td id='to-"+weekCount+"'>" + endDate + "</td>" +
				"<td width='200'><input id='quantity-"+ weekCount +"' value='" + quantity + "' /></td>" +
				"</tr>";

		if(weekCount == 1){		
		viewTable += tableHeader;
		}
		var newView = viewTable + weekValue;
		$('#dataTable3').html(newView);
		$('#weekTable').fadeIn('fast');
		$('#submitButArrival').show();
		$('#resetButArrival').show();
		$('#submitButEditArrival').hide();
		$('#resetButEditArrival').hide();
		$('#weekButEditArrival').hide();
		toBottom();

		var d = new Date(endDate);
		d.setDate(d.getDate() + 7);
		if(d.getDate()<10){
			var newDate = d.getFullYear()+"-"+(d.getMonth()+1)+"-"+("0"+ d.getDate());
		}else{		
			var newDate = d.getFullYear()+"-"+(d.getMonth()+1)+"-"+d.getDate();
		}
		
		var dd = new Date(endDate);
		dd.setDate(dd.getDate() + 1);
		if(dd.getDate()<10){
			var newStartDate = dd.getFullYear()+"-"+(dd.getMonth()+1)+"-"+("0"+ dd.getDate());
		}else{		
			var newStartDate = dd.getFullYear()+"-"+(dd.getMonth()+1)+"-"+dd.getDate();
		}
	
		$('#start-date').val(newStartDate);
		$('#end-date').val(newDate);
		$('#txtQuantity').val("");
		}

		}else{
			alert("Fill the date field first");
		}
});	

	$('#submitButArrival').click(function(){
		var arrivalArray = new Array;
		arrivalArray[1] =$('#supplierArrival').val();
		arrivalArray[2] = $('#gradeArrival').val();
		arrivalArray[3] = $('#season').val();
				
		var dataArray = new Array;
			for(var i=0; i<weekCount; i++ ){
				dataArray[i] = new Array(2);
				dataArray[i][0] = $('#from-' + (i+1)).html();
				dataArray[i][1] = $('#to-' + (i+1)).html();
				dataArray[i][2] = $('#quantity-'+(i+1)).val();
				dataArray[i][3] = $('#week-'+(i+1)).html();
			}
			if(arrivalArray[3] != ""){	
			$.post("modules/mod_mainPanel/ArrivalPatternManager.php", {arrivalArray : arrivalArray, dataArray : dataArray}, function(data){
				alert(data);

			});				
			}else{
				alert("fill the Season field");
				$('#season').focus();
			}
		});	
	
	$('#supplierArrival').keyup(function(){
		var supplierArrival = $('#supplierArrival').val();
		
		$.post("modules/mod_mainPanel/ArrivalPatternManager.php",{supplierArrival : supplierArrival}, function(data){
			if(supplierArrival != ""){
				$('#showProjectNames').html(data);
				$('#showProjectNames').fadeIn('slow');
			}else{
				$('#showProjectNames').fadeOut('slow');
				}	
		});

	});

$('#editSupplierArrival').keyup(function(){
	var editSupplierArrival = $('#editSupplierArrival').val();
	
	$.post("modules/mod_mainPanel/ArrivalPatternManager.php",{supplierArrivalEdit : editSupplierArrival}, function(data){
		if(editSupplierArrival != ""){
			$('#showProjectNamesEdit').html(data);
			$('#showProjectNamesEdit').fadeIn('slow');
		}else{
			$('#showProjectNamesEdit').fadeOut('slow');
			}	
	});

});

$('#weekButEditArrival').click(function(){
	var fromDate = $('#toEdit-'+ (editWeekCount-1)).val();
	var toDate =new Date(fromDate);
	toDate.setDate(toDate.getDate() + 6); 
		
	if(toDate.getDate()<10 && toDate.getMonth()<9){
		toDateEdit = toDate.getFullYear()+"-"+("0"+ (toDate.getMonth()+1))+"-"+("0"+ toDate.getDate());
	}if(toDate.getDate()>=10 && toDate.getMonth()<9){		
		toDateEdit = toDate.getFullYear()+"-"+("0"+ (toDate.getMonth()+1))+"-"+toDate.getDate();
	}if(toDate.getDate()<10 && toDate.getMonth()>=9){		
		toDateEdit = toDate.getFullYear()+"-"+(toDate.getMonth()+1)+"-"+("0"+toDate.getDate());
	}if(toDate.getDate()>=10 && toDate.getMonth()>=9){		
		toDateEdit = toDate.getFullYear()+"-"+(toDate.getMonth()+1)+"-"+toDate.getDate();
	}
	
	
	var newWeek = "<tr style='background-color:#ccc;text-align:center;' ><td id='weekEdit-"+editWeekCount+"'> week - "+editWeekCount+"</td>" +
	"<td ><input type='text' value='"+fromDate+"' id='fromEdit-"+editWeekCount+"' onclick=setWeekCount('"+editWeekCount+"') /></td>" +
	"<td ><input type='text' value='"+toDateEdit+"' id='toEdit-"+editWeekCount+"' /> </td>" +
	"<td width='200'><input type='text' id='quantityEdit-"+ editWeekCount +"' /></td>" +
	"</tr>";
	
	$('#editDataTable > tbody > tr').eq(editWeekCount-1).after(newWeek);
	toBottomEdit();
	
	setDatePicker(editWeekCount);
	editWeekCount++;	
});

$('#submitButEditArrival').click(function(){
	
	var projectEditSave = $('#editSupplierArrival').val();
	var subGradeEditSave = $('#editGradeArrival').val();
	var seasonEditSave = $('#editSeason').val();

	var firstTableData = new Array;
	var secondTableData = new Array;
	
	for(var m=1;m<lastWeekCount;m++){
		var RawValueFirst = new Array;
		RawValueFirst[0] = $('#fromEdit-' + m).val();
		RawValueFirst[1] = $('#toEdit-' + m).val();
		RawValueFirst[2] = $('#quantityEdit-' +m).val();
		RawValueFirst[3] = $('#weekEdit-' +m).html();
		
		firstTableData[m] = RawValueFirst;		
 	}
	
	if(editWeekCount >lastWeekCount){
	for(var n=lastWeekCount;n<editWeekCount;n++){		
		
		var RawValueSecond = new Array;
		RawValueSecond[0] = $('#fromEdit-' + (n)).val();
		RawValueSecond[1] = $('#toEdit-' + (n)).val();
		RawValueSecond[2] = $('#quantityEdit-' + (n)).val();
		RawValueSecond[3] = $('#weekEdit-' + (n)).html();
		
		secondTableData[p] = RawValueSecond;
		p++;
		}
 	}	
	
	$.post("modules/mod_mainPanel/ArrivalPatternManager.php",{projectEditSave:projectEditSave ,subGradeEditSave:subGradeEditSave ,seasonEditSave:seasonEditSave,firstTableData:firstTableData,secondTableData: secondTableData}, function(data){
		alert(data);
		
	});
	
	
	
});
});	

var weekCount=0;
var weekNo =0;

function setDate(){
	var startDateNew = $('#start-date').val();
	var d = new Date(startDateNew);
	d.setDate(d.getDate() + 6);
	if(d.getDate()<10){
		var newDateSet = d.getFullYear()+"-"+(d.getMonth()+1)+"-"+("0"+ d.getDate());
	}else{		
		var newDateSet = d.getFullYear()+"-"+(d.getMonth()+1)+"-"+d.getDate();
	}
	$('#end-date').val(newDateSet);
	
}
function setDateEdit(){	
	var startDateNewEdit = $('#fromEdit-' + weekNo).val();
	var newDateSetEdit = 0;
	for(var j=1;j<editWeekCount;j++){
	var dd = new Date(startDateNewEdit);
	dd.setDate(dd.getDate() + 6);
	
	if(dd.getDate()<10 && dd.getMonth()<9){
		newDateSetEdit = dd.getFullYear()+"-"+("0"+ (dd.getMonth()+1))+"-"+("0"+ dd.getDate());
	}if(dd.getDate()>=10 && dd.getMonth()<9){		
		newDateSetEdit = dd.getFullYear()+"-"+("0"+ (dd.getMonth()+1))+"-"+dd.getDate();
	}if(dd.getDate()<10 && dd.getMonth()>=9){		
		newDateSetEdit = dd.getFullYear()+"-"+(dd.getMonth()+1)+"-"+("0"+dd.getDate());
	}if(dd.getDate()>=10 && dd.getMonth()>=9){		
		newDateSetEdit = dd.getFullYear()+"-"+(dd.getMonth()+1)+"-"+dd.getDate();
	}
	
	$('#toEdit-' + weekNo).val(newDateSetEdit);
	startDateNewEdit = newDateSetEdit;
	weekNo++;
	$('#fromEdit-' + weekNo).val(startDateNewEdit);
	}
}


function isNumber (o) {
	  return ! isNaN (o-0);
}

function toBottom(){
	nDiv = document.getElementById('weekTable');
	setTimeout("nDiv.scrollTop = nDiv.scrollHeight",1);
}

function toBottomEdit(){
	nDivNew = document.getElementById('editDataTableDiv');
	setTimeout("nDivNew.scrollTop = nDivNew.scrollHeight",1);
}


function setProjectName(projectName){
	$('#supplierArrival').val(projectName);
	$('#showProjectNames').fadeOut('slow');

	$.post("modules/mod_mainPanel/ArrivalPatternManager.php",{projectName: projectName}, function(data){
			$('#gradeArrival').html(data);
		});	
}

function setProjectNameEdit(projectName){
	$('#editSupplierArrival').val(projectName);
	$('#showProjectNamesEdit').fadeOut('slow');

	$.post("modules/mod_mainPanel/ArrivalPatternManager.php",{projectName: projectName}, function(data){
			$('#editGradeArrival').html(data);
		});	
}

function getTableRows(){ 
	editWeekCount = $('#editDataTable tr').length;
	lastWeekCount = $('#editDataTable tr').length;
	
	for(var i=1;i<editWeekCount;i++){
		$('#fromEdit-'+i).datepicker({ dateFormat: 'yy-mm-dd',onSelect: setDateEdit });
	}
}	
function setWeekCount(weekNO) {
	weekNo = weekNO;
}
function setDatePicker(rowNo){
	$('#fromEdit-'+ rowNo).datepicker({ dateFormat: 'yy-mm-dd',onSelect: setDateEdit });
}
