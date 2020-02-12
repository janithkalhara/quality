function tableAnalyzer(){
	this.tableId;
	
	this.tables=[0,0,0,0,0];
	this.noOfCrates= ["","","","",""];
	
	this.notedWeight= [0,0,0,0,0];
	this.trueWeight=[0,0,0,0,0];
	this.sumDefectGrade=[0,0,0,0,0];
	this.reducedDefectGrade=[0,0,0,0,0];
	this.sumDefects=[0,0,0,0,0];
	this.reducedDefects=[0,0,0,0,0];
	this.payableQuantity=[0,0,0,0,0];
	this.averageFruitCount=[0,0,0,0,0];
	this.quantity=0;
	this.date2=null;
	this.project;
	this.vehicleNo;
	this.centerNo;
	this.centerArray=[[0,0],[0,0],[0,0],[0,0],[0,0],[0,0]];
	this.tmNo;
	this.sampleValues=new Array();

	// new CR for insertion of direct rejection quantity - 2020-02-08
	this.drqNoOfBags= [0,0,0,0,0];
	this.drqNoOfKilos= [0,0,0,0,0];
	
	for (var i = 0; i<5; i++){
		this.sampleValues[i]= new Array();
		var j=0;
		while(j<17){
			this.sampleValues[i][j]=[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
			j++; 
		}
	}
	this.transportData=[0,0,0,0,0,0];
	
	
	this.sumColumn=[[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
	                [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
	                [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
	                [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
	                [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0]];
		 
	this.rows=['','Fruit Count','Small Fruit','Large Fruit','Melon Fly Attacked',
	           'Peeled Off','Bore Attacked','Sand Embedded','Shrivelled','Deformed'
	           ,'Virus Attacked','Mechanical Damaged','Yellowish','Rust Patches','','','Rotten',];
	this.sumsArray=Array();
	for (var i = 0; i<5; i++){
		this.sumsArray[i]= new Array();
		var j=0;
		while(j<17){
			this.sumsArray[i][j]=[0,0,0,0,0,0,0,0,0,0,0,0,0,0];
			j++; 
		}
	}
	this.setTableId=function(){
		
		this.tables[table]=table;
		
	};
	
	this.gradesSampleSizes={"80-160":{"mm":"14-17","size":1},
			"20-80":{"mm":"17-29","size":2},
			"5-20":{"mm":"29-44","size":7},
			"15-25(No.2)":{"mm":"24-30","size":5},
			"10-15(No.3)":{"mm":"30-42","size":5},
			"5-10(No.4)":{"mm":"42-45","size":8},
			"CRS":{"mm":"16<->44","size":8}
			};
	this.grade=[0,0,0,0,0];
	this.gradeId=[0,0,0,0,0];	
	this.sampleCounter=[[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
		                    [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
		                    [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
		                    [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
		                    [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0]];
	this.percentageArray=[[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
		                    [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
		                    [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
		                    [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
		                    [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0]];
	this.acceptedArray=[[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
		                    [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
		                    [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
		                    [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
		                    [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0]];
		
	this.averageFruitCount=Array(5);
	this.fruitCount=Array(5);
	
	this.fillSumColumn=function(table,value,rowId,cell){
		this.tableId=table;
		/* Setting the date */
		this.date2=$('#date-toppane').val();
		
		/*setting the grade*/
		
		this.grade[this.tableId]=$('#'+this.tableId+"-grade").val();
		/* setting the gradeId*/
		var gId=$('#'+this.tableId+"-gradeId").val();
		var gidArr=gId.split(':');
		this.gradeId[this.tableId]=gidArr[0];
		
		
		this.tables[table]=table;
		var target=this.tableId+'-slot-'+rowId+"-13";
		this.sumsArray[this.tableId][rowId][cell]=parseFloat(value);
		var sum=this.findSum(rowId,'sum');
			if(!isNaN(sum)){
				$('#'+target).val(sum);
				this.sumColumn[this.tableId][rowId]=sum;
			}	
	};
	
	this.findSum=function(row,flag){
		var sum=0;
		var counter=0;
		var average=0;
		for (var i=0;i<13;i++){
			if(this.sumsArray[this.tableId][row][i]!=0){
				sum+=parseFloat(this.sumsArray[this.tableId][row][i]);
				counter ++;
			}
		}
		average=sum/counter;
		if(flag=="sum"){
			return sum;
		}
		else if(flag=="average"){
			if(isNaN(average)){
				return 0;
			}
			else {
				return average;
			}
		}else if('count'){
			return counter;
		}
	};
	
	this.setAverageFruitCount=function(){
		var sum=0;var counter=0;var averageFC=0;
		for(var i=0; i<this.sumsArray[this.tableId][1].length;i++  ){
			if(this.sumsArray[this.tableId][1][i]!=0){
				sum+=parseFloat(this.sumsArray[this.tableId][1][i]);
				counter++;
			}
		}
		var percentage=sum/counter;
		
		percentage=Math.round(percentage*100)/100;
		percentage=Math.round(percentage);
		this.averageFruitCount[this.tableId]=percentage;
	var target=this.tableId+"-avgFruitCount";
	$("#"+target).val(percentage);
	};
	this.setSampleValues=function(id,value){
		//1-slot-3-0
		var expandedId=id.split('-');
		var row=expandedId[2];
		var cell=expandedId[3];
		this.sampleValues[this.tableId][cell][row]=value;
		this.sampleValues[this.tableId][cell][0]=$('#'+this.tableId+'-slot-'+'0-'+cell).val();
	};
	/* Setting Percentages*/
	this.setPercentages=function(row){
		if(row!=1){
			var sum=this.findSum(row, 'sum');
		var count=this.findSum(1, "count");
		
			//var sampleSize=parseFloat(this.gradesSampleSizes[this.grade[this.tableId]]['size']);
		var size=$('#'+this.tableId+"-gradeId").val();
		//var sampleSize=
		var sizeArray=size.split(':');
		var sampleSize=sizeArray[1];
		
		//var sampleSize=parseFloat(this.gradesSampleSizes[this.grade[this.tableId]]['size']);
		var divider=sampleSize*count*parseFloat(this.averageFruitCount[this.tableId]);
		
		var percentage=sum/divider;
		percentage=Math.round(percentage*10000)/100;
		this.percentageArray[this.tableId][row]=percentage;
		
		var target=this.tableId+"-slot-"+row+"-14";
		
			$('#'+target).val(percentage);
			
		}
	};
	
	this.fillPercentageTable = function(){
		var defectGrade;
		defectGrade = this.percentageArray[this.tableId][2]+this.percentageArray[this.tableId][3];
		defectGrade = Math.round(defectGrade*100)/100;
		var targetDefectGrade = this.tableId+"-sum-defectGrade-sum";
		$('#'+targetDefectGrade).val(defectGrade);
		this.sumDefectGrade[this.tableId] = defectGrade;
		var reducedDefectGrade;
		if(defectGrade > 10){
			reducedDefectGrade = defectGrade - 10;
		}else{
			reducedDefectGrade = 0;
		}
		reducedDefectGrade = Math.round(reducedDefectGrade*100)/100;
		$('#'+this.tableId+'-sum-defectGrade-reduced').val(reducedDefectGrade);
		this.reducedDefectGrade[this.tableId] = reducedDefectGrade;
		//Set the the defects value
		var defects = 0;
		for(var i=4; i<15; i++){
			defects += parseFloat( this.percentageArray[this.tableId][i]);
		}
		//Rotten percentage
		var rottenPercentage = this.percentageArray[this.tableId][16];
		rottenPercentage = Math.round(rottenPercentage*100)/100;
		// Rounding
		defects = Math.round(defects*100)/100;
		var defectReduction = parseFloat(reductions[this.tableId - 1]);
		var targetDefects = this.tableId+"-sum-defects-sum";
		this.sumDefects[this.tableId] = defects;
		// Setting the value of Reduced defects
		$('#'+targetDefects).val(defects); 
		var reducedDefects;
		if(defects > defectReduction){
			reducedDefects = defects - defectReduction;
		}else{
			this.trueWeight[this.tableId] = $('#'+this.tableId+"-sum-trueWeight").val();
			reducedDefects = 0;
		}
		reducedDefects = reducedDefects+rottenPercentage;
		var targetReducedDefects = this.tableId+"-sum-defects-reduced";
		reducedDefects = Math.round(reducedDefects*100)/100;
		$('#'+targetReducedDefects).val(reducedDefects);
		this.reducedDefects[this.tableId] = reducedDefects;
		if(mode == 'EDIT'){
			reduce = reducedDefects + reducedDefectGrade;
			AQ = $('#'+this.tableId+"-sum-trueWeight").val();
			if(AQ != '' || AQ!=0){
				PQ = AQ - (AQ*reduce/100);
				PQ = Math.round(PQ*100)/100;
				$('#'+this.tableId+'-sum-pq-sum').val(PQ);
			}
		}
	};
	//Set Payable quantity
	this.completeCalculation = function(table){
		this.tableId = table;
		this.trueWeight[this.tableId] = $('#'+table+"-sum-trueWeight").val();
		this.noOfCrates[this.tableId] = $('#'+table+"-sum-noCrates").val();
		this.notedWeight[this.tableId] = $('#'+table+"-sum-notedWeight").val();

		this.transportData[0] = $("input[name='delivery']:checked").val();
		this.transportData[1] = $("input[name='cover']:checked").val();
		this.transportData[2] = $("input[name='smell']:checked").val();
		this.transportData[3] = $("input[name='otherThings']:checked").val();
		this.transportData[4] = $("input[name='colorcode']:checked").val();
		this.transportData[5] = $("input[name='qualityReport']:checked").val();
		//this.trueWeight=this.trueWeight;
		var totalReducable = this.reducedDefectGrade[this.tableId]+this.reducedDefects[this.tableId];
		totalReducable = Math.round(totalReducable*100)/100;
		var trWeight = this.trueWeight[this.tableId];
		var pQuantity = trWeight*(1-(totalReducable/100));
		//4-sum-noCrates
		pQuantity = Math.round(pQuantity*100)/100;
		this.payableQuantity[this.tableId] = pQuantity;
		
		$('#'+table+"-sum-pq-sum").val(this.payableQuantity[this.tableId]);
		/* Set accepted or rejected s */
		var grade = $('#'+this.tableId+'-grade').val();
		var sumOf = Array();
		for(var i=0;i<14;i++){
		   var fc = $('#'+this.tableId+'-slot-'+1+'-'+i).val();
			var sum = 0;
			for (var j=4;j<14;j++){
				sum += parseFloat( this.sampleValues[this.tableId][i][j]);
			}
			if(sum > 0){
				var size = $('#'+this.tableId+"-gradeId").val();
		        var sizeArray = size.split(':');
		        var sampleSize = sizeArray[1];
				var average = sum/(this.averageFruitCount[this.tableId]*sampleSize);
				average = average*100
				average = Math.round(average*100)/100;
				var respond = average > 7 ? "RE" : "AC";   
				$('#'+this.tableId+'-slot-'+15+'-'+i).val(respond);	
				this.acceptedArray[this.tableId][i] = respond;
			}else if(sum == 0 && fc!=""){
				$('#'+this.tableId+'-slot-'+15+'-'+i).val('AC');	
				this.acceptedArray[this.tableId][i] = 'AC';
			}
		}
		/* set transport data */
		/* set center data*/
		for(var i = 0;i<6;i++){
			this.centerArray[i][0] = $('#centerName'+(i+1)).val();
			this.centerArray[i][1] = $('#'+(i+1)+'-tmToppane').val();
		}
	};
	/*  Getters  */
	this.getSumOf = function(row){
		var retValue = this.sumsArray[row];
		return retValue;
	};
	this.setGeneralValues = function(){
		this.project = $('#project-toppane').val();
		this.vehicleNo = $('#vehicle-toppane').val();
		this.centerNo = $('#center-toppane').val();
		this.tmNo = $('#tm-toppane').val();
	};
	/* edit on 2011-10-17*/
	this.reArrangePercentages = function(table){
		var fc = this.averageFruitCount[table];
		var numOfSamples = this.getSampleCount();
		var a = $('#'+table+'-gradeId').val();
		var arr = a.split(':');
		var sampleSize = arr[1];
		var divider = fc*numOfSamples*sampleSize;
		for(var i=2;i<17;i++){
			if(i != 14 || i != 15){
				//1-slot-4-14
				var sum = $('#'+table+'-slot-'+i+'-13').val();
				var per = (sum/divider)*100;
				per = Math.round(per*100)/100;
				this.percentageArray[table][i] = per;
				$('#'+table+'-slot-'+i+'-14').val(per);
			}
		}
	};
	this.getSampleCount = function(){
		var counter = 0;
		for(var i = 0; i<13;i++){
			var value = $('#'+this.tableId+'-slot-1-'+i).val();
			if(value != ""){
				counter++;
			}
		}
		return counter;
	};
	
	this.submitData = function(id,value){
		$('#loading-div').show(500);
		this.date2 = $('#date-toppane').val();
		this.project = $('#project-toppane').val();
		this.projectName = $('#project-toppane:selected').text();
		this.vehicleNo = $('#vehicle-toppane').val();
		this.centerNo = $('#center-toppane').val();
		/*
		this.transportData[0]= $("input[name='delivery']:checked").val();
		this.transportData[1]= $("input[name='cover']:checked").val();
		this.transportData[2]= $("input[name='smell']:checked").val();
		this.transportData[3]= $("input[name='otherThings']:checked").val();
		this.transportData[4]= $("input[name='colorcode']:checked").val();
		this.transportData[5]= $("input[name='qualityReport']:checked").val();
		console.log(this.transportData);
		/* Saving header data */
		var quantity=0;
		for(var i=0;i<this.notedWeight.length;i++){
			
			quantity += parseFloat(this.notedWeight[i]);
			
			// new CR for insertion of direct rejection quantity - 2020-02-08
			this.drqNoOfBags[i] = $('#'+i+'-no-of-bags').val();
			this.drqNoOfKilos[i]= $('#'+i+'-no-of-kilos').val();			
		}
		this.quantity = quantity;	
		/*
		 * header data to stock table
		 */
		var saveheader = {
				"areaId":this.project,
				"areaName":this.projectName,
				"quantity":this.quantity,
				"vehicleNo":this.vehicleNo,
				"handovering":this.transportData[0],
				"lorryCovering":this.transportData[1],
				"badSmell":this.transportData[2],
				"otherGoods":this.transportData[3],
				"labelling":this.transportData[4],
				"qualityReports":this.transportData[5],
				"date":this.date2
				};
		
		/*saving gradeStock data*/
		var saveGradeStock = new Array();
		//this array begins from 1 .not 0	
		
		for(var i=1;i<this.tables.length;i++){
			if(this.grade[i] == 0){}
			else{
				var gradeId_pre = $('#'+i+'-gradeId').val();
				var gradeIdArr = gradeId_pre.split(':');
				
				var gradeId = gradeIdArr[0];
				var dataArray = {
						"flag":"saveGradeStock",
						"projectId":this.project,
						"project":this.projectName,
						"vehicleNo":this.vehicleNo,
						"date":this.date2,
						"gradeId":this.gradeId[i],
						"noOfCrates":this.noOfCrates[i],
						"notedWeight":this.notedWeight[i],
						"trueWeight":this.trueWeight[i],
						"averageFruitCount":this.averageFruitCount[i],
						"fruitCount":$('#'+i+'-slot-1-13').val(),
						"sumOfSmallFruit":this.sumColumn[i][2],
						"sumOfLargeFruit":this.sumColumn[i][3],
						"sumOfFlyAttacked":this.sumColumn[i][4],
						"sumOfPeeledOff":this.sumColumn[i][5],
						"sumOfBoreAttacked":this.sumColumn[i][6],
						"sumOfSandEmbedded":this.sumColumn[i][7],
						"sumOfShrivelled":this.sumColumn[i][8],
						"sumOfDeformed":this.sumColumn[i][9],
						"sumOfVirusAttacked":this.sumColumn[i][10],
						"sumOfMechanicalDamaged":this.sumColumn[i][11],
						"sumOfYellowish":this.sumColumn[i][12],
						"sumOfRustPatches":this.sumColumn[i][13],
						"sumOf45":this.sumColumn[i][14],
						"sumOfRotten":this.sumColumn[i][16],
						"totalPerOfDefectGrade":this.sumDefectGrade[i],
						"totalPerOfDefect":this.sumDefects[i],
						"reducedPerOfDefectGrade":this.reducedDefectGrade[i],
						"reducedPerOfDefect":this.reducedDefects[i],
						"payableQuantity":this.payableQuantity[i],
						"drqNoOfBags":this.drqNoOfBags[i],
						"drqNoOfKilos":this.drqNoOfKilos[i]
						
				};
				saveGradeStock[i-1] = dataArray;
				/*
				$.post("modules/mod_insertionData/ajax/dataHandler.php",,function(data){
				});
				*/
			}
		}
		/*  Saving Sample Data*/
		//get centre names
		
		var centers = Array();
		var tms = Array();
		for(var i=1; i<7;i++){
			if($('#centerName'+i).val() && $('#tm-toppane'+i).val()){
				centers[i] = $('#centerName'+i).val();
				tms[i] = $('#tm-toppane'+i).val();
			}
		}
		/*update center data*/
		var saveCenterData = new Array(6);
		for(var i=0;i<6;i++){
			if(this.centerArray[i][0] != 0){
				var dataArray = {
								'projectId':this.project,
								'project':this.projectName,
								'date':this.date2,
								'vehicleNo':this.vehicleNo,
								'centerFakeNo':i,
								'centerName':this.centerArray[i][0],
								'tmNo':this.centerArray[i][1]
				};
				saveCenterData[i]=dataArray;
			}
		}
		//setting sample array
		var savesamples = new Array(this.tables.length);
		//initializing the sample array
		for(var i=0;i<this.tables.length;i++){
			savesamples[i] = new Array(this.sampleValues[i].length);
			for(var j=0;j<this.sampleValues[i].length;j++){
				savesamples[i][j]=0;
			}
		}
		for(var i=0; i<this.tables.length;i++){
			if(this.tables[i] != 0){
				savesamples[i] = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
				for(var j=0;j<this.sampleValues[i].length;j++){
					if(this.sampleValues[i][j][1] != 0){
						var dataArray2 = {
								"flag":"savesamples",
								"project":this.projectName,
								"projectId":this.project,
								"sampleId":j,
								"vehicleNo":this.vehicleNo,
								"gradeId":this.gradeId[i],
								"centerId":this.sampleValues[i][j][0],
								"date":this.date2,
								"sampleFruitCount":this.sampleValues[i][j][1],
								"smallFruit":this.sampleValues[i][j][2],
								"largeFruit":this.sampleValues[i][j][3],
								"flyAttacked":this.sampleValues[i][j][4],
								"peeledOff":this.sampleValues[i][j][5],
								"boreAttacked":this.sampleValues[i][j][6],
								"sandEmbedded":this.sampleValues[i][j][7],
								"shrivelled":this.sampleValues[i][j][8],
								"deformed":this.sampleValues[i][j][9],
								"virusAttacked":this.sampleValues[i][j][10],
								"mechanicalDamaged":this.sampleValues[i][j][11],
								"yellowish":this.sampleValues[i][j][12],
								"rustPatches":this.sampleValues[i][j][13],
								"45":this.sampleValues[i][j][14],
								"accepted":this.acceptedArray[i][j],
								"spoiled":this.sampleValues[i][j][16]
								
						};
						savesamples[i][j] = dataArray2;
						}
					}
			}
		}
		var saveuserDetails = {	
				"projectId":this.project,
				"project":this.projectName,
				"date":this.date2,
				"vehicleNo":this.vehicleNo
				};
		var userId = $('#userId').val();
		var dataArray = Array();
		var images = Array();
		var images_desc = Array();
		var exts = Array();
		for(var i=0;i<3;i++){
			if($('#file-nm-'+i).val()){
				images[i] = $('#file-nm-'+i).val();
				var extension = images[i].substr(images[i].lastIndexOf('.'));
				exts[i] = extension;
				images[i] = i;
			}else{
				images[i] = "";
				exts[i] = "";
			}
		}
		for(var i=0;i<3;i++){
			if($('#file-'+i).val()){
			images_desc[i] = $('#file-'+i).val();
			}else{
				images_desc[i] = "";
			}
		}
		var dataArrayImage = {"projectId":this.project,
						"project":this.projectName,
						"date":this.date2,
						"vehicleNo":this.vehicleNo,
						'image1':images[0]+exts[0],
						'image2':images[1]+exts[1],
						'image3':images[2]+exts[2],
						'image_desc1':images_desc[0],
						'image_desc2':images_desc[1],
						'image_desc3':images_desc[2]
		};
		var saveImageDetails=dataArrayImage;
		var saveCenterQuantity;
			var quantityArraySet = new Array(20);
			for(var i=0;i<20;i++){
				if($('#center'+i).val() != ""){
					quantityArraySet[i] = [
					this.project,
					this.projectName,
					this.date2,
					this.vehicleNo,
					$('#center'+i).val(),
					$('#tm'+i).val(),
					$('#gr-'+i+'-1').val(),
					$('#gr-'+i+'-2').val(),
					$('#gr-'+i+'-3').val(),
					$('#gr-'+i+'-4').val(),
					''
					];				
				}
			}
			saveCenterQuantity = quantityArraySet;
			//sending all data to server 
			console.log(saveGradeStock);
			var dataSet = {"flag":"save",
							"saveheader":saveheader,//done
							"saveGradeStock":saveGradeStock,//done
							"saveCenterData":saveCenterData,//done
							"savesamples":savesamples,//done
							"saveuserDetails":saveuserDetails,//done
							"saveImageDetails":saveImageDetails,
							"saveCenterQuantity":saveCenterQuantity//done
						};
			
			$.post("modules/mod_insertionData/ajax/dataHandler.php",dataSet ,function(data){
				 alert(data);
				 $('#loading-div').hide(500);
			}); 
		};
		this.fillPrintTable=function(table){
			for(var i=0;i<this.sumColumn[table].length;i++){
				if(this.sumColumn[table][i]!=0){$('#'+table+'-print-slot-'+i+'-13').html(this.sumColumn[table][i]);}
			}
		/* samples values */
		for(var i=0;i<this.sampleValues[table].length;i++){
			for(var j=0;j<this.sampleValues[table][i].length;j++){
				if(this.sampleValues[table][i][j]!=0){
					$('#'+table+'-print-slot-'+j+'-'+i).html(this.sampleValues[table][i][j]);
				}
			}
		}
			
		for(var i=0;i<this.percentageArray[table].length;i++){
			if(this.percentageArray[table][i]!=0){
				$('#'+table+'-print-slot-'+i+'-14').html(this.percentageArray[table][i]);
			}
		}
		
		for(var i=0; i<this.acceptedArray.length;i++){
			for(var j=0;j<this.acceptedArray[i].length;j++){
				if(this.acceptedArray[i][j]!=0){
				$('#'+i+'-print-slot-'+15+'-'+j).html(this.acceptedArray[i][j]);
				}
			}
		}
		
		/*Grade value */
		$('#stationName').html($('#print-centerName').val());
		$('#'+table+'-print-grade').html($('#'+table+'-grade').val());
		/* set average*/
		//1-avgFruitCount
		$('#'+table+'-print-avgFruitCount').html(this.averageFruitCount[table]);
		//1-print-sum-noCrates
		var crates = this.noOfCrates[table].toString();
		var container = '';
		if(crates != ""){
			if(crates.indexOf('/') >= 0){
				var crbs = crates.split('/');
				var _crates = crbs[1];
				var _bags = crbs[0];
				container = (_bags!='')?_bags+"(bags)/":"";
				container += _crates+"(crates)";
			}else{
				container=crates+'bags'
			}
		}else{
		}

		$('#'+table+'-print-sum-noCrates').html(container);
		$('#'+table+'-print-sum-notedWeight').html(this.notedWeight[table]);
		$('#'+table+'-print-sum-trueWeight').html(this.trueWeight[table]);
		$('#'+table+'-print-sum-defectGrade-sum').html(this.sumDefectGrade[table]);
		$('#'+table+'-print-sum-defectGrade-reduced').html(this.reducedDefectGrade[table]);
		$('#'+table+'-print-sum-defects-sum').html(this.sumDefects[table]);
		$('#'+table+'-print-sum-defects-reduced').html(this.reducedDefects[table]);
		$('#'+table+'-print-sum-pq-sum').html(this.payableQuantity[table]);
		$("#print_date").html($('#date-toppane').val());
		$("#print-project").html(this.project);
		$("#print-vehicle").html(this.vehicleNo);
		$("#print-tmnumbers").html(this.vehicleNo);
		for(var i=0;i<6;i++){
			$('#print-center-'+(i+1)).html(this.centerArray[i][0]);
			$('#print-tm-'+(i+1)).html(this.centerArray[i][1]);
		}
		$repArray = ["නැත","ඇත"];
		$('#print-delivery').html($repArray[this.transportData[0]]);
		$('#print-lorryCover').html($repArray[this.transportData[1]]);
		$('#print-smell').html($repArray[this.transportData[2]]);
		$('#print-otherThings').html($repArray[this.transportData[3]]);
		$('#print-colorCode').html($repArray[this.transportData[4]]);
		$('#print-qualityReport').html($repArray[this.transportData[5]]);
		};
}