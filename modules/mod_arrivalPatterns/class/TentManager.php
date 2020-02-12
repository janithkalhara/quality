<?php
global $import;

$import->importLib("project");
$import->importLib("grade");
$import->importLib("season");
class TentManager{
    var $season;
	
	
	public function TentManager($season){
		$this->season=$season;
		
	}
    public function getSuppliers(){
        
        $project=new Project();
        $db=new HDatabase();
        $db->connect();
        $project=new Project();
        $db->select("qa_ap_revision","DISTINCT projectId" ,"seasonId='".$this->season."'");
        $res=$db->getResult();
        $suppliers=array();
        if($res){
            $i=0;
            foreach ($res as $t){
                $suppliers[$i]=$t['projectId'];
                //array_push($suppliers,$t['projectId']);
                $i++;
            }
        }
        $db->resetResult();
        $db->select("qa_ap_seedingPlan","DISTINCT projectId" ,"seasonId='".$this->season."'");
        $res2=$db->getResult();
        if($res2 ){
            $suppliers2=array();
            $i=0;
            foreach ($res2 as $t){
                $suppliers[$i]=$t['projectId'];
                
                //array_push($suppliers2,$t['projectId']);
                
                $i++;
            }
        }
        //
        $totalArray=array();
        $uniq=array_unique(array_merge($suppliers,$suppliers2));
        for($i=0;$i<count($uniq);$i++){
            $totalArray[$i][0]=$uniq[$i];
            $totalArray[$i][1]=$this->getLatestPlanOrRevisionId($uniq[$i], $this->season);
            $totalArray[$i][2]=$project->getInchargeNameByProjectId($uniq[$i]);
            $totalArray[$i][3]=$project->getGradeByProjectId($uniq[$i]);
        }
        
        
       return $totalArray;
        
        
    }
    
    
    
    public function getLatestPlanOrRevisionId($id,$season){
        
        $db=new HDatabase();
        $db->connect();
        
        $db->select("qa_ap_revision","MAX(weekCount) as latestweek","projectId='$id' AND seasonId='$season'","");
        $res=$db->getResult();
        if($res[0]['latestweek']!=NULL){
            return $res[0]['latestweek'];
        }else{
            return '1';
        }
        $db->__destruct();
        
    }
    function getOldestWeek(){
        
        $db=new HDatabase();
        $db->connect();
        
        $db->select("qa_ap_acerValue","DISTINCT week","revisionId LIKE '%-$this->season-%'","weekNumber");
        $res=$db->getResult();
        $weeks=array();
        $i=0;
        foreach ($res as $t){
            $seperatedWeek=$this->getSeperateWeek($t['week']);
            $weeks[$i]=$seperatedWeek[0];
                $i++;       
            
        }
        //sort($weeks);
        $numOfWeeks=count($weeks);
       // usort($weeks, "self::cmp");
        $ret=array();
        $ret['numofweeks']=$numOfWeeks;
        $ret['leastweek']=$res[0]['week'];
        
        return $ret;
        
        
    }
    function cmp($a, $b)
            {
                if ($a == $b) {
                    return 0;
                }
                return ($a < $b) ? -1 : 1;
            }
    
    function getSeperateWeek($week){
        $sp1=explode("/", $week);
        $y=$sp1[2];
        $s1=explode("-",$sp1[0]);
        $fd=$s1[0];
       // if($fd<10)$fd1="0".$fd;else $fd1=$fd;
        $fm=$s1[1];
        ///if($fm<10)$fm1="0".$fm;else $fm1=$fm;
        $s2=explode("-",$sp1[1]);
        
        $ld=$s2[0];
        //if($ld<10)$ld1="0".$ld;else $ld1=$ld;
        $lm=$s2[1];
       // if($lm<10)$lm1="0".$lm;else $lm1=$lm;
        $week_ret=array();
        $week_ret[0]=date($y."-".$fm."-".$fd);
        $week_ret[1]=date( $y."-".$lm."-".$ld);
        
        return $week_ret;
    }
    public function getWeekList($startWeek,$numOfWeeks){
        
    	
    	
        $week=$this->getSeperateWeek($startWeek);
        $start_week=$week[0];
        $timeStamp = StrToTime($startWeek);
        $end_week=$week[1];
        $weekList=array();
        
        $s=$start_week;
        $e=$end_week;
        for($i=0;$i<($numOfWeeks-1);$i++){
            
            $timeStamp = StrToTime($e);
            $e_d = StrToTime('+7 days', $timeStamp);
            $s_d= StrToTime('+1 days', $timeStamp);
            $e=date('Y-m-d',$e_d);
            $s=date('Y-m-d',$s_d);
            $weekList[$i]=date('d',$s_d).'-'.date('m',$s_d)."/".date('d',$e_d)."-".date('m',$e_d)."/".date('Y',$s_d);
            
        }
        array_unshift($weekList,$startWeek);
        return $weekList;
        
    }
    public function getWeekString($week){
    	
    	
    	
    	
    }
    
    
    public function getProjectPlans($grades,$suppliers){
        
        
        
        $db=new HDatabase();
        $db->connect();
        $project=new Project();
        //$db->select($table);
        $internal=array();
        $external=array();
        for($i=0;$i<count($suppliers);$i++){
            
             for($j=0;$j<count($suppliers[$i]);$j++){
                $cate=$project->getProjectCateById($suppliers[$i][0]);
                if(strtoupper($cate)=="IN"){
                    $internal[$i][$j]=$suppliers[$i][$j];
                }else if(strtoupper($cate)=="EX"){
                    $external[$i][$j]=$suppliers[$i][$j];
                }
             }
            
            
            
        }
        //seperate internal external ;
        
        $reportData=array();
        
        $reportData["IN"]=$this->getInternalsData($grades, $internal,$this->season);
        $reportData["EX"]=$this->getExternalsData($grades, $external,$this->season);
        $db->disconnect();
        return $reportData;
        
    }
    //parsing internal array to get plan data
    private function getInternalsData($grades,$internals,$season){
        $internalData=array();
        $keys=array_keys($internals);
        $project=new Project();
        for($i=0;$i<count($internals);$i++){
            for($j=0;$j<count($internals[$keys[$i]]);$j++){
                $internalData[$i]['cate']=$project->getGradeByProjectId($internals[$keys[$i]][0]);
                $internalData[$i][$internals[$keys[$i]][0]]=$this->getRevisionData($internals[$keys[$i]][0], $season, self::getLatestPlanOrRevisionId($internals[$keys[$i]][0], $season));
            }
            
        }
      // print_r($internals) ;
        return $internalData;
    }
    
    private function getExternalsData($grades,$externals,$season){
        $project=new Project();
        $externalData=array();
        $keys=array_keys($externals);
        for($i=0;$i<count($externals);$i++){
            for($j=0;$j<count($externals[$keys[$i]]);$j++){
                
               $externalData[$i]['cate']=$project->getGradeByProjectId($externals[$keys[$i]][0]);
                $externalData[$i][$externals[$keys[$i]][0]]=$this->getRevisionData($externals[$keys[$i]][0], $season, self::getLatestPlanOrRevisionId($externals[$keys[$i]][0], $season));
            }
            
        }
        return $externalData;
        
    }
    
    private function getRevisionData($p,$s,$w){
        
        $data=array();
        $revisionId=$p."-".$s."-".$w;
        $planId=$p."-".$s."-1";
        $weekValues=array();
        $db=new HDatabase();
        $db->connect();
        $db->select("qa_ap_acerValue","noOfAcers,seeded","revisionId='$revisionId'","weekNumber");
        $weekValues=$db->getResult();
        $data['weekValues']=$weekValues;
        $data['plannedAcerage']=$this->getPlannedAcerage($planId);
        if($w==1){
            $data['revisedAcerage']=0;
            
        }else{
            
            $data['revisedAcerage']=$this->getPlannedAcerage($revisionId);
        }
        $db->disconnect();
        return $data;
        
    }
    
    private function getPlannedAcerage($planId){
        $db=new HDatabase();
        $db->connect();
        
        $db->select("qa_ap_acerValue","noOfAcers","revisionId='$planId'","weekNumber");
        $res=$db->getResult();
        $value=0;
        if($res){
            foreach ($res as $temp) {
                $value+=$temp['noOfAcers'];
            }
            
            return $value;
        }else return NULL;
        
        
        
    }
    
    
    public function renderReport($header,$grades,$plans){
    	$s=new Season();
    	$date=date('d');
    	$prefix;
    	if($date%10==1)$prefix="st";
    	else if($date%10==2)$prefix="nd";
    	else if($date%10==3)$prefix="rd";
    	else $prefix="th"
    	?>
    	<h4 align="center">Tentative Acreage Plan <?php print $s->getOngoingSeason();?> Season <?php print date('Y');?> As @ <em><?php print $date." ".$prefix?>  <?php print date('F');?></em></h4>
    	
    	<table border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse;width:100%; font-size:11px">
  <tr><?php 
  for($i=0;$i<count($header);$i++){
  	print "<td class='header' align='center'>";
  	print $header[$i];
  print "</td>";
  }
  
  ?>
  </tr>
  <tr><td colspan="<?php print count($header)?>"><strong>Internal</strong></td>
  </tr>
  <?php 
  //printing internal set
  $internalPlans=$plans['IN'];
  $externalPlans=$plans['EX'];
 $seeded=0;$planned=0;
 $project=new Project();
 $grade=new Grade();
 $planInternalTotal=0;
 $reviseInternalTotal=0;
 $weekTotal=array();
  for($k=0;$k<(count($header)-7);$k++){
            $weekTotal[$k]=0;
  }
    $gradeTotals['plannedAcerage']=0;      
 
   for($j=0;$j<count($internalPlans);$j++){
    
    
        print "<tr>";
        $keys=array_keys($internalPlans[$j]);
            //print_r($keys);
        print "<td>".$project->getInchargeNameByProjectId($keys[1])."</td>";
        $name=$project->getProjectNameById($keys[1]);
        
        print "<td>".$name['areaName']."</td>";
        print "<td>".$internalPlans[$j]['cate']."</td>";
        
        print "<td>".$internalPlans[$j][$keys[1]]['plannedAcerage']."</td>";
        print "<td>".$internalPlans[$j][$keys[1]]['revisedAcerage']."</td>";
        
        //total setting
        $planInternalTotal+=$internalPlans[$j][$keys[1]]['plannedAcerage'];
        $reviseInternalTotal+=$internalPlans[$j][$keys[1]]['revisedAcerage'];
        //$gradeTotals[$i]+=$internalPlans[$i][$keys[1]]['plannedAcerage'];
        for($k=0;$k<(count($header)-7);$k++){
            //($internalPlans[$j][$grades[$i]]);$internalPlans[$j][$keys[1]]
            
            if(isset($internalPlans[$j][$keys[1]]['weekValues'][$k]['noOfAcers'])){
                
                $weekval=$internalPlans[$j][$keys[1]]['weekValues'][$k]['noOfAcers'];
                $weekTotal[$k]+=$internalPlans[$j][$keys[1]]['weekValues'][$k]['noOfAcers'];
                $seed=$internalPlans[$j][$keys[1]]['weekValues'][$k]['seeded'];
                if($seed==1){
                	$seeded+=$weekval;
                	print "<td><strong>".$weekval."</strong></td>";
                }else{
                	$planned+=$weekval;
                	print "<td>".$weekval."</td>";
                }
                
                
            }else{
                print "<td>0</td>";
            }
            
        }
        
        print "<td>".$internalPlans[$j][$keys[1]]['revisedAcerage']."</td>";
        print "<td>".($internalPlans[$j][$keys[1]]['plannedAcerage']-$internalPlans[$j][$keys[1]]['revisedAcerage'])."</td>";
        print "</tr>";
    
        
  
   }     
  
  //printing total row
  ?>
  <tr style="background:#ccc">
  <td><strong>Total</strong></td>
   <td></td> <td></td>
   <td><strong><?php print $planInternalTotal?></strong></td>
   <td><strong><?php print $reviseInternalTotal?></strong></td>
  <?php 
   for($k=0;$k<(count($header)-7);$k++){
   	if(isset($weekTotal[$k])){
   		print "<td><strong>".$weekTotal[$k]."</strong></td>";
   	}else{
   		print "<td><strong>0</strong></td>";
   	}
        
   
   }
   ?>
   <td><strong><?php print $reviseInternalTotal?></strong></td>
    <td><strong><?php print ($planInternalTotal-$reviseInternalTotal)?></strong></td>
  </tr>
   <tr><td colspan="<?php print count($header)?>"><strong>External</strong></td>
  </tr>
  <?php 
  //printing external set
  
 
 $planExternalTotal=0;
 $reviseExternalTotal=0;
 $exWeekTotal=array();
  for($k=0;$k<(count($header)-7);$k++){
            $exWeekTotal[$k]=0;
         }
  $gradeTotals=array();
  for($i=0;$i<count($grades);$i++){
  	
  }
  for($j=0;$j<count($externalPlans);$j++){
    
    
        print "<tr>";
        $keys=array_keys($externalPlans[$j]);
            //print_r($keys);
        print "<td>".$project->getInchargeNameByProjectId($keys[1])."</td>";
        $name=$project->getProjectNameById($keys[1]);
        
        print "<td>".$name['areaName']."</td>";
        print "<td>".$externalPlans[$j]['cate']."</td>";
        print "<td>".$externalPlans[$j][$keys[1]]['plannedAcerage']."</td>";
        print "<td>".$externalPlans[$j][$keys[1]]['revisedAcerage']."</td>";
        
        $planExternalTotal+=$externalPlans[$j][$keys[1]]['plannedAcerage'];
         $reviseExternalTotal=$externalPlans[$j][$keys[1]]['revisedAcerage'];
         
        for($k=0;$k<(count($header)-7);$k++){
            //($internalPlans[$j][$grades[$i]]);$internalPlans[$j][$keys[1]]
           // $exWeekTotal[$k]=0;
            if(isset($externalPlans[$j][$keys[1]]['weekValues'][$k]['noOfAcers'])){
                
                $weekvalEx=$externalPlans[$j][$keys[1]]['weekValues'][$k]['noOfAcers'];
                $exWeekTotal[$k]+=$weekvalEx;
                $seed=$externalPlans[$j][$keys[1]]['weekValues'][$k]['seeded'];
                if($seed==1){
                    $seeded+=$weekvalEx;
                    print "<td><strong>".$weekvalEx."</strong></td>";
                }else{
                    $planned+=$weekvalEx;
                    print "<td>".$weekvalEx."</td>";
                }
                
                //print "<td>".$weekvalEx."</td>";
            }else{
                print "<td>0</td>";
            }
            
        }
        print "<td>".$externalPlans[$j][$keys[1]]['revisedAcerage']."</td>";
        print "<td>".($externalPlans[$j][$keys[1]]['plannedAcerage']-$externalPlans[$j][$keys[1]]['revisedAcerage'])."</td>";
        print "</tr>";
    //}
    
  }
  //printing total row
  ?>
  <tr style="background:#ccc">
  <td><strong>Total</strong></td>
   <td></td> <td></td>
   <td><strong><?php print $planExternalTotal?></strong></td>
   <td><strong><?php print $reviseExternalTotal?></strong></td>
  <?php 
   for($k=0;$k<(count($header)-7);$k++){
    if(isset($exWeekTotal[$k])){
        print "<td><strong>".$exWeekTotal[$k]."</strong></td>";
    }else{
        print "<td><strong>0</strong></td>";
    }
        
   
   }
   ?>
   <td><strong><?php print $reviseExternalTotal?></strong></td>
    <td><strong><?php print ($planExternalTotal-$reviseExternalTotal)?></strong></td>
  </tr>
   <tr style="font-size:12px">
  <td><strong>GrandTotal</strong></td>
   <td></td> <td></td>
   <td><strong><?php print $planExternalTotal+$planInternalTotal?></strong></td>
   <td><strong><?php print $reviseExternalTotal+$reviseInternalTotal?></strong></td>
  <?php 
   for($k=0;$k<(count($header)-7);$k++){
    if(isset($exWeekTotal[$k])|| isset($weekTotal[$k])){
        print "<td><strong>".($exWeekTotal[$k]+$weekTotal[$k])."</strong></td>";
    }else{
        print "<td><strong>0</strong></td>";
    }
        
   
   }
   ?>
   <td><strong><?php print $reviseExternalTotal+$reviseInternalTotal?></strong></td>
    <td><strong><?php print ($planExternalTotal+$planInternalTotal)-($reviseExternalTotal+$reviseInternalTotal)?></strong></td>
  </tr>
  <tr>
  <td colspan="2"><strong>Seeded Acreage</strong></td>
  <td colspan="2"><strong><?php print $seeded?></strong></td>
  </tr>
  <tr>
  <td colspan="2"><strong>Planned Acreage</strong></td>
  <td colspan="2"><strong><?php print $planned?></strong></td>
  </tr>
</table>

    	
    	
    	<?php 
    	
    }
    
}



?>