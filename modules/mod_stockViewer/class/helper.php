<?php 

class stockHelper{
	
	function getGradeFC($gradeId){
        
       $dbo=$this->db;
        $dbo->select('qa_grade',"fruitCount","gradeId='$gradeId'");
        $res=$dbo->getResult();
        $fc;
        foreach ($res as $temp) {
            
            $fc=$temp['fruitCount'];
        }
        return $fc;
        
    }
    
	
	
	
	
}





?>