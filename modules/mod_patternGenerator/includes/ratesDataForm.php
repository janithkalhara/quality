<?php
global $import;
$import->importLib("project");
$import->importLib("season");
$import->importLib("grade");
$import->importClass("patternGenerator", "handler.ypaData");
?>
<script type="text/javascript">
function loadProjectsForYpaEdit(season){
	$('#waiting-div').show();
	$.post("modules/mod_patternGenerator/ajax/projectSupporter.php",{"flag":"getproject","season":season},function (data){
		$('#waiting-div').hide();
			if(data!="false"){
				$('#project-edit-YPAratedata').html(data);
			}else {
				alert("No projects for this season");
				}				
		});
}
function getRatesOnProject(){
	seasonId=$('#season-edit-ratesdata').val();
    project=$('#project-edit-YPAratedata').val();
	$.post('modules/mod_patternGenerator/ajax/RateManager.php',{"project":project,"season":seasonId},function(data){
	   var rates=jQuery.parseJSON(data);
	  	if(rates!=null){
			$('#rates-rates-data').show();
	        $('#ypa-edit-ratesdata').val(rates['ypa']);
		}else{
			alert("No Rates for this project.");
		}
	});
}

function checkInputsOnYPArateForm(){
    var project=$('#project-ratesdata').val();
    var season=$('#season-ratesdata').val();
    var ypa=$('#yield-ratesdata').val();

    if(project==-1 || season==-1 || ypa==""){
        alert("Please fill the all fields");
        return false;
    }
    else{
        return true;
    }
}

function checkInputsOnYPArateEditForm(){
	    var season=$('#season-edit-ratesdata').val();
	    var ypa=$('#ypa-edit-ratesdata').val();
	    if( season==-1 || ypa==""){
	        alert("Please fill the all fields");
			return false;
	    }
	    else{
	        return true;
	   	}
}

function setEditable(){
	 var project=$('#project-ratesdata').val();
	 var season=$('#season-ratesdata').val();
	 $('#season-edit-ratesdata').removeAttr('disabled');
     $('#ypa-edit-ratesdata').removeAttr('disabled');
     $('#controller-rates-rates-data').fadeIn();
 	$('#ypa-edit-tracker').val(project+"-"+season);
}

function getGradeShareData(gradeId){
   var result;
    $.ajax({
        url:"modules/mod_patternGenerator/ajax/gradeShareManager.php",
        type:'post',
        dataType:"html",
        data:{"flag":"getSharesByGrade","cateId":gradeId},
        async:false,
        success:function(d){
            result=jQuery.parseJSON(d); 
		}
    });

    if(result!=null){
        $('#update-numberOfGrades').val(result.length);
    	 var table=document.createElement("table");
    	    table.setAttribute("border",1);
    	    table.setAttribute("cellpadding",0);
    	    table.setAttribute("cellspacing",0);
    	    table.setAttribute("style","border-collapse:collapse");
    	    var tr=document.createElement("tr");
    	    for(var i=0;i<result.length;i++){
    	        var td=document.createElement("td");
    	        td.setAttribute("class", "header")
    	        var text=document.createTextNode(result[i]['fc']);
    	        td.appendChild(text);
    	        tr.appendChild(td);
    	        }
        	var tr2=document.createElement("tr");
    	    for(var j=0;j<result.length;j++){
    	        var td=document.createElement("td");
    	        var input1=document.createElement("input");
    	        input1.setAttribute("type", 'text');
    	        input1.setAttribute("style", 'width:50px');
    	        input1.setAttribute("name", "grade-rates-"+j);
    	        input1.setAttribute("value", result[j]['share']);
    	        var input2=document.createElement("input");
    	        input2.setAttribute("type", 'hidden');
    	        input2.setAttribute("name", "grade-rates-hidden-"+j);
    	        input2.setAttribute("value", result[j]['subgradeId']);
    	        var input3=document.createElement("input");
    	        input3.setAttribute("type", 'hidden');
    	        input3.setAttribute("name", "grade-rates-fc-"+j);
    	        input3.setAttribute("value", result[j]['fc']);
    	        td.appendChild(input1);
    	        td.appendChild(input2);
    	        td.appendChild(input3);
    	        tr2.appendChild(td);
    	        }
    		table.appendChild(tr);
    	    table.appendChild(tr2);
    	    $('#gradeShare-edit-table').empty();
    	    $('#gradeShare-edit-table').append(table);
        }
    else{
        alert('No Rates for this Grade Category');
        $('#gradeShare-edit-table').empty();
        }
}
function setEditableShareData(){
    $('#edit-share-cropgraderate').removeAttr('disabled');
	$('#controllers-hare-cropgraderate').fadeIn();
}
function showSubGradesTable(id){
    var cate=id;
    var result;
    $.ajax({
        url:"modules/mod_patternGenerator/ajax/RateShareManager.php",
        type:'post',
        dataType:"html",
        data:{"flag":"getGradeByCate","cate":cate},
        async:false,
        success:function(d){
            result=jQuery.parseJSON(d); 
            }
    });
    $('#numberOfGrades').val(result.length);
    if(result){
	    	var table=document.createElement("table");
	        table.setAttribute("border",1);
	        table.setAttribute("cellpadding",0);
	        table.setAttribute("cellspacing",0);
	        table.setAttribute("style","border-collapse:collapse");
	        var tr=document.createElement("tr");
	        for(var i=0;i<result.length;i++){
	        	var td=document.createElement("td");
	        	td.setAttribute("class", "header")
	        	var text=document.createTextNode(result[i]['fruitCount']);
	        	td.appendChild(text);
	        	tr.appendChild(td);
	            }
	        
	        var tr2=document.createElement("tr");
	        for(var j=0;j<result.length;j++){
	        	var td=document.createElement("td");
	            var input1=document.createElement("input");
	            input1.setAttribute("type", 'text');
	            input1.setAttribute("style", 'width:50px');
	            input1.setAttribute("name", "grade-rates-"+j);
	            var input2=document.createElement("input");
	            input2.setAttribute("type", 'hidden');
	            input2.setAttribute("name", "grade-rates-hidden-"+j);
	            input2.setAttribute("value", result[j]['gradeId']);
	            var input3=document.createElement("input");
	            input3.setAttribute("type", 'hidden');
	            input3.setAttribute("name", "grade-rates-fc-"+j);
	            input3.setAttribute("value", result[j]['fruitCount']);
	            td.appendChild(input1);
	            td.appendChild(input2);
	            td.appendChild(input3);
	            tr2.appendChild(td);
	            }
	    	table.appendChild(tr);
	        table.appendChild(tr2);
	        
	        $('#table').empty();
	        $('#table').append(table);
        }else{
			alert('No data found');
            }
}
function checkcropgraderateform(){
	if($('#view-crop-cropgraderate').val()!=-1){
			return true;
	}else{
		alert("Please select category and edit data to update.");
		return false;
	}
	
}
function loadProjectsForYpa(season){
	$('#waiting-div').show();
	$.post("modules/mod_patternGenerator/ajax/projectSupporter.php",{"flag":"getproject","season":season},function (data){
		$('#waiting-div').hide();
			if(data!="false"){
				$('#project-ratesdata').html(data);
			}else {
				alert("No projects for this season");
			}				
		});
}
</script>
<fieldset>
	<legend>
		<strong>Crop Rates Manager</strong>
	</legend>
	<div id="crop-rate-manager">
		<h4>Enter the Yield per Acre Rates.</h4>
		<form action="home.php?option=mod_patternGenerator" method="post"
			onsubmit="return checkInputsOnYPArateForm()">
			<table width="400">
				<tr>
					<td>Season</td>
					<td><select name="season-ratesdata" id="season-ratesdata"
						onchange="loadProjectsForYpa(this.value)">
							<option value="-1">Select the season</option>
							<?php
							$season = new Season();
							$seasons = $season->getSeasons();
							foreach ($seasons as $temp){
								echo "<option value='".$temp['seasonId']."'>";
								echo $temp['seasonName'];
								echo "</option>";
							}
							?>
					</select>
					</td>
				</tr>
				<tr>
					<td>Project</td>
					<td><select name="project-ratesdata" id="project-ratesdata">
							<option value="-1">Select the project</option>
							<?php
							$project = new Project();
							$projects = $project->getProjects();
							?>
					</select>
					</td>
				</tr>
				<tr>
					<td>Yield per Acre value</td>
					<td><input type="text" name="yield-ratesdata" id="yield-ratesdata" />
						(MTs)</td>
				</tr>
				<tr>
				</tr>
			</table>
			<input type="submit" value="Submit Data" class="buttons-submit" /> <input
				type="Reset" value="Reset" class="buttons-reset"> <input
				type="hidden" name="task" value="handle-ypa-data">
		</form>
		<div id="view-rates-data">
			<h4>View and Edit YPA data</h4>
			<div id="controller-top-rates-data">
				<a href="#" onclick="setEditable()"><span class="hui-edit"></span>Edit</a>
			</div>
			<form action="home.php?option=mod_patternGenerator" method="post" onsubmit="">
				 <label for="season-edit-ratesdata">Season</label>
				 <select name="season-edit-ratesdata" id="season-edit-ratesdata" onchange="loadProjectsForYpaEdit(this.value)">
					<option value="-1">Select the season</option>
					<?php $season=new Season();
					$seasons=$season->getSeasons();
					foreach ($seasons as $temp){
						echo "<option value='".$temp['seasonId']."'>";
						echo $temp['seasonName'];
						echo "</option>";
					}
					?>
				</select>
				<div id="rates-rates-data">
					<table>
						<tr>
							<td><label>Select Project</label>
							</td>
							<td>
								<select	name="project-edit-YPAratedata" id="project-edit-YPAratedata" onchange="getRatesOnProject()">
									<option value='-1'>Select project</option>
								</select>
							</td>
						</tr>
						<tr>
							<td><label for="ypa-edit-ratesdata">Yield per Acre :</label></td>
							<td><input type="text" name="ypa-edit-ratesdata" id="ypa-edit-ratesdata" disabled="disabled" />MT</td>
						</tr>
					</table>
					<div id="controller-rates-rates-data" style="display: none">
						<input type="submit" value="Submit Data" class="buttons-submit" />
						<input type="Reset" value="Reset" class="buttons-reset"> <input
							type="hidden" name="task" value="edit-ypa-data" />
					</div>
				</div>
			</form>
		</div>
	</div>
</fieldset>
<fieldset>
	<legend>
		<strong>Acre-Crop Rates Manager</strong>
	</legend>
	<div id="acre-crop-rate-manager">
		<div id="leftpanel">
			<h4>Enter crop grade-wise percentages</h4>
			<form action="" method="post">
				<table>
					<tr>
						<td><label for="crop-cropgraderate">Grade :</label>
						</td>
						<td>
							<select name="crop-cropgraderate" name="crop-cropgraderate" onchange="showSubGradesTable(this.value)">
								<option value="-1" selected="selected">Select grade</option>
								<?php
								$grade = new Grade();
								$grades = $grade->getGradeCategories();
								foreach ($grades as $temp){
									print "<option value='".$temp['id']."'>";
									print $temp['name'];
									print "</option>";
								}
								?>
						</select>
						</td>
					</tr>

				</table>
				<div id="table"></div>
				<input type="submit" value="Submit Data" class="buttons-submit" /> <input
					type="Reset" value="Reset" class="buttons-reset"> <input
					type="hidden" name="task" value="save-cropgraderate" /> <input
					type="hidden" name="numberOfGrades" id="numberOfGrades" value="" />
			</form>


		</div>

		<div id="rightpanel">
			<h4>View and Edit grade share data</h4>
			<div id="controller"></div>
			<form action="home.php?option=mod_patternGenerator" method="post"
				onsubmit="return checkcropgraderateform()">
				<table>
					<tr>
						<td><label for="view-crop-cropgraderate">Grade </label>
						</td>
						<td><select name="view-crop-cropgraderate"
							id="view-crop-cropgraderate"
							onchange="getGradeShareData(this.value)">
								<option value="-1" selected="selected">Select grade</option>
								<?php
								$grade = new Grade();
								$grades = $grade->getGradeCategories();
								foreach ($grades as $temp){
									print "<option value='".$temp['id']."'>";
									print $temp['name'];
									print "</option>";
								}
								?>
						</select></td>
					</tr>
				</table>
				<div id="gradeShare-edit-table"></div>
				<div id="controllers-hare-cropgraderate" style="">
					<input type="submit" value="Submit Data" class="buttons-submit" />
					<input type="Reset" value="Reset" class="buttons-reset"> 
					<input type="hidden" name="update-numberOfGrades" id="update-numberOfGrades" value="" /> 
					<input type="hidden" name="task" value="edit-cropgraderate" />
				</div>
			</form>
		</div>
	</div>
</fieldset>
<?php
try {
	if(isset($_POST['task'])) {
		$task = $_POST['task'];

		if($task == "handle-ypa-data"){
			handlerYPAData::processData($_POST);
		}
		else if($task == "edit-ypa-data") {
			handlerYPAData::updateData($_POST);
		}
		else if($task == "save-cropgraderate") {
			handlerCropShareData::saveGradeShareData($_POST);
		}
		else if($task == 'edit-cropgraderate') {
			handlerCropShareData::updateShareData($_POST);
		}
	}
}
catch (Exception $e) {
	print $e->getMessage();
}
?>