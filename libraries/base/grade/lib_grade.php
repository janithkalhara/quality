<?php

class Grade{
	private $db;
	public function Grade(){
		$this->db=new HDatabase();
		$this->db->connect();
	}
	
	public function getGrades(){
		
		$this->db->select("qa_grade","gradeId,gradeCategory,fruitCount");
		$res=$this->db->getResult();
		return $res;
	}
	public function getGradeById($id){
		$this->db->resetResult();
		$this->db->select("qa_grade","gradeCategory,fruitCount,diameter,sampleWeight","gradeId='$id'");
		$res=$this->db->getResult();
		return $res[0];
	}
	public function getGradeCategories(){
		
		$this->db->resetResult();
        $this->db->select("qa_gradeCategory","*");
		$res=$this->db->getResult();
		return $res;
	}
	
	public function getGradeCategoryNameById($id){
		$this->db->resetResult();
        $this->db->select("qa_gradeCategory","name","id='$id'");
		$res=$this->db->getResult();
		return $res[0];
	}
	
	public function getGradesByCategory($cateId){
		$this->db->resetResult();
        $this->db->select("qa_grade","gradeId,fruitCount","cate_id='$cateId'");
		$res=$this->db->getResult();
		return $res;
		
	}
	
	public function getGradesByCat($cat){
		$this->db->resetResult();
		$this->db->select('qa_grade','gradeId',"cate_id='$cat'","gradeId ASC");
		$res = $this->db->getResult();
		$grades = array();
		$i = 0;
		foreach ($res as $r){
			$grades[$i] = $r['gradeId'];
			$i++;
		}
		return $grades;
	}
	
	public static function getSubGradesByCategory($category) {
		$ds = HDatabase::getInstance();
		$ds->select('qa_grade','*',"cate_id='$category'","gradeId ASC");
		$result = $ds->getResult();
		return $result ? $result : null;
	}
	
}
?>