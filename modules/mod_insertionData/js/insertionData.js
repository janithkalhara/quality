$(document).ready(function(){
	var i= j = k = n = 0;
		$('#project-toppane').select2({width:'158px'});
		$('#project-toppane').change(function(){
			 //showAlert(values,gradeCatId,gradeCatName,areaName){
			var li = $('#project-toppane :selected');
			showAlert($(this).val(),
						li.data('id'),
						li.data('gradename'),
						li.data('aname')
			);
		});
	
		if(j==0){
		  var wizard=new tableWizard();
		  wizard.init('animateDiv4','1',15,17);
			wizard.setClass('datatablemain');
			wizard.appendSumTable();
			j++;
			$('#4-sum-notedWeight').val(arrayKeeper.getArray("grade4"));
		}
		var grade = $('#selectGrade').val();
		$.post("modules/mod_insertionData/GetProject.php", {gradeCatId : grade}, function(data){
			for(var i=0;i<data.length;i++){
				$('#'+(i+1)+"-grade").val(data[i]['fruitCount']);
				$('#'+(i+1)+"-gradeId").val(data[i]['gradeId']+":"+data[i]['sampleWeight']);
				reductions[i] = data[i]['reduction'];
				$('#gr'+(i+1)).html(data[i]['fruitCount']);
				}
		
			if(mode=="EDIT"){loadStocks(1);}
			
		});	
		$('#butFour').click(function(){	
		if(n != 0){
				$('#animateDiv1').show();
				}else{
					var wizard=new tableWizard();
				wizard.init('animateDiv1','4',15,17);
				wizard.setClass('datatablemain');
				wizard.appendSumTable();
				n++;
				$('#4-sum-notedWeight').val(arrayKeeper.getArray("grade4"));
				}

		var grade = $('#selectGrade').val();
		
		$.post("modules/mod_insertionData/GetProject.php", {gradeCatId : grade}, function(data){
			
				for(var i=0;i<data.length;i++){
				
				$('#'+(i+1)+"-grade").val(data[i]['fruitCount']);
				$('#'+(i+1)+"-gradeId").val(data[i]['gradeId']+":"+data[i]['sampleWeight']);
				$('#gr'+(i+1)).html(data[i]['fruitCount']);
				}
			//enabling the editing and load third worksheet data
			if(mode=="EDIT"){loadStocks(4);}
		});
				
		if($('#animateDiv1').css("width") == "0px"){
			
			$('#animateDiv1').animate({    			
			    width: '+=770'		    
			  }, 500);
		if($('#animateDiv2').css("width") == "0px"){
			$('#animateDiv2').animate({    			
			    width: '+=770'		    
			  }, 500);
		}if($('#animateDiv3').css("width") == "0px"){
			$('#animateDiv3').animate({    			
			    width: '+=770'		    
			  }, 500);
		}
			
		}else{
			
			}
		});

		$('#butThree').click(function(){
		if(k != 0){
				$('#animateDiv2').show();
				}else{
					var wizard=new tableWizard();
				wizard.init('animateDiv2','3',15,17);
				wizard.setClass('datatablemain');
				wizard.appendSumTable();
				k++;
$('#3-sum-notedWeight').val(arrayKeeper.getArray("grade3"));
				}

		var grade = $('#selectGrade').val();
		$.post("modules/mod_insertionData/GetProject.php", {gradeCatId : grade}, function(data){
	
			for(var i=0;i<data.length;i++){
				
				$('#'+(i+1)+"-grade").val(data[i]['fruitCount']);
				$('#'+(i+1)+"-gradeId").val(data[i]['gradeId']+":"+data[i]['sampleWeight']);
				$('#gr'+(i+1)).html(data[i]['fruitCount']);

			}
			//enabling the editing and load third worksheet data
			if(mode=="EDIT"){loadStocks(3);}
			
		});
		
		if($('#animateDiv2').css("width") == "0px"){
			
			$('#animateDiv2').animate({    			
			    width: '+=770'		    
			  }, 500);

			  if($('#animateDiv3').css("width") == "0px"){
				  $('#animateDiv3').animate({    			
					    width: '+=770'		    
					  }, 500);	
			}
	
			  
		}else{
			if($('#animateDiv1').css("width") == "770px"){
			$('#animateDiv1').animate({    			
			    width: '-=770'		    
			  }, 500, function(){
					$('#animateDiv1').hide();

			  });			
			}
			}
		});

		$('#butTwo').click(function(){
			if(i != 0){
				$('#animateDiv3').show();
				}else{
					var wizard=new tableWizard();
				wizard.init('animateDiv3','2',15,17);
				wizard.setClass('datatablemain');
				wizard.appendSumTable();
				i++;
				$('#2-sum-notedWeight').val(arrayKeeper.getArray("grade2"));
				}

			var grade = $('#selectGrade').val();
			$.post("modules/mod_insertionData/GetProject.php", {gradeCatId : grade}, function(data){
				for(var i=0;i<data.length;i++){
					
					$('#'+(i+1)+"-grade").val(data[i]['fruitCount']);
					$('#'+(i+1)+"-gradeId").val(data[i]['gradeId']+":"+data[i]['sampleWeight']);
					$('#gr'+(i+1)).html(data[i]['fruitCount']);
					}
				if(mode=="EDIT"){loadStocks(2);}
			});
			
		if($('#animateDiv3').css("width") == "0px"){
			$('#animateDiv3').animate({    			
			    width: '+=770'		    
			  }, 500);

			  
		}else{
			if($('#animateDiv1').css("width") == "770px"){
			$('#animateDiv1').animate({    			
			    width: '-=770'		    
			  }, 500, function(){
				  $('#animateDiv1').hide();

			  });
			}
			if($('#animateDiv2').css("width") == "770px"){
			$('#animateDiv2').animate({    			
			    width: '-=770'		    
			  }, 500, function(){
				  $('#animateDiv2').hide();

			  });
			}
			}
		
		});

		$('#butOne').click(function(){
$('#1-sum-notedWeight').val(arrayKeeper.getArray("grade1"));
		if(j != 0){
				$('#animateDiv4').show();
				}else{
					var wizard=new tableWizard();
				wizard.init('animateDiv4','1',15,17);
				wizard.setClass('datatablemain');
				wizard.appendSumTable();
				j++;
		$('#1-sum-notedWeight').val(arrayKeeper.getArray("grade1"));
				}

		if($('#animateDiv4').css("width") == "0px"){
			
			$('#animateDiv3').animate({    			
			    width: '+=770'		    
			  }, 500);
		}else{
			if($('#animateDiv1').css("width") == "770px"){
			$('#animateDiv1').animate({    			
			    width: '-=770'		    
			  }, 500, function(){
				  $('#animateDiv1').hide();

			  });
			}
			if($('#animateDiv2').css("width") == "770px"){
			$('#animateDiv2').animate({    			
			    width: '-=770'		    
			  }, 500, function(){
				  $('#animateDiv2').hide();

			  });
			}
		if($('#animateDiv3').css("width") == "770px"){
			$('#animateDiv3').animate({    			
			    width: '-=770'		    
			  }, 500, function(){
				  $('#animateDiv3').hide();

			  });
			}
		}
		if(mode=="EDIT"){loadStocks(1);}
		
		});
	$('#project-toppane').keyup(function(){
			
			var project = $('#project-toppane').val();
			
			if(project != ""){
				$.post("modules/mod_insertionData/GetProject.php", {project : project},function(data){
					if(data.success){
						$('#showSug').html(data.html);
						$('#showSug').fadeIn('fast');
						
					}
						 
					});
			}else{
				$('#showSug').fadeOut('slow');
				$('#centerName1').val("");
				$('#centerName2').val("");
				$('#centerName3').val("");
				$('#centerName4').val("");
				$('#centerName5').val("");
				$('#centerName6').val("");				
			}
		});
		
	

	//$('#date-toppane').datepicker();duration: '',
       
//	$("#date-toppane").datepicker({dateFormat: 'yy-mm-dd',maxDate:'<?php print $date?>'});
$("#date-toppane").datetimepicker({dateFormat: 'yy-mm-dd',timeFormat:'HH:mm:ss',showSecond:'true'});

$('#tmTable-link').click(function(){
	if($('#centerTable:visible').length<=0){
	    
    }else{
        handleQuantityData();
    }
	$('#centerTable').slideToggle("slow");
	$('#indexContainer').slideToggle("slow");
	$('#sliderContainer').slideToggle("slow");
	if($('#center0').val() == ""){
		$('#center0').focus();
	}	
	var dataArray = new Array(20);

	for(var i=0;i<20;i++){	
		dataArray[i] = new Array(2);			
		dataArray[i][0] = 0;
		dataArray[i][1] = "";
		
		//dataArray[i][0] = parseFloat($('#gr-'+i+'-1').val()) + parseFloat($('#gr-'+i+'-2').val()) + parseFloat($('#gr-'+i+'-3').val()) + parseFloat($('#gr-'+i+'-4').val());
		if($('#gr-'+i+'-1').val() == ""){
			dataArray[i][0] += parseFloat(0);
		}else{
			dataArray[i][0] += parseFloat($('#gr-'+i+'-1').val());
		}
		if($('#gr-'+i+'-2').val() == ""){
			dataArray[i][0] += parseFloat(0);;
		}else{
			dataArray[i][0] += parseFloat($('#gr-'+i+'-2').val());
		}
		if($('#gr-'+i+'-3').val() == ""){
			dataArray[i][0] += parseFloat(0);;
		}else{
			dataArray[i][0] += parseFloat($('#gr-'+i+'-3').val());
		}
		if($('#gr-'+i+'-4').val() == ""){
			dataArray[i][0] += parseFloat(0);;
		}else{
			dataArray[i][0] += parseFloat($('#gr-'+i+'-4').val());
		}

		if($('#center'+i).val() == ""){
			dataArray[i][1] = "";			
		}else{
			dataArray[i][1] = $('#center'+i).val() + "^" + $('#tm'+i).val() ;			
		}
	}	
	var sortedArray = new Array;
	sortedArray = dataArray.sort(sortArray);
	sortedArray = sortedArray.reverse();

	for(var m=0;m<6;m++){
		var centerTm = sortedArray[m][1].split("^");
		
		$('#centerName'+(m+1)).val(centerTm[0]);
		$('#'+(m+1)+'-tmToppane').val(centerTm[1]);		
	}
});
		
});

function sortArray(a,b){
	return ((a[0] < b[0]) ? -1:  ((a[0] > b[0]) ? 1 : 0));
}

function keyEvent(flag,number,event){
	if($("#tm"+number).val()!=""){
		if($('#center'+number).val()==""){
			alert('Please enter the center');
			$('#center'+number).focus();
			$('#tm'+number).val("");
		}
	}
	
	if(flag == "tm"){
		if(event.keyCode == "39"){
			$('#gr-'+number+'-1').focus();
		}	
		if(event.keyCode == "37"){
			$('#center'+number).focus();	
		}		
	}

	if(flag == "1"){
		if(event.keyCode == "39"){
			$('#gr-'+number+'-2').focus();
		}	
		if(event.keyCode == "37"){
			$('#tm'+number).focus();	
		}
	}

	if(flag == "2"){
		if(event.keyCode == "39"){
			$('#gr-'+number+'-3').focus();
		}	
		if(event.keyCode == "37"){
			$('#gr-'+number+'-1').focus();	
		}
	}

	if(flag == "3"){
		if(event.keyCode == "39"){
			$('#gr-'+number+'-4').focus();
		}	
		if(event.keyCode == "37"){
			$('#gr-'+number+'-2').focus();	
		}
	}

	if(flag == "4"){
		if(event.keyCode == "39"){
			$('#center'+(number+1)).focus();
		}	
		if(event.keyCode == "37"){
			$('#gr-'+number+'-3').focus();	
		}
	}
	
}

function showAlert(values,gradeCatId,gradeCatName,areaName){
	//$('#project-hidden-toppane').val(values);
	//$('#project-toppane').val(areaName);
	$('#showSug').fadeOut('medium');
	$('#selectGrade').val(gradeCatId);
	var grade = grade;
	$.post("modules/mod_insertionData/GetProject.php", {gradeCatId : gradeCatId}, function(data){
		for(var i=0;i<data.length;i++){
			$('#'+(i+1)+"-grade").val(data[i]['fruitCount']);
			$('#'+(i+1)+"-gradeId").val(data[i]['gradeId']+":"+data[i]['sampleWeight']);
			$('#gr'+(i+1)).html(data[i]['fruitCount']);
			reductions[i] = data[i]['reduction'];
	}
		$('#numberOfGrades').val(data.length);
	});
}

function hideDiv(){
	$('#showSug').fadeOut('medium');
	$('#project-toppane').val("");	
	$('#centerName1').val("");
	$('#centerName2').val("");
	$('#centerName3').val("");
	$('#centerName4').val("");
	$('#centerName5').val("");
	$('#centerName6').val("");
	
}

function getCenter(center,flag,event){
	var flag = flag;
	var centerName = center;
	var projectName = $('#project-toppane').val();
	console.log(projectName);
	var keyEvent = event;

	if(keyEvent.keyCode == "37"){
		$('#gr-'+(flag-1)+'-4').focus();
	}

	if(keyEvent.keyCode == "39"){
		$('#tm'+flag).focus();
	}
	
	if(centerName != ""){
	
		if(projectName != ""){
		$.post("modules/mod_insertionData/GetProject.php", {centerName : centerName, projectName : projectName,target : flag},function(data){
			if(flag == 0){
				$('#showSugCenter').html(data);
				$('#showSugCenter').fadeIn('slow');
				$('#showSugCenter').css('left','560px');
				}
		
			else if(flag == 1){
		$('#showSugCenter').html(data);
		$('#showSugCenter').fadeIn('fast');
		$('#showSugCenter').css('top','349px');
		}
		else if(flag == 2){
			$('#showSugCenter').html(data);
			$('#showSugCenter').fadeIn('fast');
			$('#showSugCenter').css('top','381px');
			}
		else if(flag == 3){
			$('#showSugCenter').html(data);
			$('#showSugCenter').fadeIn('fast');
			$('#showSugCenter').css('top','413px');
			}
		else if(flag == 4){
			$('#showSugCenter').html(data);
			$('#showSugCenter').fadeIn('fast');
			$('#showSugCenter').css('top','445px');
			}
		else if(flag == 5){
			$('#showSugCenter').html(data);
			$('#showSugCenter').fadeIn('fast');
			$('#showSugCenter').css('top','477px');
			}
		else if(flag == 6){
			$('#showSugCenter').html(data);
			$('#showSugCenter').fadeIn('fast');
			$('#showSugCenter').css('top','509px');
			}
		else if(flag == 7){
			$('#showSugCenter').html(data);
			$('#showSugCenter').fadeIn('fast');
			$('#showSugCenter').css('top','541px');
			}
		else if(flag == 8){
			$('#showSugCenter').html(data);
			$('#showSugCenter').fadeIn('fast');
			$('#showSugCenter').css('top','573px');
			}
		else if(flag == 9){
			$('#showSugCenter').html(data);
			$('#showSugCenter').fadeIn('fast');
			$('#showSugCenter').css('top','605px');
			}
		else if(flag == 10){
			$('#showSugCenter').html(data);
			$('#showSugCenter').fadeIn('fast');
			$('#showSugCenter').css('top','637px');
			}
		else if(flag == 11){
			$('#showSugCenter').html(data);
			$('#showSugCenter').fadeIn('fast');
			$('#showSugCenter').css('top','669px');
			}
		else if(flag == 12){
			$('#showSugCenter').html(data);
			$('#showSugCenter').fadeIn('fast');
			$('#showSugCenter').css('top','701px');
			}
		else if(flag == 13){
			$('#showSugCenter').html(data);
			$('#showSugCenter').fadeIn('fast');
			$('#showSugCenter').css('top','733px');
			}
		else if(flag == 14){
			$('#showSugCenter').html(data);
			$('#showSugCenter').fadeIn('fast');
			$('#showSugCenter').css('top','765px');
			}
		else if(flag == 15){
			$('#showSugCenter').html(data);
			$('#showSugCenter').fadeIn('fast');
			$('#showSugCenter').css('top','797px');
			}
		else if(flag == 16){
			$('#showSugCenter').html(data);
			$('#showSugCenter').fadeIn('fast');
			$('#showSugCenter').css('top','829px');
			}
		else if(flag == 17){
			$('#showSugCenter').html(data);
			$('#showSugCenter').fadeIn('fast');
			$('#showSugCenter').css('top','861px');
			}
		else if(flag == 18){
			$('#showSugCenter').html(data);
			$('#showSugCenter').fadeIn('fast');
			$('#showSugCenter').css('top','893px');
			}
		else if(flag == 19){
			$('#showSugCenter').html(data);
			$('#showSugCenter').fadeIn('fast');
			$('#showSugCenter').css('top','925px');
			}
				 
		});	

		}else{
			$('#showSug').html("Add a project name");
			$('#showSug').fadeIn('fast');
		
			}
	}else{
		$('#showSug').fadeOut('slow');
		$('#showSugCenter').fadeOut('medium');
		}
}

function addCenter(centerName,flag2){
		var txtId = flag2;
		var center = centerName;
		
		$('#center'+txtId).val(center);	
		$('#showSugCenter').fadeOut('medium');	
}
function hideDiv2(txtCenterId){
	var txtCenterId = txtCenterId;
      $('#showSugCenter').fadeOut('medium');
      $('#'+txtCenterId).val(""); 
}

function checkVal(id){
	var valu = $('#'+id).val();
	if(isNumeric(valu)){
		
		var ids=id.split("-");
		var row=ids[1];
		if($('#center'+row).val()==""  ){
			alert("Please enter center");
			$('#center'+row).focus();
		}
		if($('#tm'+row).val()==""  ){
			alert("Please enter TM number");
			$('#tm'+row).focus();
			$('#'+id).val("");
		}
		
	}else{
			if(valu != ""){
				alert("Invalid value");
				$('#'+id).focus();
				$('#'+id).val("");
			}			
		}
}

function isNumeric(val) {
    if (isNaN(parseFloat(val))) {
          return false;
     }
     return true;
}
