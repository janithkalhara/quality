<?php defined('HEXEC') or die('Restricted Access'); ?>
<?php 
require_once 'modules/mod_mainPanel/classes/season.php';
global $import;
$import->importLib('user');
$user = Huser::get($_SESSION['SESS_MEMBER_ID']);
?>
<link rel="stylesheet" href="modules/mod_userPanel/css/userPanel.css" type="text/css" />
<script type="text/javascript">
$('document').ready(function(){
    $('#profView').click(function(){
		var userId = "<?php echo $user->getId(); ?>";
		$.post("modules/mod_userPanel/EditProfile.php",{flag:'useredit',userId : userId},function(data){
				$('#fNameEdit').val(data[0]);
				$('#lNameEdit').val(data[1]);
				$('#emailEdit').val(data[2]);
				$('#userTypeEdit').val(data[4]);
				$('#areaEdit').val(data[5]);
				$('#positionEdit').val(data[6]);
				$('#mobileEdit').val(data[7]);
				$('#imgArea').html("<img src='files/users/avatars/"+data[8]+ "' width='76px' height='77px' />");
			});				
        $('#editFormDiv').fadeIn('slow');
    });
    $('#closeBut').click(function(){
        $('#editFormDiv').fadeOut('slow');
        $('#editform')[0].reset();  

        });
            
    $('#submitButEdit').click(function(){
        var editDetails = new Array();
        editDetails[0] = $('#emailEdit').val();
        editDetails[1] = $('#userTypeEdit').val();  
        editDetails[2] = $('#pwordEdit').val();
        editDetails[3] = $('#fNameEdit').val();
        editDetails[4] = $('#lNameEdit').val();
        editDetails[5] = $('#areaEdit').val();
        editDetails[6] = $('#positionEdit').val();
        editDetails[7] = $('#mobileEdit').val();
        editDetails[8] = 'avatar4.png';
		editDetails[9] = $('#oldUserId').val();
        if(editDetails[2] != $('#rePwordEdit').val()){
            $('#validPassEdit').html("* Password mismatched");  
        }
        if(editDetails[2] == "" && $('#rePwordEdit').val()== ""){
            $('#validPassEdit').html("");
        }
        if(editDetails[2] == ""){
                $('#validPassEdit').html("* Required");
                $('#pwordEdit').focus();
        }
            
        if(editDetails[0] == ""){
                $('#validEmailEdit').html("* Required");
                $('#emailEdit').focus();
            }
        if(editDetails[4] == ""){
                $('#validlNameEdit').html("* Required");
                $('#lNameEdit').focus();
        }
        if(editDetails[3] == ""){
                $('#validNameEdit').html("* Required");
                $('#fNameEdit').focus();
        }       
        
        if(editDetails[0] != "" && editDetails[3] != "" && editDetails[2] != "" && editDetails[4] != "" && editDetails[2] == $('#rePwordEdit').val()){  
            $("#editform").submit();
            $('#submitmsg').fadeIn('slow');
            setTimeout("$('#submitmsg').fadeOut('slow');", 4000);
            $('#validEmailEdit').html("");
            $('#validNameEdit').html("");
            $('#validPassEdit').html("");
            $('#validlNameEdit').html("");
            $('#editform')[0].reset();
            $('#userView').fadeOut('medium').load('modules/mod_mainPanel/mainPanel.php').fadeIn("slow");
        }
        });
    $('#fNameEdit').keydown(function(){
        $('#validNameEdit').html("");
        });
    $('#emailEdit').keydown(function(){
        $('#validEmailEdit').html("");
        });
    $('#pwordEdit').keydown(function(){
        $('#validPassEdit').html("");
        }); 
    $('#lNameEdit').keydown(function(){
        $('#validlNameEdit').html("");
        });

    $('#resetButEdit').click(function(){
        $('#validEmailEdit').html("");
        $('#validNameEdit').html("");
        $('#validPassEdit').html("");
        $('#validlNameEdit').html("");
    });
    $('#rePwordEdit').keyup(function(){
        if($('#pwordEdit').val() != ""){
            if($('#rePwordEdit').val() == $('#pwordEdit').val()){
                $('#validPassEdit').html("<span style='color:#009900'> Password matched</span>");
            }else{
                $('#validPassEdit').html("* Password mismatched");
            }       
        }       
    });
	$('#logged-details').click(function(){
		$('#online-users').toggle('blind',{},500);
     });
    $('#closebutton').click(function(){
		$('#online-users').hide('blind',{},500);
    });
});
</script>   	
<div id="innerPanel">
<?php $season = Seasonv2::getOngoingSeason();?>
	<div id="avatar" style="width: 75px; height: 80px; background-color: #fff;position: relative;">
		<img id="avatar-image" src="files/users/avatars/<?php echo $user->getAvatar(); ?>" height='80' width='74'/>
	</div>
	<div class="info">
		<p>
			<span class="username">
				<a href='#'><?php echo $user->getName(); ?></a>
			</span><br>logged as : <?php echo $user->getType(); ?></p>
		<p>
			<span id="profView" class="">Profile</span> | <a href="login/logout.php">SignOut</a><br>
			<span><b>On Going Season : </b><?php echo $season->getName(); ?></span>
		</p>
		<?php 
		$users_count = getOnlineUsers();
		if($users_count){
			$num = count($users_count);
		}else{
			$num = 0;
		}
		if($num>0){?>
			<p id='logged-details'><i class="icon icon-user"></i> There are <b><?php echo $num; ?></b> logged-in user(s) </p>
		<?php }else { ?>
			<p id='logged-details'> No users online. </p>
		<?php } ?>
	</div>
</div>

<div id="editFormDiv">
<div id="closeBut" > 
<span class="ui-icon ui-icon-closethick"></span></div>
<h3 style="width: 500px">Edit Profile</h3>
<form method="post" action="modules/mod_userPanel/EditProfile.php" enctype="multipart/form-data" id="editform" >
        <table width="550">
            <tr height="40px">
                <td width="140px" >First Name</td>
                <td width="220px">: <input type="text" id="fNameEdit" name="fNameEdit" style="width: 185px"/></td>
                <td><div id="validNameEdit" style="color:red; "></div></td>
            </tr>
            <tr height="40px">
                <td>Last Name</td>
                <td>: <input type="text" id="lNameEdit" name="lNameEdit" style="width: 185px" /></td>
                <td><div id="validlNameEdit" style="color:red; "></div></td>
            </tr>
            <tr height="40px">
                <td>Username</td>
                <td>: <input type="text" id="emailEdit" name="emailEdit" style="width: 185px" readonly="readonly" />
                </td>
                <td><div id="validEmailEdit" style="color:red; "></div></td>
            </tr>
            <tr height="40px">
                <td>Password</td>
                <td>: <input type="password" id="pwordEdit" name="pwordEdit" style="width: 185px" />
                </td>
                <td><div id="validPassEdit" style="color:red; "></div></td>
            </tr>
            <tr height="40px">
                <td >Confirm Password</td>
                <td>: <input type="password" id="rePwordEdit" name="rePwordEdit" style="width: 185px" />
                </td>
                
            </tr>           
            <tr height="40px">
                <td>Usertype</td>
                <td>: <input type="text" id="userTypeEdit" name="userTypeEdit" style="width: 185px" readonly = "readonly" />
                        
                </td>
            </tr>
            <tr height="40px">
                <td>Station / Area</td>
                <td>: <input type="text" id="areaEdit" name="areaEdit" style="width: 185px" readonly = "readonly" />
                </td>
            </tr>
            <tr height="40px">
                <td>Position</td>
                <td>: <input type="text" id="positionEdit" name="positionEdit" style="width: 185px" >
                </td>
            </tr>
            <tr height="40px">
                <td>Mobile</td>
                <td>: <input type="text" id="mobileEdit" name="mobileEdit" style="width: 185px" />
                </td>
            </tr>
            <tr>
                <td>Profile Picture</td>
                <td>: <input type="file" name="file" id="file" style="width: 187px" /></td>
                <td><div id="imgArea"> </div></td>
            </tr>
            
        </table>
		<input type="hidden" id="oldUserId" name="oldUserId" value=<?php $user = new user();
						echo $user->getUserID();		
						?> />
        <input type="button" value=" Submit "
            class="ui-state-default ui-corner-all" id="submitButEdit" /> <input
            type="reset" value=" Reset " class="ui-state-default ui-corner-all"
            id="resetButEdit" />
    </form>
</div>
<div id="online-users"  >
	<p class="heading"> Online Users <i class="icon icon-remove" id="closebutton"></i></p>
<?php 
$avatar_path = "files/users/avatars/";
if($users = getOnlineUsers()) { ?>
	<table id='user-table'>
	<?php foreach ($users as $temp) { $userDetails = getDetails($temp['userId']); ?>
		<tr>
			<td width='30'>
				<img src="<?php echo $avatar_path.$userDetails['avatar']; ?>" height='25' width='25'/>
			</td>
			<td>
				<p class='name'><?php echo $userDetails['fname']." ".$userDetails['lname']; ?></p>
				<p class='logged-in'><b> Logged In : </b><?php echo $temp['intime']; ?></p>
			</td>
		</tr>
	<?php } ?>
	</table>
<?php }?>
</div>
<?php 
function getOnlineUsers(){
	$db = new HDatabase();
	$db->connect();
	$db->select("qa_loggedUsers","*","userId!='".$_SESSION['SESS_MEMBER_ID']."' AND flag='1'");
	$res = $db->getResult();
	return $res ? $res : false;
}

function getDetails($id){
	$db = new HDatabase();
	$db->connect();
	$db->select("qa_user","*","userId='$id'");
	$res = $db->getResult();
	return $res ? array_shift($res) : false;
}
?>