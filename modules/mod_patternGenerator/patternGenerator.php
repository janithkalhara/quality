<?php 
defined("HEXEC") or die("Restrited Access.");
?>
<?php 
global $import;
$import->importCSS('patternGenerator','patternGenerator');

?>

<script type="text/javascript">
$(document).ready(function(){
	var $tabs=$('#tabs').tabs();
});

</script>

<div id="tabs" style="font-size:12px">
        <ul>
            <li><a href="#tabs-1">Enter Plan Data</a>
            </li>
            <li><a href="#tabs-2">Enter Revision Data</a>
            </li>
            <li><a href="#tabs-3">Enter Rates Data</a>
            </li>
            <li><a href="#tabs-4">Enter Week Rates Data</a>
            </li>
        </ul>
        <div id="tabs-1" style="background:#fff;color:#000;min-height:350px">
        <?php 
            include 'modules/mod_patternGenerator/includes/planDataForm.php';
        ?>
        </div>
        <div id="tabs-2" style="background:#fff;color:#000;min-height:350px">
       <?php include 'modules/mod_patternGenerator/includes/revisionDataForm.php';?>
        </div>
        <div id="tabs-3" style="background:#fff;color:#000;min-height:350px">
         <?php 
            include 'modules/mod_patternGenerator/includes/ratesDataForm.php';
        ?>
        </div>
        <div id="tabs-4" style="background:#fff;color:#000;min-height:350px">
         <?php 
            include 'modules/mod_patternGenerator/includes/weekCropDataForm.php';
        ?>
        </div>
        
    </div>

    


