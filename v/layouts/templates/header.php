<?php if(Auth::getSessionUser() instanceof User) { $user = Auth::getSessionUser(); ?>
<nav class="navbar navbar-inverse  navbar-fixed-top" role="navigation">
	<div class="navbar-header">
    	<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
    	<a class="navbar-brand" href="/">Quality Analysis System</a>
  	</div>
	<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		
    	<ul class="nav navbar-nav">
			<?php if($user->isSuperAdmin() || $user->isStationUser()) { ?>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Settings<b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li><a href="/v/users">Users</a></li>
					<li><a href="">Areas and Centers</a></li>
					<li><a href="">Grades</a></li>
					<li><a href="">Season</a></li>
					<li><a href="">News</a></li>
				</ul>
			</li> 
			<li class="dropdown">
				<a href="/settings" class="dropdown-toggle" data-toggle="dropdown">Data Insertion<b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li><a href="">Data Insertion(L/M)</a></li>
					<li><a href="">Data Insertion(Small)</a></li>
					<li><a href="">Pattern Data Insertion</a></li>
					<li><a href="">View Logs</a></li>
				</ul>
			</li> 
			
			<?php } 
			if($user->isSuperAdmin() || $user->isStationUser() || $user->isSuperUser()) { ?>
			<li class="dropdown">
				<a href="/settings" class="dropdown-toggle" data-toggle="dropdown">Views<b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li><a href="../home.php?option=mod_stockViewer">View Quality Reports(L/M)</a></li>
					<li><a href="../home.php?option=mod_smallFruitStockViewer">View Quality Reports(Small)</a></li>
					<li><a href="../home.php?option=mod_supplierProfile">Supplier Profile</a></li>
					<li><a href="../home.php?option=mod_stockByDate">Stock By Date(Large)</a></li>
					<li><a href="../home.php?option=mod_stockByDateSmall">Stock By Date(Small)</a></li>
					<li><a href="../home.php?option=mod_totalQuantityProject">Total Quantity(Project)</a></li>
					<li><a href="../home.php?option=mod_crateViewer">Crates By Date</a></li>
					<li><a href="../home.php?option=mod_invoiceGenerator">Invoices</a></li>
					<li><a href="../home.php?option=mod_tmTableViewer">View TM Table</a></li>
					<li><a href="../home.php?option=mod_totalStockViewer">Total Stocks</a></li>
				</ul>
			</li> 
			<?php } ?>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">About<b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li><a href="../home.php?option=mod_contact">Contact Us</a></li>
					<li><a href="../home.php?option=mod_help&app=pdf">System Documentation</a></li>
				</ul>
			</li> 
			<li><a href="../home.php?option=mod_help">Help</a></li>
			<li><a href="../home.php?option=mod_mail">Feedback</a></li>
    	</ul>
	    <div class="nav" id="waiting-div"><img src="<?php echo APP_CDN.'/images/waiting.gif'; ?>"></div>
	     
	    <ul class="nav navbar-nav navbar-right">
	      	<li class="dropdown">
		        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
		        	<?php echo $user->getName(); ?> <b class="caret"></b></a>
		        <ul class="dropdown-menu profile-links">
			        <li>
			        	<a href="#">
			        		<div class="row">
			        			<div class="col-md-3 avatar">
				        			<img src="<?php echo $user->getAvatar(); ?>"/>
			        			</div>
			        			<div class="col-md-9">
			        				<span class="profile-name"><?php echo $user->getName(); ?></span>
			        			</div>
			        		</div>
			        	</a>
			        </li>
			        <!-- <li><a href="/account">Account Settings</a></li> -->
			        <li class="divider"></li>
			        <li><a href="/signout">Sign out</a></li>
		        </ul>
	      	</li>
	    </ul>
  </div>
</nav>
<?php } ?>
<div id="pop-message"><div class="message-content"><div class="message success">Message Displayed successfuly</div><i class="fa fa-close"></i></div></div>
<!-- <div id="flash" style=""><div class="flash success"><div class="flash-content">Message</div></div><a href="#" class="closeflash pull-right"><i class="fa fa-times"></i></a></div>-->