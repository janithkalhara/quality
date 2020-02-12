<?php
require_once 'includes/HDatabase.php';

class GetData{
	private $startDate;
	private $endDate;
	private $seasonId;
	private $category;
	private $station;
	private $con;

	function GetData($postArr){
		$this->startDate = $postArr['start-date']." 00:00:00";
		$this->endDate = $postArr['end-date']." 23:59:59";
		$this->seasonId = $postArr['seasonId'];
		$this->category = $postArr['category'];
		$this->station = $postArr['station'];
		
		$this->con = new HDatabase();
		$this->con->connect();

		$dataSet = $this->getInvoiceData();
		$this->viewData($dataSet);
	}

	function getInvoiceData(){

		if($this->category == 5){
			return $this->getSmallQuantity();
		}else{
			return $this->getNonSmallQuantity();
		}

	}

	function getSmallQuantity(){
		$this->con->resetResult();
		$this->con->select("qa_grade","diameter,fruitCount","cate_id='$this->category'");
		$subGrades = $this->con->getResult();

		$dataArray = array();

		foreach($subGrades as $grade){
			$gradeName = $grade['diameter'];
			$fruitCount = $grade['fruitCount'];
			$this->con->resetResult();
						
			if($this->station!="tot"){
			//	$this->con->query("SELECT * FROM qa_small_belongs sb LEFT JOIN qa_stockUpdates_small su on su.stationId='".$this->station."' and sb.gradeName='".$gradeName."'");
				$queryStr = "SELECT * FROM qa_small_belongs sb,qa_stockUpdates_small su ";
				$queryStr.= "WHERE sb.id=su.areaId AND sb.date=su.date AND sb.vehicleNo=su.vehicleNo AND ";
				$queryStr.= "su.stationId='".$this->station."' AND sb.gradeName='".$gradeName."' AND ";
				$queryStr.= "sb.date<='$this->endDate' AND sb.date>='".$this->startDate."'";
					
				$this->con->query($queryStr);
			}else {
				$this->con->select("qa_small_belongs","*","gradeName='$gradeName'");
			}
			$quantityResult = $this->con->getResult();
				
			$dataArray[$fruitCount] = 0;
			foreach($quantityResult as $quantity){
				$dataArray[$fruitCount] += $quantity['11-14']+$quantity['14-17']+$quantity['17-29']+$quantity['29-44']+$quantity['CRS'];
			}
		}
		return $dataArray;
	}

	function getNonSmallQuantity(){
		$this->con->resetResult();
		$this->con->select("qa_grade","gradeId,fruitCount","cate_id='$this->category'");
		$subGrades = $this->con->getResult();
		$dataArray = array();
		
		foreach ($subGrades as $grade){
			$gradeId = $grade['gradeId'];
			$fruitCount = $grade['fruitCount'];
			$this->con->resetResult();
            
			if($this->station!="tot"){
				$queryStr = "SELECT SUM(gs.payableQuantity) FROM qa_gradeStock gs ";
				$queryStr.= ",qa_stockUpdates su WHERE gs.id=su.areaId AND gs.vehicleNo=su.vehicleNo ";
				$queryStr.= "AND gs.date=su.date AND su.stationId='".$this->station."' ";
				$queryStr.= "AND gs.gradeId='".$gradeId."' ";
				$queryStr.= "AND gs.date<='$this->endDate' AND gs.date>='$this->startDate' ";
				
				$this->con->query($queryStr);
				//$this->con->query("SELECT SUM(gs.payableQuantity) FROM qa_gradeStock gs LEFT JOIN qa_stockUpdates su ON gs.id=su.areaId AND gs.vehicleNo=su.vehicleNo AND gs.date=su.date AND su.stationId='".$this->station."' AND gs.gradeId='".$gradeId."'");
				$quantityResult = $this->con->getResult();
				$dataArray[$fruitCount] = $quantityResult[0]['SUM(gs.payableQuantity)'];
			}else{
				$this->con->select("qa_gradeStock","SUM(payableQuantity)","gradeId='$gradeId' AND date<='$this->endDate' AND date>='$this->startDate'");
				$quantityResult = $this->con->getResult();
				$dataArray[$fruitCount] = $quantityResult[0]['SUM(payableQuantity)'];
			}			
		}
		return $dataArray;
	}

	function viewData($dataArr){ ?>
		<table id="valueTable">
			<tr>
				<td><b>Qty Kgs</b></td>
				<td><b>Description</b></td>
				<td><b>Unit Price (USD)</b></td>
				<td><b>Value (USD)</b></td>
			</tr>
			<tr>
				<td></td>
				<td><b>GRN Nos.</b>
					<p onclick="genT(this)" class="pTag" id="grnNo"></p>
				</td>
				<td></td>
				<td></td>
			</tr>
			<?php 
			$i = 1;
			foreach ($dataArr as $key=>$value){ ?>
						<tr>
						<td align="center" ><p onclick="genI(this)" class="editable" id="qty<?php echo $i?>" ><?php echo $value?></p></td>
						<td align="center" ><p onclick="genI(this)" class="editable" id="type<?php echo $i?>" ><?php echo $key?></p>-<b> Fresh Fruits</b></td>
						<td align="center" ><p onclick="genTotalInput(this,'<?php echo $i?>')" class="editable" id="unitPrice<?php echo $i?>">0.00</p></td>
						<td align="center" ><p  id="totPrice<?php echo $i?>" >0.00</p></td>
						</tr>
						
			<?php $i++;
			}
			?>
			<tr style="border-top:1px solid #ccc"><td  align="right" colspan="3"><h4> TOTAL (USD)</h4> </td><td align="center"><h4 id='totalAmount'>0.00</h4></td></tr>
			</table>
			
			
			<?php 
	}

}

?>