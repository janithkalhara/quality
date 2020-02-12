<script type="text/javascript">
function remove_center(data,element) {
	if(data.success) {
		element.closest('tr').remove();
		Helper.msg('success', data.message);
	}
	else {
		Helper.msg('error', data.message);
	}
	
}
</script>

<div class="content">
	<div class="container">
		<h2>
			<a href="/v/area/add_center?id=<?php echo $project->getId(); ?>" class="system-dialog btn btn-primary pull-right">Add Center</a>		
			Areas and Centers
		</h2>
		<div id="centers-list">
			<?php include_once __DIR__.'/section_centers.list.php';?>
		</div>
	</div>
</div>