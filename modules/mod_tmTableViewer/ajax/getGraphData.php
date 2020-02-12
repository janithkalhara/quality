<?php
require_once '../../../includes/HDatabase.php';


if(isset($_POST['project'])){
	$project = $_POST['project'];

	if($project != ""){
		$con = new HDatabase();
		$con->connect();
		$con->select('qa_area','areaName,gradeCategory',"areaName LIKE '$project%'");
		$result = $con->getResult();

		if($result){
			foreach ($result as $r){
				$areaName = $r['areaName'];
				$gradeCategory = $r['gradeCategory'];

				echo '<li class="suglist" onclick=showAlert(this.id,"'.$gradeCategory.'") id="'.$areaName.'">'.$r['areaName'].'</li>';

			}
		}else{
			echo "No projects";

		}
	}
}

if(isset($_POST['season'])){
	$season = $_POST['season'];
	
	$con = new HDatabase();
	$con->connect();
	$con->select('qa_area','areaId,areaName',"season='$season'","areaName");
	$result = $con->getResult();
	
	if($result){
		print json_encode($result);
	}else{
		print false;
	}
	
}





?>