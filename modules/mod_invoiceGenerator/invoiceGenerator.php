<?php 
global $import;
$import->importLib('season');
$season = new Season();

$seasonId = $season->getOngoingSeasonId();

$import->importLib('grade');
$gradeCategory = new Grade();
$gradeCategories = $gradeCategory->getGradeCategories();

$import->importClass("invoiceGenerator", "GetData");
?>

<script
	type="text/javascript"
	src="modules/mod_invoiceGenerator/js/invoiceGenerator.js"></script>
<link
	rel="stylesheet" type="text/css"
	href="modules/mod_invoiceGenerator/css/invoiceGenerator.css" />

<script type="text/javascript">
<?php 
$date = date("Y-m-d");
?>
</script>

<div id="outerDiv">
	<h3>Invoice Details</h3>
	<div id="selectTable">
		<form name="invoiceForm" action="home.php?option=mod_invoiceGenerator"
			method="post">
			<table>
				<tr>
					<td>  Station  <br/>
						<select name="station">
						<?php if($_POST['flag']){
							$station = $_POST['station'];
							if($station=="1"){print "<option value='1' selected='selected'>HJS</option>";}
							else{print "<option value='1'>HJS</option>";}
							if($station=="2"){print "<option value='2' selected='selected'>Alawwa</option>";}
							else{print "<option value='2'>Alawwa</option>";}
							if($station=="3"){print "<option value='3' selected='selected'>Padiyathalawa</option>";}
							else{print "<option value='3'>Padiyathalawa</option>";}
							if($station=="tot"){print "<option value='tot' selected='selected'>Total</option>";}
							else{print "<option value='tot'>Total</option>";}							
						} else{?>
							<option value="1">HJS</option>
							<option value="2">Alawwa</option>
							<option value="3">Padiyathalawa</option>
							<option value="tot" >Total</option>
						<?php }?>	
						</select>
					</td>
					<td>Grade Category <br/> <select name='category'>
							<?php 
							if(isset($_POST['flag'])){
								foreach ($gradeCategories as $cat){
									if($_POST['category'] == $cat['id']){
										print "<option selected='selected' value='".$cat['id']."'>".$cat['name']."</option>";
									}else{
										print "<option value='".$cat['id']."'>".$cat['name']."</option>";
									}
								}
							}else{
								foreach ($gradeCategories as $cat){
									print "<option value='".$cat['id']."'>".$cat['name']."</option>";
								}
							}
							?>
					</select>

					</td>
					<td>Start Date <br/> <input id="start-date" name="start-date" style="width: 100px;"
						autocomplete="off"
						value="<?php echo isset($_POST['flag']) ? $_POST['start-date'] : $date; ?>"
						/>
					</td>
					<td>End Date <br/> <input id="end-date" name="end-date" style="width: 100px"
						autocomplete="off"
						value="<?php echo isset($_POST['flag']) ? $_POST['end-date'] : $date; ?>"
						/>
					</td>
				</tr>
			</table>
			<input type="hidden" name="seasonId"
				value="<?php print $seasonId; ?>" /> <input type="hidden"
				name="flag" value="1" /> <input type="submit" />
		</form>
	</div>
	<div id="letterArea"
		style="border: 1px solid #CCC; padding: 3px; width: 100%; position: absolute; display: block;">
		<link rel="stylesheet"
			href="modules/mod_invoiceGenerator/css/invoiceGenerator_p.css"
			type="text/css" media="print">
		<div id="bar-1" class='bar'>
			<table class="header">
				<tr>
					<td><img src="images/invoice/sunfrost.png" />
					</td>
					<td>
						<h2 class="head"
							style="padding: 0px; margin: 1px; font-size: 14px;"><b>Sunfrost
							(PVT) Limited</b></h2>
						<p style="padding: 2px">25, Foster Lane</p>
						<p style="padding: 2px">Colombo 10, Srilanka .</p>
						<p style="padding: 2px">(94)-11-5736211, 5736282</p>
						<p style="padding: 2px">Fax (94)-11-2465720</p>
					</td>
					<td><img alt="" src="images/invoice/awards.png">
					</td>
					<td>
						<table class="r">
							<tr>
								<td style="width: 120px"><h5 ><b>Company
										No</b></h5></td>
								<td><p style="padding: 2px; margin: 0px" class="pTag editable"
										id="companyno" onclick="genI(this)">PB 486</p>
								</td>
							</tr>
							<tr>
								<td style="width: 120px"><h5> <b>Invoice
										No.</b></h5></td>
								<td><p style="padding: 2px; margin: 0px" class="pTag editable"
										id="invoiceno" onclick="genI(this)">invoice no</p>
								</td>
							</tr>
							<tr>
								<td style="width: 120px"><h5> <b>SVAT
										No.</b></h5></td>
								<td><p style="padding: 2px; margin: 0px" class="pTag editable"
										id="svatno" onclick="genI(this)">SVAT003366</p>
								</td>
							</tr>
							<tr>
								<td style="width: 120px"><h5> <b>VAT Reg.
										No.</b></h5></td>
								<td><p style="padding: 2px; margin: 0px" class="pTag editable"
										id="vatregno" onclick="genI(this)">134001887 7000</p>
								</td>
							</tr>
						</table>

					</td>
				</tr>
			</table>
		</div>
		<div id="bar-2" class="bar">
			<div class="left">
				<fieldset>
					<legend><b>Customer</b></legend>
					<table>
						<tr>
							<td>
								<table>
									<tr>
										<td><b>Name</b></td>
										<td><p onclick="genI(this)" class="pTag editable"
												id="companyName">H.J.S.Condiments Limited,</p></td>
									</tr>
									<tr>
										<td><b>Address</b></td>
										<td><p onclick="genT(this)" class="pTag editable"
												id="companyAddress">
												No. 61,61A,62,63, <br /> Biyagama Export Processing Zone,
												Biyagama.
											</p></td>
									</tr>
									<tr>
										<td><b>Phone</b></td>
										<td><p onclick="genI(this)" class="pTag editable"
												id="companyPhoneNo">(94) 11 - 2465756, 245271</p></td>
									</tr>
									<tr>
										<td><b>VAT Reg. No.</b></td>
										<td><p onclick="genI(this)" class="pTag editable"
												id="companyRegNo">134004363 7000</p></td>
									</tr>
								</table>
							</td>
							<td></td>
						</tr>
					</table>
				</fieldset>
			</div>
			<div class="right">
				<fieldset><legend><b>Date</b></legend>
					<table>
						<tr>
							<td><b>Date Delivered</b></td>
							<td><p onclick="genI(this)" id="deliveryDate" data_id="date" class="editable"><?php print $date;?></p></td>
						</tr>
						<tr>
							<td></td>
							<td><?php $dateSplit =explode("-",$_POST['start-date']);echo date("F", mktime(0, 0, 0, $dateSplit[1], 10));?>&nbsp;&nbsp;<?php echo $dateSplit[0];?></td>
						</tr>
					</table>
				</fieldset>
			</div>
		</div>
		<div id="bar-3" class="bar">
		<?php 
			if(isset($_POST['flag'])){
				new GetData($_POST);
		?>		
		<div id="stat-month-sale">
		<h4 align="center">Sales of fresh gherkins for the Month of <span id="month-sales"><?php $dateSplit =explode("-",$_POST['start-date']);echo date("F", mktime(0, 0, 0, $dateSplit[1], 10)); ?></span>, <?php echo $dateSplit[0]; ?></h4>
		<h4 align="center">( Period : <span id="month-sales-s"><?php echo $_POST['start-date'] ?></span> to <span id="month-sales-e"><?php echo $_POST['end-date'] ?></span> )</h4>
		<p align="center">..............................................</p>
		<h4 align="center">Prepared By</h4>
		</div>
		<?php 	}	?>
		
		</div>
		</div>
		</div><div style="position:relative">
<input
	type="button" onclick='printInvoice()' value="Print Invoice" /></div>
