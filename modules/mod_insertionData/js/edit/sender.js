var error={};


function sendData(){
	//should validate here
	
	var dataSet={
			'flag':'update',
			'headers':getHeaders(),
			'tms':getTmTableData(),
			'stocks':getStockData(),
			'samples':getSamples()
	};

	$.ajax({
		url:'modules/mod_insertionData/ajax/updateHandler.php',
		data:dataSet,
		type:'post',
		async:false,
		success:function(data){
			if(data.success==true){
				alert(data.message);
				window.location=data.url;
			}else{
				alert(data.message);
			}
		}
		
	});
}

function getHeaders(){
	
	var headers={};
	headers.date=$('#date-toppane').val();
	headers.project=$('#project-hidden-toppane').val();
	headers.vehicleNo=$('#vehicle-toppane').val();
	headers.centers=[];
	for(var i=0;i<6;i++){
		var tmpCenter=$('#centerName input#centerName'+(i+1)).val();
		var tmpTm=$('#centerName input#'+(i+1)+'-tmToppane').val();
		
		if(tmpCenter!='' && tmpTm!=''){
			tmp={'center':tmpCenter,'tm':tmpTm};
			headers.centers.push(tmp);
		}
		
		
	}
	//getting DQs
	var dq=0;
	for(var i=0;i<4;i++){
		if($('#'+(i+1)+'-sum-notedWeight').val()){
			dq+=parseFloat($('#'+(i+1)+'-sum-notedWeight').val());
		}else if(gradeStocks[i]){
			dq+=parseFloat(gradeStocks[i].value.notedWeight);
		}
	}
	
	headers.dq=dq;
	headers.params=getParams(); 
	return headers;
}

function getTmTableData(){
	
	var tms=[];
	
	for(var i=0;i<20;i++){
		var center=$('#centerTable input#center'+i).val();
		var tm=$('#centerTable input#tm'+i).val();
		if(center!='' && tm!=''){
			var tmp={};
			tmp.center=center;
			tmp.tm=tm;
			tmp.grade1=$('#centerTable input#gr-'+i+'-1').val();
			tmp.grade2=$('#centerTable input#gr-'+i+'-2').val();
			tmp.grade3=$('#centerTable input#gr-'+i+'-3').val();
			tmp.grade4=$('#centerTable input#gr-'+i+'-4').val();
			tms.push(tmp);
		}
	}
	
	return tms;
}

function getStockData(){
	var stocks=[];
	for(var i=0;i<grades.data.length;i++){
		var fc=$('#'+(i+1)+'-slot-1-13').val();
		var avgFc=$('#'+(i+1)+'-avgFruitCount').val();
		var grade=$('#'+(i+1)+'-gradeId').val();
		
		if(grade && grade!=''){
			splitted=grade.split(':');
			grade=splitted[0];
		}
		else if(grades.data[i].grade){
			grade=grades.data[i].grade;
		}
		var tmpData=getDataByGrade(grade).value;

		if((fc &&fc!='') && (avgFc && avgFc!='') && (grade && grade!='')){
			
			var stock={};
			stock.grade=grades.data[i].grade;
			
			for(var j=0;j<map.length;j++){
				
				if($('#'+(i+1)+map[j].key).val()){
					stock[map[j].value]=$('#'+(i+1)+map[j].key).val();
				}else if(tmpData){
					stock[map[j].value]=tmpData[map[j].value];
				}
			}
			stocks.push(stock);
		}else if(tmpData){
			var stock={};
			stock.grade=grades.data[i].grade;
			
			for(var j=0;j<map.length;j++){
				
					stock[map[j].value]=tmpData[map[j].value];
			}
			stocks.push(stock);
			
		}else{
		}
	}
	
	return stocks;
}

function getSamples(){
	
	var samples=[];
	for(var i=0;i<grades.data.length;i++){
		var tempSamples=getSamplesByGrade(grades.data[i].grade);
		for(var j=0;j<13;j++){
			
			var tmp={};
			for(var l=0;l<mapSamples.length;l++){
				sampleId=$('#'+(i+1)+mapSamples[1].key+j).val();
				if($('#'+(i+1)+mapSamples[l].key+j).val() && sampleId!=''){
					tmp['sampleId']=j;
					tmp['grade']=grades.data[i].grade;
					tmp[mapSamples[l].value]=$('#'+(i+1)+mapSamples[l].key+j).val();
					
					
				}else if(tempSamples[j]){
					tmp['sampleId']=j;
					tmp['grade']=grades.data[i].grade;
					tmp[mapSamples[l].value]=tempSamples[j][mapSamples[l].value];
					
				}
			
				
			}
			if(count(tmp)>0)
			samples.push(tmp);
		}
	}
	return samples;
	
}
function getParams(){
	var params={};
	params['delivery']= $("input[name='delivery']:checked").val();
	params['cover']= $("input[name='cover']:checked").val();
	params['smell']= $("input[name='smell']:checked").val();
	params['otherThings']= $("input[name='otherThings']:checked").val();
	params['colorcode']= $("input[name='colorcode']:checked").val();
	params['qualityReport']= $("input[name='qualityReport']:checked").val();
	return params;
}
