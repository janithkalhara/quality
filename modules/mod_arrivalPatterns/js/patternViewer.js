function generateAll(){
	if(check()){
		var project=$('#project-pattern-viewer').val();
		var season=$('#season-pattern-viewer').val();
		var manager=new Manager();
		var renderer=new Renderer();
		manager.project=project;
		manager.season=season;
		renderer.project=project;
		renderer.season=season;
		var plans=manager.getPlan(project,season);
		$('#data-table-graph-pattern-viewer').empty();
			projectName=renderer.getProjectNameById(project);
			seasonName=renderer.getSeasonNameById(season);
			if(plans!=null){
				renderer.renderPlanTable(plans);
				revisions = manager.getRevisions(project,season);
				console.log(revisions);
				if(revisions!=null && revisions.length > 0) {
					renderer.renderRevisions(revisions);
					renderer.calculatePattern(renderer.lastRevision);
					renderer.renderGraph(renderer.values,renderer.weeks,projectName,seasonName);
				}else{
					renderer.calculatePattern(plans);
					renderer.renderGraph(renderer.values,renderer.weeks,projectName,seasonName);
				}
			}else{
				alert('No Plan for this project in this season');
				$('#plan-pattern-viewer').empty();
				$('#graph-pattern-viewer').empty();
			}
	}
}

function loadProjectsForpPV(season){
	$('#waiting-div').show();
	$.post("modules/mod_patternGenerator/ajax/projectSupporter.php",{"flag":"getproject","season":season},function (data){
		$('#waiting-div').hide();
			if(data!="false"){
				$('#project-pattern-viewer').html(data);
			}else {
				alert("No projects for this season");
				}				
		});
}

function check(){
	if($('#project-pattern-viewer').val()==-1 ){
		alert("Please select a project!");
		return false;
	}
	else{
		return true;
	}
}

var Manager=function(){
	this.getPlan=function(p,s){
		var result;
		var data={'flag':'getPlan','project':p,'season':s};
		$.ajax({
			url:"modules/mod_arrivalPatterns/ajax/manager.php",
			type:'post',
			dataType:"html",
			data:data,
			async:false,
			success:function(d){
				result=jQuery.parseJSON(d); 
				}
		
		});
		return result;
	};
	this.getRevisions=function(p,s){
		var revisions;
		var data={'flag':'getRevisions','project':p,'season':s};
		$.ajax({
			url:"modules/mod_arrivalPatterns/ajax/manager.php",
			type:'post',
			dataType:"html",
			data:data,
			async:false,
			success:function(d){
				revisions=jQuery.parseJSON(d); 
				}
		});
		return revisions;
	};
	
};

var Renderer=function(){
	this.lastRevision;
	this.project;
	this.season;
	this.weeks = [];
	this.values = [];
	
	this.renderPlanTable=function(data){
		var weeks=data;
		var numOfWeeks=weeks.length;
		weeksNames=Array();
		weekVals=Array();
		weekseed=Array();
		 
		for(i=0;i<numOfWeeks;i++){
			weeksNames[i]=weeks[i]['week'];
		}
		for(i=0;i<numOfWeeks;i++){
			weekVals[i]=weeks[i]['noOfAcers'];
		}
		for(i=0;i<numOfWeeks;i++){
			if(weeks[i]['seeded']==0)weekseed[i]="P";else weekseed[i]="S";
		}
		var table=this.getTable(3,numOfWeeks,'plan-table');
		$('#plan-pattern-viewer').empty();
		$('#plan-pattern-viewer').append(table);
		this.setHeaders('plan-table',weeksNames);
		this.setRows('plan-table',1,weekVals);
		this.setRows('plan-table',2,weekseed);
	};
	
	this.renderRevisions=function(r){
		var numOfRevisions=r.length;
		var revisions  = [];
		var headers = [];
		var rows = [];
		var seeded = [];
		$('#revision-pattern-viewer').empty();
		for(var i=0; i<numOfRevisions;i++){
			var seed = null;
			revisions[i]=Array(2);
			headers[i]=new Array(r[i].length);
			rows[i]=new Array(r[i].length);
			seeded[i]=new Array(r[i].length);
			numOfWeeks=r[i].length;
			console.log(r[i]);
			for(var j=0; j<r[i].length;j++){
				headers[j] = r[i][j]['week'];
				rows[j] = r[i][j]['noOfAcers'];
				seed = r[i][j]['seeded']==0 ? 'P' : 'S';
				seeded[j]= seed;
			}
			console.log(headers);
			console.log(rows);
			console.log(seeded);
			var tables=[];
			var field=this.getField("Revision No:"+r[i][0]['weekCount']);
			var table=this.getTable(3,numOfWeeks,'revision-'+i+'-table');
			field.appendChild(table);
			$('#revision-pattern-viewer').append(field);
			this.setHeaders('revision-'+i+'-table',headers);
			this.setRows('revision-'+i+'-table',1,rows);
			this.setRows('revision-'+i+'-table',2,seeded);
		}
		this.lastRevision = r.pop();
	};
	this.getTable=function(rows,columns,id){
		var table=document.createElement("table");
		table.setAttribute("id", id);
		table.setAttribute("border",1);
		table.setAttribute("cellpadding",0);
		table.setAttribute("cellspacing",0);
		table.setAttribute("style","width:100%");
		for(var i=0;i<rows;i++){
			var tr=document.createElement("tr");
			for(var j=0;j<columns;j++){
			
				var td=document.createElement("td");
				if(i==0){
					td.setAttribute("class","header");
					td.setAttribute("id",id+"-header-"+j);
					td.setAttribute("align","center");
				}
				else{
					td.setAttribute("id",id+"-body-"+i+"-"+j);
					td.setAttribute("align","center");
				}
				tr.appendChild(td);
			}
			table.appendChild(tr);
		}
		return table;
	};
	
	this.setHeaders=function(table,headers){
		for(i=0;i<headers.length;i++){
			$("#"+table+"-header-"+i).html(headers[i]);
		}
	};
	this.getField=function (name){
		fld=document.createElement("fieldset");
		legnd=document.createElement("legend");
		text=document.createTextNode(name);
		legnd.appendChild(text);
		fld.appendChild(legnd);
		return fld;
	};
	this.addHeader=function(table,header){
	};
	this.setRows=function (table,rowNum,data){
		for(i=0;i<data.length;i++){
				$("#"+table+"-body-"+rowNum+"-"+i).html(data[i]);
		}
	};
	
	this.calculatePattern=function(lastrevision) {
		if(!lastrevision) { return false; }
		var values=Array();
		var weeks=Array();
		var seeds=Array();
		for(i=0;i<lastrevision.length;i++){
			values[i]=lastrevision[i]['noOfAcers'];
			weeks[i]=lastrevision[i]['week'];
			seeds[i]=lastrevision[i]['seeded'];
		}
		patternValues = this.getPatternValues(values);
		this.values=patternValues;
		this.weeks=weeks;
	};
	this.getPatternValues=function(values){
		data={'flag':"getPatternValues",'project':this.project,'season':this.season,'values':values};
		var patternVals;
		$.ajax({
			url:"modules/mod_arrivalPatterns/ajax/manager.php",
			type:'post',
			dataType:"html",
			data:data,
			async:false,
			success:function(d){
				patternVals=jQuery.parseJSON(d); 
			}
		});
		return patternVals;
		
	};
	this.getProjectNameById=function(pid){
		var project = null;
		$.ajax({
			url:"modules/mod_arrivalPatterns/ajax/manager.php",
			type:'post',
			dataType:"json",
			data:{"flag":"getProjectId","project":pid},
			async:false,
			success:function(d){
				if(d.success) {
					project = d.name;
				}
			}
		});
		return project;
	};
	this.getSeasonNameById=function(sid){
		var season;
		$.ajax({
			url:"modules/mod_arrivalPatterns/ajax/manager.php",
			type:'post',
			dataType:"html",
			data:{"flag":"getSeasonId","season":sid},
			async:false,
			success:function(d){
				season=d
				}
		});
		return season;
		
	};
	this.renderGraph=function(values,weeks,p,s){
		var d=new Date();
		//date.format();
		$('#header-data').show();
		$('#print-project').html(p);
		$('#print-season').html(s);
		$('#print-date').html(d.toLocaleDateString());
		dates = this.getDateByString(weeks[0]);
		fd=dates[0];
		ld=dates[1];
		//getting large week array
		largeWeeks=this.getWeeksArrayByStartDate(fd,5+values.length);
		largeWeeks.pop();
		re_largeWeeks=Array();
		for(var i=0;i<largeWeeks.length;i++){
			re_largeWeeks[i]=this.getDateString(largeWeeks[i]);
		}
		pre_array=Array(0,0,0,0,0);
		actualValues=$.merge(pre_array,values);
		var sliced=re_largeWeeks.slice(5);
		var chart;
		this.appendDataTable(values,sliced);
		$(document).ready(function() {
			chart = new Highcharts.Chart({
				chart: {
					renderTo: 'graph-pattern-viewer',
					defaultSeriesType: 'line',
					marginRight:20,
					marginBottom: 100
				},
				title: {
					text: 'Arrival Patterns',
					x: -20 //center
				},
				subtitle: {
					text: '',
					x: -20
				},
				xAxis: {title: {
                    text: 'Weeks'
                },labels: {	y:95,
                            rotation: 90,
                            align: 'right',
                            style: {
                                 font: 'normal 10px Verdana, sans-serif'
                            }
                            },
					categories:sliced
				},
				yAxis: {
					title: {
						text: 'Quantity (MT)'
					},
					plotLines: [{
						value: 0,
						width: 1,
						color: '#808080'
					}]
				},
				tooltip: {
					formatter: function() {
			                return '<b>'+ this.series.name +'</b><br/>'+
							this.x +':<b> '+ this.y +'MT</b>';
					}
				},
				legend: {
					layout: 'horizontal',
					align: 'right',
					verticalAlign: 'top',
					x: -10,
					y: 10,
					borderWidth: 0
				},
				series: [{
					name: 'Expected Quantity',
					data: values
				}]
			});
			chart.setSize(990, 500);
			
		});
		
		
	};
	
	this.getWeeksArrayByStartDate2=function(startdate,numofweeks){
		var weeks=Array();
	    for(var i=0;i <= numofweeks;i++){ weeks[i]=new Array(2); }
	    var weekstart = new Date(startdate);   
	    var weekend = new Date();
	    var i = 0;
	    while(i<numofweeks) {
	           if(i!=0){
	        	   weekstart.setTime(weekstart.getTime()+(86400000*7));
	           }
	           weekend.setTime(weekstart.getTime()+(86400000*6));
	           if(weekstart.getDate()<10){
	        	   weeks[i][0]="0"+weekstart.getDate();
	           }else{
	        	   weeks[i][0]=weekstart.getDate();
	           }
	           if((weekstart.getMonth()+1<10)) {
	        	   weeks[i][1]="0"+(weekstart.getMonth()+1)
	           }else{
	        	   weeks[i][1]=weekstart.getMonth()+1
	           }
	           if((weekend.getDate()<10)){
	        	   weeks[i][2]="0"+weekend.getDate();
	           }else{
	        	   weeks[i][2]=weekend.getDate();
	           }
	           if((weekend.getMonth()+1)<10){
	        	   weeks[i][3]="0"+(weekend.getMonth()+1)
	           }else{
	        	   weeks[i][3]=weekend.getMonth()+1
	           };
	           weeks[i][4]=weekstart.getFullYear();  
	           i++;              
	   }
	   return weeks;
	};
	this.getDateByString=function(dateStr){
		var splitted=dateStr.split('/');
		year = splitted[2];
		df = splitted[0];
		dl = splitted[1];
		sp1=df.split('-');
		sp2=dl.split('-');
		fd=sp1[0];
		fm=sp1[1];
		ld=sp2[0];
		lm=sp2[1];
		firstDay=new Date(year+"-"+fm+"-"+fd);
		endDay=new Date(year+"-"+lm+"-"+ld);
		dates=Array(2);
		dates[0]=firstDay;
		dates[1]=endDay;
		return dates;
	};
	
	this.getWeeksArrayByStartDate=function(startdate,numofweeks){
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
	           if((weekstart.getMonth()+1)<10){weeks[i][1]="0"+(weekstart.getMonth()+1)}else{weeks[i][1]=weekstart.getMonth()+1};
	           if((weekend.getDate()<10)){weeks[i][2]="0"+weekend.getDate();} else{weeks[i][2]=weekend.getDate();}
	           if((weekend.getMonth()+1)<10){weeks[i][3]="0"+(weekend.getMonth()+1)}else{weeks[i][3]=weekend.getMonth()+1};
	           weeks[i][4]=weekstart.getFullYear();  
	           i++;                
	   }
	    return weeks;
	};
	this.getDateString=function(d){
		dstr = d[0]+"-"+d[1]+"/"+d[2]+"-"+d[3]+"/"+d[4];
		return dstr;
	};
	
	this.appendDataTable=function(values,weeks){
		field=this.getField("Data");
		table=this.getTable(2,values.length,"chart-data-table");
		field.appendChild(table);
		field=this.getField("Data [All units are (MT)]");
		table=this.getTable(2,values.length,"chart-data-table");
		field.appendChild(table);
		$('#data-table-graph-pattern-viewer').append(field);
		this.setHeaders('chart-data-table',weeks);
		this.setRows('chart-data-table',1,values);
	};
	
};

function printTheReport(){
	var disp_setting="toolbar=yes,location=no,directories=yes,menubar=yes,"; 
    disp_setting+="scrollbars=yes,width=870, height=790, left=100, top=25"; 
    var content_vlue = document.getElementById("graph-pattern-viewer-wrapper").innerHTML; 
    var docprint=window.open("","",disp_setting); 
	docprint.document.open(); 
	docprint.document.write('<link rel="stylesheet" href="css/insertionData.css" type="text/css">');    
	docprint.document.write('<body onLoad="self.print()">');          
	docprint.document.write(content_vlue);          
	docprint.document.write('</body>');
	docprint.document.close(); 
	docprint.focus(); 
}

$(document).ready(function(){
	$('#graph-pattern-viewer-wrapper').hover(
			function(){
				$('#print-toobar').fadeIn('slow');
			},
			function(){
				$('#print-toobar').fadeOut('slow');
			});
});