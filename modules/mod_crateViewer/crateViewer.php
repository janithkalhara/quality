<?php defined("HEXEC") or die("Restrited Access."); ?>
<link rel="stylesheet" href="modules/mod_crateViewer/css/crateViewer.css" type="text/css" />
<script type="text/javascript" src="modules/mod_crateViewer/js/crateViewer.js" ></script>
<?php  $date=date("Y-m-d");
global $import;
$import->importLib('project');
$project = new Project();
$projects = $project->getProjects();
$import->importLib('season');
$season = new Season();
$seasons = $season->getSeasons();
?>
<div id="outerDiv">
<table cellpadding="0" cellspacing="0" id="selectDiv">
	<tr>
		<td>Season : <select id="season">
		<option value="Total">Select Season</option>
		<?php 
			foreach ($seasons as $s){
				print "<option value='".$s['seasonId']."'>".$s['seasonName']."</option>";	
			}	
		?>
		</select>
 </td>
<td>
Project : <select id="project">
<option value="Total">Select Project</option>

</select>
</td>
<td>
Start Date : <input type="text" name="startDate" id="startDate" value="<?php echo $date;?>" />
</td>
<td>
End Date : <input type="text" name="endDate" id="endDate" value="<?php echo $date; ?>" />
</td>
</tr>
</table>
<div id="tableDiv">

</div>
<div id="submitmsg" class="ui-state-highlight ui-corner-all" style="margin-top: 10px;margin-bottom:5px; padding:5px;display: none;position: relative;">
		<span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;margin-top:1px"></span>
		No Stocks</div>
</div>