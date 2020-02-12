<?php

$db=new HDatabase();
$db->connect();
$db->select("qa_user qu","qu.userId,qu.fname,qu.lname"," qu.userId IN (SELECT qa.userId FROM qa_area qa)");
$res=$db->getResult();
?>
<div id="supplierNamesView">
	<h2 align="center">Registered Suppliers</h2>';
<?php 
if($res){
	foreach ($res as $temp){
		$inchargeName = $temp['fname']." ".$temp['lname'];
		$userId = $temp['userId'];
		$db->resetResult();
		$db->select('qa_area','DISTINCT season',"userId='$userId'");
		$seasonIds = $db->getResult();
		//$seasons = "<option>Select Season</option>";
		$seasons = '<option value="-1">Select season</option>';
		foreach ($seasonIds as $s){
			$seasonId = $s['season'];
			$db->resetResult();
			$db->select('qa_seasons','seasonName',"seasonId='$seasonId'");
			$sea = $db->getResult();
			foreach ($sea as $s){
				$seasons .= '<option value="'.$seasonId.'" >'.$s['seasonName'].'</option>';
			}
		}
		?>
		<div class="supplier-list">
			<p class="supplier-name"><i class="icon icon-caret-right handlers"></i> <?php echo $temp['fname']." ".$temp['lname']; ?></p>
			<div class="details">
				<select class="show-profile" data-name="<?php echo $inchargeName; ?>" data-id="<?php echo $temp['userId']; ?>">
					<?php echo $seasons; ?>
				</select>
			
			</div>
		</div>
		<?php		
	}
?>
</div>
<?php 
}else {
	return false;
}
?>

<script
	type="text/javascript"
	src="libraries/highcharts/js/highcharts.js"></script>
<script
	type="text/javascript"
	src="libraries/highcharts/js/modules/exporting.js"></script>
<script
	type="text/javascript"
	src="modules/mod_supplierProfile/js/supplierProfile.js"></script>

<link
	href="modules/mod_supplierProfile/css/supplierProfile.css"
	rel="stylesheet" type="text/css" />


<div id="supplierProfile">
	<h2 >Supplier Profile 
		<button class="icon btn " id="backButton" onclick="back()"><i class="icon icon-caret-left"></i> Back</button>
	</h2>
	<div id="detailsArea">
		<div class="profPic"></div>
		<div class="details">
			<table >
				<tr class="trValidater">
					<td width="60px"><b>Name</b></td>
					<td id="supplierName"></td>
				</tr>
				<tr class="trValidater">
					<td width="60px"><b>Area</b></td>
					<td id="supplierAddress"></td>
				</tr>
				<tr class="trValidater">
					<td width="60px"><b>Project</b></td>
					<td width="280px">:<select id="projectDiv"></select>
					</td>
				</tr>
				<tr class="trValidater">
					<td width="60px"><b>Grades</b></td>
					<td>:<select id="subGrade"></select></td>
				</tr>
			</table>
		</div>
			

		<div class="centerName">
			<h4>Centers</h4> 
			<div class="centerView"></div>
		</div>
	</div>

	<div id="graphArea">
		<hr style="border: 1px solid #666666; position: relative; top: -10px" />

		<h2 style="position: relative;" align="center">Arrival Pattern of Crops</h2>
		<div id="graph2">&nbsp;</div>
		<hr style="border: 1px solid #666666; margin-bottom: 20px" />
		<div style="z-index: 20000; width: 900px; margin: 0 auto 0 auto"
			id="graph1">&nbsp;</div>

		<table >
			<tr height="20px">
				<td width="200px" class="tdClass head">Category Type</td>
				<td width="200px" class="tdClass head">Quantity (kg)</td>
				<td width="200px" class="tdClass head">Percentage (%)</td>
			</tr>
			<tr height="20px">
				<td width="200px" class="tdClass"
					style="text-align: left; padding-left: 10px"><b>Weight Loss</b></td>
				<td class="tdClass" id="weightLoss"></td>
				<td class="tdClass" id="perWeightLoss"></td>
			</tr>
			<tr height="20px">
				<td width="200px" class="tdClass"
					style="text-align: left; padding-left: 10px"><b>Rejected</b>
				</td>
				<td class="tdClass" id="reject"></td>
				<td class="tdClass" id="perReject"></td>
			</tr>
		</table>
		<hr style="border: 1px solid #666666; margin-bottom: 20px" />
		<div style="z-index: 20000; width: 900px; margin: 0 auto 0 auto"
			id="graph3">&nbsp;</div>



	</div>
</div>

