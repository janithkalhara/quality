<?php defined("HEXEC") or die("Restrited Access."); ?>
<script type="text/javascript" src="modules/mod_mainPanel/js/AreaManager.js"></script>
<link href="modules/mod_areaManager/css/areaManager.css" rel="stylesheet" type="text/css" media="screen" />	
<script type="text/javascript">
$('document').ready(function(){
		$('#page').css('height','600px');
		$.post("modules/mod_mainPanel/AreaManager.php",{viewArea : 'view1'}, function(data){
			$('#areaView').html(data);	
		});	
});
</script>	
<div id="areaManager">
	<div id="areaForm">
		<h3>Add a Project</h3>
		<div id='submitAreamsg' class="ui-state-highlight ui-corner-all">
			<span class="ui-icon ui-icon-info"
				style="float: left; margin-right: .3em; margin-top: 1px"></span>
			Data submitted succeefully.
		</div>

		<div id="showNames"></div>
			<form method="post" action="" id="projectform">
				<table width="500px">
					<tr height="40px">
						<td width="130px">Project Name</td>
						<td width="205px">: <input type="text" id="projecttxt" name="projecttxt"></td>
						<td><div id="validProjName" style="color: red;"></div></td>
					</tr>
					<tr height="40px">
						<td>Grade Category</td>
						<td>: <select name="projectgradetxt" id="projectgradetxt" style="width: 100px">
						<?php $con = new HDatabase();
						$con->connect();
						$con->select('qa_grade','gradeCategory');
						$result = array_unique($con->getResult(),SORT_REGULAR);
						foreach ($result as $r){
							echo '<option value="'.$r['gradeCategory'].'" class="ui-state-default ui-corner-all">'.$r['gradeCategory'].'							                                </option>';
						}
						?>
					</select>
					</td>
				</tr>
				<tr height="40px">
					<td>Incharged Person</td>
					<td>: <input type="text" id="inchargepersontxt"
						name="inchargepersontxt">
					</td>
					<td><div id="validPersonName" style="color: red;"></div></td>
				</tr>
			</table>
			<input type="hidden" name="inchargeId" id="inchargeId" />
			<input type="button" value="Submit" class="ui-state-default ui-corner-all" id="submitButArea" /> 
			<input type="reset" value=" Reset " class="ui-state-default ui-corner-all" id="resetButArea" style="top: 10px" />
		</form>
		<br /> <br /> <br /> <br />
		<div id="showProjects"></div>
		<h3>Add a Center</h3>
		<div id='submitcentermsg' class="ui-state-highlight ui-corner-all">
			<span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em; margin-top: 1px"></span>
			Data submitted succeefully.
		</div>
		<form method="post" action="" id="centerform">
			<table width="500px">
				<tr height="40px">
					<td width="130px">Project Name</td>
					<td width="205px">: <input type="text" id="projectcentertxt"
						name="projectcentertxt"></td>
					<td><div id="validProjectName" style="color: red;"></div></td>

				</tr>
				<tr height="40px">
					<td>Center Name</td>
					<td>: <input type="text" id="centertxt" name="centertxt"></td>
					<td><div id="validCenterName" style="color: red;"></div></td>
				</tr>
			</table>
			<input type="button" value="Submit"
				class="ui-state-default ui-corner-all" id="submitButCenter" /> <input
				type="reset" value="Reset" class="ui-state-default ui-corner-all"
				id="resetButCenter" />
		</form>
	</div>
	<div id="areaView"></div>
</div>
