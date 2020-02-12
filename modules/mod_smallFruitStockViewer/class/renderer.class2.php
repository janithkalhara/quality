<?php
require_once '../../../includes/HDatabase.php';
class renderer{
	private $vehicleNo;
	private $project;
	private $date;
	//header data
	
	private $batchNo;
	private $centers;
	private $itmNo;
	private $tms;
	private $crates;
	//samples
	private $sampleData;
	private $sampleCrsData;
	private $sampleKeyArray;
	private $grades;
	private $transportData;
	private $balanceSheetData;
	private $stockData;
	private $CRSSamples;
	private $percentages;
	
	public function renderer($v,$p,$d){
		$this->date=$d;
		$this->project=$p;
		$this->vehicleNo=$v;
	
	}
	
	public function setHeaderData(){
		$db=new HDatabase();
		$db->connect();
		$db->select('qa_small_crop','*',"project='$this->project' AND date='$this->date' AND vehicleNo='$this->vehicleNo'");
		$res=$db->getResult();
		foreach ($res as $temp){
			$this->itmNo=$temp['itmNo'];
			$this->centers=$temp['centers'];
			$this->tms=$temp['tmNumbers'];
			$this->crates=$temp['noOfCrates'];
			$this->batchNo=$temp['batchNo'];
			$this->stockData['totalOffGrade']=$temp['totalOffGrade'];
			$this->stockData['total_DQ']=$temp['total_DQ'];
			$this->stockData['total_AQ']=$temp['total_AQ'];
			$this->stockData['11-14Q']=$temp['11-14Q'];
			$this->stockData['14-17Q']=$temp['14-17Q'];
			$this->stockData['17-29Q']=$temp['17-29Q'];
			$this->stockData['29-44Q']=$temp['29-44Q'];
			$this->stockData['crs']=$temp['crs'];
			$this->stockData['rejected']=$temp['rejected'];
			$this->stockData['hiddenLoss']=$temp['hiddenLoss'];
			$this->stockData['weightLoss']=$temp['weightLoss'];
			
			
			$this->transportData['delivery']=$temp['transport-delivery'];
			$this->transportData['cover']=$temp['transport-cover'];
			$this->transportData['smell']=$temp['transport-smell'];
			$this->transportData['otherThings']=$temp['transport-otherThings'];
			$this->transportData['labels']=$temp['transport-labels'];
			$this->transportData['report']=$temp['transport-QualityReport'];
			
			
			
			
		}
		
		
	}
	
	public function collectReportData(){
		/* Header Data*/
		
		$db=new HDatabase();
		$db->connect();
		$db->select('qa_small_cropSampleGrades','*',"project='$this->project' AND date='$this->date' AND vehicleNo='$this->vehicleNo'");
		$res=$db->getResult();
		$i=0;
		$this->sampleKeyArray=array('sampleNo','mellonFlyAttacked','peeledOff','boreAttacked',
		                          'shrivelled','mechanicalDamaged','yellowish','rustPatches','rotten','totalDefects');
		$this->grades=array('11-14','14-17','17-29','29-44','CRS');
		/* collect grade data*/
		if(isset($res)){
			foreach ($res as $temp){
			
			
				$this->sampleData[$temp['gradeName']][$temp['sampleId']]['sampleNo']=$temp['sampleNo'];
				$this->sampleData[$temp['gradeName']][$temp['sampleId']]['mellonFlyAttacked']=$temp['mellonFlyAttacked'];
				$this->sampleData[$temp['gradeName']][$temp['sampleId']]['peeledOff']=$temp['peeledOff'];
				$this->sampleData[$temp['gradeName']][$temp['sampleId']]['boreAttacked']=$temp['boreAttacked'];
				$this->sampleData[$temp['gradeName']][$temp['sampleId']]['shrivelled']=$temp['shrivelled'];
				$this->sampleData[$temp['gradeName']][$temp['sampleId']]['mechanicalDamaged']=$temp['mechanicalDamaged'];
				$this->sampleData[$temp['gradeName']][$temp['sampleId']]['yellowish']=$temp['yellowish'];
				$this->sampleData[$temp['gradeName']][$temp['sampleId']]['rustPatches']=$temp['rustPatches'];
				$this->sampleData[$temp['gradeName']][$temp['sampleId']]['rotten']=$temp['rotten'];
				$this->sampleData[$temp['gradeName']][$temp['sampleId']]['totalDefects']=$temp['totalDefects'];
			}
		}
		
	
		/* collect CRS grade data*/
		$db->resetResult();
		
		$db->select('qa_small_crsData','*',"project='$this->project' AND date='$this->date' AND vehicleNo='$this->vehicleNo'");
		$res2=$db->getResult();
		if(isset($res2)){
		  foreach ($res2 as $temp){
            $id=explode('-', $temp['smallFruit']);
            $this->sampleCrsData['smallFruit']['sum']=$id[0];$this->sampleCrsData['smallFruit']['per']=$id[1];
            
            $id=explode('-', $temp['largeFruit']);
            $this->sampleCrsData['largeFruit']['sum']=$id[0];$this->sampleCrsData['largeFruit']['per']=$id[1];
            
            $id=explode('-', $temp['melonFlyAttack']);
            $this->sampleCrsData['melonFlyAttack']['sum']=$id[0];$this->sampleCrsData['melonFlyAttack']['per']=$id[1];
            
            $id=explode('-', $temp['peeledOff']);
            $this->sampleCrsData['peeledOff']['sum']=$id[0];$this->sampleCrsData['peeledOff']['per']=$id[1];
            
            $id=explode('-', $temp['boreAttacked']);
            $this->sampleCrsData['boreAttacked']['sum']=$id[0];$this->sampleCrsData['boreAttacked']['per']=$id[1];
            
            $id=explode('-', $temp['sandEmbedded']);
            $this->sampleCrsData['sandEmbedded']['sum']=$id[0];$this->sampleCrsData['sandEmbedded']['per']=$id[1];
            
            $id=explode('-', $temp['shrivelled']);
            $this->sampleCrsData['shrivelled']['sum']=$id[0];$this->sampleCrsData['shrivelled']['per']=$id[1];
            
            $id=explode('-', $temp['mechanicalDamaged']);
            $this->sampleCrsData['mechanicalDamaged']['sum']=$id[0];$this->sampleCrsData['mechanicalDamaged']['per']=$id[1];
            
            $id=explode('-', $temp['yellowish']);
            $this->sampleCrsData['yellowish']['sum']=$id[0];$this->sampleCrsData['yellowish']['per']=$id[1];
            
            $id=explode('-', $temp['RustPatches']);
            $this->sampleCrsData['RustPatches']['sum']=$id[0];$this->sampleCrsData['RustPatches']['per']=$id[1];
            
            $id=explode('-', $temp['accepted']);
            $this->sampleCrsData['accepted']['sum']=$id[0];$this->sampleCrsData['accepted']['per']=$id[1];
            
            $id=explode('-', $temp['spoiled']);
            $this->sampleCrsData['spoiled']['sum']=$id[0];$this->sampleCrsData['spoiled']['per']=$id[1];
           }
		}
		
		
		$db->resetResult();
		$db->select('qa_small_crsSampleData','*',"project='$this->project' AND date='$this->date' AND vehicleNo='$this->vehicleNo'");
		$res3=$db->getResult();
		if(isset($res3)){
		foreach ($res3 as $temp){
			
			$this->CRSSamples[$temp['sampleId']]['fruitCount']=$temp['fruitCount'];
			$this->CRSSamples[$temp['sampleId']]['smallFruit']=$temp['smallFruit'];
			$this->CRSSamples[$temp['sampleId']]['largeFruit']=$temp['largeFruit'];
			$this->CRSSamples[$temp['sampleId']]['melonFlyAttacked']=$temp['melonFlyAttacked'];
			$this->CRSSamples[$temp['sampleId']]['peeledOff']=$temp['peeledOff'];
			$this->CRSSamples[$temp['sampleId']]['boreAttacked']=$temp['boreAttacked'];
			$this->CRSSamples[$temp['sampleId']]['sandEmbedded']=$temp['sandEmbeded'];
			$this->CRSSamples[$temp['sampleId']]['shrivelled']=$temp['shrivelled'];
			$this->CRSSamples[$temp['sampleId']]['mechanicalDamaged']=$temp['mechanicalDamaged'];
			$this->CRSSamples[$temp['sampleId']]['yellowish']=$temp['yellowish'];
			$this->CRSSamples[$temp['sampleId']]['RustPatches']=$temp['rustPatches'];
			$this->CRSSamples[$temp['sampleId']]['AC/RE']=$temp['AC/RE'];
			$this->CRSSamples[$temp['sampleId']]['spoiled']=$temp['spoiled'];
		}
		
		}
		
		
		
	} 
	
	public function renderQualityReport(){
		$respond=array('නැත','ඇත');
		?>
		<div width="870" height="1300" style="background:#fff;">
  <table width="870" height="60" border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse;font-size:11px">
  <tr height="25"><td colspan="2" align="center"><b>HJS Condiments Limited <br>
SunFrost (PVT) LTD</b></td>
<td colspan="6" align="center"><b>ගර්කින් තත්ව පරීක්ෂණ වාර්තාව (Small Grade)</b></td></tr>
<tr height="10"><td colspan="10" align="center"  bgcolor="#ccc"></td></tr>
    <tr height="30">
      <td width="160" ><p style="float:right; margin:0">Project :</p></td>
      <td width="160" ><?php print $this->project?></td>
      <td width="160" ><p style="float:right; margin:0">Centers:</p></td>
      <td colspan="5"  ><?php print $this->centers?></td>
    </tr>
     <tr>
    <td  align="right"> Number Of Crates/Bags
    </td>
      <td ><?php    $d=explode('/',  $this->crates);
      
     
      $str="";
      if($d[1]){
      	$crates=$d[1];
      	$str.=$crates."(Crates)/";
      	
      }
      if($d[0]){
      	$bags=$d[0];
      	$str.=$bags."(Bags)";
      	
      }
      print $str;?>
    </td>
    <td align="right">TM numbers</td>
    <td colspan="5"><?php print $this->tms?></td>
    </tr>
    <tr>
      <td width="160"><p style="float:right; margin:0">Date</p></td>
      <td width="160"><?php print $this->date ?></td>
      <td width="160"><p style="float:right; margin:0">BatchNo:</p></td>
      <td width="160" ><?php print $this->batchNo ?></td>
      <td width="160"  ><p style="float:right; margin:0">Vehicle No:</p></td>
      <td width="160" ><?php print $this->vehicleNo ?></td>
      <td width="160" ><p style="float:right; margin:0">Internal TM No:</p></td>
      <td width="160"><?php print $this->itmNo?></td>
    </tr>
  </table>
  <hr>
  <table width="870" border="1" cellspacing="0" cellpadding="0"  style="border-collapse:collapse;font-size:11px">
    <tr>
      <td width="150">&nbsp;</td>
      <td colspan="3"><p style="float:right; margin:0">Grade:</p></td>
      <td colspan="3" id="0-grade"><?php print $this->grades[0]?></td>
      <td colspan="7">&nbsp;</td>
      <td width="8" rowspan="11">&nbsp;</td>
      <td colspan="3"><p style="float:right; margin:0">Grade:</p></td>
      <td colspan="3" id="1-grade"><?php print $this->grades[1]?></td>
      <td colspan="7">&nbsp;</td>
    </tr>
    <tr>
      <td align="left">සාම්පල් අංකය</td>
      <?php
      for($h=0;$h<2;$h++){
      	for($i=0;$i<13;$i++){
            ?>
      		 <td width="32" align="center" id="0-0-0"><?php if(isset($this->sampleData[$this->grades[$h]][$i]['sampleNo']))print $this->sampleData[$this->grades[$h]][$i]['sampleNo']?></td>
      		<?php 
        } 
      }
      
      
      
      ?>
      
      
      
      
      
      
    </tr>
    <tr>
      <td align="left">ඉල් මැසි හානි</td>
   <?php
      for($h=0;$h<2;$h++){
        for($i=0;$i<13;$i++){
            ?>
             <td width="32" align="center" id="0-0-0"><?php if(isset($this->sampleData[$this->grades[$h]][$i]['mellonFlyAttacked']))print $this->sampleData[$this->grades[$h]][$i]['mellonFlyAttacked']?></td>
            <?php 
        } 
      }
      
      
      
      ?>
    </tr>
    <tr>
     <td align="left">පොතු ගැලවුණු</td>
      <?php
      for($h=0;$h<2;$h++){
        for($i=0;$i<13;$i++){
            ?>
             <td width="32" align="center" id="0-0-0"><?php if(isset($this->sampleData[$this->grades[$h]][$i]['peeledOff']))print $this->sampleData[$this->grades[$h]][$i]['peeledOff']?></td>
            <?php 
        } 
      }
      
      
      
      ?>
    </tr>
    <tr>
     <td align="left">පණු කුහර හානි</td>
       <?php
      for($h=0;$h<2;$h++){
        for($i=0;$i<13;$i++){
            ?>
             <td width="32" align="center" id="0-0-0"><?php if(isset($this->sampleData[$this->grades[$h]][$i]['boreAttacked']))print $this->sampleData[$this->grades[$h]][$i]['boreAttacked']?></td>
            <?php 
        } 
      }
      
      
      
      ?>
    </tr>
    <tr>
     <td align="left">හැකිළුණු ගෙඩි</td>
       <?php
      for($h=0;$h<2;$h++){
        for($i=0;$i<13;$i++){
            ?>
             <td width="32" align="center" id="0-0-0"><?php if(isset($this->sampleData[$this->grades[$h]][$i]['shrivelled']))print $this->sampleData[$this->grades[$h]][$i]['shrivelled']?></td>
            <?php 
        } 
      }
      
      
      
      ?>
    </tr>
    <tr>
      <td align="left">යාන්ත්‍රික හානි</td>
    <?php
      for($h=0;$h<2;$h++){
        for($i=0;$i<13;$i++){
            ?>
             <td width="32" align="center" id="0-0-0"><?php if(isset($this->sampleData[$this->grades[$h]][$i]['mechanicalDamaged']))print $this->sampleData[$this->grades[$h]][$i]['mechanicalDamaged']?></td>
            <?php 
        } 
      }
      
      
      
      ?>
    </tr>
    <tr>
      <td align="left">කහ පැහැති ගෙඩි</td>
      <?php
      for($h=0;$h<2;$h++){
        for($i=0;$i<13;$i++){
            ?>
             <td width="32" align="center" id="0-0-0"><?php if(isset($this->sampleData[$this->grades[$h]][$i]['yellowish']))print $this->sampleData[$this->grades[$h]][$i]['yellowish']?></td>
            <?php 
        } 
      }
      ?>
    </tr>
    <tr>
      <td align="left">දුඹුරු පැල්ලම්</td>
       <?php
      for($h=0;$h<2;$h++){
        for($i=0;$i<13;$i++){
            ?>
             <td width="32" align="center" id="0-0-0"><?php if(isset($this->sampleData[$this->grades[$h]][$i]['rustPatches']))print $this->sampleData[$this->grades[$h]][$i]['rustPatches']?></td>
            <?php 
        } 
      }
      ?>
    </tr>
    <tr>
      <td align="left">නරක් වු ගෙඩි</td>
     <?php
      for($h=0;$h<2;$h++){
        for($i=0;$i<13;$i++){
            ?>
             <td width="32" align="center" id="0-0-0"><?php if(isset($this->sampleData[$this->grades[$h]][$i]['rotten']))print $this->sampleData[$this->grades[$h]][$i]['rotten']?></td>
            <?php 
        } 
      }
      ?>
    </tr>
    <tr>
      <td align="left">මුළු දෝෂ ගණන</td>
      <?php
      for($h=0;$h<2;$h++){
        for($i=0;$i<13;$i++){
            ?>
             <td width="32" align="center" id="0-0-0"><?php if(isset($this->sampleData[$this->grades[$h]][$i]['totalDefects']))print $this->sampleData[$this->grades[$h]][$i]['totalDefects']?></td>
            <?php 
        } 
      }
      ?>
    </tr>
  </table>
  <tr height="6"></tr>
  <hr>
  <table width="870" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse;font-size:11px">
    <tr>
      <td width="150">&nbsp;</td>
      <td colspan="3"><p style="float:right; margin:0">Grade:</p></td>
      <td colspan="3" id="2-grade"><?php print $this->grades[2]?></td>
      <td colspan="7">&nbsp;</td>
      <td width="8" rowspan="11">&nbsp;</td>
      <td colspan="3"><p style="float:right; margin:0">Grade:</p></td>
      <td colspan="3"><?php print $this->grades[3]?></td>
      <td colspan="7">&nbsp;</td>
    </tr>
    <tr>
      <td align="left">සාම්පල් අංකය</td>
        <?php
      for($h=2;$h<4;$h++){
        for($i=0;$i<13;$i++){
            ?>
             <td width="32" align="center" id="0-0-0"><?php if(isset($this->sampleData[$this->grades[$h]][$i]['sampleNo']))print $this->sampleData[$this->grades[$h]][$i]['sampleNo']?></td>
            <?php 
        } 
      }
      ?>
    </tr>
    <tr>
      <td align="left">ඉල් මැසි හානි</td>
       <?php
      for($h=2;$h<4;$h++){
        for($i=0;$i<13;$i++){
            ?>
             <td width="32" align="center" id="0-0-0"><?php if(isset($this->sampleData[$this->grades[$h]][$i]['mellonFlyAttacked']))print $this->sampleData[$this->grades[$h]][$i]['mellonFlyAttacked']?></td>
            <?php 
        } 
      }
      ?>
    </tr>
    <tr>
      <td align="left">පොතු ගැලවුණු</td>
      <?php
      for($h=2;$h<4;$h++){
        for($i=0;$i<13;$i++){
            ?>
             <td width="32" align="center" id="0-0-0"><?php if(isset($this->sampleData[$this->grades[$h]][$i]['peeledOff']))print $this->sampleData[$this->grades[$h]][$i]['peeledOff']?></td>
            <?php 
        } 
      }
      ?>
    </tr>
    <tr>
      <td align="left">පණු කුහර හානි</td>
     <?php
      for($h=2;$h<4;$h++){
        for($i=0;$i<13;$i++){
            ?>
             <td width="32" align="center" id="0-0-0"><?php if(isset($this->sampleData[$this->grades[$h]][$i]['boreAttacked']))print $this->sampleData[$this->grades[$h]][$i]['boreAttacked']?></td>
            <?php 
        } 
      }
      ?>
    </tr>
    <tr>
      <td align="left">හැකිළුණු ගෙඩි</td>
   <?php
      for($h=2;$h<4;$h++){
        for($i=0;$i<13;$i++){
            ?>
             <td width="32" align="center" id="0-0-0"><?php if(isset($this->sampleData[$this->grades[$h]][$i]['shrivelled']))print $this->sampleData[$this->grades[$h]][$i]['shrivelled']?></td>
            <?php 
        } 
      }
      ?>
    </tr>
    <tr>
      <td align="left">යාන්ත්‍රික හානි</td>
       <?php
      for($h=2;$h<4;$h++){
        for($i=0;$i<13;$i++){
            ?>
             <td width="32" align="center" id="0-0-0"><?php if(isset($this->sampleData[$this->grades[$h]][$i]['mechanicalDamaged']))print $this->sampleData[$this->grades[$h]][$i]['mechanicalDamaged']?></td>
            <?php 
        } 
      }
      ?>
    </tr>
    <tr>
      <td align="left">කහ පැහැති ගෙඩි</td>
    <?php
      for($h=2;$h<4;$h++){
        for($i=0;$i<13;$i++){
            ?>
             <td width="32" align="center" id="0-0-0"><?php if(isset($this->sampleData[$this->grades[$h]][$i]['yellowish']))print $this->sampleData[$this->grades[$h]][$i]['yellowish']?></td>
            <?php 
        } 
      }
      ?>
    </tr>
    <tr>
      <td align="left">දුඹුරු පැල්ලම්</td>
      <?php
      for($h=2;$h<4;$h++){
        for($i=0;$i<13;$i++){
            ?>
             <td width="32" align="center" id="0-0-0"><?php if(isset($this->sampleData[$this->grades[$h]][$i]['rustPatches']))print $this->sampleData[$this->grades[$h]][$i]['rustPatches']?></td>
            <?php 
        } 
      }
      ?>
    </tr>
    <tr>
      <td align="left">නරක් වු ගෙඩි</td>
     <?php
      for($h=2;$h<4;$h++){
        for($i=0;$i<13;$i++){
            ?>
             <td width="32" align="center" id="0-0-0"><?php if(isset($this->sampleData[$this->grades[$h]][$i]['rotten']))print $this->sampleData[$this->grades[$h]][$i]['rotten']?></td>
            <?php 
        } 
      }
      ?>
    </tr>
    <tr>
      <td align="left">මුළු දෝෂ ගණන</td>
       <?php
      for($h=2;$h<4;$h++){
        for($i=0;$i<13;$i++){
            ?>
             <td width="32" align="center" id="0-0-0"><?php if(isset($this->sampleData[$this->grades[$h]][$i]['totalDefects']))print $this->sampleData[$this->grades[$h]][$i]['totalDefects']?></td>
            <?php 
        } 
      }
      ?>
    </tr>
  </table>
  <hr>
  <table width="870" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse;font-size:11px">
    <tr>
      <td width="155">&nbsp;</td>
      <td colspan="3"><p style="float:right; margin:0">Grade:</p></td>
      <td colspan="3" id='crs-grade'><?php print $this->grades[4]?></td>
      <td colspan="9">&nbsp;</td>
    </tr>
    <tr>
      <td>මුළු ගෙඩි ගණන</td>
      <td align="center" width="32" id="crs-0-0"><?php if(isset($this->CRSSamples[0]['fruitCount'])) print $this->CRSSamples[0]['fruitCount']?></td>
      <td align="center" width="32" id="crs-0-1"><?php if(isset($this->CRSSamples[1]['fruitCount'])) print $this->CRSSamples[1]['fruitCount']?></td>
      <td align="center" width="32" id="crs-0-2"><?php if(isset($this->CRSSamples[2]['fruitCount'])) print $this->CRSSamples[2]['fruitCount']?></td>
      <td align="center" width="32" id="crs-0-3"><?php if(isset($this->CRSSamples[3]['fruitCount'])) print $this->CRSSamples[3]['fruitCount']?></td>
      <td align="center" width="32" id="crs-0-4"><?php if(isset($this->CRSSamples[4]['fruitCount'])) print $this->CRSSamples[4]['fruitCount']?></td>
      <td align="center" width="32" id="crs-0-5"><?php if(isset($this->CRSSamples[5]['fruitCount'])) print $this->CRSSamples[5]['fruitCount']?></td>
      <td align="center" width="32" id="crs-0-6"><?php if(isset($this->CRSSamples[6]['fruitCount'])) print $this->CRSSamples[6]['fruitCount']?></td>
      <td align="center" width="32" id="crs-0-7"><?php if(isset($this->CRSSamples[7]['fruitCount'])) print $this->CRSSamples[7]['fruitCount']?></td>
      <td align="center" width="32" id="crs-0-8"><?php if(isset($this->CRSSamples[8]['fruitCount'])) print $this->CRSSamples[8]['fruitCount']?></td>
      <td align="center" width="32" id="crs-0-9"><?php if(isset($this->CRSSamples[9]['fruitCount'])) print $this->CRSSamples[9]['fruitCount']?></td>
      <td align="center" width="32" id="crs-0-10"><?php if(isset($this->CRSSamples[10]['fruitCount'])) print $this->CRSSamples[10]['fruitCount']?></td>
      <td align="center" width="32" id="crs-0-11"><?php if(isset($this->CRSSamples[11]['fruitCount'])) print $this->CRSSamples[11]['fruitCount']?></td>
      <td align="center" width="32" id="crs-0-12"><?php if(isset($this->CRSSamples[12]['fruitCount'])) print $this->CRSSamples[12]['fruitCount']?></td>
      <td align="center" width="32" id="crs-0-13">Sum</td>
      <td align="center" width="32" id="crs-0-14">%</td>
      <td rowspan="13" width="8">&nbsp;</td>
      <td width="180">ප්‍රවාහන තත්වය</td>
      <td width="60">විස්තරය</td>
      <td width="160">අවශ්‍ය තත්වය</td>
      
    </tr>
    <tr>
      <td >කුඩා ගෙඩි ගණන</td>
     <td align="center" width="32" ><?php if(isset($this->CRSSamples[0]['smallFruit'])) print $this->CRSSamples[0]['smallFruit']?></td>
      <td align="center" width="32" id="crs-0-1"><?php if(isset($this->CRSSamples[1]['smallFruit'])) print $this->CRSSamples[1]['smallFruit']?></td>
      <td align="center" width="32" id="crs-0-2"><?php if(isset($this->CRSSamples[2]['smallFruit'])) print $this->CRSSamples[2]['smallFruit']?></td>
      <td align="center" width="32" id="crs-0-3"><?php if(isset($this->CRSSamples[3]['smallFruit'])) print $this->CRSSamples[3]['smallFruit']?></td>
      <td align="center" width="32" id="crs-0-4"><?php if(isset($this->CRSSamples[4]['smallFruit'])) print $this->CRSSamples[4]['smallFruit']?></td>
      <td align="center" width="32" id="crs-0-5"><?php if(isset($this->CRSSamples[5]['smallFruit'])) print $this->CRSSamples[5]['smallFruit']?></td>
      <td align="center" width="32" id="crs-0-6"><?php if(isset($this->CRSSamples[6]['smallFruit'])) print $this->CRSSamples[6]['smallFruit']?></td>
      <td align="center" width="32" id="crs-0-7"><?php if(isset($this->CRSSamples[7]['smallFruit'])) print $this->CRSSamples[7]['smallFruit']?></td>
      <td align="center" width="32" id="crs-0-8"><?php if(isset($this->CRSSamples[8]['smallFruit'])) print $this->CRSSamples[8]['smallFruit']?></td>
      <td align="center" width="32" id="crs-0-9"><?php if(isset($this->CRSSamples[9]['smallFruit'])) print $this->CRSSamples[9]['smallFruit']?></td>
      <td align="center" width="32" id="crs-0-10"><?php if(isset($this->CRSSamples[10]['smallFruit'])) print $this->CRSSamples[10]['smallFruit']?></td>
      <td align="center" width="32" id="crs-0-11"><?php if(isset($this->CRSSamples[11]['smallFruit'])) print $this->CRSSamples[11]['smallFruit']?></td>
      <td align="center" width="32" id="crs-0-12"><?php if(isset($this->CRSSamples[12]['smallFruit'])) print $this->CRSSamples[12]['smallFruit']?></td>
      <td align="center" id="crs-1-13"><?php if(isset($this->sampleCrsData['smallFruit']['sum']))print $this->sampleCrsData['smallFruit']['sum']?></td>
      <td align="center" id="crs-1-14"><?php if(isset($this->sampleCrsData['smallFruit']['per']))print $this->sampleCrsData['smallFruit']['per']?></td>
      <td >බාර දීම</td>
      <td id="transport-delivery"><?php print  $respond[$this->transportData['delivery']]?></td>
      <td >සවස 3.00ට පෙර</td>
    </tr>
    <tr>
     <td >ලොකු ගෙඩි ගණන</td>
    <td align="center" width="32" id="crs-0-0"><?php if(isset($this->CRSSamples[0]['largeFruit'])) print $this->CRSSamples[0]['largeFruit']?></td>
      <td align="center" width="32" id="crs-0-1"><?php if(isset($this->CRSSamples[1]['largeFruit'])) print $this->CRSSamples[1]['largeFruit']?></td>
      <td align="center" width="32" id="crs-0-2"><?php if(isset($this->CRSSamples[2]['largeFruit'])) print $this->CRSSamples[2]['largeFruit']?></td>
      <td align="center" width="32" id="crs-0-3"><?php if(isset($this->CRSSamples[3]['largeFruit'])) print $this->CRSSamples[3]['largeFruit']?></td>
      <td align="center" width="32" id="crs-0-4"><?php if(isset($this->CRSSamples[4]['largeFruit'])) print $this->CRSSamples[4]['largeFruit']?></td>
      <td align="center" width="32" id="crs-0-5"><?php if(isset($this->CRSSamples[5]['largeFruit'])) print $this->CRSSamples[5]['largeFruit']?></td>
      <td align="center" width="32" id="crs-0-6"><?php if(isset($this->CRSSamples[6]['largeFruit'])) print $this->CRSSamples[6]['largeFruit']?></td>
      <td align="center" width="32" id="crs-0-7"><?php if(isset($this->CRSSamples[7]['largeFruit'])) print $this->CRSSamples[7]['largeFruit']?></td>
      <td align="center" width="32" id="crs-0-8"><?php if(isset($this->CRSSamples[8]['largeFruit'])) print $this->CRSSamples[8]['largeFruit']?></td>
      <td align="center" width="32" id="crs-0-9"><?php if(isset($this->CRSSamples[9]['largeFruit'])) print $this->CRSSamples[9]['largeFruit']?></td>
      <td align="center" width="32" id="crs-0-10"><?php if(isset($this->CRSSamples[10]['largeFruit'])) print $this->CRSSamples[10]['largeFruit']?></td>
      <td align="center" width="32" id="crs-0-11"><?php if(isset($this->CRSSamples[11]['largeFruit'])) print $this->CRSSamples[11]['largeFruit']?></td>
      <td align="center" width="32" id="crs-0-12"><?php if(isset($this->CRSSamples[12]['largeFruit'])) print $this->CRSSamples[12]['largeFruit']?></td>
      <td align="center" id="crs-2-13"><?php if(isset($this->sampleCrsData['largeFruit']['sum']))print $this->sampleCrsData['largeFruit']['sum']?></td>
      <td align="center" id="crs-2-14"><?php if(isset($this->sampleCrsData['largeFruit']['per']))print $this->sampleCrsData['largeFruit']['per']?></td>
      <td rowspan="2">ලොරිය ආවරණය</td>
      <td rowspan="2" id="transport-cover"><?php print $respond[$this->transportData['cover']]?></td>
      <td  rowspan="2">හොඳින් ආවරණය කර තිබිය යුතුයි</td>
    </tr>
    <tr>
    <td >ඉල් මැසි හානි</td>
      <td align="center" width="32" id="crs-0-0"><?php if(isset($this->CRSSamples[0]['melonFlyAttacked'])) print $this->CRSSamples[0]['melonFlyAttacked']?></td>
      <td align="center" width="32" id="crs-0-1"><?php if(isset($this->CRSSamples[1]['melonFlyAttacked'])) print $this->CRSSamples[1]['melonFlyAttacked']?></td>
      <td align="center" width="32" id="crs-0-2"><?php if(isset($this->CRSSamples[2]['melonFlyAttacked'])) print $this->CRSSamples[2]['melonFlyAttacked']?></td>
      <td align="center" width="32" id="crs-0-3"><?php if(isset($this->CRSSamples[3]['melonFlyAttacked'])) print $this->CRSSamples[3]['melonFlyAttacked']?></td>
      <td align="center" width="32" id="crs-0-4"><?php if(isset($this->CRSSamples[4]['melonFlyAttacked'])) print $this->CRSSamples[4]['melonFlyAttacked']?></td>
      <td align="center" width="32" id="crs-0-5"><?php if(isset($this->CRSSamples[5]['melonFlyAttacked'])) print $this->CRSSamples[5]['melonFlyAttacked']?></td>
      <td align="center" width="32" id="crs-0-6"><?php if(isset($this->CRSSamples[6]['melonFlyAttacked'])) print $this->CRSSamples[6]['melonFlyAttacked']?></td>
      <td align="center" width="32" id="crs-0-7"><?php if(isset($this->CRSSamples[7]['melonFlyAttacked'])) print $this->CRSSamples[7]['melonFlyAttacked']?></td>
      <td align="center" width="32" id="crs-0-8"><?php if(isset($this->CRSSamples[8]['melonFlyAttacked'])) print $this->CRSSamples[8]['melonFlyAttacked']?></td>
      <td align="center" width="32" id="crs-0-9"><?php if(isset($this->CRSSamples[9]['melonFlyAttacked'])) print $this->CRSSamples[9]['melonFlyAttacked']?></td>
      <td align="center" width="32" id="crs-0-10"><?php if(isset($this->CRSSamples[10]['melonFlyAttacked'])) print $this->CRSSamples[10]['melonFlyAttacked']?></td>
      <td align="center" width="32" id="crs-0-11"><?php if(isset($this->CRSSamples[11]['melonFlyAttacked'])) print $this->CRSSamples[11]['melonFlyAttacked']?></td>
      <td align="center" width="32" id="crs-0-12"><?php if(isset($this->CRSSamples[12]['melonFlyAttacked'])) print $this->CRSSamples[12]['melonFlyAttacked']?></td>
      <td align="center" id="crs-3-13"><?php if(isset($this->sampleCrsData['melonFlyAttack']['sum']))print $this->sampleCrsData['melonFlyAttack']['sum']?></td>
      <td align="center" id="crs-3-14"><?php if(isset($this->sampleCrsData['melonFlyAttack']['per']))print $this->sampleCrsData['melonFlyAttack']['per']?></td>
      
    </tr>
    <tr>
  <td  >පොතු ගැලවුණු</td>
      <td align="center" width="32" id="crs-0-0"><?php if(isset($this->CRSSamples[0]['peeledOff'])) print $this->CRSSamples[0]['peeledOff']?></td>
      <td align="center" width="32" id="crs-0-1"><?php if(isset($this->CRSSamples[1]['peeledOff'])) print $this->CRSSamples[1]['peeledOff']?></td>
      <td align="center" width="32" id="crs-0-2"><?php if(isset($this->CRSSamples[2]['peeledOff'])) print $this->CRSSamples[2]['peeledOff']?></td>
      <td align="center" width="32" id="crs-0-3"><?php if(isset($this->CRSSamples[3]['peeledOff'])) print $this->CRSSamples[3]['peeledOff']?></td>
      <td align="center" width="32" id="crs-0-4"><?php if(isset($this->CRSSamples[4]['peeledOff'])) print $this->CRSSamples[4]['peeledOff']?></td>
      <td align="center" width="32" id="crs-0-5"><?php if(isset($this->CRSSamples[5]['peeledOff'])) print $this->CRSSamples[5]['peeledOff']?></td>
      <td align="center" width="32" id="crs-0-6"><?php if(isset($this->CRSSamples[6]['peeledOff'])) print $this->CRSSamples[6]['peeledOff']?></td>
      <td align="center" width="32" id="crs-0-7"><?php if(isset($this->CRSSamples[7]['peeledOff'])) print $this->CRSSamples[7]['peeledOff']?></td>
      <td align="center" width="32" id="crs-0-8"><?php if(isset($this->CRSSamples[8]['peeledOff'])) print $this->CRSSamples[8]['peeledOff']?></td>
      <td align="center" width="32" id="crs-0-9"><?php if(isset($this->CRSSamples[9]['peeledOff'])) print $this->CRSSamples[9]['peeledOff']?></td>
      <td align="center" width="32" id="crs-0-10"><?php if(isset($this->CRSSamples[10]['peeledOff'])) print $this->CRSSamples[10]['peeledOff']?></td>
      <td align="center" width="32" id="crs-0-11"><?php if(isset($this->CRSSamples[11]['peeledOff'])) print $this->CRSSamples[11]['peeledOff']?></td>
      <td align="center" width="32" id="crs-0-12"><?php if(isset($this->CRSSamples[12]['peeledOff'])) print $this->CRSSamples[12]['peeledOff']?></td>
      <td align="center" id="crs-4-13"><?php if(isset($this->sampleCrsData['peeledOff']['sum']))print $this->sampleCrsData['peeledOff']['sum']?></td>
      <td align="center" id="crs-4-14"><?php if(isset($this->sampleCrsData['peeledOff']['per']))print $this->sampleCrsData['peeledOff']['per']?></td>
      <td  rowspan="2">ලොරිය තුළ අනවශ්‍ය දුර්ගන්ධය</td>
      <td  rowspan="2" id="transport-smell"><?php print $respond[$this->transportData['smell']]?></td>
      <td  rowspan="2">නොතිබිය යුතුයි</td>
    </tr>
    <tr>
    <td  >පණු කුහර හානි</td>
    <?php
    for($i=0;$i<13;$i++){
    	?>
    	<td align="center" width="32" ><?php if(isset($this->CRSSamples[$i]['peeledOff'])) print $this->CRSSamples[$i]['peeledOff']?></td>
    	<?php 
    	
    } 
    
    ?>
    
    
      <td align="center" id="crs-5-13"><?php if(isset($this->sampleCrsData['boreAttacked']['sum']))print $this->sampleCrsData['boreAttacked']['sum']?></td>
      <td align="center" id="crs-5-14"><?php if(isset($this->sampleCrsData['boreAttacked']['per']))print $this->sampleCrsData['boreAttacked']['per']?></td>
     
    </tr>
    <tr>
   <td >වැලි සහිත</td>
   <?php
    for($i=0;$i<13;$i++){
        ?>
        <td align="center" width="32"><?php if(isset($this->CRSSamples[$i]['sandEmbedded'])) print $this->CRSSamples[$i]['sandEmbedded']?></td>
        <?php 
        
    } 
    
    ?>
      <td align="center" id="crs-6-13"><?php if(isset($this->sampleCrsData['sandEmbedded']['sum']))print $this->sampleCrsData['sandEmbedded']['sum']?></td>
      <td align="center" id="crs-6-14"><?php if(isset($this->sampleCrsData['sandEmbedded']['per']))print $this->sampleCrsData['sandEmbedded']['per']?></td>
       <td rowspan="2" >ගර්කින් හැර වෙනත් ද්‍රව්‍ය </td>
      <td rowspan="2" id="transport-otherthings"><?php print $respond[$this->transportData['otherThings']]?></td>
      <td rowspan="2">නොතිබිය යුතුයි</td>
      
    </tr>
    <tr>
      <td >හැකිළුණු ගෙඩි</td>
      <?php
    for($i=0;$i<13;$i++){
        ?>
        <td align="center" width="32" ><?php if(isset($this->CRSSamples[$i]['shrivelled'])) print $this->CRSSamples[$i]['shrivelled']?></td>
        <?php 
        
    } 
    
    ?>
      <td align="center" id="crs-7-13"><?php if(isset($this->sampleCrsData['shrivelled']['sum']))print $this->sampleCrsData['shrivelled']['sum']?></td>
      <td align="center" id="crs-7-14"><?php if(isset($this->sampleCrsData['shrivelled']['per']))print $this->sampleCrsData['shrivelled']['per']?></td>
   
    </tr>
    <tr>
   <td  >යාන්ත්‍රික හානි</td>
       <?php
    for($i=0;$i<13;$i++){
        ?>
        <td align="center" width="32" ><?php if(isset($this->CRSSamples[$i]['mechanicalDamaged'])) print $this->CRSSamples[$i]['mechanicalDamaged']?></td>
        <?php 
        
    } 
    
    ?>
      <td align="center" id="crs-8-13"><?php if(isset($this->sampleCrsData['mechanicalDamaged']['sum']))print $this->sampleCrsData['mechanicalDamaged']['sum']?></td>
      <td align="center" id="crs-8-14"><?php if(isset($this->sampleCrsData['mechanicalDamaged']['per']))print $this->sampleCrsData['mechanicalDamaged']['per']?></td>
        <td  rowspan="2">ලේබල්/හඳුනාගැනීමේ වර්ණ සංකේත</td>
      <td rowspan="2" id="transport-labels"><?php print $respond[$this->transportData['labels']]?></td>
      <td  rowspan="2">තිබිය යුතුයි</td>
      
    </tr>
    <tr>
    <td >කහ පැහැති ගෙඩි</td>
   
          <?php
    for($i=0;$i<13;$i++){
        ?>
        <td align="center" width="32" ><?php if(isset($this->CRSSamples[$i]['yellowish'])) print $this->CRSSamples[$i]['yellowish']?></td>
        <?php 
        
    } 
    
    ?>
      <td align="center" id="crs-9-13"><?php if(isset($this->sampleCrsData['yellowish']['sum']))print $this->sampleCrsData['yellowish']['sum']?></td>
      <td align="center" id="crs-9-14"><?php if(isset($this->sampleCrsData['yellowish']['per']))print $this->sampleCrsData['yellowish']['per']?></td>
      
     
    </tr>
    <tr>
   <td  >දුඹුරු පැල්ලම්</td>
    <?php
    for($i=0;$i<13;$i++){
        ?>
        <td align="center" width="32" ><?php if(isset($this->CRSSamples[$i]['RustPatches'])) print $this->CRSSamples[$i]['RustPatches']?></td>
        <?php 
        
    } 
    
    ?>
      <td align="center" id="crs-10-13"><?php if(isset($this->sampleCrsData['RustPatches']['sum']))print $this->sampleCrsData['RustPatches']['sum']?></td>
      <td align="center" id="crs-10-14"><?php if(isset($this->sampleCrsData['RustPatches']['per']))print $this->sampleCrsData['RustPatches']['per']?></td>
       <td >තත්ව වාර්තාව</td>
      <td id="transport-qualityReport"><?php print $respond[$this->transportData['report']]?></td>
      <td >තිබිය යුතුයි</td>
      
      
    </tr>
    <tr>
      <td >නො/පිළිගත්(AC)/(RE)</td>
     <?php
    for($i=0;$i<13;$i++){
        ?>
        <td align="center" width="32" ><?php if(isset($this->CRSSamples[$i]['AC/RE'])) print $this->CRSSamples[$i]['AC/RE']?></td>
        <?php 
        
    } 
    
    ?>
      <td align="center" id="crs-11-13"><?php if(isset($this->sampleCrsData['accepted']['sum']))print $this->sampleCrsData['accepted']['sum']?></td>
      <td align="center" id="crs-11-14"><?php if(isset($this->sampleCrsData['accepted']['per']))print $this->sampleCrsData['accepted']['per']?></td>
      <td  colspan="3" rowspan="2"></td>
    </tr>
    <tr>
     <td  >නරක් වු ගෙඩි</td>
      <?php
    for($i=0;$i<13;$i++){
        ?>
        <td align="center" width="32" id="crs-0-0"><?php if(isset($this->CRSSamples[$i]['spoiled'])) print $this->CRSSamples[$i]['spoiled']?></td>
        <?php 
        
    } 
    
    ?>
      <td align="center" id="crs-12-13"><?php if(isset($this->sampleCrsData['spoiled']['sum']))print $this->sampleCrsData['spoiled']['sum']?></td>
      <td align="center" id="crs-12-14"><?php if(isset($this->sampleCrsData['spoiled']['per']))print $this->sampleCrsData['spoiled']['per']?></td>
     
    </tr>
  </table>
  <hr>
   <table width="870" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse;font-size:11px">
   <tr>
   <td height="25"><strong>නිගමනය : </strong> භාරගත හැක/ප්‍රතික්ශේපිත/කොටසක් ප්‍රතික්ශේපිත</td>
   </tr>
   <tr>
   <td height="25"><b>වෙනත්: </b>.................................................................................................................................................................................................</td>
   </tr>
   <tr>
   <td height="25"><strong>පරීක්ෂා කළේ :</strong>........................................ <strong>නිරීක්ෂණය කළේ :</strong>............................................ <strong>අනුමත කළේ :</strong>..........................................</td>
   </tr>
   <tr>
   <td height="25"><strong>සටහන: </strong>ඉල් මැසි හානි අධික අවස්ථාවේදී එය නිෂ්පාදනය සඳහා යොදාගත නොහැකි බැවින් ,සම්පූර්ණ තොගය සාම්පල් සැලැස්ම නොසලකා හරිමින් ප්‍රතික්ශේප කරනු ලැබේ.</td>
   </tr>
   <tr>
   <td>&nbsp;</td>
   </tr>
   
   </table>
  
</div>
		
		
		
		
		
		
		
		
		<?php 
		
		
	}
	
	
	
	
	
	
	public function setBalanceSheetData(){
		/* Setting balance sheet data*/
		$db=new HDatabase();
		$db->connect();
		$db->select('qa_small_belongs','*',"project='$this->project' AND date='$this->date' AND vehicleNo='$this->vehicleNo'");
		$res=$db->getResult();
		if(isset($res)){
			foreach ($res as $temp){
			
			$this->balanceSheetData[$temp['gradeName']]['AQ']=$temp['AQ'];
			$this->balanceSheetData[$temp['gradeName']]['DQ']=$temp['DQ'];
			$this->balanceSheetData[$temp['gradeName']]['11-14']=$temp['11-14'];
			$this->balanceSheetData[$temp['gradeName']]['14-17']=$temp['14-17'];
			$this->balanceSheetData[$temp['gradeName']]['17-29']=$temp['17-29'];
			$this->balanceSheetData[$temp['gradeName']]['29-44']=$temp['29-44'];
			$this->balanceSheetData[$temp['gradeName']]['crs']=$temp['CRS'];
			$this->balanceSheetData[$temp['gradeName']]['reject']=$temp['reject'];
			
			$this->balanceSheetData[$temp['gradeName']]['hiddenLoss']=$temp['hiddenLoss'];
			$this->balanceSheetData[$temp['gradeName']]['weightLoss']=$temp['weightLoss'];
			$this->balanceSheetData[$temp['gradeName']]['offGrade']=$temp['offGrade'];
			
            }
		}
		
		$this->setPecentageData();
		
	}
	
	private function setPecentageData(){
		
			$totalDQ=$this->stockData['total_DQ'];
	        $totalAQ=$this->stockData['total_AQ'];
	        $totalG1=$this->stockData['11-14Q'];
	        $totalG2=$this->stockData['14-17Q'];
	        $totalG3=$this->stockData['17-29Q'];
	       $totalG4=$this->stockData['29-44Q'];
	       $totalCRS=$this->stockData['crs'];
	       $totalRejected=$this->stockData['rejected'];
	       $totalHL=$this->stockData['hiddenLoss'];
	       $totalWL=$this->stockData['weightLoss'];
            if($totalAQ!=0){
	           $this->percentages['11-14Q']=round(($totalG1/$totalAQ)*100,2);
	           $this->percentages['14-17Q']=round(($totalG2/$totalAQ)*100,2);
		       $this->percentages['17-29Q']=round(($totalG3/$totalAQ)*100,2);
		       $this->percentages['29-44Q']=round(($totalG4/$totalAQ)*100,2);
		       $this->percentages['crs']=round(($totalCRS/$totalAQ)*100,2);
		       $this->percentages['rejected']=round(($totalRejected/$totalAQ)*100,2);
		       $this->percentages['hiddenLoss']=round(($totalHL/$totalAQ)*100,2);
		       $this->percentages['weightLoss']=round(($totalWL/$totalDQ)*100,2);
			}else{
				 $this->percentages['11-14Q']=0;
	           $this->percentages['14-17Q']=0;
		       $this->percentages['17-29Q']=0;
		       $this->percentages['29-44Q']=0;
		       $this->percentages['crs']=0;
		       $this->percentages['rejected']=0;
		       $this->percentages['hiddenLoss']=0;
		       $this->percentages['weightLoss']=0;
				
				
				}
	}
	
	
	
	
	public function renderBalanceSheet(){
		
		?>
		<table border="1" cellpadding="0" cellspacing="0"  width="870" >
  <tr height="40">
    <td align="center"><b>HJS Condiments Limited <br>SunFrost (PVT) LTD</b></td>
    <td align="center"><b>Daily Fresh Gherkin (Small) Quantity Balance Sheet</b></td>
  </tr>
 
</table>
<hr>
<table  border="1" cellpadding="0" cellspacing="0"  width="870" height="25" >
  <tr>
    <td width="200" align="right"><b>Date:</b></td><td width="200" id='date-balancesheet'><?php print $this->date?></td>
    <td width="200" align="right"><b>Project:</b></td><td width="200" id='project-balancesheet'><?php print $this->project?></td>
  </tr>
 
</table>

<hr>
<table width="870" border="1" cellpadding="0" cellspacing="0" style="margin-bottom:20px" class="navigateable"> 
  <tr height="25">
    <td colspan="2" style="text-align:right;padding-right:5px">ශ්‍රේණිය</td>
    <td colspan="2" style="text-align:center; font-weight:bold">11-14.5</td>
    <td colspan="6">&nbsp;</td>
  </tr>
  <tr valign="middle" height="30" class="thDiv" >
    <td width="98" height="25">Declared Quantity(kg)</td>
    <td width="85">Actual Quantity</td>
    <td width="66">11.0-14.5</td>
    <td width="64">14.5-17.0</td>
    <td width="67">17.0-29.0</td>
    <td width="60">29.0-44.0</td>
    <td width="66">CRS</td>
    <td width="66">Rejected</td>
    <td width="80">Hidden Loss</td>
    <td width="84">Weight Loss</td>
   </tr>
  <tr height="30" bordercolor="#fff"  >
    <td align="center" id="printBsheet-0-0" ><?php if(isset($this->balanceSheetData['11-14']['DQ'])) print $this->balanceSheetData['11-14']['DQ']?></td>
    <td align="center" id="printBsheet-0-1"><?php if(isset($this->balanceSheetData['11-14']['AQ'])) print $this->balanceSheetData['11-14']['AQ']?></td>
    <td align="center" id="printBsheet-0-2"><?php if(isset($this->balanceSheetData['11-14']['11-14'])) print $this->balanceSheetData['11-14']['11-14']?></td>
    <td align="center" id="printBsheet-0-3"><?php if(isset($this->balanceSheetData['11-14']['14-17'])) print $this->balanceSheetData['11-14']['14-17']?></td>
    <td align="center" id="printBsheet-0-4"><?php if(isset($this->balanceSheetData['11-14']['17-29'])) print $this->balanceSheetData['11-14']['17-29']?></td>
    <td align="center" id="printBsheet-0-5"><?php if(isset($this->balanceSheetData['11-14']['29-44'])) print $this->balanceSheetData['11-14']['29-44']?></td>
    <td align="center" id="printBsheet-0-6"><?php if(isset($this->balanceSheetData['11-14']['crs'])) print $this->balanceSheetData['11-14']['crs']?></td>
    <td align="center" id="printBsheet-0-7"><?php if(isset($this->balanceSheetData['11-14']['reject'])) print $this->balanceSheetData['11-14']['reject']?></td>
    <td align="center" id="printBsheet-0-8"><?php if(isset($this->balanceSheetData['11-14']['hiddenLoss'])) print $this->balanceSheetData['11-14']['hiddenLoss']?></td>
    <td align="center" id="printBsheet-0-9"><?php if(isset($this->balanceSheetData['11-14']['weightLoss'])) print $this->balanceSheetData['11-14']['weightLoss']?></td>
   </tr>
  <tr height="25" bordercolor="#fff">
    <td colspan="2" style="text-align:right;padding-right:5px">Off Grade %</td>
    <td colspan="1" id="0-print-offgrade"><?php if(isset($this->balanceSheetData['11-14']['offGrade'])) print $this->balanceSheetData['11-14']['offGrade']?></td>
    <td colspan="7">&nbsp;</td>    
  </tr>
  <tr>
    <td colspan="10" style="background:#ccc">&nbsp;</td>
   </tr>
  <tr height="25">
    <td colspan="2" style="text-align:right;padding-right:5px">Grade</td>
    <td colspan="2" style="text-align:center;font-weight:bold">14.5-17.0</td>
    <td colspan="6">&nbsp;</td>    
   </tr>
  <tr height="30" class="thDiv">
    <td width="98">Declared Quantity</td>
    <td width="85">Actual Quantity</td>
    <td width="66">11.0-14.5</td>
    <td width="64">14.5-17.0</td>
    <td width="67">17.0-29.0</td>
    <td width="60">29.0-44.0</td>
    <td width="66">CRS</td>
    <td width="66">Reject</td>
    <td width="80">Hidden Loss</td>
    <td width="84">Weight Loss</td>
   </tr>
  <tr height="30" bordercolor="#fff" >
    <td align="center" id="printBsheet-0-0" ><?php if(isset($this->balanceSheetData['14-17']['DQ'])) print $this->balanceSheetData['14-17']['DQ']?></td>
    <td align="center" id="printBsheet-0-1"><?php if(isset($this->balanceSheetData['14-17']['AQ'])) print $this->balanceSheetData['14-17']['AQ']?></td>
    <td align="center" id="printBsheet-0-2"><?php if(isset($this->balanceSheetData['14-17']['11-14'])) print $this->balanceSheetData['14-17']['11-14']?></td>
    <td align="center" id="printBsheet-0-3"><?php if(isset($this->balanceSheetData['14-17']['14-17'])) print $this->balanceSheetData['14-17']['14-17']?></td>
    <td align="center" id="printBsheet-0-4"><?php if(isset($this->balanceSheetData['14-17']['17-29'])) print $this->balanceSheetData['14-17']['17-29']?></td>
    <td align="center" id="printBsheet-0-5"><?php if(isset($this->balanceSheetData['14-17']['29-44'])) print $this->balanceSheetData['14-17']['29-44']?></td>
    <td align="center" id="printBsheet-0-6"><?php if(isset($this->balanceSheetData['14-17']['crs'])) print $this->balanceSheetData['14-17']['crs']?></td>
    <td align="center" id="printBsheet-0-7"><?php if(isset($this->balanceSheetData['14-17']['reject'])) print $this->balanceSheetData['14-17']['reject']?></td>
    <td align="center" id="printBsheet-0-8"><?php if(isset($this->balanceSheetData['14-17']['hiddenLoss'])) print $this->balanceSheetData['14-17']['hiddenLoss']?></td>
    <td align="center" id="printBsheet-0-9"><?php if(isset($this->balanceSheetData['14-17']['weightLoss'])) print $this->balanceSheetData['14-17']['weightLoss']?></td>
   </tr>
  <tr height="25" bordercolor="#fff">
    <td colspan="2" style="text-align:right;padding-right:5px">Off Grade %</td>
    <td colspan="1" id="1-print-offgrade"><?php if(isset($this->balanceSheetData['14-17']['offGrade'])) print $this->balanceSheetData['14-17']['offGrade']?></td>
    <td colspan="7">&nbsp;</td>    
  </tr>
  <tr>
   <td colspan="10" style="background:#ccc">&nbsp;</td>
   </tr>
  <tr height="25">
    <td colspan="2" style="text-align:right;padding-right:5px">Grade</td>
    <td colspan="2" style="text-align:center;font-weight:bold">17.0-29.0</td>
    <td colspan="6">&nbsp;</td>
   </tr>
  <tr height="30" class="thDiv">
    <td width="98">Declared Quantity</td>
    <td width="85">Actual Quantity</td>
    <td width="66">11.0-14.5</td>
    <td width="64">14.5-17.0</td>
    <td width="67">17.0-29.0</td>
    <td width="60">29.0-44.0</td>
    <td width="66">CRS</td>
    <td width="66">Reject</td>
    <td width="80">Hidden Loss</td>
    <td width="84">Weight Loss</td>
   </tr>
  <tr height="30" bordercolor="#fff" >
      <td align="center" id="printBsheet-0-0" ><?php if(isset($this->balanceSheetData['17-29']['DQ'])) print $this->balanceSheetData['17-29']['DQ']?></td>
    <td align="center" id="printBsheet-0-1"><?php if(isset($this->balanceSheetData['17-29']['AQ'])) print $this->balanceSheetData['17-29']['AQ']?></td>
    <td align="center" id="printBsheet-0-2"><?php if(isset($this->balanceSheetData['17-29']['11-14'])) print $this->balanceSheetData['17-29']['11-14']?></td>
    <td align="center" id="printBsheet-0-3"><?php if(isset($this->balanceSheetData['17-29']['14-17'])) print $this->balanceSheetData['17-29']['14-17']?></td>
    <td align="center" id="printBsheet-0-4"><?php if(isset($this->balanceSheetData['17-29']['17-29'])) print $this->balanceSheetData['17-29']['17-29']?></td>
    <td align="center" id="printBsheet-0-5"><?php if(isset($this->balanceSheetData['17-29']['29-44'])) print $this->balanceSheetData['17-29']['29-44']?></td>
    <td align="center" id="printBsheet-0-6"><?php if(isset($this->balanceSheetData['17-29']['crs'])) print $this->balanceSheetData['17-29']['crs']?></td>
    <td align="center" id="printBsheet-0-7"><?php if(isset($this->balanceSheetData['17-29']['reject'])) print $this->balanceSheetData['17-29']['reject']?></td>
    <td align="center" id="printBsheet-0-8"><?php if(isset($this->balanceSheetData['17-29']['hiddenLoss'])) print $this->balanceSheetData['17-29']['hiddenLoss']?></td>
    <td align="center" id="printBsheet-0-9"><?php if(isset($this->balanceSheetData['17-29']['weightLoss'])) print $this->balanceSheetData['17-29']['weightLoss']?></td>
   </tr>
  <tr height="25" bordercolor="#fff">
    <td colspan="2" style="text-align:right;padding-right:5px">Off Grade %</td>
    <td colspan="1" id="2-print-offgrade" ><?php if(isset($this->balanceSheetData['17-29']['offGrade'])) print $this->balanceSheetData['17-29']['offGrade']?></td>
    <td colspan="7">&nbsp;</td>    
  </tr>
  <tr>
    <td colspan="10" style="background:#ccc">&nbsp;</td>
   </tr>
  <tr height="25">
    <td colspan="2" style="text-align:right;padding-right:5px">Grade</td>
    <td colspan="2" style="text-align:center;font-weight:bold">29.0-44.0</td>
    <td colspan="6">&nbsp;</td>
   </tr>
  <tr height="30" class="thDiv">
    <td width="98">Declared Quantity</td>
    <td width="85">Actual Quantity</td>
    <td width="66">11.0-14.5</td>
    <td width="64">14.5-17.0</td>
    <td width="67">17.0-29.0</td>
    <td width="60">29.0-44.0</td>
    <td width="66">CRS</td>
    <td width="66">Reject</td>
    <td width="80">Hidden Loss</td>
    <td width="84">Weight Loss</td>
   </tr>
  <tr height="30" bordercolor="#fff" >
   <td align="center" id="printBsheet-0-0" ><?php if(isset($this->balanceSheetData['29-44']['DQ'])) print $this->balanceSheetData['29-44']['DQ']?></td>
    <td align="center" id="printBsheet-0-1"><?php if(isset($this->balanceSheetData['29-44']['AQ'])) print $this->balanceSheetData['29-44']['AQ']?></td>
    <td align="center" id="printBsheet-0-2"><?php if(isset($this->balanceSheetData['29-44']['11-14'])) print $this->balanceSheetData['29-44']['11-14']?></td>
    <td align="center" id="printBsheet-0-3"><?php if(isset($this->balanceSheetData['29-44']['14-17'])) print $this->balanceSheetData['29-44']['14-17']?></td>
    <td align="center" id="printBsheet-0-4"><?php if(isset($this->balanceSheetData['29-44']['17-29'])) print $this->balanceSheetData['29-44']['17-29']?></td>
    <td align="center" id="printBsheet-0-5"><?php if(isset($this->balanceSheetData['29-44']['29-44'])) print $this->balanceSheetData['29-44']['29-44']?></td>
    <td align="center" id="printBsheet-0-6"><?php if(isset($this->balanceSheetData['29-44']['crs'])) print $this->balanceSheetData['29-44']['crs']?></td>
    <td align="center" id="printBsheet-0-7"><?php if(isset($this->balanceSheetData['29-44']['reject'])) print $this->balanceSheetData['29-44']['reject']?></td>
    <td align="center" id="printBsheet-0-8"><?php if(isset($this->balanceSheetData['29-44']['hiddenLoss'])) print $this->balanceSheetData['29-44']['hiddenLoss']?></td>
    <td align="center" id="printBsheet-0-9"><?php if(isset($this->balanceSheetData['29-44']['weightLoss'])) print $this->balanceSheetData['29-44']['weightLoss']?></td>
   </tr>
  <tr height="25" bordercolor="#fff">
    <td colspan="2" style="text-align:right;padding-right:5px">Off Grade %</td>
    <td colspan="1" id="3-print-offgrade"><?php if(isset($this->balanceSheetData['29-44']['offGrade'])) print $this->balanceSheetData['29-44']['offGrade']?></td>
    <td colspan="7">&nbsp;</td>    
  </tr>
  <tr>
    <td colspan="10" style="background:#ccc">&nbsp;</td>
   </tr>
  <tr height="25">
    <td colspan="2" style="text-align:right;padding-right:5px">Grade</td>
    <td colspan="2" style="text-align:center;font-weight:bold">CRS</td>
    <td colspan="6">&nbsp;</td>
   </tr>
  <tr height="30" class="thDiv">
    <td width="98">Declared Quantity</td>
    <td width="85">Actual Quantity</td>
    <td width="66">11.0-14.5</td>
    <td width="64">14.5-17.0</td>
    <td width="67">17.0-29.0</td>
    <td width="60">29.0-44.0</td>
    <td width="66">CRS</td>
    <td width="66">Reject</td>
    <td width="80">Hidden Loss</td>
    <td width="84">Weight Loss</td>   </tr>
  <tr height="30" bordercolor="#fff" >
      <td align="center" id="printBsheet-0-0" ><?php if(isset($this->balanceSheetData['CRS']['DQ'])) print $this->balanceSheetData['CRS']['DQ']?></td>
    <td align="center" id="printBsheet-0-1"><?php if(isset($this->balanceSheetData['CRS']['AQ'])) print $this->balanceSheetData['CRS']['AQ']?></td>
    <td align="center" id="printBsheet-0-2"><?php if(isset($this->balanceSheetData['CRS']['11-14'])) print $this->balanceSheetData['CRS']['11-14']?></td>
    <td align="center" id="printBsheet-0-3"><?php if(isset($this->balanceSheetData['CRS']['14-17'])) print $this->balanceSheetData['CRS']['14-17']?></td>
    <td align="center" id="printBsheet-0-4"><?php if(isset($this->balanceSheetData['CRS']['17-29'])) print $this->balanceSheetData['CRS']['17-29']?></td>
    <td align="center" id="printBsheet-0-5"><?php if(isset($this->balanceSheetData['CRS']['29-44'])) print $this->balanceSheetData['CRS']['29-44']?></td>
    <td align="center" id="printBsheet-0-6"><?php if(isset($this->balanceSheetData['CRS']['crs'])) print $this->balanceSheetData['CRS']['crs']?></td>
    <td align="center" id="printBsheet-0-7"><?php if(isset($this->balanceSheetData['CRS']['reject'])) print $this->balanceSheetData['CRS']['reject']?></td>
    <td align="center" id="printBsheet-0-8"><?php if(isset($this->balanceSheetData['CRS']['hiddenLoss'])) print $this->balanceSheetData['CRS']['hiddenLoss']?></td>
    <td align="center" id="printBsheet-0-9"><?php if(isset($this->balanceSheetData['CRS']['weightLoss'])) print $this->balanceSheetData['CRS']['weightLoss']?></td>
   </tr>
  <tr height="25" bordercolor="#fff">
    <td colspan="2" style="text-align:right;padding-right:5px">Off Grade %</td>
    <td colspan="1" id="4-print-offgrade"><?php if(isset($this->balanceSheetData['CRS']['offGrade'])) print $this->balanceSheetData['CRS']['offGrade']?></td>
    <td colspan="7">&nbsp;</td>    
  </tr>
  <tr>
    <td colspan="10" style="background:#ccc">&nbsp;</td>
   </tr>
  <tr height="25">
    <td colspan="2" style="text-align:right;padding-right:5px">Total</td>
    <td colspan="8">&nbsp;</td>
    
   </tr>
  <tr height="30" class="thDiv">
    <td width="98">Declared Quantity</td>
    <td width="85">Actual Quantity</td>
    <td width="66">11.0-14.5</td>
    <td width="64">14.5-17.0</td>
    <td width="67">17.0-29.0</td>
    <td width="60">29.0-44.0</td>
    <td width="66">CRS</td>
    <td width="66">Reject</td>
    <td width="80">Hidden Loss</td>
    <td width="84">Weight Loss</td>
   </tr>
  
 <tr height="30" bordercolor="#fff" >
    <td align="center" id="printBsheet-5-0"><?php if(isset($this->stockData['total_DQ'])) print  $this->stockData['total_DQ']?></td>
    <td align="center" id="printBsheet-5-1"><?php if(isset($this->stockData['total_AQ'])) print  $this->stockData['total_AQ']?></td>
    <td align="center" id="printBsheet-5-2"><?php if(isset($this->stockData['11-14Q'])) print  $this->stockData['11-14Q']?></td>
    <td align="center" id="printBsheet-5-3"><?php if(isset($this->stockData['14-17Q'])) print  $this->stockData['14-17Q']?></td>
    <td align="center" id="printBsheet-5-4"><?php if(isset($this->stockData['17-29Q'])) print  $this->stockData['17-29Q']?></td>
    <td align="center" id="printBsheet-5-5"><?php if(isset($this->stockData['29-44Q'])) print  $this->stockData['29-44Q']?></td>
    <td align="center" id="printBsheet-5-6"><?php if(isset($this->stockData['crs'])) print  $this->stockData['crs']?></td>
    <td align="center" id="printBsheet-5-7"><?php if(isset($this->stockData['rejected'])) print  $this->stockData['rejected']?></td>
    <td align="center" id="printBsheet-5-8"><?php if(isset($this->stockData['hiddenLoss'])) print  $this->stockData['hiddenLoss']?></td>
    <td align="center" id="printBsheet-5-9"><?php if(isset($this->stockData['weightLoss'])) print  $this->stockData['weightLoss']?></td>
   </tr>
  <tr height="25" bordercolor="#fff">
    <td colspan="2" style="text-align:right;padding-right:5px">Off Grade %</td>
    <td colspan="1" id="5-print-offgrade" ><?php print  $this->stockData['totalOffGrade']?></td>
    <td colspan="7">&nbsp;</td>    
  </tr>
  <tr height="25">
    <td colspan="2" style="text-align:right;padding-right:5px">Total Percentages %</td>
    <td colspan="8">&nbsp;</td>
    
   </tr>
  <tr height="30" class="thDiv">
    <td width="98">Declared Quantity</td>
    <td width="85">Actual Quantity</td>
    <td width="66">11.0-14.5</td>
    <td width="64">14.5-17.0</td>
    <td width="67">17.0-29.0</td>
    <td width="60">29.0-44.0</td>
    <td width="66">CRS</td>
    <td width="66">Reject</td>
    <td width="80">Hidden Loss</td>
    <td width="84">Weight Loss</td>
   </tr>
  
 <tr height="30" bordercolor="#fff" >
    <td align="center" id="printBsheet-5-0"><?php ?></td>
    <td align="center" id="printBsheet-5-1"><?php ?></td>
    <td align="center" id="printBsheet-5-2"><?php print $this->percentages['11-14Q']?></td>
    <td align="center" id="printBsheet-5-3"><?php print $this->percentages['14-17Q']?></td>
    <td align="center" id="printBsheet-5-4"><?php print $this->percentages['17-29Q']?></td>
    <td align="center" id="printBsheet-5-5"><?php print $this->percentages['29-44Q']?></td>
    <td align="center" id="printBsheet-5-6"><?php print $this->percentages['crs']?></td>
    <td align="center" id="printBsheet-5-7"><?php print $this->percentages['rejected']?></td>
    <td align="center" id="printBsheet-5-8"><?php print $this->percentages['hiddenLoss']?></td>
    <td align="center" id="printBsheet-5-9"><?php print $this->percentages['weightLoss']?></td>
   </tr>
 
</table>

		<?php 
		
	}
	
}
?>