function tablePrinter() {
	this.cols;
	this.rows;
	this.targetElement;
	this.tableId;
	this.table=document.createElement('table');
	this.init=function(target,tableId,cols,rows){
		
		this.cols=cols;
		this.rows=rows;
		this.targetElement=document.getElementById(target);
		this.tableId=tableId;
		var form=document.createElement('form');
		
		this.table.setAttribute('border','1');
		this.table.setAttribute('class','datatable');
		this.table.setAttribute('cellpadding',0);
		this.table.setAttribute('cellspacing',0);
		this.table.setAttribute('id',tableId+'-print');
		var firstRow=document.createElement('tr');
		var k=0; 
	
		while(k<cols){
			var firstRowCells=document.createElement('td');
			if(k==0){
				firstRowCells.setAttribute('colspan',2);
				var text1=document.createTextNode('Grade');
				var pElement=document.createElement('p');
				pElement.setAttribute('align', 'right');
				
				pElement.appendChild(text1);
				firstRowCells.appendChild(pElement);
				
				k+=2;
			}
			else if(k==2){
				firstRowCells.setAttribute('colspan',2);
				var content=document.createElement('p');
				
				content.setAttribute('id',this.tableId+'-print-grade');
				
				firstRowCells.appendChild(content);
				k+=2;
				
			}
			else if(k==4){
				var text1=document.createTextNode(' ');
				var pElement=document.createElement('p');
				pElement.setAttribute('style','');				
				pElement.appendChild(text1);	
				firstRowCells.appendChild(pElement);
				firstRowCells.setAttribute('colspan',2);
				
				k+=2;
				
				
			}
			else if(k==6){
				firstRowCells.setAttribute('colspan',4);
				var content=document.createTextNode('  Accepted Fruit Count');
				var pElement=document.createElement('p');
				pElement.appendChild(content);
				pElement.setAttribute('align', 'right');
				
				firstRowCells.appendChild(pElement);
				k+=4;
				
			}
			else if(k==10){
				firstRowCells.setAttribute('colspan',3);
				var content=document.createElement('p');
				
				content.setAttribute('id',this.tableId+'-print-avgFruitCount');
				firstRowCells.appendChild(content);
				k+=3;
				
			}
			else if(k==13){
				
				var content=document.createTextNode(' Sum ');
				var pElement=document.createElement('p');
				pElement.appendChild(content);
				pElement.setAttribute('align', 'center');
				firstRowCells.appendChild(pElement);
				k+=1;
				
			}else if(k==14){
				
				var content=document.createTextNode(' %');
				var pElement=document.createElement('p');
				pElement.appendChild(content);
				pElement.setAttribute('align', 'center');
				firstRowCells.appendChild(pElement);
				k+=1;
				
			}
			
			else{
				var text1=document.createTextNode(' test');
				firstRowCells.appendChild(text1);
				k++;
				
			}
			firstRow.appendChild(firstRowCells);
			
		
			
			
		}
		this.table.appendChild(firstRow);
		
		for(var i=0; i<this.rows;i++){
			var tableRow=document.createElement('tr');
			for(var j=0;j<this.cols;j++){
				var tableCell=document.createElement('td');
				//var inputs=document.createElement('span');
				///inputs.setAttribute('id', tableId+'-print-'+i+'-'+j);
				tableCell.setAttribute('id', tableId+'-print-'+i+'-'+j);
				//tableCell.appendChild(inputs);
				tableRow.appendChild(tableCell);
				
			}
			this.table.appendChild(tableRow);
		}
		
		
		
		
		this.targetElement.appendChild(this.table);
		//alert(this.threeDiArray);
	
	};

	this.removeTable=function(){};
	
	this.setClass=function(className){
		
		this.table.setAttribute('class',className);
		
	};
	this.appendSumTable=function(){
		
		var sumTable=document.createElement('table');
		sumTable.setAttribute('border','1');
		sumTable.setAttribute('style','max-height:150px');
		sumTable.setAttribute('class', 'datatable-sum');
		sumTable.setAttribute('width', '400px');
		sumTable.setAttribute('id',this.tableId+"-sum");
		
		sumTable.setAttribute('cellspacing','0');
		sumTable.setAttribute('cellpadding','0');
		var contentArray=['Number of Crates','Noted Weight','True weight','','Defect Grade','Defects','Payable Quantity'];
		var idArray=[["noCrates","notedWeight","trueWeight"],["defectGrade-sum","defects-sum","pq-sum"],["defectGrade-reduced","defects-reduced","pq-reduced"]];
	
		for (var i=0;i<7;i++){
			var row=document.createElement('tr');
			var j=0;
			while(j<3){
				if(j==0){
					var cell=document.createElement('td');
					var text=document.createTextNode(contentArray[i]);
					cell.appendChild(text);
					row.appendChild(cell);
					j++;
					}
				else if( j==1){
					if(i==0||i==1||i==2){
						var cell=document.createElement('td');
						cell.setAttribute('colspan',2);
						var inputs=document.createElement('p');
						inputs.setAttribute('id', this.tableId+'-print-sum-'+idArray[0][i]);
						cell.appendChild(inputs);
						row.appendChild(cell);
						j+=2;
					}else if(i==3){
						var cell=document.createElement('td');
						var text=document.createTextNode("Sum %");
						var pElement=document.createElement('p');
						pElement.setAttribute('align',"center");
						pElement.setAttribute('style',"font-weight:bold");
						pElement.appendChild(text);
						cell.appendChild(pElement);
						row.appendChild(cell);
						j++;
						
					}
					
					else{
						var cell=document.createElement('td');
						var inputs=document.createElement('p');
						inputs.setAttribute('id', this.tableId+'-print-sum-'+idArray[1][i-4]);
						cell.appendChild(inputs);
						row.appendChild(cell);
						j++;
						
					}
						
				}else{
					if(i==3){
						var cell=document.createElement('td');
						var text=document.createTextNode("Reduced %");
						var pElement=document.createElement('p');
						pElement.setAttribute('align',"center");
						pElement.setAttribute('style',"font-weight:bold");
						pElement.appendChild(text);
						cell.appendChild(pElement);
						row.appendChild(cell);
						j++;
						
					}
					else if(!(i==0||i==1||i==2||i==3)){
						var cell=document.createElement('td');
						var inputs=document.createElement('p');
						inputs.setAttribute('id', this.tableId+'-print-sum-'+idArray[2][i-4]);
						cell.appendChild(inputs);
						row.appendChild(cell);
						j++;
					}else{
						j++;
					}
				}
			}
			sumTable.appendChild(row);
		
		}
		
		this.targetElement.appendChild(sumTable);
		
		
		
	};
	
	
	
	}


	
	




