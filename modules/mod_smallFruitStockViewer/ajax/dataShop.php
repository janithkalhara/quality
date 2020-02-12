<?php
session_start();
require_once '../../../includes/HDatabase.php';
require_once '../../../libraries/base/project/lib_project.php';

if(isset($_POST)){
	$flag=$_POST['flag'];
	$datashop=new dataShop();
	if($flag=='selectStockByDate'){
		$datashop->getStockDataByDate($_POST['date'],$_POST['vehicleNo'],$_POST['project']);
		
	}else if($flag=='selectStockByProject'){
        $datashop->getStockDataByProject($_POST['project'],$_POST['date_status'],$_POST['date'],$_POST['vehicleNo']);
        
    }
    else if($flag=='selectStockByVehicleNo'){
        $datashop->getStockDataByVehicleNo($_POST['date'],$_POST['project'],$_POST['vehicleNo'],$_POST['date_status']);
        
    }
}

class dataShop{	
	
	private $db;
	public function dataShop(){
		$this->db=new HDatabase();
		$this->db->connect();
		
	}
	
	function getStockDataByDate($date,$vehicleNo,$project){
		$this->db->resetResult();
		$date_f=$date." 00:00:00";
		$date_l=$date." 23:59:59";
		
		if($vehicleNo == "" && $project == ""){
			$this->db->select('qa_small_crop','*',"date>='$date_f' AND date<='$date_l'");
		}else if ($vehicleNo == "" && $project != ""){
			$this->db->select('qa_small_crop','*',"date>='$date_f' AND date<='$date_l' and id='$project'");
		}else if($vehicleNo != "" && $project != ""){
			$this->db->select('qa_small_crop','*',"date>='$date_f' AND date<='$date_l' and id='$project' and vehicleNo='$vehicleNo'");
		}else{
			$this->db->select('qa_small_crop','*',"date>='$date_f' AND date<='$date_l' and vehicleNo='$vehicleNo'");
			
		}
		
		$res=$this->db->getResult();
		
		$output="<table class='datatable' width='950'>";
		$output.="<tr>";
		$output.="<th>Project </th><th></th><th>Vehicle No</th><th>Batch No</th><th>Date</th>";
		$output.="</tr>";
		if($res){
			$k=0;
			$p=new Project();
			foreach ($res as $temp){
					$names=$p->getProjectNameById($temp['id']);
					$projectName=$names['areaName'];
					$names=null;
					
			 	$id=json_encode(array($temp['id'],$temp['vehicleNo'],$temp['date']));
				$output.="<tr id='tr$k'>";
	             $output.="<td>".$projectName."</td>";
	             $output.="<td>";
	             $output.="<li><a href='#' onclick='displayBSheet($id)'>view BalanceSheet</a></li>";
	             $output.=" <li> <a href='#' onclick='displayReport($id)'>view Quality Report</a></li>";
	             $output.="</td>";
	             $output.="<td>".$temp['vehicleNo']."</td>";
	             $output.="<td>".$temp['batchNo']."</td>";
	             $output.="<td>".$temp['date']."</td>";
	             $output.="<td><input type='button' class='img-view-button' onclick='showImages(this.id)' id='$id' value='View Images'></td>";
	             if($this->proveOwnership($temp['id'], $temp['vehicleNo'], $temp['date'])){
	            	$output.="<td><input type='button' class='delete-button' onclick='deleteStock(this.id)' id='".$id."|tr".$k."' value='Delete'></td>";
	            	$output.="<td><a class='edit-button' href='home.php?option=mod_smallFruitInsertion&id=".urlencode($id)."&action=edit'>Edit</td>";
	            }else{
	            	$output.="<td></td>";
	            }
             
	             //$output.="<td><input type='button' onclick='deleteStock(this.id)' id='".$id."|tr".$k."' value='Delete'></td>";
	            $output.="</tr>";
				$k++;
				
			}
			print $output;
		
		}
		else{ 
			print "<p class='ui-state-error ui-corner-all'>No Stocks for this date</p> ";
		}
		
	}
	
	
	function getStockDataByProject($pId,$date_status,$date,$vehicleNo){
	   
		$this->db->resetResult();
        
       	$date_f=$date." 00:00:00";
        $date_l=$date." 23:59:59";
        if($date_status=='not-empty' && $vehicleNo != ""){
        	$this->db->select('qa_small_crop','*'," id='$pId' and date>='$date_f' AND date<='$date_l' and vehicleNo='$vehicleNo'");
        }else if($date_status=='not-empty' && $vehicleNo == ""){
        	$this->db->select('qa_small_crop','*'," id='$pId' and date>='$date_f' AND date<='$date_l'");
        }else if($date_status == 'empty' && $vehicleNo == ""){
        	$this->db->select('qa_small_crop','*'," id='$pId'");
        }else if($date_status == 'empty' && $vehicleNo != ""){
        	$this->db->select('qa_small_crop','*',"id='$pId' and vehicleNo='$vehicleNo'");
        }
       	
       
        	
        $res=$this->db->getResult();

	  //print_r($res);
	   
        $output="<table class='datatable' width='950'>";
        $output.="<tr>";
        $output.="<th>Project </th><th></th><th>Vehicle No</th><th>Batch NO:</th><th>Date</th>";
        $output.="</tr>";
        if($res){
        	$k=0;
        	
        	$p=new Project();
        foreach ($res as $temp){
        	$names=$p->getProjectNameById($temp['id']);
					$projectName=$names['areaName'];
					$names=null;
           
        	$id=json_encode(array($temp['id'],$temp['vehicleNo'],$temp['date']));
			$output.="<tr id='tr$k'>";
             $output.="<td>".$projectName."</td>";
             $output.="<td>";
             $output.="<li><a href='#' onclick='displayBSheet($id)'>view BalanceSheet</a></li>";
             $output.=" <li> <a href='#' onclick='displayReport($id)'>view Quality Report</a></li>";
             $output.="</td>";
             $output.="<td>".$temp['vehicleNo']."</td>";
             $output.="<td>".$temp['batchNo']."</td>";
             $output.="<td>".$temp['date']."</td>";
             $output.="<td><input type='button' class='img-view-button' onclick='showImages(this.id)' id='$id' value='View Images'></td>";
             if($this->proveOwnership($temp['id'], $temp['vehicleNo'], $temp['date'])){
            	$output.="<td><input type='button' class='delete-button' onclick='deleteStock(this.id)' id='".$id."|tr".$k."' value='Delete'></td>";
            	$output.="<td><a class='edit-button' href='home.php?option=mod_smallFruitInsertion&id=".urlencode($id)."&action=edit'>Edit</td>";
            }else{
            	$output.="<td></td>";
            }
             
             //$output.="<td><input type='button' onclick='deleteStock(this.id)' id='".$id."|tr".$k."' value='Delete'></td>";
            $output.="</tr>";
            $k++;
            
        }
        print $output;
        
        }
        else{ 
            print "<p class='ui-state-error ui-corner-all'>No Stocks for this Project<p> ";
        }
        
	
	}
	
	function getStockDataByVehicleNo($date,$project,$vehicle,$date_status){
		
		$this->db->resetResult();
        $date_f=$date." 00:00:00";
        $date_l=$date." 23:59:59";
       if($date_status=='not-empty' && $project!=''){
        $this->db->select('qa_small_crop','*',"date>='$date_f' AND date<='$date_l' AND id='$project' AND vehicleNo='$vehicle'");
       }else if($date_status == 'not-empty' && $project == ''){
       	$this->db->select('qa_small_crop','*',"date>='$date_f' AND date<='$date_l' AND vehicleNo='$vehicle'");
       }else if($date_status=='empty' && $project==''){
       	$this->db->select('qa_small_crop','*',"vehicleNo='$vehicle'");
       }else{
       	$this->db->select('qa_small_crop','*',"id='$project' AND vehicleNo='$vehicle'");
       }
        
        $res=$this->db->getResult();
       
      // print_r($res);
       
        $output="<table class='datatable' width='950'>";
        $output.="<tr>";
        $output.="<th>Project </th><th></th><th>Vehicle No</th><th>Batch NO:</th><th>Date</th>";
        $output.="</tr>";
        if($res){
        	$k=0;
        	$p=new Project();
        foreach ($res as $temp){
           $names=$p->getProjectNameById($temp['id']);
					$projectName=$names['areaName'];
					$names=null;
        	$id=json_encode(array($temp['id'],$temp['vehicleNo'],$temp['date']));
			$output.="<tr id='tr$k'>";
             $output.="<td>".$projectName."</td>";
             $output.="<td>";
             $output.="<li><a href='#' onclick='displayBSheet($id)'>view BalanceSheet</a></li>";
             $output.=" <li> <a href='#' onclick='displayReport($id)'>view Quality Report</a></li>";
             $output.="</td>";
             $output.="<td>".$temp['vehicleNo']."</td>";
             $output.="<td>".$temp['batchNo']."</td>";
             $output.="<td>".$temp['date']."</td>";
             $output.="<td><input type='button' class='img-view-button' onclick='showImages(this.id)' id='$id' value='View Images'></td>";
            if($this->proveOwnership($temp['id'], $temp['vehicleNo'], $temp['date'])){
            	$output.="<td><input type='button'  class='delete-button' onclick='deleteStock(this.id)' id='".$id."|tr".$k."' value='Delete'></td>";
            	$output.="<td><a class='edit-button' href='home.php?option=mod_smallFruitInsertion&id=".urlencode($id)."&action=edit'>Edit</td>";
            }else{
            	$output.="<td></td>";
            }
             
            $output.="</tr>";
        	
            $k++;
            
        }
        print $output;
        
        }
        else{ 
        	print "<p class='ui-state-error ui-corner-all'>No Stocks for this Vehicle Number<p> ";
            
        }
        
		
		
	}
	function proveOwnership($p,$v,$d){
        $isSuperAdmin = $_SESSION['SESS_USERTYPE'] ==  'SuperAdministrator' ? true : false;

        if(!$isSuperAdmin) {
            return false;
        }
        else {
            return true;
        }

		$this->db->resetResult();
		$this->db->select("qa_stockUpdates_small","userId","date='$d' AND areaId='$p' AND vehicleNo='$v'");
		$res=$this->db->getResult();
		if($res){
			$user=$res[0]['userId'];
			
			$reg_user=$_SESSION['SESS_MEMBER_ID'];
		
			if(  $reg_user==$user){
				
				return true;
			}else{
				return false ;
			}
		}else{
			return false;
		}
		
	}
	
}




?>