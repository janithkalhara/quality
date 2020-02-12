<?php
ini_set('display_errors', 'Off');
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
	private $projectName;
	
	public function reportGenerator($date,$vehicleNo,$project){
		$this->date=$date;
		$this->date_f=$this->date." 00:00:00";
        $this->date_l=$this->date." 23:59:59";
		$this->project=$project;
		$this->vehicleNo=$vehicleNo;
		$this->db=new HDatabase();
		$this->db->connect();

		$p=new Project();
		$names=$p->getProjectNameById($this->project);
		$this->projectName=$names['areaName'];
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
		$dbo->resetResult();
		$dbo->select('qa_stock','*',"id='$this->project' AND vehicleNo='$this->vehicleNo' AND date>='$this->date_f' AND date<='$this->date_l'" );
		$res = $dbo->getResult();
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
		$dbo->select('qa_gradeStock','gradeId',"id='$this->project' AND  date>='$this->date_f' AND date<='$this->date_l' AND vehicleNo='$this->vehicleNo'");
		$res=$dbo->getResult();
		for($i=0;$i<count($res);$i++){
			
			$this->gradeArray[$i]=$res[$i]['gradeId'];
			
		}
		return true;
	}
	public function setGradeStock(){
		
		$dbo = new HDatabase();
		$dbo->connect();
		
		for($i=0;$i<count($this->gradeArray);$i++){
		  if($this->gradeArray[$i]!=0){
		  	$dbo->resetResult();
		  	$dbo->select('qa_gradeStock','*',"id='$this->project' AND  date>='$this->date_f' AND date<='$this->date_l' AND 
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
                        $this->gradeStock[$this->gradeArray[$i]]['sumOf45']=$temp['sumOf45'];
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
				$db->resetResult();
				$db->select('qa_sample','*',"date>='$this->date_f' AND id='$this->project' AND date<='$this->date_l' AND vehicleNo='".$this->vehicleNo."' AND gradeId=".$this->gradeArray[$i]."");
				
				$this->gradeSamples[$i]=$db->getResult();
				
				$db->resetResult();
			}
		}
	}
    
	public function getCenterData(){
		$db=new HDatabase();
		$db->connect();
		
		$db->select('qa_center_fakes','centerFakeId,centerName,TMno',"id='$this->project' AND  date>='$this->date_f' AND date<='$this->date_l' AND vehicleNo='$this->vehicleNo'");
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
				$this->samples[$i][$sampleId]['fruits45']=$this->gradeSamples[$i][$j]['fruits45'];
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
                    
                     $this->percentages[$i]['perOf45']= $this->gradeStock[$this->gradeArray[$i]]['sumOf45']/$divider; 
                    $this->percentages[$i]['perOf45']=round($this->percentages[$i]['perOf45']*100,2);
                 
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

	public function setHeaderTable(){ ?>
        <table width="870" border="1" id="headertable" cellpadding="0" cellspacing="0" style="font-size:10px;border-collapse:collapse">
            <tr>
            <td width="231" align="center"><b> HJS</b>  <b>Condiments Limited <br> 
            SunFrost (PVT) LTD<b></b></td>
            <td colspan="10" align="center"><b>ගර්කින් තත්ව පරීක්ෂණ වාර්තාව (Medium,Large and CRS Grades)</b> </td>
            <td>Issue No: 01 <br> Issue Date : 2011.09.03</td>
            </tr>
        </table>
        <table width="870" border="1" id="headertable" cellpadding="0" cellspacing="0" style="font-size:10px;border-collapse:collapse" >
	        <tr>
		        <td align="left" width="200" >ගෙඩි භාරගත් ස්ථානය <span style="font-weight:bold;float:right; padding-right:10px;"><?php print_r($this->getStation());?></span></td>
		        <td width="78" align="right">දිනය: &nbsp;&nbsp;</td>
		        <td width="80" id="print_date" align="center"><?php print $this->date;?> </td>
		        <td width="97" align="right">ව්‍යාපෘතිය : &nbsp;&nbsp;</td><td width="97" id="print-project" align="center"> <?php print "sdfjdfdjfhj";?></td>
		        <td width="115" align="right">වාහන අංකය :&nbsp;&nbsp; </td><td width="70" id="print-vehicle" align="center"><?php print $this->vehicleNo;?></td>
			</tr>
		</table>	
        <?php }
	public function setMainTable(){ ?>
	 	<table width="870" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse; font-size:10px">
    		<tr>
      			<td align="center" width="250"><strong>HJS</strong> <strong>Condiments Limited <br />SunFrost (PVT) LTD</strong></td>
      			<td  align="center" ><strong>ගර්කින් තත්ව පරීක්ෂණ වාර්තාව (Medium,Large and CRS Grades)</strong></td>
      			<td align="center">Issue No:01<br>Issue Date: 23.09.2011</td>
    		</tr>
  		</table>
  		<table width="870" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse; font-size:10px">
	    	<tr>
	    		<td width="225" height="20">ගෙඩි භාරගත් ස්ථානය<span style="position:relative;float:right;right:10px" id="stationName">
		  		<?php print_r($this->getStation()); ?></span>
	      		</td>
			      <td width="179"> දිනය :<span style="position:relative;float:right;right:10px" id="print_date"><?php print $this->date;?></span></td>
			      <td width="65"> ව්‍යාපෘතිය :  </td>
			      <td width="181" id="print-project"><?php print $this->projectName;?></td>
			      <td width="68"> වාහන අංකය : </td>
			      <td width="138" id="print-vehicle"><?php print $this->vehicleNo;?></td>
			</tr>
	  </table>
	  <table width="870" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse; font-size:10px">
		  <tr>
		    	<td colspan="7" width="160" >&nbsp;</td>
				<td colspan="2"> ශ්‍රේණිය </td>
				<td colspan="2" id="1-print-grade"><?php  if($this->gradeArray[0]!=0) print($this->getGradeName($this->gradeArray[0])) ; ?></td>
    <td colspan="2">&nbsp;</td>
    <td colspan="4"> අනුමත ගෙඩි ගණන </td>
    <td colspan="3" id="1-print-avgFruitCount"><?php if($this->gradeArray[0]!=0) print $this->gradeStock[$this->gradeArray[0]]['averageFruitCount']; ?></td>
    <td width="23"> එකතුව </td>
    <td width="23">%</td>
    <td rowspan="25" width="4">&nbsp;</td>
    <td colspan="2">ශ්‍රේණිය</td>
    <td colspan="2" id="2-print-grade"><?php if($this->gradeArray[1]!=0) print($this->getGradeName($this->gradeArray[1])) ;?></td>
    <td colspan="2"></td>
    <td colspan="4">අනුමත ගෙඩි ගණන</td>
    <td colspan="3" id="2-print-avgFruitCount"><?php if($this->gradeArray[1]!=0) print $this->gradeStock[$this->gradeArray[1]]['averageFruitCount']; ?></td>
    <td width="23">එකතුව</td>
    <td width="23">%</td>
		  </tr>
		  <tr>
    	<td colspan="7"> මධ්‍යස්ථාන අංකය </td>
    <?php
	for($i=0;$i<13;$i++){
		print "<td width='23'>";
		if(isset($this->samples[0][$i]['centerId']))print($this->samples[0][$i]['centerId']);
		print "</td >";
		}
   
	?>
    <td width="23">&nbsp;</td>
    <td width="23">&nbsp;</td>
    
    <?php
	for($i=0;$i<13;$i++){
		print "<td width='23'>";
		if(isset($this->samples[1][$i]['centerId']))print($this->samples[1][$i]['centerId']);
		print "</td >";
		}
   
	?>
   
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="7"> ගෙඩි ගණන </td>
    
    <?php
	for($i=0;$i<13;$i++){
		print "<td width='23'>";
		if(isset($this->samples[0][$i]['fruitCount']))print($this->samples[0][$i]['fruitCount']);
		print "</td >";
		}
   
	?>
    <td id="1-print-slot-1-13"><?php if($this->gradeArray[0]!=0) print $this->gradeStock[$this->gradeArray[0]]['fruitCount']; ?></td>
    <td>&nbsp;</td>
    
   <?php
	for($i=0;$i<13;$i++){
		print "<td width='23'>";
		if(isset($this->samples[1][$i]['fruitCount']))print($this->samples[1][$i]['fruitCount']);
		print "</td >";
		}
   
	?>
   <td ><?php if($this->gradeArray[1]!=0) print $this->gradeStock[$this->gradeArray[1]]['fruitCount']; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" rowspan="2"> වැරදි <br />
      ශ්‍රේණිය </td>
    <td colspan="4"> කුඩා ගෙඩි ගණන </td>
     <?php
	for($i=0;$i<13;$i++){
		print "<td width='23'>";
		if(isset($this->samples[0][$i]['smallFruit']))print($this->samples[0][$i]['smallFruit']);
		print "</td >";
		}
   
	?>
    <td><?php if($this->gradeArray[0]!=0) print $this->gradeStock[$this->gradeArray[0]]['sumOfSmallFruit']; ?></td>
    <td><?php if(isset($this->percentages[0]['perOfSmallFruit']))print $this->percentages[0]['perOfSmallFruit']; ?></td>
    
     <?php
	for($i=0;$i<13;$i++){
		print "<td width='23'>";
		if(isset($this->samples[1][$i]['smallFruit']))print($this->samples[1][$i]['smallFruit']);
		print "</td >";
		}
   
	?>
    
    <td><?php if($this->gradeArray[1]!=0) print $this->gradeStock[$this->gradeArray[1]]['sumOfSmallFruit']; ?></td>
    <td><?php if(isset($this->percentages[1]['perOfSmallFruit']))print $this->percentages[1]['perOfSmallFruit']; ?></td>
  </tr>
  <tr>
    <td colspan="4"> ලොකුගෙඩි ගණන </td>
     <?php
	for($i=0;$i<13;$i++){
		print "<td width='23'>";
		if(isset($this->samples[0][$i]['largeFruit']))print($this->samples[0][$i]['largeFruit']);
		print "</td >";
		}
   
	?>
   <td><?php if($this->gradeArray[0]!=0) print $this->gradeStock[$this->gradeArray[0]]['sumOfLargeFruit']; ?></td>
    <td><?php if(isset($this->percentages[0]['perOfLargeFruit']))print $this->percentages[0]['perOfLargeFruit']; ?></td>
   <!-- 2nd table-->
    <?php
	for($i=0;$i<13;$i++){
		print "<td width='23'>";
		if(isset($this->samples[1][$i]['largeFruit']))print($this->samples[1][$i]['largeFruit']);
		print "</td >";
		}
   
	?>
   
    <td><?php if($this->gradeArray[1]!=0) print $this->gradeStock[$this->gradeArray[1]]['sumOfLargeFruit']; ?></td>
    <td><?php if(isset($this->percentages[1]['perOfLargeFruit']))print $this->percentages[1]['perOfLargeFruit']; ?></td>
  </tr>
  <tr>
    <td colspan="3" rowspan="5"> ප්‍රධාන දෝෂ<br />
      (ගෙඩි ගණන) </td>
    <td colspan="4"> ඉල් මැසි හානි </td>
    <?php
	for($i=0;$i<13;$i++){
		print "<td width='23'>";
		if(isset($this->samples[0][$i]['flyAttacked']))print($this->samples[0][$i]['flyAttacked']);
		print "</td >";
		}
   
	?>
    
    <td><?php if($this->gradeArray[0]!=0) print $this->gradeStock[$this->gradeArray[0]]['sumOfFlyAttacked']; ?></td>
    <td><?php if(isset($this->percentages[0]['perOfFlyAttacked']))print $this->percentages[0]['perOfFlyAttacked']; ?></td>
    
    <?php
	for($i=0;$i<13;$i++){
		print "<td width='23'>";
		if(isset($this->samples[1][$i]['flyAttacked']))print($this->samples[1][$i]['flyAttacked']);
		print "</td >";
		}
   
	?>
  	<td><?php if($this->gradeArray[1]!=0) print $this->gradeStock[$this->gradeArray[1]]['sumOfFlyAttacked']; ?></td>
    <td><?php if(isset($this->percentages[1]['perOfFlyAttacked']))print $this->percentages[1]['perOfFlyAttacked']; ?></td>
  </tr>
  <tr>
    <td colspan="4"> පොතු ගැලවුණු </td>
     <?php
	for($i=0;$i<13;$i++){
		print "<td width='23'>";
		if(isset($this->samples[0][$i]['peeledOff']))print($this->samples[0][$i]['peeledOff']);
		print "</td >";
		}
   
	?>
  
    
    <td><?php if($this->gradeArray[0]!=0) print $this->gradeStock[$this->gradeArray[0]]['sumOfPeeledOff']; ?></td>
    <td><?php if(isset($this->percentages[0]['perOfPeeledOff']))print  $this->percentages[0]['perOfPeeledOff']; ?></td>
    <?php
	for($i=0;$i<13;$i++){
		print "<td width='23'>";
		if(isset($this->samples[1][$i]['peeledOff']))print($this->samples[1][$i]['peeledOff']);
		print "</td >";
		}
   
	?>
   
    
    <td><?php if($this->gradeArray[1]!=0) print $this->gradeStock[$this->gradeArray[1]]['sumOfPeeledOff']; ?></td>
    <td><?php if(isset($this->percentages[1]['perOfPeeledOff']))print  $this->percentages[1]['perOfPeeledOff']; ?></td>
  </tr>
  <tr>
    <td colspan="4"> පණු කුහර හානි </td>
     <?php
	for($i=0;$i<13;$i++){
		print "<td width='23'>";
		if(isset($this->samples[0][$i]['boreAttacked']))print($this->samples[0][$i]['boreAttacked']);
		print "</td >";
		}
   
	?>
    <td><?php if($this->gradeArray[0]!=0) print $this->gradeStock[$this->gradeArray[0]]['sumOfBoreAttacked']; ?></td>
    <td><?php if(isset($this->percentages[0]['perOfBoreAttacked']))print $this->percentages[0]['perOfBoreAttacked']; ?></td>
    <?php
	for($i=0;$i<13;$i++){
		print "<td width='23'>";
		if(isset($this->samples[1][$i]['boreAttacked']))print($this->samples[1][$i]['boreAttacked']);
		print "</td >";
		}
   
	?>
    
    
    <td><?php if($this->gradeArray[1]!=0) print $this->gradeStock[$this->gradeArray[1]]['sumOfBoreAttacked']; ?></td>
    <td><?php if(isset($this->percentages[1]['perOfBoreAttacked']))print $this->percentages[1]['perOfBoreAttacked']; ?></td>
  </tr>
  <tr>
    <td colspan="4"> වැලි සහිත </td>
    <?php
	for($i=0;$i<13;$i++){
		print "<td width='23'>";
		if(isset($this->samples[0][$i]['sandEmbedded']))print($this->samples[0][$i]['sandEmbedded']);
		print "</td >";
		}
   
	?>
    
   
    <td><?php if($this->gradeArray[0]!=0) print $this->gradeStock[$this->gradeArray[0]]['sumOfSandEmbedded']; ?></td>
    <td><?php if(isset($this->percentages[0]['perOfSandEmbedded']))print $this->percentages[0]['perOfSandEmbedded']; ?></td>
    
    <?php
	for($i=0;$i<13;$i++){
		print "<td width='23'>";
		if(isset($this->samples[1][$i]['sandEmbedded']))print($this->samples[1][$i]['sandEmbedded']);
		print "</td >";
		}
   
	?>
    <td><?php if($this->gradeArray[1]!=0) print $this->gradeStock[$this->gradeArray[1]]['sumOfSandEmbedded']; ?></td>
    <td><?php if(isset($this->percentages[1]['perOfSandEmbedded']))print $this->percentages[1]['perOfSandEmbedded']; ?></td>
  </tr>
  <tr>
    <td colspan="4"> හැකිළුණු ගෙඩි </td>
     <?php
	for($i=0;$i<13;$i++){
		print "<td width='23'>";
		if(isset($this->samples[0][$i]['shrivelled']))print($this->samples[0][$i]['shrivelled']);
		print "</td >";
		}
   
	?>
   
    
    <td><?php if($this->gradeArray[0]!=0) print $this->gradeStock[$this->gradeArray[0]]['sumOfShrivelled']; ?></td>
    <td><?php if(isset($this->percentages[0]['perOfShrivelled']))print $this->percentages[0]['perOfShrivelled']; ?></td>
     <?php
	for($i=0;$i<13;$i++){
		print "<td width='23'>";
		if(isset($this->samples[1][$i]['shrivelled']))print($this->samples[1][$i]['shrivelled']);
		print "</td >";
		}
   
	?>
    
    
    <td><?php if($this->gradeArray[1]!=0) print $this->gradeStock[$this->gradeArray[1]]['sumOfShrivelled']; ?></td>
    <td><?php if(isset($this->percentages[1]['perOfShrivelled']))print $this->percentages[1]['perOfShrivelled']; ?></td>
  </tr>
  <tr>
    <td colspan="3" rowspan="6"> ප්‍රධාන නොවන <br />
      දෝෂ<br />
      (ගෙඩි ගණන) </td>
    <td colspan="4"> හැඩය වෙනස් </td>
     <?php
	for($i=0;$i<13;$i++){
		print "<td width='23'>";
		if(isset($this->samples[0][$i]['deformed']))print($this->samples[0][$i]['deformed']);
		print "</td >";
		}
   
	?>
    
   
    <td><?php if($this->gradeArray[0]!=0) print $this->gradeStock[$this->gradeArray[0]]['sumOfDeformed']; ?></td>
    <td><?php if(isset($this->percentages[0]['perOfDeformed']))print $this->percentages[0]['perOfDeformed']; ?></td>
   <?php
	for($i=0;$i<13;$i++){
		print "<td width='23'>";
		if(isset($this->samples[1][$i]['deformed']))print($this->samples[1][$i]['deformed']);
		print "</td >";
		}
   
	?>
       
    <td><?php if($this->gradeArray[1]!=0) print $this->gradeStock[$this->gradeArray[1]]['sumOfDeformed']; ?></td>
    <td><?php if(isset($this->percentages[1]['perOfDeformed']))print $this->percentages[1]['perOfDeformed']; ?></td>
  </tr>
  <tr>
    <td colspan="4"> වෛරස් ආසාදිත </td>
     <?php
	for($i=0;$i<13;$i++){
		print "<td width='23'>";
		if(isset($this->samples[0][$i]['virusAttacked']))print($this->samples[0][$i]['virusAttacked']);
		print "</td >";
		}
   
	?>
   
    
    <td><?php if($this->gradeArray[0]!=0) print $this->gradeStock[$this->gradeArray[0]]['sumOfVirusAttacked']; ?></td>
    <td><?php if(isset($this->percentages[0]['perOfVirusAttacked']))print $this->percentages[0]['perOfVirusAttacked']; ?></td>
     <?php
	for($i=0;$i<13;$i++){
		print "<td width='23'>";
		if(isset($this->samples[1][$i]['virusAttacked']))print($this->samples[1][$i]['virusAttacked']);
		print "</td >";
		}
   
	?>
   
    <td><?php if($this->gradeArray[1]!=0) print $this->gradeStock[$this->gradeArray[1]]['sumOfVirusAttacked']; ?></td>
    <td><?php if(isset($this->percentages[1]['perOfVirusAttacked']))print $this->percentages[1]['perOfVirusAttacked']; ?></td>
  </tr>
  <tr>
    <td colspan="4"> යාන්ත්‍රික හානි </td>
    
    <?php
	for($i=0;$i<13;$i++){
		print "<td width='23'>";
		if(isset($this->samples[0][$i]['mechanicalDamaged']))print($this->samples[0][$i]['mechanicalDamaged']);
		print "</td >";
		}
   
	?>
       
    <td><?php if($this->gradeArray[0]!=0) print $this->gradeStock[$this->gradeArray[0]]['sumOfMechanicalDamaged']; ?></td>
    <td><?php if(isset($this->percentages[0]['perOfMechanicalDamaged']))print $this->percentages[0]['perOfMechanicalDamaged']; ?></td>
     <?php
	for($i=0;$i<13;$i++){
		print "<td width='23'>";
		if(isset($this->samples[1][$i]['mechanicalDamaged']))print($this->samples[1][$i]['mechanicalDamaged']);
		print "</td >";
		}
   
	?>
   
    
    <td><?php if($this->gradeArray[1]!=0) print $this->gradeStock[$this->gradeArray[1]]['sumOfMechanicalDamaged']; ?></td>
    <td><?php if(isset($this->percentages[1]['perOfMechanicalDamaged']))print $this->percentages[1]['perOfMechanicalDamaged']; ?></td>
  </tr>
  <tr>
    <td colspan="4"> කහ පැහැති ගෙඩි </td>
     <?php
	for($i=0;$i<13;$i++){
		print "<td width='23'>";
		if(isset($this->samples[0][$i]['yellowish']))print($this->samples[0][$i]['yellowish']);
		print "</td >";
		}
   
	?>
    
    <td><?php if($this->gradeArray[0]!=0) print $this->gradeStock[$this->gradeArray[0]]['sumOfYellowish']; ?></td>
    <td><?php if(isset($this->percentages[0]['perOfYellowish']))print $this->percentages[0]['perOfYellowish']; ?></td>
    <?php
	for($i=0;$i<13;$i++){
		print "<td width='23'>";
		if(isset($this->samples[1][$i]['yellowish']))print($this->samples[1][$i]['yellowish']);
		print "</td >";
		}
   
	?>
    
    <td><?php if($this->gradeArray[1]!=0) print $this->gradeStock[$this->gradeArray[1]]['sumOfYellowish']; ?></td>
    <td><?php if(isset($this->percentages[1]['perOfYellowish']))print $this->percentages[1]['perOfYellowish']; ?></td>
    
   
  </tr>
  <tr>
    <td colspan="4"> දුඹුරු පැල්ලම් </td>
   <?php
	for($i=0;$i<13;$i++){
		print "<td width='23'>";
		if(isset($this->samples[0][$i]['rustPatches']))print($this->samples[0][$i]['rustPatches']);
		print "</td >";
		}
   
	?>
    
    <td><?php if($this->gradeArray[0]!=0) print $this->gradeStock[$this->gradeArray[0]]['sumOfRustPatches']; ?></td>
    <td><?php if(isset($this->percentages[0]['perOfRustPatches']))print $this->percentages[0]['perOfRustPatches']; ?></td>
    <?php
	for($i=0;$i<13;$i++){
		print "<td width='23'>";
		if(isset($this->samples[1][$i]['rustPatches']))print($this->samples[1][$i]['rustPatches']);
		print "</td >";
		}
   
	?>
    
    <td><?php if($this->gradeArray[1]!=0) print $this->gradeStock[$this->gradeArray[1]]['sumOfRustPatches']; ?></td>
    <td><?php if(isset($this->percentages[1]['perOfRustPatches']))print $this->percentages[1]['perOfRustPatches']; ?></td>
    
  </tr>
  <tr>
    
      <td colspan="4">45mmට වැඩි</td>
     <?php
    for($i=0;$i<13;$i++){
        print "<td width='23'>";
        if(isset($this->samples[0][$i]['fruits45']))print($this->samples[0][$i]['fruits45']);
        print "</td >";
        }
   
    ?>
    
    <td><?php if($this->gradeArray[0]!=0) print $this->gradeStock[$this->gradeArray[0]]['sumOf45']; ?></td>
    <td><?php if(isset($this->percentages[0]['perOf45']))print $this->percentages[0]['perOf45']; ?></td>
    <?php 
    for($i=0;$i<13;$i++){
        print "<td width='23'>";
        if(isset($this->samples[1][$i]['fruits45']))print($this->samples[1][$i]['fruits45']);
        print "</td >";
        }
   
    ?>
    
    
    <td><?php if($this->gradeArray[1]!=0) print $this->gradeStock[$this->gradeArray[1]]['sumOf45']; ?></td>
    <td><?php if(isset($this->percentages[1]['perOf45']))print $this->percentages[1]['perOf45']; ?></td>
  </tr>
  <tr>
    <td colspan="7"> පිළිගත් (AC)/නොපිළිගත්(RJ) </td>
     <?php
	for($i=0;$i<13;$i++){
		print "<td width='23'>";
		if(isset($this->samples[0][$i]['accepted']))print($this->samples[0][$i]['accepted']);
		print "</td >";
		}
   
	?>
    
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <?php
	for($i=0;$i<13;$i++){
		print "<td width='23'>";
		if(isset($this->samples[1][$i]['accepted']))print($this->samples[1][$i]['accepted']);
		print "</td >";
		}
   
	?>
    
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    
  </tr>
  <tr>
    <td colspan="7"> නරක් වු ගෙඩි </td><?php
	for($i=0;$i<13;$i++){
		print "<td width='23'>";
		if(isset($this->samples[0][$i]['spoiled']))print($this->samples[0][$i]['spoiled']);
		print "</td >";
		}
   
	?>
    
    <td><?php if($this->gradeArray[0]!=0) print $this->gradeStock[$this->gradeArray[0]]['sumOfRotten']; ?></td>
    <td><?php if(isset($this->percentages[0]['perOfRotten']))print $this->percentages[0]['perOfRotten']; ?></td>
    <?php
	for($i=0;$i<13;$i++){
		print "<td width='23'>";
		if(isset($this->samples[1][$i]['spoiled']))print($this->samples[1][$i]['spoiled']);
		print "</td >";
		}
   
	?>
    
    <td><?php if($this->gradeArray[1]!=0) print $this->gradeStock[$this->gradeArray[1]]['sumOfRotten']; ?></td>
    <td><?php if(isset($this->percentages[1]['perOfRotten']))print $this->percentages[1]['perOfRotten']; ?></td>
  </tr>
  <tr>
    <td colspan="7" rowspan="7">&nbsp;</td>
    <td colspan="6"> ක්‍රේට් ගණන </td>
    <td colspan="4"><?php 
    if($this->gradeStock[$this->gradeArray[0]]['noOfCrates']){
        $a = explode('/',  $this->gradeStock[$this->gradeArray[0]]['noOfCrates']);
      $str0="";
      if(isset($a[1]) && $a[1]){
        $crates0=$a[1];
        $str0.=$crates0."(Crates)/";
      }
      if(isset($a[0]) && $a[0]){
        $bags0=$a[0];
        $str0.=$bags0."(Bags)";
      } 
      echo  $str0;
    }
   // print $this->gradeStock[$this->gradeArray[0]]['noOfCrates']; ?></td>
    <td colspan="5" rowspan="7">&nbsp;</td>
    <td colspan="6">ක්‍රේට් ගණන </td>
    <td colspan="4"><?php 
    if($this->gradeStock[$this->gradeArray[1]]['noOfCrates']){
    	 $b=explode('/',  $this->gradeStock[$this->gradeArray[1]]['noOfCrates']);
      $str1="";
      if(isset($b[1]) && $b[1]){
        $crates1 = $b[1];
        $str1 .= $crates1."(Crates)/";
        
      }
      if(isset($b[0]) && $b[0]){
        $bags1 = $b[0];
        $str1 .= $bags1."(Bags)";
      } 
      echo  $str1;
    }
    
  //  print $this->gradeStock[$this->gradeArray[1]]['noOfCrates']; ?></td>
    <td colspan="5" rowspan="7">&nbsp;</td>
    </tr>
  <tr>
    <td colspan="6"> ප්‍රකාශිත බර(kg) </td>
    <td colspan="4"><?php if($this->gradeArray[0]!=0)print $this->gradeStock[$this->gradeArray[0]]['notedWeight']; ?></td>
    <td colspan="6">ප්‍රකාශිත බර(kg) </td>
    <td colspan="4"><?php if($this->gradeArray[1]!=0)print $this->gradeStock[$this->gradeArray[1]]['notedWeight']; ?></td>
    </tr>
  <tr>
    <td colspan="6"> තිබූ බර ප්‍රමාණය(kg) </td>
    <td colspan="4"><?php if($this->gradeArray[0]!=0)print $this->gradeStock[$this->gradeArray[0]]['trueWeight']; ?></td>
    <td colspan="6">තිබූ බර ප්‍රමාණය(kg) </td>
    <td colspan="4"><?php if($this->gradeArray[1]!=0)print $this->gradeStock[$this->gradeArray[1]]['trueWeight']; ?></td>
    </tr>
  <tr>
    <td colspan="6">&nbsp;</td>
    <td colspan="2" align="center"> එකතුව </td>
    <td colspan="2" align="center">අඩු කල %</td>
    <td colspan="6">&nbsp;</td>
    <td colspan="2" align="center"> එකතුව </td>
    <td colspan="2" align="center">අඩු කල %</td>
    </tr>
  <tr>
    <td colspan="6"> වැරදි ශ්‍රේණිය </td>
    <td colspan="2"><?php if($this->gradeArray[0]!=0)print $this->gradeStock[$this->gradeArray[0]]['totalPerOfDefectGrade']; ?></td>
    <td colspan="2"><?php if($this->gradeArray[0]!=0)print $this->gradeStock[$this->gradeArray[0]]['reducedPerOfDefectGrade']; ?></td>
    <td colspan="6">වැරදි ශ්‍රේණිය </td>
    <td colspan="2"><?php if($this->gradeArray[1]!=0)print $this->gradeStock[$this->gradeArray[1]]['totalPerOfDefectGrade']; ?></td>
    <td colspan="2"><?php if($this->gradeArray[1]!=0)print $this->gradeStock[$this->gradeArray[1]]['reducedPerOfDefectGrade']; ?></td>
    </tr>
  <tr>
    <td colspan="6"> දෝෂ </td>
    <td colspan="2"><?php if($this->gradeArray[0]!=0)print $this->gradeStock[$this->gradeArray[0]]['totalPerOfDefect']; ?></td>
    <td colspan="2"><?php if($this->gradeArray[0]!=0)print $this->gradeStock[$this->gradeArray[0]]['reducedPerOfDefect']; ?></td>
    <td colspan="6">දෝෂ </td>
    <td colspan="2"><?php if($this->gradeArray[1]!=0)print $this->gradeStock[$this->gradeArray[1]]['totalPerOfDefect']; ?></td>
    <td colspan="2"><?php if($this->gradeArray[1]!=0)print $this->gradeStock[$this->gradeArray[1]]['reducedPerOfDefect']; ?></td>
    </tr>
  <tr>
    <td colspan="6"> ගෙවිය හැකි ප්‍රමාණය(kg) </td>
    <td colspan="2"><?php if($this->gradeArray[0]!=0)print $this->gradeStock[$this->gradeArray[0]]['payableQuantity']; ?></td>
    <td colspan="2">&nbsp;</td>
    <td colspan="6">ගෙවිය හැකි ප්‍රමාණය(kg) </td>
    <td colspan="2"><?php if($this->gradeArray[1]!=0)print $this->gradeStock[$this->gradeArray[1]]['payableQuantity']; ?></td>
    <td colspan="2">&nbsp;</td>
    </tr>
</table>
  <table width="870" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse; font-size:10px">
  <tr>
    <td colspan="7" width="160" >&nbsp;</td>
    <td colspan="2"> ශ්‍රේණිය </td>
    <td colspan="2"><?php if($this->gradeArray[2]!=0) print($this->getGradeName($this->gradeArray[2])) ;?></td>
    <td colspan="2">&nbsp;</td>
    <td colspan="4"> අනුමත ගෙඩි ගණන </td>
    <td colspan="3"><?php if($this->gradeArray[2]!=0)print $this->gradeStock[$this->gradeArray[2]]['averageFruitCount']; ?></td>
    <td width="23"> එකතුව </td>
    <td width="23">%</td>
    <td rowspan="25" width="4">&nbsp;</td>
    <td colspan="2">ශ්‍රේණිය</td>
    <td colspan="2"><?php if($this->gradeArray[3]!=0) print($this->getGradeName($this->gradeArray[3])) ;?></td>
    <td colspan="2">&nbsp;</td>
    <td colspan="4">අනුමත ගෙඩි ගණන</td>
    <td colspan="3"><?php if($this->gradeArray[3]!=0)print $this->gradeStock[$this->gradeArray[3]]['averageFruitCount']; ?></td>
    <td width="23">එකතුව</td>
    <td width="23">%</td>
  </tr>
  <tr>
    <td colspan="7"> මධ්‍යස්ථාන අංකය </td>
    <?php
	for($i=0;$i<13;$i++){
		print "<td width='23'>";
		if(isset($this->samples[2][$i]['centerId']))print($this->samples[2][$i]['centerId']);
		print "</td >";
		}
   
	?>
   
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <?php
	for($i=0;$i<13;$i++){
		print "<td width='23'>";
		if(isset($this->samples[3][$i]['centerId']))print($this->samples[3][$i]['centerId']);
		print "</td >";
		}
   
	?>
    
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="7"> ගෙඩි ගණන </td>
     <?php
	for($i=0;$i<13;$i++){
		print "<td width='23'>";
		if(isset($this->samples[2][$i]['fruitCount']))print($this->samples[2][$i]['fruitCount']);
		print "</td >";
		}
   
	?>
    <td ><?php if($this->gradeArray[2]!=0) print $this->gradeStock[$this->gradeArray[2]]['fruitCount']; ?></td>
    <td>&nbsp;</td>
    
   <?php
	for($i=0;$i<13;$i++){
		print "<td width='23'>";
		if(isset($this->samples[3][$i]['fruitCount']))print($this->samples[3][$i]['fruitCount']);
		print "</td >";
		}
   
	?>
   <td ><?php if($this->gradeArray[3]!=0) print $this->gradeStock[$this->gradeArray[3]]['fruitCount']; ?></td>
    <td>&nbsp;</td>
    
    
  </tr>
  <tr>
    <td colspan="3" rowspan="2"> වැරදි <br />
      ශ්‍රේණිය </td>
    <td colspan="4"> කුඩා ගෙඩි ගණන </td>
    
     <?php
	for($i=0;$i<13;$i++){
		print "<td width='23'>";
		if(isset($this->samples[2][$i]['smallFruit']))print($this->samples[2][$i]['smallFruit']);
		print "</td >";
		}
   
	?>
   
    <td><?php if($this->gradeArray[2]!=0) print $this->gradeStock[$this->gradeArray[2]]['sumOfSmallFruit']; ?></td>
    <td><?php if(isset($this->percentages[2]['perOfSmallFruit']))print $this->percentages[2]['perOfSmallFruit']; ?></td>
    
       <?php
	for($i=0;$i<13;$i++){
		print "<td width='23'>";
		if(isset($this->samples[3][$i]['smallFruit']))print($this->samples[3][$i]['smallFruit']);
		print "</td >";
		}
   
	?>
    
    
    <td><?php if($this->gradeArray[3]!=0) print $this->gradeStock[$this->gradeArray[3]]['sumOfSmallFruit']; ?></td>
    <td><?php if(isset($this->percentages[3]['perOfSmallFruit']))print $this->percentages[3]['perOfSmallFruit']; ?></td>
  </tr>
  <tr>
    <td colspan="4"> ලොකුගෙඩි ගණන </td>    <?php
	for($i=0;$i<13;$i++){
		print "<td width='23'>";
		if(isset($this->samples[2][$i]['largeFruit']))print($this->samples[2][$i]['largeFruit']);
		print "</td >";
		}
   
	?>
   
    <td><?php if($this->gradeArray[2]!=0) print $this->gradeStock[$this->gradeArray[2]]['sumOfLargeFruit']; ?></td>
    <td><?php if(isset($this->percentages[2]['perOfLargeFruit']))print $this->percentages[2]['perOfLargeFruit']; ?></td>
    
       <?php
	for($i=0;$i<13;$i++){
		print "<td width='23'>";
		if(isset($this->samples[3][$i]['largeFruit']))print($this->samples[3][$i]['largeFruit']);
		print "</td >";
		}
   
	?>
    
    
    <td><?php if($this->gradeArray[3]!=0) print $this->gradeStock[$this->gradeArray[3]]['sumOfLargeFruit']; ?></td>
    <td><?php if(isset($this->percentages[3]['perOfLargeFruit']))print $this->percentages[3]['perOfLargeFruit']; ?></td>
  </tr>
  <tr>
    <td colspan="3" rowspan="5"> ප්‍රධාන දෝෂ<br />
      (ගෙඩි ගණන) </td>
    <td colspan="4"> ඉල් මැසි හානි </td>
      <?php
	for($i=0;$i<13;$i++){
		print "<td width='23'>";
		if(isset($this->samples[2][$i]['flyAttacked']))print($this->samples[2][$i]['flyAttacked']);
		print "</td >";
		}
   
	?>
   
    <td><?php if($this->gradeArray[2]!=0) print $this->gradeStock[$this->gradeArray[2]]['sumOfFlyAttacked']; ?></td>
    <td><?php if(isset($this->percentages[2]['perOfFlyAttacked']))print $this->percentages[2]['perOfFlyAttacked']; ?></td>
    
       <?php
	for($i=0;$i<13;$i++){
		print "<td width='23'>";
		if(isset($this->samples[3][$i]['flyAttacked']))print($this->samples[3][$i]['flyAttacked']);
		print "</td >";
		}
   
	?>
    
    
    <td><?php if($this->gradeArray[3]!=0) print $this->gradeStock[$this->gradeArray[3]]['sumOfFlyAttacked']; ?></td>
    <td><?php if(isset($this->percentages[3]['perOfFlyAttacked']))print $this->percentages[3]['perOfFlyAttacked']; ?></td>
  </tr>
  <tr>
    <td colspan="4"> පොතු ගැලවුණු </td>
    
      <?php
	for($i=0;$i<13;$i++){
		print "<td width='23'>";
		if(isset($this->samples[2][$i]['peeledOff']))print($this->samples[2][$i]['peeledOff']);
		print "</td >";
		}
   
	?>
   
    <td><?php if($this->gradeArray[2]!=0) print $this->gradeStock[$this->gradeArray[2]]['sumOfPeeledOff']; ?></td>
    <td><?php if(isset($this->percentages[2]['perOfPeeledOff']))print $this->percentages[2]['perOfPeeledOff']; ?></td>
    
       <?php
	for($i=0;$i<13;$i++){
		print "<td width='23'>";
		if(isset($this->samples[3][$i]['peeledOff']))print($this->samples[3][$i]['peeledOff']);
		print "</td >";
		}
   
	?>
    
    
    <td><?php if($this->gradeArray[3]!=0) print $this->gradeStock[$this->gradeArray[3]]['sumOfPeeledOff']; ?></td>
    <td><?php if(isset($this->percentages[3]['perOfPeeledOff']))print $this->percentages[3]['perOfPeeledOff']; ?></td>
   
  </tr>
  <tr>
    <td colspan="4"> පණු කුහර හානි </td>
      <?php
	for($i=0;$i<13;$i++){
		print "<td width='23'>";
		if(isset($this->samples[2][$i]['boreAttacked']))print($this->samples[2][$i]['boreAttacked']);
		print "</td >";
		}
   
	?>
   
    <td><?php if($this->gradeArray[2]!=0) print $this->gradeStock[$this->gradeArray[2]]['sumOfBoreAttacked']; ?></td>
    <td><?php if(isset($this->percentages[2]['perOfBoreAttacked']))print $this->percentages[2]['perOfBoreAttacked']; ?></td>
    
       <?php
	for($i=0;$i<13;$i++){
		print "<td width='23'>";
		if(isset($this->samples[3][$i]['boreAttacked']))print($this->samples[3][$i]['boreAttacked']);
		print "</td >";
		}
   
	?>
    
    
    <td><?php if($this->gradeArray[3]!=0) print $this->gradeStock[$this->gradeArray[3]]['sumOfBoreAttacked']; ?></td>
    <td><?php if(isset($this->percentages[3]['perOfBoreAttacked']))print $this->percentages[3]['perOfBoreAttacked']; ?></td>
    
  </tr>
  <tr>
    <td colspan="4"> වැලි සහිත </td>
      <?php
	for($i=0;$i<13;$i++){
		print "<td width='23'>";
		if(isset($this->samples[2][$i]['sandEmbedded']))print($this->samples[2][$i]['sandEmbedded']);
		print "</td >";
		}
   
	?>
   
    <td><?php if($this->gradeArray[2]!=0) print $this->gradeStock[$this->gradeArray[2]]['sumOfSandEmbedded']; ?></td>
    <td><?php if(isset($this->percentages[2]['perOfSandEmbedded']))print $this->percentages[2]['perOfSandEmbedded']; ?></td>
    
       <?php
	for($i=0;$i<13;$i++){
		print "<td width='23'>";
		if(isset($this->samples[3][$i]['sandEmbedded']))print($this->samples[3][$i]['sandEmbedded']);
		print "</td >";
		}
   
	?>
    
    
    <td><?php if($this->gradeArray[3]!=0) print $this->gradeStock[$this->gradeArray[3]]['sumOfSandEmbedded']; ?></td>
    <td><?php if(isset($this->percentages[3]['perOfSandEmbedded']))print $this->percentages[3]['perOfSandEmbedded']; ?></td>
    
  </tr>
  <tr>
    <td colspan="4"> හැකිළුණු ගෙඩි </td>
      <?php
	for($i=0;$i<13;$i++){
		print "<td width='23'>";
		if(isset($this->samples[2][$i]['shrivelled']))print($this->samples[2][$i]['shrivelled']);
		print "</td >";
		}
   
	?>
   
    <td><?php if($this->gradeArray[2]!=0) print $this->gradeStock[$this->gradeArray[2]]['sumOfShrivelled']; ?></td>
    <td><?php if(isset($this->percentages[2]['perOfShrivelled']))print $this->percentages[2]['perOfShrivelled']; ?></td>
    
       <?php
	for($i=0;$i<13;$i++){
		print "<td width='23'>";
		if(isset($this->samples[3][$i]['shrivelled']))print($this->samples[3][$i]['shrivelled']);
		print "</td >";
		}
   
	?>
    
    
    <td><?php if($this->gradeArray[3]!=0) print $this->gradeStock[$this->gradeArray[3]]['sumOfShrivelled']; ?></td>
    <td><?php if(isset($this->percentages[3]['perOfShrivelled']))print $this->percentages[3]['perOfShrivelled']; ?></td>
    
    
   
    
  </tr>
  <tr>
    <td colspan="3" rowspan="6"> ප්‍රධාන නොවන <br />
      දෝෂ<br />
      (ගෙඩි ගණන) </td>
    <td colspan="4"> හැඩය වෙනස් </td>
    <?php
	for($i=0;$i<13;$i++){
		print "<td width='23'>";
		if(isset($this->samples[2][$i]['deformed']))print($this->samples[2][$i]['deformed']);
		print "</td >";
		}
   
	?>
   
    <td><?php if($this->gradeArray[2]!=0) print $this->gradeStock[$this->gradeArray[2]]['sumOfDeformed']; ?></td>
    <td><?php if(isset($this->percentages[2]['perOfDeformed']))print $this->percentages[2]['perOfDeformed']; ?></td>
    
       <?php
	for($i=0;$i<13;$i++){
		print "<td width='23'>";
		if(isset($this->samples[3][$i]['deformed']))print($this->samples[3][$i]['deformed']);
		print "</td >";
		}
   
	?>
    
    
    <td><?php if($this->gradeArray[3]!=0) print $this->gradeStock[$this->gradeArray[3]]['sumOfDeformed']; ?></td>
    <td><?php if(isset($this->percentages[3]['perOfDeformed']))print $this->percentages[3]['perOfDeformed']; ?></td>
    
   
  </tr>
  <tr>
    <td colspan="4"> වෛරස් ආසාදිත </td>
     <?php
	for($i=0;$i<13;$i++){
		print "<td width='23'>";
		if(isset($this->samples[2][$i]['virusAttacked']))print($this->samples[2][$i]['virusAttacked']);
		print "</td >";
		}
   
	?>
   
    <td><?php if($this->gradeArray[2]!=0) print $this->gradeStock[$this->gradeArray[2]]['sumOfVirusAttacked']; ?></td>
    <td><?php if(isset($this->percentages[2]['perOfVirusAttacked']))print $this->percentages[2]['perOfVirusAttacked']; ?></td>
    
       <?php
	for($i=0;$i<13;$i++){
		print "<td width='23'>";
		if(isset($this->samples[3][$i]['virusAttacked']))print($this->samples[3][$i]['virusAttacked']);
		print "</td >";
		}
   
	?>
    
    
    <td><?php if($this->gradeArray[3]!=0) print $this->gradeStock[$this->gradeArray[3]]['sumOfVirusAttacked']; ?></td>
    <td><?php if(isset($this->percentages[3]['perOfVirusAttacked']))print $this->percentages[3]['perOfVirusAttacked']; ?></td>
    
  </tr>
  <tr>
    <td colspan="4"> යාන්ත්‍රික හානි </td>
    
     <?php
	for($i=0;$i<13;$i++){
		print "<td width='23'>";
		if(isset($this->samples[2][$i]['mechanicalDamaged']))print($this->samples[2][$i]['mechanicalDamaged']);
		print "</td >";
		}
   
	?>
   
    <td><?php if($this->gradeArray[2]!=0) print $this->gradeStock[$this->gradeArray[2]]['sumOfMechanicalDamaged']; ?></td>
    <td><?php if(isset($this->percentages[2]['perOfMechanicalDamaged']))print $this->percentages[2]['perOfMechanicalDamaged']; ?></td>
    
       <?php
	for($i=0;$i<13;$i++){
		print "<td width='23'>";
		if(isset($this->samples[3][$i]['mechanicalDamaged']))print($this->samples[3][$i]['mechanicalDamaged']);
		print "</td >";
		}
   
	?>
    
    
    <td><?php if($this->gradeArray[3]!=0) print $this->gradeStock[$this->gradeArray[3]]['sumOfMechanicalDamaged']; ?></td>
    <td><?php if(isset($this->percentages[3]['perOfMechanicalDamaged']))print $this->percentages[3]['perOfMechanicalDamaged']; ?></td>
    
  </tr>
  <tr>
    <td colspan="4"> කහ පැහැති ගෙඩි </td>
    <?php
	for($i=0;$i<13;$i++){
		print "<td width='23'>";
		if(isset($this->samples[2][$i]['yellowish']))print($this->samples[2][$i]['yellowish']);
		print "</td >";
		}
   
	?>
   
    <td><?php if($this->gradeArray[2]!=0) print $this->gradeStock[$this->gradeArray[2]]['sumOfYellowish']; ?></td>
    <td><?php if(isset($this->percentages[2]['perOfYellowish']))print $this->percentages[2]['perOfYellowish']; ?></td>
    
       <?php
	for($i=0;$i<13;$i++){
		print "<td width='23'>";
		if(isset($this->samples[3][$i]['yellowish']))print($this->samples[3][$i]['yellowish']);
		print "</td >";
		}
   
	?>
    
    
    <td><?php if($this->gradeArray[3]!=0) print $this->gradeStock[$this->gradeArray[3]]['sumOfYellowish']; ?></td>
    <td><?php if(isset($this->percentages[3]['perOfYellowish']))print $this->percentages[3]['perOfYellowish']; ?></td>
    
  </tr>
  <tr>
    <td colspan="4"> දුඹුරු පැල්ලම් </td>
    <?php
	for($i=0;$i<13;$i++){
		print "<td width='23'>";
		if(isset($this->samples[2][$i]['rustPatches']))print($this->samples[2][$i]['rustPatches']);
		print "</td >";
		}
   
	?>
   
    <td><?php if($this->gradeArray[2]!=0) print $this->gradeStock[$this->gradeArray[2]]['sumOfRustPatches']; ?></td>
    <td><?php if(isset($this->percentages[2]['perOfRustPatches']))print $this->percentages[2]['perOfRustPatches']; ?></td>
    
       <?php
	for($i=0;$i<13;$i++){
		print "<td width='23'>";
		if(isset($this->samples[3][$i]['rustPatches']))print($this->samples[3][$i]['rustPatches']);
		print "</td >";
		}
   
	?>
    
    
    <td><?php if($this->gradeArray[3]!=0) print $this->gradeStock[$this->gradeArray[3]]['sumOfRustPatches']; ?></td>
    <td><?php if(isset($this->percentages[3]['perOfRustPatches']))print $this->percentages[3]['perOfRustPatches']; ?></td>
    
  </tr>
  <tr>
        <td colspan="4">45mmට වැඩි</td>
     <?php
    for($i=0;$i<13;$i++){
        print "<td width='23'>";
        if(isset($this->samples[2][$i]['fruits45']))print($this->samples[2][$i]['fruits45']);
        print "</td >";
        }
   
    ?>
    
    <td><?php if($this->gradeArray[2]!=0) print $this->gradeStock[$this->gradeArray[2]]['sumOf45']; ?></td>
    <td><?php if(isset($this->percentages[2]['perOf45']))print $this->percentages[2]['perOf45']; ?></td>
    <?php 
    for($i=0;$i<13;$i++){
        print "<td width='23'>";
        if(isset($this->samples[3][$i]['fruits45']))print($this->samples[3][$i]['fruits45']);
        print "</td >";
        }
   
    ?>
    
    
    <td><?php if($this->gradeArray[3]!=0) print $this->gradeStock[$this->gradeArray[3]]['sumOf45']; ?></td>
    <td><?php if(isset($this->percentages[3]['perOf45']))print $this->percentages[3]['perOf45']; ?></td>
    
  </tr>
  <tr>
    <td colspan="7"> පිළිගත් (AC)/නොපිළිගත්(RJ) </td>
     <?php
	for($i=0;$i<13;$i++){
		print "<td width='23'>";
		if(isset($this->samples[2][$i]['accepted']))print($this->samples[2][$i]['accepted']);
		print "</td >";
		}
   
	?>
   
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    
       <?php
	for($i=0;$i<13;$i++){
		print "<td width='23'>";
		if(isset($this->samples[3][$i]['accepted']))print($this->samples[3][$i]['accepted']);
		print "</td >";
		}
   
	?>
    
    
    <td>&nbsp;</td>
    <td>&nbsp;</td>
   
  </tr>
  <tr>
    <td colspan="7"> නරක් වු ගෙඩි </td>
    <?php
	for($i=0;$i<13;$i++){
		print "<td width='23'>";
		if(isset($this->samples[2][$i]['spoiled']))print($this->samples[2][$i]['spoiled']);
		print "</td >";
		}
   
	?>
   
    <td><?php if($this->gradeArray[2]!=0) print $this->gradeStock[$this->gradeArray[2]]['sumOfRotten']; ?></td>
    <td><?php if(isset($this->percentages[2]['perOfRotten']))print $this->percentages[2]['perOfRotten']; ?></td>
    
       <?php
	for($i=0;$i<13;$i++){
		print "<td width='23'>";
		if(isset($this->samples[3][$i]['spoiled']))print($this->samples[3][$i]['spoiled']);
		print "</td >";
		}
   
	?>
    
    
    <td><?php if($this->gradeArray[3]!=0) print $this->gradeStock[$this->gradeArray[3]]['sumOfRotten']; ?></td>
    <td><?php if(isset($this->percentages[3]['perOfRotten']))print $this->percentages[3]['perOfRotten']; ?></td>
    
  </tr>
  <tr>
    <td colspan="7" rowspan="7">&nbsp;</td>
    <td colspan="6"> ක්‍රේට් ගණන </td>
    <td colspan="4"><?php 
    if($this->gradeStock[$this->gradeArray[2]]['noOfCrates']){
    $c=explode('/',  $this->gradeStock[$this->gradeArray[2]]['noOfCrates']);
      $str2="";
      if(isset($c[1]) && $c[1]){
        $crates2=$c[1];
        $str2.=$crates2."(Crates)/";
        
      }
      if(isset($c[0]) && $c[0]){
        $bags2=$c[0];
        $str2.=$bags2."(Bags)";
        
      }
      print $str2;
    }
  //  print $this->gradeStock[$this->gradeArray[2]]['noOfCrates']; 
    
    ?></td>
    <td colspan="5" rowspan="7">&nbsp;</td>
    <td colspan="6">ක්‍රේට් ගණන </td>
    <td colspan="4"><?php 
    if(isset($this->gradeStock[$this->gradeArray[3]]) && $this->gradeStock[$this->gradeArray[3]]['noOfCrates']){
    	$e=explode('/', $this->gradeStock[$this->gradeArray[3]]['noOfCrates']);
     	$str3="";
      	if(isset($e[1]) && $e[1]){
        	$crates3=$e[1];
        	$str3.=$crates3."(Crates)/";
		}
      	if(isset($e[1]) && $e[0]){
        	$bags3=$e[0];
        	$str3.=$bags3."(Bags)";
      	} 
      	echo $str3;
    }
   ?></td>
    <td colspan="5" rowspan="7">&nbsp;</td>
    </tr>
  <tr>
    <td colspan="6"> ප්‍රකාශිත බර(kg) </td>
    <td colspan="4"><?php if($this->gradeArray[2]!=0)print $this->gradeStock[$this->gradeArray[2]]['notedWeight']; ?></td>
    <td colspan="6">ප්‍රකාශිත බර(kg) </td>
    <td colspan="4"><?php if($this->gradeArray[3]!=0)print $this->gradeStock[$this->gradeArray[3]]['notedWeight']; ?></td>
    </tr>
  <tr>
    <td colspan="6"> තිබූ බර ප්‍රමාණය(kg) </td>
    <td colspan="4"><?php if($this->gradeArray[2]!=0)print $this->gradeStock[$this->gradeArray[2]]['trueWeight']; ?></td>
    <td colspan="6">තිබූ බර ප්‍රමාණය(kg) </td>
    <td colspan="4"><?php if($this->gradeArray[3]!=0)print $this->gradeStock[$this->gradeArray[3]]['trueWeight']; ?></td>
    </tr>
  <tr>
    <td colspan="6">&nbsp;</td>
    <td colspan="2"> එකතුව </td>
    <td colspan="2">අඩු කල %</td>
    <td colspan="6">&nbsp;</td>
    <td colspan="2"> එකතුව </td>
    <td colspan="2">අඩු කල %</td>
    </tr>
  <tr>
    <td colspan="6"> වැරදි ශ්‍රේණිය </td>
    <td colspan="2"><?php if($this->gradeArray[2]!=0)print $this->gradeStock[$this->gradeArray[2]]['totalPerOfDefectGrade']; ?></td>
    <td colspan="2"><?php if($this->gradeArray[2]!=0)print $this->gradeStock[$this->gradeArray[2]]['reducedPerOfDefectGrade']; ?></td>
    <td colspan="6">වැරදි ශ්‍රේණිය </td>
    <td colspan="2"><?php if($this->gradeArray[3]!=0)print $this->gradeStock[$this->gradeArray[3]]['totalPerOfDefectGrade']; ?></td>
    <td colspan="2"><?php if($this->gradeArray[3]!=0)print $this->gradeStock[$this->gradeArray[3]]['reducedPerOfDefectGrade']; ?></td>
    </tr>
  <tr>
    <td colspan="6"> දෝෂ </td>
    <td colspan="2"><?php if($this->gradeArray[2]!=0)print $this->gradeStock[$this->gradeArray[2]]['totalPerOfDefect']; ?></td>
    <td colspan="2"><?php if($this->gradeArray[2]!=0)print $this->gradeStock[$this->gradeArray[2]]['reducedPerOfDefect']; ?></td>
    <td colspan="6">දෝෂ </td>
    <td colspan="2"><?php if($this->gradeArray[3]!=0)print $this->gradeStock[$this->gradeArray[3]]['totalPerOfDefect']; ?></td>
    <td colspan="2"><?php if($this->gradeArray[3]!=0)print $this->gradeStock[$this->gradeArray[3]]['reducedPerOfDefect']; ?></td>
    </tr>
  <tr>
    <td colspan="6"> ගෙවිය හැකි ප්‍රමාණය(kg) </td>
    <td colspan="2"><?php if($this->gradeArray[2]!=0)print $this->gradeStock[$this->gradeArray[2]]['payableQuantity']; ?></td>
    <td colspan="2">&nbsp;</td>
    <td colspan="6">ගෙවිය හැකි ප්‍රමාණය(kg) </td>
    <td colspan="2"><?php if($this->gradeArray[3]!=0)print $this->gradeStock[$this->gradeArray[3]]['payableQuantity']; ?></td>
    <td colspan="2">&nbsp;</td>
    </tr>
</table>
  <table width="870" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse ;font-size:10px">
    <tr  height="2">
      <td  height="2" colspan="33">&nbsp;</td>
    </tr>
    <tr>
      <td width="150"> ප්‍රවාහන තත්වය </td>
      <td colspan="2"> විස්තරය </td>
      <td colspan="7"> අවශ්‍ය තත්වය </td>
      <td width="8" rowspan="7">&nbsp;</td>
      <td colspan="3"> මධ්‍යස්ථාන අංකය </td>
      <td colspan="4"> මධ්‍යස්ථානය </td>
      <td colspan="3"> TM අංකය </td>
      <td width="8" rowspan="7">&nbsp;</td>
      <td colspan="4"> තොගයේ ප්‍රමාණය(crates/bags) </td>
      <td colspan="3"> සාම්පලයේ ප්‍රමාණය </td>
      <td colspan="4"> තිබිය හැකි උපරිම මට්ටම </td>
    </tr>
    <tr>
      <td> බාර දීම </td>
      <td colspan="2"><?php if($this->transportArray['handovering']==1)print "ඇත";else print "නැත";?></td>
      <td colspan="7"> සවස 3.00ට පෙර </td>
      <td colspan="3">1</td>
      <td colspan="4"><?php if(isset($this->centers[0])) print $this->centers[0]['centerName']?></td>
      <td colspan="3"><?php if(isset($this->centers[0])) print $this->centers[0]['tmNo']?></td>
      <td colspan="4"> 2-90 </td>
      <td colspan="3">5</td>
      <td colspan="4">1</td>
    </tr>
    <tr>
      <td height="17"> ලොරිය ආවරණය </td>
      <td colspan="2"><?php if($this->transportArray['lorryCovering']==1)print "ඇත";else print "නැත";?></td>
      <td colspan="7"> හොඳින් ආවරණය කර තිබිය යුතුයි </td>
      <td colspan="3">2</td>
      <td colspan="4"><?php if(isset($this->centers[1])) print $this->centers[1]['centerName']?></td>
      <td colspan="3"><?php if(isset($this->centers[1])) print $this->centers[1]['tmNo']?></td>
      <td colspan="4"> 91-150 </td>
      <td colspan="3">8</td>
      <td colspan="4">2</td>
    </tr>
    <tr>
      <td> ලොරිය තුළ අනවශ්‍ය දුර්ගන්ධය </td>
      <td colspan="2"><?php if($this->transportArray['badSmell'])print "ඇත";else print "නැත";?></td>
      <td colspan="7"> නොතිබිය යුතුයි </td>
      <td colspan="3">3</td>
      <td colspan="4"><?php if(isset($this->centers[2])) print $this->centers[2]['centerName']?></td>
      <td colspan="3"><?php if(isset($this->centers[2])) print $this->centers[2]['tmNo']?></td>
      <td colspan="4"> 151-500 </td>
      <td colspan="3">13</td>
      <td colspan="4">3</td>
    </tr>
    <tr>
      <td height="15"> ගර්කින් හැර වෙනත් ද්‍රව්‍ය </td>
      <td colspan="2"><?php if($this->transportArray['otherGoods'])print "ඇත";else print "නැත";?></td>
      <td colspan="7"> නොතිබිය යුතුයි </td>
      <td colspan="3">4</td>
      <td colspan="4"><?php if(isset($this->centers[3])) print $this->centers[3]['centerName']?></td>
      <td colspan="3"><?php if(isset($this->centers[3])) print $this->centers[3]['tmNo']?></td>
      <td colspan="11"> තිබිය හැකි උපරිම වැරදි ශ්‍රේණි මට්ටම 10% </td>
    </tr>
    <tr>
      <td> ලේබල්/හඳුනාගැනීමේ වර්ණ සංකේත </td>
      <td colspan="2"><?php if($this->transportArray['labelling'])print "ඇත";else print "නැත";?></td>
      <td colspan="7"> තිබිය යුතුයි </td>
      <td colspan="3">5</td>
      <td colspan="4"><?php if(isset($this->centers[4])) print $this->centers[4]['centerName']?></td>
      <td colspan="3"><?php if(isset($this->centers[4])) print $this->centers[4]['tmNo']?></td>
      <td colspan="11"> තිබිය හැකි උපරිම දෝෂ මට්ටම 7% ( නරක් වූ ගෙඩි % හැර) </td>
    </tr>
    <tr>
      <td> තත්ව වාර්තාව </td>
      <td colspan="2"><?php if($this->transportArray['qualityReports'])print "ඇත";else print "නැත";?></td>
      <td colspan="7"> තිබිය යුතුයි </td>
      <td colspan="3">6</td>
      <td colspan="4"><?php if(isset($this->centers[5])) print $this->centers[5]['centerName']?></td>
      <td colspan="3"><?php if(isset($this->centers[5])) print $this->centers[5]['tmNo']?></td>
      <td colspan="11"> මුලු නරක් වූ % සම්පූර්ණ තොගයෙන් අඩු කරනු ලැබේ. </td>
    </tr>
  </table>
  <table width="870" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse; font-size:10px">
    <tr>
      <td colspan="10">&nbsp;</td>
    </tr>
    <tr>
      <td width="70"> ශ්‍රේණිය </td>
      <td width="106"> අනුමත විශ්කම්භය(mm) </td>
      <td width="103"> උප සාම්පලයේ ප්‍රමාණය </td>
      <td width="12" rowspan="8">&nbsp;</td>
      <td colspan="6" rowspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td>80/160</td>
      <td> 14-17 </td>
      <td>1</td>
    </tr>
    <tr>
      <td> 20/80 </td>
      <td> 17-29 </td>
      <td>2</td>
      <td colspan="6"> නිගමනය : භාරගත හැක/ප්‍රතික්ශේපිත/කොටසක් ප්‍රතික්ශේපිත </td>
    </tr>
    <tr>
      <td>5/20</td>
      <td> 29-44 </td>
      <td>7</td>
      <td colspan="6"> වෙනත්:......................................................................................................................................................................................................... </td>
    </tr>
    <tr>
      <td> 15/25(No.2) </td>
      <td> 24-30 </td>
      <td>5</td>
      <td colspan="6"> පරීක්ෂා කළේ :........................................ නිරීක්ෂණය කළේ :............................................ අනුමත කළේ :.......................................... </td>
    </tr>
    <tr>
      <td> 10/15(No.3) </td>
      <td> 30-42 </td>
      <td>5</td>
      <td colspan="6">&nbsp;</td>
    </tr>
    <tr>
      <td height="17"> 5/10(No.4) </td>
      <td> 42-45 </td>
      <td>8</td>
      <td colspan="6" rowspan="2"> සටහන: ඉල් මැසි හානි අධික අවස්ථාවේදී එය නිෂ්පාදනය සඳහා යොදාගත නොහැකි බැවින් ,සම්පූර්ණ තොගය සාම්පල් සැලැස්ම නොසලකා හරිමින් ප්‍රතික්ශේප කරනු ලැබේ. </td>
    </tr>
    <tr>
      <td> CRS </td>
      <td> 16&lt;--&gt;44 </td>
      <td>5</td>
    </tr>
  </table>
	 <?php }
     function renderReport(){
     	$this->setMainTable();
     }

     function setToolBar(){ ?>
     	<div id="toolbar">
	     	<h3 align="left">Gherkin Quality Report</h3>
    	    <ul>
    	    	<li id="print-button">
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