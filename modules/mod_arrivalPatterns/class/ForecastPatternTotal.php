<?php 
global $import;
$import->importLib("grade");

class TotalManager{
	private $season;
	private $grades;
	private $subGrades=array();
	private $weeks;	
	private $db;
	private $quantities=array();
	public function TotalManager($s){
		
		$this->season=$s;
		$this->db=new HDatabase();
		$this->db->connect();
		$g=new Grade();
        
       
        $this->grades=$g->getGradeCategories();
	}
	
	
	public function setSubGrades(){
		$g=new Grade();
		foreach ($this->grades as $temp){
			$r=$g->getGradesByCategory($temp['id']);
			array_push($this->subGrades,$r);
		}
		
	}
	
	function setWeekList(){
		
	   $this->db->resetResult();
       $this->db->select("qa_arrivalData","DISTINCT cropFrom","seasonId='$this->season'");
       $res=$this->db->getResult();
       $weeks=array();
       foreach ($res as $temp){
        
        array_push($weeks, $temp['cropFrom']);
        
       }
        sort($weeks);
       $weekList=array();
        for($i=0;$i<count($weeks);$i++){
            $weekList[$i][0]=$weeks[$i];
            $e_d = StrToTime('+6 days', StrToTime($weeks[$i]));
            $weekList[$i][1]=date('Y-m-d',$e_d);
            
        }
        $this->weeks=$weekList;

        
		
	}
	
	function setWeekGradewiseQuantities(){
		
		
		for($i=0;$i<count($this->grades);$i++){
			for($j=0;$j<count($this->subGrades[$i]);$j++){
				for($k=0;$k<count($this->weeks);$k++){
					
					$this->quantities[$i][$j][$k]=$this->getPatternByGradeAndWeek($this->subGrades[$i][$j]['gradeId'], $this->weeks[$k]);
				 
					
				}
				
				
			}
			
		}
		
		
		
	}
	
	private function getPatternByGradeAndWeek($gradeId,$week) {
		
		$this->db->resetResult();
		$this->db->select("qa_arrivalData","quantity","gradeId='$gradeId' AND cropFrom='".$week[0]."' AND cropTo='".$week[1]."'");
		$res=$this->db->getResult();
		$total=0;
		if(isset($res)){
			foreach ($res as $temp){
	            
	            $total+=$temp['quantity'];
	        }
		}
		
		return $total;
		
	}
	private function getWeekString($week){
        $start=date($week[0]);
        $end=date($week[1]);
        //2012-02-01
        $sp1=explode("-",$start);
        $fd=$sp1[2];
        $fm=$sp1[1];
        $y=$sp1[0];
          $sp2=explode("-",$end);
          $ld=$sp2[2];
          $lm=$sp2[1];
          
          $weekStr=$fd."-".$fm."/".$ld."-".$lm."/".$y;
          return $weekStr;
    }
    
	
	public function renderReport(){
	
	$s=new Season();
		$date=date('d');
        $prefix;
        if($date%10==1)$prefix="st";
        else if($date%10==2)$prefix="nd";
        else if($date%10==3)$prefix="rd";
        else $prefix="th"
		?>
		<h4 align="center">FORECASTED ARRIVAL PATTERNS OF GHERKIN<BR>AS @ <?php print $s->getOngoingSeason();?> Season <?php print date('Y');?> As @ <em><?php print $date." ".$prefix?>  <?php print date('F');?></em></h4>
		<table width="100%" height="100" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse; font-size:10px">
  <tr>
    <td rowspan="2" align="center"><strong>GRADE</strong></td>
   
    <td colspan="<?php print (count($this->weeks))?>" align="center"><strong>DELIVERY PERIOD</strong></td>
    <td rowspan="2"><strong>TOTAL</strong></td>
  </tr>
  <tr>
  
  <?php 
  for($i=0;$i<count($this->weeks);$i++){
  	print "<td><strong>".$this->getWeekString($this->weeks[$i])."</strong></td>";
  }
  
  ?>
 
  </tr>
  
  <?php 
  $weeklyGrandTotal=array();
  for($i=0;$i<count($this->grades);$i++){
	for($k=0;$k<count($this->weeks);$k++){
            $weeksTotals[$i][$k]=0;          
            $weeklyGrandTotal[$k]=0;
                    
                }
  } 
 
	for($i=0;$i<count($this->grades);$i++){
		$totalAll=0;
		$totals=array();
		print " <tr height='15'></tr>";
		print "<tr height='15'><td style='background:#ccc' colspan='".(count($this->weeks)+2)."'><strong>".$this->grades[$i]['name'];
		print " Fruits</strong></td></tr>";
		
            for($j=0;$j<count($this->subGrades[$i]);$j++){
            	print "<tr>";
            	print "<td><strong>".$this->subGrades[$i][$j]['fruitCount']."</strong></td>";
            	$total=0;
                for($k=0;$k<count($this->weeks);$k++){
                    
                   print "<td>".$this->quantities[$i][$j][$k]."</td>";
                   $total+=$this->quantities[$i][$j][$k];
                   $weeksTotals[$i][$k]+=$this->quantities[$i][$j][$k]; 
                   $weeklyGrandTotal[$k]+=$this->quantities[$i][$j][$k];
                }
                print "<td>".$total."</td>";
                $totalAll+=$total;
               
                print "</tr>";
               
            }
                print "<tr>";
                print "<td><strong> TOTAL</strong></td>";
                $total=0;
                for($k=0;$k<count($this->weeks);$k++){
                    print "<td><strong>".$weeksTotals[$i][$k]."</strong></td>";
                }
                print "<td><strong>".$totalAll."</strong></td>";
                print "</tr>";
               ///setting average week crop 
                print "<tr height='10'><tr>";
                print "<tr>";
                print "<td><strong> AVG/DAY </strong></td>";
                $total=0;
                for($k=0;$k<count($this->weeks);$k++){
                    print "<td><strong>".round($weeksTotals[$i][$k]/7,2)."</strong></td>";
                }
                print "<td><strong>".round($totalAll/7,2)."</strong></td>";
                print "</tr>";
        }
                print "<tr height='10'><tr>";
                print "<tr>";
                print "<td><strong>WEEKLY FORECAST</strong></td>";
                $total=0;
                for($k=0;$k<count($this->weeks);$k++){
                    print "<td><strong>".$weeklyGrandTotal[$k]."</strong></td>";
                }
                print "<td><strong>".round($totalAll/7,2)."</strong></td>";
  
  
  ?>
  
  
  
  
  
</table>
		
		
		<?php 
		
		
	}
	
}



?>