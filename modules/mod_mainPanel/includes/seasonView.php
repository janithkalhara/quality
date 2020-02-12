<fieldset>
<legend><b>On Going Season</b></legend>
<table width="580" border="" id="table-season-view" cellspacing="0" cellpadding="0">
<tr><th><b>Name:</b></th><th><b>Start Date:</b></th><th><b>End Date:</b></th></tr>
<tr>
<td><?php print($ongoingSeason['seasonName']);?></td>
<td><?php print($ongoingSeason['startDate']);?></td>
<td><?php print($ongoingSeason['endDate']);?></td>
</tr>

</table>
</fieldset><fieldset>
<legend>Seasons</legend>
<table  width="580" cellspacing="0" cellpadding="0" border="1" id="table-season-exist">
<tr><th>Season Name</th><th>Start Date</th><th>End Date</th><th>Actions</th>
</tr>
<?php 
$seasons=$season->getSeasons();
for($i=0;$i<count($seasons);$i++){
    print "<tr id='season-tr-".$seasons[$i]['seasonId']."'>";
    print "<td>".$seasons[$i]['seasonName']."</td>";
    print "<td>".$seasons[$i]['startDate']."</td>";
    print "<td>".$seasons[$i]['endDate']."</td>";
    print "<td><input type='button' value='edit' onclick='editSeason(\"".$seasons[$i]['seasonId']."\")'>";
    print "<input type='button' value='remove' onclick='removeSeason(\"".$seasons[$i]['seasonId']."\")'></td>";
    print "<tr>";
}




?>
</table>
</fieldset>