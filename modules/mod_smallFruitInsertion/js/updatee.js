
var sampleKeys = ['sampleNo',
                  'mellonFlyAttacked',
                  'peeledOff',
                  'boreAttacked',
                  'shrivelled',
                  'mechanicalDamaged',
                  'yellowish',
                  'rustPatches',
                  'rotten',
                  'totalDefects'
                  ];
var sampleKeysExtened = ['sampleNo',
                         'fruitCount',
                         'smallFruit',
                         'largeFruit',
                         'mellonFlyAttacked',
                         'peeledOff',
                         'boreAttacked',
                         'sandEmbedded',
                         'shrivelled',
                         'deformed',
                         'virusAttacked',
                         'mechanicalDamaged',
                         'yellowish',
                         'rustPatches',
                         '45mm',
                         'ac/re',
                         'rotten',
                         'total'
                         ];

var crsSampleKeys = [
                     'fruitCount',
                     'smallFruit',
                     'largeFruit',
                     'melonFlyAttacked',
                     'peeledOff',
                     'boreAttacked',
                     'sandEmbedded',
                     'shrivelled',
                     'mechanicalDamaged',
                     'yellowish',
                     'rustPatches',
                     'AC/RE',
                     'spoiled'
                     ];
var crsStatKeys = ['',
                   'smallFruit',
                   'largeFruit',
                   'melonFlyAttacked',
                   'peeledOff',
                   'boreAttacked',
                   'sandEmbedded',
                   'shrivelled',
                   'mechanicalDamaged',
                   'yellowish',
                   'rustPatches',
                   'accepted',
                   'spoiled'];
var smallGrades = ['11-14','14-17','17-29','29-44','CRS'];
var belongKeys = ['DQ','AQ','11-14','14-17','17-29','29-44','CRS','reject','hiddenLoss','weightLoss'];

$(function(){
	
	$('#project-toppane').prop('disabled','disabled');
	$('#date-toppane').prop('disabled','disabled');
	$('#vehicleNo-toppane').prop('disabled','disabled');
	//$('#project-toppane').val(headers.project);
	$('#project-toppane').val(headers.id);
	$('#date-toppane').val(headers.date);
	$('#batchNo-toppane').val(headers.batchNo);
	$('#center-toppane').val(headers.centers);
	$('#vehicleNo-toppane').val(headers.vehicleNo);
	$('#itmNo-toppane').val(headers.itmNo);
	
	$('input:radio[name="delivery"]').filter('[value="'+headers['transport-delivery']+'"]').attr('checked', true);
	$('input:radio[name="cover"]').filter('[value="'+headers['transport-cover']+'"]').attr('checked', true);
	$('input:radio[name="smell"]').filter('[value="'+headers['transport-smell']+'"]').attr('checked', true);
	$('input:radio[name="otherThings"]').filter('[value="'+headers['transport-otherThings']+'"]').attr('checked', true);
	$('input:radio[name="colorcode"]').filter('[value="'+headers['transport-labels']+'"]').attr('checked', true);
	$('input:radio[name="qualityReport"]').filter('[value="'+headers['transport-QualityReport']+'"]').attr('checked', true);
	$('#bsheet-6-0').val(headers.total_DQ);
	$('#bsheet-6-1').val(headers.total_AQ);
	$('#bsheet-6-2').val(headers['11-14Q']);
	$('#bsheet-6-3').val(headers['14-17Q']);
	$('#bsheet-6-4').val(headers['17-29Q']);
	$('#bsheet-6-5').val(headers['29-44Q']);
	$('#bsheet-6-6').val(headers['crs']);
	$('#bsheet-6-7').val(headers['rejected']);
	$('#bsheet-6-8').val(headers['hiddenLoss']);
	$('#bsheet-6-9').val(headers['weightLoss']);
	$('#6-offgrade').val(headers['totalOffGrade']);
	$('#numofcrates').val(headers['noOfCrates']);
	
	/* setting percentages */
	
	$('#bsheet-7-2').val(Math.round(headers['11-14Q']/headers.total_AQ*100*100)/100);
	$('#bsheet-7-3').val(Math.round(headers['14-17Q']/headers.total_AQ*100*100)/100);
	$('#bsheet-7-4').val(Math.round(headers['17-29Q']/headers.total_AQ*100*100)/100);
	$('#bsheet-7-5').val(Math.round(headers['29-44Q']/headers.total_AQ*100*100)/100);
	$('#bsheet-7-6').val(Math.round(headers['crs']/headers.total_AQ*100*100)/100);
	$('#bsheet-7-7').val(Math.round(headers['rejected']/headers.total_AQ*100*100)/100);
	$('#bsheet-7-8').val(Math.round(headers['hiddenLoss']/headers.total_AQ*100*100)/100);
	$('#bsheet-7-9').val(Math.round(headers['weightLoss']/headers.total_AQ*100*100)/100);
	/* Setting tm table */
	
	for( var i = 0; i<tmls.length; i++){
		$('#centerTableSmall #center'+i).val(tmls[i].center);
		$('#centerTableSmall #tm'+i).val(tmls[i].tmNo);
		$('#centerTableSmall #gr-'+i+"-1").val(tmls[i].grade1);
		$('#centerTableSmall #gr-'+i+"-2").val(tmls[i].grade2);
		$('#centerTableSmall #gr-'+i+"-3").val(tmls[i].grade3);
		$('#centerTableSmall #gr-'+i+"-4").val(tmls[i].grade4);
		$('#centerTableSmall #gr-'+i+"-5").val(tmls[i].grade5);
	}
	/* setting samples*/
	setSampleData('11-14',0);
	//setting belong tables 
	var gradeValue;
	for(i in smallGrades){
		table = parseInt(i)+1;
		gradeValue = getGradeBelong(smallGrades[i]);
		console.log(gradeValue);
		for(k in belongKeys){
			//bsheet-1-1
			row = parseInt(i)+1;
			col = parseInt(k);
			console.log( row+'-'+col+ ' -- ' + belongKeys[k]+' => '+gradeValue[belongKeys[k]]);
			$('#bsheet-'+row+'-'+col).val(gradeValue[belongKeys[k]]);
		}
		$('#'+table+'-offgrade').val(gradeValue['offGrade']);
	}
	
	
});

function setSampleData(grade,tableNo){
	
	var gradeSamples ;
	var afc = parseFloat(getGradeBelong(grade).afc)!=0?parseFloat(getGradeBelong(grade).afc):'';
	var pos = smallGrades.indexOf(grade) ;
	$('#avg-fc-'+pos).html(afc);
	var sample;
	for(var i=0;i<13;i++){
		sample = [];
		sample = getSamplesByGrade(grade,i);
		if(sample){
			for(k in sampleKeysExtened){
				key = sampleKeysExtened[k];
				$('#table-'+tableNo+'-'+k+'-'+i).val(sample[key]);
			}	
		}
	}
	var mode = getGradeBelong(grade).mode ? Boolean(parseInt(getGradeBelong(grade).mode)) : false;
	
	if(mode){
		var tempkeys = sampleKeysExtened;
		tempkeys
		var stat = getGradeStat(grade);
		var value = sum = per = '';
		for(k in sampleKeysExtened){
			key = sampleKeysExtened[k];
			if(stat[key]){
				value = stat[key].split('-');
				//if(Array.isArray(value)){
				sum = value[0];
				per = value[1];
				//}
				$('#table-'+tableNo+'-'+k+'-'+13).val(sum);
				$('#table-'+tableNo+'-'+k+'-'+14).val(per);
			}
		}
		//show extra fields
		$('#form0').find('table tr').show();
		
	}
}

function getSamplesByGrade(grade,pos){
	var belong = getGradeBelong(grade);
	var mode =  typeof(belong)!='undefined'?belong.mode:false;
	for(i in gradeSamples){
		if(gradeSamples[i].gradeName == grade && gradeSamples[i].sampleId == pos ){
			return gradeSamples[i];
		}
	}
	return false;
}

function setCrsData(){
	var sample;
	for(var i=0;i<13;i++){
		sample = getSampleCrs(i);
		if(sample){
			for(k in crsSampleKeys){
				$('#table-4-'+k+'-'+i).val(sample[crsSampleKeys[k]]);
			}
		}
	}
	//setting stat
	for(i in crsStatKeys){
			var val = crsStat[crsStatKeys[i]];
			if(val){
				var a = val.split('-');
				var sum = a[0];
				var per = a[1];
				$('#table-4-'+(i)+'-13').val(sum);
				$('#table-4-'+(i)+'-14').val(per);
		}
	}
}

function getGradeBelong(gradeName){
	for(i in belongs){
		if(belongs[i].gradeName == gradeName){
			return belongs[i];
		}
	}
}

function getGradeStat(gradeName){
	for(i in gradeStats){
		if(gradeStats[i].gradeName == gradeName){
			return gradeStats[i];
		}
	}
}

function getSampleCrs(col){
	for(i in crsSamples){
		
		if(crsSamples[i].sampleId == col){
			return crsSamples[i];
		}
	}
	return false;
	
}

function editMe(){
	//
	var headers = {'date':$('#date-toppane').val(),
					'batchNo':$('#batchNo-toppane').val(),
					'centers':$('#center-toppane').val(),
					'vehicleNo':$('#vehicleNo-toppane').val(),
					'itm':$('#itmNo-toppane').val(),
					'totalOffgrade':$('#6-offgrade').val(),
					'totalDQ':$('#bsheet-6-0').val(),
					'totalAQ':$('#bsheet-6-1').val(),
					'11_14Q':$('#bsheet-6-2').val(),
					'14_17Q':$('#bsheet-6-3').val(),
					'17_29Q':$('#bsheet-6-4').val(),
					'29_44Q':$('#bsheet-6-5').val(),
					'crs':$('#bsheet-6-6').val(),
					'reject':$('#bsheet-6-7').val(),
					'hl':$('#bsheet-6-8').val(),
					'wl':$('#bsheet-6-9').val(),
					'crates':$('#numofcrates').val(),
					'delivery':$("input[name='delivery']:checked").val(),
					'cover':$("input[name='cover']:checked").val(),
					'smell':$("input[name='smell']:checked").val(),
					'otherThings':$("input[name='otherThings']:checked").val(),
					'colorcode':$("input[name='otherThings']:checked").val(),
					'qr':$("input[name='qualityReport']:checked").val()
			};
	
	var gradeSamples = [];
	var flag = grade = false;
	
	for(var i=0;i<4;i++){
		grade = {samples:[],sums:[],pers:[],mode:false}
		if($('#table-'+i+'-0-0').val()){
			grade.mode = $('#toggler-'+i).is(':checked');
			grade.name = smallGrades[i];
			//grade.afc = afc;//parseFloat(afc);
			//var numRows = grade.mode?18:10;
			var numRows = 18;//we save all defects. show only necessary ones	
			for(var j=0;j<13;j++){
				//table-0-0-0
				if($('#table-'+i+'-0-'+j).val()!= '' && Number($('#table-'+i+'-0-'+j).val())){
					var sample = {};
					sample.grade = smallGrades[i];
					sample.gradeId = i;
					sample.id = j;
					sample.samples = [];
					var val;
					for(var k=0; k<	numRows;k++){
						val = $('#table-'+i+'-'+k+'-'+j).val();
						if(val != '' && Number(val)){
							sample.samples.push(val);
						}
						else{
							sample.samples.push(0);
						}
					}
					grade.samples.push(sample);
				}
			}
			if(grade.mode){
				var per = sum = 0;
				for(var k=0; k<numRows; k++){
					sum = $('#table-'+i+'-'+k+'-13').val();
					sum = typeof(sum)!=='undefined'&& sum!=''?parseFloat(sum):0;
					per = $('#table-'+i+'-'+k+'-14').val();
					per = typeof(per)!=='undefined'&& per!=''?parseFloat(per):0;
					grade.sums.push(sum);
					grade.pers.push(per);
				}
			}
			gradeSamples.push(grade);
		}
		else{
			mode = getGradeBelong(smallGrades[i]).mode;
			grade.mode = Boolean(parseInt(mode));
			grade.name = smallGrades[i];
			//var keysArray = grade.mode?sampleKeysExtened:sampleKeys;
			var keysArray = sampleKeysExtened;
			for(var j=0;j<13;j++){
				if(s = getSamplesByGrade(smallGrades[i],j)){
					var s_sample = {};
					
					s_sample.gradeId = i;
					s_sample.id = j;
					s_sample.samples = [];
					for(m in keysArray){
						s_sample.samples.push(s[keysArray[m]]);
					}
					grade.samples.push(s_sample);
				}
			}
			
			if(grade.mode){
				stat = getGradeStat(smallGrades[i]);
				var traverser = sum = per = false;
				for(k in keysArray){
					traverser = stat[keysArray[k]]?stat[keysArray[k]]:'';
					traverser = traverser.indexOf('-') >= 0?traverser.split('-'):[0,0]
					sum = traverser[0]?traverser[0]:0;
					per = traverser[1]?traverser[1]:0;
					grade.sums.push(sum);
					grade.pers.push(per);
				}
				
			}
			
			
			gradeSamples.push(grade)
		}
	}
	//getting crs samples
	var crsSamples = {};
	crsSamples.stat = [];
	crsSamples.samples = [];
	if($('#table-4-0-0').val()){
		for(var i=0;i<13;i++){
			if($('#table-4-0-'+i).val() != '' && $('#table-4-0-'+i).val() != '' ){
				var sample = {};
				sample.id = i; 
				sample.s = [];
				for(var j=0;j<13;j++){
					sample.s.push($('#table-4-'+j+'-'+i).val());
				}
				crsSamples.samples.push(sample);
			}
			
			crsSamples.stat.push([$('#table-4-'+i+'-13').val(),$('#table-4-'+i+'-14').val()]);
			
		}
	
	}
	else{
		//getting from stocks
		for(var i=0;i<13;i++){
			if(sample = getSampleCrs(i)){
				var s_sample = {};
				s_sample.id = i;
				s_sample.s = [];
				for(j in crsSampleKeys){
					s_sample.s.push(sample[crsSampleKeys[j]]);
				}
				crsSamples.samples.push(s_sample);
			}
			
		}
		for(i in crsStatKeys){
			var val = crsStat[crsStatKeys[i]];
			if(val){
				statsArray = val.split('-');
				crsSamples.stat.push([statsArray[0],statsArray[1]]);
			}
		}
		
	}
	//getting balance sheet data
	var belongs = [];
	for(i in smallGrades){
		//bsheet-1-10
		var row = {};
		row.id = i;
		//var afc = $('#avg-fc-'+(parseInt(i))).html();
		row.off = $('#'+(parseInt(i)+1)+'-offgrade').val();
		if($('#avg-fc-'+(parseInt(i))).html()!='') row.afc = $('#avg-fc-'+(parseInt(i))).html();
		if($('#avg-fc-'+(parseInt(i))).html() == '' && getGradeBelong(smallGrades[i]).afc!='0' ){
			row.afc = getGradeBelong(smallGrades[i]).afc; 
		}
		row.d = [];
		for(var j = 0;j < 10;j++){
			row.d.push($('#bsheet-'+(parseInt(i)+1)+'-'+j).val());
		}
		belongs.push(row);
	}
	//getting tm table data 
	var tms = [];
	for(var i=0;i<20;i++){
		var tm = {};
		if($('#center'+i).val() != ''){
			tm.center = $('#center'+i).val();
			tm.tm = $('#tm'+i).val();
			tm.g1 = $('#gr-'+i+'-1').val();
			tm.g2 = $('#gr-'+i+'-2').val();
			tm.g3 = $('#gr-'+i+'-3').val();
			tm.g4 = $('#gr-'+i+'-4').val();
			tm.g5 = $('#gr-'+i+'-5').val();
			tms.push(tm);
		}
		
	}
	//[headers,samples,crsSamples,belongs]
	var data = {'flag':'update',
				'headers':headers,
				'samples':gradeSamples,
				'crs':crsSamples,
				'belongs':belongs,
				'tms':tms};
	console.log(data);
	$('#loading-div').show('500');
	$.ajax({
		url:'modules/mod_smallFruitInsertion/ajax/updater.php',
		data:data,
		async:false,
		type:'post',
		success:function(data){
			if(data.success == true){
				$('#loading-div').hide('500');
				alert('Stock data updated successfully.');
			}else{
				alert(data.message);
			}
			
		}
	});
}