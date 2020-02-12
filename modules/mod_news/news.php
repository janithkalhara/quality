<?php 
defined("HEXEC") or die("Restrited Access.");
$news = array();
$ds = new HDatabase();
$ds->connect();
$ds->select('qa_news','*',null,'id DESC');
$news = $ds->getResult();
?>
<link rel="stylesheet" type="text/css" href="libraries/textEditor/jquery.cleditor.css" />
<link rel="stylesheet" type="text/css" href="modules/mod_news/css/style.css" />
<link rel="stylesheet" type="text/css" href="css/bootstrap.css" />	
<link rel="stylesheet" type="text/css" href="css/font-awesome.css" />	
<script type="text/javascript" src="libraries/textEditor/ckeditor.js"></script>
<script type="text/javascript">
var editor ;
      $(document).ready(function() {
    	  CKEDITOR.replace('newstext',{width : 540, height:100});
    		CKEDITOR.instances['newstext'].on('blur', function() {
    		    CKEDITOR.instances['newstext'].updateElement();
    		});

			$('.action').click(function(){
					var id=$(this).data('ref');
					var action =$(this).data('action'); 
					var that = $(this);
					$.get('modules/mod_mainPanel/seasonManager.php?flag=news&id='+id+'&action='+action,function(d){
						if(d.success == true){
							if(action=='remove'){
								that.closest('.archive').remove();
								alert(d.message);
							}
							else if(action == 'publish'){
								alert(d.message);
							}
						}
					});
				return false;
				});

    		

    	  
      });

      function submitNews(){
          var newstitle=$('#newstitle').val();
          var newstext=CKEDITOR.instances.newstext.getData();
          var showing=$('input[name=showing]:checked').val();
         	
		$.ajax({
			url:'modules/mod_mainPanel/seasonManager.php',
			type:'post',
			data:{'flag':'submitNews','title':newstitle,'text':newstext,'showing':showing},
			success:function(d){
				console.log(d);
				if(d.success == true){
					location.reload(true);
				}else{
					alert(d.message);
					document.forms[1].reset();
						}						
			}
			});
          /*
          $.post('',{'flag':'submitNews','title':newstitle,'text':newstext,'showing':showing},function(data){
              alert(data);
              $('#waiting-div').hide();
              });
          */
      }      
    </script>
<fieldset>
	<legend>
		<b>News Manager</b>
	</legend>
	<form>
		<table border="0" id="news-table">
			<tr>
				<td>News Title</td>
				<td><input type="text" maxlength="200" width="200" id="newstitle"></td>
			</tr>
			<tr>
				<td>News Text</td>
				<td><textarea name="newstext" id="newstext"></textarea></td>
			</tr>
			<tr>
				<td>Showing</td>
				<td>
					<label> Yes	<input type="radio" name="showing" value="yes" checked="checked" /></label>
					<label> No<input type="radio" name="showing" value="no" /></label>
				</td>
			</tr>

			<tr>
				<td><input type="Button" value="submit" onclick="submitNews()"
					class="buttons" /></td>
				<td><input type="reset" value="Reset" class="buttons" /></td>
			</tr>

		</table>
	</form>
	
	<div class="news-archive">
	<h2>News Archive</h2>
	<?php if(!empty($news)){ ?>
		<?php foreach ($news as $item){ ?>
		<div class="archive">
			<p class="title"><?php echo $item['title']; ?></p>
			<div class="body"><?php echo $item['text']; ?></div>
			<small>Published on <?php echo date('d M Y',$item['ts']); ?></small>
			<div class="tools">
				<a href="#" class="btn btn-danger action" data-ref="<?php echo $item['id']; ?>" data-action="remove"><i class="icon-trash"></i> Remove</a>
				<a href="#" class="btn action" data-ref="<?php echo $item['id']; ?>" data-action="publish"><i class="icon-globe"></i> Publish</a>
			</div>
		</div>
		<?php }?>
	<?php }else{ ?>
	<div>Archive is empty.</div>
	<?php }?>
	
	</div>
</fieldset>



