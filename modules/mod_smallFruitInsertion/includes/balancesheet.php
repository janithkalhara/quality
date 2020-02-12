<div id="wrapperDiv">
	<form action="" id="form5">
		<input type="hidden" id="tmNumbers" value="">
 			<table	 width="960" border="1" cellpadding="0" cellspacing="0" style="margin-bottom:20px" class="navigateable"> 
				<tr height="25">
				    <td colspan="2" style="text-align:right;padding-right:5px">Grade</td>
				    <td colspan="2" style="text-align:center; font-weight:bold">11-14.5</td>
				    <td colspan="6">&nbsp;</td>
				</tr>
				<tr valign="middle" height="30" class="thDiv">
				<?php foreach ($tableHeaders as $name=>$val){ ?>
				    <td  align="center" width="<?php echo $val['w']?>" height="25"><?php echo $name?></td>
				<?php }?>
				</tr>
				<tr height="30"   >
				<?php foreach( range(0,9) as $i){ ?>
				    <td align="center"><input type="text" class="tdDiv" id="bsheet-1-<?php echo $i?>" onkeyup="setKey(this.id,event)" onblur=calculate_Bsheet(this.id,this.value) /></td>
				<?php }?>
				</tr>
				<tr height="25" >
				    <td  align="center"  colspan="2" style="text-align:right;padding-right:5px">Off Grade %</td>
				    <td  align="center" colspan="1"><input type="text" class="tdDiv" id="1-offgrade" disabled="disabled"/></td>
				    <td colspan="7">&nbsp;</td>    
				</tr>
				<tr  height="5" style="background:#ccc"> </tr>
				<tr height="25">
    				<td colspan="2"  align="center" style="text-align:right;padding-right:5px">Grade</td>
    				<td colspan="2"  align="center"  style="text-align:center;font-weight:bold">14.5-17.0</td>
    				<td colspan="6">&nbsp;</td>    
    			</tr>
    			<tr height="30" class="thDiv">
			   	<?php foreach ($tableHeaders as $name => $val){ ?>
			  		<td  align="center" width="<?php echo $val['w']?>" height="25"><?php echo $name?></td>
			  	<?php }?>
   				</tr>
  				<tr height="30"  >
  				<?php foreach(range(0,9) as $i){ ?>
  					<td align="center"><input type="text" class="tdDiv" id="bsheet-2-<?php echo $i?>" onkeyup="setKey(this.id,event)" onblur=calculate_Bsheet(this.id,this.value) /></td>
    			<?php }?>
    			</tr>
				<tr height="25" >
					<td colspan="2"  align="center" style="text-align:right;padding-right:5px">Off Grade %</td>
					<td colspan="1" align="center" ><input type="text" class="tdDiv" id="2-offgrade" disabled="disabled"/></td>
					<td colspan="7">&nbsp;</td>    
				</tr>
				<tr  height="5" style="background:#ccc"> </tr>
				<tr height="25">
					<td colspan="2"  align="center" style="text-align:right;padding-right:5px">Grade</td>
					<td colspan="2"  align="center" style="text-align:center;font-weight:bold">17.0-29.0</td>
					<td colspan="6">&nbsp;</td>
				</tr>
				<tr height="30" class="thDiv">
				<?php foreach ($tableHeaders as $name=>$val){ ?>
					<td  align="center" width="<?php echo $val['w']?>" height="25"><?php echo $name?></td>
   				<?php }?>
   				</tr>
  				<tr height="30"  >
  				<?php foreach(range(0,9) as $i){ ?>
     				<td align="center"><input type="text" class="tdDiv" id="bsheet-3-<?php echo $i?>" onkeyup="setKey(this.id,event)" onblur=calculate_Bsheet(this.id,this.value) /></td>
    			<?php }?>
    			</tr>
  				<tr height="25" >
    				<td colspan="2"  align="center" style="text-align:right;padding-right:5px">Off Grade %</td>
    				<td colspan="1" align="center" ><input type="text" class="tdDiv" id="3-offgrade" disabled="disabled" /></td>
    				<td colspan="7" align="center" >&nbsp;</td>    
  				</tr>
 				<tr  height="5" style="background:#ccc"> </tr>
  				<tr height="25">
    				<td colspan="2"  align="center" style="text-align:right;padding-right:5px">Grade</td>
    				<td colspan="2"  align="center" style="text-align:center;font-weight:bold">29.0-44.0</td>
    				<td colspan="6">&nbsp;</td>
   				</tr>
  				<tr height="30" class="thDiv">
   				<?php foreach ($tableHeaders as $name=>$val){ ?>
    				<td  align="center" width="<?php echo $val['w']?>" height="25"><?php echo $name?></td>
   				<?php }?>
   				</tr>
  				<tr height="30" >
  				<?php foreach (range(0,9) as $i){ ?>
     				<td align="center"><input type="text" class="tdDiv" id="bsheet-4-<?php echo $i?>" onkeyup="setKey(this.id,event)" onblur=calculate_Bsheet(this.id,this.value) /></td>
     			<?php }?>
   				</tr>
  				<tr height="25">
    				<td colspan="2"  align="center" style="text-align:right;padding-right:5px">Off Grade %</td>
    				<td colspan="1" align="center" ><input type="text" class="tdDiv" id="4-offgrade" disabled="disabled"/></td>
    				<td colspan="7" align="center" >&nbsp;</td>    
  				</tr>
  				<tr  height="5" style="background:#ccc"> </tr>
  				<tr height="25">
    				<td colspan="2" align="center" style="text-align:right;padding-right:5px">Grade</td>
    				<td colspan="2" align="center" style="text-align:center;font-weight:bold">CRS</td>
    				<td colspan="6" align="center" >&nbsp;</td>
   				</tr>
  				<tr height="30" class="thDiv">
 				<?php foreach ($tableHeaders as $name=>$val){ ?>
    				<td  align="center" width="<?php echo $val['w']?>" height="25"><?php echo $name?></td>
   				<?php }?> 
   				</tr>
  				<tr height="30" >
  				<?php foreach (range(0,9) as $i){ ?>
     				<td align="center"><input type="text" class="tdDiv" id="bsheet-5-<?php echo $i?>" onkeyup="setKey(this.id,event)" onblur=calculate_Bsheet(this.id,this.value) /></td>
	   			<?php }?>
     			</tr>
  				<tr height="25" >
    				<td colspan="2" align="center"  style="text-align:right;padding-right:5px">Off Grade %</td>
    				<td colspan="1" align="center" ><input type="text" class="tdDiv" id="5-offgrade" disabled="disabled" /></td>
    				<td colspan="7" align="center" >&nbsp;</td>    
  				</tr>
  				<tr  height="5" style="background:#ccc"> </tr>
  				<tr height="25">
    				<td colspan="2" align="center"  style="text-align:right;padding-right:5px">Total</td>
    				<td colspan="8">&nbsp;</td>
	   			</tr>
  				<tr height="30" class="thDiv">
     			<?php foreach ($tableHeaders as $name=>$val){ ?>
    				<td  align="center" width="<?php echo $val['w']?>" height="25"><?php echo $name?></td>
   				<?php }?>
   				</tr>
 				<tr height="30"  >
 				<?php foreach (range(0,9) as $i){ ?>
     				<td align="center"><input type="text" class="tdDiv" id="bsheet-6-<?php echo $i?>" onkeyup="setKey(this.id,event)" /></td>
     			<?php }?>
    			</tr>
  				<tr height="25" >
    				<td colspan="2" align="center"  style="text-align:right;padding-right:5px">Off Grade %</td>
    				<td colspan="1" align="center" ><input type="text" class="tdDiv" id="6-offgrade" disabled="disabled" /></td>
    				<td colspan="7" align="center" >&nbsp;</td>    
  				</tr>	
   				<tr height="25">
    				<td colspan="2" style="text-align:right;padding-right:5px">Total Percentages %</td>
    				<td colspan="8">nbsp;</td>
   				</tr>
   				<tr height="30" class="thDiv">
   				<?php foreach ($tableHeaders as $name=>$val){ ?>
    				<td  align="center" width="<?php echo $val['w']?>" height="25"><?php echo $name?></td>
   				<?php }?>
   				</tr>
  				<tr height="30"  >
  				<?php foreach (range(0,9) as $i){ ?>
     				<td  align="center"><input type="text" class="tdDiv" id="bsheet-7-<?php echo $i?>" disabled="disabled" /></td>
		   		<?php }?> 
   				</tr>
     			<tr style="background:#ccc">
  					<td colspan="2" align="center"  style="padding:8px;"> Total Number of Crates/bags</td>
  					<td colspan="8"  style="padding:8px"><input type="text" class="tdDiv" id="numofcrates" /></td>
  				</tr> 
		</table>
	</form>
<hr>
<button class="btn btn-primary buttons" onclick="<?php echo $edit?'editMe()':'submitMe()'?>"><i class="icon icon-save"></i> Submit Data</button>
<button class="btn  buttons" onclick="resetMe()"><i class="icon icon-undo"></i> Reset DataSheet</button>
<button class="btn  buttons" onclick="printMe()"> <i class="icon icon-print"></i> Print	</button>
</div>