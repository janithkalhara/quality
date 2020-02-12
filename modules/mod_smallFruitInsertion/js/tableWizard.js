function simpleTableWizard(target) {
	
	this.target=document.getElementById(target);
	this.tableCount=0;
	this.baseData;
	this.project;
	this.randerHeaderTable=function(target){
		var headerFields=Array("Project",'Center',"Date",'Vehicle No','Batch-No','Internal Tm No');
		var specAttr={'project-toppane':'onblur="hideDiv()'};
		var headerFieldIDS=Array("project-toppane",'center-toppane',"date-toppane",'vehicleNo-toppane','batchNo-toppane','itmNo-toppane');
		
		//creating the table
		var headerTable=document.createElement('table');
		headerTable.setAttribute('cellpadding',0);
		headerTable.setAttribute('cellspacing',0);
		var textTracker=0;
		var idTracker=0;
		for(var i=0; i<3;i++){
			var row=document.createElement('tr');
			
			for(var j=0;j<4;j++){
				var cell=document.createElement('td');
				
				if(j%2==0){
					var text=document.createTextNode(headerFields[textTracker]);
					var pElement=document.createElement('p');
					pElement.appendChild(text);
					cell.appendChild(pElement);
					textTracker++;
			
				}else{
					if(i==0&&j==1){
						var inPut=document.createElement('select');
					}else{
						
						var inPut=document.createElement('input');
					}
					inPut.setAttribute('id', headerFieldIDS[idTracker]);
					
					idTracker++;
					cell.appendChild(inPut);
					if(i==0&&j==1){
						var __inPut=document.createElement('input');
						__inPut.setAttribute('id', "project-hidden-toppane");
						__inPut.setAttribute('type', "hidden");
						cell.appendChild(__inPut);
					}
					
					if(i==1 && j==3){
						var p=document.createElement('p');
						var text=document.createTextNode("!important");
						p.appendChild(text);
						p.setAttribute("style","color:#FF0F1F;position:relative;float:right;right:75px;top:10px; cursor:pointer");
						p.setAttribute("onmousemove","showHighlight()");
						p.setAttribute("onmouseout","hideHighlight()");
						var div=document.createElement('div');
						var tex3=document.createTextNode("Vehicle Number form Should be either 'xxYY-0000' or '00-0000'.");
						var style="position:absolute;padding:10px;background:#fff;border:1px solid #ccc;display:none;left:550px;top:80px;float:right;z-index:10000";
						div.setAttribute("style",style);
						div.setAttribute("id", "highlight-text");
						div.appendChild(tex3);
						cell.appendChild(div);
						cell.appendChild(p);
					}
				}
				row.appendChild(cell);
				
			}
			headerTable.appendChild(row);
		}
		textTracker++;idTracker++;
		
	var targetDiv=document.getElementById(target);
		targetDiv.appendChild(headerTable)
	};
	
	this.appendNavigator=function(target){
		//butOneSmall
		
		var buttons=Array('butOneSmall',"butTwoSmall",'butThreeSmall',"butFourSmall","butFiveSmall");
		var wrapper=document.createElement('div');	
		var btnWrapper=document.createElement('ul');	
		for(var i=0; i<5;i++){
			var liItem=document.createElement('li');
			var inPut=document.createElement('input');
			inPut.setAttribute('type', 'button');
			inPut.setAttribute('class', 'ui-state-default ui-corner-all');
			inPut.setAttribute('value', i+1);
			inPut.setAttribute('id',buttons[i]);
			liItem.appendChild(inPut);
			btnWrapper.appendChild(liItem);
		}
	//	wrapper.appendChild(btnWrapper);
		var navigator=document.getElementById(target);
		navigator.appendChild(btnWrapper);
		var index=document.createElement('span');
		index.setAttribute('id', 'indexer');
		navigator.appendChild(index);
		var controller=document.createElement('div');
		controller.setAttribute("id", "controller-div");
		var btn=document.createElement('input');
		btn.setAttribute('type', 'button');
		btn.setAttribute('value', 'Show Balance Sheet');
		btn.setAttribute('id', 'show-balanceSheet');
		btn.setAttribute('onclick', 'showBalanceSheet()');
		controller.appendChild(btn);
		var btn2=document.createElement('input');
		btn2.setAttribute('type', 'button');
		btn2.setAttribute('value', 'Export data to Balance Sheet');
		btn2.setAttribute('id', 'export-balanceSheet');
		btn2.setAttribute('onclick', 'exportDataToBalanceSheet()');
		controller.appendChild(btn2);
		navigator.appendChild(controller);
	};
	
	this.appendDataTable=function(target,tableId){
		//set the num of table count
		this.tableCount++;
		var form=document.createElement('form');
		form.setAttribute('id', 'form'+tableId);
		var table=document.createElement('table');
		//var indexText=Array('No: of Sample','Melon Fly Attacked','Peeled Off','Bore Attacked','Dehydrated or Shriveled ',
		//'Mechanical Damages','Yellowish ','Rust Patches','Spoiled / Rotten','Total Defects(No:)');
		table.setAttribute('cellpadding',0);
		table.setAttribute('cellspacing',0);
		//table.setAttribute('border',1)
		//create header
		var sums = ['Per','Sum'];
		for(var i=0; i<18;i++){
			var j=0;
			var cellId=0;
			var row=document.createElement('tr');
			row.setAttribute('id','row-'+tableId+'-'+i);
			while(j<19){
				
				var cell=document.createElement('td');
				if(j==0){
					cell.setAttribute('colspan', 4);
					cell.setAttribute('width', 220);
					cell.setAttribute('class', 'indexes header'+i);
					var text=document.createTextNode(columns[i]);
					var cellTxt=document.createElement('p');
					cellTxt.appendChild(text);
					cell.appendChild(cellTxt);
					j+=4;
				}
				else if(i==0&& (cellId==13 || cellId==14)){
					var text=document.createTextNode(sums[14-cellId]);
					var cellTxt=document.createElement('p');
					cellTxt.appendChild(text);
					cell.appendChild(cellTxt);
					cellId++;
					j++;
				}
				else{
					var inPut=document.createElement('input');
					inPut.setAttribute('id', 'table-'+tableId+'-'+i+'-'+cellId);
					inPut.setAttribute('onblur','calculateQuality(this.id,this.value)');
					inPut.setAttribute('class','table-cell');
					cellId++;
					
					cell.appendChild(inPut);
					j++;
				}
				
				row.appendChild(cell);
				
			}table.appendChild(row);
			
		}
		var targetDiv=document.getElementById(target);
		form.appendChild(table)
		targetDiv.appendChild(form);
	};
	
	this.appendCRSTable=function(target,tableId){
		//set the num of table count
		
		this.tableCount++;
		var form = document.createElement('form');
		form.setAttribute('id', 'form'+tableId);
		var table = document.createElement('table');
		var indexText = ['Fruit Count','Small Fruit','Large Fruit','Melon Fly Attacked','Peeled Off','Bore Attacked',
		'Sand Embedded ','Shrivelled','Mechanical Damaged','Yellowish','Rust Patches','Accepted/Rejected','Spoiled/Rotten'];
		table.setAttribute('cellpadding',0);
		table.setAttribute('cellspacing',0);
		table.setAttribute('id','CRSTable');
		//table.setAttribute('border',1)
		for(var i=0; i<13;i++){
			var row = document.createElement('tr');
			row.setAttribute('id','row-'+tableId+'-'+i);
			var j=0;
			var cellId=0;
			while(j<19){
				var cell=document.createElement('td');
				if(j==0){
					cell.setAttribute('colspan', 4);
					cell.setAttribute('class', 'indexes crs'+i);
					var text=document.createTextNode(indexText[i]);
					var cellTxt=document.createElement('p');
					cellTxt.appendChild(text);
					cell.appendChild(cellTxt);
					j+=4;
				}
				else if(j==17 && i==0){
					var t=document.createTextNode('Sum');
					var cellTxt=document.createElement('p');
					cellTxt.appendChild(t);
					cellTxt.setAttribute('align', 'center');
					cell.setAttribute('class','sum');
					cell.appendChild(cellTxt);
					j++;
				}
				else if(j==18 && i==0){
					var t=document.createTextNode('%');
					var cellTxt=document.createElement('p');
					cellTxt.appendChild(t);
					cellTxt.setAttribute('align', 'center');
					cell.setAttribute('class','sum');
					cell.appendChild(cellTxt);
					j++;
				}
				
				else{
					var inPut=document.createElement('input');
					inPut.setAttribute('id', 'table-'+tableId+'-'+i+'-'+cellId);
					if(j==17|| j==18){
						inPut.setAttribute('disabled', 'disabled');	
					}
					inPut.setAttribute('class','table-cell');
					inPut.setAttribute('onblur','calculateQuality(this.id,this.value)');
					cellId++;
					
				cell.appendChild(inPut);
				j++;
				}
				row.appendChild(cell);
			}
			table.appendChild(row);
		}
		var targetDiv=document.getElementById(target);
		form.appendChild(table)
		targetDiv.appendChild(form);
		var acceptBtn=document.createElement('a');
		acceptBtn.setAttribute('id', 'setAccepted');
		acceptBtn.setAttribute('onclick', 'setAccepted(this.id)');
		
		var link=document.createTextNode('Set Accepted/Rejected');
		acceptBtn.appendChild(link);
		targetDiv.appendChild(acceptBtn);
	};
	
}
