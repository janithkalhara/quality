<?php

class Season{
	
	private $db;
	private $data;
	public function Season($data=null){
		$this->db = HDatabase::getInstance();
		if(!is_null($data)) { $this->data = $data; }
	}
	
	public static function getPresentSeason() {
		$db = HDatabase::getInstance();
		$db->select('qa_seasons','*','flag=1');
		$result = $db->getResult();
		$seasonData = $result ? array_shift($result) : null;
		return $seasonData ? new Season($seasonData) : null;
	}
	
	public function getSeasonId() {
		return $this->data['seasonId'];
	}
	
	public function getSeasonName() {
		return $this->data['seasonName'];
	}
	
	public function getSeasonStartDate() {
		return $this->data['startDate'];
	}
	
	public function getSeasonEndDate() {
		return $this->data['endDate'];
	}
	
	public function getRemarks() {
		return $this->data['remarks'];
	}
	
	public function getFlag() {
		return $this->data['flag'];
	}
	
	public static function getSeason(){
		$db = HDatabase::getInstance();
		$db->query("SELECT * FROM qa_seasons WHERE flag=1");
		$season = $db->getResult();
		return array_pop($season);
	}
	
	public function getSeasons(){
		$this->db->select("qa_seasons","seasonId,seasonName,flag",null,'flag DESC');
		$res = $this->db->getResult();
		return $res;
	}

	public function getSeasonNameById($id){
		$this->db->resetResult();
		$this->db->select("qa_seasons","seasonName","seasonId='$id'");
		$res = $this->db->getResult();
		return $res[0]['seasonName'];
		
	}
	
	public function getOngoingSeason(){
		$this->db->resetResult();
        $this->db->select("qa_seasons","seasonName","flag='1'");
        $res = $this->db->getResult();
        return $res[0]['seasonName'];
		
		
	}
	
	public function getOngoingSeasonId(){
        $this->db->resetResult();
        $this->db->select("qa_seasons","seasonId","flag='1'");
        $res=$this->db->getResult();
        return $res[0]['seasonId'];
        
        
    }
    
    public function getSeasonData($id){
    	$this->db->resetResult();
		$this->db->select("qa_seasons","*","seasonId='$id'");
		$res = $this->db->getResult();
    	return $res;
    }
     
    public function getRelaventSeasonByDate($date){
    	$x = explode(" ", $date);
    	$d = $x[0];
    	$this->db->resetResult();
		$this->db->select("qa_seasons","seasonId","startDate<='$d' AND endDate>='$d'");
    	$res = $this->db->getResult();
    	return $res[0]["seasonId"];
    }
    
}

?>