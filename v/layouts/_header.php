<?php 
Html::importCss("navbar");
Html::importJs("navbar");

?>
<script type="text/javascript">
$(document).ready(function(){
	$("ul#navigator li").hover(function(){
		//mouse on
			$(this).stop().animate({"background-color":"#900"},300);
		},
		function(){
		//mouse out
			$(this).stop().animate({"background-color":"#600"},300);
			});
	
});
</script>
		
<div id="header" >
  <div class="navbar-inner">
   <ul id="navigator">
   	   <li align="center"><a href="?">Home</a></li>
   	   <li align="center"><a href="?url=insert/view/view">Explore</a></li>
	   <li align="center"><a href="?url=insert/insert/selectProduct">Insert</a></li>
	   <li align="center"><a href="?url=graph/graph">Graphs</a></li>
	   <li align="center"><a href="?url=notif/notif/">Notifications</a></li>
	   <li align="center"><a href="">Worksheets</a></li>
	   <li align="center"><a href="">Events</a></li>
   </ul>
    </div>
  <div id="default-header-profile">
<?php 
$user=new User($_SESSION['MEMBER_ID']);

?>
<img src="public/images/avatars/<?php print $user->getAvatar()?>" id="">
<p class="name"><?php print $user->getFname()." ".$user->getLname()?>	</p><br>
<p class="type"><?php print $user->getType()?></p>

<div id="default-header-profile-more" style="display: none; ">

<img src="public/images/avatars/<?php print $user->getAvatar()?>" id="">
<p id="changeBg">Change Background</p>
<a href="?url=user/profile/edit">Edit profile</a>
<a class="signout" href="?url=sign/sign/out">Sign Out</a>
</div>
</div>
</div>
 

