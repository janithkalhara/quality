<?php
require_once '../../includes/HDatabase.php';

if(isset($_POST['project'])){
	$project = $_POST['project'];
	$con = new HDatabase();
	$con->connect();
	$con->select('qa_seasons',"seasonId","flag=1");
	$seasonRes = $con->getResult();
	$seasonId = $seasonRes[0]['seasonId'];
	$con->resetResult();
	$con->select('qa_area a,qa_gradeCategory gc','a.areaId,a.areaName,gc.name,gc.id',
					"a.areaName LIKE '$project%' AND 
					 a.season='$seasonId' AND a.cate_id=gc.id AND a.cate_id <> 5"
					);
	$result = $con->getResult();
	header('Content-type:application/json');
	if($result){
		$html = '';		
		foreach ($result as $r){
			$areaName = $r['areaName'];
			$gradeCat = $r['id'];
			$gradeCatName = $r['name'];		
			$html.= '<li class="suglist" onclick="showAlert(this.id,\''.$gradeCat.'\',\''.$gradeCatName.'\',\''.$areaName.'\')" id="'.$r['areaId'].'">'.$r['areaName'].'</li>';	
		}
		echo json_encode(array('success'=>true,'html'=>$html));
	}
	else{
		echo json_encode(array('success'=>false));
		
	}
}

if(isset($_POST['centerName'])){
	$flag = $_POST['target'];
	
	$center = $_POST['centerName'];
	$project = $_POST['projectName'];
			
	$con1 = new HDatabase();
	$con1->connect();
	$con1->select('qa_area','areaId',"areaName='$project'");
	$res = $con1->getResult();
	
	$areaId = $res[0]['areaId'];
	
	$con2 = new HDatabase();
	$con2->connect();
	$con2->select('qa_center','centerName,centerId',"centerName LIKE '$center%' AND areaId='$project'");
	$res2 = $con2->getResult();
	
	if($res2){
		
		foreach($res2 as $r2){
			$centerName = $r2['centerName'];
			$centerId = $r2['centerId'];
				echo '<li class="sugCenterlist" id="'.$centerName.'" onclick="addCenter(this.id,'.$flag.')" >'.$centerName.'</li>';
			
		}
	}else{echo "No center"; }
}

if(isset($_POST['gradeCatId'])){
	$grade = $_POST['gradeCatId'];
	$con = new HDatabase();
	$con->connect();
	$con->select('qa_grade','*',"cate_id='$grade'",'gradeId ASC' );
	$res= $con->getResult();
	
	$array=array();
	$i=0;
	foreach ($res as $r){
		//echo $r['fruitCount']."-".$r['gradeId'].":".$r['sampleWeight'].";";
		$array[$i]['fruitCount']=$r['fruitCount'];
		$array[$i]['gradeId']=$r['gradeId'];
		$array[$i]['sampleWeight']=$r['sampleWeight'];
		$array[$i]['reduction']=$r['offgradereduce'];
		$i++;
	}
	header('Content-type:application/json');
	print json_encode($array);
	
}


?>