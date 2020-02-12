<div class="container">
	<h2>Users</h2>
	<ul class="user-list">
		<?php foreach ($users as $user) { ?>
		<li class="col-md-4">
			<div class="media">
      			<a class="pull-left" href="#">
	        		<img class="media-object" data-src="holder.js/64x64" alt="64x64" src="<?php echo $user->getAvatar(); ?>" style="width: 64px; height: 64px;">
	     		</a>
	      		<div class="media-body">
	        		<h4 class="media-heading"><?php echo $user->getName(); ?></h4>
	        		<span><small><?php echo $user->getPosition(); ?></small></span>
	        		<p><?php echo $user->getArea(); ?></p>
	      		</div>
	    </div>
		</li>
		<?php } ?>
	</ul>
</div>