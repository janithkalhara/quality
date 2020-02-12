<script type="text/javascript">
var tabOpened = true;
	$(function() {
		var st_in_url = '/scheme/get_st_in_form?'
		var params = null;
		$('.date-picker').datepicker().on('changeDate', function(){
			$(this).datepicker('hide');
			setUrl();
			});
		$('.seasons-list').change(function(){
			var elem = $(this);
			setUrl();
			Helper.wait('on');
			$.get('/scheme/getprojects?id='+$(this).val(),function(d){
				Helper.wait('off');
				if(d.success) {
					elem.closest('form').find('[name="project"]').html(d.html)
				}
				else{
						Helper.msg('error',d.message);
				}
			})
		});

		$('.projects-list').change(function(){
			setUrl();
		});
		
		$(document).on('click','#handler a ',function(e){
			e.preventDefault();
			$(this).closest('.row').siblings('.form-wrapper').slideToggle();
			if(tabOpened) {
				$(this).find('i').replaceWith('<i class="fa fa-chevron-circle-right "></i>');
				tabOpened = false;
			}
			else {
				$(this).find('i').replaceWith('<i class="fa fa-chevron-circle-down "></i>');
				tabOpened = true;
			}

		});
		
		$('#generate-scheme').validate({
			rules:{
				/**season:{required:true},
				project:{required:true},
				from:{required:true},
				to:{required:true}*/
				},
			submitHandler:function(form) {
				$(form).ajaxSubmit({
					beforeSubmit:Helper.wait('on'),
					success:function(data){
						Helper.wait('off');
						if(data.success) {
							tabOpened = false;
							$(form).closest('.row').siblings('.payment-sheet-wrapper').hide().html(data.html).slideDown();
							$(form).closest('.row').slideUp();
							$('#handler').slideDown();
						}
						else{
							Helper.msg('error', data.message);
						}
					}

					}); 
			
				
			}
		});
		function setUrl(){
			var paramlist = {};
			if($('.projects-list').val() != '' && $('.seasons-list').val()!='') {
				var from_date = $('[name="from"]').val();
				var to_date = $('[name="to"]').val();
				params = $.param({season:$('.seasons-list').val(),project:$('.projects-list').val(),from:from_date,to:to_date});
				$('#st-in-form-trigger').prop('href',st_in_url+params);
			}
		}
});
	
</script>
<div class="container">
	<div class="row hide-elem" id="handler">
		<div class="handler-row">
			<a href="#" title="Expand form"><i class="fa fa-chevron-circle-right "></i></a>
		</div>
	</div>
	<div class="row form-wrapper">
		<h2>Generate the Payment Sheet</h2>
		<form role="form" id="generate-scheme" action="/scheme/generate" method="post">
			<section class="form-section">
				<div class="row">
					<div class="col-md-2">
						<select name="season" class="form-control seasons-list" >
				    		<option value="">Select the season</option>
				    		<?php foreach ($seasons as $season) { ?>
				    		<option  value="<?php echo $season->getSeasonId(); ?>"><?php echo $season->getSeasonName(); ?></option>
				    		<?php } ?>
				    	</select>
					</div>
					<div class="col-md-2">
						<select name="project" class="projects-list form-control" >
			    			<option value="">Select the project </option>
			    		</select>
					</div>
					<div class="col-md-2">
						<input name="from" type="text" class="form-control date-picker" data-date-format="yyyy-mm-dd" > 
					</div>
					<div class="col-md-2">
						<input name="to" type="text" class="form-control date-picker" data-date-format="yyyy-mm-dd">
					</div>
					<div class="col-md-2">
						<a href="/scheme/get_st_in_form" class="btn btn-primary btn-xs system-dialog" id="st-in-form-trigger"><i class="fa fa-plus-circle"></i> Add ST-in Quantity</a>
					</div>
				</div>
			</section>
			<div class="button-row">
				<label><input type="checkbox" name="draft"> Make Draft</label>
				<label><input type="checkbox" name="final-payment"> Last Payment</label>
				<input type="hidden" name="st-in-qty" id="st-in-qty">
				<button type="submit" class="btn btn-primary"><i class="fa fa-gears"></i> Generate</button>
			</div>
		</form>
	</div>
	<div class="row payment-sheet-wrapper">
	</div>
</div>
