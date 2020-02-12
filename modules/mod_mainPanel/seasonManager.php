<?php
require_once '../../includes/HDatabase.php';
require_once 'classes/season.php';
if(isset($_POST)){
	
	$season=new seasons();
	$news=new news();
	
	$flag=isset($_POST['flag'])?$_POST['flag']:$_GET['flag'];
	if($flag=="insertSeason"){
		insertSeason($_POST);
	}
	elseif ($flag=="removeSeason"){
		
		$season->removeSeason($_POST);
	}
	elseif ($flag=="editSeason"){
		$id=$_POST['id'];
		$season->getSeasonById($id);
	}
    elseif ($flag=="updateSeason"){
     
        $season->updateSeason($_POST);
    }
    elseif ($flag=="submitNews"){
     
       $news->addNews($_POST);
    }
    else if($flag == 'news'){
    	$action = $_GET['action'];
    	$id = $_GET['id'];
    	header('Content-type:application/json');
    	switch ($action){
    		case 'remove':
    			if($news->remove($id)){
    				echo json_encode(array('success'=>true,'message'=>'News deleted successfully.'));
    			}
    			else {
    				echo json_encode(array('success'=>false,'message'=>'Unable to delete the item. Please try again.'));
    			}
    			exit();
    			break;
    		case 'publish':
    			if($news->publish($id)){
    				echo json_encode(array('success'=>true,'message'=>'News published successfully.'));
    			}
    			else{
    				echo json_encode(array('success'=>false,'message'=>'Unable to publish the item. Please try again.'));
    			}
    			break;
    	}
    }
}
function insertSeason($post){
	$db=new HDatabase();
    $db->connect();
	$name=$post['name'];
	$startdate=$post['startdate'];
	$enddate=$post['enddate'];
	$ongoing=$post['ongoing'];
	$remarks=$post['remarks'];
	if($ongoing=='yes'){
		$flag=1;
		$db->update("qa_seasons", "flag='0'", "flag='1'");
		
		
		
	}else{$flag=0;}
	
	
	if($db->insert('qa_seasons',array('',$name,$startdate,$enddate,$remarks,$flag))){
		
		print "Season Added Successfully";
	}else{
		
		print "Some errors occured in insrtion of Season.Please try again! ";
	}
}




?>