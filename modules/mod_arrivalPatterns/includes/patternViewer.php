<?php 
global $import;
$import->importLib("project");
$import->importLib("season");
$import->importJS("arrivalPatterns", 'patternViewer');
?>
<script type="text/javascript" src="libraries/highcharts/js/highcharts.js"></script>
<div id="pattern-viewer-container">
<h4>View Arrival Patterns</h4>
	<form action="">
	   <table id="table1">
	       <tr>
	           <td>Select Season:</td>
	           <td>
		           <select name="season-pattern-viewer" id="season-pattern-viewer" onchange="loadProjectsForpPV(this.value)">
			           <option value="-1">Select a Season</option>
	        		   <?php 
			              	$season=new Season();
			            	$seasons=$season->getSeasons();
		               		foreach ($seasons as $temp){
		                   		print "<option value=".$temp['seasonId'].">";
		                  		print $temp['seasonName'];
		                  		print "</option>";
		               		}
	           			?>
	           		</select>
	           </td>
	           <td>Project:</td>
	           <td>
		           <select name="project-pattern-viewer" id="project-pattern-viewer">
		               <option value="-1">Select a Project</option>
		           </select>
	           </td>
	           <td>
		           <input type="button" value="Generate" onclick="generateAll()" class="button"/>
	           </td>
	       </tr>
	   </table>
	</form>
	<h4>Project Plan:</h4>
	<div id="plan-pattern-viewer">
	</div>
	<h4>Project Revisions:</h4>
	<div id="revision-pattern-viewer"></div>
    <h4>Arrival Pattern : </h4>
    <div id="print-toobar" style="display:none" onclick="printTheReport()">
	<p> Print the Report</p>
	</div>
    <div id="graph-pattern-viewer-wrapper">
      <table border="1" style="display:none;width:80%" cellpadding="5" cellspacing="0" id="header-data">
    <tr>
    <td style="background:#ccc"><b>Project :</b> </td><td id="print-project"></td>
    <td style="background:#ccc"><b>Season : </b></td><td id="print-season"></td>
    <td style="background:#ccc"><b>Generated Date : </b></td><td id="print-date"></td>
    </tr>
    </table>
     <table border="0" style="width:100%" cellpadding="5" cellspacing="0">
    <tr height="15">
    </tr>
    </table>
    <div id="graph-pattern-viewer">
    </div>
    <div id="data-table-graph-pattern-viewer"></div>
</div>	
</div>