$('document').ready(function() {
	$("#date-small").datepicker({dateFormat: 'yy-mm-dd'});
	
});

function calculate(id){
	var butId = id;
	var field = id.split("-");
	var fieldNo = field[1];
	var fieldVal = 0;
	parseFloat(fieldVal);
	for(var i=1;i<6;i++){
		var fieldValue = $('#'+i+'-'+fieldNo).val();
		if(fieldValue != ""){
			fieldVal += parseFloat(fieldValue);
		}
	}
	$('#6-'+ fieldNo).val(fieldVal);
	
}

function setKey(keyVal,e){
    var keyVal = keyVal;
    var keyArray = keyVal.split("-");

    var tableNo = parseInt(keyArray[0]);
    var selectedKey = parseInt(keyArray[1]);
        
    if(e.keyCode == '39'){ 
        var next =  selectedKey+1;
        $('#'+tableNo+'-'+next).focus();

        if(selectedKey == 10){
        	 var down = tableNo + 1 ;
             $('#'+down+'-'+1).focus();
        }
    }
    if(e.keyCode == '37'){
        if(selectedKey != 1){ 
            var prev =  selectedKey - 1;
            $('#'+tableNo+'-'+prev).focus();
        }
        if(selectedKey == 1 && tableNo != 1){ 
        	var down = tableNo - 1 ;
            $('#'+down+'-'+10).focus();
        }        
    }
    if(e.keyCode == '40'){
            var down = tableNo + 1 ;
            $('#'+down+'-'+1).focus();        
    }
    if(e.keyCode == '38'){
        if(tableNo != 1){
            var down = tableNo - 1 ;
            $('#'+down+'-'+1).focus();
        }        
    }	
}
