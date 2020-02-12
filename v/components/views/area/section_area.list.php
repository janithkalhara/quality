<h3>Season <?php echo $season->getSeasonName(); ?></h3>
<table class="table table-strpped">
	<tr>
		<th>#</th>
		<th>Name</th>
		<th>Season</th>
		<th>Grade Category</th>
		<th>Type</th>
		<th>Incharge Person</th>
		<td></td>
	</tr>
	<?php foreach ($projects as $position => $area) { ?>
	<tr>
		<td class="v-m"><?php echo ($position + 1); ?></td>
		<td class="v-m"><?php echo $area->getName(); ?></td>
		<td class="v-m"><?php echo $area->getSeason()->getSeasonName(); ?></td>
		<td class="v-m"><?php echo $area->getGradeCategory()->getName(); ?></td>
		<td class="v-m"><?php echo $area->getAreaType(); ?></td>
		<td class="v-m">
			<img alt="" src="<?php echo $area->getIncharge()->getAvatar(); ?>" class="avatar">
			<span><?php echo $area->getIncharge()->getName(); ?></span>
		</td>
		<td>
			<a href="/v/area/edit_area?id=<?php echo $area->getId(); ?>" class="system-dialog">edit</a> &bull;
			<a class="confirm" data-func="remove_area" data-prompt="Are you sure you want to delete project <?php echo $area->getName(); ?> ? This action cannot be reversed" href="/v/area/remove?id=<?php echo $area->getId(); ?>">delete</a> &bull;
			<a href="/v/area?view=centers&area=<?php echo $area->getId(); ?>"> centers</a>
		</td>
	</tr>
	<?php } ?>

</table>