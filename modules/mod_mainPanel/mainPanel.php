<?php defined("HEXEC") or die("Restrited Access."); ?>
<link href="modules/mod_mainPanel/css/mainPanel.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="modules/mod_mainPanel/js/md5.js"></script>
<script type="text/javascript" src="modules/mod_mainPanel/js/mainPanel.js"></script>
<script type="text/javascript" src="modules/mod_mainPanel/js/AreaManager.js"></script>
<script type="text/javascript" src="modules/mod_mainPanel/js/ArrivalPatternManager.js"></script>
<script type="text/javascript" src="modules/mod_mainPanel/js/GradeManager.js"></script>
<script type="text/javascript" src="libraries/jqueryCustomUI/js/jquery-ui-timepicker-addon.min.js"></script>
<script type="text/javascript">
	var oldUserName= "";			
	var nameExists= "";
$('document').ready(function(){
	<?php
	global $import;
	$import->importLib('season');
	?>
	
	$("#startDate,#endDate").datetimepicker({dateFormat: 'yy-mm-dd', timeFormat:'hh:mm:ss',showSecond:'true'}); 	
	$.post("modules/mod_mainPanel/profileDetails.php",{viewData : 'view'}, function(data){		
			$('#userView').html(data);
	});

	$.post("modules/mod_mainPanel/AreaManager.php",{viewArea : 'view1'}, function(data){
		$('#areaView').html(data);
});
	
		
	$('#submitBut').click(function(){
		$('#emailtxt').removeAttr('readOnly');			
		var butValue = $('#submitBut').val();
		
		var details = new Array();
		details[0] = $('#emailtxt').val();
		details[1] = $('#userType').val();	
		if($('#pwordtxt').val() != ""){
		details[2] = calcMD5($('#pwordtxt').val());
		}else{
		details[2] = "";
		}
		details[3] = $('#fNametxt').val();
		details[4] = $('#lNametxt').val();
		details[5] = $('#areatxt').val();
		details[6] = $('#positiontxt').val();
		details[7] = $('#mobiletxt').val();
		details[8] = 'avatar4.png';

		$stationUser = $('#stationUser').val();
		
		if(details[2] != calcMD5($('#rePwordtxt').val())){
			$('#validPass').html("* Password missmatched");	
		}
		if(details[2] == "" && $('#rePwordtxt').val()== ""){
			$('#validPass').html("");
		}
		if($('#pwordtxt').val() == ""){
				$('#validPass').html("* Required");
				$('#pwordtxt').focus();
		}
			
		if(details[0] == ""){
				$('#validEmail').html("* Required");
				$('#emailtxt').focus();
			}
		if(details[4] == ""){
				$('#validlName').html("* Required");
				$('#lNametxt').focus();
		}
		if(details[3] == ""){
				$('#validName').html("* Required");
				$('#fNametxt').focus();
		}	
		
		if(details[0] != "" && details[3] != "" && details[2] != "" && nameExists =="" && details[4] != "" && details[2] == calcMD5($('#rePwordtxt').val())){	
			
		$('#waiting-div').show();																																																																																																																																																																																																						
		$.post("modules/mod_mainPanel/profileDetails.php",{details : details, butValue : butValue, oldUsername : oldUserName}, function(data){
				//$('#userView').fadeOut('medium').load('modules/mod_mainPanel/mainPanel.php').fadeIn("slow");
					
				$('#submitmsg').fadeIn('slow');
				setTimeout("$('#submitmsg').fadeOut('slow')", 4000);
				$('#validPass').html("");
				$('#userform')[0].reset();
				$('#submitBut').val("Submit");

				$.post("modules/mod_mainPanel/profileDetails.php",{viewData : 'view'}, function(data){
				$('#userView').html(data);
				});
				$('#waiting-div').hide();
			});
		}
		});
		$('#emailtxt').blur(function(){
			if($('#submitBut').val() == "Submit"){				
				var uName = $('#emailtxt').val();
				$.post("modules/mod_mainPanel/profileDetails.php", {uName : uName}, function(data){
					nameExists = data.trim();
					$('#validEmail').html(data.trim());
				});
			}
		});
		$('#fNametxt').keydown(function(){
			$('#validName').html("");
			});
		$('#emailtxt').keydown(function(){
			$('#validEmail').html("");
			});
		$('#pwordtxt').keydown(function(){
			$('#validPass').html("");
			});	
		$('#lNametxt').keydown(function(){
			$('#validlName').html("");
			});
		$('#rePwordtxt').keyup(function(){
	        if($('#pwordtxt').val() != ""){
	            if($('#rePwordtxt').val() == $('#pwordtxt').val()){
	                $('#validPass').html("<span style='color:#009900'> Password matched</span>");
	            }else{
	                $('#validPass').html("* Password mismatched");
	            }       
	        }       
	    });
		
		$('#resetBut').click(function(){
			$('#emailtxt').removeAttr('readOnly');
			$('#validEmail').html("");
			$('#validName').html("");
			$('#validPass').html("");
			$('#validlName').html("");
			$('#submitBut').val("Submit");
			
		});

			
/*----------------------------------Season Manager---------------------------------------*/
			//submitMe-season
$('#submitMe-season').click(function() {
	var dispatcher=$('#dispatcher').val();
	var id=$('#seasonId').val();
	var s_name=$('#seasonName').val();
	var s_startDate=$('#startDate').val();
	var s_endDate=$('#endDate').val();
	var ongoing=$('input[name=ongoing]:checked').val();
	var remarks=$('#remarks').val();
	var s_array={'flag':'insertSeason','name':s_name,'startdate':s_startDate,'enddate':s_endDate,'ongoing':ongoing,'remarks':remarks}
	if(dispatcher=='insert'){
		$.post('modules/mod_mainPanel/seasonManager.php',s_array,function(data){
		    alert(data);
	    	$('#seasonManager-form')[0].reset();
		});
	}
	else if(dispatcher=='update'){
		    var s_array={'flag':'updateSeason','id':id,'name':s_name,'startdate':s_startDate,'enddate':s_endDate,'ongoing':ongoing,'remarks':remarks};
		    $.post('modules/mod_mainPanel/seasonManager.php',s_array,function(data){
			    if(data.success){
			        alert(data.message);
				}else{
					alert(data.message)}
		        $('#seasonManager-form')[0].reset();
		      });
	}
});
});
function removeSeason(id){
	var s_array={'flag':'removeSeason',"id":id};
	$.post('modules/mod_mainPanel/seasonManager.php',s_array,function(data){
		$('#season-tr-'+id).remove();
		alert(data);
	});
}
function editSeason(id){
    $('#dispatcher').val("update");
    $('#submitMe-season').val("Update"); 
    $('#waiting-div').show();
    $.ajax({
        url:"modules/mod_mainPanel/seasonManager.php",
        type:'post',
        dataType:"html",
        data:{'flag':'editSeason','id':id},
        async:false,
        success:function(d){
        result=d;
        $('#waiting-div').hide();
         }
    });
   result=jQuery.parseJSON(result);
    $('#seasonId').val(result['seasonId']);
    $('#seasonName').val(result['seasonName']);
	$('#startDate').val(result['startDate']);
	$('#endDate').val(result['endDate']);
	if(result['flag']==1){
		var $radios = $('input:radio[name=ongoing]');
		$radios.filter('[value=yes]').attr('checked', true);
	}
	else{
		 var $radios = $('input:radio[name=ongoing]');
	     $radios.filter('[value=no]').attr('checked', true);
	}
    $('#remarks').val(result['remarks']);
}
function submitNews(){
	var newstitle=$('#newstitle').val();
	var newstext=$('#newstext').val();
	var showing=$('input[name=showing]:checked').val();
	$.post('modules/mod_mainPanel/seasonManager.php',{'flag':'submitNews','title':newstitle,'text':newstext,'showing':showing},function(data){
    	alert(data);
    });
}

function editUser(userId){
	var userIdEdit = userId;
	$.post("modules/mod_mainPanel/profileDetails.php",{userId : userIdEdit}, function(data){
		$('#userform')[0].reset();
		$('#validEmail').html("");
		$('#validName').html("");
		$('#validPass').html("");
		$('#validlName').html("");
		$('#submitBut').val("Update");
		$.post("modules/mod_mainPanel/GradeManager.php",{viewGrade : 'view2'}, function(data){
			$('#gradeView').html(data);
			document.forms['userform'].emailtxt.setAttribute('readOnly','readonly');
			$('#fNametxt').val(data['fname']);
			$('#lNametxt').val(data['lname']);
			$('#emailtxt').val(data['userId']);
			$('#userType').val(data['userType']);
			$('#areatxt').val(data['areaId']);
			$('#positiontxt').val(data['position']);
			$('#mobiletxt').val(data['mobileNo']);
		});
	});
	oldUserName = userId;
}

function delUser(uId){
	if(confirm("Do you need to remove the selected User ?")){
		$.post("modules/mod_mainPanel/profileDetails.php",{uId : uId}, function(data){
			alert(data);
		});
		$.post("modules/mod_mainPanel/profileDetails.php",{viewData : 'view'}, function(data){
			$('#userView').html(data);
		});
	}
}
</script>
<ul id="navNew">
	<?php if($_SESSION['SESS_USERTYPE'] == 'SuperAdministrator') { ?>
	<li id="list1">User Manager</li>
	<li id="list2">Area and Center Manager</li>
	<?php } ?>
	<li id="list3">Grade Manager</li>
	<li id="list5">Season Manager</li>
	<?php if($_SESSION['SESS_USERTYPE'] == 'SuperAdministrator') { ?>
	<li id="list6"><a href="home.php?option=mod_news">News Manager </a></li>
	<?php }?>
</ul>
<div id="outer" class="ui-widget-shadow ui-corner-all" style="opacity: .4;"></div>
<div id="userManager">
	<div id="userForm">
		<h3>Add User Details</h3>
		<div id='submitmsg' class="ui-state-highlight ui-corner-all">
			<span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em; margin-top: 1px"></span>
			Data submitted successfully.
		</div>
		<form method="post" action="m" id="resetButCenter" >
			<table width="500px">
				<tr height="40px">
					<td width="130px">First Name</td>
					<td width="205px"><input type="text" id="fNametxt"
						name="fNametxt"></td>
					<td><div id="validName" style="color: red;"></div></td>
				</tr>
				<tr height="40px">
					<td>Last Name</td>
					<td> <input type="text" id="lNametxt" name="lNametxt"></td>
					<td><div id="validlName" style="color: red;"></div></td>
				</tr>
				<tr height="40px">
					<td>Username</td>
					<td> <input type="text" id="emailtxt" name="emailtxt">
					</td>
					<td><div id="validEmail" style="color: red;"></div></td>
				</tr>
			
				<tr height="40px">
					<td>Password</td>
					<td> <input type="password" id="pwordtxt" name="pwordtxt">
					</td>
					<td><div id="validPass" style="color: red;"></div></td>
				</tr>
				<tr height="40px">
					<td>Confirm Password</td>
					<td> <input type="password" id="rePwordtxt" name="rePwordtxt">
					</td>
					<td></td>
				</tr>
				<tr height="40px">
					<td>Usertype</td>
					<td>: <select id="userType" name="userType">
							<option value="SuperUser">SuperUser</option>
							<option value="StationUser">StationUser</option>
							<option value="Supplier">Supplier</option>
					</select>
					</td>
				</tr>
				<tr height="40px">
					<td>Station / Area</td>
					<td><input type="text" id="areatxt" name="areatxt" />
					</td>

				</tr>
				<tr height="40px">
					<td>Position</td>
					<td><input type="text" id="positiontxt" name="positiontxt">
					</td>
				</tr>
				<tr height="40px">
					<td>Mobile</td>
					<td><input type="text" id="mobiletxt" name="mobiletxt">
					</td>
				</tr>
			</table>
			<input type="button" value="Submit" class="btn btn-primary" id="submitBut" /> 
			<input type="reset" value="Reset" class="btn btn-default" id="resetBut" />
		</form>
	</div>
	<div id="userView">
		<h3 style="width: 375px">Existing Users</h3>
		<li class="liFormat">
			<div class="profilePic">
				<img src="" />
			</div>
			<hr/>
			<div class="details"></div>
		</li>
	</div>
</div>
<div id="areaManager">
	<div id="areaForm">
		<h3>Add a Project</h3>
		<div id='submitAreamsg' class="ui-state-highlight ui-corner-all">
			<span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em; margin-top: 1px"></span>
			Data submitted successfully.
		</div>
		<div id="showNames"></div>
		<form method="post" action="" id="projectform">
			<table width="500px">
				<tr>
					<td width="130px">Season</td>
					<td width="205px"> <select id="seasontxt" name="seasontxt">
					<?php
					$season = new Season();
					$seasonSet = $season->getSeasons();
					foreach($seasonSet as $temp){
						if($temp['flag'] == 1){
							print "<option selected='selected' value='".$temp['seasonId']."'>".$temp['seasonName'].'</option>';
						}else{
							print "<option value='".$temp['seasonId']."'>".$temp['seasonName'].'</option>';
						}
					}
					?>
					</select>
					</td>
				</tr>
				<tr height="30px">
					<td width="130px">Project Name</td>
					<td width="205px"><input type="text" id="projecttxt" name="projecttxt"></td>
					<td>
						<div id="validProjName" onmousemove="showtips()" onmouseout="hidetips()" style="color: red;">!important</div></td>
					<div id="tips">Invalid characters ( : ; , ' )</div>
				</tr>
				<tr height="30px">
					<td>Grade Category</td>
					<td>: <select name="projectgradetxt" id="projectgradetxt"
						style="width: 100px">
						<?php $con = new HDatabase();
						$con->connect();
						$con->select('qa_gradeCategory','*');
						$result = $con->getResult();
							
						foreach ($result as $r){
							echo '<option value="'.$r['id'].'" class="ui-state-default ui-corner-all">'.$r['name'].'</option>';
						}
						?>
					</select>
					</td>
				</tr>
				<tr>
					<td>Project Type</td>
					<td> <select name="projectType" id="projectType"
						style="width: 100px;">
							<option value="0">Internal</option>
							<option value="1">External</option>
					</select>
					</td>
				</tr>
				<tr height="30px">
					<td>Incharged Person</td>
					<td> <input type="text" id="inchargepersontxt"
						name="inchargepersontxt">
					</td>
					<td><div id="validPersonName" style="color: red;"></div></td>
					<input type="hidden" name="inchargeId" id="inchargeId" />
				</tr>							
			</table>
			 <input
				type="button" value="Submit" class="ui-state-default ui-corner-all"
				id="submitButArea" /> <input type="reset" value=" Reset "
				class="ui-state-default ui-corner-all" id="resetButArea" />
		</form>
		<div id="showProjects"></div>
		<h3>Add a Center</h3>
		<div id='submitcentermsg' class="ui-state-highlight ui-corner-all">
			<span class="ui-icon ui-icon-info"
				style="float: left; margin-right: .3em; margin-top: 1px"></span>
			Data submitted successfully.
		</div>
		<form method="post" action="" id="centerform">
			<table width="500px">
				<tr>
				<td>Season</td>
				<td>
				<select id="centerSeasonId">
				<?php
					$season=new Season();
					$seasonSet=$season->getSeasons();
					foreach($seasonSet as $temp){
						if($temp['flag'] == 1){
							print "<option selected='selected' value='".$temp['seasonId']."'>".$temp['seasonName'];
							print "</option>";
						}else{
							print "<option value='".$temp['seasonId']."'>".$temp['seasonName'];
							print "</option>";
						}
					}
					?>
				</select>
				</td>
				</tr>				
				<tr height="30px">
					<td width="130px"> Project Name </td>
					<td width="205px">
						<input type="text" id="projectcentertxt" name="projectcentertxt"></td>
					<td>
						<div id="validProjectName" style="color: red;"></div>
						<input type="hidden" id="centerProjectId" />
					</td>
				</tr>
				<tr height="30px">
					<td>Center Name</td>
					<td> <input type="text" id="centertxt" name="centertxt"></td>
					<td>
						<div id="validCenterName" style="color: red;"></div>
						<input type="hidden" id="centerId" />
					</td>
				</tr>
			</table>
			<input type="button" value="Submit" class="ui-state-default ui-corner-all" id="submitButCenter" /> 
			<input type="reset" value="Reset" class="ui-state-default ui-corner-all" id="resetButCenter" />
		</form>
	</div>
	<div id="areaView"></div>
</div>
<div id="gradeManager" class="row">
	<div id="gradeForm" class="span6"></div>
	<div id="gradeView"   class="span6"></div>
</div>
<div id="seasonManager">
	<fieldset>
		<legend>
			<b>Season Manager </b>
		</legend>
		<form action="" id="seasonManager-form">
			<table width="350" id="table-season-insert">

				<tr>
					<td>Season Name</td>
					<td><input type="hidden" name="seasonId" value="" id="seasonId"><input
						type="text" name="seasonName" id="seasonName"></td>
				</tr>
				<tr>
					<td>Start Date</td>
					<td><input type="text" name="startDate" id="startDate"></td>
				</tr>
				<tr>
					<td>End Date</td>
					<td><input type="text" name="endDate" id="endDate"></td>
				</tr>
				<tr>
					<td>On Going</td>
					<td><input type="radio" id="ongoing" name="ongoing" value="yes" />Yes
						<input type="radio" name="ongoing" id="ongoing" value="no" /> No</td>
				</tr>
				<tr>
					<td>Remarks</td>
					<td><textarea id="remarks" cols="25" rows="3"></textarea></td>
				</tr>

				<tr>
					<td><input type="button" id="submitMe-season" value="Submit" /></td>
					<td><input type="reset" value="Reset" id="resetMe" /><input
						type="hidden" name="dispatcher" value="insert" id="dispatcher"></td>
				</tr>
			</table>
			<?php
			require_once 'modules/mod_mainPanel/classes/season.php';
			$season=new seasons();
			$ongoingSeason=$season->getOngoingSeason();
			?>
			<div id="season-view">
				<!-- this content called through jquery.load method -->

				<fieldset>
					<legend>
						<b>On Going Season</b>
					</legend>
					<table width="580" border="" id="table-season-view" cellspacing="0"
						cellpadding="0">
						<tr>
							<th><b>Name:</b></th>
							<th><b>Start Date:</b></th>
							<th><b>End Date:</b></th>
						</tr>
						<tr>
							<td><?php print($ongoingSeason['seasonName']);?></td>
							<td><?php print($ongoingSeason['startDate']);?></td>
							<td><?php print($ongoingSeason['endDate']);?></td>
						</tr>

					</table>
				</fieldset>
				<fieldset>
					<legend>Seasons</legend>
					<table width="580" cellspacing="0" cellpadding="0" border="1"
						id="table-season-exist">
						<tr>
							<th>Season Name</th>
							<th>Start Date</th>
							<th>End Date</th>
							<th>Actions</th>
						</tr>
						<?php
						$seasons=$season->getSeasons();
						for($i=0;$i<count($seasons);$i++){
							print "<tr id='season-tr-".$seasons[$i]['seasonId']."'>";
							print "<td>".$seasons[$i]['seasonName']."</td>";
							print "<td>".$seasons[$i]['startDate']."</td>";
							print "<td>".$seasons[$i]['endDate']."</td>";
							print "<td><input type='button' value='edit' onclick='editSeason(\"".$seasons[$i]['seasonId']."\")'>";
							print "<input type='button' value='remove' onclick='removeSeason(\"".$seasons[$i]['seasonId']."\")'></td>";
							print "<tr>";
						}
						?>
					</table>
				</fieldset>
			</div>
		</form>
	</fieldset>

</div>


<!-- Grage manager queries -->

<div id="subGradeAddForm">
	<h3>Add Grade Category</h3>
	<div id='submitgradecatmsg' class="ui-state-highlight ui-corner-all">
		<span class="ui-icon ui-icon-info"
			style="float: left; margin-right: .3em; margin-top: 1px"></span> Data
		submitted successfully.
	</div>


	<table width="500px">
		<tr height="40px">
			<td width="130px">Grade Category</td>
			<td width="205px"><input type="text" id="gradeCattxt"
				name="gradeCattxt"></td>
			<td><div id="validGradecatName" style="color: red;"></div></td>
			<input type="hidden" id="hidden-grade-cate" />
		</tr>

	</table>
	<input type="button" value="Submit"
		class="ui-state-default ui-corner-all submitButGrade"
		id="submitButGradeCat" onclick='submitCategoryData()' /> <input type="button" value="Reset"
		class="ui-state-default ui-corner-all resetButGrade"
		id="resetButGradeCat" onclick="resetGradeCatForm()" /> <br /> <br /> <br />

	<h3>Add Sub Grades</h3>
	<div id='submitsubgrademsg' class="ui-state-highlight ui-corner-all"><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em; margin-top: 1px"></span> 
		Data submitted successfully.
	</div>
	<form method="post" action="" id="subgradeform">
		<table width="500px">
			<tr>
				<td>Grade Category</td>
				<td> <select id='gradeCat'>
						<option value='-1'>Select a Category</option>
						<?php
						$con = new HDatabase();
						$con->connect();
						$con->select('qa_gradeCategory','*');
						$res = $con->getResult();
						foreach ($res as $rr){
							print '<option value="'.$rr['id'].'">'.$rr['name'].'</option>';
						}
							
						?>
				</select>
				</td>
				<td><div id="validGradecat" style="color: red;"></div></td>
			</tr>
			<tr height="40px">
				<td width="130px"> Fruit Count </td>
				<td width="205px"> <input type="text" id="fctxt" name="fctxt"></td>
				<td><div id="validFc" style="color: red;"></div></td>

			</tr>
			<tr height="40px">
				<td> Diameter Range </td>
				<td><input type="text" id="diametertxt" name="diametertxt"></td>
				<td><div id="validDiameter" style="color: red;"></div></td>
			</tr>
			<tr height="40px">
				<td> Sample Weight </td>
				<td><input type="text" id="sampleweighttxt" name="sampleweighttxt">
				</td>
				<td><div id="validSampleweight" style="color: red;"></div></td>
			</tr>
			<tr height="40px">
				<td> Reduction Percentage </td>
				<td><input type="text" id="reduction" name="reduction">
				</td>
				<td><div id="validreduction" style="color: red;"></div></td>
			</tr>
			<tr height="40px">
				<td> Order </td>
				<td><input type="text" id="order" name="order">
				</td>
			</tr>
			<tr height="40px">
				<td> Main Grade </td>
				<td><input type="radio" name="maingrade" value="1"> Yes 
				<input type="radio" name="maingrade" checked value="0"> No 
				</td>
			</tr>
			
		</table>
		<input type="button" value="Submit"	class="ui-state-default ui-corner-all submitButGrade"
			id="submitButGrade" onclick="submitSubGradeData()" /> 
			<input type="button" value="Reset" class="ui-state-default ui-corner-all resetButGrade"
			id="resetButGrade" onclick="resetSubGradeForm()" />
	</form>


</div>

<div id="subGradeEditForm">
	 <input type="button" value="Submit" class="ui-state-default ui-corner-all submitButGrade" id="submitButGradeCatEdit" onclick="submitForm()" />
	<input type="button" value="Reset" class="ui-state-default ui-corner-all resetButGrade" id="resetButGradeCatEdit" onclick="resetForm()" />
	<input type="button" value="Exit" class="ui-state-default ui-corner-all exitButGrade" id="exitButGradeCatEdit" onclick="exit()" />
</div>

