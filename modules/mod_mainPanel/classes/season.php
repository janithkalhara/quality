<?php
class seasons{
	private $seasonid;
	private $seasonName;
	private $flag;
	private $start;
	private $end;
	private $db;
	
	
	
	public function seasons(){
		$this->db=new HDatabase();
        $this->db->connect();
		
	}
	
	public function getName(){
		return $this->seasonName;
	} 
	
	
	public function getOngoingSeason(){
		$this->db->select("qa_seasons","*","flag='1'");
		$res=$this->db->getResult();
		return $res[0];
		
	}
	
	public function getSeasons(){
		$this->db->select("qa_seasons","*");
		$res=$this->db->getResult();
        return $res;
		
	}
	public function removeSeason($post){
		
		$id=$post['id'];
		if($this->db->delete("qa_seasons","seasonId='$id'")){
			
			print "Season Removed Successfully";
		}else {
			
			print "There was an error removing season . Please try again later.";
		}
		
		
	}
	
	public function getSeasonById($id){
		$this->db->select("qa_seasons","*","seasonId='$id'");
		$res=$this->db->getResult();
		print json_encode($res[0]);
		
	}
	
	public  function updateSeason($data){
		$id=$data['id'];
		$name=$data['name'];
		$startDate=$data['startdate'];
		$endDate=$data['enddate'];
		$ongoing=$data['ongoing'];
		$remarks=$data['remarks'];
		if($ongoing=='yes'){
			$flag=1;
		}
		else{
			$flag=0;
		}
		
		$updateString="seasonId=$id,seasonName='$name',startDate='$startDate',endDate='$endDate',remarks='$remarks',flag='$flag'";
		if($flag == 1){
			$this->db->update('qa_seasons', 'flag=0', "flag=1");
			
		}
		header('Content-type:application/json');
		if($this->db->update("qa_seasons",$updateString,"seasonId='$id'")){
			echo json_encode(array('success'=>true,'message'=>'Season updated successfully!'));
			exit();
		}
		else{
			echo json_encode(array('success'=>false,'message'=>'There was an error updating season.Please try again later'));
			exit();
		}
	}
}

class Seasonv2{
	
	private $name;
	private $eod;
	private $sod;
	private $flag;
	private $id;
		
	public function __construct($data=null){
		if(!is_null($data)){
			
			$this->name =  isset($data['seasonName']) ? $data['seasonName'] : false;
			$this->eod =  isset($data['endDate']) ? $data['endDate'] : false;
			$this->sod =  isset($data['startDate']) ? $data['startDate'] : false;
			$this->flag = isset($data['flag']) ? $data['flag'] : false;
			$this->id = $data['seasonId'];
		}
	}

	public static function get($id){
		
		$db = new HDatabase();
		$db->connect();
		$db->query("SELECT * FROM qa_seasons WHERE seasonId='{$id}'");
		$result = $db->getResult();
		if($result){
			return new Seasonv2($result);
		}
		else{
			return false;
		}
		
	}
	
	public static function getOngoingSeason(){
		$db = new HDatabase();
		$db->connect();
		$db->query("SELECT * FROM qa_seasons WHERE flag='1'");
		$result = $db->getResult();
		if($result){
			return new Seasonv2(array_pop($result));
		}
		else{
			return false;
		}
	}
	
	public function getName(){
		return $this->name;
	}
	
	public function setName($n){
		$this->name = $n;
		return $this;
	}
	
	public function getEod(){
		return $this->eod;
	}
	
	public function setEod($d){
		$this->eod = $d;
		return $this;
	}
	
	public function getSod(){
		return $this->sod;
	}
	
	public function setSod($d){
		$this->sod = $d;
		return $this;
	}
	
	public function getId(){
		return $this->id;
	}
	
	public function setId($d){
		$this->id = $d;
		return $this;
	}
	public function getFlag(){
		return $this->flag;
	}
	
	public function setFlag($f){
		$this->flag = $f;
		return $this;
	}
}


class news{
	private $db;
	public function news(){
		$this->db=new HDatabase();
		$this->db->connect();
	}
	
	public function addNews($data){
		$title=$data['title'];
		$text=$data['text'];
		$showing=$data['showing'];
		$showBool;
		if($showing=='yes'){
			$showBool=1;
			$this->db->update('qa_news', "showing='0'",  "showing='1'");
		}else{
			$showBool=0;
		}
		$dataArr=array('',$title,$text,$showBool,time());
		header('Content-type:application/json');
		if($this->db->insert('qa_news',$dataArr )){
			echo json_encode(array('success'=>true,'message'=>'News saved successfully.'));	
		}else{
			echo json_encode(array('success'=>false,'message'=>'There was an error occured in submitting news item.<br>try again later'));
		}
		
	}
	
	public function getLatestNewsItem(){
		
		$this->db->select("qa_news","*","showing='1'");
		$res=$this->db->getResult();
		return $res[0];
	}
	public function remove($id){
		if($this->db->delete('qa_news',"id='{$id}'")){
			return true;
		}
		else{
			return false;
		}
	}
	
	public function publish($id){
		$this->db->update("qa_news","showing='0'","showing='1'");
		$this->db->update("qa_news","showing='1'","id='{$id}'");
		return true;
	}
	
	
}

?>




