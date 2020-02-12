<?php
?><script type="text/javascript" src="modules/mod_insertionData/js/browserplus-min.js"></script>
<script type="text/javascript" src="modules/mod_insertionData/js/plupload.full.js"></script>
<script type="text/javascript" src="http://bp.yahooapis.com/2.4.21/browserplus-min.js"></script>
<script type="text/javascript" src="modules/mod_insertionData/js/plupload.full.js"></script>
<script type="text/javascript" src="modules/mod_insertionData/js/uploader.js" >

</script>
<table width="210" border="1" class="datatable-side" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" height="24">&nbsp;</td>
  </tr>
  <tr>
  <td colspan="2" height="24" >Center No.</td>
  </tr>
  <tr>
    <td colspan="2" style="height: 22px" >Fruit Count</td>
  </tr>
  <tr>
    <td width="45" rowspan="2" ><p class="rowspanned">Defect Grade</p></td>
    <td width="165" style="height: 31px">Small Fruit</td>
  </tr>
  <tr>
    <td style="height: 22px; ">Large Fruit</td>
  </tr>
  <tr>
    <td rowspan="5" ><p class="rowspanned">Major Defects</p></td>
    <td style="height: 22px; ">Melon Fly Attacked</td>
  </tr>
  <tr>
    <td style="height: 22px;">Peeled Off</td>
  </tr>
  <tr>
    <td style="height: 22px;">Bore Attacked</td>
  </tr>
  <tr>
    <td style="height: 22px; ">Sand Embedded</td>
  </tr>
  <tr>
    <td style="height: 22px;">Shrivelled</td>
  </tr>
  <tr>
    <td rowspan="6"><p class="rowspanned">Minor Defects</p></td>
    <td style="height: 22px;">Deformed</td>
  </tr>
  
  <tr>
    <td style="height: 22px; ">Virus Attacked</td>
  </tr>
  <tr>
    <td style="height: 22px">Mechanical Damaged</td>
  </tr>
  <tr>
    <td style="height: 22px; ">Yellowish</td>
  </tr>
  <tr>
    <td style="height: 22px; ">Rust Patches</td>
  </tr>
  <tr>
    <td style="height: 22px; ">&gt;&nbsp;45mm Fruits</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td style="height: 22px">Accepted/Rejected</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td style="height: 22px">Spoiled/Rotten</td>
  </tr>
</table>
 <script type="text/javascript">

 $(document).ready(function(){
     
     $('#transportCondition-link').click(function(){

         $('#transportCondition').toggle("blind",{},500);
         if($(document).find('#imageUploaderDiv').css('display')=='none'){

         }
     else{
          $(document).find('#imageUploaderDiv').hide("blind",{},500);
          }
     
         
         });

     $('#close-link').click(function(){

         $("#transportCondition").hide("blind",{},500);
        
         });
    $('#imageuploader-link,#keep-away').click(function(){
       $('#imageUploaderDiv').toggle("blind",{},500);

         if($(this).prev('div').css('display')=='none'){

             }
         else{
              $(this).prev('div').hide("blind",{},500);
              }
         
        });

     
 });
</script>

 
<p id="transportCondition-link" >View Transport Condition table</p>

<div id="transportCondition" style="display:none">

<table cellpadding="0" cellspacing="0">
  <tr>
    <th>Transportation Condition</th>
    <th>Status</th>
    <th>Required Status</th>
  </tr>
  <tr>
    <td>Delivery</td>
    <td><input type="radio" name="delivery" value="1" checked="checked">Yes <input type="radio" name="delivery" value="0">No</td>
    <td>Before 3.00 pm</td>
  </tr>
   <tr>
    <td>Lorry cover</td>
    <td><input type="radio" name="cover" value="1" checked="checked" >Yes <input type="radio" name="cover" value="0">No</td>
    <td>Should be covered properly</td>
  </tr>
   <tr>
    <td>Unusual odour inside the truck</td>
    <td><input type="radio" name="smell" value="1" >Yes <input type="radio" name="smell" value="0" checked="checked">No</td>
    <td>Should not present</td>
  </tr>
   <tr>
    <td>Things ather than gherkin</td>
    <td><input type="radio" name="otherThings" value="1">Yes <input type="radio" name="otherThings" value="0" checked="checked">No</td>
    <td>Should not present </td>
  </tr>
   <tr>
    <td>Labels/Color codes</td>
    <td><input type="radio" value="1" name="colorcode" checked="checked">Yes <input type="radio"   name="colorcode" value="0">No</td>
    <td>Should present</td>
  </tr>
   <tr>
    <td>Quality report</td>
    <td><input type="radio" name="qualityReport" value="1" checked="checked" >Yes <input type="radio" name="qualityReport" value="0">No</td>
    <td>Should present</td>
  </tr>
</table>
<a  id="close-link"></a>
</div>
<p id="imageuploader-link" align="center"  > Attach Photos <p>
<div id="imageUploaderDiv" style="display:none">
<form enctype="multipart/form-data" action="upload.php" method="POST">
 Please choose a file:
  <div id="container-uploader">
    <div id="filelist">No runtime found.</div>
    <br />
    <input type="button" id="pickfiles" href="javascript:;" class='buttons-' value="Select files">
    <a id="keep-away" href="javascript:;" class='buttons-'>Keep to Upload</a> 
    <input type="button" id="reset-button" href="javascript:;" class='buttons-' value="Reset">
</div>
 
 </form> 

&nbsp;
</div>

