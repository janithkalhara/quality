<div width="870" height="1300" style="background:#fff;">
  	<table width="870" height="60" border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse;font-size:11px">
  		<tr height="25">
 			<td colspan="2" align="center"><b>HJS Condiments Limited <br>SunFrost (PVT) LTD</b></td>
 			<td colspan="6" align="center"><b>ගර්කින් තත්ව පරීක්ෂණ වාර්තාව (Small Grade)</b></td>
		</tr>
		<tr height="10"><td colspan="10" align="center"  bgcolor="#ccc"></td></tr>
    	<tr height="30">
      		<td width="160" ><p style="float:right; margin:0">Project :</p></td>
      		<td width="160" id="print-project"></td>
      		<td width="160" ><p style="float:right; margin:0">Centers:</p></td>
      		<td colspan="5"  id="print-centers"></td>
    	</tr>
     	<tr>
    		<td  align="right"> Number Of Crates/Bags</td>
      		<td></td>
    		<td align="right">TM numbers</td>
    		<td colspan="5"><?php echo  $this->tms?></td>
   		</tr>
		<tr>
	      	<td width="160"><p style="float:right; margin:0">Date</p></td>
	      	<td width="160" id="print-date"></td>
	      	<td width="160"><p style="float:right; margin:0">BatchNo:</p></td>
	      	<td width="160" id="print-batchNo"></td>
	      	<td width="160"  ><p style="float:right; margin:0">Vehicle No:</p></td>
	      	<td width="160" id="print-vehicleNo"></td>
	      	<td width="160" ><p style="float:right; margin:0">Internal TM No:</p></td>
	      	<td width="160" id="print-itmNo"></td>
		</tr>
  	</table>
  	<table width="870">
  		<tr>
  			<td><?php $this->renderTable(0); ?></td>
  			<td><?php $this->renderTable(1); ?></td>
	  	</tr>
	  	<tr>
	  		<td><?php $this->renderTable(2); ?></td>
  			<td><?php $this->renderTable(3); ?></td>
	  	</tr>
	  	<tr>
	  		<td colspan="2">
			  		<table width="870" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse;font-size:11px">
				    <tr>
					      <td width="155">&nbsp;</td>
					      <td colspan="3"><p style="float:right; margin:0">Grade:</p></td>
					      <td colspan="3" id='crs-grade'><?php print $this->grades[4]?></td>
					      <td colspan="9">&nbsp;</td>
				    </tr>
				    <tr>
					      <td>මුළු ගෙඩි ගණන</td>
					      <?php foreach (range(0,12) as $i){ ?>
					      <td align="center" width="32" id="crs-0-<?php echo $i?>"><?php if(isset($this->CRSSamples[$i]['fruitCount'])) echo $this->CRSSamples[$i]['fruitCount']?></td>
					      <?php }?>
					      <td align="center" width="32" id="crs-0-13">Sum</td>
					      <td align="center" width="32" id="crs-0-14">%</td>
					      <td rowspan="13" width="8">&nbsp;</td>
					      <td width="180">ප්‍රවාහන තත්වය</td>
					      <td width="60">විස්තරය</td>
					      <td width="160">අවශ්‍ය තත්වය</td>
				    </tr>
				    <tr>
					     <td >කුඩා ගෙඩි ගණන</td>
					     <?php foreach (range(0,12) as $i){ ?>
					     <td align="center" width="32" id="crs-0-<?php echo $i?>"><?php if(isset($this->CRSSamples[$i]['smallFruit'])) echo $this->CRSSamples[$i]['smallFruit']?></td>
					     <?php }?>
					     <td align="center" id="crs-1-13"><?php if(isset($this->sampleCrsData['smallFruit']['sum']))echo $this->sampleCrsData['smallFruit']['sum']?></td>
					     <td align="center" id="crs-1-14"><?php if(isset($this->sampleCrsData['smallFruit']['per']))echo $this->sampleCrsData['smallFruit']['per']?></td>
					     <td >බාර දීම</td>
					     <td id="transport-delivery"><?php echo $respond[$this->transportData['delivery']]; ?></td>
					     <td >සවස 3.00ට පෙර</td>
				    </tr>
		    		<tr>
				     	<td >ලොකු ගෙඩි ගණන</td>
				     	<?php foreach (range(0,12) as $i){ ?>
				    	<td align="center" width="32" id="crs-0-<?php echo $i; ?>"><?php if(isset($this->CRSSamples[$i]['largeFruit'])) print $this->CRSSamples[$i]['largeFruit']; ?></td>
				      	<?php }?>
				      	<td align="center" id="crs-2-13"><?php if(isset($this->sampleCrsData['largeFruit']['sum']))print $this->sampleCrsData['largeFruit']['sum']?></td>
				      	<td align="center" id="crs-2-14"><?php if(isset($this->sampleCrsData['largeFruit']['per']))print $this->sampleCrsData['largeFruit']['per']?></td>
				      	<td rowspan="2">ලොරිය ආවරණය</td>
				      	<td rowspan="2" id="transport-cover"><?php print $respond[$this->transportData['cover']]?></td>
				      	<td  rowspan="2">හොඳින් ආවරණය කර තිබිය යුතුයි</td>
		    		</tr>
				    <tr>
				    	<td >ඉල් මැසි හානි</td>
				    	<?php foreach (range(0,12) as $i){ ?>
				      	<td align="center" width="32" id="crs-0-<?php echo $i; ?>"><?php if(isset($this->CRSSamples[$i]['melonFlyAttacked'])) echo $this->CRSSamples[$i]['melonFlyAttacked']?></td>
				      	<?php }?>
				      	<td align="center" id="crs-3-13"><?php if(isset($this->sampleCrsData['melonFlyAttacked']['sum']))print $this->sampleCrsData['melonFlyAttacked']['sum']?></td>
				      	<td align="center" id="crs-3-14"><?php if(isset($this->sampleCrsData['melonFlyAttacked']['per']))print $this->sampleCrsData['melonFlyAttacked']['per']?></td>
				      
				    </tr>
		   			<tr>
				  		<td  >පොතු ගැලවුණු</td>
				  		<?php foreach (range(0,12) as $i){ ?>
				      	<td align="center" width="32" id="crs-0-<?php echo $i; ?>"><?php if(isset($this->CRSSamples[$i]['peeledOff'])) print $this->CRSSamples[$i]['peeledOff']?></td>
				      	<?php }?>
				      	<td align="center" id="crs-4-13"><?php if(isset($this->sampleCrsData['peeledOff']['sum']))print $this->sampleCrsData['peeledOff']['sum']?></td>
				      	<td align="center" id="crs-4-14"><?php if(isset($this->sampleCrsData['peeledOff']['per']))print $this->sampleCrsData['peeledOff']['per']?></td>
				      	<td  rowspan="2">ලොරිය තුළ අනවශ්‍ය දුර්ගන්ධය</td>
				      	<td  rowspan="2" id="transport-smell"><?php print $respond[$this->transportData['smell']]?></td>
				      	<td  rowspan="2">නොතිබිය යුතුයි</td>
		    		</tr>
				    <tr>
					    <td  >පණු කුහර හානි</td>
					    <?php foreach (range(0,12) as $i){ ?>
					    	<td align="center" width="32" ><?php if(isset($this->CRSSamples[$i]['boreAttacked'])) print $this->CRSSamples[$i]['boreAttacked']?></td>
					   	<?php } ?>
					    <td align="center" id="crs-5-13"><?php if(isset($this->sampleCrsData['boreAttacked']['sum']))print $this->sampleCrsData['boreAttacked']['sum']?></td>
					    <td align="center" id="crs-5-14"><?php if(isset($this->sampleCrsData['boreAttacked']['per']))print $this->sampleCrsData['boreAttacked']['per']?></td>
				    </tr>
		    		<tr>
		   				<td>වැලි සහිත</td>
		   				<?php foreach (range(0,12) as $i){ ?>
		        		<td align="center" width="32"><?php if(isset($this->CRSSamples[$i]['sandEmbedded'])) print $this->CRSSamples[$i]['sandEmbedded']?></td>
		        		<?php } ?>
					    <td align="center" id="crs-6-13"><?php if(isset($this->sampleCrsData['sandEmbedded']['sum']))print $this->sampleCrsData['sandEmbedded']['sum']?></td>
					    <td align="center" id="crs-6-14"><?php if(isset($this->sampleCrsData['sandEmbedded']['per']))print $this->sampleCrsData['sandEmbedded']['per']?></td>
					    <td rowspan="2" >ගර්කින් හැර වෙනත් ද්‍රව්‍ය </td>
					    <td rowspan="2" id="transport-otherthings"><?php print $respond[$this->transportData['otherThings']]?></td>
					    <td rowspan="2">නොතිබිය යුතුයි</td>
		      		</tr>
		    		<tr>
		      			<td>හැකිළුණු ගෙඩි</td>
		     			<?php foreach (range(0,12) as $i){ ?>
		        		<td align="center" width="32" ><?php if(isset($this->CRSSamples[$i]['shrivelled'])) print $this->CRSSamples[$i]['shrivelled']?></td>
		        		<?php } ?>
		      			<td align="center" id="crs-7-13"><?php if(isset($this->sampleCrsData['shrivelled']['sum']))print $this->sampleCrsData['shrivelled']['sum']?></td>
		      			<td align="center" id="crs-7-14"><?php if(isset($this->sampleCrsData['shrivelled']['per']))print $this->sampleCrsData['shrivelled']['per']?></td>
		   
		   			</tr>
		    		<tr>
		   				<td>යාන්ත්‍රික හානි</td>
			      		<?php foreach (range(0,12) as $i){ ?>
		        		<td align="center" width="32" ><?php if(isset($this->CRSSamples[$i]['mechanicalDamaged'])) print $this->CRSSamples[$i]['mechanicalDamaged']?></td>
		        		<?php } ?>
		      			<td align="center" id="crs-8-13"><?php if(isset($this->sampleCrsData['mechanicalDamaged']['sum']))print $this->sampleCrsData['mechanicalDamaged']['sum']?></td>
		      			<td align="center" id="crs-8-14"><?php if(isset($this->sampleCrsData['mechanicalDamaged']['per']))print $this->sampleCrsData['mechanicalDamaged']['per']?></td>
		        		<td  rowspan="2">ලේබල්/හඳුනාගැනීමේ වර්ණ සංකේත</td>
		      			<td rowspan="2" id="transport-labels"><?php print $respond[$this->transportData['labels']]?></td>
		      			<td  rowspan="2">තිබිය යුතුයි</td>
		      
		    		</tr>
		    		<tr>
		    			<td >කහ පැහැති ගෙඩි</td>
		   				<?php foreach (range(0,12) as $i){ ?>
		        		<td align="center" width="32" ><?php if(isset($this->CRSSamples[$i]['yellowish'])) print $this->CRSSamples[$i]['yellowish']?></td>
		        		<?php } ?>
		      			<td align="center" id="crs-9-13"><?php if(isset($this->sampleCrsData['yellowish']['sum']))print $this->sampleCrsData['yellowish']['sum']?></td>
		      			<td align="center" id="crs-9-14"><?php if(isset($this->sampleCrsData['yellowish']['per']))print $this->sampleCrsData['yellowish']['per']?></td>
		    		</tr>
		   			<tr>
		   				<td>දුඹුරු පැල්ලම්</td>
		   				<?php foreach (range(0,12) as $i){ ?>
		        		<td align="center" width="32" ><?php if(isset($this->CRSSamples[$i]['rustPatches'])) print $this->CRSSamples[$i]['rustPatches']?></td>
		        		<?php }?>
					    <td align="center" id="crs-10-13"><?php if(isset($this->sampleCrsData['rustPatches']['sum']))print $this->sampleCrsData['rustPatches']['sum']?></td>
					    <td align="center" id="crs-10-14"><?php if(isset($this->sampleCrsData['rustPatches']['per']))print $this->sampleCrsData['rustPatches']['per']?></td>
		       			<td >තත්ව වාර්තාව</td>
		      			<td id="transport-qualityReport"><?php print $respond[$this->transportData['report']]?></td>
		      			<td >තිබිය යුතුයි</td>
				   	</tr>
		    		<tr>
		      			<td >නො/පිළිගත්(AC)/(RE)</td>
					    <?php foreach (range(0,12) as $i){ ?>
		        		<td align="center" width="32" ><?php if(isset($this->CRSSamples[$i]['accepted'])) print $this->CRSSamples[$i]['accepted']?></td>
		        		<?php }?>
					    <td align="center" id="crs-11-13"><?php if(isset($this->sampleCrsData['accepted']['sum']))print $this->sampleCrsData['accepted']['sum']?></td>
					    <td align="center" id="crs-11-14"><?php if(isset($this->sampleCrsData['accepted']['per']))print $this->sampleCrsData['accepted']['per']?></td>
		      			<td  colspan="3" rowspan="2"></td>
				    </tr>
				    <tr>
		     			<td  >නරක් වු ගෙඩි</td>
		     			<?php foreach (range(0,12) as $i){ ?>
		        		<td align="center" width="32" id="crs-0-0"><?php if(isset($this->CRSSamples[$i]['spoiled'])) print $this->CRSSamples[$i]['spoiled']?></td>
		        		<?php }?>
		      			<td align="center" id="crs-12-13"><?php if(isset($this->sampleCrsData['spoiled']['sum']))print $this->sampleCrsData['spoiled']['sum']?></td>
		      			<td align="center" id="crs-12-14"><?php if(isset($this->sampleCrsData['spoiled']['per']))print $this->sampleCrsData['spoiled']['per']?></td>
		    		</tr>
		  		</table>
	  		</td>
  		
	  	</tr>
  	</table>
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