<?php
require_once '../../../includes/HDatabase.php';


if(isset($_POST['project'])){
	new GetData($_POST);

}

class GetData{
	var $project;
	var $season;
	var $printTable;
	var $weekSet;
	var $valueSet;
	var $startDate;
	var $endDate;
	
	public function GetData($postData){
		$this->project = $postData['project'];
		$this->season = $postData['season'];
		$this->printTable = "";
		$this->weekSet = "";
		$this->valueSet = "";

		$con = HDatabase::getInstance();
		$con->select('qa_seasons',"*","seasonName = '$this->season'");
		$result = $con->getResult();
		$seasonId = $result[0]['seasonId'];

		$db = new HDatabase();
		$db->connect();
		$db->select('qa_ap_revision','*',"project='$this->project' AND seasonId='$seasonId'");
		$res = $db->getResult();

		if($res == NULL){
			$db1 = new HDatabase();
			$db1->connect();
			$db1->select('qa_ap_seedingPlan',"*","project='$this->project' AND seasonId='$seasonId'");
			$res1 = $db1->getResult();
			$planId = $res1[0]['planId'];

			$db2 = new HDatabase();
			$db2->connect();
			$db2->select('qa_ap_acerValue',"*","revisionId='$planId'","weekNo ASC");
			$res2 = $db2->getResult();

			foreach ($res2 as $r){
				$weekNo = $r['weekNo'];

				$c = new HDatabase();
				$c->connect();
				$c->select('qa_ap_week',"*","weekNo='$weekNo'");
				$weekRes = $c->getResult();

				$this->startDate = $weekRes[0]['startDate'];
				$this->endDate = $weekRes[0]['endDate'];				
				
				$this->weekSet .= "<td id='day".$weekNo."' >".date('d',strtotime($this->startDate))."-".date('d',strtotime($this->endDate))."/".date('m',strtotime($this->startDate))."/".date('y',strtotime($this->startDate))."</td>";
				$this->valueSet .= "<td>".$r['noOfAcers']."</td>";
			}

			$this->printTable .= "<table id='printTable1' cellspacing='0' cellpadding='0' border='1' ><tr>";
			$this->printTable .= $this->weekSet;
			$this->printTable .= "</tr><tr>";
			$this->printTable .= $this->valueSet;
			$this->printTable .= "</tr></table>";

			print $this->printTable;

		}else{
			$con = new HDatabase();
			$con->connect();
			$con->select('qa_seasons',"*","seasonName = '$this->season'");
			$result = $con->getResult();
			$seasonId = $result[0]['seasonId'];

			$db = new HDatabase();
			$db->connect();
			$db->select('qa_ap_revision',"revisionId","project='$this->project' AND seasonId='$seasonId'","weekCount ASC");
			$res = $db->getResult();
				
			foreach ($res as $r){
				$revisionId = $r['revisionId'];
			}
				
			$db2 = new HDatabase();
			$db2->connect();
			$db2->select('qa_ap_acerValue',"*","revisionId='$revisionId'","weekNo ASC");
			$res2 = $db2->getResult();

			foreach ($res2 as $r){
				$weekNo = $r['weekNo'];
				
				$c = new HDatabase();
				$c->connect();
				$c->select('qa_ap_week',"*","weekNo='$weekNo'");
				$weekRes = $c->getResult();

				$this->startDate = $weekRes[0]['startDate'];
				$this->endDate = $weekRes[0]['endDate'];	
				
				$this->weekSet .= "<td id='day".$weekNo."' >".date('d',strtotime($this->startDate))."-".date('d',strtotime($this->endDate))."/".date('m',strtotime($this->startDate))."/".date('Y',strtotime($this->startDate))."</td>";
				$this->valueSet .= "<td id='".$weekNo."'>".$r['noOfAcers']."</td>";
			}

			$this->printTable .= "<table id='printTable1' cellspacing='0' cellpadding='0' border='1' ><tr>";
			$this->printTable .= $this->weekSet;
			$this->printTable .= "</tr><tr>";
			$this->printTable .= $this->valueSet;
			$this->printTable .= "</tr></table>";

			print $this->printTable;
				
		}
	}
}
?>