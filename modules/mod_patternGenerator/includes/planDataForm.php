<?php
global $import;
$import->importLib("project");
$import->importLib("season");
$import->importClass('patternGenerator','handler.plandata');
$import->importClass("patternGenerator", "OptionalArrivalPatternMaker");
?>
<script type="text/javascript">
$(document).ready(function(){
	$('#startDate-plandata').datepicker({dateFormat: 'yy-mm-dd'});
});
function loadProjectsforPlan(season){
		$('#waiting-div').show();
		$.post("modules/mod_patternGenerator/ajax/projectSupporter.php",{"flag":"getproject","season":season},function (data){
			$('#waiting-div').hide();
				if(data!="false"){
					$('#project-plandata').html(data);
				}else {
					alert("No projects for this season");
					}				
			});
}

function setDataTable(val){
	   var numOfCells=val;
	   var startDate=$('#startDate-plandata').val();
	    
	   if(isNaN(numOfCells) ){
		    alert("please enter a numerical value");
		    $("#numofweeks-plandata").val("");
	    }
	   /**validate nume of weeks*/
	   else if( numOfCells==""){

		   }
	   /**validate date*/
	   else if(startDate==""){
		   alert("please enter the start date");
           $("#startDate-plandata").focus();
		   }
	   else{
		   var weeks=Array();
		
		     weeks=getWeeksArrayByStartDate(startDate,numOfCells);
		   
				   var table=document.createElement("table");
				   table.setAttribute("border",1);
				   table.setAttribute("cellpadding",0);
				   table.setAttribute("cellspacing",0);
				   table.setAttribute("borderspacing",0);
				   table.setAttribute("id","table-body-plandata");
				   var row1=document.createElement("tr");
				   for(var i=0;i < numOfCells;i++){
					   
					   var cell=document.createElement("td");
					   cell.setAttribute("class","header");
					   var text=document.createTextNode(weeks[i][0]+"-"+weeks[i][1]+ "/"+weeks[i][2]+"-"+weeks[i][3]);
					   var text2=document.createTextNode(weeks[i][4]);
					   var year=document.createElement("p");
					   year.appendChild(text2);
					   cell.appendChild(text);
					   cell.appendChild(year);
					  row1.appendChild(cell);
					   }
				    table.appendChild(row1);
				    var row2=document.createElement("tr");
				       for(var i=0;i < numOfCells;i++){
				           var cell=document.createElement("td");
				           cell.setAttribute("align","center")
				           
				           var input=document.createElement("input");
				           input.setAttribute("type","text");
				           input.setAttribute("id","input-"+i);
				           input.setAttribute("name","input-"+i);
				           input.setAttribute("onblur","checkMyValue(this.value,this.id)");
				           //plan or seeded
				           var select =document.createElement("select");
				           select.setAttribute("name","seededFlag-plandata-"+i);
				           select.setAttribute("id","seededFlag-plandata-"+i);
				           option1=document.createElement("option");
                           option1.setAttribute("value","0");
                           text1=document.createTextNode("p");
                           option1.appendChild(text1);
                           option2=document.createElement("option");
                           
                           option2.setAttribute("value","1");
                           text2=document.createTextNode("s");
                           option2.appendChild(text2);
				           select.appendChild(option1);
				           select.appendChild(option2);
				           //hidden identifier
				           var identifier=document.createElement("input");
                           identifier.setAttribute("type","hidden");
                           identifier.setAttribute("value",weeks[i][0]+"-"+weeks[i][1]+ "/"+weeks[i][2]+"-"+weeks[i][3]+"/"+weeks[i][4]);
                           identifier.setAttribute("name","hidden-input-"+i);

                           cell.appendChild(input);
                           cell.appendChild(select);
                           cell.appendChild(identifier);
                           row2.appendChild(cell);
				           }
				        table.appendChild(row2);
				    $('#body-plandata').empty();
				    $('#body-plandata').append(table);

				    
		   }
}

//getting weeks array
function getWeeksArrayByStartDate(startdate,numofweeks){
	
   var weeks=Array();

    for(var i=0;i<=numofweeks;i++){
       
            weeks[i]=new Array(2);
    }
    var weekstart=new Date(startdate);   
    var weekend=new Date();
    var i=0;
    while(i<numofweeks){
           if(i==0){}else{
               weekstart.setTime(weekstart.getTime()+(86400000*7));
           }
         weekend.setTime(weekstart.getTime()+(86400000*6));
          if(weekstart.getDate()<10){weeks[i][0]="0"+weekstart.getDate();}else{weeks[i][0]=weekstart.getDate();}; 
           if((weekstart.getMonth()+1<10)){weeks[i][1]="0"+(weekstart.getMonth()+1)}else{weeks[i][1]=weekstart.getMonth()+1};
           if((weekend.getDate()<10)){weeks[i][2]="0"+weekend.getDate();} else{weeks[i][2]=weekend.getDate();}
           if((weekend.getMonth()+1)<10){weeks[i][3]="0"+(weekend.getMonth()+1)}else{weeks[i][3]=weekend.getMonth()+1};
           weeks[i][4]=weekstart.getFullYear();  
           i++;              
   }
    
   return weeks;
}

//checking date inputs  
function checkMyValue(value,id){
    if(isNaN(value)){
        alert("Please Enter Numerical value");
        $('#'+id).focus();
        $('#'+id).val("");
        }
    else if(value==""){

        }
}	
//check inputs

function checkInputs(){
    var project =$('#project-plandata').val();
    var season=$('#season-plandata').val();
    var date=$('#startDate-plandata').val();
    var weekCount=$('#numofweeks-plandata').val();
    if(project==-1 || season==-1 || date==""|| weekCount==""){
    	alert('Please fill all fields!');
        return false;
        }
    else{
        return true;
        }

	
}

</script>
<?php

/* handle data */
//var_dump(handlerPlandata::checkDependencies($_POST));

try {
	if(isset($_POST['task'])){
		$task=$_POST['task'];
		if($task=="handle_plan_data"){
			/*
			 * checking relevant data is filled
			 */
			$error_got = handlerPlandata::checkDependencies($_POST);
			if(!$error_got['error']){
				$error;
				if(handlerPlandata::processPlanData($_POST)){
					$error=false;
				}else{
					$error=true;
				}
				if(OptionalArrivalPatternMaker::managerPlan($_POST)){
					$error = false;
					print $error;
					 
				}else{
					$error=true;
				}
				if($error){
					handlerPlanData::clearAll($_POST);
				}
			}else{
				global $mainframe;
				
				if($error_got['type']=="ypa"){
					
					$mainframe->putMessage("It seems you have not entered Yield Per Acre parameter. Please set the YPA value for this project and season in third tab.", ERROR);
					
				}else if($error_got['type']=="gradeShare"){
					
					$mainframe->putMessage("It seems you have not entered Grade share parameter. Please set the Grade share value in third tab.", ERROR);
				
				}else if($error_got['type']=="gradeWeek"){
					
					$mainframe->putMessage("It seems you have not entered Grade Week parameter. Please set the Grade Week value in forth tab.", ERROR);
				
				}
			}
		}else if($task=="edit_plan_data"){
			handlerPlanData::updatePlanData($_POST);
			OptionalArrivalPatternMaker::managerPlan($_POST);
		}
	}
} catch (Exception $e) {
	print $e->getMessage();
}
?>
<hr />
<fieldset>
	<legend>
		<strong>Enter Plan Data </strong>
	</legend>
	<form action="home.php?option=mod_patternGenerator" method="post"
		onsubmit="return checkInputs();">
		<div id="header-plandata">
			<table id="table-header-plandata">
				<tr>
				<td>Season</td>
					<td><select name="season-plandata" id="season-plandata" onchange="loadProjectsforPlan(this.value)">
							<option value="-1">Select Season</option>
							<?php
								$season=new Season();
								$seasons=$season->getSeasons();
							foreach ($seasons as $temp){

								print "<option value='".$temp['seasonId']."'>";
								print $temp['seasonName'];
								print "</option>";

							}

							?>
					</select></td>
					<td>Project</td>
					<td><select name="project-plandata" id="project-plandata">
					<?php

					$project = new Project();
					$projects = $project->getProjects();
					?>
							<option value="-1">Select project</option>
							
					</select>
					</td>
					
				</tr>
				<tr>
					<td>Start Date</td>
					<td><input type="text" name="startDate-plandata"
						id="startDate-plandata" /></td>
					<td>Number of weeks</td>
					<td><input type="text" name="numofweeks-plandata"
						id="numofweeks-plandata" onblur="setDataTable(this.value)" /></td>
				</tr>

			</table>
		</div>
		<div id="body-plandata"></div>
		<div id="controls-plandata">
			<input type="submit" value="Submit Data" class="buttons-submit" /> <input
				type="Reset" value="Reset" class="buttons-reset"> <input
				type="hidden" name="task" value="handle_plan_data" id="task" /> <input
				type="hidden" name="tracker" value="" id="tracker" />
		</div>
	</form>
</fieldset>
