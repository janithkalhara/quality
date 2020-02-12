<?php

class Project{
	
	private $projectName;
	private $projectId;
	private $projectCategory;
	private $inchargeName;
	private $userId;
	private $db;
	
	public function Project(){

		$this->db=new HDatabase();
        $this->db->connect();
	}
	
	public function getProjects(){	
		$this->db->select("qa_area","areaId,areaName","","areaName");
		$res=$this->db->getResult();
		
		return $res;
	}
	public function getProjectIdByName($name){
        
        $this->db->resetResult();
        $this->db->select("qa_area","areaId,cate_id,inchargeName,userId","areaName='$name'");
        $res=$this->db->getResult();
        return $res[0];
        
    }
	public function getProjectNameById($id){		
		$this->db->resetResult();
		$this->db->select("qa_area","areaName,cate_id,inchargeName,userId","areaId='$id'");		
		$res=$this->db->getResult();		
		return $res[0];		
	}
	public function getInchargeNameByProjectId($id){		
		$this->db->resetResult();
        $this->db->select("qa_area","inchargeName","areaId='$id'");
        $res=$this->db->getResult();
        return $res[0]['inchargeName'];
	}
	public function getGradeByProjectId($id){		
		$this->db->resetResult();
        $this->db->select("qa_area a,qa_gradeCategory gc","gc.id,gc.name",
        	"a.areaId='$id' AND a.cate_id=gc.id");
        $res=$this->db->getResult();       
        return $res[0]['id'];
	}
	/*
	 * get grade for 
	 */
	public function getGradeByProjectIdforGraph($id){
		
		$this->db->resetResult();
        $this->db->select("qa_area a,qa_gradeCategory gc","gc.id,gc.name",
        	"a.areaId='$id' AND a.cate_id=gc.id");
        $res=$this->db->getResult();       
        return $res[0]['name'];
	}
	
	public function getProjectCateById($id){
		$this->db->resetResult();
        $this->db->select("qa_area","areaName","areaId='$id'");
        $res=$this->db->getResult();
        $areaName=$res[0]["areaName"];
        $s=array();
        $s=explode("-", $areaName);
        $cate=array_pop($s);
        return $cate;
		
	}
	public function getProjectBySupplier($supId){
		
		$this->db->resetResult();
        $this->db->select("qa_area","areaId,areaName","userId='$supId'");
        $res=$this->db->getResult();
		return $res;
	}
	
	public function getProTypeById($proId){
		$this->db->resetResult();
		$this->db->select("qa_area",'areaType',"areaId = $proId");
		$proData = $this->db->getResult();
		$type = $proData[0]['areaType'];
		return $type;
	}
	
	public function getAQPQDQByProjectNameAndDate($project,$date){
		$details=$this->getProjectIdByName($project);
		$grade=$this->getGradeByProjectId($project);
		
		$date_f=$date." 00:00:00";
		$date_l=$date." 23:59:59";
		$ret=array();
        $ret['DQ']=0;
        $ret['AQ']=0;
        $ret['PQ']=0;
       
		if($grade!="Small"){
			//if large or other grade
		
			$this->db->resetResult();
	        $this->db->select("qa_gradeStock","notedWeight,trueWeight,payableQuantity","id='$project' AND date>='$date_f' AND date<='$date_l'");
			$res=$this->db->getResult();
			//var_dump($project);	
				if($res){
					foreach ($res as $temp){
						$ret['DQ']+=$temp['notedWeight'];
						$ret['AQ']+=$temp['trueWeight'];
						$ret['PQ']+=$temp['payableQuantity'];
					}
					
				}
				return $ret;
		}else if($grade=="Small" || $grade=="small"){
			//qa_small_crop
		
			$this->db->resetResult();
            $this->db->select("qa_small_crop","*","id='$project' AND date>='$date_f' AND date<='$date_l'");
			$res2=$this->db->getResult();
			
			if($res2){
				
				foreach ($res2 as $temp){
	                    $ret['DQ']+=$temp['total_DQ'];
	                    $ret['AQ']+=$temp['total_AQ'];
	                    $ret['PQ']+=$temp['11-14Q']+$temp['14-17Q']+$temp['17-29Q']+$temp['29-44Q']+$temp['crs'];
	                }
	               
			}
            
            
           return $ret; 
            
		}       
		
	}
	public function __destruct(){
		
		unset($this);
		
	}
	
	public function getProjectBySeason($seasonId){
		$this->db->resetResult();
		$this->db->select("qa_area","*","season='$seasonId'","areaName");
		$res = $this->db->getResult();
		if($res){
			return $res;
		}else{
			return false;
		}
		
	}

	public function getProjectBySeasonAndType($seasonId,$type){
		$this->db->resetResult();
		$this->db->select("qa_area","*","season='$seasonId' AND areaType='$type'","areaName");
		$res = $this->db->getResult();
		if($res){
			return $res;
		}else{
			return false;
		}
	
	}
	
	public static function getProjectsv2($season=false,$lm=true){
		$q = '';
		if($season){
			$q = 'SELECT a.areaId,a.areaName ,a.cate_id as gradeid, c.name as gradeName FROM qa_area a, qa_seasons s, qa_gradeCategory c WHERE s.flag=1 AND s.seasonId=a.season AND c.id=a.cate_id ';
		}
		else{
			$q = 'SELECT * FROM qa_area';
		}
		if($lm){
			$q .= ' AND a.cate_id<>5';
		}else{
			$q .= ' AND a.cate_id = 5';
		}
		$db = new HDatabase();
		$db->query($q);
		$result = $db->getResult();
		return $result;
		
	}
	
	
}



?>