<?php 
global $import,$mainframe;
$import->importLib('project');
$import->importLib('season');
$import->importClass("patternGenerator", "handler.revisiondata");
$import->importClass("patternGenerator", "OptionalArrivalPatternMaker");
$import->importJS("patternGenerator", "revisionDataForm");
$mainframe->setTitle("Pattern Generator");

?>


<div id="revision-data-cantainer">
<fieldset>
<legend class="legend">View Revision Data</legend>
<form action="home.php?option=mod_patternGenerator" method="post" onsubmit="return submitForm()">
    <table class="selector">
        <tr>
        <td>
		      Season : 
		    </td>
        <td>
			    <select  name="season-revisiondata" id="season-revisiondata" onchange="loadProjects(this.value)">
			    <option value="-1" >Select Season</option>
	                     <?php 
	                    foreach ($seasons as $temp){
	                        
	                        print "<option value='".$temp['seasonId']."'>";
	                        print $temp['seasonName'];
	                        print "</option>";
	                        
	                    }
	                                     
	                    ?>
	            </select>
            </td>
            <td>
                Project : 
            </td>
	        <td>
			    <select name="project-revisiondata" id="project-revisiondata" onchange="displayRevisionDataTable();">
			        <option value="-1">Select the project</option>
			        <?php 
			        $project=new Project();
			        $projects=$project->getProjects();
			        
			      
			        
			        ?>
			    </select>
		    </td>
		    
		    
	    </tr>
    </table>
    <div id="view-plan-data">
    </div>
    <table>
        <tr>
            <td>Revision :</td>
            <td>
	            <select name="revision-selector" id="revision-selector" onchange="manageInputs(this.value)">
			    <option>Select missed revision</option>
			    </select>
			    
		    </td>
		    <td>Or Enter Revision Number : </td>
		    <td><input type="text" name="revision-number-selector" id="revision-number-selector" />
		    <input type="hidden" id="numOfweeks-hidden" name="numOfweeks-hidden" value=""/>
		    </td>
		    <td><input type="button" value="Set Revision Table" class='buttons' onclick="setRevisionDataEditTable();"/></td>
		    <td><input type="text" name="add-number-selector" id="add-number-selector" style="display:none"/></td>
		    <td><input type="button" value="Add week" id="click-number-selector" class='buttons' onclick="addWeekToDataEditTable();" style="display:none"/></td>
        </tr>
    </table>
    <div id="edit-revision-data">
    
    </div>

<div id="controllers-revision-data">
    
    </div>

</form>
</fieldset>

</div>
<?php 
//tracking and saving data
try {
	
	if(isset($_POST['task'])){
		$task=$_POST['task'];
	   if($task=="enter-revision-data"){
	   	   revisionDataHandler::saveRevisionData($_POST);
	   	   OptionalArrivalPatternMaker::manager($_POST);
	   }
	}
	   
	
	
	
} catch (Exception $e) {
	$e->getMessage();
}





?>



