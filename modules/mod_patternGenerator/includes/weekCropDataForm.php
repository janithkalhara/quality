<?php 
global $import;
$import->importLib("grade");
$import->importLib("season");
?>
<script type="text/javascript">

$(document).ready(function() {
	$('tr.parent')
		.css("cursor","pointer").css('background',"#ccc").css('font-weight',"bold")
		.attr("title","Click to expand/collapse")
		.click(function(){
			$(this).siblings('.child-'+this.id).toggle('slow');
		});
	//$('tr[@class^=child-]').hide().children('td');
});


function setWeekTable(value){
    var target=document.getElementById("target-week-cropdata-container");
   //var target=$('#target-week-cropdata-container');
    if(value!=""){
    	  var table=document.createElement("table");
    	  $('#target-week-cropdata-container').empty();
    	  var tr1=document.createElement("tr");
    	   for(var i=0;i<value;i++){
    		    var td=document.createElement("td");
    		    td.setAttribute("align","center");
    		    td.setAttribute("class","header");
    		    var text=document.createTextNode("Week "+(i+1));
    		    td.appendChild(text);
    		    tr1.appendChild(td);
        	   }
    	  table.appendChild(tr1);
    	  var tr2=document.createElement("tr");
    	    for(var i=0;i<value;i++){
    	         var td=document.createElement("td");
    	         td.setAttribute("align","center");
    	         var input=document.createElement("input");
    	         input.setAttribute("type","text");
    	         input.setAttribute("name","crop-per-week-"+i);
    	         input.setAttribute("id","crop-per-week-"+i);
    	         td.appendChild(input);
    	         tr2.appendChild(td);
    	        }
    	   table.appendChild(tr2);
    	   target.appendChild(table);
        }
    
    

   
 }

  function setEditableWeekData(value){
	    
	    var data=jQuery.parseJSON(value);
	   $('#season-weeks').val(data['seasonId']);
	  // $('#season-weeks').attr("disabled","disabled");
	   $('#gradeCategory-weeks').val(data['cate_id']);
	   ///$('#gradeCategory-weeks').attr("disabled","disabled");
	   $('#task-week-cropData').val('edit_week_crop_data');
	   
	    $.post("modules/mod_patternGenerator/ajax/weekCropManager.php",
	    	    {"flag":"getWeekCropData","seasonId":data['seasonId'],"gradeName":data['gradeName']},function(data){

	    	        var a=jQuery.parseJSON(data);
	    	        $('#num-weeks').val(a.length);
	    	        setWeekTable(a.length);
	    	        
	    	        for(var i=0;i<a.length;i++){
	    	            $('#crop-per-week-'+i).val(a[i]['percentage']);

		    	        }
	    	       
		    	    });
	    

	   
	  }  
function checkweekcropdata(){

	if($('#season-weeks').val()==-1 || $('#gradeCategory-weeks').val()==-1 || $('#num-weeks').val()=="" ){
			
			alert("Please select all field correctly");
		
			return false;
		}else{
			if(!Number($('#num-weeks').val())){
				alert("Please select all field correctly");
				return false
				}else{
					return true;
					}
			
			}
}

function confirmDel(){
	if(confirm("All arrival pattern related to this grade \nwill be not available after deleting.\nAre you sure?")){
			return true;
		}else {
			return false;
		}
}


</script>


<div id="week-cropdata-container">
<fieldset>
<legend class="legend">Enter week crop data.</legend>
<form action="home.php?option=mod_patternGenerator" method="post" onsubmit="return checkweekcropdata()">
    <table >
        <tr>
            <td>Season</td>
            <td>
            <select name="season-weeks" id="season-weeks">
            <option selected="selected" value="-1">Select Season</option>
             <?php
             $season = new Season();
             $seasons=$season->getSeasons();
             foreach ($seasons as $temp){
             	
             	print "<option value='".$temp['seasonId']."'>";
                print $temp['seasonName'];
                print "</option>";
             	
             }
              ?>
            </select>
               
            </td>
        </tr>
        <tr> 
            <td>Grade Category:</td>
            <td>
            <select name="gradeCategory-weeks" id="gradeCategory-weeks">
                <option selected="selected" value="-1">Select Category</option>
            <?php 
            $grade=new Grade();
            $gradeCategories=$grade->getGradeCategories();
            foreach ($gradeCategories as $temp){
            	print "<option value='".$temp['id']."'>";
            	print $temp['name'];
            	print "</option>";
            }
            ?>
            
            </select>
            </td>
               
        </tr>
        <tr> 
            <td>Number of weeks</td>
            <td><input type="text" id="num-weeks" onblur="setWeekTable(this.value)" name="number_weeks"/></td>
               
        </tr>
    
    </table>
    <div id="target-week-cropdata-container">
    
    </div>
    <div id="controller-week-cropdata-container">
    <input type="submit" value="Submit Data" class="buttons-submit" />
	<input type="Reset" value="Reset" class="buttons-reset">
	<input type="hidden" name="task-week-cropData" value="handle_week_crop_data" id="task-week-cropData" />
    <input type="hidden" name="tracker" value="" id="tracker" />
    </div>
    </form>
    </fieldset>
    
</div>

<div id="view-week-cropdata-container">
<?php 
        $db = new HDatabase();
        $db->connect();
        $db->select("qa_ap_gradeWeekPercentages","*","","seasonId,gradeName,weekNo");
        $res = $db->getResult();
        
?>
          
<fieldset>
    <legend class="legend"> View week crop data percentages</legend>
    <table cellpadding="0" cellspacing="0" border="1">
        <tr>
            <td class="header">Season </td>
            <td class="header">Grade Category</td>
            <td class="header">Week No:</td>
            <td class="header">Percentage:</td>
            <td class="header">Action</td>
        </tr>
        <?php 
        if($res){
        	$tracker="";
        	$i=0;
        	foreach ($res as $temp){
        		$seasonName = $season->getSeasonNameById($temp['seasonId']);
        		if($tracker != $temp['cate_id'].'-'.$temp['seasonId']){
        			print "<tr id='id$i' class='parent'>";
        			print "<td>Season: $seasonName</td><td>".$temp['gradeName']."</td>";
        			$i++;
        		}
        		
        		echo "<tr class='child-id".($i-1)."' style='display:none' >";
		           // $seasonName = $season->getSeasonNameById($temp['seasonId']);
		            print "<td >".$seasonName."</td>";
		            print "<td >".$temp['gradeName']."</td>";
		            print "<td >".$temp['weekNo']."</td>";
		            print "<td >".$temp['percentage']."</td>";
		            print "<td ><a class='action' onclick='setEditableWeekData(this.id)' id='".json_encode($temp)."'>Edit</a>
		                   <a class='action' onclick='return confirmDel()'href='home.php?option=mod_patternGenerator&task-week-cropData=remove&id=".$temp['seasonId']."&grade=".$temp['gradeName']."'>Remove</a></td>";
		            print "</tr>";
	            $tracker = $temp['cate_id'].'-'.$temp['seasonId'];
            }
        }else{
        	print "No data";
        }
        ?>
    </table>
</fieldset>
</div>
<?php 
if(isset($_POST['task-week-cropData'])){
	try {
		$task=$_POST['task-week-cropData'];
		if($task=="handle_week_crop_data"){
			handlerCropWeekData::insertWeekCropData($_POST);
		}
		else if($task=="edit_week_crop_data"){
			handlerCropWeekData::updateWeekCropData($_POST);
		}
	}
	catch (Exception $e) {
		print $e->getMessage();
	}
}

if(isset($_GET['task-week-cropData'])){
	$task=$_GET['task-week-cropData'];
	if($task=="remove"){
	   $season=$_GET['id'];
	   $grade=$_GET['grade'];
	   handlerCropWeekData::removeWeekCropData($season,$grade);
	}
}
?>