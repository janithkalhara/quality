<?php
class UpdateHandler{
	private $p;
	private $v;
	private $d;	
	private $db;
	function __construct($project,$vehicleNo,$date){
		$this->p = $project;
		$this->v = $vehicleNo;
		$this->d = $date;
		$this->db = new HDatabase();
		$this->db->connect();
	}
	
	public function getHeaders(){
		$this->db->select('qa_small_crop','*',"id='{$this->p}' AND vehicleNo='{$this->v}' AND date='{$this->d}'");
		$res = $this->db->getResult();
		if($res){
			$this->db->resetResult();
			$this->db->select('qa_area','*',"areaId='{$this->p}'");
			$project = $this->db->getResult();
			$project = array_pop($project);
			$projectName = $project['areaName'];
			$res = array_pop($res);
			$res['project'] = $projectName;
			return  $res;
		}
		else{
			return false;
		}
	}
	
	public function getTms(){
		$this->db->resetResult();
		$this->db->select('qa_centerQuantitySmall','*',"id='{$this->p}' AND vehicleNo='{$this->v}' AND date='{$this->d}'");
		$res = $this->db->getResult();
		return $res;		
	}
	
	public function getSamples(){
		$this->db->resetResult();
		$this->db->select('qa_small_cropSampleGrades2','*',"id='{$this->p}' AND vehicleNo='{$this->v}' AND date='{$this->d}'");
		$res = $this->db->getResult();
		return $res;
	}

	public function getGradeStats(){
		$this->db->resetResult();
		$this->db->select('qa_small_cropSampleStat','*',"id='{$this->p}' AND vehicleNo='{$this->v}' AND date='{$this->d}'");
		$res = $this->db->getResult();
		return $res;
	}
	
	public function getCrsSamples(){
		$this->db->resetResult();
		$this->db->select('qa_small_crsSampleData','*',"id='{$this->p}' AND vehicleNo='{$this->v}' AND date='{$this->d}'");
		$res = $this->db->getResult();
		$this->db->resetResult();
		$this->db->select('qa_small_crsData','*',"id='{$this->p}' AND vehicleNo='{$this->v}' AND date='{$this->d}'");
		$stat = $this->db->getResult();
		return array('samples'=>$res,'stat'=>$stat[0]);
		
		
	}
	
	public function getBalanceSheet(){
		$this->db->resetResult();
		$this->db->select('qa_small_belongs','*',"id='{$this->p}' AND vehicleNo='{$this->v}' AND date='{$this->d}'");
		$res = $this->db->getResult();
		return $res;
		
	}
	
	
	
}