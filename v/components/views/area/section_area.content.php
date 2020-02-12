<script type="text/javascript">
$(function(){
	$('#season-trigger').change(function(){
		Helper.wait('on');
		$.get('/v/area/get_areas?season='+$(this).val(),function(data){
			Helper.wait('off');
			if(data.success) {
				$('#area-list').slideUp();
				$('#area-list').html(data.html).slideDown();
				}
			else{
				Helper.msg('error',data.message);
				}
			});
		});
	
});
function remove_area(data,element) {
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
			<a href="/v/area/add" class="system-dialog btn btn-primary pull-right">Add Area</a>		
			Areas and Centers
		</h2>
		<div class="row">
			<div class="col-md-2 pull-right">
				<select class="form-control col-md-2" id="season-trigger">
					<?php foreach ($seasons as $season) { ?>
					<option value="<?php echo $season->getSeasonId(); ?>"><?php echo $season->getSeasonName(); ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		
		<div id="area-list">
			<?php echo $this->getPrjectListTable(); ?>
		</div>
	</div>
</div>