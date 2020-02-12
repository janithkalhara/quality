<?php
require_once '../../../includes/HDatabase.php';


if(isset($_POST['project'])){
	$project = $_POST['project'];

	if($project != ""){
		$con = new HDatabase();
		$con->connect();
		$con->select('qa_area','areaId,areaName,cate_id',"areaName LIKE '$project%'");
		$result = $con->getResult();

		if($result){
			foreach ($result as $r){
				$areaId = $r['areaId'];
				$areaName = $r['areaName'];
				$gradeCategory = $r['cate_id'];

				echo '<li class="suglist" onclick=showAlert(this.id,"'.$gradeCategory.'") id="'.$areaId.'">'.$r['areaName'].'</li>';

			}
		}else{
			echo "No projects";

		}
	}
}



?>