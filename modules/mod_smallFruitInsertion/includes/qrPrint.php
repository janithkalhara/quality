
<div width="870" height="1300" style="background:#fff;">
  <table width="870" height="60" border="1" cellpadding="0" cellspacing="0" style=" border-collapse:collapse; font-size:11px">
  	<tr height="25">
  		<td colspan="2" align="center"><b>HJS Condiments Limited <br>SunFrost (PVT) LTD</b></td>
		<td colspan="6" align="center"><b>ගර්කින් තත්ව පරීක්ෂණ වාර්තාව (Small Grade)</b>
        <div style="float:right;border-left:1px solid #000" >Issue No:01 <br> Issue Date: <?php echo date('d-m-y')?></div>
        </td>
    </tr>
	<tr height="10"><td colspan="10" align="center"  bgcolor="#ccc"></td></tr>
    <tr height="30">
      <td width="160" ><p style="float:right; margin:0">Project :&nbsp;&nbsp;</p></td>
      <td width="160" id="print-project">&nbsp;</td>
      <td width="160" ><p style="float:right; margin:0">Centers:&nbsp;&nbsp;</p></td>
      <td colspan="5" id="print-centers">&nbsp;</td>
    </tr>
    <tr>
      <td width="160"><p style="float:right; margin:0">Date&nbsp;&nbsp;</p></td>
      <td width="160" id="print-date">&nbsp;</td>
      <td width="160"><p style="float:right; margin:0">BatchNo:&nbsp;&nbsp;</p></td>
      <td width="160" id="print-batchNo">&nbsp;</td>
      <td width="160"  ><p style="float:right; margin:0">Vehicle No:&nbsp;&nbsp;</p></td>
      <td width="160" id="print-vehicleNo">&nbsp;</td>
      <td width="200" ><p style="float:right; margin:0">Internal TM No:&nbsp;&nbsp;</p></td>
      <td width="160" id="print-itmNo">&nbsp;</td>
    </tr>
  </table>
  <hr>
  <table width="870" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse;font-size:11px">
    <tr>
      <td width="150">&nbsp;</td>
      <td colspan="3"><p style="float:right; margin:0">Grade:&nbsp;&nbsp;</p></td>
      <td colspan="3" id="0-grade">&nbsp;</td>
      <td colspan="7">&nbsp;</td>
      <td width="8" rowspan="11">&nbsp;</td>
      <td colspan="3"><p style="float:right; margin:0">Grade:&nbsp;&nbsp;</p></td>
      <td colspan="3" id="1-grade">&nbsp;</td>
      <td colspan="7">&nbsp;</td>
    </tr>
    <tr>
      <td align="left">සාම්පල් අංකය</td>
      <?php 
      for($i=0;$i<2;$i++){
      	for($j=0;$j<13;$j++){
      		
      		print "<td width='32' align='center' id='$i-0-$j'>&nbsp;</td>";
      	}
      	
      }
      
      ?>
     
    </tr>
    <tr>
      <td align="left">ඉල් මැසි හානි</td>
       <?php 
      for($i=0;$i<2;$i++){
        for($j=0;$j<13;$j++){
            
            print "<td width='32' align='center' id='$i-1-$j'>&nbsp;</td>";
        }
        
      }
      
      ?>
      
    </tr>
    <tr>
     <td align="left">පොතු ගැලවුණු</td>
       <?php 
      for($i=0;$i<2;$i++){
        for($j=0;$j<13;$j++){
            
            print "<td width='32' align='center' id='$i-2-$j'>&nbsp;</td>";
        }
        
      }
      
      ?>
      
    </tr>
    <tr>
     <td align="left">පණු කුහර හානි</td>
      <?php 
      for($i=0;$i<2;$i++){
        for($j=0;$j<13;$j++){
            
            print "<td width='32' align='center' id='$i-3-$j'>&nbsp;</td>";
        }
        
      }
      
      ?>
      
    </tr>
    <tr>
     <td align="left">හැකිළුණු ගෙඩි</td>
      <?php 
      for($i=0;$i<2;$i++){
        for($j=0;$j<13;$j++){
            
            print "<td width='32' align='center' id='$i-4-$j'>&nbsp;</td>";
        }
        
      }
      
      ?>
      
    </tr>
    <tr>
      <td align="left">යාන්ත්‍රික හානි</td>
       <?php 
      for($i=0;$i<2;$i++){
        for($j=0;$j<13;$j++){
            
            print "<td width='32' align='center' id='$i-5-$j'>&nbsp;</td>";
        }
        
      }
      
      ?>
      
    </tr>
    <tr>
      <td align="left">කහ පැහැති ගෙඩි</td>
       <?php 
      for($i=0;$i<2;$i++){
        for($j=0;$j<13;$j++){
            
            print "<td width='32' align='center' id='$i-6-$j'>&nbsp;</td>";
        }
        
      }
      
      ?>
      
    </tr>
    <tr>
      <td align="left">දුඹුරු පැල්ලම්</td>
       <?php 
      for($i=0;$i<2;$i++){
        for($j=0;$j<13;$j++){
            
            print "<td width='32' align='center' id='$i-7-$j'>&nbsp;</td>";
        }
        
      }
      
      ?>
      
    </tr>
    <tr>
      <td align="left">නරක් වු ගෙඩි</td>
       <?php 
      for($i=0;$i<2;$i++){
        for($j=0;$j<13;$j++){
            
            print "<td width='32' align='center' id='$i-8-$j'>&nbsp;</td>";
        }
        
      }
      
      ?>
      
    </tr>
    <tr>
      <td align="left">මුළු දෝෂ ගණන</td>
       <?php 
      for($i=0;$i<2;$i++){
        for($j=0;$j<13;$j++){
            
            print "<td width='32' align='center' id='$i-9-$j'>&nbsp;</td>";
        }
        
      }
      
      ?>
      
    </tr>
  </table>
  <tr height="6"></tr>
  <hr>
  <table width="870" border="1" cellspacing="0" cellpadding="0" style="font-size:11px; border-collapse:collapse">
    <tr>
      <td width="150">&nbsp;</td>
      <td colspan="3"><p style="float:right; margin:0">Grade:</p></td>
      <td colspan="3" id="2-grade">&nbsp;</td>
      <td colspan="7">&nbsp;</td>
      <td width="8" rowspan="11">&nbsp;</td>
      <td colspan="3"><p style="float:right; margin:0">Grade:</p></td>
      <td colspan="3" id="3-grade">&nbsp;</td>
      <td colspan="7">&nbsp;</td>
    </tr>
    <tr>
      <td align="left">සාම්පල් අංකය</td>
       <?php 
      for($i=2;$i<4;$i++){
        for($j=0;$j<13;$j++){
            
            print "<td width='32' align='center' id='$i-0-$j'>&nbsp;</td>";
        }
        
      }
      
      ?>
      
    </tr>
    <tr>
      <td align="left">ඉල් මැසි හානි</td>
       <?php 
      for($i=2;$i<4;$i++){
        for($j=0;$j<13;$j++){
            
            print "<td width='32' align='center' id='$i-1-$j'>&nbsp;</td>";
        }
        
      }
      
      ?>
     
    </tr>
    <tr>
      <td align="left">පොතු ගැලවුණු</td>
       <?php 
      for($i=2;$i<4;$i++){
        for($j=0;$j<13;$j++){
            
            print "<td width='32' align='center' id='$i-2-$j'>&nbsp;</td>";
        }
        
      }
      
      ?>
     
    </tr>
    <tr>
      <td align="left">පණු කුහර හානි</td>
       <?php 
      for($i=2;$i<4;$i++){
        for($j=0;$j<13;$j++){
            
            print "<td width='32' align='center' id='$i-3-$j'>&nbsp;</td>";
        }
        
      }
      
      ?>
      
    </tr>
    <tr>
      <td align="left">හැකිළුණු ගෙඩි</td>
       <?php 
      for($i=2;$i<4;$i++){
        for($j=0;$j<13;$j++){
            
            print "<td width='32' align='center' id='$i-4-$j'>&nbsp;</td>";
        }
        
      }
      
      ?>
      
    </tr>
    <tr>
      <td align="left">යාන්ත්‍රික හානි</td>
       <?php 
      for($i=2;$i<4;$i++){
        for($j=0;$j<13;$j++){
            
            print "<td width='32' align='center' id='$i-5-$j'>&nbsp;</td>";
        }
        
      }
      
      ?>
      
    </tr>
    <tr>
      <td align="left">කහ පැහැති ගෙඩි</td>
       <?php 
      for($i=2;$i<4;$i++){
        for($j=0;$j<13;$j++){
            
            print "<td width='32' align='center' id='$i-6-$j'>&nbsp;</td>";
        }
        
      }
      
      ?>
      
    </tr>
    <tr>
      <td align="left">දුඹුරු පැල්ලම්</td>
       <?php 
      for($i=2;$i<4;$i++){
        for($j=0;$j<13;$j++){
            
            print "<td width='32' align='center' id='$i-7-$j'>&nbsp;</td>";
        }
        
      }
      
      ?>
      
    </tr>
    <tr>
      <td align="left">නරක් වු ගෙඩි</td>
       <?php 
      for($i=2;$i<4;$i++){
        for($j=0;$j<13;$j++){
            
            print "<td width='32' align='center' id='$i-8-$j'>&nbsp;</td>";
        }
        
      }
      
      ?>
    </tr>
    <tr>
      <td align="left">මුළු දෝෂ ගණන</td>
       <?php 
      for($i=2;$i<4;$i++){
        for($j=0;$j<13;$j++){
            
            print "<td width='32' align='center' id='$i-9-$j'>&nbsp;</td>";
        }
        
      }
      
      ?>
      
    </tr>
  </table>
  <hr>
  <table width="870" border="1" cellpadding="0" cellspacing="0" style="font-size:11px; border-collapse:collapse">
    <tr>
      <td width="155">&nbsp;</td>
      <td colspan="3"><p style="float:right; margin:0">Grade:</p></td>
      <td colspan="3" id='4-grade'>&nbsp;</td>
      <td colspan="9">&nbsp;</td>
    </tr>
    <tr>
      <td>මුළු ගෙඩි ගණන</td>
      <?php 
     
     for($i=0;$i<13;$i++){
        print "<td align='center' width='32' id='crs-0-$i'>&nbsp;</td>";
        
     }
     ?>
     
      <td align="center" width="32" id="crs-0-13">Sum</td>
      <td align="center" width="32" id="crs-0-14">%</td>
      <td rowspan="13" width="8">&nbsp;</td>
      <td width="180">ප්‍රවාහන තත්වය</td>
      <td width="60">විස්තරය</td>
      <td width="160">අවශ්‍ය තත්වය</td>
      
    </tr>
    <tr>
      <td >කුඩා ගෙඩි ගණන</td>
       <?php 
     
     for($i=0;$i<15;$i++){
        print "<td align='center' width='32' id='crs-1-$i'>&nbsp;</td>";
        
     }
     ?>
      <td >බාර දීම</td>
      <td id="transport-delivery"></td>
      <td >සවස 3.00ට පෙර</td>
    </tr>
    <tr>
     <td >ලොකු ගෙඩි ගණන</td>
     
     <?php 
     
     for($i=0;$i<15;$i++){
     	print "<td align='center' width='32' id='crs-2-$i'>&nbsp;</td>";
     	
     }
     ?>
      
      <td rowspan="2">ලොරිය ආවරණය</td>
      <td rowspan="2" id="transport-cover"></td>
      <td  rowspan="2">හොඳින් ආවරණය කර තිබිය යුතුයි</td>
    </tr>
    <tr>
    <td >ඉල් මැසි හානි</td>
    <?php 
     
     for($i=0;$i<15;$i++){
        print "<td align='center'width='32'  id='crs-3-$i'>&nbsp;</td>";
        
     }
     ?>
      
    </tr>
    <tr>
  <td  >පොතු ගැලවුණු</td>
       <?php 
     
     for($i=0;$i<15;$i++){
        print "<td align='center' width='32' id='crs-4-$i'>&nbsp;</td>";
        
     }
     ?>
      <td  rowspan="2">ලොරිය තුළ අනවශ්‍ය දුර්ගන්ධය</td>
      <td  rowspan="2" id="transport-smell"></td>
      <td  rowspan="2">නොතිබිය යුතුයි</td>
    </tr>
    <tr>
    <td  >පණු කුහර හානි</td>
 <?php 
     
     for($i=0;$i<15;$i++){
        print "<td align='center' width='32'  id='crs-5-$i'>&nbsp;</td>";
        
     }
     ?>
     
    </tr>
    <tr>
   <td >වැලි සහිත</td>
    <?php 
     
     for($i=0;$i<15;$i++){
        print "<td align='center' width='32'  id='crs-6-$i'>&nbsp;</td>";
        
     }
     ?>
       <td rowspan="2" >ගර්කින් හැර වෙනත් ද්‍රව්‍ය </td>
      <td rowspan="2" id="transport-otherthings"></td>
      <td rowspan="2">නොතිබිය යුතුයි</td>
      
    </tr>
    <tr>
      <td >හැකිළුණු ගෙඩි</td>
   <?php 
     
     for($i=0;$i<15;$i++){
        print "<td align='center' width='32' id='crs-7-$i'>&nbsp;</td>";
        
     }
     ?>
   
    </tr>
    <tr>
   <td  >යාන්ත්‍රික හානි</td>
       <?php 
     
     for($i=0;$i<15;$i++){
        print "<td align='center' width='32' id='crs-8-$i'>&nbsp;</td>";
        
     }
     ?>
        <td  rowspan="2">ලේබල්/හඳුනාගැනීමේ වර්ණ සංකේත</td>
      <td rowspan="2" id="transport-labels"></td>
      <td  rowspan="2">තිබිය යුතුයි</td>
      
    </tr>
    <tr>
    <td >කහ පැහැති ගෙඩි</td>
    <?php 
     
     for($i=0;$i<15;$i++){
        print "<td align='center' width='32' id='crs-9-$i'>&nbsp;</td>";
        
     }
     ?>
      
     
    </tr>
    <tr>
   <td  >දුඹුරු පැල්ලම්</td>
  <?php 
     
     for($i=0;$i<15;$i++){
        print "<td align='center' width='32' id='crs-10-$i'>&nbsp;</td>";
        
     }
     ?>
       <td >තත්ව වාර්තාව</td>
      <td id="transport-qualityReport"></td>
      <td >තිබිය යුතුයි</td>
      
      
    </tr>
    <tr>
      <td >නො/පිළිගත්(AC)/(RE)</td>
     <?php 
     
     for($i=0;$i<15;$i++){
        print "<td align='center' width='32'  id='crs-11-$i'>&nbsp;</td>";
        
     }
     ?>
      <td  colspan="3" rowspan="2"></td>
    </tr>
    <tr>
     <td  >නරක් වු ගෙඩි</td>
      <?php 
     
     for($i=0;$i<15;$i++){
        print "<td align='center' width='32' id='crs-12-$i'>&nbsp;</td>";
        
     }
     ?>
    </tr>
  </table>
  <hr>
   <table width="870" border="1" cellpadding="0" cellspacing="0" style="font-size:11px; border-collapse:collapse">
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



