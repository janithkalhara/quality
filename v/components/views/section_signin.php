<script>
$(function() {

$('#signin-form').validate({
	rules:{
		username:{required:true},
		password:{required:true},
		},
	submitHandler:function(form) {
		$(form).ajaxSubmit({
			beforeSubmit:function (arr,form){
				$(form).find(':submit').button('loading');
				},
			success:function(data) {
				$(form).find(':submit').button('reset');
				if(data.success) {
					window.location = data.path ? data.path : '/';
				}else{
					$('#error-msg').html(data.message).slideDown();
					}
				}
			});
		}
});
});

</script>
<div class="container">
      <form class="form-signin" role="form" id="signin-form" action="/signin/auth<?php echo !is_null($backlink) ? '?__backto='.urlencode($backlink) : ''; ?>" method="post">
        <h3 class="form-signin-heading text-center" >Scheme Payment System</h3>
        <div class="form-group">
        	<div class="validate-w form-group">
		        <input type="text" class="form-control" placeholder="Username" required="" autofocus="" name="username">
	        	<div class="error-w"></div>
        	</div>
        </div>
        <div class="form-group">
	        <div class="validate-w ">
	      		<input type="password" class="form-control" placeholder="Password" required="" name="password">
	        <div class="error-w"></div>
	        </div>
        </div>
        <label class="checkbox">
          <input type="checkbox" value="remember-me"> Remember me
        </label>
        <p id="error-msg" class="alert alert-danger hide-elem text-center"></p>
        <button class="btn btn-lg btn-primary btn-block" type="submit" data-loading-text="Signing in..">Sign in</button>
      </form>
	</div>