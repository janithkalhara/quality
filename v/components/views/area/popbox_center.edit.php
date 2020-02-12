<script type="text/javascript">
	$(function(){
		$('#center-save-form').validate({
			rules:{
				name:{required:true},
			},
			submitHandler:function(form){
				$(form).ajaxSubmit({
					beforeSubmit:Helper.wait('on'),
					success:function(data){
						Helper.wait('off');
						Helper.closeModal();
						if(data.success) {
							Helper.msg('success',data.message);
							$('#centers-list').html(data.html);
							}
						else {
							Helper.msg('error',data.message);
						}
		
					}
					});
				}

			});
	});
</script>

<div class="modal-dialog ">
	<div class="modal-content">
    	<form action="/v/area/update_center" method="post" id="center-edit-form">
	    	<div class="modal-header">
	        	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        	<h4 class="modal-title" >Edit Center - <?php echo $center->getName(); ?></h4>
	      	</div>
	      	<div class="modal-body">
				<div class="row">
					<div class="col-md-6 form-group">
						<label>Area : </label>
						<span><?php echo $project->getName(); ?></span>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 form-group">
						<label>Center Name</label>
						<input name="name" class="form-control" value="<?php echo $center->getName(); ?>">
					</div>
				</div>
	      	</div>
	      	<div class="modal-footer">
	      		<input type="hidden" value="<?php echo $project->getId(); ?>" name="project">
	        	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        	<input type="submit" class="btn btn-primary" value="Save">
	      	</div>
		</form>
    </div>
</div>
