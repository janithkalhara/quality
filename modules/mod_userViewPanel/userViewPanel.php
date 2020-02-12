<link rel="stylesheet" href="modules/mod_userViewPanel/css/userViewPanel.css" type="text/css" />

<script type="text/javascript">
	$('document').ready(function(){
		$("#a-seeall").click(function(){
			if($(this).attr('name')=='seeall'){
			var count=$('#profile-div').children().length;
			var height=10;
			var mult;
			if(count%2!=1){
				mult=parseInt(count/2);
				
				}else{
				mult=parseInt((count/2)+2);
					}
			h=mult*90;
						
			$('#userViewArea').animate({
			    height: h+'px'
			  }, 5000);
			$("#a-seeall").text("collapse");
			$("#a-seeall").attr("name","collapse");
			}else{
				$('#userViewArea').animate({
				    height: '400px'
				  }, 3000);
				$("#a-seeall").text("See all");
				$("#a-seeall").attr("name","seeall");
				  
				}
			});
		
	});

</script>



<div id= "userViewArea">
<?php
	$conn = new HDatabase();
	$conn->connect();
	$conn->select('qa_user','*');
	$result = $conn->getResult();
	
	print "<h3 class='ribbon-text' align='center'><strong>Existing Users</strong></h3>";
	$content="<ul id='profile-div' >";
	foreach ($result as $r){
		if($r['userId'] != "kasun"){
		$content.='<li class="liFormat" ><div class="profilePic">
		<img src="files/users/avatars/'.$r['avatar'].'" height="75px" width="77px" /></div><hr/>
		<div class="details" ><p class="user-name">'.$r['fname']." ".$r['lname'].'</p><p style="font-size: 13px;color:#FF7D19"><strong>'.$r['position'].'</strong></p><p style="font-size: 13px;">'.$r['areaId'].
		'</p></div> </li>'; 
	
		}			
	}
	
	
	$content.= '<li class="liFormat" ><div class="profilePic">
		<img src="files/users/avatars/'.$result[0]['avatar'].'" height="75px" width="77px" /></div><hr/>
		<div class="details" ><p class="user-name">'.$result[0]['fname']." ".$result[0]['lname'].'</p><p style="font-size: 13px;color:#FF7D19"><strong>'.$result[0]['position'].'</strong></p><p style="font-size: 13px;">'.$result[0]['areaId'].
		'</p></div> </li>';
	$content.="</ul>";
	echo $content;


?>
	
</div>
<a class="seeall" id="a-seeall" name="seeall">See all >></a>
