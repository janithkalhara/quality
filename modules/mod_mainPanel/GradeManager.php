<?php
require_once '../../includes/HDatabase.php';

if(isset($_POST['viewGrade'])){

	$con = new HDatabase();
	$con->connect();
	$con->select('qa_gradeCategory','*','','id ASC');
	$res = $con->getResult();

	echo '<h3>Existing Grade Categories</h3>';
	$gradeCategories = "<table class='table'>";

	if($res){
		foreach ($res as $r){
			$gradeCategories .= '<tr><td>'.$r['name'].' </td>
					<td><button class="btn btn-mini btn-danger"   id="butDelGrade" onclick="delGrade(\''.$r['id'].'\')" ><i class="icon icon-trash"  ></i> delete</button></td>
					<td><button class="btn btn-mini btn-primary" id="butEditGrade" onclick="editGrade(\''.$r['id'].'\',\''.$r['name'].'\',0)" ><i class="icon icon-trash"></i> edit</button></td></tr>';
		}
	}
	$gradeCategories .= '</table>';
	print $gradeCategories;
}

if(isset($_POST['gradeData']) && $_POST['gradeData']['flag'] == 'savegrade'){	
	$gradeData = $_POST['gradeData'];
	$db = HDatabase::getInstance();
	$category = $gradeData['cate'];
	$fruitCount = $gradeData['fc'];
	$diameter = $gradeData['diameter'];
	$sampleWeight = $gradeData['sampleweight'];
	$maingrade = $gradeData['maingrade'];
	$reduction = $gradeData['reduction'];
	$order = $gradeData['order'];

	$insert = array(
			$category,
			$fruitCount,
			$diameter,
			$sampleWeight,
			$reduction,
			$maingrade,
			$order
			);
	$rows = '`cate_id`,`fruitCount`,`diameter`,`sampleWeight`,`offgradereduce`,`maingrade`,`order`';
	
	$db->resetResult();
	header('Content-type:application/json');error_log(json_encode($gradeData));
	if($db->insert('qa_grade', $insert,$rows)){
		echo json_encode(array('success'=>true,'Grade data saved successfully.'));
		exit();
	}
	else{
		echo json_encode(array('success'=>false,'Unable to save grade data.'));
		exit();
	}
}

if(isset($_POST['gradeCatId'])){
	$gradeCatId = $_POST['gradeCatId'];
	$con = new HDatabase();
	$con->connect();
	$con->select('qa_grade','*',"cate_id = '$gradeCatId'");
	$res = $con->getResult();
	header('Content-type:application/json');
	if($res){
		echo json_encode(array('success'=>true,'data'=>$res));
	}else{
		echo json_encode(array('success'=>false));
	}
}

if(isset($_POST['categories'])){
	$con = new HDatabase();
	$con->connect();
	$con->select('qa_gradeCategory','*');
	$res = $con->getResult();
	$gradeCategories = "<option value='-1'>Select a Category</option>";
	if($res){
		foreach ($res as $r){
			$gradeCategories .= "<option value='".$r['id']."'>".$r['name']."</option>";
		}
	}
	print $gradeCategories;
}

if(isset($_POST['delgradeId'])){
	$gradeId = $_POST['delgradeId'];
	$con = new HDatabase();
	$con->connect();
	$con->delete('qa_gradeCategory',"id = '$gradeId'");
	$con->resetResult();
	$con->delete('qa_grade',"gradeId = '$gradeId'");
	echo "Grade Deleted Successfully";

}

if(isset($_POST['gradeCategorySave'])){
	$catName = $_POST['gradeCategorySave'];
	$butVal = $_POST['catButValue'];
	
	$gradeCatArr = array();
	$gradeCatArr[0] = "";
	$gradeCatArr[1] = $catName;
	
	$con = new HDatabase();
	$con->connect();

	if($butVal == "Update"){
		$catId = $_POST['catId'];
		
		$con->resetResult();
		$con->update('qa_gradeCategory',"name='$catName'" ,"id='$catId'");		
	}else{
		$con->resetResult();
		$con->insert('qa_gradeCategory', $gradeCatArr,"id,name");
		
	}
	
}

if(isset($_POST['flag']) && $_POST['flag'] == 'updateData'){
	$submitArray = $_POST['submitArray'];
	$grades = $submitArray['grades'];
	error_log(json_encode($grades));
	$category = $submitArray['cate']['cate'];
	$categoryName = $submitArray['cate']['cate_name'];
	$con = HDatabase::getInstance();
	$flag = true;
	$con->resetResult();
	$con->update('qa_gradeCategory',"name='$categoryName'","id='$category'");
	foreach($grades as $grade){
		$id =  $grade['id'];
		$fruitCount = $grade['fc'];
		$sampleWeight = $grade['sampleweight'];
		$diameter =  $grade['diameter'];
		$reduction = $grade['reduction'];
		$order = $grade['ordr'];
		$con->resetResult();
		header('Content-type:application/json');
		if($con->update('qa_grade', "`fruitCount`='$fruitCount',`diameter`='$diameter',`sampleWeight`='$sampleWeight',`offgradereduce`='$reduction',`order`='$order'","gradeId='$id'")){
			
		}else{
			$flag = false;
		}
		
	}
	if($flag){
		echo json_encode(array('success'=>true,'message'=>'Data updated successfully.'));
		
	}else{
		echo json_encode(array('success'=>false));
	}
	
}

if(isset($_POST['deleteSubGrade'])){
	$gradeId = $_POST['deleteSubGrade'];
	
	$con = new HDatabase();
	$con->connect();
	$con->delete('qa_grade',"gradeId='$gradeId'");
}

?>
