<?php

class user{

	private $id;
	private $fname;
	private $lname;
	private $userType;
	private $db;

	public function __construct(){
		$this->id=$_SESSION['SESS_MEMBER_ID'];
		$this->db=new HDatabase();
		$this->db->connect();
		$this->db->select('qa_user','*',"userId={$this->id}");
		$res = $this->db->getResult();
		
	}

	public function getUserID(){
		return $this->id;
	}
	
	
	
	public function getUserFname(){
		return $this->fname;
	}
	public function getUserLname(){
		return $this->lname;
	}
	public function getUserType(){
		return $this->userType;
	}
	public function getUserStation(){
		$this->db->select('qa_station','stationId',"inchargePersonId='{$this->id}'");
		$result=$this->db->getResult();
		
		return $result[0]['stationId'];
	}





}





?>
