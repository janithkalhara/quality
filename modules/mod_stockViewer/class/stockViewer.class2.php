<?php


require_once 'helper.php';
class reportGenerator{
	private $date;
	private $date_f;
	private $date_l;
	private $vehicleNo;
	private $project;
	private $headerData=array();
	private $db;
	private $gradeArray=array(0,0,0,0);
	private $transportArray=array();
	private $gradeStock=array();
	private $samples=array();
	private $gradeSamples=array();
	private $gradeSampleSums=array(0,0,0,0);
	private $percentages=array();
	private $centers=array();
	
	
	public function reportGenerator($date,$vehicleNo,$project){
		$this->date=$date;
		$this->date_f=$this->date." 00:00:00";
        $this->date_l=$this->date." 23:59:59";
		$this->project=$project;
		$this->vehicleNo=$vehicleNo;
		$this->db=new HDatabase();
		$this->db->connect();
		
		$this->setGrades();
	    $this->setTransportArray();
	    $this->setGradeStock();
	    $this->setSampleData();
	    $this->setSamples();
	    $this->setPercentageArray();
	    $this->getCenterData();
	}
	
	
	
	public function setTransportArray(){
		$dbo=new HDatabase();
		$dbo->connect();
		
		
		$dbo->select('qa_stock','*',"areaId='$this->project' AND vehicleNo='$this->vehicleNo' AND date>='$this->date_f' AND date<='$this->date_l'" );
		$res=$dbo->getResult();
		
		foreach ($res as $temp){
			$this->transportArray['handovering']=$temp['handovering'];
			$this->transportArray['lorryCovering']=$temp['lorryCovering'];
			$this->transportArray['otherGoods']=$temp['otherGoods'];
			$this->transportArray['badSmell']=$temp['badSmell'];
			$this->transportArray['labelling']=$temp['labelling'];
			$this->transportArray['qualityReports']=$temp['qualityReports'];
			
		}
	   return true;
	}
	
	public function setGrades(){
		$grades;
		$dbo=new HDatabase();
		$dbo->connect();
		$dbo->select('qa_gradeStock','gradeId',"project='$this->project' AND  date>='$this->date_f' AND date<='$this->date_l' AND vehicleNo='$this->vehicleNo'");
		$res=$dbo->getResult();
		for($i=0;$i<count($res);$i++){
			
			$this->gradeArray[$i]=$res[$i]['gradeId'];
			
		}return true;
	}
	
	public function setGradeStock(){
		
		$dbo=new HDatabase();
		$dbo->connect();
		
		for($i=0;$i<count($this->gradeArray);$i++){
		  if($this->gradeArray[$i]!=0){
		  	$dbo->select('qa_gradeStock','*',"project='$this->project' AND  date>='$this->date_f' AND date<='$this->date_l' AND 
		  	         vehicleNo='$this->vehicleNo' AND gradeId='".$this->gradeArray[$i]."'");
		  	$res2=$dbo->getResult();
		  	foreach ($res2 as $temp){
		  		if(isset($temp['notedWeight'])){
		  		  	    $this->gradeStock[$this->gradeArray[$i]]['noOfCrates']=$temp['noOfCrates'];
                        $this->gradeStock[$this->gradeArray[$i]]['notedWeight']=$temp['notedWeight'];
                        $this->gradeStock[$this->gradeArray[$i]]['trueWeight']=$temp['trueWeight'];
                        $this->gradeStock[$this->gradeArray[$i]]['averageFruitCount']=$temp['averageFruitCount'];
                        $this->gradeStock[$this->gradeArray[$i]]['fruitCount']=$temp['fruitCount'];
                        $this->gradeStock[$this->gradeArray[$i]]['sumOfSmallFruit']=$temp['sumOfSmallFruit'];
                        $this->gradeStock[$this->gradeArray[$i]]['sumOfLargeFruit']=$temp['sumOfLargeFruit'];
                        $this->gradeStock[$this->gradeArray[$i]]['sumOfFlyAttacked']=$temp['sumOfFlyAttacked'];
                        $this->gradeStock[$this->gradeArray[$i]]['sumOfPeeledOff']=$temp['sumOfPeeledOff'];
                        $this->gradeStock[$this->gradeArray[$i]]['sumOfBoreAttacked']=$temp['sumOfBoreAttacked'];
                        $this->gradeStock[$this->gradeArray[$i]]['sumOfSandEmbedded']=$temp['sumOfSandEmbedded'];
                        $this->gradeStock[$this->gradeArray[$i]]['sumOfShrivelled']=$temp['sumOfShrivelled'];
                        $this->gradeStock[$this->gradeArray[$i]]['sumOfDeformed']=$temp['sumOfDeformed'];
                        $this->gradeStock[$this->gradeArray[$i]]['sumOfVirusAttacked']=$temp['sumOfVirusAttacked'];
                        $this->gradeStock[$this->gradeArray[$i]]['sumOfMechanicalDamaged']=$temp['sumOfMechanicalDamaged'];
                        $this->gradeStock[$this->gradeArray[$i]]['sumOfYellowish']=$temp['sumOfYellowish'];
                        $this->gradeStock[$this->gradeArray[$i]]['sumOfRustPatches']=$temp['sumOfRustPatches'];
                        $this->gradeStock[$this->gradeArray[$i]]['sumOfRotten']=$temp['sumOfRotten'];
                        $this->gradeStock[$this->gradeArray[$i]]['totalPerOfDefectGrade']=$temp['totalPerOfDefectGrade'];
                        $this->gradeStock[$this->gradeArray[$i]]['totalPerOfDefect']=$temp['totalPerOfDefect'];
                        $this->gradeStock[$this->gradeArray[$i]]['reducedPerOfDefectGrade']=$temp['reducedPerOfDefectGrade'];
                        $this->gradeStock[$this->gradeArray[$i]]['reducedPerOfDefect']=$temp['reducedPerOfDefect'];
                        $this->gradeStock[$this->gradeArray[$i]]['payableQuantity']=$temp['payableQuantity'];
		  		  	
		  		  }
		  	  }
		 
		  }
	
	   }
	 
	   return true;
	}
	
	/*Get sample Details*/
	    
	public function setSampleData(){
		$db=new HDatabase();
        $db->connect();
		
		$gradeSamples=array();
		for($i=0; $i<count($this->gradeArray);$i++){
			
			if($this->gradeArray[$i]!=0){
				
				$db->select('qa_sample','*',"date>='$this->date_f' AND date<='$this->date_l' AND vehicleNo='".$this->vehicleNo."' AND gradeId=".$this->gradeArray[$i]."");
				
				$this->gradeSamples[$i]=$db->getResult();
				
				$db->resetResult();
			}
		}
	}
    
	public function getCenterData(){
		$db=new HDatabase();
		$db->connect();
		
		$db->select('qa_center_fakes','centerFakeId,centerName,TMno',"project='$this->project' AND  date>='$this->date_f' AND date<='$this->date_l' AND vehicleNo='$this->vehicleNo'");
		$res=$db->getResult();
        $i=0;
        if(isset($res)){
		  foreach ($res as $temp){
				 $centerFakeId=$temp['centerFakeId'];
				 $this->centers[$centerFakeId]['centerName']=$temp['centerName'];
			     $this->centers[$centerFakeId]['tmNo']=$temp['TMno'];
			     $i++;
		  }
        }
	}
	
	public function setSamples(){
		
		for($i=0;$i<count($this->gradeSamples);$i++){
			
			$this->gradeSampleSums[$i]=count($this->gradeSamples[$i]);
			for($j=0;$j<count($this->gradeSamples[$i]);$j++){
				
				$sampleId=$this->gradeSamples[$i][$j]['sampleId'];
				$this->samples[$i][$sampleId]['centerId']=$this->gradeSamples[$i][$j]['centerId'];
				$this->samples[$i][$sampleId]['fruitCount']=$this->gradeSamples[$i][$j]['fruitCount'];
				$this->samples[$i][$sampleId]['smallFruit']=$this->gradeSamples[$i][$j]['smallFruit'];
				$this->samples[$i][$sampleId]['largeFruit']=$this->gradeSamples[$i][$j]['largeFruit'];
				$this->samples[$i][$sampleId]['flyAttacked']=$this->gradeSamples[$i][$j]['flyAttacked'];
				$this->samples[$i][$sampleId]['peeledOff']=$this->gradeSamples[$i][$j]['peeledOff'];
				$this->samples[$i][$sampleId]['boreAttacked']=$this->gradeSamples[$i][$j]['boreAttacked'];
				$this->samples[$i][$sampleId]['sandEmbedded']=$this->gradeSamples[$i][$j]['sandEmbedded'];
				$this->samples[$i][$sampleId]['shrivelled']=$this->gradeSamples[$i][$j]['shrivelled'];
				$this->samples[$i][$sampleId]['deformed']=$this->gradeSamples[$i][$j]['deformed'];
				$this->samples[$i][$sampleId]['virusAttacked']=$this->gradeSamples[$i][$j]['virusAttacked'];
				$this->samples[$i][$sampleId]['mechanicalDamaged']=$this->gradeSamples[$i][$j]['mechanicalDamaged'];
				$this->samples[$i][$sampleId]['yellowish']=$this->gradeSamples[$i][$j]['yellowish'];
				$this->samples[$i][$sampleId]['rustPatches']=$this->gradeSamples[$i][$j]['rustPatches'];
				$this->samples[$i][$sampleId]['accepted']=$this->gradeSamples[$i][$j]['accepted'];
				$this->samples[$i][$sampleId]['spoiled']=$this->gradeSamples[$i][$j]['spoiled'];
				
			}
		}
	}
	
	public function setPercentageArray(){
		
	     for($i=0;$i<count($this->gradeArray);$i++){
	     	if($this->gradeArray[$i]!=0){
	     		
	
	     		$sampleWeight=$this->getSampleSize($this->gradeArray[$i]);
	     		
	     		$numOfSamples=$this->gradeSampleSums[$i];
	     		
	     		$averageFC= $this->gradeStock[$this->gradeArray[$i]]['averageFruitCount'];
	     		$divider=$averageFC*$sampleWeight*$numOfSamples;
	     		if($divider!=0){
	     			$this->percentages[$i]['perOfSmallFruit'] =$this->gradeStock[$this->gradeArray[$i]]['sumOfSmallFruit']/$divider;
                    $this->percentages[$i]['perOfSmallFruit']=round($this->percentages[$i]['perOfSmallFruit']*100,2);
                
                    
                $this->percentages[$i]['perOfLargeFruit']= $this->gradeStock[$this->gradeArray[$i]]['sumOfLargeFruit']/$divider;
                    $this->percentages[$i]['perOfLargeFruit']=round($this->percentages[$i]['perOfLargeFruit']*100,2);
                
                $this->percentages[$i]['perOfFlyAttacked']= $this->gradeStock[$this->gradeArray[$i]]['sumOfFlyAttacked']/$divider;    
                    $this->percentages[$i]['perOfFlyAttacked']=round($this->percentages[$i]['perOfFlyAttacked']*100,2);
                
                $this->percentages[$i]['perOfPeeledOff']= $this->gradeStock[$this->gradeArray[$i]]['sumOfPeeledOff']/$divider;    
                    $this->percentages[$i]['perOfPeeledOff']=round($this->percentages[$i]['perOfPeeledOff']*100,2);
                
                $this->percentages[$i]['perOfBoreAttacked']= $this->gradeStock[$this->gradeArray[$i]]['sumOfBoreAttacked']/$divider;    
                    $this->percentages[$i]['perOfBoreAttacked']=round($this->percentages[$i]['perOfBoreAttacked']*100,2);
                
                $this->percentages[$i]['perOfSandEmbedded']= $this->gradeStock[$this->gradeArray[$i]]['sumOfSandEmbedded']/$divider; 
                    $this->percentages[$i]['perOfSandEmbedded']=round($this->percentages[$i]['perOfSandEmbedded']*100,2);
                
                $this->percentages[$i]['perOfShrivelled']= $this->gradeStock[$this->gradeArray[$i]]['sumOfShrivelled']/$divider; 
                    $this->percentages[$i]['perOfShrivelled']=round($this->percentages[$i]['perOfShrivelled']*100,2);
                
                $this->percentages[$i]['perOfDeformed']= $this->gradeStock[$this->gradeArray[$i]]['sumOfDeformed']/$divider; 
                    $this->percentages[$i]['perOfDeformed']=round($this->percentages[$i]['perOfDeformed']*100,2);
                
                $this->percentages[$i]['perOfVirusAttacked']= $this->gradeStock[$this->gradeArray[$i]]['sumOfVirusAttacked']/$divider; 
                    $this->percentages[$i]['perOfVirusAttacked']=round($this->percentages[$i]['perOfVirusAttacked']*100,2);
                 
                $this->percentages[$i]['perOfMechanicalDamaged']= $this->gradeStock[$this->gradeArray[$i]]['sumOfMechanicalDamaged']/$divider; 
                    $this->percentages[$i]['perOfMechanicalDamaged']=round($this->percentages[$i]['perOfMechanicalDamaged']*100,2);
            
                $this->percentages[$i]['perOfYellowish']= $this->gradeStock[$this->gradeArray[$i]]['sumOfYellowish']/$divider; 
                    $this->percentages[$i]['perOfYellowish']=round($this->percentages[$i]['perOfYellowish']*100,2);
            
                $this->percentages[$i]['perOfRustPatches']= $this->gradeStock[$this->gradeArray[$i]]['sumOfRustPatches']/$divider; 
                    $this->percentages[$i]['perOfRustPatches']=round($this->percentages[$i]['perOfRustPatches']*100,2);
                 
                $this->percentages[$i]['perOfRotten']= $this->gradeStock[$this->gradeArray[$i]]['sumOfRotten']/$divider; 
                    $this->percentages[$i]['perOfRotten']=round($this->percentages[$i]['perOfRotten']*100,2);
            
	     			
	     		}
	     		
	     	}
	     }
	}
	
    private  function getSampleSize($gradeId){
		$db=new HDatabase();
		$db->connect();
		$db->select('qa_grade','sampleWeight',"gradeId='$gradeId'");
	   $res=$db->getResult();
	   $sampleWeight;
	   foreach ($res as $temp){
	   	$sampleWeight=$temp['sampleWeight'];
	   	
	   }
	  return $sampleWeight;
	}
	
	private function getGradeName($gradeId){
		$db=new HDatabase();
		$db->connect();
		$db->select('qa_grade','fruitCount',"gradeId=$gradeId");
		$res=$db->getResult();
		
		foreach ($res as $temp){
			$fruitCount=$temp['fruitCount'];
			
		}
		return $fruitCount;
		
	}
	
	private function getStation(){
		    
		$db=new HDatabase();
		$db->connect();
		$db->select('qa_stockUpdates','userId',"vehicleNo='$this->vehicleNo' AND date>='$this->date_f' AND date<='$this->date_l'");
		$res=$db->getResult();
		$updater;
		if(isset($res)){
		foreach ($res as $temp){
			$updater=$temp['userId'];
			
		}
		}
		
		$db->resetResult();
		if(isset($updater)){
			$db->select(' qa_station','stationName',"inchargePersonId='$updater'");
		    $res2=$db->getResult();
		    $station;
		    if(isset($res2)){
		      foreach ($res2 as $temp){
			     $station=$temp['stationName'];
			
		      }
		      return $station;
		  }
		}
		
	}
	public function setHeaderTable(){
    /* Render the header table*/    
    ?>
        <table width="1080" border="1" id="headertable" cellpadding="0" cellspacing="0">
        <tr>
        <td width="231" align="center"><b> HJS</b>  <b>Condiments Limited <br> 
        SunFrost (PVT) LTD<b></b></td>
        <td colspan="10" align="center"><b>ගර්කින් තත්ව පරීක්ෂණ වාර්තාව (Medium,Large and CRS Grades)</b> </td>
        <td>Issue No: 01 <br> Issue Date : 2011.09.03</td>
        </tr>
        </table>
        <table width="1080" border="1" id="headertable" cellpadding="0" cellspacing="0">
 


        <tr>
        <td align="left" width="200" >ගෙඩි භාරගත් ස්ථානය <span style="font-weight:bold;float:right; padding-right:10px;"><?php print_r($this->getStation());?></span></td>
        <td width="78" align="right">දිනය: &nbsp;&nbsp;</td>
        <td width="80" id="print_date" align="center"><?php print $this->date;?> </td>
        <td width="97" align="right">ව්‍යාපෘතිය : &nbsp;&nbsp;</td><td width="97" id="print-project" align="center"> <?php print $this->project;?></td>
        <td width="115" align="right">වාහන අංකය :&nbsp;&nbsp; </td><td width="70" id="print-vehicle" align="center"><?php print $this->vehicleNo;?></td>


</tr>

</table>
        <?php 
    }
    
	
	public function setMainTable(){
		
		?>
		<table width="1080" height="855" border="1" cellpadding="0" cellspacing="0" class="data-print" style="margin:0px; font-size:12px;
		">
    <tr>
    <td colspan="6">&nbsp;</td>
    <td colspan="2" class="tableheader">ශ්‍රේණිය</td>
    <td colspan="2" id="1-print-grade" ><?php 
    if($this->gradeArray[0]!=0){
   
  print($this->getGradeName($this->gradeArray[0])) ;
   
    }?>
    
    </td>
    <td colspan="2">&nbsp;</td>
    <td colspan="4" class="tableheader">අනුමත ගෙඩි ගණන</td>
    <td colspan="3" id="1-print-avgFruitCount"><?php if($this->gradeArray[0]!=0) print $this->gradeStock[$this->gradeArray[0]]['averageFruitCount']; ?></td>
    <td width="27">එකතුව</td>
    <td width="23">%</td>
    <td width="2">&nbsp;</td>
    <td colspan="2" class="tableheader">ශ්‍රේණිය</td>
    <td colspan="2" id="2-print-grade">
    <?php 
    if($this->gradeArray[1]!=0){
   
  
    print($this->getGradeName($this->gradeArray[1])) ;
    }?></td>
    <td colspan="2">&nbsp;</td>
    <td colspan="4"><span class="tableheader">අනුමත ගෙඩි ගණන</span></td>
    <td colspan="3" id="2-print-avgFruitCount"><?php if($this->gradeArray[1]!=0) print $this->gradeStock[$this->gradeArray[1]]['averageFruitCount']; ?></td>
    <td width="27">එකතුව</td>
    <td width="22">%</td>
  </tr>
  <tr>
    <td colspan="6" class="tableheader">මධ්‍යස්ථාන අංකය</td>
    <td width="30" id="1-print-slot-0-0"><?php if(isset($this->samples[0][0]['centerId'])) print($this->samples[0][0]['centerId']) ?></td>
    <td width="26" id="1-print-slot-0-1"><?php if(isset($this->samples[0][1]['centerId'])) print($this->samples[0][1]['centerId']) ?></td>
    <td width="26" id="1-print-slot-0-2"><?php if(isset($this->samples[0][2]['centerId'])) print($this->samples[0][2]['centerId']) ?></td>
    <td width="27" id="1-print-slot-0-3"><?php if(isset($this->samples[0][3]['centerId'])) print($this->samples[0][3]['centerId']) ?></td>
    <td width="29" id="1-print-slot-0-4"><?php if(isset($this->samples[0][4]['centerId'])) print($this->samples[0][4]['centerId']) ?></td>
    <td width="27" id="1-print-slot-0-5"><?php if(isset($this->samples[0][5]['centerId'])) print($this->samples[0][5]['centerId']) ?></td>
    <td width="23" id="1-print-slot-0-6"><?php if(isset($this->samples[0][6]['centerId'])) print($this->samples[0][6]['centerId']) ?></td>
    <td width="24" id="1-print-slot-0-7"><?php if(isset($this->samples[0][7]['centerId'])) print($this->samples[0][7]['centerId']) ?></td>
    <td width="25" id="1-print-slot-0-8"><?php if(isset($this->samples[0][8]['centerId'])) print($this->samples[0][8]['centerId']) ?></td>
    <td width="21" id="1-print-slot-0-9"><?php if(isset($this->samples[0][9]['centerId'])) print($this->samples[0][9]['centerId']) ?></td>
    <td width="24" id="1-print-slot-0-10"><?php if(isset($this->samples[0][10]['centerId'])) print($this->samples[0][10]['centerId']) ?></td>
    <td width="26" id="1-print-slot-0-11"><?php if(isset($this->samples[0][11]['centerId'])) print($this->samples[0][11]['centerId']) ?></td>
    <td width="26" id="1-print-slot-0-12"><?php if(isset($this->samples[0][12]['centerId'])) print($this->samples[0][12]['centerId']) ?></td>
    <td width="27" id="1-print-slot-0-13"></td>
    <td width="23" id="1-print-slot-0-14">&nbsp;</td>
    <td width="2" rowspan="24" style="background:#999">&nbsp;</td>
    <td width="23" id="2-print-slot-0-0"><?php if(isset($this->samples[1][0]['centerId'])) print($this->samples[1][0]['centerId']) ?></td>
    <td width="24" id="2-print-slot-0-1"><?php if(isset($this->samples[1][1]['centerId'])) print($this->samples[1][1]['centerId']) ?></td>
    <td width="27" id="2-print-slot-0-2"><?php if(isset($this->samples[1][2]['centerId'])) print($this->samples[1][2]['centerId']) ?></td>
    <td width="25" id="2-print-slot-0-3"><?php if(isset($this->samples[1][3]['centerId'])) print($this->samples[1][3]['centerId']) ?></td>
    <td width="26" id="2-print-slot-0-4"><?php if(isset($this->samples[1][4]['centerId'])) print($this->samples[1][4]['centerId']) ?></td>
    <td width="25" id="2-print-slot-0-5"><?php if(isset($this->samples[1][5]['centerId'])) print($this->samples[1][5]['centerId']) ?></td>
    <td width="28" id="2-print-slot-0-6"><?php if(isset($this->samples[1][6]['centerId'])) print($this->samples[1][6]['centerId']) ?></td>
    <td width="26" id="2-print-slot-0-7"><?php if(isset($this->samples[1][7]['centerId'])) print($this->samples[1][7]['centerId']) ?></td>
    <td width="27" id="2-print-slot-0-8"><?php if(isset($this->samples[1][8]['centerId'])) print($this->samples[1][8]['centerId']) ?></td>
    <td width="28" id="2-print-slot-0-9"><?php if(isset($this->samples[1][9]['centerId'])) print($this->samples[1][9]['centerId']) ?></td>
    <td width="27" id="2-print-slot-0-10"><?php if(isset($this->samples[1][10]['centerId'])) print($this->samples[1][10]['centerId']) ?></td>
    <td width="26" id="2-print-slot-0-11"><?php if(isset($this->samples[1][11]['centerId'])) print($this->samples[1][11]['centerId']) ?></td>
    <td width="24" id="2-print-slot-0-12"><?php if(isset($this->samples[1][12]['centerId'])) print($this->samples[1][12]['centerId']) ?></td>
    <td width="27" id="2-print-slot-0-13"><?php ?></td>
    <td width="22" id="2-print-slot-0-14">&nbsp;</td>
  </tr>
  <tr>
    <td height="16" colspan="6" class="tableheader">මුළු ගෙඩි ගණන</td>
    <td id="1-print-slot-1-0"><?php if(isset($this->samples[0][0]['centerId'])) print($this->samples[0][0]['fruitCount']) ?></td>
    <td id="1-print-slot-1-1"><?php if(isset($this->samples[0][1]['centerId'])) print($this->samples[0][1]['fruitCount']) ?></td>
    <td id="1-print-slot-1-2"><?php if(isset($this->samples[0][2]['centerId'])) print($this->samples[0][2]['fruitCount']) ?></td>
    <td id="1-print-slot-1-3"><?php if(isset($this->samples[0][3]['centerId'])) print($this->samples[0][3]['fruitCount']) ?></td>
    <td id="1-print-slot-1-4"><?php if(isset($this->samples[0][4]['centerId'])) print($this->samples[0][4]['fruitCount']) ?></td>
    <td id="1-print-slot-1-5"><?php if(isset($this->samples[0][5]['centerId'])) print($this->samples[0][5]['fruitCount']) ?></td>
    <td id="1-print-slot-1-6"><?php if(isset($this->samples[0][6]['centerId'])) print($this->samples[0][6]['fruitCount']) ?></td>
    <td id="1-print-slot-1-7"><?php if(isset($this->samples[0][7]['centerId'])) print($this->samples[0][7]['fruitCount']) ?></td>
    <td id="1-print-slot-1-8"><?php if(isset($this->samples[0][8]['centerId'])) print($this->samples[0][8]['fruitCount']) ?></td>
    <td id="1-print-slot-1-9"><?php if(isset($this->samples[0][9]['centerId'])) print($this->samples[0][9]['fruitCount']) ?></td>
    <td id="1-print-slot-1-10"><?php if(isset($this->samples[0][10]['centerId'])) print($this->samples[0][10]['fruitCount']) ?></td>
    <td id="1-print-slot-1-11"><?php if(isset($this->samples[0][11]['centerId'])) print($this->samples[0][11]['fruitCount']) ?></td>
    <td id="1-print-slot-1-12"><?php if(isset($this->samples[0][12]['centerId'])) print($this->samples[0][12]['fruitCount']) ?></td>
    <td id="1-print-slot-1-13"><?php if($this->gradeArray[0]!=0) print $this->gradeStock[$this->gradeArray[0]]['fruitCount']; ?></td>
    <td id="1-print-slot-1-14">&nbsp;</td>
    
     <td id="2-print-slot-1-0"><?php if(isset($this->samples[1][0]['fruitCount'])) print($this->samples[1][0]['fruitCount']) ?></td>
    <td id="2-print-slot-1-1"><?php if(isset($this->samples[1][1]['fruitCount'])) print($this->samples[1][1]['fruitCount']) ?></td>
    <td id="2-print-slot-1-2"><?php if(isset($this->samples[1][2]['fruitCount'])) print($this->samples[1][2]['fruitCount']) ?></td>
    <td id="2-print-slot-1-3"><?php if(isset($this->samples[1][3]['fruitCount'])) print($this->samples[1][3]['fruitCount']) ?></td>
    <td id="2-print-slot-1-4"><?php if(isset($this->samples[1][4]['fruitCount'])) print($this->samples[1][4]['fruitCount']) ?></td>
    <td id="2-print-slot-1-5"><?php if(isset($this->samples[1][5]['fruitCount'])) print($this->samples[1][5]['fruitCount']) ?></td>
    <td id="2-print-slot-1-6"><?php if(isset($this->samples[1][6]['fruitCount'])) print($this->samples[1][6]['fruitCount']) ?></td>
    <td id="2-print-slot-1-7"><?php if(isset($this->samples[1][7]['fruitCount'])) print($this->samples[1][7]['fruitCount']) ?></td>
    <td id="2-print-slot-1-8"><?php if(isset($this->samples[1][8]['fruitCount'])) print($this->samples[1][8]['fruitCount']) ?></td>
    <td id="2-print-slot-1-9"><?php if(isset($this->samples[1][9]['fruitCount'])) print($this->samples[1][9]['fruitCount']) ?></td>
    <td id="2-print-slot-1-10"><?php if(isset($this->samples[1][10]['fruitCount'])) print($this->samples[1][10]['fruitCount']) ?></td>
    <td id="2-print-slot-1-11"><?php if(isset($this->samples[1][11]['fruitCount'])) print($this->samples[1][11]['fruitCount']) ?></td>
    <td id="2-print-slot-1-12"><?php if(isset($this->samples[1][12]['fruitCount'])) print($this->samples[1][12]['fruitCount']) ?></td>
    <td id="2-print-slot-1-13"><?php if($this->gradeArray[1]!=0) print $this->gradeStock[$this->gradeArray[1]]['fruitCount']; ?></td>
    <td id="2-print-slot-1-14">&nbsp;</td>
  </tr>
  <tr>
    <td width="117" rowspan="2" class=""> <p>වැරදි ශ්‍රේණිය</p></td>
    <td colspan="5" class="tableheader">කුඩා ගෙඩි ගණන</td>
    <td id="1-print-slot-2-0"><?php if(isset($this->samples[0][0]['centerId'])) print($this->samples[0][0]['smallFruit']) ?></td>
    <td id="1-print-slot-2-1"><?php if(isset($this->samples[0][1]['centerId'])) print($this->samples[0][1]['smallFruit']) ?></td>
    <td id="1-print-slot-2-2"><?php if(isset($this->samples[0][2]['centerId'])) print($this->samples[0][2]['smallFruit']) ?></td>
    <td id="1-print-slot-2-3"><?php if(isset($this->samples[0][3]['centerId'])) print($this->samples[0][3]['smallFruit']) ?></td>
    <td id="1-print-slot-2-4"><?php if(isset($this->samples[0][4]['centerId'])) print($this->samples[0][4]['smallFruit']) ?></td>
    <td id="1-print-slot-2-5"><?php if(isset($this->samples[0][5]['centerId'])) print($this->samples[0][5]['smallFruit']) ?></td>
    <td id="1-print-slot-2-6"><?php if(isset($this->samples[0][6]['centerId'])) print($this->samples[0][6]['smallFruit']) ?></td>
    <td id="1-print-slot-2-7"><?php if(isset($this->samples[0][7]['centerId'])) print($this->samples[0][7]['smallFruit']) ?></td>
    <td id="1-print-slot-2-8"><?php if(isset($this->samples[0][8]['centerId'])) print($this->samples[0][8]['smallFruit']) ?></td>
    <td id="1-print-slot-2-9"><?php if(isset($this->samples[0][9]['centerId'])) print($this->samples[0][9]['smallFruit']) ?></td>
    <td id="1-print-slot-2-10"><?php if(isset($this->samples[0][10]['centerId'])) print($this->samples[0][10]['smallFruit']) ?></td>
    <td id="1-print-slot-2-11"><?php if(isset($this->samples[0][11]['centerId'])) print($this->samples[0][11]['smallFruit']) ?></td>
    <td id="1-print-slot-2-12"><?php if(isset($this->samples[0][12]['centerId'])) print($this->samples[0][12]['smallFruit']) ?></td>
    <td id="1-print-slot-2-13"><?php if($this->gradeArray[0]!=0) print $this->gradeStock[$this->gradeArray[0]]['sumOfSmallFruit']; ?></td>
    <td  id="1-print-slot-2-14"><?php if(isset($this->percentages[0]['perOfSmallFruit']))print $this->percentages[0]['perOfSmallFruit']; ?></td>
    
    <td id="2-print-slot-2-0"><?php if(isset($this->samples[1][0]['centerId'])) print($this->samples[1][0]['smallFruit']) ?></td>
    <td id="2-print-slot-2-1"><?php if(isset($this->samples[1][1]['centerId'])) print($this->samples[1][1]['smallFruit']) ?></td>
    <td id="2-print-slot-2-2"><?php if(isset($this->samples[1][2]['centerId'])) print($this->samples[1][2]['smallFruit']) ?></td>
    <td id="2-print-slot-2-3"><?php if(isset($this->samples[1][3]['centerId'])) print($this->samples[1][3]['smallFruit']) ?></td>
    <td id="2-print-slot-2-4"><?php if(isset($this->samples[1][4]['centerId'])) print($this->samples[1][4]['smallFruit']) ?></td>
    <td id="2-print-slot-2-5"><?php if(isset($this->samples[1][5]['centerId'])) print($this->samples[1][5]['smallFruit']) ?></td>
    <td id="2-print-slot-2-6"><?php if(isset($this->samples[1][6]['centerId'])) print($this->samples[1][6]['smallFruit']) ?></td>
    <td id="2-print-slot-2-7"><?php if(isset($this->samples[1][7]['centerId'])) print($this->samples[1][7]['smallFruit']) ?></td>
    <td id="2-print-slot-2-8"><?php if(isset($this->samples[1][8]['centerId'])) print($this->samples[1][8]['smallFruit']) ?></td>
    <td id="2-print-slot-2-9"><?php if(isset($this->samples[1][9]['centerId'])) print($this->samples[1][9]['smallFruit']) ?></td>
    <td id="2-print-slot-2-10"><?php if(isset($this->samples[1][10]['centerId'])) print($this->samples[1][10]['smallFruit']) ?></td>
    <td id="2-print-slot-2-11"><?php if(isset($this->samples[1][11]['centerId'])) print($this->samples[1][11]['smallFruit']) ?></td>
    <td id="2-print-slot-2-12"><?php if(isset($this->samples[1][12]['centerId'])) print($this->samples[1][12]['smallFruit']) ?></td>
    
    <td id="2-print-slot-2-13"><?php if($this->gradeArray[1]!=0) print $this->gradeStock[$this->gradeArray[1]]['sumOfSmallFruit']; ?></td>
    <td id="2-print-slot-2-14"><?php if(isset($this->percentages[1]['perOfSmallFruit']))print $this->percentages[1]['perOfSmallFruit']; ?></td>
  </tr>
  <tr>
    <td colspan="5" class="tableheader">ලොකුගෙඩි ගණන</td>
    <td id="1-print-slot-3-0"><?php if(isset($this->samples[0][0]['centerId'])) print($this->samples[0][0]['largeFruit']) ?></td>
    <td id="1-print-slot-3-1"><?php if(isset($this->samples[0][1]['centerId'])) print($this->samples[0][1]['largeFruit']) ?></td>
    <td id="1-print-slot-3-2"><?php if(isset($this->samples[0][2]['centerId'])) print($this->samples[0][2]['largeFruit']) ?></td>
    <td id="1-print-slot-3-3"><?php if(isset($this->samples[0][3]['centerId'])) print($this->samples[0][3]['largeFruit']) ?></td>
    <td id="1-print-slot-3-4"><?php if(isset($this->samples[0][4]['centerId'])) print($this->samples[0][4]['largeFruit']) ?></td>
    <td id="1-print-slot-3-5"><?php if(isset($this->samples[0][5]['centerId'])) print($this->samples[0][5]['largeFruit']) ?></td>
    <td id="1-print-slot-3-6"><?php if(isset($this->samples[0][6]['centerId'])) print($this->samples[0][6]['largeFruit']) ?></td>
    <td id="1-print-slot-3-7"><?php if(isset($this->samples[0][7]['centerId'])) print($this->samples[0][7]['largeFruit']) ?></td>
    <td id="1-print-slot-3-8"><?php if(isset($this->samples[0][8]['centerId'])) print($this->samples[0][8]['largeFruit']) ?></td>
    <td id="1-print-slot-3-9"><?php if(isset($this->samples[0][9]['centerId'])) print($this->samples[0][9]['largeFruit']) ?></td>
    <td id="1-print-slot-3-10"><?php if(isset($this->samples[0][10]['centerId'])) print($this->samples[0][10]['largeFruit']) ?></td>
    <td id="1-print-slot-3-11"><?php if(isset($this->samples[0][11]['centerId'])) print($this->samples[0][11]['largeFruit']) ?></td>
    <td id="1-print-slot-3-12"><?php if(isset($this->samples[0][12]['centerId'])) print($this->samples[0][12]['largeFruit']) ?></td>
    <td id="1-print-slot-3-13"><?php if($this->gradeArray[0]!=0) print $this->gradeStock[$this->gradeArray[0]]['sumOfLargeFruit']; ?></td>
    <td id="1-print-slot-3-14"><?php if(isset($this->percentages[0]['perOfLargeFruit']))print $this->percentages[0]['perOfLargeFruit']; ?></td>
    
   <td id="2-print-slot-3-0"><?php if(isset($this->samples[1][0]['centerId'])) print($this->samples[1][0]['largeFruit']) ?></td>
    <td id="2-print-slot-3-1"><?php if(isset($this->samples[1][1]['centerId'])) print($this->samples[1][1]['largeFruit']) ?></td>
    <td id="2-print-slot-3-2"><?php if(isset($this->samples[1][2]['centerId'])) print($this->samples[1][2]['largeFruit']) ?></td>
    <td id="2-print-slot-3-3"><?php if(isset($this->samples[1][3]['centerId'])) print($this->samples[1][3]['largeFruit']) ?></td>
    <td id="2-print-slot-3-4"><?php if(isset($this->samples[1][4]['centerId'])) print($this->samples[1][4]['largeFruit']) ?></td>
    <td id="2-print-slot-3-5"><?php if(isset($this->samples[1][5]['centerId'])) print($this->samples[1][5]['largeFruit']) ?></td>
    <td id="2-print-slot-3-6"><?php if(isset($this->samples[1][6]['centerId'])) print($this->samples[1][6]['largeFruit']) ?></td>
    <td id="2-print-slot-3-7"><?php if(isset($this->samples[1][7]['centerId'])) print($this->samples[1][7]['largeFruit']) ?></td>
    <td id="2-print-slot-3-8"><?php if(isset($this->samples[1][8]['centerId'])) print($this->samples[1][8]['largeFruit']) ?></td>
    <td id="2-print-slot-3-9"><?php if(isset($this->samples[1][9]['centerId'])) print($this->samples[1][9]['largeFruit']) ?></td>
    <td id="2-print-slot-3-10"><?php if(isset($this->samples[1][10]['centerId'])) print($this->samples[1][10]['largeFruit']) ?></td>
    <td id="2-print-slot-3-11"><?php if(isset($this->samples[1][11]['centerId'])) print($this->samples[1][11]['largeFruit']) ?></td>
    <td id="2-print-slot-3-12"><?php if(isset($this->samples[1][12]['centerId'])) print($this->samples[1][12]['largeFruit']) ?></td>
    <td id="2-print-slot-3-13"><?php if($this->gradeArray[1]!=0) print $this->gradeStock[$this->gradeArray[1]]['sumOfLargeFruit']; ?></td>
    <td id="2-print-slot-3-14"><?php if(isset($this->percentages[1]['perOfLargeFruit']))print $this->percentages[1]['perOfLargeFruit']; ?></td>
  </tr>
  <tr>
    <td rowspan="5" class=""><p>ප්‍රධාන දෝෂ<br />
      (ගෙඩි ගණන)</p></td>
    <td colspan="5" class="tableheader">ඉල් මැසි හානි</td>
   <td id="1-print-slot-4-0"><?php if(isset($this->samples[0][0]['flyAttacked'])) print($this->samples[0][0]['flyAttacked']) ?></td>
    <td id="1-print-slot-4-1"><?php if(isset($this->samples[0][1]['flyAttacked'])) print($this->samples[0][1]['flyAttacked']) ?></td>
    <td id="1-print-slot-4-2"><?php if(isset($this->samples[0][2]['flyAttacked'])) print($this->samples[0][2]['flyAttacked']) ?></td>
    <td id="1-print-slot-4-3"><?php if(isset($this->samples[0][3]['flyAttacked'])) print($this->samples[0][3]['flyAttacked']) ?></td>
    <td id="1-print-slot-4-4"><?php if(isset($this->samples[0][4]['flyAttacked'])) print($this->samples[0][4]['flyAttacked']) ?></td>
    <td id="1-print-slot-4-5"><?php if(isset($this->samples[0][5]['flyAttacked'])) print($this->samples[0][5]['flyAttacked']) ?></td>
    <td id="1-print-slot-4-6"><?php if(isset($this->samples[0][6]['flyAttacked'])) print($this->samples[0][6]['flyAttacked']) ?></td>
    <td id="1-print-slot-4-7"><?php if(isset($this->samples[0][7]['flyAttacked'])) print($this->samples[0][7]['flyAttacked']) ?></td>
    <td id="1-print-slot-4-8"><?php if(isset($this->samples[0][8]['flyAttacked'])) print($this->samples[0][8]['flyAttacked']) ?></td>
    <td id="1-print-slot-4-9"><?php if(isset($this->samples[0][9]['flyAttacked'])) print($this->samples[0][9]['flyAttacked']) ?></td>
    <td id="1-print-slot-4-10"><?php if(isset($this->samples[0][10]['flyAttacked'])) print($this->samples[0][10]['flyAttacked']) ?></td>
    <td id="1-print-slot-4-11"><?php if(isset($this->samples[0][11]['flyAttacked'])) print($this->samples[0][11]['flyAttacked']) ?></td>
    <td id="1-print-slot-4-12"><?php if(isset($this->samples[0][12]['flyAttacked'])) print($this->samples[0][12]['flyAttacked']) ?></td>
    <td id="1-print-slot-4-13"><?php if($this->gradeArray[0]!=0) print $this->gradeStock[$this->gradeArray[0]]['sumOfFlyAttacked']; ?></td>
    <td id="1-print-slot-4-14"><?php if(isset($this->percentages[0]['perOfFlyAttacked']))print $this->percentages[0]['perOfFlyAttacked']; ?></td>
    
   <td id="2-print-slot-4-0"><?php if(isset($this->samples[1][0]['flyAttacked'])) print($this->samples[1][0]['flyAttacked']) ?></td>
    <td id="2-print-slot-4-1"><?php if(isset($this->samples[1][1]['flyAttacked'])) print($this->samples[1][1]['flyAttacked']) ?></td>
    <td id="2-print-slot-4-2"><?php if(isset($this->samples[1][2]['flyAttacked'])) print($this->samples[1][2]['flyAttacked']) ?></td>
    <td id="2-print-slot-4-3"><?php if(isset($this->samples[1][3]['flyAttacked'])) print($this->samples[1][3]['flyAttacked']) ?></td>
    <td id="2-print-slot-4-4"><?php if(isset($this->samples[1][4]['flyAttacked'])) print($this->samples[1][4]['flyAttacked']) ?></td>
    <td id="2-print-slot-4-5"><?php if(isset($this->samples[1][5]['flyAttacked'])) print($this->samples[1][5]['flyAttacked']) ?></td>
    <td id="2-print-slot-4-6"><?php if(isset($this->samples[1][6]['flyAttacked'])) print($this->samples[1][6]['flyAttacked']) ?></td>
    <td id="2-print-slot-4-7"><?php if(isset($this->samples[1][7]['flyAttacked'])) print($this->samples[1][7]['flyAttacked']) ?></td>
    <td id="2-print-slot-4-8"><?php if(isset($this->samples[1][8]['flyAttacked'])) print($this->samples[1][8]['flyAttacked']) ?></td>
    <td id="2-print-slot-4-9"><?php if(isset($this->samples[1][9]['flyAttacked'])) print($this->samples[1][9]['flyAttacked']) ?></td>
    <td id="2-print-slot-4-10"><?php if(isset($this->samples[1][10]['flyAttacked'])) print($this->samples[1][10]['flyAttacked']) ?></td>
    <td id="2-print-slot-4-11"><?php if(isset($this->samples[1][11]['flyAttacked'])) print($this->samples[1][11]['flyAttacked']) ?></td>
    <td id="2-print-slot-4-12"><?php if(isset($this->samples[1][12]['flyAttacked'])) print($this->samples[1][12]['flyAttacked']) ?></td>
    <td id="2-print-slot-4-13"><?php if($this->gradeArray[1]!=0) print $this->gradeStock[$this->gradeArray[1]]['sumOfFlyAttacked']; ?></td>
     <td id="2-print-slot-4-14"><?php if(isset($this->percentages[1]['perOfFlyAttacked']))print $this->percentages[1]['perOfFlyAttacked']; ?></td>
  </tr>
  <tr>
    <td colspan="5" class="tableheader"> පොතු ගැලවුණු </td>
    <td id="1-print-slot-5-0"><?php if(isset($this->samples[0][0]['peeledOff'])) print($this->samples[0][0]['peeledOff']) ?></td>
    <td id="1-print-slot-5-1"><?php if(isset($this->samples[0][1]['peeledOff'])) print($this->samples[0][1]['peeledOff']) ?></td>
    <td id="1-print-slot-5-2"><?php if(isset($this->samples[0][2]['peeledOff'])) print($this->samples[0][2]['peeledOff']) ?></td>
    <td id="1-print-slot-5-3"><?php if(isset($this->samples[0][3]['peeledOff'])) print($this->samples[0][3]['peeledOff']) ?></td>
    <td id="1-print-slot-5-4"><?php if(isset($this->samples[0][4]['peeledOff'])) print($this->samples[0][4]['peeledOff']) ?></td>
    <td id="1-print-slot-5-5"><?php if(isset($this->samples[0][5]['peeledOff'])) print($this->samples[0][5]['peeledOff']) ?></td>
    <td id="1-print-slot-5-6"><?php if(isset($this->samples[0][6]['peeledOff'])) print($this->samples[0][6]['peeledOff']) ?></td>
    <td id="1-print-slot-5-7"><?php if(isset($this->samples[0][7]['peeledOff'])) print($this->samples[0][7]['peeledOff']) ?></td>
    <td id="1-print-slot-5-8"><?php if(isset($this->samples[0][8]['peeledOff'])) print($this->samples[0][8]['peeledOff']) ?></td>
    <td id="1-print-slot-5-9"><?php if(isset($this->samples[0][9]['peeledOff'])) print($this->samples[0][9]['peeledOff']) ?></td>
    <td id="1-print-slot-5-10"><?php if(isset($this->samples[0][10]['peeledOff'])) print($this->samples[0][10]['peeledOff']) ?></td>
    <td id="1-print-slot-5-11"><?php if(isset($this->samples[0][11]['peeledOff'])) print($this->samples[0][11]['peeledOff']) ?></td>
    <td id="1-print-slot-5-12"><?php if(isset($this->samples[0][12]['peeledOff'])) print($this->samples[0][12]['peeledOff']) ?></td>
    <td id="1-print-slot-5-13"><?php if($this->gradeArray[0]!=0) print $this->gradeStock[$this->gradeArray[0]]['sumOfPeeledOff']; ?></td>
    <td id="1-print-slot-5-14"><?php if(isset($this->percentages[0]['perOfPeeledOff']))print  $this->percentages[0]['perOfPeeledOff']; ?></td>
    
   <td id="2-print-slot-5-0"><?php if(isset($this->samples[1][0]['peeledOff'])) print($this->samples[1][0]['peeledOff']) ?></td>
    <td id="2-print-slot-5-1"><?php if(isset($this->samples[1][1]['peeledOff'])) print($this->samples[1][1]['peeledOff']) ?></td>
    <td id="2-print-slot-5-2"><?php if(isset($this->samples[1][2]['peeledOff'])) print($this->samples[1][2]['peeledOff']) ?></td>
    <td id="2-print-slot-5-3"><?php if(isset($this->samples[1][3]['peeledOff'])) print($this->samples[1][3]['peeledOff']) ?></td>
    <td id="2-print-slot-5-4"><?php if(isset($this->samples[1][4]['peeledOff'])) print($this->samples[1][4]['peeledOff']) ?></td>
    <td id="2-print-slot-5-5"><?php if(isset($this->samples[1][5]['peeledOff'])) print($this->samples[1][5]['peeledOff']) ?></td>
    <td id="2-print-slot-5-6"><?php if(isset($this->samples[1][6]['peeledOff'])) print($this->samples[1][6]['peeledOff']) ?></td>
    <td id="2-print-slot-5-7"><?php if(isset($this->samples[1][7]['peeledOff'])) print($this->samples[1][7]['peeledOff']) ?></td>
    <td id="2-print-slot-5-8"><?php if(isset($this->samples[1][8]['peeledOff'])) print($this->samples[1][8]['peeledOff']) ?></td>
    <td id="2-print-slot-5-9"><?php if(isset($this->samples[1][9]['peeledOff'])) print($this->samples[1][9]['peeledOff']) ?></td>
    <td id="2-print-slot-5-10"><?php if(isset($this->samples[1][10]['peeledOff'])) print($this->samples[1][10]['peeledOff']) ?></td>
    <td id="2-print-slot-5-11"><?php if(isset($this->samples[1][11]['peeledOff'])) print($this->samples[1][11]['peeledOff']) ?></td>
    <td id="2-print-slot-5-12"><?php if(isset($this->samples[1][12]['peeledOff'])) print($this->samples[1][12]['peeledOff']) ?></td>
    <td id="2-print-slot-5-13"><?php if($this->gradeArray[1]!=0) print $this->gradeStock[$this->gradeArray[1]]['sumOfPeeledOff']; ?></td>
    <td id="2-print-slot-5-14"><?php if(isset($this->percentages[1]['perOfPeeledOff']))print $this->percentages[1]['perOfPeeledOff']; ?></td>
  </tr>
  <tr>
    <td colspan="5" class="tableheader"> පණු කුහර හානි </td>
     <td id="1-print-slot-6-0"><?php if(isset($this->samples[0][0]['peeledOff'])) print($this->samples[0][0]['boreAttacked']) ?></td>
    <td id="1-print-slot-6-1"><?php if(isset($this->samples[0][1]['boreAttacked'])) print($this->samples[0][1]['boreAttacked']) ?></td>
    <td id="1-print-slot-6-2"><?php if(isset($this->samples[0][2]['boreAttacked'])) print($this->samples[0][2]['boreAttacked']) ?></td>
    <td id="1-print-slot-6-3"><?php if(isset($this->samples[0][3]['boreAttacked'])) print($this->samples[0][3]['boreAttacked']) ?></td>
    <td id="1-print-slot-6-4"><?php if(isset($this->samples[0][4]['boreAttacked'])) print($this->samples[0][4]['boreAttacked']) ?></td>
    <td id="1-print-slot-6-5"><?php if(isset($this->samples[0][5]['boreAttacked'])) print($this->samples[0][5]['boreAttacked']) ?></td>
    <td id="1-print-slot-6-6"><?php if(isset($this->samples[0][6]['boreAttacked'])) print($this->samples[0][6]['boreAttacked']) ?></td>
    <td id="1-print-slot-6-7"><?php if(isset($this->samples[0][7]['boreAttacked'])) print($this->samples[0][7]['boreAttacked']) ?></td>
    <td id="1-print-slot-6-8"><?php if(isset($this->samples[0][8]['boreAttacked'])) print($this->samples[0][8]['boreAttacked']) ?></td>
    <td id="1-print-slot-6-9"><?php if(isset($this->samples[0][9]['boreAttacked'])) print($this->samples[0][9]['boreAttacked']) ?></td>
    <td id="1-print-slot-6-10"><?php if(isset($this->samples[0][10]['boreAttacked'])) print($this->samples[0][10]['boreAttacked']) ?></td>
    <td id="1-print-slot-6-11"><?php if(isset($this->samples[0][11]['boreAttacked'])) print($this->samples[0][11]['boreAttacked']) ?></td>
    <td id="1-print-slot-6-12"><?php if(isset($this->samples[0][12]['boreAttacked'])) print($this->samples[0][12]['boreAttacked']) ?></td>
    <td id="1-print-slot-6-13"><?php if($this->gradeArray[0]!=0) print $this->gradeStock[$this->gradeArray[0]]['sumOfBoreAttacked']; ?></td>
    <td id="1-print-slot-6-14"><?php if(isset($this->percentages[0]['perOfBoreAttacked']))print $this->percentages[0]['perOfBoreAttacked']; ?></td>
    
     <td id="2-print-slot-6-0"><?php if(isset($this->samples[1][0]['peeledOff'])) print($this->samples[1][0]['boreAttacked']) ?></td>
    <td id="2-print-slot-6-1"><?php if(isset($this->samples[1][1]['boreAttacked'])) print($this->samples[1][1]['boreAttacked']) ?></td>
    <td id="2-print-slot-6-2"><?php if(isset($this->samples[1][2]['boreAttacked'])) print($this->samples[1][2]['boreAttacked']) ?></td>
    <td id="2-print-slot-6-3"><?php if(isset($this->samples[1][3]['boreAttacked'])) print($this->samples[1][3]['boreAttacked']) ?></td>
    <td id="2-print-slot-6-4"><?php if(isset($this->samples[1][4]['boreAttacked'])) print($this->samples[1][4]['boreAttacked']) ?></td>
    <td id="2-print-slot-6-5"><?php if(isset($this->samples[1][5]['boreAttacked'])) print($this->samples[1][5]['boreAttacked']) ?></td>
    <td id="2-print-slot-6-6"><?php if(isset($this->samples[1][6]['boreAttacked'])) print($this->samples[1][6]['boreAttacked']) ?></td>
    <td id="2-print-slot-6-7"><?php if(isset($this->samples[1][7]['boreAttacked'])) print($this->samples[1][7]['boreAttacked']) ?></td>
    <td id="2-print-slot-6-8"><?php if(isset($this->samples[1][8]['boreAttacked'])) print($this->samples[1][8]['boreAttacked']) ?></td>
    <td id="2-print-slot-6-9"><?php if(isset($this->samples[1][9]['boreAttacked'])) print($this->samples[1][9]['boreAttacked']) ?></td>
    <td id="2-print-slot-6-10"><?php if(isset($this->samples[1][10]['boreAttacked'])) print($this->samples[1][10]['boreAttacked']) ?></td>
    <td id="2-print-slot-6-11"><?php if(isset($this->samples[1][11]['boreAttacked'])) print($this->samples[1][11]['boreAttacked']) ?></td>
    <td id="2-print-slot-6-12"><?php if(isset($this->samples[1][12]['boreAttacked'])) print($this->samples[1][12]['boreAttacked']) ?></td>
    <td id="2-print-slot-6-13"><?php if($this->gradeArray[1]!=0) print $this->gradeStock[$this->gradeArray[1]]['sumOfBoreAttacked']; ?></td>
    <td id="2-print-slot-6-14"><?php if(isset($this->percentages[1]['perOfBoreAttacked']))print $this->percentages[1]['perOfBoreAttacked']; ?></td>
  </tr>
  <tr>
    <td colspan="5" class="tableheader"> වැලි සහිත </td>
    <td id="1-print-slot-7-0"><?php if(isset($this->samples[0][0]['sandEmbedded'])) print($this->samples[0][0]['sandEmbedded']) ?></td>
    <td id="1-print-slot-7-1"><?php if(isset($this->samples[0][1]['sandEmbedded'])) print($this->samples[0][1]['sandEmbedded']) ?></td>
    <td id="1-print-slot-7-2"><?php if(isset($this->samples[0][2]['sandEmbedded'])) print($this->samples[0][2]['sandEmbedded']) ?></td>
    <td id="1-print-slot-7-3"><?php if(isset($this->samples[0][3]['sandEmbedded'])) print($this->samples[0][3]['sandEmbedded']) ?></td>
    <td id="1-print-slot-7-4"><?php if(isset($this->samples[0][4]['sandEmbedded'])) print($this->samples[0][4]['sandEmbedded']) ?></td>
    <td id="1-print-slot-7-5"><?php if(isset($this->samples[0][5]['sandEmbedded'])) print($this->samples[0][5]['sandEmbedded']) ?></td>
    <td id="1-print-slot-7-6"><?php if(isset($this->samples[0][6]['sandEmbedded'])) print($this->samples[0][6]['sandEmbedded']) ?></td>
    <td id="1-print-slot-7-7"><?php if(isset($this->samples[0][7]['sandEmbedded'])) print($this->samples[0][7]['sandEmbedded']) ?></td>
    <td id="1-print-slot-7-8"><?php if(isset($this->samples[0][8]['sandEmbedded'])) print($this->samples[0][8]['sandEmbedded']) ?></td>
    <td id="1-print-slot-7-9"><?php if(isset($this->samples[0][9]['sandEmbedded'])) print($this->samples[0][9]['sandEmbedded']) ?></td>
    <td id="1-print-slot-7-10"><?php if(isset($this->samples[0][10]['sandEmbedded'])) print($this->samples[0][10]['sandEmbedded']) ?></td>
    <td id="1-print-slot-7-11"><?php if(isset($this->samples[0][11]['sandEmbedded'])) print($this->samples[0][11]['sandEmbedded']) ?></td>
    <td id="1-print-slot-7-12"><?php if(isset($this->samples[0][12]['sandEmbedded'])) print($this->samples[0][12]['sandEmbedded']) ?></td>
    <td id="1-print-slot-7-13"><?php if($this->gradeArray[0]!=0) print $this->gradeStock[$this->gradeArray[0]]['sumOfSandEmbedded']; ?></td>
    <td id="1-print-slot-7-14"><?php if(isset($this->percentages[0]['perOfSandEmbedded']))print $this->percentages[0]['perOfSandEmbedded']; ?></td>
    
   <td id="2-print-slot-7-0"><?php if(isset($this->samples[1][0]['peeledOff'])) print($this->samples[1][0]['sandEmbedded']) ?></td>
    <td id="2-print-slot-7-1"><?php if(isset($this->samples[1][1]['sandEmbedded'])) print($this->samples[1][1]['sandEmbedded']) ?></td>
    <td id="2-print-slot-7-2"><?php if(isset($this->samples[1][2]['sandEmbedded'])) print($this->samples[1][2]['sandEmbedded']) ?></td>
    <td id="2-print-slot-7-3"><?php if(isset($this->samples[1][3]['sandEmbedded'])) print($this->samples[1][3]['sandEmbedded']) ?></td>
    <td id="2-print-slot-7-4"><?php if(isset($this->samples[1][4]['sandEmbedded'])) print($this->samples[1][4]['sandEmbedded']) ?></td>
    <td id="2-print-slot-7-5"><?php if(isset($this->samples[1][5]['sandEmbedded'])) print($this->samples[1][5]['sandEmbedded']) ?></td>
    <td id="2-print-slot-7-6"><?php if(isset($this->samples[1][6]['sandEmbedded'])) print($this->samples[1][6]['sandEmbedded']) ?></td>
    <td id="2-print-slot-7-7"><?php if(isset($this->samples[1][7]['sandEmbedded'])) print($this->samples[1][7]['sandEmbedded']) ?></td>
    <td id="2-print-slot-7-8"><?php if(isset($this->samples[1][8]['sandEmbedded'])) print($this->samples[1][8]['sandEmbedded']) ?></td>
    <td id="2-print-slot-7-9"><?php if(isset($this->samples[1][9]['sandEmbedded'])) print($this->samples[1][9]['sandEmbedded']) ?></td>
    <td id="2-print-slot-7-10"><?php if(isset($this->samples[1][10]['sandEmbedded'])) print($this->samples[1][10]['sandEmbedded']) ?></td>
    <td id="2-print-slot-7-11"><?php if(isset($this->samples[1][11]['sandEmbedded'])) print($this->samples[1][11]['sandEmbedded']) ?></td>
    <td id="2-print-slot-7-12"><?php if(isset($this->samples[1][12]['sandEmbedded'])) print($this->samples[1][12]['sandEmbedded']) ?></td>
    <td id="2-print-slot-7-13"><?php if($this->gradeArray[1]!=0) print $this->gradeStock[$this->gradeArray[1]]['sumOfSandEmbedded']; ?></td>
    <td id="2-print-slot-7-14"><?php if(isset($this->percentages[1]['perOfSandEmbedded']))print $this->percentages[1]['perOfSandEmbedded']; ?></td>
  </tr>
  <tr>
    <td colspan="5" class="tableheader"> හැකිළුණු ගෙඩි</td>
    <td id="1-print-slot-8-0"><?php if(isset($this->samples[0][0]['shrivelled'])) print($this->samples[0][0]['shrivelled']) ?></td>
    <td id="1-print-slot-8-1"><?php if(isset($this->samples[0][1]['shrivelled'])) print($this->samples[0][1]['shrivelled']) ?></td>
    <td id="1-print-slot-8-2"><?php if(isset($this->samples[0][2]['shrivelled'])) print($this->samples[0][2]['shrivelled']) ?></td>
    <td id="1-print-slot-8-3"><?php if(isset($this->samples[0][3]['shrivelled'])) print($this->samples[0][3]['shrivelled']) ?></td>
    <td id="1-print-slot-8-4"><?php if(isset($this->samples[0][4]['shrivelled'])) print($this->samples[0][4]['shrivelled']) ?></td>
    <td id="1-print-slot-8-5"><?php if(isset($this->samples[0][5]['shrivelled'])) print($this->samples[0][5]['shrivelled']) ?></td>
    <td id="1-print-slot-8-6"><?php if(isset($this->samples[0][6]['shrivelled'])) print($this->samples[0][6]['shrivelled']) ?></td>
    <td id="1-print-slot-8-7"><?php if(isset($this->samples[0][7]['shrivelled'])) print($this->samples[0][7]['shrivelled']) ?></td>
    <td id="1-print-slot-8-8"><?php if(isset($this->samples[0][8]['shrivelled'])) print($this->samples[0][8]['shrivelled']) ?></td>
    <td id="1-print-slot-8-9"><?php if(isset($this->samples[0][9]['shrivelled'])) print($this->samples[0][9]['shrivelled']) ?></td>
    <td id="1-print-slot-8-10"><?php if(isset($this->samples[0][10]['shrivelled'])) print($this->samples[0][10]['shrivelled']) ?></td>
    <td id="1-print-slot-8-11"><?php if(isset($this->samples[0][11]['shrivelled'])) print($this->samples[0][11]['shrivelled']) ?></td>
    <td id="1-print-slot-8-12"><?php if(isset($this->samples[0][12]['shrivelled'])) print($this->samples[0][12]['shrivelled']) ?></td>
    <td id="1-print-slot-8-13"><?php if($this->gradeArray[0]!=0) print $this->gradeStock[$this->gradeArray[0]]['sumOfShrivelled']; ?></td>
    <td id="1-print-slot-8-14"><?php if(isset($this->percentages[0]['perOfShrivelled']))print $this->percentages[0]['perOfShrivelled']; ?></td>
    
  <td id="2-print-slot-8-0"><?php if(isset($this->samples[1][0]['shrivelled'])) print($this->samples[1][0]['shrivelled']) ?></td>
    <td id="2-print-slot-8-1"><?php if(isset($this->samples[1][1]['shrivelled'])) print($this->samples[1][1]['shrivelled']) ?></td>
    <td id="2-print-slot-8-2"><?php if(isset($this->samples[1][2]['shrivelled'])) print($this->samples[1][2]['shrivelled']) ?></td>
    <td id="2-print-slot-8-3"><?php if(isset($this->samples[1][3]['shrivelled'])) print($this->samples[1][3]['shrivelled']) ?></td>
    <td id="2-print-slot-8-4"><?php if(isset($this->samples[1][4]['shrivelled'])) print($this->samples[1][4]['shrivelled']) ?></td>
    <td id="2-print-slot-8-5"><?php if(isset($this->samples[1][5]['shrivelled'])) print($this->samples[1][5]['shrivelled']) ?></td>
    <td id="2-print-slot-8-6"><?php if(isset($this->samples[1][6]['shrivelled'])) print($this->samples[1][6]['shrivelled']) ?></td>
    <td id="2-print-slot-8-7"><?php if(isset($this->samples[1][7]['shrivelled'])) print($this->samples[1][7]['shrivelled']) ?></td>
    <td id="2-print-slot-8-8"><?php if(isset($this->samples[1][8]['shrivelled'])) print($this->samples[1][8]['shrivelled']) ?></td>
    <td id="2-print-slot-8-9"><?php if(isset($this->samples[1][9]['shrivelled'])) print($this->samples[1][9]['shrivelled']) ?></td>
    <td id="2-print-slot-8-10"><?php if(isset($this->samples[1][10]['shrivelled'])) print($this->samples[1][10]['shrivelled']) ?></td>
    <td id="2-print-slot-8-11"><?php if(isset($this->samples[1][11]['shrivelled'])) print($this->samples[1][11]['shrivelled']) ?></td>
    <td id="2-print-slot-8-12"><?php if(isset($this->samples[1][12]['shrivelled'])) print($this->samples[1][12]['shrivelled']) ?></td>
    <td id="2-print-slot-8-13"><?php if($this->gradeArray[1]!=0) print $this->gradeStock[$this->gradeArray[1]]['sumOfShrivelled']; ?></td>
    <td id="2-print-slot-8-14"><?php if(isset($this->percentages[1]['perOfShrivelled']))print $this->percentages[1]['perOfShrivelled']; ?></td>
  </tr>
  <tr>
    <td rowspan="6" class="">ප්‍රධාන නොවන <br />දෝෂ<br />(ගෙඩි ගණන)</td>
    <td colspan="5" class="tableheader"> හැඩය වෙනස් </td>
    <td id="1-print-slot-9-0"><?php if(isset($this->samples[0][0]['deformed'])) print($this->samples[0][0]['deformed']) ?></td>
    <td id="1-print-slot-9-1"><?php if(isset($this->samples[0][1]['deformed'])) print($this->samples[0][1]['deformed']) ?></td>
    <td id="1-print-slot-9-2"><?php if(isset($this->samples[0][2]['deformed'])) print($this->samples[0][2]['deformed']) ?></td>
    <td id="1-print-slot-9-3"><?php if(isset($this->samples[0][3]['deformed'])) print($this->samples[0][3]['deformed']) ?></td>
    <td id="1-print-slot-9-4"><?php if(isset($this->samples[0][4]['deformed'])) print($this->samples[0][4]['deformed']) ?></td>
    <td id="1-print-slot-9-5"><?php if(isset($this->samples[0][5]['deformed'])) print($this->samples[0][5]['deformed']) ?></td>
    <td id="1-print-slot-9-6"><?php if(isset($this->samples[0][6]['deformed'])) print($this->samples[0][6]['deformed']) ?></td>
    <td id="1-print-slot-9-7"><?php if(isset($this->samples[0][7]['deformed'])) print($this->samples[0][7]['deformed']) ?></td>
    <td id="1-print-slot-9-8"><?php if(isset($this->samples[0][8]['deformed'])) print($this->samples[0][8]['deformed']) ?></td>
    <td id="1-print-slot-9-9"><?php if(isset($this->samples[0][9]['deformed'])) print($this->samples[0][9]['deformed']) ?></td>
    <td id="1-print-slot-9-10"><?php if(isset($this->samples[0][10]['deformed'])) print($this->samples[0][10]['deformed']) ?></td>
    <td id="1-print-slot-9-11"><?php if(isset($this->samples[0][11]['deformed'])) print($this->samples[0][11]['deformed']) ?></td>
    <td id="1-print-slot-9-12"><?php if(isset($this->samples[0][12]['deformed'])) print($this->samples[0][12]['deformed']) ?></td>
    
    <td id="1-print-slot-9-13"><?php if($this->gradeArray[0]!=0) print $this->gradeStock[$this->gradeArray[0]]['sumOfDeformed']; ?></td>
     <td id="1-print-slot-9-14"><?php if(isset($this->percentages[0]['perOfDeformed']))print $this->percentages[0]['perOfDeformed']; ?></td>
     
    <td id="2-print-slot-9-0"><?php if(isset($this->samples[1][0]['deformed'])) print($this->samples[1][0]['deformed']) ?></td>
    <td id="2-print-slot-9-1"><?php if(isset($this->samples[1][1]['deformed'])) print($this->samples[1][1]['deformed']) ?></td>
    <td id="2-print-slot-9-2"><?php if(isset($this->samples[1][2]['deformed'])) print($this->samples[1][2]['deformed']) ?></td>
    <td id="2-print-slot-9-3"><?php if(isset($this->samples[1][3]['deformed'])) print($this->samples[1][3]['deformed']) ?></td>
    <td id="2-print-slot-9-4"><?php if(isset($this->samples[1][4]['deformed'])) print($this->samples[1][4]['deformed']) ?></td>
    <td id="2-print-slot-9-5"><?php if(isset($this->samples[1][5]['deformed'])) print($this->samples[1][5]['deformed']) ?></td>
    <td id="2-print-slot-9-6"><?php if(isset($this->samples[1][6]['deformed'])) print($this->samples[1][6]['deformed']) ?></td>
    <td id="2-print-slot-9-7"><?php if(isset($this->samples[1][7]['deformed'])) print($this->samples[1][7]['deformed']) ?></td>
    <td id="2-print-slot-9-8"><?php if(isset($this->samples[1][8]['deformed'])) print($this->samples[1][8]['deformed']) ?></td>
    <td id="2-print-slot-9-9"><?php if(isset($this->samples[1][9]['deformed'])) print($this->samples[1][9]['deformed']) ?></td>
    <td id="2-print-slot-9-10"><?php if(isset($this->samples[1][10]['deformed'])) print($this->samples[1][10]['deformed']) ?></td>
    <td id="2-print-slot-9-11"><?php if(isset($this->samples[1][11]['deformed'])) print($this->samples[1][11]['deformed']) ?></td>
    <td id="2-print-slot-9-12"><?php if(isset($this->samples[1][12]['deformed'])) print($this->samples[1][12]['deformed']) ?></td>
    
    <td id="2-print-slot-9-13"><?php if($this->gradeArray[1]!=0) print $this->gradeStock[$this->gradeArray[1]]['sumOfDeformed']; ?></td>
    <td id="2-print-slot-9-14"><?php if(isset($this->percentages[1]['perOfDeformed']))print $this->percentages[1]['perOfDeformed']; ?></td>
  </tr>
  <tr>
    <td colspan="5" class="tableheader"> වෛරස් ආසාදිත</td>
    <td id="1-print-slot-10-0"><?php if(isset($this->samples[0][0]['virusAttacked'])) print($this->samples[0][0]['virusAttacked']) ?></td>
    <td id="1-print-slot-10-1"><?php if(isset($this->samples[0][1]['virusAttacked'])) print($this->samples[0][1]['virusAttacked']) ?></td>
    <td id="1-print-slot-10-2"><?php if(isset($this->samples[0][2]['virusAttacked'])) print($this->samples[0][2]['virusAttacked']) ?></td>
    <td id="1-print-slot-10-3"><?php if(isset($this->samples[0][3]['virusAttacked'])) print($this->samples[0][3]['virusAttacked']) ?></td>
    <td id="1-print-slot-10-4"><?php if(isset($this->samples[0][4]['virusAttacked'])) print($this->samples[0][4]['virusAttacked']) ?></td>
    <td id="1-print-slot-10-5"><?php if(isset($this->samples[0][5]['virusAttacked'])) print($this->samples[0][5]['virusAttacked']) ?></td>
    <td id="1-print-slot-10-6"><?php if(isset($this->samples[0][6]['virusAttacked'])) print($this->samples[0][6]['virusAttacked']) ?></td>
    <td id="1-print-slot-10-7"><?php if(isset($this->samples[0][7]['virusAttacked'])) print($this->samples[0][7]['virusAttacked']) ?></td>
    <td id="1-print-slot-10-8"><?php if(isset($this->samples[0][8]['virusAttacked'])) print($this->samples[0][8]['virusAttacked']) ?></td>
    <td id="1-print-slot-10-9"><?php if(isset($this->samples[0][9]['virusAttacked'])) print($this->samples[0][9]['virusAttacked']) ?></td>
    <td id="1-print-slot-10-10"><?php if(isset($this->samples[0][10]['virusAttacked'])) print($this->samples[0][10]['virusAttacked']) ?></td>
    <td id="1-print-slot-10-11"><?php if(isset($this->samples[0][11]['virusAttacked'])) print($this->samples[0][11]['virusAttacked']) ?></td>
    <td id="1-print-slot-10-12"><?php if(isset($this->samples[0][12]['virusAttacked'])) print($this->samples[0][12]['virusAttacked']) ?></td>
    <td id="1-print-slot-10-13"><?php if($this->gradeArray[0]!=0) print $this->gradeStock[$this->gradeArray[0]]['sumOfVirusAttacked']; ?></td>
    <td id="1-print-slot-10-14"><?php if(isset($this->percentages[0]['perOfVirusAttacked']))print $this->percentages[0]['perOfVirusAttacked']; ?></td>
    
    <td id="2-print-slot-10-0"><?php if(isset($this->samples[1][0]['virusAttacked'])) print($this->samples[1][0]['virusAttacked']) ?></td>
    <td id="2-print-slot-10-1"><?php if(isset($this->samples[1][1]['virusAttacked'])) print($this->samples[1][1]['virusAttacked']) ?></td>
    <td id="2-print-slot-10-2"><?php if(isset($this->samples[1][2]['virusAttacked'])) print($this->samples[1][2]['virusAttacked']) ?></td>
    <td id="2-print-slot-10-3"><?php if(isset($this->samples[1][3]['virusAttacked'])) print($this->samples[1][3]['virusAttacked']) ?></td>
    <td id="2-print-slot-10-4"><?php if(isset($this->samples[1][4]['virusAttacked'])) print($this->samples[1][4]['virusAttacked']) ?></td>
    <td id="2-print-slot-10-5"><?php if(isset($this->samples[1][5]['virusAttacked'])) print($this->samples[1][5]['virusAttacked']) ?></td>
    <td id="2-print-slot-10-6"><?php if(isset($this->samples[1][6]['virusAttacked'])) print($this->samples[1][6]['virusAttacked']) ?></td>
    <td id="2-print-slot-10-7"><?php if(isset($this->samples[1][7]['virusAttacked'])) print($this->samples[1][7]['virusAttacked']) ?></td>
    <td id="2-print-slot-10-8"><?php if(isset($this->samples[1][8]['virusAttacked'])) print($this->samples[1][8]['virusAttacked']) ?></td>
    <td id="2-print-slot-10-9"><?php if(isset($this->samples[1][9]['virusAttacked'])) print($this->samples[1][9]['virusAttacked']) ?></td>
    <td id="2-print-slot-10-10"><?php if(isset($this->samples[1][10]['virusAttacked'])) print($this->samples[1][10]['virusAttacked']) ?></td>
    <td id="2-print-slot-10-11"><?php if(isset($this->samples[1][11]['virusAttacked'])) print($this->samples[1][11]['virusAttacked']) ?></td>
    <td id="2-print-slot-10-12"><?php if(isset($this->samples[1][12]['virusAttacked'])) print($this->samples[1][12]['virusAttacked']) ?></td>
    <td id="2-print-slot-10-13"><?php if($this->gradeArray[1]!=0) print $this->gradeStock[$this->gradeArray[1]]['sumOfVirusAttacked']; ?></td>
    <td id="2-print-slot-10-14"><?php if(isset($this->percentages[1]['perOfVirusAttacked']))print $this->percentages[1]['perOfVirusAttacked']; ?></td>
  </tr>
  <tr>
    <td colspan="5" class="tableheader"> යාන්ත්‍රික හානි </td>
    <td id="1-print-slot-11-0"><?php if(isset($this->samples[0][0]['mechanicalDamaged'])) print($this->samples[0][0]['mechanicalDamaged']) ?></td>
    <td id="1-print-slot-11-1"><?php if(isset($this->samples[0][1]['mechanicalDamaged'])) print($this->samples[0][1]['mechanicalDamaged']) ?></td>
    <td id="1-print-slot-11-2"><?php if(isset($this->samples[0][2]['mechanicalDamaged'])) print($this->samples[0][2]['mechanicalDamaged']) ?></td>
    <td id="1-print-slot-11-3"><?php if(isset($this->samples[0][3]['mechanicalDamaged'])) print($this->samples[0][3]['mechanicalDamaged']) ?></td>
    <td id="1-print-slot-11-4"><?php if(isset($this->samples[0][4]['mechanicalDamaged'])) print($this->samples[0][4]['mechanicalDamaged']) ?></td>
    <td id="1-print-slot-11-5"><?php if(isset($this->samples[0][5]['mechanicalDamaged'])) print($this->samples[0][5]['mechanicalDamaged']) ?></td>
    <td id="1-print-slot-11-6"><?php if(isset($this->samples[0][6]['mechanicalDamaged'])) print($this->samples[0][6]['mechanicalDamaged']) ?></td>
    <td id="1-print-slot-11-7"><?php if(isset($this->samples[0][7]['mechanicalDamaged'])) print($this->samples[0][7]['mechanicalDamaged']) ?></td>
    <td id="1-print-slot-11-8"><?php if(isset($this->samples[0][8]['mechanicalDamaged'])) print($this->samples[0][8]['mechanicalDamaged']) ?></td>
    <td id="1-print-slot-11-9"><?php if(isset($this->samples[0][9]['mechanicalDamaged'])) print($this->samples[0][9]['mechanicalDamaged']) ?></td>
    <td id="1-print-slot-11-10"><?php if(isset($this->samples[0][10]['mechanicalDamaged'])) print($this->samples[0][10]['mechanicalDamaged']) ?></td>
    <td id="1-print-slot-11-11"><?php if(isset($this->samples[0][11]['mechanicalDamaged'])) print($this->samples[0][11]['mechanicalDamaged']) ?></td>
    <td id="1-print-slot-11-12"><?php if(isset($this->samples[0][12]['mechanicalDamaged'])) print($this->samples[0][12]['mechanicalDamaged']) ?></td>
    <td id="1-print-slot-11-13"><?php if($this->gradeArray[0]!=0) print $this->gradeStock[$this->gradeArray[0]]['sumOfMechanicalDamaged']; ?></td>
    <td id="1-print-slot-11-14"><?php if(isset($this->percentages[0]['perOfMechanicalDamaged']))print $this->percentages[0]['perOfMechanicalDamaged']; ?></td>
    
    <td id="2-print-slot-11-0"><?php if(isset($this->samples[1][0]['mechanicalDamaged'])) print($this->samples[1][0]['mechanicalDamaged']) ?></td>
    <td id="2-print-slot-11-1"><?php if(isset($this->samples[1][1]['mechanicalDamaged'])) print($this->samples[1][1]['mechanicalDamaged']) ?></td>
    <td id="2-print-slot-11-2"><?php if(isset($this->samples[1][2]['mechanicalDamaged'])) print($this->samples[1][2]['mechanicalDamaged']) ?></td>
    <td id="2-print-slot-11-3"><?php if(isset($this->samples[1][3]['mechanicalDamaged'])) print($this->samples[1][3]['mechanicalDamaged']) ?></td>
    <td id="2-print-slot-11-4"><?php if(isset($this->samples[1][4]['mechanicalDamaged'])) print($this->samples[1][4]['mechanicalDamaged']) ?></td>
    <td id="2-print-slot-11-5"><?php if(isset($this->samples[1][5]['mechanicalDamaged'])) print($this->samples[1][5]['mechanicalDamaged']) ?></td>
    <td id="2-print-slot-11-6"><?php if(isset($this->samples[1][6]['mechanicalDamaged'])) print($this->samples[1][6]['mechanicalDamaged']) ?></td>
    <td id="2-print-slot-11-7"><?php if(isset($this->samples[1][7]['mechanicalDamaged'])) print($this->samples[1][7]['mechanicalDamaged']) ?></td>
    <td id="2-print-slot-11-8"><?php if(isset($this->samples[1][8]['mechanicalDamaged'])) print($this->samples[1][8]['mechanicalDamaged']) ?></td>
    <td id="2-print-slot-11-9"><?php if(isset($this->samples[1][9]['mechanicalDamaged'])) print($this->samples[1][9]['mechanicalDamaged']) ?></td>
    <td id="2-print-slot-11-10"><?php if(isset($this->samples[1][10]['mechanicalDamaged'])) print($this->samples[1][10]['mechanicalDamaged']) ?></td>
    <td id="2-print-slot-11-11"><?php if(isset($this->samples[1][11]['mechanicalDamaged'])) print($this->samples[1][11]['mechanicalDamaged']) ?></td>
    <td id="2-print-slot-11-12"><?php if(isset($this->samples[1][12]['mechanicalDamaged'])) print($this->samples[1][12]['mechanicalDamaged']) ?></td>
    <td id="2-print-slot-11-13"><?php if($this->gradeArray[1]!=0) print $this->gradeStock[$this->gradeArray[1]]['sumOfMechanicalDamaged']; ?></td>
    <td id="2-print-slot-11-14"><?php if(isset($this->percentages[1]['perOfMechanicalDamaged']))print $this->percentages[1]['perOfMechanicalDamaged']; ?></td>
  </tr>
  <tr>
    <td colspan="5" class="tableheader">කහ පැහැති ගෙඩි</td>
     <td id="1-print-slot-12-0"><?php if(isset($this->samples[0][0]['yellowish'])) print($this->samples[0][0]['yellowish']) ?></td>
    <td id="1-print-slot-12-1"><?php if(isset($this->samples[0][1]['yellowish'])) print($this->samples[0][1]['yellowish']) ?></td>
    <td id="1-print-slot-12-2"><?php if(isset($this->samples[0][2]['yellowish'])) print($this->samples[0][2]['yellowish']) ?></td>
    <td id="1-print-slot-12-3"><?php if(isset($this->samples[0][3]['yellowish'])) print($this->samples[0][3]['yellowish']) ?></td>
    <td id="1-print-slot-12-4"><?php if(isset($this->samples[0][4]['yellowish'])) print($this->samples[0][4]['yellowish']) ?></td>
    <td id="1-print-slot-12-5"><?php if(isset($this->samples[0][5]['yellowish'])) print($this->samples[0][5]['yellowish']) ?></td>
    <td id="1-print-slot-12-6"><?php if(isset($this->samples[0][6]['yellowish'])) print($this->samples[0][6]['yellowish']) ?></td>
    <td id="1-print-slot-12-7"><?php if(isset($this->samples[0][7]['yellowish'])) print($this->samples[0][7]['yellowish']) ?></td>
    <td id="1-print-slot-12-8"><?php if(isset($this->samples[0][8]['yellowish'])) print($this->samples[0][8]['yellowish']) ?></td>
    <td id="1-print-slot-12-9"><?php if(isset($this->samples[0][9]['yellowish'])) print($this->samples[0][9]['yellowish']) ?></td>
    <td id="1-print-slot-12-10"><?php if(isset($this->samples[0][10]['yellowish'])) print($this->samples[0][10]['yellowish']) ?></td>
    <td id="1-print-slot-12-11"><?php if(isset($this->samples[0][11]['yellowish'])) print($this->samples[0][11]['yellowish']) ?></td>
    <td id="1-print-slot-12-12"><?php if(isset($this->samples[0][12]['yellowish'])) print($this->samples[0][12]['yellowish']) ?></td>
    
    <td id="1-print-slot-12-13"><?php if($this->gradeArray[0]!=0) print $this->gradeStock[$this->gradeArray[0]]['sumOfYellowish']; ?></td>
    <td id="1-print-slot-12-14"><?php if(isset($this->percentages[0]['perOfYellowish']))print $this->percentages[0]['perOfYellowish']; ?></td>
    
     <td id="2-print-slot-12-0"><?php if(isset($this->samples[1][0]['yellowish'])) print($this->samples[1][0]['yellowish']) ?></td>
    <td id="2-print-slot-12-1"><?php if(isset($this->samples[1][1]['yellowish'])) print($this->samples[1][1]['yellowish']) ?></td>
    <td id="2-print-slot-12-2"><?php if(isset($this->samples[1][2]['yellowish'])) print($this->samples[1][2]['yellowish']) ?></td>
    <td id="2-print-slot-12-3"><?php if(isset($this->samples[1][3]['yellowish'])) print($this->samples[1][3]['yellowish']) ?></td>
    <td id="2-print-slot-12-4"><?php if(isset($this->samples[1][4]['yellowish'])) print($this->samples[1][4]['yellowish']) ?></td>
    <td id="2-print-slot-12-5"><?php if(isset($this->samples[1][5]['yellowish'])) print($this->samples[1][5]['yellowish']) ?></td>
    <td id="2-print-slot-12-6"><?php if(isset($this->samples[1][6]['yellowish'])) print($this->samples[1][6]['yellowish']) ?></td>
    <td id="2-print-slot-12-7"><?php if(isset($this->samples[1][7]['yellowish'])) print($this->samples[1][7]['yellowish']) ?></td>
    <td id="2-print-slot-12-8"><?php if(isset($this->samples[1][8]['yellowish'])) print($this->samples[1][8]['yellowish']) ?></td>
    <td id="2-print-slot-12-9"><?php if(isset($this->samples[1][9]['yellowish'])) print($this->samples[1][9]['yellowish']) ?></td>
    <td id="2-print-slot-12-10"><?php if(isset($this->samples[1][10]['yellowish'])) print($this->samples[1][10]['yellowish']) ?></td>
    <td id="2-print-slot-12-11"><?php if(isset($this->samples[1][11]['yellowish'])) print($this->samples[1][11]['yellowish']) ?></td>
    <td id="2-print-slot-12-12"><?php if(isset($this->samples[1][12]['yellowish'])) print($this->samples[1][12]['yellowish']) ?></td>
    <td id="2-print-slot-12-13"><?php if($this->gradeArray[1]!=0) print $this->gradeStock[$this->gradeArray[1]]['sumOfYellowish']; ?></td>
    <td id="2-print-slot-12-14"><?php if(isset($this->percentages[1]['perOfYellowish']))print $this->percentages[1]['perOfYellowish']; ?></td>
  </tr>
  <tr>
    <td colspan="5" class="tableheader"> දුඹුරු පැල්ලම් </td>
    <td id="1-print-slot-13-0"><?php if(isset($this->samples[0][0]['rustPatches'])) print($this->samples[0][0]['rustPatches']) ?></td>
    <td id="1-print-slot-13-1"><?php if(isset($this->samples[0][1]['rustPatches'])) print($this->samples[0][1]['rustPatches']) ?></td>
    <td id="1-print-slot-13-2"><?php if(isset($this->samples[0][2]['rustPatches'])) print($this->samples[0][2]['rustPatches']) ?></td>
    <td id="1-print-slot-13-3"><?php if(isset($this->samples[0][3]['rustPatches'])) print($this->samples[0][3]['rustPatches']) ?></td>
    <td id="1-print-slot-13-4"><?php if(isset($this->samples[0][4]['rustPatches'])) print($this->samples[0][4]['rustPatches']) ?></td>
    <td id="1-print-slot-13-5"><?php if(isset($this->samples[0][5]['rustPatches'])) print($this->samples[0][5]['rustPatches']) ?></td>
    <td id="1-print-slot-13-6"><?php if(isset($this->samples[0][6]['rustPatches'])) print($this->samples[0][6]['rustPatches']) ?></td>
    <td id="1-print-slot-13-7"><?php if(isset($this->samples[0][7]['rustPatches'])) print($this->samples[0][7]['rustPatches']) ?></td>
    <td id="1-print-slot-13-8"><?php if(isset($this->samples[0][8]['rustPatches'])) print($this->samples[0][8]['rustPatches']) ?></td>
    <td id="1-print-slot-13-9"><?php if(isset($this->samples[0][9]['rustPatches'])) print($this->samples[0][9]['rustPatches']) ?></td>
    <td id="1-print-slot-13-10"><?php if(isset($this->samples[0][10]['rustPatches'])) print($this->samples[0][10]['rustPatches']) ?></td>
    <td id="1-print-slot-13-11"><?php if(isset($this->samples[0][11]['rustPatches'])) print($this->samples[0][11]['rustPatches']) ?></td>
    <td id="1-print-slot-13-12"><?php if(isset($this->samples[0][12]['rustPatches'])) print($this->samples[0][12]['rustPatches']) ?></td>
    <td id="1-print-slot-13-13"><?php if($this->gradeArray[0]!=0) print $this->gradeStock[$this->gradeArray[0]]['sumOfRustPatches']; ?></td>
    <td id="1-print-slot-13-14"><?php if(isset($this->percentages[0]['perOfRustPatches']))print $this->percentages[0]['perOfRustPatches']; ?></td>
    
     <td id="2-print-slot-13-0"><?php if(isset($this->samples[1][0]['rustPatches'])) print($this->samples[1][0]['rustPatches']) ?></td>
    <td id="2-print-slot-13-1"><?php if(isset($this->samples[1][1]['rustPatches'])) print($this->samples[1][1]['rustPatches']) ?></td>
    <td id="2-print-slot-13-2"><?php if(isset($this->samples[1][2]['rustPatches'])) print($this->samples[1][2]['rustPatches']) ?></td>
    <td id="2-print-slot-13-3"><?php if(isset($this->samples[1][3]['rustPatches'])) print($this->samples[1][3]['rustPatches']) ?></td>
    <td id="2-print-slot-13-4"><?php if(isset($this->samples[1][4]['rustPatches'])) print($this->samples[1][4]['rustPatches']) ?></td>
    <td id="2-print-slot-13-5"><?php if(isset($this->samples[1][5]['rustPatches'])) print($this->samples[1][5]['rustPatches']) ?></td>
    <td id="2-print-slot-13-6"><?php if(isset($this->samples[1][6]['rustPatches'])) print($this->samples[1][6]['rustPatches']) ?></td>
    <td id="2-print-slot-13-7"><?php if(isset($this->samples[1][7]['rustPatches'])) print($this->samples[1][7]['rustPatches']) ?></td>
    <td id="2-print-slot-13-8"><?php if(isset($this->samples[1][8]['rustPatches'])) print($this->samples[1][8]['rustPatches']) ?></td>
    <td id="2-print-slot-13-9"><?php if(isset($this->samples[1][9]['rustPatches'])) print($this->samples[1][9]['rustPatches']) ?></td>
    <td id="2-print-slot-13-10"><?php if(isset($this->samples[1][10]['rustPatches'])) print($this->samples[1][10]['rustPatches']) ?></td>
    <td id="2-print-slot-13-11"><?php if(isset($this->samples[1][11]['rustPatches'])) print($this->samples[1][11]['rustPatches']) ?></td>
    <td id="2-print-slot-13-12"><?php if(isset($this->samples[1][12]['rustPatches'])) print($this->samples[1][12]['rustPatches']) ?></td>
    <td id="2-print-slot-13-13"><?php if($this->gradeArray[1]!=0) print $this->gradeStock[$this->gradeArray[1]]['sumOfRustPatches']; ?></td>
    <td id="2-print-slot-13-14"><?php if(isset($this->percentages[1]['perOfRustPatches']))print $this->percentages[1]['perOfRustPatches']; ?></td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
    <td id="1-print-slot-14-0">&nbsp;</td>
    <td id="1-print-slot-14-1">&nbsp;</td>
    <td id="1-print-slot-14-2">&nbsp;</td>
    <td id="1-print-slot-14-3">&nbsp;</td>
    <td id="1-print-slot-14-4">&nbsp;</td>
    <td id="1-print-slot-14-5">&nbsp;</td>
    <td id="1-print-slot-14-6">&nbsp;</td>
    <td id="1-print-slot-14-7">&nbsp;</td>
    <td id="1-print-slot-14-8">&nbsp;</td>
    <td id="1-print-slot-14-9">&nbsp;</td>
    <td id="1-print-slot-14-10">&nbsp;</td>
    <td id="1-print-slot-14-11">&nbsp;</td>
    <td id="1-print-slot-14-12">&nbsp;</td>
    <td id="1-print-slot-14-13">&nbsp;</td>
   <td id="1-print-slot-14-14">&nbsp;</td>
   
    <td id="2-print-slot-14-0">&nbsp;</td>
    <td id="2-print-slot-14-1">&nbsp;</td>
    <td id="2-print-slot-14-2">&nbsp;</td>
    <td id="2-print-slot-14-3">&nbsp;</td>
    <td id="2-print-slot-14-4">&nbsp;</td>
    <td id="2-print-slot-14-5">&nbsp;</td>
    <td id="2-print-slot-14-6">&nbsp;</td>
    <td id="2-print-slot-14-7">&nbsp;</td>
    <td id="2-print-slot-14-8">&nbsp;</td>
    <td id="2-print-slot-14-9">&nbsp;</td>
    <td id="2-print-slot-14-10">&nbsp;</td>
    <td id="2-print-slot-14-11">&nbsp;</td>
    <td id="2-print-slot-14-12">&nbsp;</td>
    <td id="2-print-slot-14-13">&nbsp;</td>
     <td id="2-print-slot-14-14">&nbsp;</td>
  </tr>
  <tr>
    <td  colspan="6" height="8"><p>පිළිගත් (AC)/නොපිළිගත්(RJ)</p></td>
    <td id="1-print-slot-15-0"><?php if(isset($this->samples[0][0]['accepted'])) print($this->samples[0][0]['accepted']) ?></td>
    <td id="1-print-slot-15-1"><?php if(isset($this->samples[0][1]['accepted'])) print($this->samples[0][1]['accepted']) ?></td>
    <td id="1-print-slot-15-2"><?php if(isset($this->samples[0][2]['accepted'])) print($this->samples[0][2]['accepted']) ?></td>
    <td id="1-print-slot-15-3"><?php if(isset($this->samples[0][3]['accepted'])) print($this->samples[0][3]['accepted']) ?></td>
    <td id="1-print-slot-15-4"><?php if(isset($this->samples[0][4]['accepted'])) print($this->samples[0][4]['accepted']) ?></td>
    <td id="1-print-slot-15-5"><?php if(isset($this->samples[0][5]['accepted'])) print($this->samples[0][5]['accepted']) ?></td>
    <td id="1-print-slot-15-6"><?php if(isset($this->samples[0][6]['accepted'])) print($this->samples[0][6]['accepted']) ?></td>
    <td id="1-print-slot-15-7"><?php if(isset($this->samples[0][7]['accepted'])) print($this->samples[0][7]['accepted']) ?></td>
    <td id="1-print-slot-15-8"><?php if(isset($this->samples[0][8]['accepted'])) print($this->samples[0][8]['accepted']) ?></td>
    <td id="1-print-slot-15-9"><?php if(isset($this->samples[0][9]['accepted'])) print($this->samples[0][9]['accepted']) ?></td>
    <td id="1-print-slot-15-10"><?php if(isset($this->samples[0][10]['accepted'])) print($this->samples[0][10]['accepted']) ?></td>
    <td id="1-print-slot-15-11"><?php if(isset($this->samples[0][11]['accepted'])) print($this->samples[0][11]['accepted']) ?></td>
    <td id="1-print-slot-15-12"><?php if(isset($this->samples[0][12]['accepted'])) print($this->samples[0][12]['accepted']) ?></td>
    <td id="1-print-slot-15-13">&nbsp;</td>
    <td id="1-print-slot-15-14">&nbsp;</td>
    
    <td id="2-print-slot-15-0"><?php if(isset($this->samples[1][0]['accepted'])) print($this->samples[1][0]['accepted']) ?></td>
    <td id="2-print-slot-15-1"><?php if(isset($this->samples[1][1]['accepted'])) print($this->samples[1][1]['accepted']) ?></td>
    <td id="2-print-slot-15-2"><?php if(isset($this->samples[1][2]['accepted'])) print($this->samples[1][2]['accepted']) ?></td>
    <td id="2-print-slot-15-3"><?php if(isset($this->samples[1][3]['accepted'])) print($this->samples[1][3]['accepted']) ?></td>
    <td id="2-print-slot-15-4"><?php if(isset($this->samples[1][4]['accepted'])) print($this->samples[1][4]['accepted']) ?></td>
    <td id="2-print-slot-15-5"><?php if(isset($this->samples[1][5]['accepted'])) print($this->samples[1][5]['accepted']) ?></td>
    <td id="2-print-slot-15-6"><?php if(isset($this->samples[1][6]['accepted'])) print($this->samples[1][6]['accepted']) ?></td>
    <td id="2-print-slot-15-7"><?php if(isset($this->samples[1][7]['accepted'])) print($this->samples[1][7]['accepted']) ?></td>
    <td id="2-print-slot-15-8"><?php if(isset($this->samples[1][8]['accepted'])) print($this->samples[1][8]['accepted']) ?></td>
    <td id="2-print-slot-15-9"><?php if(isset($this->samples[1][9]['accepted'])) print($this->samples[1][9]['accepted']) ?></td>
    <td id="2-print-slot-15-10"><?php if(isset($this->samples[1][10]['accepted'])) print($this->samples[1][10]['accepted']) ?></td>
    <td id="2-print-slot-15-11"><?php if(isset($this->samples[1][11]['accepted'])) print($this->samples[1][11]['accepted']) ?></td>
    <td id="2-print-slot-15-12"><?php if(isset($this->samples[1][12]['accepted'])) print($this->samples[1][12]['accepted']) ?></td>
    <td id="2-print-slot-15-13">&nbsp;</td>
    <td id="2-print-slot-15-14">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6">නරක් වු ගෙඩි </td>
   <td id="1-print-slot-16-0"><?php if(isset($this->samples[0][0]['spoiled'])) print($this->samples[0][0]['spoiled']) ?></td>
    <td id="1-print-slot-16-1"><?php if(isset($this->samples[0][1]['spoiled'])) print($this->samples[0][1]['spoiled']) ?></td>
    <td id="1-print-slot-16-2"><?php if(isset($this->samples[0][2]['spoiled'])) print($this->samples[0][2]['spoiled']) ?></td>
    <td id="1-print-slot-16-3"><?php if(isset($this->samples[0][3]['spoiled'])) print($this->samples[0][3]['spoiled']) ?></td>
    <td id="1-print-slot-16-4"><?php if(isset($this->samples[0][4]['spoiled'])) print($this->samples[0][4]['spoiled']) ?></td>
    <td id="1-print-slot-16-5"><?php if(isset($this->samples[0][5]['spoiled'])) print($this->samples[0][5]['spoiled']) ?></td>
    <td id="1-print-slot-16-6"><?php if(isset($this->samples[0][6]['spoiled'])) print($this->samples[0][6]['spoiled']) ?></td>
    <td id="1-print-slot-16-7"><?php if(isset($this->samples[0][7]['spoiled'])) print($this->samples[0][7]['spoiled']) ?></td>
    <td id="1-print-slot-16-8"><?php if(isset($this->samples[0][8]['spoiled'])) print($this->samples[0][8]['spoiled']) ?></td>
    <td id="1-print-slot-16-9"><?php if(isset($this->samples[0][9]['spoiled'])) print($this->samples[0][9]['spoiled']) ?></td>
    <td id="1-print-slot-16-10"><?php if(isset($this->samples[0][10]['spoiled'])) print($this->samples[0][10]['spoiled']) ?></td>
    <td id="1-print-slot-16-11"><?php if(isset($this->samples[0][11]['spoiled'])) print($this->samples[0][11]['spoiled']) ?></td>
    <td id="1-print-slot-16-12"><?php if(isset($this->samples[0][12]['spoiled'])) print($this->samples[0][12]['spoiled']) ?></td>
    <td id="1-print-slot-16-13"><?php if($this->gradeArray[0]!=0) print $this->gradeStock[$this->gradeArray[0]]['sumOfRotten']; ?></td>
    <td id="1-print-slot-16-14"><?php if(isset($this->percentages[0]['perOfRotten']))print $this->percentages[0]['perOfRotten']; ?></td>
    
    <td id="2-print-slot-16-0"><?php if(isset($this->samples[1][0]['spoiled'])) print($this->samples[1][0]['spoiled']) ?></td>
    <td id="2-print-slot-16-1"><?php if(isset($this->samples[1][1]['spoiled'])) print($this->samples[1][1]['spoiled']) ?></td>
    <td id="2-print-slot-16-2"><?php if(isset($this->samples[1][2]['spoiled'])) print($this->samples[1][2]['spoiled']) ?></td>
    <td id="2-print-slot-16-3"><?php if(isset($this->samples[1][3]['spoiled'])) print($this->samples[1][3]['spoiled']) ?></td>
    <td id="2-print-slot-16-4"><?php if(isset($this->samples[1][4]['spoiled'])) print($this->samples[1][4]['spoiled']) ?></td>
    <td id="2-print-slot-16-5"><?php if(isset($this->samples[1][5]['spoiled'])) print($this->samples[1][5]['spoiled']) ?></td>
    <td id="2-print-slot-16-6"><?php if(isset($this->samples[1][6]['spoiled'])) print($this->samples[1][6]['spoiled']) ?></td>
    <td id="2-print-slot-16-7"><?php if(isset($this->samples[1][7]['spoiled'])) print($this->samples[1][7]['spoiled']) ?></td>
    <td id="2-print-slot-16-8"><?php if(isset($this->samples[1][8]['spoiled'])) print($this->samples[1][8]['spoiled']) ?></td>
    <td id="2-print-slot-16-9"><?php if(isset($this->samples[1][9]['spoiled'])) print($this->samples[1][9]['spoiled']) ?></td>
    <td id="2-print-slot-16-10"><?php if(isset($this->samples[1][10]['spoiled'])) print($this->samples[1][10]['spoiled']) ?></td>
    <td id="2-print-slot-16-11"><?php if(isset($this->samples[1][11]['spoiled'])) print($this->samples[1][11]['spoiled']) ?></td>
    <td id="2-print-slot-16-12"><?php if(isset($this->samples[1][12]['spoiled'])) print($this->samples[1][12]['spoiled']) ?></td>
    <td id="2-print-slot-16-13"><?php if($this->gradeArray[1]!=0) print $this->gradeStock[$this->gradeArray[1]]['sumOfRotten']; ?></td>
    <td id="2-print-slot-16-14"><?php if(isset($this->percentages[1]['perOfRotten']))print $this->percentages[1]['perOfRotten']; ?></td>
  </tr>
  <tr>
    <td colspan="6" rowspan="7">&nbsp;</td>
    <td colspan="6" class="tableheader"> ක්‍රේට් ගණන </td>
    <td colspan="4" id="1-print-sum-noCrates"><?php if($this->gradeArray[0]!=0)print $this->gradeStock[$this->gradeArray[0]]['noOfCrates']; ?></td>
    <td colspan="5" rowspan="7">&nbsp;</td>
    <td colspan="6" class="tableheader"> ක්‍රේට් ගණන </td>
    <td colspan="4" id="2-print-sum-noCrates"><?php if($this->gradeArray[1]!=0)print $this->gradeStock[$this->gradeArray[1]]['noOfCrates']; ?></td>
    <td colspan="5" rowspan="7">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6" class="tableheader">ප්‍රකාශිත බර(kg)</td>
    <td colspan="4" id="1-print-sum-notedWeight"><?php if($this->gradeArray[0]!=0)print $this->gradeStock[$this->gradeArray[0]]['notedWeight']; ?></td>
    <td colspan="6" class="tableheader">ප්‍රකාශිත බර(kg)</td>
    <td colspan="4" id="2-print-sum-notedWeight"><?php if($this->gradeArray[1]!=0)print $this->gradeStock[$this->gradeArray[1]]['notedWeight']; ?></td>
    </tr>
  <tr>
    <td colspan="6" class="tableheader">තිබූ බර ප්‍රමාණය(kg)</td>
    <td colspan="4" id="1-print-sum-trueWeight"><?php if($this->gradeArray[0]!=0)print $this->gradeStock[$this->gradeArray[0]]['trueWeight']; ?></td>
    <td colspan="6" class="tableheader">තිබූ බර ප්‍රමාණය(kg)</td>
    <td colspan="4" id="2-print-sum-trueWeight"><?php if($this->gradeArray[1]!=0)print $this->gradeStock[$this->gradeArray[1]]['trueWeight']; ?></td>
    </tr>
  <tr>
    <td colspan="6" class="tableheader">&nbsp;</td>
    <td colspan="2" align="center">එකතුව</td>
    <td colspan="2" align="center">%</td>
    <td colspan="6" class="tableheader">&nbsp;</td>
    <td colspan="2" align="center">එකතුව</td>
    <td colspan="2" align="center">%</td>
    </tr>
  <tr>
    <td colspan="6" class="tableheader">වැරදි ශ්‍රේණිය</td>
    <td colspan="2" id="1-print-sum-defectGrade-sum"><?php if($this->gradeArray[0]!=0)print $this->gradeStock[$this->gradeArray[0]]['totalPerOfDefectGrade']; ?></td>
    <td colspan="2" id="1-print-sum-defectGrade-reduced"><?php if($this->gradeArray[0]!=0)print $this->gradeStock[$this->gradeArray[0]]['reducedPerOfDefectGrade']; ?></td>
    <td colspan="6" class="tableheader">වැරදි ශ්‍රේණිය</td>
    <td colspan="2" id="2-print-sum-defectGrade-sum"><?php if($this->gradeArray[1]!=0)print $this->gradeStock[$this->gradeArray[1]]['totalPerOfDefectGrade']; ?></td>
    <td colspan="2" id="2-print-sum-defectGrade-reduced"><?php if($this->gradeArray[1]!=0)print $this->gradeStock[$this->gradeArray[1]]['reducedPerOfDefectGrade']; ?></td>
    </tr>
  <tr>
    <td height="16" colspan="6" class="tableheader">දෝෂ </td>
    <td colspan="2" id="1-print-sum-defects-sum"><?php if($this->gradeArray[0]!=0)print $this->gradeStock[$this->gradeArray[0]]['totalPerOfDefect']; ?></td>
    <td colspan="2" id="1-print-sum-defects-reduced"><?php if($this->gradeArray[0]!=0)print $this->gradeStock[$this->gradeArray[0]]['reducedPerOfDefect']; ?></td>
    <td height="16" colspan="6" class="tableheader">දෝෂ </td>
    <td colspan="2" id="2-print-sum-defects-sum"><?php if($this->gradeArray[1]!=0)print $this->gradeStock[$this->gradeArray[1]]['totalPerOfDefect']; ?></td>
    <td colspan="2" id="2-print-sum-defects-reduced"><?php if($this->gradeArray[1]!=0)print $this->gradeStock[$this->gradeArray[1]]['reducedPerOfDefect']; ?></td>
    </tr>
  <tr>
    <td height="18" colspan="6"><span class="tableheader">ගෙවිය හැකි ප්‍රමාණය(kg) </span></td>
    <td colspan="2" id="1-print-sum-pq-sum"><?php if($this->gradeArray[0]!=0)print $this->gradeStock[$this->gradeArray[0]]['payableQuantity']; ?></td>
    <td colspan="2">&nbsp;</td>
    <td height="18" colspan="6"><span class="tableheader">ගෙවිය හැකි ප්‍රමාණය(kg) </span></td>
    <td colspan="2" id="2-print-sum-pq-sum"><?php if($this->gradeArray[1]!=0)print $this->gradeStock[$this->gradeArray[1]]['payableQuantity']; ?></td>
    <td colspan="2">&nbsp;</td>
    </tr>
 <!-- htsihist-->
 
 <tr><td colspan="44"></td></tr>
 <tr>
    <td colspan="6">&nbsp;</td>
    <td colspan="2" class="tableheader">ශ්‍රේණිය</td>
    <td colspan="2" id="3-print-grade"><?php 
    if($this->gradeArray[2]!=0){
   
  
    //print $this->gradeArray[2];
    print($this->getGradeName($this->gradeArray[2])) ;
    }?></td>
    <td colspan="2">&nbsp;</td>
    <td colspan="4" class="tableheader">අනුමත ගෙඩි ගණන</td>
    <td colspan="3" id="3-print-avgFruitCount"><?php if($this->gradeArray[2]!=0)print $this->gradeStock[$this->gradeArray[2]]['averageFruitCount']; ?></td>
    <td width="27">එකතුව</td>
    <td width="23">%</td>
    <td width="2">&nbsp;</td>
    <td colspan="2" class="tableheader">ශ්‍රේණිය</td>
    <td colspan="2" id="4-print-grade"><?php 
    if($this->gradeArray[3]!=0){
        //print $this->gradeArray[3];
        print($this->getGradeName($this->gradeArray[3])) ;
    }?></td>
    <td colspan="2">&nbsp;</td>
    <td colspan="4"><span class="tableheader">අනුමත ගෙඩි ගණන</span></td>
    <td colspan="3" id="4-print-avgFruitCount"><?php if($this->gradeArray[3]!=0)print $this->gradeStock[$this->gradeArray[3]]['averageFruitCount']; ?></td>
    <td width="27">එකතුව</td>
    <td width="22">%</td>
  </tr>
  <tr>
    <td colspan="6" class="tableheader">මධ්‍යස්ථාන අංකය</td>
    <td width="30" id="3-print-slot-0-0"><?php if(isset($this->samples[2][0]['centerId'])) print($this->samples[2][0]['centerId']) ?></td>
    <td width="26" id="3-print-slot-0-1"><?php if(isset($this->samples[2][1]['centerId'])) print($this->samples[2][1]['centerId']) ?></td>
    <td width="26" id="3-print-slot-0-2"><?php if(isset($this->samples[2][2]['centerId'])) print($this->samples[2][2]['centerId']) ?></td>
    <td width="27" id="3-print-slot-0-3"><?php if(isset($this->samples[2][3]['centerId'])) print($this->samples[2][3]['centerId']) ?></td>
    <td width="29" id="3-print-slot-0-4"><?php if(isset($this->samples[2][4]['centerId'])) print($this->samples[2][4]['centerId']) ?></td>
    <td width="27" id="3-print-slot-0-5"><?php if(isset($this->samples[2][5]['centerId'])) print($this->samples[2][5]['centerId']) ?></td>
    <td width="23" id="3-print-slot-0-6"><?php if(isset($this->samples[2][6]['centerId'])) print($this->samples[2][6]['centerId']) ?></td>
    <td width="24" id="3-print-slot-0-7"><?php if(isset($this->samples[2][7]['centerId'])) print($this->samples[2][7]['centerId']) ?></td>
    <td width="25" id="3-print-slot-0-8"><?php if(isset($this->samples[2][8]['centerId'])) print($this->samples[2][8]['centerId']) ?></td>
    <td width="21" id="3-print-slot-0-9"><?php if(isset($this->samples[2][9]['centerId'])) print($this->samples[2][9]['centerId']) ?></td>
    <td width="24" id="3-print-slot-0-10"><?php if(isset($this->samples[2][10]['centerId'])) print($this->samples[2][10]['centerId']) ?></td>
    <td width="26" id="3-print-slot-0-11"><?php if(isset($this->samples[2][11]['centerId'])) print($this->samples[2][11]['centerId']) ?></td>
    <td width="26" id="3-print-slot-0-12"><?php if(isset($this->samples[2][12]['centerId'])) print($this->samples[2][12]['centerId']) ?></td>
    <td width="27" id="3-print-slot-0-13">&nbsp;</td>
    <td width="23" id="3-print-slot-0-14">&nbsp;</td>
    <td width="2" rowspan="24" style="background:#999">&nbsp;</td>
       <td width="30" id="3-print-slot-0-0"><?php if(isset($this->samples[3][0]['centerId'])) print($this->samples[3][0]['centerId']) ?></td>
    <td width="26" id="4-print-slot-0-1"><?php if(isset($this->samples[3][1]['centerId'])) print($this->samples[3][1]['centerId']) ?></td>
    <td width="26" id="4-print-slot-0-2"><?php if(isset($this->samples[3][2]['centerId'])) print($this->samples[3][2]['centerId']) ?></td>
    <td width="27" id="4-print-slot-0-3"><?php if(isset($this->samples[3][3]['centerId'])) print($this->samples[3][3]['centerId']) ?></td>
    <td width="29" id="4-print-slot-0-4"><?php if(isset($this->samples[3][4]['centerId'])) print($this->samples[3][4]['centerId']) ?></td>
    <td width="27" id="4-print-slot-0-5"><?php if(isset($this->samples[3][5]['centerId'])) print($this->samples[3][5]['centerId']) ?></td>
    <td width="23" id="4-print-slot-0-6"><?php if(isset($this->samples[3][6]['centerId'])) print($this->samples[3][6]['centerId']) ?></td>
    <td width="24" id="4-print-slot-0-7"><?php if(isset($this->samples[3][7]['centerId'])) print($this->samples[3][7]['centerId']) ?></td>
    <td width="25" id="4-print-slot-0-8"><?php if(isset($this->samples[3][8]['centerId'])) print($this->samples[3][8]['centerId']) ?></td>
    <td width="21" id="4-print-slot-0-9"><?php if(isset($this->samples[3][9]['centerId'])) print($this->samples[3][9]['centerId']) ?></td>
    <td width="24" id="4-print-slot-0-10"><?php if(isset($this->samples[3][10]['centerId'])) print($this->samples[3][10]['centerId']) ?></td>
    <td width="26" id="4-print-slot-0-11"><?php if(isset($this->samples[3][11]['centerId'])) print($this->samples[3][11]['centerId']) ?></td>
    <td width="26" id="4-print-slot-0-12"><?php if(isset($this->samples[3][12]['centerId'])) print($this->samples[3][12]['centerId']) ?></td>
   
  </tr>
  <tr>
    <td height="15" colspan="6" class="tableheader">මුළු ගෙඩි ගණන</td>
    <td id="3-print-slot-1-0"><?php if(isset($this->samples[2][0]['fruitCount'])) print($this->samples[2][0]['fruitCount']) ?></td>
    <td id="3-print-slot-1-1"><?php if(isset($this->samples[2][1]['fruitCount'])) print($this->samples[2][1]['fruitCount']) ?></td>
    <td id="3-print-slot-1-2"><?php if(isset($this->samples[2][2]['fruitCount'])) print($this->samples[2][2]['fruitCount']) ?></td>
    <td id="3-print-slot-1-3"><?php if(isset($this->samples[2][3]['fruitCount'])) print($this->samples[2][3]['fruitCount']) ?></td>
    <td id="3-print-slot-1-4"><?php if(isset($this->samples[2][4]['fruitCount'])) print($this->samples[2][4]['fruitCount']) ?></td>
    <td id="3-print-slot-1-5"><?php if(isset($this->samples[2][5]['fruitCount'])) print($this->samples[2][5]['fruitCount']) ?></td>
    <td id="3-print-slot-1-6"><?php if(isset($this->samples[2][6]['fruitCount'])) print($this->samples[2][6]['fruitCount']) ?></td>
    <td id="3-print-slot-1-7"><?php if(isset($this->samples[2][7]['fruitCount'])) print($this->samples[2][7]['fruitCount']) ?></td>
    <td id="3-print-slot-1-8"><?php if(isset($this->samples[2][8]['fruitCount'])) print($this->samples[2][8]['fruitCount']) ?></td>
    <td id="3-print-slot-1-9"><?php if(isset($this->samples[2][9]['fruitCount'])) print($this->samples[2][9]['fruitCount']) ?></td>
    <td id="3-print-slot-1-10"><?php if(isset($this->samples[2][10]['fruitCount'])) print($this->samples[2][10]['fruitCount']) ?></td>
    <td id="3-print-slot-1-11"><?php if(isset($this->samples[2][11]['fruitCount'])) print($this->samples[2][11]['fruitCount']) ?></td>
    <td id="3-print-slot-1-12"><?php if(isset($this->samples[2][12]['fruitCount'])) print($this->samples[2][12]['fruitCount']) ?></td>
    <td id="3-print-slot-1-13"><?php if($this->gradeArray[2]!=0) print $this->gradeStock[$this->gradeArray[2]]['fruitCount']; ?></td>
    <td id="3-print-slot-1-14">&nbsp;</td>
    
    <td id="4-print-slot-1-0"><?php if(isset($this->samples[3][0]['fruitCount'])) print($this->samples[3][0]['fruitCount']) ?></td>
    <td id="4-print-slot-1-1"><?php if(isset($this->samples[3][1]['fruitCount'])) print($this->samples[3][1]['fruitCount']) ?></td>
    <td id="4-print-slot-1-2"><?php if(isset($this->samples[3][2]['fruitCount'])) print($this->samples[3][2]['fruitCount']) ?></td>
    <td id="4-print-slot-1-3"><?php if(isset($this->samples[3][3]['fruitCount'])) print($this->samples[3][3]['fruitCount']) ?></td>
    <td id="4-print-slot-1-4"><?php if(isset($this->samples[3][4]['fruitCount'])) print($this->samples[3][4]['fruitCount']) ?></td>
    <td id="4-print-slot-1-5"><?php if(isset($this->samples[3][5]['fruitCount'])) print($this->samples[3][5]['fruitCount']) ?></td>
    <td id="4-print-slot-1-6"><?php if(isset($this->samples[3][6]['fruitCount'])) print($this->samples[3][6]['fruitCount']) ?></td>
    <td id="4-print-slot-1-7"><?php if(isset($this->samples[3][7]['fruitCount'])) print($this->samples[3][7]['fruitCount']) ?></td>
    <td id="4-print-slot-1-8"><?php if(isset($this->samples[3][8]['fruitCount'])) print($this->samples[3][8]['fruitCount']) ?></td>
    <td id="4-print-slot-1-9"><?php if(isset($this->samples[3][9]['fruitCount'])) print($this->samples[3][9]['fruitCount']) ?></td>
    <td id="4-print-slot-1-10"><?php if(isset($this->samples[3][10]['fruitCount'])) print($this->samples[3][10]['fruitCount']) ?></td>
    <td id="4-print-slot-1-11"><?php if(isset($this->samples[3][11]['fruitCount'])) print($this->samples[3][11]['fruitCount']) ?></td>
    <td id="4-print-slot-1-12"><?php if(isset($this->samples[3][12]['fruitCount'])) print($this->samples[3][12]['fruitCount']) ?></td>
    <td id="4-print-slot-1-13"><?php if($this->gradeArray[3]!=0) print $this->gradeStock[$this->gradeArray[3]]['fruitCount']; ?></td>
    <td id="4-print-slot-1-14">&nbsp;</td>
  </tr>
  <tr>
    <td width="117" rowspan="2" class="tableheader">වැරදි ශ්‍රේණිය</td>
    <td colspan="5" class="tableheader">කුඩා ගෙඩි ගණන</td>
    <td id="3-print-slot-2-0"><?php if(isset($this->samples[2][0]['centerId'])) print($this->samples[2][0]['smallFruit']) ?></td>
    <td id="3-print-slot-2-1"><?php if(isset($this->samples[2][1]['centerId'])) print($this->samples[2][1]['smallFruit']) ?></td>
    <td id="3-print-slot-2-2"><?php if(isset($this->samples[2][2]['centerId'])) print($this->samples[2][2]['smallFruit']) ?></td>
    <td id="3-print-slot-2-3"><?php if(isset($this->samples[2][3]['centerId'])) print($this->samples[2][3]['smallFruit']) ?></td>
    <td id="3-print-slot-2-4"><?php if(isset($this->samples[2][4]['centerId'])) print($this->samples[2][4]['smallFruit']) ?></td>
    <td id="3-print-slot-2-5"><?php if(isset($this->samples[2][5]['centerId'])) print($this->samples[2][5]['smallFruit']) ?></td>
    <td id="3-print-slot-2-6"><?php if(isset($this->samples[2][6]['centerId'])) print($this->samples[2][6]['smallFruit']) ?></td>
    <td id="3-print-slot-2-7"><?php if(isset($this->samples[2][7]['centerId'])) print($this->samples[2][7]['smallFruit']) ?></td>
    <td id="3-print-slot-2-8"><?php if(isset($this->samples[2][8]['centerId'])) print($this->samples[2][8]['smallFruit']) ?></td>
    <td id="3-print-slot-2-9"><?php if(isset($this->samples[2][9]['centerId'])) print($this->samples[2][9]['smallFruit']) ?></td>
    <td id="3-print-slot-2-10"><?php if(isset($this->samples[2][10]['centerId'])) print($this->samples[2][10]['smallFruit']) ?></td>
    <td id="3-print-slot-2-11"><?php if(isset($this->samples[2][11]['centerId'])) print($this->samples[2][11]['smallFruit']) ?></td>
    <td id="3-print-slot-2-12"><?php if(isset($this->samples[2][12]['centerId'])) print($this->samples[2][12]['smallFruit']) ?></td>
    <td id="3-print-slot-2-13"><?php if($this->gradeArray[2]!=0) print $this->gradeStock[$this->gradeArray[2]]['sumOfSmallFruit']; ?></td>
    <td  id="3-print-slot-2-14"><?php if(isset($this->percentages[2]['perOfSmallFruit']))print $this->percentages[2]['perOfSmallFruit']; ?></td>
    
   <td id="4-print-slot-2-0"><?php if(isset($this->samples[3][0]['centerId'])) print($this->samples[3][0]['smallFruit']) ?></td>
    <td id="4-print-slot-2-1"><?php if(isset($this->samples[3][1]['centerId'])) print($this->samples[3][1]['smallFruit']) ?></td>
    <td id="4-print-slot-2-2"><?php if(isset($this->samples[3][2]['centerId'])) print($this->samples[3][2]['smallFruit']) ?></td>
    <td id="4-print-slot-2-3"><?php if(isset($this->samples[3][3]['centerId'])) print($this->samples[3][3]['smallFruit']) ?></td>
    <td id="4-print-slot-2-4"><?php if(isset($this->samples[3][4]['centerId'])) print($this->samples[3][4]['smallFruit']) ?></td>
    <td id="4-print-slot-2-5"><?php if(isset($this->samples[3][5]['centerId'])) print($this->samples[3][5]['smallFruit']) ?></td>
    <td id="4-print-slot-2-6"><?php if(isset($this->samples[3][6]['centerId'])) print($this->samples[3][6]['smallFruit']) ?></td>
    <td id="4-print-slot-2-7"><?php if(isset($this->samples[3][7]['centerId'])) print($this->samples[3][7]['smallFruit']) ?></td>
    <td id="4-print-slot-2-8"><?php if(isset($this->samples[3][8]['centerId'])) print($this->samples[3][8]['smallFruit']) ?></td>
    <td id="4-print-slot-2-9"><?php if(isset($this->samples[3][9]['centerId'])) print($this->samples[3][9]['smallFruit']) ?></td>
    <td id="4-print-slot-2-10"><?php if(isset($this->samples[3][10]['centerId'])) print($this->samples[3][10]['smallFruit']) ?></td>
    <td id="4-print-slot-2-11"><?php if(isset($this->samples[3][11]['centerId'])) print($this->samples[3][11]['smallFruit']) ?></td>
    <td id="4-print-slot-2-12"><?php if(isset($this->samples[3][12]['centerId'])) print($this->samples[3][12]['smallFruit']) ?></td>
    <td id="4-print-slot-2-13"><?php if($this->gradeArray[3]!=0) print $this->gradeStock[$this->gradeArray[3]]['sumOfSmallFruit']; ?></td>
    <td id="4-print-slot-2-14"><?php if(isset($this->percentages[3]['perOfSmallFruit']))print $this->percentages[3]['perOfSmallFruit']; ?></td>
  </tr>
  <tr>
    <td colspan="5" class="tableheader">ලොකු ගෙඩි ගණන</td>
    <td id="3-print-slot-3-0"><?php if(isset($this->samples[2][0]['centerId'])) print($this->samples[2][0]['largeFruit']) ?></td>
    <td id="3-print-slot-3-1"><?php if(isset($this->samples[2][1]['centerId'])) print($this->samples[2][1]['largeFruit']) ?></td>
    <td id="3-print-slot-3-2"><?php if(isset($this->samples[2][2]['centerId'])) print($this->samples[2][2]['largeFruit']) ?></td>
    <td id="3-print-slot-3-3"><?php if(isset($this->samples[2][3]['centerId'])) print($this->samples[2][3]['largeFruit']) ?></td>
    <td id="3-print-slot-3-4"><?php if(isset($this->samples[2][4]['centerId'])) print($this->samples[2][4]['largeFruit']) ?></td>
    <td id="3-print-slot-3-5"><?php if(isset($this->samples[2][5]['centerId'])) print($this->samples[2][5]['largeFruit']) ?></td>
    <td id="3-print-slot-3-6"><?php if(isset($this->samples[2][6]['centerId'])) print($this->samples[2][6]['largeFruit']) ?></td>
    <td id="3-print-slot-3-7"><?php if(isset($this->samples[2][7]['centerId'])) print($this->samples[2][7]['largeFruit']) ?></td>
    <td id="3-print-slot-3-8"><?php if(isset($this->samples[2][8]['centerId'])) print($this->samples[2][8]['largeFruit']) ?></td>
    <td id="3-print-slot-3-9"><?php if(isset($this->samples[2][9]['centerId'])) print($this->samples[2][9]['largeFruit']) ?></td>
    <td id="3-print-slot-3-10"><?php if(isset($this->samples[2][10]['centerId'])) print($this->samples[2][10]['largeFruit']) ?></td>
    <td id="3-print-slot-3-11"><?php if(isset($this->samples[2][11]['centerId'])) print($this->samples[2][11]['largeFruit']) ?></td>
    <td id="3-print-slot-3-12"><?php if(isset($this->samples[2][12]['centerId'])) print($this->samples[2][12]['largeFruit']) ?></td>
    <td id="3-print-slot-3-13"><?php if($this->gradeArray[2]!=0) print $this->gradeStock[$this->gradeArray[2]]['sumOfLargeFruit']; ?></td>
    <td id="3-print-slot-3-14"><?php if(isset($this->percentages[2]['perOfLargeFruit']))print $this->percentages[2]['perOfLargeFruit']; ?></td>
    
   <td id="4-print-slot-3-0"><?php if(isset($this->samples[3][0]['centerId'])) print($this->samples[3][0]['largeFruit']) ?></td>
    <td id="4-print-slot-3-1"><?php if(isset($this->samples[3][1]['centerId'])) print($this->samples[3][1]['largeFruit']) ?></td>
    <td id="4-print-slot-3-2"><?php if(isset($this->samples[3][2]['centerId'])) print($this->samples[3][2]['largeFruit']) ?></td>
    <td id="4-print-slot-3-3"><?php if(isset($this->samples[3][3]['centerId'])) print($this->samples[3][3]['largeFruit']) ?></td>
    <td id="4-print-slot-3-4"><?php if(isset($this->samples[3][4]['centerId'])) print($this->samples[3][4]['largeFruit']) ?></td>
    <td id="4-print-slot-3-5"><?php if(isset($this->samples[3][5]['centerId'])) print($this->samples[3][5]['largeFruit']) ?></td>
    <td id="4-print-slot-3-6"><?php if(isset($this->samples[3][6]['centerId'])) print($this->samples[3][6]['largeFruit']) ?></td>
    <td id="4-print-slot-3-7"><?php if(isset($this->samples[3][7]['centerId'])) print($this->samples[3][7]['largeFruit']) ?></td>
    <td id="4-print-slot-3-8"><?php if(isset($this->samples[3][8]['centerId'])) print($this->samples[3][8]['largeFruit']) ?></td>
    <td id="4-print-slot-3-9"><?php if(isset($this->samples[3][9]['centerId'])) print($this->samples[3][9]['largeFruit']) ?></td>
    <td id="4-print-slot-3-10"><?php if(isset($this->samples[3][10]['centerId'])) print($this->samples[3][10]['largeFruit']) ?></td>
    <td id="4-print-slot-3-11"><?php if(isset($this->samples[3][11]['centerId'])) print($this->samples[3][11]['largeFruit']) ?></td>
    <td id="4-print-slot-3-12"><?php if(isset($this->samples[3][12]['centerId'])) print($this->samples[3][12]['largeFruit']) ?></td>
    <td id="4-print-slot-3-13"><?php if($this->gradeArray[3]!=0) print $this->gradeStock[$this->gradeArray[3]]['sumOfLargeFruit']; ?></td>
    <td id="4-print-slot-3-14"><?php if(isset($this->percentages[3]['perOfLargeFruit']))print $this->percentages[3]['perOfLargeFruit']; ?></td>
  </tr>
  <tr>
    <td rowspan="5" class="tableheader">ප්‍රධාන දෝෂ(ගෙඩි ගණන)</td>
    <td colspan="5" class="tableheader">ඉල් මැසි හානි</td>
    <td id="3-print-slot-4-0"><?php if(isset($this->samples[2][0]['flyAttacked'])) print($this->samples[2][0]['flyAttacked']) ?></td>
    <td id="3-print-slot-4-1"><?php if(isset($this->samples[2][1]['flyAttacked'])) print($this->samples[2][1]['flyAttacked']) ?></td>
    <td id="3-print-slot-4-2"><?php if(isset($this->samples[2][2]['flyAttacked'])) print($this->samples[2][2]['flyAttacked']) ?></td>
    <td id="3-print-slot-4-3"><?php if(isset($this->samples[2][3]['flyAttacked'])) print($this->samples[2][3]['flyAttacked']) ?></td>
    <td id="3-print-slot-4-4"><?php if(isset($this->samples[2][4]['flyAttacked'])) print($this->samples[2][4]['flyAttacked']) ?></td>
    <td id="3-print-slot-4-5"><?php if(isset($this->samples[2][5]['flyAttacked'])) print($this->samples[2][5]['flyAttacked']) ?></td>
    <td id="3-print-slot-4-6"><?php if(isset($this->samples[2][6]['flyAttacked'])) print($this->samples[2][6]['flyAttacked']) ?></td>
    <td id="3-print-slot-4-7"><?php if(isset($this->samples[2][7]['flyAttacked'])) print($this->samples[2][7]['flyAttacked']) ?></td>
    <td id="3-print-slot-4-8"><?php if(isset($this->samples[2][8]['flyAttacked'])) print($this->samples[2][8]['flyAttacked']) ?></td>
    <td id="3-print-slot-4-9"><?php if(isset($this->samples[2][9]['flyAttacked'])) print($this->samples[2][9]['flyAttacked']) ?></td>
    <td id="3-print-slot-4-10"><?php if(isset($this->samples[2][10]['flyAttacked'])) print($this->samples[2][10]['flyAttacked']) ?></td>
    <td id="3-print-slot-4-11"><?php if(isset($this->samples[2][11]['flyAttacked'])) print($this->samples[2][11]['flyAttacked']) ?></td>
    <td id="3-print-slot-4-12"><?php if(isset($this->samples[2][12]['flyAttacked'])) print($this->samples[2][12]['flyAttacked']) ?></td>
    <td id="3-print-slot-4-13"><?php if($this->gradeArray[2]!=0) print $this->gradeStock[$this->gradeArray[2]]['sumOfFlyAttacked']; ?></td>
    <td id="3-print-slot-4-14"><?php if(isset($this->percentages[2]['perOfFlyAttacked']))print $this->percentages[2]['perOfFlyAttacked']; ?></td>
    
   <td id="4-print-slot-4-0"><?php if(isset($this->samples[3][0]['flyAttacked'])) print($this->samples[3][0]['flyAttacked']) ?></td>
    <td id="4-print-slot-4-1"><?php if(isset($this->samples[3][1]['flyAttacked'])) print($this->samples[3][1]['flyAttacked']) ?></td>
    <td id="4-print-slot-4-2"><?php if(isset($this->samples[3][2]['flyAttacked'])) print($this->samples[3][2]['flyAttacked']) ?></td>
    <td id="4-print-slot-4-3"><?php if(isset($this->samples[3][3]['flyAttacked'])) print($this->samples[3][3]['flyAttacked']) ?></td>
    <td id="4-print-slot-4-4"><?php if(isset($this->samples[3][4]['flyAttacked'])) print($this->samples[3][4]['flyAttacked']) ?></td>
    <td id="4-print-slot-4-5"><?php if(isset($this->samples[3][5]['flyAttacked'])) print($this->samples[3][5]['flyAttacked']) ?></td>
    <td id="4-print-slot-4-6"><?php if(isset($this->samples[3][6]['flyAttacked'])) print($this->samples[3][6]['flyAttacked']) ?></td>
    <td id="4-print-slot-4-7"><?php if(isset($this->samples[3][7]['flyAttacked'])) print($this->samples[3][7]['flyAttacked']) ?></td>
    <td id="4-print-slot-4-8"><?php if(isset($this->samples[3][8]['flyAttacked'])) print($this->samples[3][8]['flyAttacked']) ?></td>
    <td id="4-print-slot-4-9"><?php if(isset($this->samples[3][9]['flyAttacked'])) print($this->samples[3][9]['flyAttacked']) ?></td>
    <td id="4-print-slot-4-10"><?php if(isset($this->samples[3][10]['flyAttacked'])) print($this->samples[3][10]['flyAttacked']) ?></td>
    <td id="4-print-slot-4-11"><?php if(isset($this->samples[3][11]['flyAttacked'])) print($this->samples[3][11]['flyAttacked']) ?></td>
    <td id="4-print-slot-4-12"><?php if(isset($this->samples[3][12]['flyAttacked'])) print($this->samples[3][12]['flyAttacked']) ?></td>
    <td id="4-print-slot-4-13"><?php if($this->gradeArray[3]!=0) print $this->gradeStock[$this->gradeArray[3]]['sumOfFlyAttacked']; ?></td>
     <td id="4-print-slot-4-14"><?php if(isset($this->percentages[3]['perOfFlyAttacked']))print $this->percentages[3]['perOfFlyAttacked']; ?></td>
  </tr>
  <tr>
    <td colspan="5" class="tableheader"> පොතු ගැලවුණු </td>
   <td id="3-print-slot-5-0"><?php if(isset($this->samples[2][0]['peeledOff'])) print($this->samples[2][0]['peeledOff']) ?></td>
    <td id="3-print-slot-5-1"><?php if(isset($this->samples[2][1]['peeledOff'])) print($this->samples[2][1]['peeledOff']) ?></td>
    <td id="3-print-slot-5-2"><?php if(isset($this->samples[2][2]['peeledOff'])) print($this->samples[2][2]['peeledOff']) ?></td>
    <td id="3-print-slot-5-3"><?php if(isset($this->samples[2][3]['peeledOff'])) print($this->samples[2][3]['peeledOff']) ?></td>
    <td id="3-print-slot-5-4"><?php if(isset($this->samples[2][4]['peeledOff'])) print($this->samples[2][4]['peeledOff']) ?></td>
    <td id="3-print-slot-5-5"><?php if(isset($this->samples[2][5]['peeledOff'])) print($this->samples[2][5]['peeledOff']) ?></td>
    <td id="3-print-slot-5-6"><?php if(isset($this->samples[2][6]['peeledOff'])) print($this->samples[2][6]['peeledOff']) ?></td>
    <td id="3-print-slot-5-7"><?php if(isset($this->samples[2][7]['peeledOff'])) print($this->samples[2][7]['peeledOff']) ?></td>
    <td id="3-print-slot-5-8"><?php if(isset($this->samples[2][8]['peeledOff'])) print($this->samples[2][8]['peeledOff']) ?></td>
    <td id="3-print-slot-5-9"><?php if(isset($this->samples[2][9]['peeledOff'])) print($this->samples[2][9]['peeledOff']) ?></td>
    <td id="3-print-slot-5-10"><?php if(isset($this->samples[2][10]['peeledOff'])) print($this->samples[2][10]['peeledOff']) ?></td>
    <td id="3-print-slot-5-11"><?php if(isset($this->samples[2][11]['peeledOff'])) print($this->samples[2][11]['peeledOff']) ?></td>
    <td id="3-print-slot-5-12"><?php if(isset($this->samples[2][12]['peeledOff'])) print($this->samples[2][12]['peeledOff']) ?></td>
    <td id="3-print-slot-5-13"><?php if($this->gradeArray[2]!=0) print $this->gradeStock[$this->gradeArray[2]]['sumOfPeeledOff']; ?></td>
    <td id="3-print-slot-5-14"><?php if(isset($this->percentages[2]['perOfPeeledOff']))print $this->percentages[2]['perOfPeeledOff']; ?></td>
    
    <td id="4-print-slot-5-0"><?php if(isset($this->samples[3][0]['peeledOff'])) print($this->samples[3][0]['peeledOff']) ?></td>
    <td id="4-print-slot-5-1"><?php if(isset($this->samples[3][1]['peeledOff'])) print($this->samples[3][1]['peeledOff']) ?></td>
    <td id="4-print-slot-5-2"><?php if(isset($this->samples[3][2]['peeledOff'])) print($this->samples[3][2]['peeledOff']) ?></td>
    <td id="4-print-slot-5-3"><?php if(isset($this->samples[3][3]['peeledOff'])) print($this->samples[3][3]['peeledOff']) ?></td>
    <td id="4-print-slot-5-4"><?php if(isset($this->samples[3][4]['peeledOff'])) print($this->samples[3][4]['peeledOff']) ?></td>
    <td id="4-print-slot-5-5"><?php if(isset($this->samples[3][5]['peeledOff'])) print($this->samples[3][5]['peeledOff']) ?></td>
    <td id="4-print-slot-5-6"><?php if(isset($this->samples[3][6]['peeledOff'])) print($this->samples[3][6]['peeledOff']) ?></td>
    <td id="4-print-slot-5-7"><?php if(isset($this->samples[3][7]['peeledOff'])) print($this->samples[3][7]['peeledOff']) ?></td>
    <td id="4-print-slot-5-8"><?php if(isset($this->samples[3][8]['peeledOff'])) print($this->samples[3][8]['peeledOff']) ?></td>
    <td id="4-print-slot-5-9"><?php if(isset($this->samples[3][9]['peeledOff'])) print($this->samples[3][9]['peeledOff']) ?></td>
    <td id="4-print-slot-5-10"><?php if(isset($this->samples[3][10]['peeledOff'])) print($this->samples[3][10]['peeledOff']) ?></td>
    <td id="4-print-slot-5-11"><?php if(isset($this->samples[3][11]['peeledOff'])) print($this->samples[3][11]['peeledOff']) ?></td>
    <td id="4-print-slot-5-12"><?php if(isset($this->samples[3][12]['peeledOff'])) print($this->samples[3][12]['peeledOff']) ?></td>
    <td id="4-print-slot-5-13"><?php if($this->gradeArray[3]!=0) print $this->gradeStock[$this->gradeArray[3]]['sumOfPeeledOff']; ?></td>
    <td id="4-print-slot-5-14"><?php if(isset($this->percentages[3]['perOfPeeledOff']))print $this->percentages[3]['perOfPeeledOff']; ?></td>
  </tr>
  <tr>
    <td colspan="5" class="tableheader"> පණු කුහර හානි </td>
    <td id="3-print-slot-6-0"><?php if(isset($this->samples[2][0]['peeledOff'])) print($this->samples[2][0]['boreAttacked']) ?></td>
    <td id="3-print-slot-6-1"><?php if(isset($this->samples[2][1]['boreAttacked'])) print($this->samples[2][1]['boreAttacked']) ?></td>
    <td id="3-print-slot-6-2"><?php if(isset($this->samples[2][2]['boreAttacked'])) print($this->samples[2][2]['boreAttacked']) ?></td>
    <td id="3-print-slot-6-3"><?php if(isset($this->samples[2][3]['boreAttacked'])) print($this->samples[2][3]['boreAttacked']) ?></td>
    <td id="3-print-slot-6-4"><?php if(isset($this->samples[2][4]['boreAttacked'])) print($this->samples[2][4]['boreAttacked']) ?></td>
    <td id="3-print-slot-6-5"><?php if(isset($this->samples[2][5]['boreAttacked'])) print($this->samples[2][5]['boreAttacked']) ?></td>
    <td id="3-print-slot-6-6"><?php if(isset($this->samples[2][6]['boreAttacked'])) print($this->samples[2][6]['boreAttacked']) ?></td>
    <td id="3-print-slot-6-7"><?php if(isset($this->samples[2][7]['boreAttacked'])) print($this->samples[2][7]['boreAttacked']) ?></td>
    <td id="3-print-slot-6-8"><?php if(isset($this->samples[2][8]['boreAttacked'])) print($this->samples[2][8]['boreAttacked']) ?></td>
    <td id="3-print-slot-6-9"><?php if(isset($this->samples[2][9]['boreAttacked'])) print($this->samples[2][9]['boreAttacked']) ?></td>
    <td id="3-print-slot-6-10"><?php if(isset($this->samples[2][10]['boreAttacked'])) print($this->samples[2][10]['boreAttacked']) ?></td>
    <td id="3-print-slot-6-11"><?php if(isset($this->samples[2][11]['boreAttacked'])) print($this->samples[2][11]['boreAttacked']) ?></td>
    <td id="3-print-slot-6-12"><?php if(isset($this->samples[2][12]['boreAttacked'])) print($this->samples[2][12]['boreAttacked']) ?></td>
    <td id="3-print-slot-6-13"><?php if($this->gradeArray[2]!=0) print $this->gradeStock[$this->gradeArray[2]]['sumOfBoreAttacked']; ?></td>
    <td id="3-print-slot-6-14"><?php if(isset($this->percentages[2]['perOfBoreAttacked']))print $this->percentages[2]['perOfBoreAttacked']; ?></td>
    
    
   <td id="4-print-slot-6-0"><?php if(isset($this->samples[3][0]['peeledOff'])) print($this->samples[3][0]['boreAttacked']) ?></td>
    <td id="4-print-slot-6-1"><?php if(isset($this->samples[3][1]['boreAttacked'])) print($this->samples[3][1]['boreAttacked']) ?></td>
    <td id="4-print-slot-6-2"><?php if(isset($this->samples[3][2]['boreAttacked'])) print($this->samples[3][2]['boreAttacked']) ?></td>
    <td id="4-print-slot-6-3"><?php if(isset($this->samples[3][3]['boreAttacked'])) print($this->samples[3][3]['boreAttacked']) ?></td>
    <td id="4-print-slot-6-4"><?php if(isset($this->samples[3][4]['boreAttacked'])) print($this->samples[3][4]['boreAttacked']) ?></td>
    <td id="4-print-slot-6-5"><?php if(isset($this->samples[3][5]['boreAttacked'])) print($this->samples[3][5]['boreAttacked']) ?></td>
    <td id="4-print-slot-6-6"><?php if(isset($this->samples[3][6]['boreAttacked'])) print($this->samples[3][6]['boreAttacked']) ?></td>
    <td id="4-print-slot-6-7"><?php if(isset($this->samples[3][7]['boreAttacked'])) print($this->samples[3][7]['boreAttacked']) ?></td>
    <td id="4-print-slot-6-8"><?php if(isset($this->samples[3][8]['boreAttacked'])) print($this->samples[3][8]['boreAttacked']) ?></td>
    <td id="4-print-slot-6-9"><?php if(isset($this->samples[3][9]['boreAttacked'])) print($this->samples[3][9]['boreAttacked']) ?></td>
    <td id="4-print-slot-6-10"><?php if(isset($this->samples[3][10]['boreAttacked'])) print($this->samples[3][10]['boreAttacked']) ?></td>
    <td id="4-print-slot-6-11"><?php if(isset($this->samples[3][11]['boreAttacked'])) print($this->samples[3][11]['boreAttacked']) ?></td>
    <td id="4-print-slot-6-12"><?php if(isset($this->samples[3][12]['boreAttacked'])) print($this->samples[3][12]['boreAttacked']) ?></td>
    <td id="4-print-slot-6-13"><?php if($this->gradeArray[3]!=0) print $this->gradeStock[$this->gradeArray[3]]['sumOfBoreAttacked']; ?></td>
     <td id="4-print-slot-6-14"><?php if(isset($this->percentages[3]['perOfBoreAttacked']))print $this->percentages[3]['perOfBoreAttacked']; ?></td>
  </tr>
  <tr>
    <td colspan="5" class="tableheader"> වැලි සහිත </td>
<td id="3-print-slot-7-0"><?php if(isset($this->samples[2][0]['sandEmbedded'])) print($this->samples[2][0]['sandEmbedded']) ?></td>
    <td id="3-print-slot-7-1"><?php if(isset($this->samples[2][1]['sandEmbedded'])) print($this->samples[2][1]['sandEmbedded']) ?></td>
    <td id="3-print-slot-7-2"><?php if(isset($this->samples[2][2]['sandEmbedded'])) print($this->samples[2][2]['sandEmbedded']) ?></td>
    <td id="3-print-slot-7-3"><?php if(isset($this->samples[2][3]['sandEmbedded'])) print($this->samples[2][3]['sandEmbedded']) ?></td>
    <td id="3-print-slot-7-4"><?php if(isset($this->samples[2][4]['sandEmbedded'])) print($this->samples[2][4]['sandEmbedded']) ?></td>
    <td id="3-print-slot-7-5"><?php if(isset($this->samples[2][5]['sandEmbedded'])) print($this->samples[2][5]['sandEmbedded']) ?></td>
    <td id="3-print-slot-7-6"><?php if(isset($this->samples[2][6]['sandEmbedded'])) print($this->samples[2][6]['sandEmbedded']) ?></td>
    <td id="3-print-slot-7-7"><?php if(isset($this->samples[2][7]['sandEmbedded'])) print($this->samples[2][7]['sandEmbedded']) ?></td>
    <td id="3-print-slot-7-8"><?php if(isset($this->samples[2][8]['sandEmbedded'])) print($this->samples[2][8]['sandEmbedded']) ?></td>
    <td id="3-print-slot-7-9"><?php if(isset($this->samples[2][9]['sandEmbedded'])) print($this->samples[2][9]['sandEmbedded']) ?></td>
    <td id="3-print-slot-7-10"><?php if(isset($this->samples[2][10]['sandEmbedded'])) print($this->samples[2][10]['sandEmbedded']) ?></td>
    <td id="3-print-slot-7-11"><?php if(isset($this->samples[2][11]['sandEmbedded'])) print($this->samples[2][11]['sandEmbedded']) ?></td>
    <td id="3-print-slot-7-12"><?php if(isset($this->samples[2][12]['sandEmbedded'])) print($this->samples[2][12]['sandEmbedded']) ?></td>
    <td id="3-print-slot-7-13"><?php if($this->gradeArray[2]!=0) print $this->gradeStock[$this->gradeArray[2]]['sumOfSandEmbedded']; ?></td>
    <td id="3-print-slot-7-14"><?php if(isset($this->percentages[2]['perOfBoreAttacked']))print $this->percentages[2]['perOfBoreAttacked']; ?></td>
    
   <td id="4-print-slot-7-0"><?php if(isset($this->samples[3][0]['sandEmbedded'])) print($this->samples[3][0]['sandEmbedded']) ?></td>
    <td id="4-print-slot-7-1"><?php if(isset($this->samples[3][1]['sandEmbedded'])) print($this->samples[3][1]['sandEmbedded']) ?></td>
    <td id="4-print-slot-7-2"><?php if(isset($this->samples[3][2]['sandEmbedded'])) print($this->samples[3][2]['sandEmbedded']) ?></td>
    <td id="4-print-slot-7-3"><?php if(isset($this->samples[3][3]['sandEmbedded'])) print($this->samples[3][3]['sandEmbedded']) ?></td>
    <td id="4-print-slot-7-4"><?php if(isset($this->samples[3][4]['sandEmbedded'])) print($this->samples[3][4]['sandEmbedded']) ?></td>
    <td id="4-print-slot-7-5"><?php if(isset($this->samples[3][5]['sandEmbedded'])) print($this->samples[3][5]['sandEmbedded']) ?></td>
    <td id="4-print-slot-7-6"><?php if(isset($this->samples[3][6]['sandEmbedded'])) print($this->samples[3][6]['sandEmbedded']) ?></td>
    <td id="4-print-slot-7-7"><?php if(isset($this->samples[3][7]['sandEmbedded'])) print($this->samples[3][7]['sandEmbedded']) ?></td>
    <td id="4-print-slot-7-8"><?php if(isset($this->samples[3][8]['sandEmbedded'])) print($this->samples[3][8]['sandEmbedded']) ?></td>
    <td id="4-print-slot-7-9"><?php if(isset($this->samples[3][9]['sandEmbedded'])) print($this->samples[3][9]['sandEmbedded']) ?></td>
    <td id="4-print-slot-7-10"><?php if(isset($this->samples[3][10]['sandEmbedded'])) print($this->samples[3][10]['sandEmbedded']) ?></td>
    <td id="4-print-slot-7-11"><?php if(isset($this->samples[3][11]['sandEmbedded'])) print($this->samples[3][11]['sandEmbedded']) ?></td>
    <td id="4-print-slot-7-12"><?php if(isset($this->samples[3][12]['sandEmbedded'])) print($this->samples[3][12]['sandEmbedded']) ?></td>
    <td id="4-print-slot-7-13"><?php if($this->gradeArray[3]!=0) print $this->gradeStock[$this->gradeArray[3]]['sumOfSandEmbedded']; ?></td>
    <td id="4-print-slot-7-14"><?php if(isset($this->percentages[3]['perOfSandEmbedded']))print $this->percentages[3]['perOfSandEmbedded']; ?></td>
  </tr>
  <tr>
    <td colspan="5" class="tableheader"> හැකිළුණු ගෙඩි </td>
   <td id="3-print-slot-8-0"><?php if(isset($this->samples[2][0]['shrivelled'])) print($this->samples[2][0]['shrivelled']) ?></td>
    <td id="3-print-slot-8-1"><?php if(isset($this->samples[2][1]['shrivelled'])) print($this->samples[2][1]['shrivelled']) ?></td>
    <td id="3-print-slot-8-2"><?php if(isset($this->samples[2][2]['shrivelled'])) print($this->samples[2][2]['shrivelled']) ?></td>
    <td id="3-print-slot-8-3"><?php if(isset($this->samples[2][3]['shrivelled'])) print($this->samples[2][3]['shrivelled']) ?></td>
    <td id="3-print-slot-8-4"><?php if(isset($this->samples[2][4]['shrivelled'])) print($this->samples[2][4]['shrivelled']) ?></td>
    <td id="3-print-slot-8-5"><?php if(isset($this->samples[2][5]['shrivelled'])) print($this->samples[2][5]['shrivelled']) ?></td>
    <td id="3-print-slot-8-6"><?php if(isset($this->samples[2][6]['shrivelled'])) print($this->samples[2][6]['shrivelled']) ?></td>
    <td id="3-print-slot-8-7"><?php if(isset($this->samples[2][7]['shrivelled'])) print($this->samples[2][7]['shrivelled']) ?></td>
    <td id="3-print-slot-8-8"><?php if(isset($this->samples[2][8]['shrivelled'])) print($this->samples[2][8]['shrivelled']) ?></td>
    <td id="3-print-slot-8-9"><?php if(isset($this->samples[2][9]['shrivelled'])) print($this->samples[2][9]['shrivelled']) ?></td>
    <td id="3-print-slot-8-10"><?php if(isset($this->samples[2][10]['shrivelled'])) print($this->samples[2][10]['shrivelled']) ?></td>
    <td id="3-print-slot-8-11"><?php if(isset($this->samples[2][11]['shrivelled'])) print($this->samples[2][11]['shrivelled']) ?></td>
    <td id="3-print-slot-8-12"><?php if(isset($this->samples[2][12]['shrivelled'])) print($this->samples[2][12]['shrivelled']) ?></td>
    <td id="3-print-slot-8-13"><?php if($this->gradeArray[2]!=0) print $this->gradeStock[$this->gradeArray[2]]['sumOfShrivelled']; ?></td>
    <td id="3-print-slot-8-14"><?php if(isset($this->percentages[2]['perOfShrivelled']))print $this->percentages[2]['perOfShrivelled']; ?></td>
    
    <td id="4-print-slot-8-0"><?php if(isset($this->samples[3][0]['shrivelled'])) print($this->samples[3][0]['shrivelled']) ?></td>
    <td id="4-print-slot-8-1"><?php if(isset($this->samples[3][1]['shrivelled'])) print($this->samples[3][1]['shrivelled']) ?></td>
    <td id="4-print-slot-8-2"><?php if(isset($this->samples[3][2]['shrivelled'])) print($this->samples[3][2]['shrivelled']) ?></td>
    <td id="4-print-slot-8-3"><?php if(isset($this->samples[3][3]['shrivelled'])) print($this->samples[3][3]['shrivelled']) ?></td>
    <td id="4-print-slot-8-4"><?php if(isset($this->samples[3][4]['shrivelled'])) print($this->samples[3][4]['shrivelled']) ?></td>
    <td id="4-print-slot-8-5"><?php if(isset($this->samples[3][5]['shrivelled'])) print($this->samples[3][5]['shrivelled']) ?></td>
    <td id="4-print-slot-8-6"><?php if(isset($this->samples[3][6]['shrivelled'])) print($this->samples[3][6]['shrivelled']) ?></td>
    <td id="4-print-slot-8-7"><?php if(isset($this->samples[3][7]['shrivelled'])) print($this->samples[3][7]['shrivelled']) ?></td>
    <td id="4-print-slot-8-8"><?php if(isset($this->samples[3][8]['shrivelled'])) print($this->samples[3][8]['shrivelled']) ?></td>
    <td id="4-print-slot-8-9"><?php if(isset($this->samples[3][9]['shrivelled'])) print($this->samples[3][9]['shrivelled']) ?></td>
    <td id="4-print-slot-8-10"><?php if(isset($this->samples[3][10]['shrivelled'])) print($this->samples[3][10]['shrivelled']) ?></td>
    <td id="4-print-slot-8-11"><?php if(isset($this->samples[3][11]['shrivelled'])) print($this->samples[3][11]['shrivelled']) ?></td>
    <td id="4-print-slot-8-12"><?php if(isset($this->samples[3][12]['shrivelled'])) print($this->samples[3][12]['shrivelled']) ?></td>
    <td id="4-print-slot-8-13"><?php if($this->gradeArray[3]!=0) print $this->gradeStock[$this->gradeArray[3]]['sumOfShrivelled']; ?></td>
    <td id="4-print-slot-8-14"><?php if(isset($this->percentages[3]['perOfShrivelled']))print $this->percentages[3]['perOfShrivelled']; ?></td>
  </tr>
  <tr>
    <td rowspan="6" class="tableheader"><p>ප්‍රධාන නොවන දෝෂ</p>
      <p>(ගෙඩි ගණන)</p></td>
    <td colspan="5" class="tableheader"> හැඩය වෙනස් </td>
    <td id="3-print-slot-9-0"><?php if(isset($this->samples[2][0]['deformed'])) print($this->samples[2][0]['deformed']) ?></td>
    <td id="3-print-slot-9-1"><?php if(isset($this->samples[2][1]['deformed'])) print($this->samples[2][1]['deformed']) ?></td>
    <td id="3-print-slot-9-2"><?php if(isset($this->samples[2][2]['deformed'])) print($this->samples[2][2]['deformed']) ?></td>
    <td id="3-print-slot-9-3"><?php if(isset($this->samples[2][3]['deformed'])) print($this->samples[2][3]['deformed']) ?></td>
    <td id="3-print-slot-9-4"><?php if(isset($this->samples[2][4]['deformed'])) print($this->samples[2][4]['deformed']) ?></td>
    <td id="3-print-slot-9-5"><?php if(isset($this->samples[2][5]['deformed'])) print($this->samples[2][5]['deformed']) ?></td>
    <td id="3-print-slot-9-6"><?php if(isset($this->samples[2][6]['deformed'])) print($this->samples[2][6]['deformed']) ?></td>
    <td id="3-print-slot-9-7"><?php if(isset($this->samples[2][7]['deformed'])) print($this->samples[2][7]['deformed']) ?></td>
    <td id="3-print-slot-9-8"><?php if(isset($this->samples[2][8]['deformed'])) print($this->samples[2][8]['deformed']) ?></td>
    <td id="3-print-slot-9-9"><?php if(isset($this->samples[2][9]['deformed'])) print($this->samples[2][9]['deformed']) ?></td>
    <td id="3-print-slot-9-10"><?php if(isset($this->samples[2][10]['deformed'])) print($this->samples[2][10]['deformed']) ?></td>
    <td id="3-print-slot-9-11"><?php if(isset($this->samples[2][11]['deformed'])) print($this->samples[2][11]['deformed']) ?></td>
    <td id="3-print-slot-9-12"><?php if(isset($this->samples[2][12]['deformed'])) print($this->samples[2][12]['deformed']) ?></td>
    <td id="3-print-slot-9-13"><?php if($this->gradeArray[2]!=0) print $this->gradeStock[$this->gradeArray[2]]['sumOfDeformed']; ?></td>
     <td id="3-print-slot-9-14"><?php if(isset($this->percentages[2]['perOfDeformed']))print $this->percentages[2]['perOfDeformed']; ?></td>
     
    <td id="4-print-slot-9-0"><?php if(isset($this->samples[3][0]['deformed'])) print($this->samples[3][0]['deformed']) ?></td>
    <td id="4-print-slot-9-1"><?php if(isset($this->samples[3][1]['deformed'])) print($this->samples[3][1]['deformed']) ?></td>
    <td id="4-print-slot-9-2"><?php if(isset($this->samples[3][2]['deformed'])) print($this->samples[3][2]['deformed']) ?></td>
    <td id="4-print-slot-9-3"><?php if(isset($this->samples[3][3]['deformed'])) print($this->samples[3][3]['deformed']) ?></td>
    <td id="4-print-slot-9-4"><?php if(isset($this->samples[3][4]['deformed'])) print($this->samples[3][4]['deformed']) ?></td>
    <td id="4-print-slot-9-5"><?php if(isset($this->samples[3][5]['deformed'])) print($this->samples[3][5]['deformed']) ?></td>
    <td id="4-print-slot-9-6"><?php if(isset($this->samples[3][6]['deformed'])) print($this->samples[3][6]['deformed']) ?></td>
    <td id="4-print-slot-9-7"><?php if(isset($this->samples[3][7]['deformed'])) print($this->samples[3][7]['deformed']) ?></td>
    <td id="4-print-slot-9-8"><?php if(isset($this->samples[3][8]['deformed'])) print($this->samples[3][8]['deformed']) ?></td>
    <td id="4-print-slot-9-9"><?php if(isset($this->samples[3][9]['deformed'])) print($this->samples[3][9]['deformed']) ?></td>
    <td id="4-print-slot-9-10"><?php if(isset($this->samples[3][10]['deformed'])) print($this->samples[3][10]['deformed']) ?></td>
    <td id="4-print-slot-9-11"><?php if(isset($this->samples[3][11]['deformed'])) print($this->samples[3][11]['deformed']) ?></td>
    <td id="4-print-slot-9-12"><?php if(isset($this->samples[3][12]['deformed'])) print($this->samples[3][12]['deformed']) ?></td>
    <td id="4-print-slot-9-13"><?php if($this->gradeArray[3]!=0) print $this->gradeStock[$this->gradeArray[3]]['sumOfDeformed']; ?></td>
    <td id="4-print-slot-9-14"><?php if(isset($this->percentages[3]['perOfDeformed']))print $this->percentages[3]['perOfDeformed']; ?></td>
  </tr>
  <tr>
    <td colspan="5" class="tableheader"> වෛරස් ආසාදිත</td>
   <td id="3-print-slot-10-0"><?php if(isset($this->samples[2][0]['virusAttacked'])) print($this->samples[2][0]['virusAttacked']) ?></td>
    <td id="3-print-slot-10-1"><?php if(isset($this->samples[2][1]['virusAttacked'])) print($this->samples[2][1]['virusAttacked']) ?></td>
    <td id="3-print-slot-10-2"><?php if(isset($this->samples[2][2]['virusAttacked'])) print($this->samples[2][2]['virusAttacked']) ?></td>
    <td id="3-print-slot-10-3"><?php if(isset($this->samples[2][3]['virusAttacked'])) print($this->samples[2][3]['virusAttacked']) ?></td>
    <td id="3-print-slot-10-4"><?php if(isset($this->samples[2][4]['virusAttacked'])) print($this->samples[2][4]['virusAttacked']) ?></td>
    <td id="3-print-slot-10-5"><?php if(isset($this->samples[2][5]['virusAttacked'])) print($this->samples[2][5]['virusAttacked']) ?></td>
    <td id="3-print-slot-10-6"><?php if(isset($this->samples[2][6]['virusAttacked'])) print($this->samples[2][6]['virusAttacked']) ?></td>
    <td id="3-print-slot-10-7"><?php if(isset($this->samples[2][7]['virusAttacked'])) print($this->samples[2][7]['virusAttacked']) ?></td>
    <td id="3-print-slot-10-8"><?php if(isset($this->samples[2][8]['virusAttacked'])) print($this->samples[2][8]['virusAttacked']) ?></td>
    <td id="3-print-slot-10-9"><?php if(isset($this->samples[2][9]['virusAttacked'])) print($this->samples[2][9]['virusAttacked']) ?></td>
    <td id="3-print-slot-10-10"><?php if(isset($this->samples[2][10]['virusAttacked'])) print($this->samples[2][10]['virusAttacked']) ?></td>
    <td id="3-print-slot-10-11"><?php if(isset($this->samples[2][11]['virusAttacked'])) print($this->samples[2][11]['virusAttacked']) ?></td>
    <td id="3-print-slot-10-12"><?php if(isset($this->samples[2][12]['virusAttacked'])) print($this->samples[2][12]['virusAttacked']) ?></td>
   
    <td id="3-print-slot-10-13"><?php if($this->gradeArray[2]!=0) print $this->gradeStock[$this->gradeArray[2]]['sumOfVirusAttacked']; ?></td>
    <td id="3-print-slot-10-14"><?php if(isset($this->percentages[2]['perOfVirusAttacked']))print $this->percentages[2]['perOfVirusAttacked']; ?></td>
    
  <td id="4-print-slot-10-0"><?php if(isset($this->samples[3][0]['virusAttacked'])) print($this->samples[3][0]['virusAttacked']) ?></td>
    <td id="4-print-slot-10-1"><?php if(isset($this->samples[3][1]['virusAttacked'])) print($this->samples[3][1]['virusAttacked']) ?></td>
    <td id="4-print-slot-10-2"><?php if(isset($this->samples[3][2]['virusAttacked'])) print($this->samples[3][2]['virusAttacked']) ?></td>
    <td id="4-print-slot-10-3"><?php if(isset($this->samples[3][3]['virusAttacked'])) print($this->samples[3][3]['virusAttacked']) ?></td>
    <td id="4-print-slot-10-4"><?php if(isset($this->samples[3][4]['virusAttacked'])) print($this->samples[3][4]['virusAttacked']) ?></td>
    <td id="4-print-slot-10-5"><?php if(isset($this->samples[3][5]['virusAttacked'])) print($this->samples[3][5]['virusAttacked']) ?></td>
    <td id="4-print-slot-10-6"><?php if(isset($this->samples[3][6]['virusAttacked'])) print($this->samples[3][6]['virusAttacked']) ?></td>
    <td id="4-print-slot-10-7"><?php if(isset($this->samples[3][7]['virusAttacked'])) print($this->samples[3][7]['virusAttacked']) ?></td>
    <td id="4-print-slot-10-8"><?php if(isset($this->samples[3][8]['virusAttacked'])) print($this->samples[3][8]['virusAttacked']) ?></td>
    <td id="4-print-slot-10-9"><?php if(isset($this->samples[3][9]['virusAttacked'])) print($this->samples[3][9]['virusAttacked']) ?></td>
    <td id="4-print-slot-10-10"><?php if(isset($this->samples[3][10]['virusAttacked'])) print($this->samples[3][10]['virusAttacked']) ?></td>
    <td id="4-print-slot-10-11"><?php if(isset($this->samples[3][11]['virusAttacked'])) print($this->samples[3][11]['virusAttacked']) ?></td>
    <td id="4-print-slot-10-12"><?php if(isset($this->samples[3][12]['virusAttacked'])) print($this->samples[3][12]['virusAttacked']) ?></td>
    <td id="4-print-slot-10-13"><?php if($this->gradeArray[3]!=0) print $this->gradeStock[$this->gradeArray[3]]['sumOfVirusAttacked']; ?></td>
     <td id="4-print-slot-10-14"><?php if(isset($this->percentages[3]['perOfVirusAttacked']))print $this->percentages[3]['perOfVirusAttacked']; ?></td>
  </tr>
  <tr>
    <td colspan="5" class="tableheader"> යාන්ත්‍රික හානි </td>
    <td id="3-print-slot-11-0"><?php if(isset($this->samples[2][0]['mechanicalDamaged'])) print($this->samples[2][0]['mechanicalDamaged']) ?></td>
    <td id="3-print-slot-11-1"><?php if(isset($this->samples[2][1]['mechanicalDamaged'])) print($this->samples[2][1]['mechanicalDamaged']) ?></td>
    <td id="3-print-slot-11-2"><?php if(isset($this->samples[2][2]['mechanicalDamaged'])) print($this->samples[2][2]['mechanicalDamaged']) ?></td>
    <td id="3-print-slot-11-3"><?php if(isset($this->samples[2][3]['mechanicalDamaged'])) print($this->samples[2][3]['mechanicalDamaged']) ?></td>
    <td id="3-print-slot-11-4"><?php if(isset($this->samples[2][4]['mechanicalDamaged'])) print($this->samples[2][4]['mechanicalDamaged']) ?></td>
    <td id="3-print-slot-11-5"><?php if(isset($this->samples[2][5]['mechanicalDamaged'])) print($this->samples[2][5]['mechanicalDamaged']) ?></td>
    <td id="3-print-slot-11-6"><?php if(isset($this->samples[2][6]['mechanicalDamaged'])) print($this->samples[2][6]['mechanicalDamaged']) ?></td>
    <td id="3-print-slot-11-7"><?php if(isset($this->samples[2][7]['mechanicalDamaged'])) print($this->samples[2][7]['mechanicalDamaged']) ?></td>
    <td id="3-print-slot-11-8"><?php if(isset($this->samples[2][8]['mechanicalDamaged'])) print($this->samples[2][8]['mechanicalDamaged']) ?></td>
    <td id="3-print-slot-11-9"><?php if(isset($this->samples[2][9]['mechanicalDamaged'])) print($this->samples[2][9]['mechanicalDamaged']) ?></td>
    <td id="3-print-slot-11-10"><?php if(isset($this->samples[2][10]['mechanicalDamaged'])) print($this->samples[2][10]['mechanicalDamaged']) ?></td>
    <td id="3-print-slot-11-11"><?php if(isset($this->samples[2][11]['mechanicalDamaged'])) print($this->samples[2][11]['mechanicalDamaged']) ?></td>
    <td id="3-print-slot-11-12"><?php if(isset($this->samples[2][12]['mechanicalDamaged'])) print($this->samples[2][12]['mechanicalDamaged']) ?></td>
    
    <td id="3-print-slot-11-13"><?php if($this->gradeArray[2]!=0) print $this->gradeStock[$this->gradeArray[2]]['sumOfMechanicalDamaged']; ?></td>
    <td id="3-print-slot-11-14"><?php if(isset($this->percentages[2]['perOfMechanicalDamaged']))print $this->percentages[2]['perOfMechanicalDamaged']; ?></td>
    
    <td id="4-print-slot-11-0"><?php if(isset($this->samples[3][0]['mechanicalDamaged'])) print($this->samples[3][0]['mechanicalDamaged']) ?></td>
    <td id="4-print-slot-11-1"><?php if(isset($this->samples[3][1]['mechanicalDamaged'])) print($this->samples[3][1]['mechanicalDamaged']) ?></td>
    <td id="4-print-slot-11-2"><?php if(isset($this->samples[3][2]['mechanicalDamaged'])) print($this->samples[3][2]['mechanicalDamaged']) ?></td>
    <td id="4-print-slot-11-3"><?php if(isset($this->samples[3][3]['mechanicalDamaged'])) print($this->samples[3][3]['mechanicalDamaged']) ?></td>
    <td id="4-print-slot-11-4"><?php if(isset($this->samples[3][4]['mechanicalDamaged'])) print($this->samples[3][4]['mechanicalDamaged']) ?></td>
    <td id="4-print-slot-11-5"><?php if(isset($this->samples[3][5]['mechanicalDamaged'])) print($this->samples[3][5]['mechanicalDamaged']) ?></td>
    <td id="4-print-slot-11-6"><?php if(isset($this->samples[3][6]['mechanicalDamaged'])) print($this->samples[3][6]['mechanicalDamaged']) ?></td>
    <td id="4-print-slot-11-7"><?php if(isset($this->samples[3][7]['mechanicalDamaged'])) print($this->samples[3][7]['mechanicalDamaged']) ?></td>
    <td id="4-print-slot-11-8"><?php if(isset($this->samples[3][8]['mechanicalDamaged'])) print($this->samples[3][8]['mechanicalDamaged']) ?></td>
    <td id="4-print-slot-11-9"><?php if(isset($this->samples[3][9]['mechanicalDamaged'])) print($this->samples[3][9]['mechanicalDamaged']) ?></td>
    <td id="4-print-slot-11-10"><?php if(isset($this->samples[3][10]['mechanicalDamaged'])) print($this->samples[3][10]['mechanicalDamaged']) ?></td>
    <td id="4-print-slot-11-11"><?php if(isset($this->samples[3][11]['mechanicalDamaged'])) print($this->samples[3][11]['mechanicalDamaged']) ?></td>
    <td id="4-print-slot-11-12"><?php if(isset($this->samples[3][12]['mechanicalDamaged'])) print($this->samples[3][12]['mechanicalDamaged']) ?></td>
    <td id="4-print-slot-11-13"><?php if($this->gradeArray[3]!=0) print $this->gradeStock[$this->gradeArray[3]]['sumOfMechanicalDamaged']; ?></td>
    <td id="4-print-slot-11-14"><?php if(isset($this->percentages[3]['perOfMechanicalDamaged']))print $this->percentages[3]['perOfMechanicalDamaged']; ?></td>
  </tr>
  <tr>
    <td colspan="5" class="tableheader">කහ පැහැති ගෙඩි</td>
   <td id="3-print-slot-12-0"><?php if(isset($this->samples[2][0]['yellowish'])) print($this->samples[2][0]['yellowish']) ?></td>
    <td id="3-print-slot-12-1"><?php if(isset($this->samples[2][1]['yellowish'])) print($this->samples[2][1]['yellowish']) ?></td>
    <td id="3-print-slot-12-2"><?php if(isset($this->samples[2][2]['yellowish'])) print($this->samples[2][2]['yellowish']) ?></td>
    <td id="3-print-slot-12-3"><?php if(isset($this->samples[2][3]['yellowish'])) print($this->samples[2][3]['yellowish']) ?></td>
    <td id="3-print-slot-12-4"><?php if(isset($this->samples[2][4]['yellowish'])) print($this->samples[2][4]['yellowish']) ?></td>
    <td id="3-print-slot-12-5"><?php if(isset($this->samples[2][5]['yellowish'])) print($this->samples[2][5]['yellowish']) ?></td>
    <td id="3-print-slot-12-6"><?php if(isset($this->samples[2][6]['yellowish'])) print($this->samples[2][6]['yellowish']) ?></td>
    <td id="3-print-slot-12-7"><?php if(isset($this->samples[2][7]['yellowish'])) print($this->samples[2][7]['yellowish']) ?></td>
    <td id="3-print-slot-12-8"><?php if(isset($this->samples[2][8]['yellowish'])) print($this->samples[2][8]['yellowish']) ?></td>
    <td id="3-print-slot-12-9"><?php if(isset($this->samples[2][9]['yellowish'])) print($this->samples[2][9]['yellowish']) ?></td>
    <td id="3-print-slot-12-10"><?php if(isset($this->samples[2][10]['yellowish'])) print($this->samples[2][10]['yellowish']) ?></td>
    <td id="3-print-slot-12-11"><?php if(isset($this->samples[2][11]['yellowish'])) print($this->samples[2][11]['yellowish']) ?></td>
    <td id="3-print-slot-12-12"><?php if(isset($this->samples[2][12]['yellowish'])) print($this->samples[2][12]['yellowish']) ?></td>
    <td id="3-print-slot-12-13"><?php if($this->gradeArray[2]!=0) print $this->gradeStock[$this->gradeArray[2]]['sumOfYellowish']; ?></td>
    <td id="3-print-slot-12-14"><?php if(isset($this->percentages[2]['sumOfYellowish']))print $this->percentages[2]['sumOfYellowish']; ?></td>
    
   <td id="4-print-slot-12-0"><?php if(isset($this->samples[3][0]['yellowish'])) print($this->samples[3][0]['yellowish']) ?></td>
    <td id="4-print-slot-12-1"><?php if(isset($this->samples[3][1]['yellowish'])) print($this->samples[3][1]['yellowish']) ?></td>
    <td id="4-print-slot-12-2"><?php if(isset($this->samples[3][2]['yellowish'])) print($this->samples[3][2]['yellowish']) ?></td>
    <td id="4-print-slot-12-3"><?php if(isset($this->samples[3][3]['yellowish'])) print($this->samples[3][3]['yellowish']) ?></td>
    <td id="4-print-slot-12-4"><?php if(isset($this->samples[3][4]['yellowish'])) print($this->samples[3][4]['yellowish']) ?></td>
    <td id="4-print-slot-12-5"><?php if(isset($this->samples[3][5]['yellowish'])) print($this->samples[3][5]['yellowish']) ?></td>
    <td id="4-print-slot-12-6"><?php if(isset($this->samples[3][6]['yellowish'])) print($this->samples[3][6]['yellowish']) ?></td>
    <td id="4-print-slot-12-7"><?php if(isset($this->samples[3][7]['yellowish'])) print($this->samples[3][7]['yellowish']) ?></td>
    <td id="4-print-slot-12-8"><?php if(isset($this->samples[3][8]['yellowish'])) print($this->samples[3][8]['yellowish']) ?></td>
    <td id="4-print-slot-12-9"><?php if(isset($this->samples[3][9]['yellowish'])) print($this->samples[3][9]['yellowish']) ?></td>
    <td id="4-print-slot-12-10"><?php if(isset($this->samples[3][10]['yellowish'])) print($this->samples[3][10]['yellowish']) ?></td>
    <td id="4-print-slot-12-11"><?php if(isset($this->samples[3][11]['yellowish'])) print($this->samples[3][11]['yellowish']) ?></td>
    <td id="4-print-slot-12-12"><?php if(isset($this->samples[3][12]['yellowish'])) print($this->samples[3][12]['yellowish']) ?></td>
    <td id="4-print-slot-12-13"><?php if($this->gradeArray[3]!=0) print $this->gradeStock[$this->gradeArray[3]]['sumOfYellowish']; ?></td>
    <td id="4-print-slot-12-14"><?php if(isset($this->percentages[3]['perOfYellowish']))print $this->percentages[3]['perOfYellowish']; ?></td>
  </tr>
  <tr>
    <td colspan="5" class="tableheader">දුඹුරු පැල්ලම්</td>
    <td id="3-print-slot-13-0"><?php if(isset($this->samples[2][0]['rustPatches'])) print($this->samples[2][0]['rustPatches']) ?></td>
    <td id="3-print-slot-13-1"><?php if(isset($this->samples[2][1]['rustPatches'])) print($this->samples[2][1]['rustPatches']) ?></td>
    <td id="3-print-slot-13-2"><?php if(isset($this->samples[2][2]['rustPatches'])) print($this->samples[2][2]['rustPatches']) ?></td>
    <td id="3-print-slot-13-3"><?php if(isset($this->samples[2][3]['rustPatches'])) print($this->samples[2][3]['rustPatches']) ?></td>
    <td id="3-print-slot-13-4"><?php if(isset($this->samples[2][4]['rustPatches'])) print($this->samples[2][4]['rustPatches']) ?></td>
    <td id="3-print-slot-13-5"><?php if(isset($this->samples[2][5]['rustPatches'])) print($this->samples[2][5]['rustPatches']) ?></td>
    <td id="3-print-slot-13-6"><?php if(isset($this->samples[2][6]['rustPatches'])) print($this->samples[2][6]['rustPatches']) ?></td>
    <td id="3-print-slot-13-7"><?php if(isset($this->samples[2][7]['rustPatches'])) print($this->samples[2][7]['rustPatches']) ?></td>
    <td id="3-print-slot-13-8"><?php if(isset($this->samples[2][8]['rustPatches'])) print($this->samples[2][8]['rustPatches']) ?></td>
    <td id="3-print-slot-13-9"><?php if(isset($this->samples[2][9]['rustPatches'])) print($this->samples[2][9]['rustPatches']) ?></td>
    <td id="3-print-slot-13-10"><?php if(isset($this->samples[2][10]['rustPatches'])) print($this->samples[2][10]['rustPatches']) ?></td>
    <td id="3-print-slot-13-11"><?php if(isset($this->samples[2][11]['rustPatches'])) print($this->samples[2][11]['rustPatches']) ?></td>
    <td id="3-print-slot-13-12"><?php if(isset($this->samples[2][12]['rustPatches'])) print($this->samples[2][12]['rustPatches']) ?></td>
    <td id="3-print-slot-13-13"><?php if($this->gradeArray[2]!=0) print $this->gradeStock[$this->gradeArray[2]]['sumOfRustPatches']; ?></td>
    <td id="3-print-slot-13-14"><?php if(isset($this->percentages[2]['perOfRustPatches']))print $this->percentages[2]['perOfRustPatches']; ?></td>
    
    <td id="4-print-slot-13-0"><?php if(isset($this->samples[3][0]['rustPatches'])) print($this->samples[3][0]['rustPatches']) ?></td>
    <td id="4-print-slot-13-1"><?php if(isset($this->samples[3][1]['rustPatches'])) print($this->samples[3][1]['rustPatches']) ?></td>
    <td id="4-print-slot-13-2"><?php if(isset($this->samples[3][2]['rustPatches'])) print($this->samples[3][2]['rustPatches']) ?></td>
    <td id="4-print-slot-13-3"><?php if(isset($this->samples[3][3]['rustPatches'])) print($this->samples[3][3]['rustPatches']) ?></td>
    <td id="4-print-slot-13-4"><?php if(isset($this->samples[3][4]['rustPatches'])) print($this->samples[3][4]['rustPatches']) ?></td>
    <td id="4-print-slot-13-5"><?php if(isset($this->samples[3][5]['rustPatches'])) print($this->samples[3][5]['rustPatches']) ?></td>
    <td id="4-print-slot-13-6"><?php if(isset($this->samples[3][6]['rustPatches'])) print($this->samples[3][6]['rustPatches']) ?></td>
    <td id="4-print-slot-13-7"><?php if(isset($this->samples[3][7]['rustPatches'])) print($this->samples[3][7]['rustPatches']) ?></td>
    <td id="4-print-slot-13-8"><?php if(isset($this->samples[3][8]['rustPatches'])) print($this->samples[3][8]['rustPatches']) ?></td>
    <td id="4-print-slot-13-9"><?php if(isset($this->samples[3][9]['rustPatches'])) print($this->samples[3][9]['rustPatches']) ?></td>
    <td id="4-print-slot-13-10"><?php if(isset($this->samples[3][10]['rustPatches'])) print($this->samples[3][10]['rustPatches']) ?></td>
    <td id="4-print-slot-13-11"><?php if(isset($this->samples[3][11]['rustPatches'])) print($this->samples[3][11]['rustPatches']) ?></td>
    <td id="4-print-slot-13-12"><?php if(isset($this->samples[3][12]['rustPatches'])) print($this->samples[3][12]['rustPatches']) ?></td>
    <td id="4-print-slot-13-13"><?php if($this->gradeArray[3]!=0) print $this->gradeStock[$this->gradeArray[3]]['sumOfRustPatches']; ?></td>
    <td id="4-print-slot-13-14"><?php if(isset($this->percentages[3]['perOfRustPatches']))print $this->percentages[3]['perOfRustPatches']; ?></td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
    <td id="3-print-slot-14-0">&nbsp;</td>
    <td id="3-print-slot-14-1">&nbsp;</td>
    <td id="3-print-slot-14-2">&nbsp;</td>
    <td id="3-print-slot-14-3">&nbsp;</td>
    <td id="3-print-slot-14-4">&nbsp;</td>
    <td id="3-print-slot-14-5">&nbsp;</td>
    <td id="3-print-slot-14-6">&nbsp;</td>
    <td id="3-print-slot-14-7">&nbsp;</td>
    <td id="3-print-slot-14-8">&nbsp;</td>
    <td id="3-print-slot-14-9">&nbsp;</td>
    <td id="3-print-slot-14-10">&nbsp;</td>
    <td id="3-print-slot-14-11">&nbsp;</td>
    <td id="3-print-slot-14-12">&nbsp;</td>
    <td id="3-print-slot-14-13">&nbsp;</td>
   <td id="3-print-slot-14-14">&nbsp;</td>
   
    <td id="4-print-slot-14-0">&nbsp;</td>
    <td id="4-print-slot-14-1">&nbsp;</td>
    <td id="4-print-slot-14-2">&nbsp;</td>
    <td id="4-print-slot-14-3">&nbsp;</td>
    <td id="4-print-slot-14-4">&nbsp;</td>
    <td id="4-print-slot-14-5">&nbsp;</td>
    <td id="4-print-slot-14-6">&nbsp;</td>
    <td id="4-print-slot-14-7">&nbsp;</td>
    <td id="4-print-slot-14-8">&nbsp;</td>
    <td id="4-print-slot-14-9">&nbsp;</td>
    <td id="4-print-slot-14-10">&nbsp;</td>
    <td id="4-print-slot-14-11">&nbsp;</td>
    <td id="4-print-slot-14-12">&nbsp;</td>
    <td id="4-print-slot-14-13">&nbsp;</td>
     <td id="4-print-slot-14-14">&nbsp;</td>
  </tr>
  <tr>
   
    <td colspan="6" class="tableheader">පිළිගත්(AC)/නොපිළිගත්(RJ)</td>
     <td id="3-print-slot-15-0"><?php if(isset($this->samples[2][0]['accepted'])) print($this->samples[2][0]['accepted']) ?></td>
    <td id="3-print-slot-15-1"><?php if(isset($this->samples[2][1]['accepted'])) print($this->samples[2][1]['accepted']) ?></td>
    <td id="3-print-slot-15-2"><?php if(isset($this->samples[2][2]['accepted'])) print($this->samples[2][2]['accepted']) ?></td>
    <td id="3-print-slot-15-3"><?php if(isset($this->samples[2][3]['accepted'])) print($this->samples[2][3]['accepted']) ?></td>
    <td id="3-print-slot-15-4"><?php if(isset($this->samples[2][4]['accepted'])) print($this->samples[2][4]['accepted']) ?></td>
    <td id="3-print-slot-15-5"><?php if(isset($this->samples[2][5]['accepted'])) print($this->samples[2][5]['accepted']) ?></td>
    <td id="3-print-slot-15-6"><?php if(isset($this->samples[2][6]['accepted'])) print($this->samples[2][6]['accepted']) ?></td>
    <td id="3-print-slot-15-7"><?php if(isset($this->samples[2][7]['accepted'])) print($this->samples[2][7]['accepted']) ?></td>
    <td id="3-print-slot-15-8"><?php if(isset($this->samples[2][8]['accepted'])) print($this->samples[2][8]['accepted']) ?></td>
    <td id="3-print-slot-15-9"><?php if(isset($this->samples[2][9]['accepted'])) print($this->samples[2][9]['accepted']) ?></td>
    <td id="3-print-slot-15-10"><?php if(isset($this->samples[2][10]['accepted'])) print($this->samples[2][10]['accepted']) ?></td>
    <td id="3-print-slot-15-11"><?php if(isset($this->samples[2][11]['accepted'])) print($this->samples[2][11]['accepted']) ?></td>
    <td id="3-print-slot-15-12"><?php if(isset($this->samples[2][12]['accepted'])) print($this->samples[2][12]['accepted']) ?></td>
    <td id="3-print-slot-15-13"></td>
    <td id="3-print-slot-15-14">&nbsp;</td>
    
    
     <td id="4-print-slot-15-0"><?php if(isset($this->samples[3][0]['accepted'])) print($this->samples[3][0]['accepted']) ?></td>
    <td id="4-print-slot-15-1"><?php if(isset($this->samples[3][1]['accepted'])) print($this->samples[3][1]['accepted']) ?></td>
    <td id="4-print-slot-15-2"><?php if(isset($this->samples[3][2]['accepted'])) print($this->samples[3][2]['accepted']) ?></td>
    <td id="4-print-slot-15-3"><?php if(isset($this->samples[3][3]['accepted'])) print($this->samples[3][3]['accepted']) ?></td>
    <td id="4-print-slot-15-4"><?php if(isset($this->samples[3][4]['accepted'])) print($this->samples[3][4]['accepted']) ?></td>
    <td id="4-print-slot-15-5"><?php if(isset($this->samples[3][5]['accepted'])) print($this->samples[3][5]['accepted']) ?></td>
    <td id="4-print-slot-15-6"><?php if(isset($this->samples[3][6]['accepted'])) print($this->samples[3][6]['accepted']) ?></td>
    <td id="4-print-slot-15-7"><?php if(isset($this->samples[3][7]['accepted'])) print($this->samples[3][7]['accepted']) ?></td>
    <td id="4-print-slot-15-8"><?php if(isset($this->samples[3][8]['accepted'])) print($this->samples[3][8]['accepted']) ?></td>
    <td id="4-print-slot-15-9"><?php if(isset($this->samples[3][9]['accepted'])) print($this->samples[3][9]['accepted']) ?></td>
    <td id="4-print-slot-15-10"><?php if(isset($this->samples[3][10]['accepted'])) print($this->samples[3][10]['accepted']) ?></td>
    <td id="4-print-slot-15-11"><?php if(isset($this->samples[3][11]['accepted'])) print($this->samples[3][11]['accepted']) ?></td>
    <td id="4-print-slot-15-12"><?php if(isset($this->samples[3][12]['accepted'])) print($this->samples[3][12]['accepted']) ?></td>
    <td id="4-print-slot-15-13">&nbsp;</td>
    <td id="4-print-slot-15-14">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6">නරක් වු ගෙඩි</td>
     <td id="3-print-slot-16-0"><?php if(isset($this->samples[2][0]['spoiled'])) print($this->samples[2][0]['spoiled']) ?></td>
    <td id="3-print-slot-16-1"><?php if(isset($this->samples[2][1]['spoiled'])) print($this->samples[2][1]['spoiled']) ?></td>
    <td id="3-print-slot-16-2"><?php if(isset($this->samples[2][2]['spoiled'])) print($this->samples[2][2]['spoiled']) ?></td>
    <td id="3-print-slot-16-3"><?php if(isset($this->samples[2][3]['spoiled'])) print($this->samples[2][3]['spoiled']) ?></td>
    <td id="3-print-slot-16-4"><?php if(isset($this->samples[2][4]['spoiled'])) print($this->samples[2][4]['spoiled']) ?></td>
    <td id="3-print-slot-16-5"><?php if(isset($this->samples[2][5]['spoiled'])) print($this->samples[2][5]['spoiled']) ?></td>
    <td id="3-print-slot-16-6"><?php if(isset($this->samples[2][6]['spoiled'])) print($this->samples[2][6]['spoiled']) ?></td>
    <td id="3-print-slot-16-7"><?php if(isset($this->samples[2][7]['spoiled'])) print($this->samples[2][7]['spoiled']) ?></td>
    <td id="3-print-slot-16-8"><?php if(isset($this->samples[2][8]['spoiled'])) print($this->samples[2][8]['spoiled']) ?></td>
    <td id="3-print-slot-16-9"><?php if(isset($this->samples[2][9]['spoiled'])) print($this->samples[2][9]['spoiled']) ?></td>
    <td id="3-print-slot-16-10"><?php if(isset($this->samples[2][10]['spoiled'])) print($this->samples[2][10]['spoiled']) ?></td>
    <td id="3-print-slot-16-11"><?php if(isset($this->samples[2][11]['spoiled'])) print($this->samples[2][11]['spoiled']) ?></td>
    <td id="3-print-slot-16-12"><?php if(isset($this->samples[2][12]['spoiled'])) print($this->samples[2][12]['spoiled']) ?></td>
    <td id="3-print-slot-16-13"><?php if($this->gradeArray[2]!=0) print $this->gradeStock[$this->gradeArray[2]]['sumOfRotten']; ?></td>
    <td id="3-print-slot-16-14"><?php if(isset($this->percentages[2]['perOfRotten']))print $this->percentages[2]['perOfRotten']; ?></td>
    
    <td id="4-print-slot-16-0"><?php if(isset($this->samples[3][0]['spoiled'])) print($this->samples[3][0]['spoiled']) ?></td>
    <td id="4-print-slot-16-1"><?php if(isset($this->samples[3][1]['spoiled'])) print($this->samples[3][1]['spoiled']) ?></td>
    <td id="4-print-slot-16-2"><?php if(isset($this->samples[3][2]['spoiled'])) print($this->samples[3][2]['spoiled']) ?></td>
    <td id="4-print-slot-16-3"><?php if(isset($this->samples[3][3]['spoiled'])) print($this->samples[3][3]['spoiled']) ?></td>
    <td id="4-print-slot-16-4"><?php if(isset($this->samples[3][4]['spoiled'])) print($this->samples[3][4]['spoiled']) ?></td>
    <td id="4-print-slot-16-5"><?php if(isset($this->samples[3][5]['spoiled'])) print($this->samples[3][5]['spoiled']) ?></td>
    <td id="4-print-slot-16-6"><?php if(isset($this->samples[3][6]['spoiled'])) print($this->samples[3][6]['spoiled']) ?></td>
    <td id="4-print-slot-16-7"><?php if(isset($this->samples[3][7]['spoiled'])) print($this->samples[3][7]['spoiled']) ?></td>
    <td id="4-print-slot-16-8"><?php if(isset($this->samples[3][8]['spoiled'])) print($this->samples[3][8]['spoiled']) ?></td>
    <td id="4-print-slot-16-9"><?php if(isset($this->samples[3][9]['spoiled'])) print($this->samples[3][9]['spoiled']) ?></td>
    <td id="4-print-slot-16-10"><?php if(isset($this->samples[3][10]['spoiled'])) print($this->samples[3][10]['spoiled']) ?></td>
    <td id="4-print-slot-16-11"><?php if(isset($this->samples[3][11]['spoiled'])) print($this->samples[3][11]['spoiled']) ?></td>
    <td id="4-print-slot-16-12"><?php if(isset($this->samples[3][12]['spoiled'])) print($this->samples[3][12]['spoiled']) ?></td>
    
    <td id="4-print-slot-16-13"><?php if($this->gradeArray[3]!=0) print $this->gradeStock[$this->gradeArray[3]]['sumOfRotten']; ?></td>
    <td id="4-print-slot-16-14"><?php if(isset($this->percentages[3]['perOfRotten']))print $this->percentages[3]['perOfRotten']; ?></td>
  </tr>
  <tr>
    <td colspan="6" rowspan="7">&nbsp;</td>
    <td colspan="6" class="tableheader"> ක්‍රේට් ගණන </td>
    <td colspan="4" id="3-print-sum-noCrates"><?php if($this->gradeArray[2]!=0)print $this->gradeStock[$this->gradeArray[2]]['noOfCrates']; ?></td>
    <td colspan="5" rowspan="7">&nbsp;</td>
    <td colspan="6" class="tableheader"> ක්‍රේට් ගණන </td>
    <td colspan="4" id="4-print-sum-noCrates"><?php if($this->gradeArray[3]!=0)print $this->gradeStock[$this->gradeArray[3]]['noOfCrates']; ?></td>
    <td colspan="5" rowspan="7">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6" class="tableheader">ප්‍රකාශිත බර(kg)</td>
    <td colspan="4" id="3-print-sum-notedWeight"><?php if($this->gradeArray[2]!=0)print $this->gradeStock[$this->gradeArray[2]]['notedWeight']; ?></td>
    <td colspan="6" class="tableheader">ප්‍රකාශිත බර(kg)</td>
    <td colspan="4" id="4-print-sum-notedWeight"><?php if($this->gradeArray[3]!=0)print $this->gradeStock[$this->gradeArray[3]]['notedWeight']; ?></td>
    </tr>
  <tr>
    <td colspan="6" class="tableheader">තිබූ බර ප්‍රමාණය(kg)</td>
    <td colspan="4" id="3-print-sum-trueWeight"><?php if($this->gradeArray[2]!=0)print $this->gradeStock[$this->gradeArray[2]]['trueWeight']; ?></td>
    <td colspan="6" class="tableheader">තිබූ බර ප්‍රමාණය(kg)</td>
    <td colspan="4" id="4-print-sum-trueWeight"><?php if($this->gradeArray[3]!=0)print $this->gradeStock[$this->gradeArray[3]]['trueWeight']; ?></td>
    </tr>
  <tr>
    <td colspan="6" class="tableheader">&nbsp;</td>
    <td colspan="2" align="center">එකතුව</td>
    <td colspan="2" align="center">%</td>
    <td colspan="6" class="tableheader">&nbsp;</td>
    <td colspan="2" align="center">එකතුව</td>
    <td colspan="2" align="center">%</td>
    </tr>
  <tr>
    <td colspan="6" class="tableheader">වැරදි ශ්‍රේණිය</td>
    <td colspan="2" id="3-print-sum-defectGrade-sum"><?php if($this->gradeArray[2]!=0)print $this->gradeStock[$this->gradeArray[2]]['totalPerOfDefectGrade']; ?></td>
    <td colspan="2" id="3-print-sum-defectGrade-reduced"><?php if($this->gradeArray[2]!=0)print $this->gradeStock[$this->gradeArray[2]]['reducedPerOfDefectGrade']; ?></td>
    <td colspan="6" class="tableheader">වැරදි ශ්‍රේණිය</td>
    <td colspan="2" id="4-print-sum-defectGrade-sum"><?php if($this->gradeArray[3]!=0)print $this->gradeStock[$this->gradeArray[3]]['totalPerOfDefectGrade']; ?></td>
    <td colspan="2" id="4-print-sum-defectGrade-reduced"><?php if($this->gradeArray[3]!=0)print $this->gradeStock[$this->gradeArray[3]]['reducedPerOfDefectGrade']; ?></td>
    </tr>
  <tr>
    <td height="16" colspan="6" class="tableheader">දෝෂ </td>
    <td colspan="2" id="3-print-sum-defects-sum"><?php if($this->gradeArray[2]!=0)print $this->gradeStock[$this->gradeArray[2]]['totalPerOfDefect']; ?></td>
    <td colspan="2" id="3-print-sum-defects-reduced"><?php if($this->gradeArray[2]!=0)print $this->gradeStock[$this->gradeArray[2]]['reducedPerOfDefect']; ?></td>
    <td height="16" colspan="6" class="tableheader">දෝෂ </td>
    <td colspan="2" id="4-print-sum-defects-sum"><?php if($this->gradeArray[3]!=0)print $this->gradeStock[$this->gradeArray[3]]['totalPerOfDefect']; ?></td>
    <td colspan="2" id="4-print-sum-defects-reduced"><?php if($this->gradeArray[3]!=0)print $this->gradeStock[$this->gradeArray[3]]['reducedPerOfDefect']; ?></td>
    </tr>
  <tr>
    <td height="18" colspan="6"><span class="tableheader">ගෙවිය හැකි ප්‍රමාණය(kg) </span></td>
    <td colspan="2" id="3-print-sum-pq-sum"><?php if($this->gradeArray[2]!=0)print $this->gradeStock[$this->gradeArray[2]]['payableQuantity']; ?></td>
    <td colspan="2">&nbsp;</td>
    <td height="18" colspan="6"><span class="tableheader">ගෙවිය හැකි ප්‍රමාණය(kg) </span></td>
    <td colspan="2" id="4-print-sum-pq-sum"><?php if($this->gradeArray[3]!=0)print $this->gradeStock[$this->gradeArray[3]]['payableQuantity']; ?></td>
    <td colspan="2">&nbsp;</td>
    </tr>
 
 
</table>
  <table width="1078" height="152" border="1" cellpadding="0" cellspacing="0" style="font-size:12px">
      <tr>
        <td colspan="11">&nbsp;</td>
    </tr>
      <tr>
        <td width="183">ප්‍රවාහන තත්වය</td>
        <td width="53">විස්තරය</td>
        <td width="174">අවශ්‍ය තත්වය</td>
        <td width="13" rowspan="7">&nbsp;</td>
        <td width="88">මධ්‍යස්ථාන අංකය</td>
        <td width="71">මධ්‍යස්ථානය</td>
        <td width="77">TM අංකය</td>
        <td width="14" rowspan="7">&nbsp;</td>
        <td width="152">තොගයේ ප්‍රමාණය(crates/bags)</td>
        <td width="90">සාම්පලයේ ප්‍රමාණය</td>
        <td width="139">තිබිය හැකි උපරිම මට්ටම</td>
      </tr>
      <tr>
        <td>බාර දීම</td>
        <td><?php if($this->transportArray['handovering']==1)print "ඇත";else print "නැත";;?></td>
        <td>සවස 3.00ට පෙර</td>
        <td align="center">1</td>
        <td align="center"><?php if(isset($this->centers[0])) print $this->centers[0]['centerName']?></td>
        <td align="center"><?php if(isset($this->centers[0])) print $this->centers[0]['tmNo']?></td>
        <td align="center">2-90</td>
        <td align="center">5</td>
        <td align="center">1</td>
      </tr>
      <tr>
        <td>ලොරිය ආවරණය</td>
        <td><?php if($this->transportArray['lorryCovering']==1)print "ඇත";else print "නැත";?></td>
        <td>හොඳින් ආවරණය කර තිබිය යුතුයි</td>
        <td align="center">2</td>
        <td align="center"><?php if(isset($this->centers[1])) print $this->centers[1]['centerName']?></td>
        <td align="center"><?php if(isset($this->centers[1])) print $this->centers[1]['tmNo']?></td>
        <td align="center">91-150</td>
        <td align="center">8</td>
        <td align="center">2</td>
      </tr>
      <tr>
        <td>ලොරිය තුළ අනවශ්‍ය දුර්ගන්ධය</td>
        <td><?php if($this->transportArray['badSmell'])print "ඇත";else print "නැත";;?></td>
        <td>නොතිබිය යුතුයි</td>
        <td align="center">3</td>
        <td align="center"><?php if(isset($this->centers[2])) print $this->centers[2]['centerName']?></td>
        <td align="center"><?php if(isset($this->centers[2])) print $this->centers[2]['tmNo']?></td>
        <td align="center">151-500</td>
        <td align="center">13</td>
        <td align="center">3</td>
      </tr>
      <tr>
        <td>ගර්කින් හැර වෙනත් ද්‍රව්‍ය</td>
        <td><?php if($this->transportArray['otherGoods'])print "ඇත";else print "නැත";;?></td>
        <td>නොතිබිය යුතුයි</td>
        <td align="center">4</td>
        <td align="center"><?php if(isset($this->centers[3])) print $this->centers[3]['centerName']?></td>
        <td align="center"><?php if(isset($this->centers[3])) print $this->centers[3]['tmNo']?></td>
        <td colspan="3">තිබිය හැකි උපරිම වැරදි ශ්‍රේණි මට්ටම 10%</td>
      </tr>
      <tr>
        <td>ලේබල්/හඳුනාගැනීමේ වර්ණ සංකේත</td>
        <td><?php if($this->transportArray['labelling'])print "ඇත";else print "නැත";;?></td>
        <td>තිබිය යුතුයි</td>
        <td align="center">5</td>
        <td align="center"><?php if(isset($this->centers[4])) print $this->centers[4]['centerName']?></td>
        <td align="center"><?php if(isset($this->centers[4])) print $this->centers[4]['tmNo']?></td>
        <td colspan="3">තිබිය හැකි උපරිම දෝෂ මට්ටම 7% ( නරක් වූ ගෙඩි % හැර)</td>
      </tr>
      <tr>
        <td>තත්ව වාර්තාව</td>
        <td><?php if($this->transportArray['qualityReports'])print "ඇත";else print "නැත";;?></td>
        <td>තිබිය යුතුයි</td>
        <td align="center">6</td>
        <td align="center"><?php if(isset($this->centers[5])) print $this->centers[5]['centerName']?></td>
        <td align="center"><?php if(isset($this->centers[5])) print $this->centers[5]['tmNo']?></td>
        <td colspan="3">මුලු නරක් වූ % සම්පූර්ණ තොගයෙන් අඩු කරනු ලැබේ.</td>
      </tr>
  </table>
  <table width="1077" height="159" border="1" cellpadding="0" cellspacing="0" style="font-size:12px">
      <tr>
        <td colspan="5" height="2">&nbsp;</td>
      </tr>
      <tr>
        <td width="120" height="23"><span class="tableheader">ශ්‍රේණිය</span></td>
        <td width="112">අනුමත විශ්කම්භය(mm)</td>
        <td width="121">උප සාම්පලයේ ප්‍රමාණය</td>
        <td width="32" rowspan="8">&nbsp;</td>
        <td width="680" rowspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td height="20" align="center">80/160</td>
        <td align="center">14-17</td>
        <td align="center">1</td>
      </tr>
      <tr>
        <td align="center" height="20">20/80</td>
        <td align="center">17-29</td>
        <td align="center">2</td>
        <td align="left">නිගමනය : භාරගත හැක/ප්‍රතික්ශේපිත/කොටසක් ප්‍රතික්ශේපිත</td>
      </tr>
      <tr>
        <td height="20" align="center">5/20</td>
        <td align="center">29-44</td>
        <td align="center">7</td>
        <td align="left">වෙනත්:............................................................................................................................................................................................................</td>
      </tr>
      <tr>
        <td height="19" align="center">15/25(No.2)</td>
        <td align="center">24-30</td>
        <td align="center">5</td>
        <td align="left">පරීක්ෂා කළේ :........................................ නිරීක්ෂණය කළේ :............................................ අනුමත කළේ :..........................................</td>
      </tr>
      <tr>
        <td align="center" height="19">10/15(No.3)</td>
        <td align="center">30-42</td>
        <td align="center">5</td>
        <td align="center">&nbsp;</td>
      </tr>
      <tr>
        <td align="center" height="17">5/10(No.4)</td>
        <td align="center">42-45</td>
        <td align="center">8</td>
        <td rowspan="2" align="left">සටහන: ඉල් මැසි හානි අධික අවස්ථාවේදී එය නිෂ්පාදනය සඳහා යොදාගත නොහැකි බැවින් ,සම්පූර්ණ තොගය  සාම්පල් සැලැස්ම නොසලකා හරිමින් ප්‍රතික්ශේප කරනු ලැබේ.</td>
      </tr>
      <tr>
        <td align="center" height="17">CRS</td>
        <td align="center">16&lt;--&gt;44</td>
        <td align="center">5</td>
      </tr>
    </table>
<?php
     }
     
     
     
	
     function renderReport(){
     	
     	$this->setHeaderTable();
     	$this->setMainTable();
     	
     }
     
     function setToolBar(){
     	
     	?>
     	
     	<div id="toolbar">
     	
     	<h3 align="left">Gherkin Quality Report</h3>
        <ul><li id="print-button">
        <img src="images/Printer.png" alt="Print the Report" >
        </li>
        <li id="close-button">
        <img src="images/closebutton.png" alt="Close the Report">
        </li>
        </ul>



</div>
     	
     	
     	<?php 
     	
     }
}





?>
