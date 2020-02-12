<?php
require_once '../../../includes/HDatabase.php';
class renderer{
	private $vehicleNo;
	private $project;
	private $date;
	private $projectName;
	//header data
	
	private $batchNo;
	private $centers;
	private $itmNo;
	private $tms;
	private $crates;
	//samples
	private $sampleData;
	private $sampleStatData;
	private $sampleCrsData;
	private $sampleKeyArray;
	private $grades = array('11-14','14-17','17-29','29-44','CRS');
	private $transportData;
	private $balanceSheetData;
	private $stockData;
	private $CRSSamples;
	private $percentages;
	
	private static $keys = array('fruitCount',
						'smallFruit',
						'largeFruit',
						'melonFlyAttacked',
						'peeledOff',
						'boreAttacked',
						'sandEmbedded',
						'shrivelled',
						'mechanicalDamaged',
						'yellowish',
						'rustPatches',
						'accepted',
						'spoiled'
				);
	
	private static $keysSimple = array(
										'sampleNo',
										'mellonFlyAttacked',
										'peeledOff',
										'boreAttacked',
										'shrivelled',
										'mechanicalDamaged',
										'yellowish',
										'rustPatches',
										'rotten',
										'total');
	private static $keysExtended = array(
										'sampleNo',
										'fruitCount',
										'smallFruit',
										'largeFruit',
										'mellonFlyAttacked',
										'peeledOff',
										'boreAttacked',
										'sandEmbedded',
										'shrivelled',
										'deformed',
										'virusAttacked',
										'mechanicalDamaged',
										'yellowish',
										'rustPatches',
										'45mm',
										'ac/re',
										'rotten');
	private static $lang = array('si'=>array('sampleNo'=>'සාම්පල් අංකය', 
											'fruitCount' =>'මුළු ගෙඩි ගණන',
											'smallFruit'=>'කුඩා ගෙඩි ගණන',
											'largeFruit'=>'ලොකු ගෙඩි ගණන',
											'mellonFlyAttacked'=>'ඉල් මැසි හානි',
											'peeledOff'=>'පොතු ගැලවුණු',
											'boreAttacked'=>'පණු කුහර හානි',
											'sandEmbedded'=>'වැලි සහිත',
											'shrivelled'=>'හැකිළුණු ගෙඩි',
											'deformed'=>'හැඩය වෙනස්',
											'virusAttacked'=>'වෛරස් ආසාදිත',
											'mechanicalDamaged'=>'යාන්ත්‍රික හානි',
											'yellowish'=>'කහ පැහැති ගෙඩි',
											'rustPatches'=>'දුඹුරු පැල්ලම්',
											'45mm'=>'45mmට වැඩි',
											'ac/re'=>'පිළිගත් /නොපිළිගත්',
											'rotten'=>'නරක් වු ගෙඩි',
											'total'=>'මුළු දෝෂ ගණන'
											)
								);
		
	public function renderer($v,$p,$d){
		$this->date = $d;
		$this->project = $p;
		$this->vehicleNo = $v;
		$p = new Project();
		$ps = $p->getProjectNameById($this->project);
		$this->projectName = $ps['areaName'];
	}
	
	public function setHeaderData(){
		$db = new HDatabase();
		$db->connect();
		$db->select('qa_small_crop','*',"id='$this->project' AND date='$this->date' AND vehicleNo='$this->vehicleNo'");
		$res = $db->getResult();
		foreach ($res as $temp){
			$this->itmNo = $temp['itmNo'];
			$this->centers = $temp['centers'];
			$this->tms = $temp['tmNumbers'];
			$this->crates = $temp['noOfCrates'];
			$this->batchNo = $temp['batchNo'];
			$this->stockData['totalOffGrade'] = $temp['totalOffGrade'];
			$this->stockData['total_DQ'] = $temp['total_DQ'];
			$this->stockData['total_AQ'] = $temp['total_AQ'];
			$this->stockData['11-14Q'] = $temp['11-14Q'];
			$this->stockData['14-17Q'] = $temp['14-17Q'];
			$this->stockData['17-29Q'] = $temp['17-29Q'];
			$this->stockData['29-44Q'] = $temp['29-44Q'];
			$this->stockData['crs'] = $temp['crs'];
			$this->stockData['rejected'] = $temp['rejected'];
			$this->stockData['hiddenLoss'] = $temp['hiddenLoss'];
			$this->stockData['weightLoss'] = $temp['weightLoss'];
			$this->transportData['delivery'] = $temp['transport-delivery'];
			$this->transportData['cover'] = $temp['transport-cover'];
			$this->transportData['smell'] = $temp['transport-smell'];
			$this->transportData['otherThings'] = $temp['transport-otherThings'];
			$this->transportData['labels'] = $temp['transport-labels'];
			$this->transportData['report'] = $temp['transport-QualityReport'];
		}
	}
	
	public function collectReportData(){
		$db = new HDatabase();
		$db->connect();
		$db->select('qa_small_cropSampleGrades2','*',"id='{$this->project}' AND date='{$this->date}' AND vehicleNo='{$this->vehicleNo}'");
		$res = $db->getResult();
		$i = 0;
		$keys = array_merge(self::$keysSimple,self::$keysExtended);
		$keys = array_unique($keys);
		if(isset($res)){
			foreach ($res as $temp){
				foreach ($keys as $key){
					$this->sampleData[$temp['gradeName']][$temp['sampleId']][$key] = $temp[$key];
				}
			}
		}
		
		$db->resetResult();
		$result = null;
		$db->select('qa_small_cropSampleStat','*',"id='$this->project' AND date='$this->date' AND vehicleNo='$this->vehicleNo'");
		$result = $db->getResult();
		if($result){
			foreach ($result as $T){
				foreach ($keys as $key){
					if(isset($T[$key])){
						$id = explode('-', $T[$key]);
						$this->sampleStatData[$T['gradeName']][$key]['sum'] = isset($id[0])?$id[0] : 0;
						$this->sampleStatData[$T['gradeName']][$key]['per'] = isset($id[1])?$id[1] : 0;
					}
				}
				$this->sampleStatData[$T['gradeName']]['TOP']['sum'] = 'sum';
				$this->sampleStatData[$T['gradeName']]['TOP']['per'] = 'per';
			}
		}
		
		$db->resetResult();$result = $T =  null;
		$db->select('qa_small_crsData','*',"id='$this->project' AND date='$this->date' AND vehicleNo='$this->vehicleNo'");
		$result = $db->getResult();
		if(isset($result)){
		  	foreach ($result as $T){
		  		foreach (self::$keys as $key){
		  			if(isset($T[$key])){
			  			$id = explode('-', $T[$key]);
			  			$this->sampleCrsData[$key]['sum'] = $id[0]?$id[0] : 0;
			  			$this->sampleCrsData[$key]['per'] = $id[1]?$id[1] : 0;
		  			}
		  		}
	        }
		}
		
		$db->resetResult();
		$db->select('qa_small_crsSampleData','*',"id='$this->project' AND date='$this->date' AND vehicleNo='$this->vehicleNo'");
		$res3=$db->getResult();
		if(isset($res3)){
		foreach ($res3 as $temp){
			foreach (self::$keys as $key){
				$this->CRSSamples[$temp['sampleId']][$key] = $temp[$key];
			}
		}
		
		}
	} 
	public function renderQualityReport(){
		$respond=array('නැත','ඇත');
		include_once __DIR__.'/../tpl/tpl-quality.report.v2.php';
	}
	public function setBalanceSheetData(){
		/* Setting balance sheet data*/
		$db = new HDatabase();
		$db->connect();
		$db->select('qa_small_belongs','*',"id='$this->project' AND date='$this->date' AND vehicleNo='$this->vehicleNo'");
		$res = $db->getResult();
		if(isset($res)){
			foreach ($res as $temp){
			$this->balanceSheetData[$temp['gradeName']]['AQ'] = $temp['AQ'];
			$this->balanceSheetData[$temp['gradeName']]['DQ'] = $temp['DQ'];
			$this->balanceSheetData[$temp['gradeName']]['11-14'] = $temp['11-14'];
			$this->balanceSheetData[$temp['gradeName']]['14-17'] = $temp['14-17'];
			$this->balanceSheetData[$temp['gradeName']]['17-29'] = $temp['17-29'];
			$this->balanceSheetData[$temp['gradeName']]['29-44'] = $temp['29-44'];
			$this->balanceSheetData[$temp['gradeName']]['crs'] = $temp['CRS'];
			$this->balanceSheetData[$temp['gradeName']]['reject'] = $temp['reject'];
			$this->balanceSheetData[$temp['gradeName']]['hiddenLoss'] = $temp['hiddenLoss'];
			$this->balanceSheetData[$temp['gradeName']]['weightLoss'] = $temp['weightLoss'];
			$this->balanceSheetData[$temp['gradeName']]['offGrade'] = $temp['offGrade'];
			$this->balanceSheetData[$temp['gradeName']]['mode'] = (bool)$temp['mode'];
            }
		}
		$this->setPecentageData();
	}
	
	private function setPecentageData(){
		$totalDQ = $this->stockData['total_DQ'];
	    $totalAQ = $this->stockData['total_AQ'];
	    $totalG1 = $this->stockData['11-14Q'];
	    $totalG2 = $this->stockData['14-17Q'];
	    $totalG3 = $this->stockData['17-29Q'];
	    $totalG4 = $this->stockData['29-44Q'];
	    $totalCRS = $this->stockData['crs'];
	    $totalRejected = $this->stockData['rejected'];
	    $totalHL = $this->stockData['hiddenLoss'];
	    $totalWL = $this->stockData['weightLoss'];
	    if($totalAQ != 0){
			$this->percentages['11-14Q'] = round(($totalG1/$totalAQ)*100,2);
			$this->percentages['14-17Q'] = round(($totalG2/$totalAQ)*100,2);
			$this->percentages['17-29Q'] = round(($totalG3/$totalAQ)*100,2);
			$this->percentages['29-44Q'] = round(($totalG4/$totalAQ)*100,2);
			$this->percentages['crs'] = round(($totalCRS/$totalAQ)*100,2);
			$this->percentages['rejected'] = round(($totalRejected/$totalAQ)*100,2);
			$this->percentages['hiddenLoss'] = round(($totalHL/$totalAQ)*100,2);
			$this->percentages['weightLoss'] = round(($totalWL/$totalDQ)*100,2);
		}
		else{
			$this->percentages['11-14Q'] = 0;
			$this->percentages['14-17Q'] = 0;
			$this->percentages['17-29Q'] = 0;
			$this->percentages['29-44Q'] = 0;
			$this->percentages['crs'] = 0;
			$this->percentages['rejected'] = 0;
			$this->percentages['hiddenLoss'] = 0;
			$this->percentages['weightLoss'] = 0;
		}
	}
	
	public function renderTable($tableNo){ 
		$mode = $this->balanceSheetData[$this->grades[$tableNo]]['mode'];	
		
		?>
		<table width="435" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse;font-size:11px">
		<tr>
			<td width="<?php echo $mode?'120':'150'?>">&nbsp;</td>
			<td colspan="3"><p style="float:right; margin:0">Grade:</p></td>
			<td colspan="3" id="2-grade"><?php print $this->grades[$tableNo]?></td>
			<td colspan="<?php echo $mode?'9':'7'?>">&nbsp;</td>
		</tr>
		<?php if(!$mode){
				foreach (self::$keysSimple as $key){ ?>
				<tr>
					<td align="left"><?php echo self::$lang['si'][$key]?></td>
					<?php for($i=0;$i<13;$i++){ ?>
						<td width="32" align="center" id="0-0-0"><?php if(isset($this->sampleData[$this->grades[$tableNo]][$i][$key]))echo $this->sampleData[$this->grades[$tableNo]][$i][$key]?></td>
					<?php } ?>
				</tr>
			<?php }
			}else{ 
				$tracker = 0;
				foreach (self::$keysExtended as $key){ ?>
				<tr>
					<td align="left"><?php echo self::$lang['si'][$key]?></td>
					<?php for($i=0;$i<13;$i++){ ?>
						<td width="32" align="center" id="0-0-0"><?php if(isset($this->sampleData[$this->grades[$tableNo]][$i][$key]))echo $this->sampleData[$this->grades[$tableNo]][$i][$key]?></td>
					<?php } ?>
					<td align="center"><?php echo $tracker!=0?$this->sampleStatData[$this->grades[$tableNo]][$key]['sum']:'sum'?></td>
					<td align="center"><?php echo $tracker!=0?$this->sampleStatData[$this->grades[$tableNo]][$key]['per']:'per'?></td>
				</tr>
		<?php $tracker++;} 
		}
		?>
		</table>
	<?php }
	
	public function renderBalanceSheet(){ 
		include_once __DIR__.'/../tpl/tpl-balancesheet.php';
	}
}
?>