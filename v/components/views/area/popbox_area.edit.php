<script type="text/javascript">
	$(function(){
		$('[name="supplier"]').select2('data',{id:'<?php echo $project->getIncharge()->getUserName(); ?>',text:'<?php echo $project->getIncharge()->getName(); ?>'});
		$('[name="supplier"]').select2({
			width:'300px',
			formatResult: format,
		    formatSelection: format,
		    escapeMarkup: function(m) { return m; }
		});

		function format(state) {
		    var elem = state.element;
		 	if($(elem).data('avatar')) {
			    return "<div class='row'><div class='col-md-2'><img class='flag' src='"+$(elem).data('avatar')+"' alt='" + state.text+ "' /></div><div class='col-md-10'>" + state.text+"</div></div>";
		 	}
		 	else {
				return state.text;
			}
		}
		$('#area-update-form').validate({
			rules:{
				season:{required:true},
				name:{required:true},
				category:{required:true},
				type:{required:true},
				supplier:{required:true}
			},
			submitHandler:function(form){
				$(form).ajaxSubmit({
					beforeSubmit:Helper.wait('on'),
					success:function(data){
						Helper.wait('off');
						Helper.closeModal();
						if(data.success) {
							Helper.msg('success',data.message);
							$('#area-list').html(data.html);
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
    	<form action="/v/area/update_center" method="post" id="area-update-form">
	    	<div class="modal-header">
	        	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        	<h4 class="modal-title" >Edit Project - <?php echo $project->getName(); ?></h4>
	      	</div>
	      	<div class="modal-body">
      			<div class="row">
					<div class="col-md-6 form-group">
						<label>Season</label>
						<select class="form-control" name="season">
		      					<option value="">Select a season</option>
		      					<?php foreach ($seasons as $season) { ?>
		      					<option value="<?php echo $season->getSeasonId(); ?>" <?php echo $season->getSeasonId() == $project->getSeason()->getSeasonId() ? 'selected' : ''; ?>><?php echo $season->getSeasonName(); ?></option>
		      					<?php } ?>
		      			</select>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 form-group">
						<label>Project Name</label>
						<input type="text" name="name" class="form-control" value="<?php echo $project->getName(); ?>">
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 form-group">
						<label>Grade Category</label>
						<select class="form-control" name="category">
		      					<option value="">Select a Grade Category</option>
		      					<?php foreach ($gradeCategories as $category) { ?>
		      					<option <?php echo $category->getId() == $project->getGradeCategory()->getId() ? 'selected' : ''; ?> value="<?php echo $category->getId(); ?>"><?php echo $category->getName(); ?></option>
		      					<?php } ?>
		      			</select>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 form-group">
						<label>Project Type <small> (internal/external)</small></label>
						<select class="form-control" name="type">
		      					<option value="">Select project type</option>
		      					<?php foreach (Project::$types as $position => $type) { ?>
		      					<option <?php echo $project->getAreaType() == $type ? 'selected' : ''; ?> value="<?php echo $position; ?>"><?php echo $type; ?></option>
		      					<?php } ?>
		      			</select>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 form-group">
						<label>Incahrge Person</label>
						<select class="select" name="supplier">
		      					<option value="">Select Incharge Person</option>
		      					<?php foreach (User::getSuppliers() as $user) { ?>
		      					<option <?php echo $user->getUserName() == $project->getIncharge()->getUserName() ? 'selected' : ''; ?> value="<?php echo $user->getUserName(); ?>" data-avatar="<?php echo $user->getAvatar(); ?>"><?php echo $user->getName(); ?></option>
		      					<?php } ?>
		      			</select>
					</div>
				</div>
	      	</div>
	      	<div class="modal-footer">
	      		<input type="hidden" name="id" value="<?php echo $project->getId(); ?>">
	        	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        	<input type="submit" class="btn btn-primary" value="Save">
	      	</div>
		</form>
    </div>
</div>
