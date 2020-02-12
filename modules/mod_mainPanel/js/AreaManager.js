var centerId="";
var proId = "";
var exists="";
var validName = 0;
$('document').ready(function(){
	
/*
 * Area data submit button 
 */	
	
$('#submitButArea').click(function(){
			$('#showNames').fadeOut('slow');
			var butValue = $('#submitButArea').val();
			
			var projectArray = new Array;
			projectArray[1]= $('#seasontxt').val();
			projectArray[2]= $('#projecttxt').val();	
			projectArray[3]= $('#projectgradetxt').val();
			projectArray[4]= $('#projectType').val();
			projectArray[5]=$('#inchargepersontxt').val();
			projectArray[6]=$('#inchargeId').val();
			
			if(projectArray[5] == ""){
				$('#validPersonName').html("* Required");
				$('#inchargepersontxt').focus();	
			}
			if(validName == 0){
				$('#validPersonName').html("* invalid Incharge name");
				$('#inchargepersontxt').focus();	
			}	
			
			if(projectArray[2] == ""){
				$('#validProjName').html("* Required");
				$('#projecttxt').focus();
			}
				
				
			if(projectArray[2] != "" && projectArray[5] != "" && exists == "" && validName != 0){
				$('#waiting-div').show();

				$.post("modules/mod_mainPanel/AreaManager.php",{projectArray : projectArray, butValue : butValue, proId : proId}, function(data){

					$('#submitAreamsg').fadeIn('slow');
					setTimeout("$('#submitAreamsg').fadeOut('slow')", 4000);					
						$.post("modules/mod_mainPanel/AreaManager.php",{viewArea : 'view1'}, function(data){
							$('#areaView').html(data);
					});
				
				$('#projectform')[0].reset();
				$('#submitButArea').val("Submit");
				$('#waiting-div').hide();
				}); 

			}
			
			validName =0;

			});

		
		$('#projecttxt').blur(function(){
			var newProjectName = $('#projecttxt').val();
			
			if($('#submitButArea').val() == "Submit"){
				var projectName = $('#projecttxt').val();
				$.post("modules/mod_mainPanel/AreaManager.php",{projectName : projectName}, function(data){
					$('#validProjName').html(data.trim());
					exists = data.trim();
				});
				}else{
				exists = "";
			}
		});
		

		
		$('#projecttxt').keydown(function(){
			$('#validProjName').html("");
			$('#submitAreamsg').fadeOut('slow');
		});
		
		$('#inchargepersontxt').keydown(function(){
			validName = 0;
			$('#validPersonName').html("");
			$('#submitAreamsg').fadeOut('slow');

			});

		$('#inchargepersontxt').keyup(function(){
			var inchargeName = $('#inchargepersontxt').val();
			
				$.post("modules/mod_mainPanel/AreaManager.php",{inchargeName: inchargeName}, function(data){					
					if($('#inchargepersontxt').val() != ""){
						$('#showNames').html(data.trim());
						$('#showNames').fadeIn('medium');	
					}else{
						$('#showNames').fadeOut('medium');
					}
				});	
			});
		
		$('#inchargepersontxt').blur(function(){
			$('#showNames').fadeOut('medium');			
		});

		$('#resetButArea').click(function(){
			$('#validProjName').html("");
			$('#validPersonName').html("");	
			$('#submitButArea').val("Submit");
			});

		/*
		 * Center details submit button click event 
		 */

		$('#submitButCenter').click(function(){

			var centerButSubmit = $('#submitButCenter').val();
			var centerName = $('#centertxt').val();
			var centerExistency;
			var proId = "";
						
			if($('#projectcentertxt').val() == ""){
				$('#validProjectName').html("* Required");
				$('#projectcentertxt').focus();			
			}else{
				proId = $('#centerProjectId').val();
			}
			
			if($('#centertxt').val() == ""){
				$('#validCenterName').html("* Required");				
				$('#centertxt').focus();
			}else{
				/*
				 * checking for center existency 
				 */
				$.ajax({
					url:"modules/mod_mainPanel/AreaManager.php",
					type : "post",
					data : {checkCenter : centerName, centerProjectId : proId },	
					async : false,
					success : function(data){
						console.log(data);
						centerExistency = data.trim();						
						if(centerExistency == "1"){
							
						$('#validCenterName').html("* Center Exists");
						}
					}					
				});
				
			}					
			
			if($('#centertxt').val() != "" && $('#projectcentertxt').val() != "" && centerExistency == "0" ){
				var centerDetails = new Array;
				centerDetails[2] =  $('#centertxt').val();
				centerDetails[1] = $('#centerProjectId').val();
							
			$('#waiting-div').show();
				$.post("modules/mod_mainPanel/AreaManager.php", {centerDetails : centerDetails,butValue : centerButSubmit,centerId : centerId}, function(data){
							
							if(data.trim()=="true"){
								$('#centerform')[0].reset();
								$('#validCenterName').html();	
								$('#validProjectName').html();
								$('#submitcentermsg').fadeIn('slow');
								setTimeout("$('#submitcentermsg').fadeOut('slow')", 4000);
								$('#submitButCenter').val("Submit");
							}else if(data.trim()=="false"){
								$('#submitcentermsg').html("Center exists.");
							}							
							
						if(centerButSubmit == "Update"){	
							$.post("modules/mod_mainPanel/AreaManager.php",{projectCenters : centerDetails[1]}, function(data){
								$('#areaView').html(data.trim());
							});
						}
							
				$('#waiting-div').hide();
				
				});
			}
				
			
		});

			$('#projectcentertxt').blur(function(){
				$('#showProjects').fadeOut('slow');
			});  
		
			$('#resetButCenter').click(function(){
						
				$('#centerform')[0].reset();
				$('#validCenterName').html("");	
				$('#validProjectName').html("");
				$('#submitButCenter').val("Submit");
			});

			$('#centertxt').keydown(function(){
				$('#validCenterName').html("");		
			});
			$('#projectcentertxt').keydown(function(){
				$('#validProjectName').html("");
			});
			
			$('#projectcentertxt').keyup(function(){
				var projectName = $('#projectcentertxt').val();
				var centerSeasonId = $('#centerSeasonId').val();
				$.post("modules/mod_mainPanel/AreaManager.php", {projectNameList : projectName, centerSeason : centerSeasonId}, function(data){
					if($('#projectcentertxt').val() != ""){
						$('#showProjects').html(data.trim());
						$('#showProjects').fadeIn('slow');	
					}else{
						$('#showProjects').fadeOut('slow');
					}
				});				
			});	
					
			
});

function delProject(projectId){
	var projectId = projectId;
	if(confirm("Do you need to remove the selected Project ?")){
		$.post("modules/mod_mainPanel/AreaManager.php",{projectId : projectId},function(data){
			alert(data);
			$.post("modules/mod_mainPanel/AreaManager.php",{viewArea : 'view1'}, function(data){
				$('#areaView').html(data);
			});			
		});
	}		
}

function editProject(projectId){
	validName = 1;
	$('#projectform')[0].reset();
	$('#validProjName').html("");
	$('#validPersonName').html("");
	
	$('#waiting-div').show();
	$.post("modules/mod_mainPanel/AreaManager.php",{projectData : projectId}, function(data){
			$projectDetails = jQuery.parseJSON(data);
			
			$('#seasontxt').val($projectDetails[0]['season']);
			$('#projecttxt').val($projectDetails[0]['areaName']);
			$('#projectgradetxt').val($projectDetails[0]['cate_id']);
			$('#projectType').val($projectDetails[0]['areaType']);
			$('#inchargepersontxt').val($projectDetails[0]['inchargeName']);
			$('#inchargeId').val($projectDetails[0]['userId']);
			$('#submitButArea').val("Update");
			proId = projectId;
			$('#waiting-div').hide();
		});
	
}
function getName(inchargeName,userId){
		validName = 1;
		$('#inchargeId').val(userId);
		$('#inchargepersontxt').val(inchargeName);
		$('#showNames').fadeOut('slow');
}


function getCenters(projectId){
	var projectId = projectId;
	$('#waiting-div').show();
	$.post("modules/mod_mainPanel/AreaManager.php",{projectCenters : projectId}, function(data){
			$('#areaView').html(data);
			$('#waiting-div').hide();
	});
}
function back(){
	$.post("modules/mod_mainPanel/AreaManager.php",{viewArea : 'view1'}, function(data){
		$('#areaView').html(data);
});
}

function editCenter(centId){
		$('#waiting-div').show();
		$('#centerId').val(centId);
		centerId = centId;
		
	$.post("modules/mod_mainPanel/AreaManager.php", {'flag':'getCenter',centerId : centerId},function(data){
		var centerDetails = jQuery.parseJSON(data);
		
		$('#centerProjectId').val(centerDetails[0]);
		$('#projectcentertxt').val(centerDetails[1]);
		$('#centertxt').val(centerDetails[2]);
		$('#validCenterName').html("");	
		$('#validProjectName').html("");
		$('#submitButCenter').val("Update");
		
		$('#waiting-div').hide();	
	});	
}

function delCenter(centerId){

	if(confirm("Do you need to remove the selected Center?")){
		$.post("modules/mod_mainPanel/AreaManager.php", {delCenterId : centerId},function(data){
			alert("Center Deleted Successfully");
			var projectId = data.trim();
			$.post("modules/mod_mainPanel/AreaManager.php",{projectCenters : projectId}, function(data){
			$('#areaView').html(data);
			});	
		});
	}
	
}
function getProject(projectId,projectName){
	
		$('#centerProjectId').val(projectId);
		$('#projectcentertxt').val(projectName);
		$('#showProjects').fadeOut('medium');
	}

//validation tips
function showtips(){
	$('#tips').fadeIn("medium");	
}
function hidetips(){
	$('#tips').fadeOut("medium");
	
}


