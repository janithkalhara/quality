<?php
class ForecastManager{
	private $season;
	private $gradeCategory;
	private $grades;
	private $internals = array();
	private $externals = array();
	private $db;
	private $weeks;
	private $internalProjects = array();
	private $externalProjects = array();
	
	public function ForecastManager($season,$grade) {
		$g = new Grade();
		$this->season = $season;
		$this->gradeCategory = $grade;
		$this->grades = $g->getGradesByCategory($grade);
		$this->db = HDatabase::getInstance();
	}
	
	public  function setInExProjects() {
	   $this->db->resetResult();
	   $this->db->select("qa_area","areaId,areaName,areaType","cate_id='$this->gradeCategory' AND season=".$this->season);
	   $res = $this->db->getResult();
	 
	   if($res) {
	   		foreach ($res as $temp) {
			   	$flag = $temp['areaType'];
			    
			    if($flag == '0'){
			   		array_push($this->internalProjects,$temp['areaId'] );
			   	}
			   	else if($flag == "1") {
			   		array_push($this->externalProjects,$temp['areaId'] );
			   	}
	   		}
		}
	}
    
	function setWeekList() {
	   $this->db->resetResult();
       $this->db->select("qa_arrivalData","DISTINCT cropFrom","seasonId=".$this->season);
	   $res = $this->db->getResult();
	   $weeks = array();
	   foreach ($res as $temp) {
	   		array_push($weeks, $temp['cropFrom']);
	   }
	   sort($weeks);
	   $weekList = array();
	   for($i=0;$i<count($weeks);$i++) {
			$weekList[$i][0] = $weeks[$i];
			$e_d = StrToTime('+6 days', StrToTime($weeks[$i]));
			$weekList[$i][1] = date('Y-m-d',$e_d);
	   }
	   $this->weeks = $weekList;
	}
	
	public function setInternalGradeWeekQuantities() {
		$values = array();	
		
		for($i=0;$i<count($this->grades);$i++) {
            for($j=0;$j<count($this->weeks);$j++){
                for($k=0;$k<count($this->internalProjects);$k++) {
                   $values[$i][$k][$j] = 0;
                }
            }
      	}
		
		for($i=0;$i<count($this->grades);$i++) {
			for($j=0;$j<count($this->weeks);$j++) {
				for($k=0;$k<count($this->internalProjects);$k++) {
					$this->db->resetResult();
					$this->db->select("qa_arrivalData","quantity","projectId='".$this->internalProjects[$k]."' AND gradeId='".$this->grades[$i]['gradeId']."' AND seasonId='".$this->season."' AND cropFrom='".$this->weeks[$j][0]."' AND cropTo='".$this->weeks[$j][1]."'");
					$res = $this->db->getResult();
					$values[$i][$k][$j] += $res[0]['quantity'];
				}
			}
	   }
	   
	   for($i=0;$i<count($this->grades);$i++){
            for($j=0;$j<count($this->weeks);$j++){
                $this->internals[$i][$j] = 0;
                for($k=0;$k<count($this->internalProjects);$k++){
                     $this->internals[$i][$j] += $values[$i][$k][$j];
                }
            }
	   }	  

	}
	
	public function setExternalGradeWeekQuantities(){
	    $values=array();    
	    for($i=0;$i<count($this->grades);$i++){
            for($j=0;$j<count($this->weeks);$j++){
                for($k=0;$k<count($this->externalProjects);$k++){
                   $values[$i][$k][$j]=0;
                }
            }
      	}
        
        for($i=0;$i<count($this->grades);$i++){
                       
            for($j=0;$j<count($this->weeks);$j++){
                
                for($k=0;$k<count($this->externalProjects);$k++){
                    $this->db->resetResult();
                    $this->db->select("qa_arrivalData","quantity","projectId='".$this->externalProjects[$k]."' AND gradeId='".$this->grades[$i]['gradeId']."' AND seasonId='".$this->season."' AND cropFrom='".$this->weeks[$j][0]."' AND cropTo='".$this->weeks[$j][1]."'");
                    $res = $this->db->getResult();
                    //print $this->internalProjects[$k]."-".$this->grades[$i]['gradeId']."||".$this->weeks[$j][0]."--".$this->weeks[$j][1]."---".$this->season;
                    $values[$i][$k][$j] += $res[0]['quantity'];
                }
            }
       	}
    	for($i=0;$i<count($this->grades);$i++){
                       
            for($j=0;$j<count($this->weeks);$j++){
                $this->externals[$i][$j] = 0;
                for($k=0;$k<count($this->externalProjects);$k++){
                     $this->externals[$i][$j] += $values[$i][$k][$j];
                }
            }
       }
    }
	
	function renderDataTable() {
		$g = new Grade();
		$cate = $g->getGradeCategoryNameById($this->gradeCategory) ;
		?>
		<div id="forecast-report">
		<h4 align="center">FORECASTED ARRIVAL PATTERN OF GRADE : <?php print $cate['name']?> </h4>
		<h4 align="center">Forecasted arrival pattern of ghrekins based on forecasted seeding plan</h4>
		<h4 style="border:1px solid #000;padding:8px" >Grade : <?php print $cate['name']?>- <strong>Internal</strong></h4>
		

		<table width="100%" height="100" border="1" cellpadding="0" cellspacing="0" style="font-size:10px;border-collapse:collapse">
  <tr>
    <td rowspan="2" align="center"><strong>Grade</strong> </td>
    <td rowspan="2" align="center"><strong>%</strong></td>
    <td colspan="<?php print count($this->weeks)?>" align="center"><strong>DELIVERY PERIOD</strong></td>
    <td rowspan="2" align="center"><strong>Total<br>MT s</strong></td>
  </tr>
  <tr>
    
    <?php 
    for ($i=0;$i<count($this->weeks);$i++){
    	print "<td><b>";
    	print $this->getWeekString($this->weeks[$i]);
    	print "</b></td>";
    }
    
    ?>
  </tr>
  <?php 
  $totalMain=0;
  $totalGradeShare=0;
  $weekTotal=array();
  $grandTotal=0;
  //making week total array
  for($k=0;$k<count($this->internals[0]);$k++){
  	$weekTotal[$k]=0;
  }
  
  for($i=0;$i<count($this->grades);$i++){
  	
  	print "<tr>";
  	print "<td>".$this->grades[$i]['fruitCount']."</td>";
  	print "<td>".$this->getGradeShare($this->grades[$i]['gradeId'])."</td>";
  	$totalGradeShare+=$this->getGradeShare($this->grades[$i]['gradeId']);
  	$total=0;
  	for($j=0;$j<count($this->internals[$i]);$j++){
  		print "<td>".$this->internals[$i][$j]."</td>";
  		$total+=$this->internals[$i][$j];
  		$weekTotal[$j]+=$this->internals[$i][$j];
  	}
  	print "<td>".$total."</td>";
  	$grandTotal+=$total;
  	print "</tr>";
  
  }
  	print "<tr>";
  	print "<td><strong>TOTAL</strong></td>";
  	print "<td><strong>$totalGradeShare</strong></td>";
	for($k=0;$k<count($this->internals[0]);$k++){
       print "<td><strong>$weekTotal[$k]</strong></td>";
    }
  	print "<td><strong>$grandTotal</strong></td>";
  	print "</tr>";
  ?> 
  
  
</table>
		
	<h4 style="border:1px solid #000;padding:8px" >Grade : <?php print $cate['name']?>- <strong>External</strong></h4>	
		
  <table width="100%" height="100" border="1" cellpadding="0" cellspacing="0" style="font-size:10px;border-collapse:collapse">
  <tr>
    <td rowspan="2" align="center"><strong>Grade</strong> </td>
    <td rowspan="2" align="center"><strong>%</strong></td>
    <td colspan="<?php print count($this->weeks)?>" align="center"><strong>DELIVERY PERIOD</strong></td>
    <td rowspan="2" align="center"><strong>Total<br>MT s</strong></td>
  </tr>
  <tr>
    
    <?php 
    for ($i=0;$i<count($this->weeks);$i++){
        print "<td><b>";
        print $this->getWeekString($this->weeks[$i]);
        print "</b></td>";
    }
    
    ?>
  </tr>
  <?php 
   $totalMain_ex=0;
  $totalGradeShare_ex=0;
  $grandTotal_ex=0;
  $weekTotal_ex=array();
  //making week total array
  for($k=0;$k<count($this->externals[0]);$k++){
    $weekTotal_ex[$k]=0;
  }
  
  
  for($i=0;$i<count($this->grades);$i++){
    
    print "<tr>";
    print "<td>".$this->grades[$i]['fruitCount']."</td>";
    print "<td>".$this->getGradeShare($this->grades[$i]['gradeId'])."</td>";
    $totalGradeShare_ex+=$this->getGradeShare($this->grades[$i]['gradeId']);
    $total=0;
    for($j=0;$j<count($this->externals[$i]);$j++){
        print "<td>".$this->externals[$i][$j]."</td>";
        $total+=$this->externals[$i][$j];
        $weekTotal_ex[$j]+=$this->externals[$i][$j];
    }
    print "<td>".$total."</td>";
    $grandTotal_ex+=$total;
    print "</tr>";
  }
  
    print "<tr>";
    print "<td><strong>TOTAL</strong></td>";
    print "<td><strong>$totalGradeShare_ex</strong></td>";
    for($k=0;$k<count($this->internals[0]);$k++){
       print "<td><strong>$weekTotal_ex[$k]</strong></td>";
    }
    print "<td><strong>$grandTotal_ex</strong></td>";
    print "</tr>";
  
  ?> 
  <tr height="10"></tr>
  <tr style="border:1px; background:#ccc;padding:10px 0 10px 0; font-size:12px ">
  <td colspan="2">WEEKLY TOTAL</td>
  <?php 
    for($k=0;$k<count($this->internals[0]);$k++){
       print "<td><strong>".($weekTotal_ex[$k]+$weekTotal[$k])."</strong></td>";
    }
  
  ?>
  <td><?php print ($grandTotal+$grandTotal_ex)?></td>
  </tr>
  
</table>
</div>
  <?php }
	
	private function getGradeShare($gradeId){
		$db=HDatabase::getInstance();
		$db->select("qa_ap_GradeShare","share","gradeId='$gradeId'");
		$res = $db->getResult();
		return $res[0]["share"];
	}
	
	private function getWeekString($week){
		$start = date($week[0]);
		$end = date($week[1]);
		//2012-02-01
		$sp1 = explode("-",$start);
		$fd = $sp1[2];
		$fm = $sp1[1];
		$y = $sp1[0];
		  $sp2 = explode("-",$end);
		  $ld = $sp2[2];
		  $lm = $sp2[1];
		  $weekStr=$fd."-".$fm."/".$ld."-".$lm."/".$y;
		  return $weekStr;
	}
}
?>