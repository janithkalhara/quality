var existGrade;
var numOfRows = 0;
$('document').ready(function(){

	$('#gradeForm').html($('#subGradeAddForm').html());
	
	
$.post("modules/mod_mainPanel/GradeManager.php",{viewGrade : 'view2'}, function(data){
		$('#gradeView').html(data.trim());
});			
						
			
/* ----------------------------- Grade Category Edit Scripts ------------------------------------ */		
			
});

function editGrade(gradeCategoryId,gradeCategoryName,flag){
	
    var gradeCatId = gradeCategoryId;
    var gradeCatName = gradeCategoryName;    
	
    $('#waiting-div').show();
	$.post("modules/mod_mainPanel/GradeManager.php",{gradeCatId : gradeCatId}, function(data){
		
			$('#subgradeform')[0].reset();
		   $('#validGradecat').html("");
		   $('#validFc').html("");
		   $('#validDiameter').html("");
		   $('#validSampleweight').html("");
			   
		   if(data.success){
			   var gradeData = data.data;
			   var gradeTable = "<table id='gradeTable' class='table table-stripped'><tr><th>Fruit Count</th><th>Diameter</th><th>Sample Weight</th><th>Defect Reductions(%)</th><th>Order</th></tr>";
			   numOfRows = gradeData.length;
			   for(i=0;i<gradeData.length;i++){
				   var gradeRow = "<tr><td><input type='hidden' id='row-"+i+"-gid' value='"+ gradeData[i]['gradeId'] +"' /><input type='text' id='row-"+i+"-fc' value='"+gradeData[i]['fruitCount'] +"' /></td>";
				   gradeRow += "<td><input type='text' id='row-"+i+"-dmtr' value='"+gradeData[i]['diameter'] +"' /></td>";
				   gradeRow +=  "<td><input type='text' id='row-"+i+"-sw' value='"+gradeData[i]['sampleWeight'] +"' /></td>";
				   gradeRow +=  "<td><input type='text' id='row-"+i+"-dr' value='"+gradeData[i]['offgradereduce'] +"' /></td>";
				   gradeRow +=  "<td><input type='text' id='row-"+i+"-order' value='"+gradeData[i]['order'] +"' /></td>";
				   gradeRow +=	"<td><button class='btn btn-xs btn-danger' onclick='deleteGrade(\""+gradeCatId+"\",\""+gradeCatName+"\",\""+gradeData[i]['gradeId']+"\")'><i class='icon icon-trash'></i> </button></td></tr>";
				   
				   gradeTable += gradeRow;				   
			   }
			   gradeTable += "</table>"; 
			   
			   var topicText = "<h3> Sub Grades : " + gradeCatName +  " Category</h3>";
			   var gradeCategoryInput = " Grade Category : <input type='text' id='gradeCatNameEdit' value='"+gradeCatName+"' /><br/><br/>";
			   var buttons = $('#subGradeEditForm').html();
			   
			   existGrade = gradeCatId;
			   
			   $('#gradeForm').html( topicText + gradeCategoryInput +gradeTable + buttons);
			   $('#waiting-div').hide();
		   }else{		   
			   $('#gradeForm').html($('#subGradeAddForm').html());
			   
			   $.post("modules/mod_mainPanel/GradeManager.php",{categories:'categories'},function(data){
					$('#gradeCat').html(data.trim());
				});
			   
			   if(flag == 0){
				   $('#gradeCattxt').val(gradeCategoryName);
				   $('#hidden-grade-cate').val(gradeCatId);
				   $('#submitButGradeCat').val("Update");
			   }
			   $('#waiting-div').hide();
			   alert("No Sub Grades ");
		   }	   	    
		   
		});   
}

function delGrade(gradeCategoryId){
    var gradeId = gradeCategoryId;
	if(confirm("Do you need to remove the selected Grade Category ?")){
		$.post("modules/mod_mainPanel/GradeManager.php", {delgradeId : gradeId}, function(data){
    	
			$.post("modules/mod_mainPanel/GradeManager.php",{viewGrade : 'view2'}, function(data){
				$('#gradeView').html(data.trim());
			});
    	
			$.post("modules/mod_mainPanel/GradeManager.php",{categories:'categories'},function(data){
				$('#gradeCat').html(data.trim());
			});
    	
			alert(data.trim());
        });	
    }
}

function submitCategoryData(){
	var catButValue = $('#submitButGradeCat').val();
	var catName = $('#gradeCattxt').val();
	var catId = $('#hidden-grade-cate').val();
				
	if(catName != ""){
		$('#waiting-div').show();
		$.post("modules/mod_mainPanel/GradeManager.php",{gradeCategorySave: catName, catButValue : catButValue, catId : catId },function(data){
			
			$('#submitgradecatmsg').fadeIn('slow');
			setTimeout("$('#submitgradecatmsg').fadeOut('slow')", 4000);
		
			$.post("modules/mod_mainPanel/GradeManager.php",{viewGrade : 'view2'}, function(data){
				$('#gradeView').html(data.trim());
			});
			
			$('#gradeCattxt').val("");
			$('#submitButGradeCat').val("Submit");
						
			$('#waiting-div').hide();
		});
	
		$.post("modules/mod_mainPanel/GradeManager.php",{categories:'categories'},function(data){
			$('#gradeCat').html(data.trim());
		});
		
	}else{
			$('#validGradecatName').html("* Required");
			$('#gradeCattxt').focus();
												
	}
	$('#gradeCattxt').keydown(function(){
		$('#validGradecatName').html("");					
	});	
}

function submitSubGradeData(){
	
	/*gradeData[0] = $('#gradeCat').val();
	gradeData[1] = "";
	gradeData[3] = $('#fctxt').val();
	gradeData[4] = $('#diametertxt').val();
	gradeData[5] = $('#sampleweighttxt').val();
	gradeData[6] = $('#reduction').val();
	gradeData[6] = $('#order').val();*/
	var gradeData = {
			flag : "savegrade",
			cate : $('#gradeCat').val(),
			fc : $('#fctxt').val(),
			diameter : $('#diametertxt').val(),
			sampleweight : $('#sampleweighttxt').val(),
			maingrade : $('[name=maingrade]').val(),
			reduction : $('#reduction').val(),
			order : $('#order').val()
	}; 
    if(gradeData.cate != '-1' && gradeData.fc != "" && gradeData.diameter != "" && gradeData.sampleweight != ""){
    
    $('#waiting-div').show();
	$.post("modules/mod_mainPanel/GradeManager.php",{gradeData : gradeData}, function(data){
			
			$('#subgradeform')[0].reset();
			$('#submitsubgrademsg').fadeIn('slow');
			setTimeout("$('#submitsubgrademsg').fadeOut('slow')", 4000);
			$('#submitButGrade').val("Submit");

			$('#waiting-div').hide();
	});
    }
    if(gradeData.sampleweight == ""){
        $('#validSampleweight').html("* Required");
        $('#sampleweighttxt').focus();
    }if(gradeData.diameter == ""){
        $('#validDiameter').html("* Required");
        $('#diametertxt').focus();
    }if(gradeData.fc == ""){
        $('#validFc').html("* Required");
        $('#fctxt').focus();
    }			    
	if(gradeData.cate == '-1'){
		$('#validGradecat').html("* Required");
		
	}
/* --------------------- Clearing Validation Fields ---------------------------- */	
	
	$('#gradeCattxt').keydown(function(){
		$('#validGradecat').html("");
		});
	$('#fctxt').keydown(function(){
        $('#validFc').html("");
        });
	$('#diametertxt').keydown(function(){
        $('#validDiameter').html("");
        });
	$('#sampleweighttxt').keydown(function(){
        $('#validSampleweight').html("");
        });

	$('#gradeCat').change(function(){
		$('#validGradecat').html("");				
	});
	
	
}


function exit(){		
	$('#gradeForm').html($('#subGradeAddForm').html());	
	$.post("modules/mod_mainPanel/GradeManager.php",{categories:'categories'},function(data){
		$('#gradeCat').html(data.trim());
	});
}
function resetForm(){
	
	$('#gradeCatEditForm')[0].reset();	
}
function submitForm(){
	var gradeCatId = existGrade;
	var gradeCatName = $('#gradeCatNameEdit').val();
	var status = true;
	
	$('#gradeTable input[type="text"]').each(function(){
		if($(this).val() == ""){
			status = false;
			return false;
		}		
	});
	
	if(gradeCatName != "" && status){
		var submitArray = {grades:[], cate:{}};
		$('#waiting-div').show();
		submitArray.cate = {cate :gradeCatId,
				cate_name : $('#gradeCatNameEdit').val()}
		for(j=0;j<numOfRows;j++){
			var rowData = {
					id :  $('#row-'+j+'-gid').val(),
					fc : $('#row-'+j+'-fc').val(),
					diameter : $('#row-'+j+'-dmtr').val(),
					sampleweight:$('#row-'+j+'-sw').val(),
					reduction : $('#row-'+j+'-dr').val(),
					ordr : $('#row-'+j+'-order').val()
			};
			
			/*rowData[0] = gradeCatId;
			rowData[1] = $('#row-'+j+'-gid').val();
			rowData[3] = $('#row-'+j+'-fc').val();
			rowData[4] = $('#row-'+j+'-dmtr').val();
			rowData[5] = $('#row-'+j+'-sw').val();
			rowData[6] = $('#row-'+j+'-dr').val();*/
			submitArray.grades.push(rowData);
		}
	
		$.post("modules/mod_mainPanel/GradeManager.php", {flag:'updateData',submitArray : submitArray},function(data){
			if(data.success){
				$.post("modules/mod_mainPanel/GradeManager.php",{viewGrade : 'view2'}, function(data){
					$('#gradeView').html(data.trim());
				});
				alert(data.message);
				$('#waiting-div').hide();
				
			}else{
				alert(data.message);
			}
		});
	}else{
		alert("Please fill required fields");
	}	
}

function deleteGrade(catId,catName,gradeId){
	
	if(confirm("Do you need to remove the selected Sub Grade ?")){
		$('#waiting-div').show();
		$.post("modules/mod_mainPanel/GradeManager.php",{deleteSubGrade:gradeId},function(data){
			editGrade(catId,catName,1);
			alert("Sub Grade deleted Successfully");
		
		});			
		$('#waiting-div').show();
	}
	
}

/*
 * resetting function calls
 */

function resetSubGradeForm(){
	$('#submitButGrade').val("Submit");				
	$('#validGradecat').html("");
	$('#validSampleweight').html("");
	$('#validDiameter').html("");
	$('#validSampleweight').html("");
	$('#reduction').html("");
	$('#validFc').html("");
	$('#subgradeform')[0].reset();
	
}

function resetGradeCatForm(){
	$('#submitButGradeCat').val("Submit");				
	$('#validGradecatName').html("");
	$('#gradeCattxt').val("");
	
}

