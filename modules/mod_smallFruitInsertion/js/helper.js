var columns = ['Center No.',
             'Fruit Count',
             'Small Fruit',
             'Large Fruit',
             'Melon Fly Attacked',
             'Peeled Off',
             'Bore Attacked',
             'Sand Embedded',
             'Shrivelled',
             'Deformed',
             'Virus Attacked',
             'Mechanical Damaged',
             'Yellowish',
             'Rust Patches',
             ' >45mm Fruits',
             'Accepted/Rejected',
             'Spoiled/Rotten',
             'Total Defects(No:)'
		                 ];
var dataFields = {'on':[0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18],
                  'off':[1,2,3,7,9,10,14,15],
                  'calc_fields_off':[4,5,6,8,11,12,13,16],
                  'on_calcable':[2,3,4,5,6,7,8,9,10,11,12,13,14,16]
				};

var capturable = {	table_0:0,
					table_1:0,
					table_2:0,
					table_3:0
				};


$(document).ready(function(){
	
    var i=0;
    var j=0;
    var k=0;
    var n=0;
    var m=0;    

    var table=new simpleTableWizard();
	table.randerHeaderTable('headertable');
	table.appendNavigator("navigator");
	if(j==0){
		table.appendDataTable("animateDiv-0", 0); 
		$('#avg-fc-0').parent().show();
		$('#indexer').html('You are in the Grade 11-14.5 Table');    
	   j++;
	}
	var table=new simpleTableWizard();
	var html = '';
	for(pos in projectsIn){
		html += '<option value="'+projectsIn[pos]['areaId']+'">'+projectsIn[pos]['areaName']+'</option>';
	}
	$('#project-toppane').html(html);
	$('#project-toppane').select2({width:'220px'});
	
	$('#butFiveSmall').click(function(){    
        if(m != 0){
                $('#animateDiv-4').show();
                $('#indexer').html('You are in CRS Table');
        }else{
        	table.appendCRSTable("animateDiv-4", 4);
        	$('#avg-fc-4').parent().show();
            $('#indexer').html('You are in CRS Table'); 
            m++;
        }
        if($('#animateDiv-4').css("width") == "0px"){
            $('#animateDiv-4').animate({width: '+=1000'}, 500);
            if($('#animateDiv-3').css("width") == "0px"){
               $('#animateDiv-3').animate({width: '+=1000'}, 500);    
            }
            if($('#animateDiv-2').css("width") == "0px"){
            	$('#animateDiv-2').animate({width: '+=1000'}, 500);
            }
            if($('#animateDiv-1').css("width") == "0px"){
                $('#animateDiv-1').animate({width: '+=1000'}, 500);
            }
        }
        if(edit){
        	setCrsData();
        }
	});

	$('#butFourSmall').click(function(){    
        if(n != 0){
               $('#animateDiv-3').show();
               $('#indexer').html('You are in the Grade 29-44 Table');
        }else{
            	table.appendDataTable("animateDiv-3", 3);
            	$('#avg-fc-3').parent().show();
            	manageTableColumns(3);
                $('#indexer').html('You are in the Grade 29-44 Table');
                n++;
        }
	    if($('#animateDiv-3').css("width") == "0px"){
	        $('#animateDiv-3').animate({width: '+=1000'}, 500);
	        if($('#animateDiv-2').css("width") == "0px"){
	            $('#animateDiv-2').animate({width: '+=1000'}, 500);
	        }
	        if($('#animateDiv-1').css("width") == "0px"){
	        	$('#animateDiv-1').animate({width: '+=1000'}, 500);
	        }
        }else{
            if($('#animateDiv-4').css("width") == "1000px"){
                $('#animateDiv-4').animate({width: '-=1000'}, 500, function(){
                        $('#animateDiv-4').hide();
                 });           
            }
        }
	    if(edit){
	        	setSampleData('29-44',3);
	        	
	    }
	});
    $('#butThreeSmall').click(function(){
    	if(k != 0){
            $('#animateDiv-2').show();
            $('#indexer').html('You are in the Grade 17-29 Table');
        }
    	else{
             table.appendDataTable("animateDiv-2", 2);
             $('#avg-fc-2').parent().show();
             manageTableColumns(2);
             $('#indexer').html('You are in the Grade 17-29 Table');
             k++;
    	}
    
    	if($('#animateDiv-2').css("width") == "0px"){
    		$('#animateDiv-2').animate({width: '+=1000'}, 500);
    		if($('#animateDiv-1').css("width") == "0px"){
    			$('#animateDiv-1').animate({width: '+=1000'}, 500);  
    		}
        }else{
       		if($('#animateDiv-4').css("width") == "1000px"){
       			$('#animateDiv-4').animate({width: '-=1000'}, 500, function(){
        					$('#animateDiv-4').hide();
        		});           
            }
        	if($('#animateDiv-3').css("width") == "1000px"){
        		$('#animateDiv-3').animate({width: '-=1000'}, 500, function(){
                    $('#animateDiv-3').hide();
        		});           
        	}
        }
        if(edit){
        	setSampleData('17-29',2);
        		
        }
   });

   $('#butTwoSmall').click(function(){
	   console.log(projectsIn);
	   console.log(i);
        if(i != 0){
        	$('#animateDiv-1').show();
        	$('#indexer').html('You are in the Grade 14.5-17 Table');
        }else{
        	table.appendDataTable("animateDiv-1", 1);
        	$('#avg-fc-1').parent().show();
        	manageTableColumns(1);
        	$('#indexer').html('You are in the Grade 14.5-17 Table');
        	i++;
        }
        if($('#animateDiv-1').css("width") == "0px"){
            $('#animateDiv-1').animate({width: '+=1000'}, 500);
        }
	    else{
	        if($('#animateDiv-4').css("width") == "1000px"){
	           $('#animateDiv-4').animate({width: '-=1000'}, 500, function(){
	                        $('#animateDiv-4').hide();
	            });           
	        }
	        if($('#animateDiv-3').css("width") == "1000px"){
	           	$('#animateDiv-3').animate({width: '-=1000'}, 500, function(){
	            		$('#animateDiv-3').hide();
	           	});
            }
	        if($('#animateDiv-2').css("width") == "1000px"){
	          	$('#animateDiv-2').animate({width: '-=1000'}, 500, function(){
	                  $('#animateDiv-2').hide();
	            	});
	        }
        }
	    if(edit){
	       	setSampleData('14-17',1);
	    }
   });
   $('#butOneSmall').click(function(){
    	if(j != 0){
            $('#animateDiv-0').show();
            $('#indexer').html("You are in the Grade 11-14.5 Table");
        }else{
        	table.appendDataTable('animateDiv-0', 1);
        	$('#avg-fc-0').parent().show();
        	manageTableColumns(0);
        	$('#indexer').html("You are in the Grade 11-14.5 Table");
            j++;
        }
      	if($('#animateDiv-0').css("width") == "0px"){
      		$('#animateDiv-1').animate({width: '+=1000'}, 500);
        }else{
    		if($('#animateDiv-4').css("width") == "1000px"){
    			$('#animateDiv-4').animate({width: '-=1000'}, 500, function(){
                    $('#animateDiv-4').hide();
    			});           
            }
            if($('#animateDiv-3').css("width") == "1000px"){
	            $('#animateDiv-3').animate({width: '-=1000'}, 500, function(){
	                  $('#animateDiv-3').hide();
	              	});
	            }
	            if($('#animateDiv-2').css("width") == "1000px"){
	            	$('#animateDiv-2').animate({width: '-=1000'}, 500, function(){
	            		$('#animateDiv-2').hide();
	            	});
	            }
	            if($('#animateDiv-1').css("width") == "1000px"){
	            	$('#animateDiv-1').animate({width: '-=1000'}, 500, function(){
	            		$('#animateDiv-1').hide();
	            	});
	            }
        	}
        	if(edit){
        		setSampleData('11-14',0);
        	}
        });
        $('#project-toppane').keyup(function(){
            $('#showSug').fadeOut('slow');
            var project = $('#project-toppane').val();
            if(project != ""){
            	$.post("modules/mod_smallFruitInsertion/GetProjectSmall.php", {'do':'getProject',project : project},function(data){
            		if(data.success == true){
            			$('#showSug').html(data.data.html);
                		$('#showSug').fadeIn('slow');
            		}
            		else{
            			$('#showSug').html(data.message);
            			$('#showSug').fadeIn('slow');
            		}
            	});
            }
            else{
                $('#showSug').fadeOut('slow');
                $('#center-toppane').val("");           
            }
        });
        $('#project-toppane').blur(function(){
		$('#showSug').fadeOut('slow');
	});
	var d=new Date();
	var maxdate=d.getFullYear()+"-"+(d.getMonth()+1)+"-"+d.getDate();
    $("#date-toppane").datetimepicker({dateFormat: 'yy-mm-dd',timeFormat:'HH:mm:ss',showSecond:'true',maxDate:maxdate});    
    var clicked=false;
    $('#tmButton').click(function(){
    if(clicked==true){
		setDeclaredQuantities();
		clicked=false;
	}else{
		clicked=true;
	}
	if($('#tmButton').html() == "Get TM Table" ){
		$('#tableDiv').show('slow');
		$('#tmButton').html('Hide TM Table');
		if($('#center0').val() == ""){
			$('#center0').focus();
		}
	}
	else{
		$('#tableDiv').hide('slow');
		$('#tmButton').html('Get TM Table');
		var centerNames = "";
		for(var i=0;i<10;i++){
			if($('#center'+i).val() != ""){
				centerNames += $('#center'+i).val() + ',';
			}		
		}
		$('#center-toppane').val(centerNames);
		var tms=Array();
		for(var i=0;i<10;i++){
            if($('#tm'+i).val() != ""){
                 //$('#tm'+i).val() ;
                tms.push($('#tm'+i).val() );
            }       
        } 
	    $('#tmNumbers').val(tms.join(","));
	}
});
      
});
function setDeclaredQuantities(){
	var gr_11_14=0;
	var gr_14_17=0;
	var gr_17_29=0;
	var gr_29_44=0;
	var gr_crs=0;

	for(var i=0;i<20;i++){
		if($('#gr-'+i+'-1').val()!=""){
			gr_11_14+=Number($('#gr-'+i+'-1').val());
		}
		if($('#gr-'+i+'-2').val()!=""){
			gr_14_17+=Number($('#gr-'+i+'-2').val());
		}
		if($('#gr-'+i+'-3').val()!=""){
			gr_17_29+=Number($('#gr-'+i+'-3').val());
		}
		if($('#gr-'+i+'-4').val()!=""){
			gr_29_44+=Number($('#gr-'+i+'-4').val());
		}
		if($('#gr-'+i+'-5').val()!=""){
			gr_crs+=Number($('#gr-'+i+'-5').val());
		}
	}

	$('#bsheet-1-0').val(gr_11_14);
	$('#bsheet-2-0').val(gr_14_17);
	$('#bsheet-3-0').val(gr_17_29);
	$('#bsheet-4-0').val(gr_29_44);
	$('#bsheet-5-0').val(gr_crs);
	$('#bsheet-6-0').val(gr_11_14+gr_14_17+gr_17_29+gr_29_44+gr_crs);
	
}

function showAlert(id,name){ 
    $('#project-toppane').val(name);
    $('#project-hidden-toppane').val(id);
    $('#showSug').fadeOut('slow');
	   
}

function keyEvent(flag,number,event){

	var id = 'gr-'+number+'-'+flag;
	if(flag=="tm"){
		if($('#tm'+number).val()!=""){
			if($('#center'+number).val()==""){
				alert("Please fill center data");
				$('#center'+number).focus();
				$('#tm'+number).val("");
			}
		}
	}

	if(Number($('#'+id).val())){
		if($('#center'+number).val()=="" ||$('#tm'+number).val()=="" ){
			alert("You have not enterd center or TM data.\nPlease fill them correctly");
			$('#'+id).val("");
		}
	}else {
		
		if(flag!="tm" && $('#'+id).val()!=''){
			alert("Please enter a numeric value ");
			$('#'+id).val("");
			$('#'+id).focus("");
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
			$('#gr-'+ number + '-5' ).focus();
		}	
		if(event.keyCode == "37"){
			$('#gr-'+number+'-3').focus();	
		}
	}

	if(flag == "5"){
		if(event.keyCode == "39"){
			$('#center'+(number+1)).focus();
		}	
		if(event.keyCode == "37"){
			$('#gr-'+number+'-4').focus();	
		}
	}
	
}


function setKey(id,e) {
    var key=e.keyCode;
    var ids=id.split('-');
    var table=ids[1];
    var column=ids[2];
    if(key==39){
            column++;
            $('#bsheet-'+table+"-"+column).focus();
        }
        if(key==37){
            column--;
            $('#bsheet-'+table+"-"+column).focus();

            }
        if(key==38){
            table--;
            $('#bsheet-'+table+"-"+column).focus();

            }
        if(key==40){
            table++;
            $('#bsheet-'+table+"-"+column).focus();

            } 
}

function getCenter(center,flag,event){
	var flag = flag;
	var centerName = center;
	var projectId = $('#project-toppane').val();
	var keyEvent = event;

	if(keyEvent.keyCode == "37"){
		$('#gr-'+(flag-1)+'-4').focus();
	}
	
	if(keyEvent.keyCode == "39"){
		$('#tm'+flag).focus();
	}
	if(centerName != ""){
		if(projectId != ""){
		$.post("modules/mod_smallFruitInsertion/GetProjectSmall.php", {'do':'getCenter',center : centerName, project : projectId,target : flag},function(data){
			$('#showSugCenter').fadeIn('slow');
			if(data.success == true){
				$('#showSugCenter').html(data.data.html);
				if(flag == 0){
					$('#showSugCenter').css('left','480px');
					$('#showSugCenter').css('top','320px');
				}
				else if(flag == 1){
					$('#showSugCenter').css('top','349px');
				}
				else if(flag == 2){
					$('#showSugCenter').css('top','385px');
				}
				else if(flag == 3){
					$('#showSugCenter').css('top','423px');
				}
				else if(flag == 4){
					$('#showSugCenter').css('top','460px');
				}
				else if(flag == 5){
					$('#showSugCenter').css('top','490px');
				}
				else if(flag == 6){
					$('#showSugCenter').css('top','525px');
				}
				else if(flag == 7){
					$('#showSugCenter').css('top','555px');
				}
				else if(flag == 8){
					$('#showSugCenter').css('top','588px');
				}
				else if(flag == 9){
					$('#showSugCenter').css('top','620px');
				}	
				else if(flag == 10){
					$('#showSugCenter').css('top','652px');
				}
				else if(flag == 11){
					$('#showSugCenter').css('top','688px');
				}
				else if(flag == 12){
					$('#showSugCenter').css('top','722px');
				}
				else if(flag == 13){
					$('#showSugCenter').css('top','758px');
				}
				else if(flag == 14){
					$('#showSugCenter').css('top','791px');
				}
				else if(flag == 15){
					$('#showSugCenter').css('top','823px');
				}
				else if(flag == 16){
					$('#showSugCenter').css('top','856px');
				}
				else if(flag == 17){
					$('#showSugCenter').css('top','892px');
				}
				else if(flag == 18){
					$('#showSugCenter').css('top','928px');
				}
				else if(flag == 19){
					$('#showSugCenter').css('top','960px');
				}		
			}else{
				$('#showSugCenter').html(data.message);
			}
	});	
	}else{
		$('#showSug').html("Add a project name");
		$('#showSug').fadeIn('slow');
	}
}else{
	$('#showSug').fadeOut('slow');
	$('#showSugCenter').fadeOut('slow');
}
}

function addCenter(centerName,flag2){
	var txtId = flag2;
	var center = centerName;
	$('#center'+txtId).val(center);	
	$('#showSugCenter').fadeOut('slow');	
}
function hideDiv2(txtCenterId){
	var txtCenterId = txtCenterId;
      $('#showSugCenter').fadeOut('slow');
      $('#'+txtCenterId).val(""); 
}
