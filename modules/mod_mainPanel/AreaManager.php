<?php
require_once '../../includes/HDatabase.php';

if(isset($_POST['projectArray']) && $_POST['butValue']){
	$projectArray = $_POST['projectArray'];
	$proId = $_POST['proId'];

	if($_POST['butValue'] == "Update"){
		$areaName = $projectArray[2];
		$conn = new HDatabase();
		$conn->connect();
		$conn->update('qa_area',"season = '$projectArray[1]',areaName='$areaName',cate_id='$projectArray[3]',areaType='$projectArray[4]',inchargeName='$projectArray[5]',userId='$projectArray[6]'", "areaId='$proId'");

	}else{
		$con = new HDatabase();
		$con->connect();
		$con->insert('qa_area', $projectArray,'areaId,season,areaName,cate_id,areaType,inchargeName,userId');
	}
}
if(isset($_POST['projectId'])){
	$projectId = $_POST['projectId'];
	$con1 = new HDatabase();
	$con1->connect();
	$con1->delete('qa_area',"areaId = '$projectId'");

	$con1->resetResult();
	$con1->delete('qa_center',"areaId = '$projectId'");

	echo "Project deleted successfully";
}

if(isset($_POST['viewArea'])){

	$conn1 = new HDatabase();
	$conn1->connect();
	$conn1->select('qa_area','*','',"areaName");
	$result1 = $conn1->getResult();

	$areaView = '<h3>Existing Projects</h3>';

	if($result1){
		foreach ($result1 as $r1){
			
			$areaView .= '<li class="liFormatArea row" >';
			$areaView .= '<div class="detailsArea" >'.$r1['areaName'].'<br/><p style="font-size: 12px">'.$r1['inchargeName'].'<br/>';
			$areaView .= '</p><input type="button" value="Edit" id="butEditArea" class="ui-state-default ui-corner-all area" onclick="editProject(\''.$r1['areaId'].'\')" />';
			$areaView .= '<input type="button" value="Centers" id="butCenter" class="ui-state-default ui-corner-all area" onclick="getCenters(\''.$r1['areaId'].'\')" />';
			$areaView .= '<input type="button" value="Delete" id="butDelArea" class="ui-state-default ui-corner-all area" onclick="delProject(\''.$r1['areaId'].'\')" /></div>';
			$areaView .= '</li>'; 
		}

		print $areaView;
	}else{

	}
}

if(isset($_POST['projectData'])){

	$projectId = $_POST['projectData'];
	$con2 = new HDatabase();
	$con2->connect();
	$con2->select('qa_area','*',"areaId = '$projectId'");
	$res = $con2->getResult();

	print json_encode($res);
}

if(isset($_POST['projectName'])){
	$projectName = $_POST['projectName'];
	$connec = new HDatabase();
	$connec->connect();
	$connec->select('qa_area','areaName',"areaName='$projectName'");
	$resultName = $connec->getResult();
	if($resultName){
		echo "* Name exists";
	}
}

if(isset($_POST['inchargeName'])){
	$incharge = $_POST['inchargeName'];
	$con = new HDatabase();
	$con->connect();
	$con->select('qa_user','userId,fname,lname',"fname LIKE '$incharge%'");
	$res = $con->getResult();

	if($res){
		foreach ($res as $r){
			$userId = $r['userId'];
			echo '<li class="inchargeNameList" id="'.$r['fname'].' '.$r['lname'].'" onclick="getName(this.id,\''.$userId.'\')" >'.$r['fname'].' '.$r['lname'].'</li>';
		}
	}else{
		echo '<li class="inchargeNameList"> No Suppliers</li>';
	}

}

if(isset($_POST['centerDetails'])){
	$centerData = $_POST['centerDetails'];
	$butValue = $_POST['butValue'];
	$centerId = $_POST['centerId'];
	$c= new HDatabase();
	$c->connect();
	if($butValue == "Update"){
		if($c->update('qa_center',"areaId = '$centerData[1]',centerName='$centerData[2]'","centerId='$centerId'"))
			print "true";
		else print "false";
	}
	else{
		$c->resetResult();
		if($c->insert('qa_center', $centerData,"centerId,areaId,centerName")) 
			print "true";
		else 
			print "false";
		
		
	}
}
if(isset($_POST['projectCenters'])){
	$projectId = $_POST['projectCenters'];

	$conn = new HDatabase();
	$conn->connect();
	$conn->select('qa_center','*',"areaId='$projectId'","centerName");
	$res = $conn->getResult();

	$c = new HDatabase();
	$c->connect();
	$c->select('qa_area','areaName',"areaId='$projectId'");
	$r = $c->getResult();

	print '<h3>Centers of '.$r[0]['areaName'].'</h3>';
	print '<img src="images/arrow2.png" width="25px" height="25px" style="position: relative;top:-15px;left:240px" /><div id="backButton" onclick="back()"> Back to Projects</div>';

	$centers = "";

	if($res){
		foreach ($res as $r1){
			$centers .= '<li class="liFormatCenter" >';
			$centers .= '<div class="detailsCenter" >'.$r1['centerName'].'<br/>';
			$centers .= ' <input type="button" value="Edit" id="butEditCenter" class="ui-state-default ui-corner-all center" onclick="editCenter(\''.$r1['centerId'].'\')" /> ';
			$centers .= ' <input type="button" value="Delete" id="butDelCenter" class="ui-state-default ui-corner-all center" onclick="delCenter(\''.$r1['centerId'].'\')" /></div>';
			$centers .= '</li><hr style="position:relative;width: 390px; top:-35px" />';
		}
		print $centers;
	}else{
		echo '<li class="liFormatCenter" >
		<div class="detailsCenter" >No Centers </div></li>'; 
	}

}

if(isset($_POST['flag'])&& $_POST['flag']=='getCenter'){
	
	$centerId = $_POST['centerId'];
	$con = new HDatabase();
	$con->connect();
	$con->select('qa_center','*',"centerId='$centerId'");
	$res= $con->getResult();

	$areaId = $res[0]['areaId'];
	$con->select('qa_area','areaName',"areaId='$areaId'");
	$res1 = $con->getResult();
	$areaName = $res1[0]['areaName'];

	$centerDetails = array();
	$centerDetails[0] = $areaId;
	$centerDetails[1] = $areaName;
	$centerDetails[2] = $res[0]['centerName'];

	print json_encode($centerDetails);
}
if(isset($_POST['delCenterId'])){
	$centerId = $_POST['delCenterId'];

	$con = new HDatabase();
	$con->connect();
	$con->select('qa_center','areaId',"centerId='$centerId'");
	$ress = $con->getResult();
	$areaId = $ress[0]['areaId'];
	echo $areaId;

	$con = new HDatabase();
	$con->connect();
	$con->delete('qa_center',"centerId='$centerId'");
}

if(isset($_POST['getProjectName'])){
	$projName = $_POST['getProjectName'];
	$con = new HDatabase();
	$con->connect();
	$con->select('qa_area','*',"areaName='$projName'" );
	$re = $con->getResult();

	if(!$re){
		echo "* Invalid Project Name";
	}
}
if(isset($_POST['projectNameList'])){
	$projectName = $_POST['projectNameList'];
	$seasonId = $_POST['centerSeason'];

	$con = new HDatabase();
	$con->connect();
	$con->select('qa_area','areaId,areaName',"areaName LIKE '$projectName%' AND season='$seasonId'","areaName ASC");
	$result = $con->getResult();

	if($result){
		foreach ($result as $r){
			$areaName = $r['areaName'];
			$areaId = $r['areaId'];
			echo '<li class="projectList" id="'.$areaId.'" onclick="getProject(this.id,\''.$areaName.'\')" >'.$areaName.'</li>';
		}
	}else{
		echo '<li class="projectList"> No Projects</li>';
	}
}

/*
 * checking for centerName existency
 */
if(isset($_POST['checkCenter'])){
	$centerName = $_POST['checkCenter'];
	$projectId = $_POST['centerProjectId'];

	$db = new HDatabase();
	$db->connect();
	$db->select("qa_center",'centerName',"centerName='$centerName' AND areaId='$projectId'");
	$result = $db->getResult();

	if($result)
		print "1";
	else
		print "0";
}



?>