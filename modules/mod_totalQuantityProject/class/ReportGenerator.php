<?php
require_once 'includes/HDatabase.php';

class ReportGenerator{
	private $stationId;
	private $seasonId;
	private $projectId;
	private  $startDate;
	private $endDate;
	private $type;
	private $db;
	const TOTAL = "TOT";
	private $notedWeight;
	private $trueWeight;
	private $payableQuantity;
	
	function ReportGenerator($postArr){
		$this->stationId = $postArr['select-station'];
		$this->seasonId = $postArr['select-season'];
		$this->projectId = $postArr['select-project'];
		$this->type = $postArr['select-type'];
		$this->startDate = $postArr['start-date'];
		$this->endDate = $postArr['end-date'];
		$this->startDate = $postArr['start-date']." 00:00:00";
		$this->endDate = $postArr['end-date']." 23:59:59";
	
		$this->db = new HDatabase();
		$this->db->connect();
		
		$this->generateTable();
		
	}
	
	function generateTable(){
		$this->notedWeight = 0;
		$this->trueWeight = 0;
		$this->payableQuantity = 0;
		
		if($this->projectId == self::TOTAL){
			$categories = $this->getCategories();
			foreach($categories as $category){
				
				$subGrades = $this->getSubGrades($category['id']);
				$count = count($subGrades);
				
				print "<b>".$category['name']."</b>";
				print "<table style='width: 965px;margin-bottom: 10px;;' cellpadding='0' cellspacing='0' border='1' class='dataTable' >";
				print "<tr style='background-color: #627AAD;font-size: 14px;'>";
				foreach($subGrades as $grade){
					print "<th colspan='3'>".$grade['fruitCount']."</th>";
				}
				print "</tr><tr style='text-align:center;font-size: 12px;font-weight:bold;'>";
				
				foreach($subGrades as $grade){
					print "<td><b>DQ</b></td>";
					print "<td><b>AQ</b></td>";
					print "<td><b>PQ</b></td>";
				}
				print "</tr><tr style='text-align: center;font-size: 12px;color: #000'>";
				
					foreach($subGrades as $grade){
						$query = "";
						if($category['id'] != 5){
							$query = $this->getQuery($category['id'],$grade['gradeId']);
						}else{
							$query = $this->getQuery($category['id'],$grade['diameter']);
						}
						$this->db->resetResult();
						$this->db->query($query);
						$result = $this->db->getResult();
						
						if($category['id'] != 5){
							if($result[0]['SUM(notedWeight)']== null){$this->notedWeight=0;}
							else{$this->notedWeight=$result[0]['SUM(notedWeight)'];}
							
							if($result[0]['SUM(trueWeight)']== null){$this->trueWeight=0;}
							else{$this->trueWeight=$result[0]['SUM(trueWeight)'];}
							
							if($result[0]['SUM(payableQuantity)']== null){$this->payableQuantity=0;}
							else{$this->payableQuantity=$result[0]['SUM(payableQuantity)'];}
						}else{
							foreach ($result as $r){
								if($r['DQ'] != null){
									$this->notedWeight += $r['DQ'];
								}else{
									$this->notedWeight += 0;
								}
								if($r['AQ'] != null){
									$this->trueWeight += $r['AQ'];
								}else{
									$this->trueWeight += 0;
								}
								if($r['11-14'] != null){
									$this->payableQuantity += $r['11-14'] + $r['14-17'] + $r['17-29'] + $r['29-44'] + $r['CRS'];
								}else{
									$this->payableQuantity = 0;
								}
							}						
						}
						
						print "<td>".$this->notedWeight."</td>";
						print "<td>".$this->trueWeight."</td>";
						print "<td>".$this->payableQuantity."</td>";
						
						$this->notedWeight = 0;
						$this->trueWeight = 0;
						$this->payableQuantity = 0;					
					}
					print "</tr></table><hr/>";		
				
			}
			
			
		}else{
			$projectCategoryId = $this->getProjectCategory();
			$projectSubGrades = $this->getSubGrades($projectCategoryId);
			
			print "<table class='dataTable' cellpadding='0' cellspacing='0' border='1' style='width: 965px;margin-bottom: 10px;'>";
			print "<tr style='background-color: #627AAD;font-size: 14px;'>";
				
			foreach($projectSubGrades as $grade){
				print "<th colspan='3'>".$grade['fruitCount']."</th>";
			}
			print "</tr><tr style='background-color: #627AAD;text-align: center;font-size: 12px;font-weight:bold;'>";
			
			foreach($projectSubGrades as $grade){
				print "<td><b>DQ</b></td>";
				print "<td><b>AQ</b></td>";
				print "<td><b>PQ</b></td>";
			}
			print "</tr><tr style='text-align: center;font-size: 12px;color: #000'>";				
			
			foreach($projectSubGrades as $grade){
				$query = "";
				if($projectCategoryId != 5){
					$query = $this->getQuery($projectCategoryId,$grade['gradeId']);
				}else{
					$query = $this->getQuery($projectCategoryId,$grade['diameter']);
				}
				
				$this->db->query($query);
				$result = $this->db->getResult();
								
				if($projectCategoryId != 5){				
					if($result[0]['SUM(notedWeight)']== null){$this->notedWeight=0;}
					else{$this->notedWeight=$result[0]['SUM(notedWeight)'];}
					
					if($result[0]['SUM(trueWeight)']== null){$this->trueWeight=0;}
					else{$this->trueWeight=$result[0]['SUM(trueWeight)'];}
					
					if($result[0]['SUM(payableQuantity)']== null){$this->payableQuantity=0;}
					else{$this->payableQuantity=$result[0]['SUM(payableQuantity)'];}
				}else{
					foreach ($result as $r){
						if($r['DQ'] != null){
							$this->notedWeight += $r['DQ'];
						}else{
							$this->notedWeight += 0;
						}
						if($r['AQ'] != null){
							$this->trueWeight += $r['AQ'];
						}else{
							$this->trueWeight += 0;
						}
						if($r['11-14'] != null){
							$this->payableQuantity += $r['11-14'] + $r['14-17'] + $r['17-29'] + $r['29-44'] + $r['CRS'];
						}else{
							$this->payableQuantity += 0;
						}
					}
				}
					
				print "<td>".$this->notedWeight."</td>";
				print "<td>".$this->trueWeight."</td>";
				print "<td>".$this->payableQuantity."</td>";
				
				$this->notedWeight = 0;
				$this->trueWeight = 0;
				$this->payableQuantity = 0;
									
			}
			print "</tr></table><hr/>";			
		}
		
	}
	
	function getCategories(){
		$this->db->resetResult();
		$this->db->select("qa_gradeCategory",'*');	
		return $this->db->getResult();
	}
	
	function getSubGrades($categoryId){
		$this->db->resetResult();
		$this->db->select('qa_grade','*',"cate_id='$categoryId'");
		return $this->db->getResult();		
	}
	
	function getQuery($categoryId,$gradeId){
		$query = "";			
		if($categoryId == 5){			
			$query .= "select * from ";
			$query .= "qa_small_belongs qg,qa_stockUpdates_small qs,qa_area qa WHERE qg.gradeName='$gradeId' AND qg.vehicleNo=qs.vehicleNo AND qg.date=qs.date AND qg.id=qa.areaId ";
		}else{
			$query .= "select SUM(notedWeight),SUM(trueWeight),SUM(payableQuantity) from ";
			$query .= "qa_gradeStock qg,qa_stockUpdates qs,qa_area qa WHERE qg.gradeId='$gradeId' AND qg.vehicleNo=qs.vehicleNo AND qg.date=qs.date AND qg.id=qa.areaId ";
		}
		
		if($this->stationId != self::TOTAL){
			$query .= "AND qs.stationId='$this->stationId' ";
		}
		if($this->type != self::TOTAL){
			$query .= "AND qa.areaType='$this->type' ";
		}
		$query .= "AND qg.date<='$this->endDate' AND qg.date>='$this->startDate' ";
		//var_dump($query);
		
		return $query;		
	}
	
	function getProjectCategory(){
		$this->db->resetResult();
		$this->db->select('qa_area','cate_id',"areaId='$this->projectId'");
		$result = $this->db->getResult();
	    return $result[0]['cate_id'];
		
// 		$this->db->resetResult();
// 		$this->db->select("qa_gradeCategory",'*',"id='$categoryId'");
// 		return $this->db->getResult();
	}
	
}


?>