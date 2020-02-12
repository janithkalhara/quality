
function loadProjects(season){
	$('#waiting-div').show();
	$.post("modules/mod_patternGenerator/ajax/projectSupporter.php",{"flag":"getproject","season":season},function (data){
		$('#waiting-div').hide();
			if(data!="false"){
				$('#project-revisiondata').html(data);
			}else {
				alert("No projects for this season");
				}				
		});
}
var storeKeeper=function(){
	this.weekArray=new Array;
	this.numOfWeeks=0;
	this.weekCount=0;
	this.box=new Array;
	this.storeArray=function(arrayName,array){
		this.box[arrayName]=array;
	};
	
	this.getArrayByName=function(arrayName){
		return this.box[arrayName];
	};
	
	this.setWeekArray=function(array){
		this.weekArray=array;
	};
	this.getWeekArray=function(){
		return this.weekArray;
	};
	this.setNumWeeks=function(num){
		this.numOfWeeks=num;
	};
	this.getNumWeeks=function(){
		return this.numOfWeeks;
	};
	
};

var keeper=new storeKeeper();

function displayRevisionDataTable(){
    var project=$('#project-revisiondata').val();
    var season=$('#season-revisiondata').val();;
    var latestPlanOrRevision=getlatestPlanOrRevision(project,season) ;
    var latestplan;//=new Array();
    var latestRevision=new Array();
 
    //alert(latestPlanOrRevision);
    if(latestPlanOrRevision!=null){
   
    	if(latestPlanOrRevision['flag']=="plan"){
	          var type="Plan";
	          latestplan=latestPlanOrRevision['values'];
	          
	          latestPlanId=latestplan['planId'];
	          
	          latestPlanValues=latestplan['planValues'];
	          latestPlanWeeks=latestplan['weeks'];
	          latestRevisionSeeded=latestplan['seeded'];
	          //store array
	          keeper.storeArray("plan_weeks",latestPlanWeeks);
	          //
	          keeper.storeArray("workingOnFlag","plan");
	          weekCount=latestplan['weekCount'];
	          keeper.weekCount=weekCount;
	          setRevisionSelectorEmpty();
	          setPlanTable(latestPlanId,latestPlanValues,latestPlanWeeks,latestRevisionSeeded,type,weekCount);
	          
          
          }else if(latestPlanOrRevision['flag']=="revision"){
              
              latestRevision = latestPlanOrRevision['values'];
              var type="Revision";
              var restArray=new Array();
              restArray=latestRevision['restArray'];
              restArray.shift();
              
              latestRevisionId=latestRevision['revisionId'];
              latestRevisionValues=latestRevision['revisionValues'];
              latestRevisionWeeks=latestRevision['weeks'];
              latestRevisionSeeded=latestRevision['seeded'];
              weekCount=latestRevision['weekCount'];
              keeper.weekCount=weekCount;
              keeper.storeArray('revision_weeks',latestRevisionWeeks );
              keeper.storeArray("workingOnFlag","revision");
              
              setRevisionSelector(restArray);
              
              setPlanTable(latestRevisionId,latestRevisionValues,latestRevisionWeeks,latestRevisionSeeded,type,weekCount);

          }else{
            	  alert('No plan or revision for this project!');
            	  $('#edit-revision-data').empty();
                  $('#view-plan-data').empty();
                  }
       }

        
    else{
        alert('No plan or revision for this project!');
        $('#edit-revision-data').empty();
       $('#view-plan-data').empty();
      }
    
    
    }

function getlatestPlanOrRevision(p,s){
    var result;

    var data={"flag":"getlatestPlanOrRevision","project":p,"season":s};
	$.ajax({
		url:"modules/mod_patternGenerator/ajax/revisionDataManager.php",
		type:'post',
		dataType:"html",
		data:data,
		async:false,
		success:function(d){
			result=jQuery.parseJSON(d); 
		 	//result=d;
			}
	
	});
//alert(result);
	return result;
}


function  setPlanTable(id,values,weeks,seeded,type,revisionNo){

    var numOfWeeks=values.length;
    //fix date
    
     keeper.numOfWeeks=numOfWeeks;
    var table=document.createElement("table");
    table.setAttribute("border",1);
    table.setAttribute("cellpadding",0);
    table.setAttribute("cellspacing",0);
    table.setAttribute("id","table-latest-revision");
    $('#numOfweeks-hidden').val(keeper.getNumWeeks());
    var row1=document.createElement("tr");
    for(var i=0;i < numOfWeeks;i++){
        
        var cell=document.createElement("td");
        cell.setAttribute("align","center");
        cell.setAttribute("class","header");
        var date=getDateArranged(weeks[i]);
        var text=document.createTextNode(date[0]+"-"+date[1]+"/"+date[2]+"-"+date[3]);
        var text2=document.createTextNode(date[4]);
        var year=document.createElement("p");
        year.appendChild(text2);
        cell.appendChild(text);
        cell.appendChild(year);
       row1.appendChild(cell);
        }
     table.appendChild(row1);
     var row2=document.createElement("tr");
        for(var i=0;i < numOfWeeks;i++){
            var cell=document.createElement("td");
            cell.setAttribute("align","center");
            var p=document.createElement("p");
            var tValue;
            if(seeded[i]==0){
            	tValue="P";
            	
            }else{
            	tValue="S";
            }
            var seed=document.createTextNode(tValue);
            p.appendChild(seed);
            var text=document.createTextNode(values[i]);
            cell.appendChild(text);
            cell.appendChild(p);
            row2.appendChild(cell);
            }
         table.appendChild(row2);
     $('#view-plan-data').empty();
     var h4=document.createElement("h4");
     var h4Text=document.createTextNode("This is latest "+type+ "- No :"+revisionNo);
     h4.appendChild(h4Text);
     $('#view-plan-data').append(h4);
     $('#view-plan-data').append(table);



	
	
}

function getDateArranged(d){
    var splitted=d.split('/');
	var year=splitted[2];
	first=splitted[0];
	second=splitted[1];
	
	f_split=first.split("-");
	firstdate=f_split[0];
	firstmonth=f_split[1];
	s_split=second.split("-");
	seconddate=s_split[0];
	secondmonth=s_split[1];
	
	dates=new Array();
	dates[0]=firstdate;
	dates[1]=firstmonth;
	dates[2]=seconddate;
	dates[3]=secondmonth;
	dates[4]=year;

return dates;
}

function setRevisionSelector(arr){
    
	$('#revision-selector').empty();
	var o=document.createElement("option");
	o.setAttribute("value","-1");
	text=document.createTextNode("Select missed revision");
	o.appendChild(text);
	$('#revision-selector').append(o);
	if(arr){
		for(var i=0;i<arr.length;i++){

			var option=document.createElement("option");
			option.setAttribute("value",arr[i]);
		    text=document.createTextNode(arr[i]);

		    option.appendChild(text);
		    
		    $('#revision-selector').append(option);
			}
	}
	
}

function setRevisionSelectorEmpty() {
	
	$('#revision-selector').empty();
	var o=document.createElement("option");
	o.setAttribute("value","-1");
	text=document.createTextNode("Select missed revision");
	o.appendChild(text);
	$('#revision-selector').append(o);
}

function setRevisionDataEditTable() {
	//get data
	var project=$('#project-revisiondata').val();
	var season=$('#season-revisiondata').val();
	var missedRevision=$('#revision-selector').val();
	var nextRevision=$('#revision-number-selector').val();
	
	var options=new Array();
	$('#revision-selector option').each(function(){
		options.push($(this).val());
	});
	//remove -1
	options.shift();
	
	
	var countChildren=$('#revision-selector').children().length;
	//logic
	
	if(nextRevision==""){
		if(missedRevision!=-1){
			//missed revision is ok; 
			
			revisionWeeks=keeper.getArrayByName("revision_weeks");
			
			DisplayTable(revisionWeeks);
			appendControllers();
			$('#add-number-selector').fadeIn();
			$('#click-number-selector').fadeIn();
			
		
		}
		else{
			alert("Please Select a Revision Number!");
			$('#edit-revision-data').empty();
			$('#project-revisiondata').focus();
		}
		
	}else if(countChildren<=1 && nextRevision!="" ) {
		
		if(nextRevision>1){
			
			var revisionWeeks;
			if(keeper.weekCount==1){
				revisionWeeks=keeper.getArrayByName("plan_weeks");
			}else{
				revisionWeeks=keeper.getArrayByName("revision_weeks");
			}
			
			DisplayTable(revisionWeeks);
			appendControllers();
			$('#add-number-selector').fadeIn();
			$('#click-number-selector').fadeIn();
		}else{
			alert("Please enter correct revision number!");
		}
		
		
	}else{
		
		var h=new helper();
		if(h.searchArray(options,nextRevision )|| nextRevision>Array.max(options)){
			revisionWeeks=keeper.getArrayByName("revision_weeks");
			DisplayTable(revisionWeeks);
			appendControllers();
			$('#add-number-selector').fadeIn();
			$('#click-number-selector').fadeIn();
		}
		else{
			alert('Please enter correct revision number !');
		}
	}
	
	
	
	
}
function manageInputs(value){
	
	if(value!=-1){
		$('#revision-number-selector').val("");
		$('#revision-number-selector').attr("disabled","disabled");
	}else{
		$('#revision-number-selector').removeAttr("disabled");
		
	}
	
}

function DisplayTable(weeks){
	var numOfWeeks=weeks.length;
    //fix date
    
     
    var table=document.createElement("table");
    table.setAttribute("border",1);
    table.setAttribute("cellpadding",0);
    table.setAttribute("cellspacing",0);
    table.setAttribute("id","data-table-revision");
    var row1=document.createElement("tr");
    row1.setAttribute("id", "tr1-data-table-revision");
    for(var i=0;i < numOfWeeks;i++){
    	
        var cell=document.createElement("td");
        cell.setAttribute("align","center");
        cell.setAttribute("class","header");
        var date=getDateArranged(weeks[i]);
        var text=document.createTextNode(date[0]+"-"+date[1]+"/"+date[2]+"-"+date[3]);
        var text2=document.createTextNode(date[4]);
        var year=document.createElement("p");
        year.appendChild(text2);
        cell.appendChild(text);
        cell.appendChild(year);
       row1.appendChild(cell);
        }
     table.appendChild(row1);
     var row2=document.createElement("tr");
     row2.setAttribute("id", "tr2-data-table-revision");
        for(var i=0;i < numOfWeeks;i++){
            var cell=document.createElement("td");
            cell.setAttribute("align","center");
            var date=getDateArranged(weeks[i]);
            var input=document.createElement("input");
            input.setAttribute("type","text");
            input.setAttribute("id","revisionData-insert-"+i);
            input.setAttribute("name","revisionData-insert-"+i);
            
            var input2=document.createElement("input");
            input2.setAttribute("type","hidden");
            //
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
            
            
            
            input2.setAttribute("id","hidden-revisionData-insert-"+i);
            input2.setAttribute("name","hidden-revisionData-insert-"+i);
            input2.setAttribute("value",date[0]+"-"+date[1]+"/"+date[2]+"-"+date[3]+"/"+date[4]);
            cell.appendChild(input);
            cell.appendChild(select);
            cell.appendChild(input2);
            
            row2.appendChild(cell);
            }
         table.appendChild(row2);
     $('#edit-revision-data').empty();
    var h=document.createElement("h4");
    var text=document.createTextNode("Enter New Revision Data");
     h.appendChild(text);
     $('#edit-revision-data').append(h);
     $('#edit-revision-data').append(table);

	
	
	
	
	
	
}

function getNextWeek(current){
	
	var splitted1=current.split("/");
    var y=splitted1[2];
    var f_m_s=splitted1[0];
    var l_m_s=splitted1[1];
    
    D_split1=f_m_s.split("-");
    D_split2=l_m_s.split("-");
    
    firstdate=D_split1[0];
    firstmonth=D_split1[1];
    
    seconddate=D_split2[0];
    secondmonth=D_split2[1];
    
    lastDate=y+"-"+secondmonth+"-"+seconddate;
    
    var nextday=new Date(lastDate);
    var nextStartDate=new Date(lastDate);
    nextDate=new Date(lastDate);
    nextStartDate.setDate(nextday.getDate()+1);
    nextDate.setDate(nextday.getDate()+7);
    
    fixed=nextStartDate.getDate()+"-"+(nextStartDate.getMonth()+1)+"/"+nextDate.getDate()+"-"+(nextDate.getMonth()+1)+"/"+y;
    return fixed;
}

function addWeekToDataEditTable(){

	var nextWeek;
	var numOfWeeks=$('#add-number-selector').val();
	
	if(numOfWeeks!=""){
		var flag=keeper.getArrayByName("workingOnFlag");
		keeper.numOfWeeks+=parseInt(numOfWeeks);
		if(flag=="plan"){
			
			var planWeeks=keeper.getArrayByName("plan_weeks");
			weekNo=planWeeks.length;
			nextWeek=getNextWeek(planWeeks.pop());
			
			var i=0;
			while(i<numOfWeeks)	{
				var td1=document.createElement("td");
				td1.setAttribute("align","center");
		        td1.setAttribute("class","header");
				var date=getDateArranged(nextWeek);
				//rearranging dates to full numbers
				if(date[0]<10)date[0]="0"+date[0];
				if(date[1]<10)date[1]="0"+date[1];
				if(date[2]<10)date[2]="0"+date[2];
				if(date[3]<10)date[3]="0"+date[3];
				
				
				
				var text=document.createTextNode(date[0]+"-"+date[1]+"/"+date[2]+"-"+date[3]);
				var text2=document.createTextNode(date[4]);
				var p=document.createElement("p");
				p.appendChild(text2);
				td1.appendChild(text);
				td1.appendChild(p);
				$('#tr1-data-table-revision').append(td1);
				
				var td2=document.createElement("td");
				td2.setAttribute("align","center");
				var input=document.createElement("input");
				input.setAttribute("type","text");
				 input.setAttribute("id","revisionData-insert-"+weekNo);
		         input.setAttribute("name","revisionData-insert-"+weekNo);
		         
		         var input2=document.createElement("input");
		         input2.setAttribute("type","hidden");
				 input2.setAttribute("id","hidden-revisionData-insert-"+weekNo);
		         input2.setAttribute("name","hidden-revisionData-insert-"+weekNo);
		         input2.setAttribute("value",date[0]+"-"+date[1]+"/"+date[2]+"-"+date[3]+"/"+date[4]);
		         
		         var select =document.createElement("select");
		           select.setAttribute("name","seededFlag-plandata-"+weekNo);
		           select.setAttribute("id","seededFlag-plandata-"+weekNo);
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
		         
		         
				td2.appendChild(input);
				td2.appendChild(select);
				td2.appendChild(input2);
				$('#tr2-data-table-revision').append(td2);
				
				weekNo++;
				
				nextWeek=getNextWeek(nextWeek);
				i++;
				//append num of weeks
				
			}
			$('#numOfweeks-hidden').val(keeper.getNumWeeks());
			
		}else if(flag=="revision"){
			
			var planWeeks=keeper.getArrayByName("revision_weeks");
			nextWeek=getNextWeek(planWeeks.pop());
			
			
			weekNo=planWeeks.length+1;
			//for(;;){
				var i=0;
			while(i<numOfWeeks)	{
				var td1=document.createElement("td");
				td1.setAttribute("align","center");
		        td1.setAttribute("class","header");
				var date=getDateArranged(nextWeek);
				//rearranging dates to full numbers
				if(date[0]<10)date[0]="0"+date[0];
				if(date[1]<10)date[1]="0"+date[1];
				if(date[2]<10)date[2]="0"+date[2];
				if(date[3]<10)date[3]="0"+date[3];
				var text=document.createTextNode(date[0]+"-"+date[1]+"/"+date[2]+"-"+date[3]);
				var text2=document.createTextNode(date[4]);
				var p=document.createElement("p");
				p.appendChild(text2);
				td1.appendChild(text);
				td1.appendChild(p);
				$('#tr1-data-table-revision').append(td1);
				
				var td2=document.createElement("td");
				td2.setAttribute("align","center");
				var input=document.createElement("input");
				input.setAttribute("type","text");
				 input.setAttribute("id","revisionData-insert-"+weekNo);
		         input.setAttribute("name","revisionData-insert-"+weekNo);
		         
		         var input2=document.createElement("input");
		         input2.setAttribute("type","hidden");
				 input2.setAttribute("id","hidden-revisionData-insert-"+weekNo);
		         input2.setAttribute("name","hidden-revisionData-insert-"+weekNo);
		         input2.setAttribute("value",date[0]+"-"+date[1]+"/"+date[2]+"-"+date[3]+"/"+date[4]);
		         
		         var select =document.createElement("select");
		           select.setAttribute("name","seededFlag-plandata-"+weekNo);
		           select.setAttribute("id","seededFlag-plandata-"+weekNo);
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
		         
				td2.appendChild(input);
				td2.appendChild(select);
				td2.appendChild(input2);
				$('#tr2-data-table-revision').append(td2);
				
				weekNo++;
				
				nextWeek=getNextWeek(nextWeek);
				i++;
				
			}
			//append num of weeks
		
			
		}
		$('#numOfweeks-hidden').val(keeper.getNumWeeks());
	}else{
		alert('Please enter number of weeks to add');
		return false;
	}
	
	
}

function appendControllers(){
	
	var sbmt=document.createElement("input");
	sbmt.setAttribute("type","submit");
	sbmt.setAttribute("value","Submit Data");
	sbmt.setAttribute("class","button-submit");
	
	var rst=document.createElement("input");
	rst.setAttribute("type","reset");
	rst.setAttribute("value","Reset");
	rst.setAttribute("class","button-reset");
	
	var task=document.createElement("input");
	task.setAttribute("type","hidden");
	task.setAttribute("name","task");
	task.setAttribute("value","enter-revision-data");

	
	
	$("#controllers-revision-data").append(sbmt);
	$('#controllers-revision-data').append(rst);
	$('#controllers-revision-data').append(task);
}

function submitForm(){
	
	if(confirm("Are you sure want to submit data.Please check data again !")){
		
		return true;
	}else{
		return false;
	}
	
	
}








