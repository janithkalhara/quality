<?php
class Huser{
	
	private $db;
	private $id;
	private $lname;
	private $fname;
	private $avatar;
	private $area;
	private $type;
	private $position;
	private $mobile;
	
	function __construct($data=null){
		$this->db=new HDatabase();
		$this->db->connect();
			
		if(!is_null($data)){
			$this->id = $data['userId']; 
			$this->lname = $data['lname'];
			$this->fname = $data['fname'];
			$this->avatar = $data['avatar'];
			$this->area = $data['areaId'];
			$this->position = $data['position'];
			$this->type = $data['userType'];
			$this->mobile = $data['mobileNo'];
		}
	}
	
	public function getId(){
		return $this->id;
	}
	
	public function setId($id){
		$this->id = $id;
		return $this;
	}
	public function getLname(){
		return $this->lname;
	}
	
	public function setLname($lname){
		$this->lname = $lname;
		return $this;
	}
	public function getFname(){
		return $this->fname;
	}
	
	public function setFname($fname){
		$this->fname = $fname;
		return $this;
	}
	public function getAvatar(){
		return $this->avatar;
	}
	
	public function setAvatar($a){
		$this->avatar = $a;
		return $this;
	}
	
	public function getArea(){
		return $this->area;
	}
	
	public function setArea($a){
		$this->area = $a;
		return $this;
	}
	

	public function getPosition(){
		return $this->position;
	}
	
	public function setPosition($p){
		$this->position = $p;
		return $this;
	}

	public function getType(){
		return $this->type;
	}
	
	public function setType($t){
		$this->type = $t;
		return $this;
	}
	public function getMobile(){
		return $this->mobile;
	}
	
	public function setMobile($m){
		$this->mobile = $m;
		return $this;
	}
	
	public function getName(){
		return $this->fname.' '.$this->lname;
	}
	
	public static function get($username){
		$db = new HDatabase();
		$db->connect();	
		$db->query("SELECT * FROM qa_user WHERE userId='$username'");
		$user = $db->getResult();
		if($user){
			return new Huser(array_pop($user));
		}
		else {
			return false;
		}
	}
	
	public function getNameById($id){
		$this->db->resetResult();
		$this->db->select("qa_user","fname,lname","userId='".$id."'");
		
		$res=$this->db->getResult();
		if(isset($res)){
			$name=$res[0]['fname']." ".$res[0]['lname'];	
			return $name;
			
		}else return false;
		
		
	}

}