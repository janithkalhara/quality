<h3>Center of <?php echo $project->getName(); ?></h3>
<table class="table table-strpped">
	<tr>
		<th>#</th>
		<th>Name</th>
		<th>Season</th>
		<td></td>
	</tr>
	<?php foreach ($centers as $position => $center) { ?>
	<tr>
		<td class="v-m"><?php echo ($position + 1); ?></td>
		<td class="v-m"><?php echo $center->getName(); ?></td>
		<td class="v-m"><?php echo $project->getSeason()->getSeasonName(); ?></td>
		<td>
			<a href="/v/area/edit_center?id=<?php echo $center->getId(); ?>" class="system-dialog">edit</a> &bull;
			<a class="confirm" data-func="remove_center" data-prompt="Are you sure you want to delete center <?php echo $center->getName(); ?> ? This action cannot be reversed" href="/v/area/remove_center?id=<?php echo $center->getId(); ?>">delete</a>
		</td>
	</tr>
	<?php } ?>

</table>