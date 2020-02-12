function tableWizard() {
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
		
		this.table.setAttribute('border','0');
		this.table.setAttribute('class','datatable');
		this.table.setAttribute('cellpadding',0);
		this.table.setAttribute('cellspacing',0);
		this.table.setAttribute('id',tableId+'-slot');
		var firstRow=document.createElement('tr');
		var k=0; 
	
		while(k<cols){
			var firstRowCells=document.createElement('td');
			if(k==0){
				firstRowCells.setAttribute('colspan',2);
				var text1=document.createTextNode('Grade');
				var pElement=document.createElement('p');
				pElement.setAttribute('align', 'right');
				 var hidd=document.createElement('input');
				 hidd.setAttribute('type', 'hidden');
				 hidd.setAttribute('id', this.tableId+'-gradeId');
				 
				 
				pElement.setAttribute('style', 'padding-right:5px');
				pElement.appendChild(text1);
				firstRowCells.appendChild(pElement);
				firstRowCells.appendChild(hidd);
				k+=2;
			}
			else if(k==2){
				firstRowCells.setAttribute('colspan',2);
				var content=document.createElement('input');
				
				content.setAttribute('id',this.tableId+'-grade');
				content.setAttribute('disabled','disabled');
				content.setAttribute('style','width:60px');
				firstRowCells.appendChild(content);
				k+=2;
				
			}
			else if(k==4){
				var text1=document.createTextNode('Worksheet '+this.tableId);
				var pElement=document.createElement('p');
				pElement.setAttribute('style','padding:1px;color:#333;font-weight:bold;font-size:10px;-moz-border-radius:4px;-webkit-border-radius:4px;border-radius:4px;width:80px;margin-top:2px');				
				pElement.appendChild(text1);	
				firstRowCells.appendChild(pElement);
				firstRowCells.setAttribute('colspan',2);
				firstRowCells.setAttribute('style','background:#fff;width:100px');
				k+=2;
				
				
			}
			else if(k==6){
				firstRowCells.setAttribute('colspan',4);
				var content=document.createTextNode('  Accepted Fruit Count');
				var pElement=document.createElement('p');
				pElement.appendChild(content);
				pElement.setAttribute('align', 'right');
				pElement.setAttribute('style', 'padding-right:5px;');
				firstRowCells.appendChild(pElement);
				k+=4;
				
			}
			else if(k==10){
				firstRowCells.setAttribute('colspan',3);
				var content=document.createElement('input');
				content.setAttribute('style','width:50px');
				content.setAttribute('id',this.tableId+'-avgFruitCount');
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
				var inputs=document.createElement('input');
				inputs.setAttribute('id', tableId+'-slot-'+i+'-'+j);
				if(i>0){
					if(j<13){
					inputs.setAttribute('onblur',"addToSum(this.id,this.value)");
					}
					else {
					inputs.setAttribute('disabled',"disabled");
					}
				}
				inputs.setAttribute('onkeyup',"goThere(event,this.id)");
				tableCell.appendChild(inputs);
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
		sumTable.setAttribute('border','0');
		sumTable.setAttribute('cellpadding','2');
		sumTable.setAttribute('cellspacing','1');
		sumTable.setAttribute('class', 'datatable-sum');
		sumTable.setAttribute('id',this.tableId+"-sum");
		var contentArray=['Number of Crates','Declared Quantity','Actual Quantity','','Off Grade','Defects','Payable Quantity','Direct Rejected Quantity'];
		var idArray=[["noCrates","notedWeight","trueWeight"],["defectGrade-sum","defects-sum","pq-sum"],["defectGrade-reduced","defects-reduced","pq-reduced"]];
	
		for (var i=0;i<8;i++){
			var row=document.createElement('tr');
			var j=0;
			while(j<3){
				if(j==0){
					var cell=document.createElement('td');
					var text=document.createTextNode(contentArray[i]);
					cell.appendChild(text);
					cell.setAttribute('class',"highlight-insertion");
					row.appendChild(cell);
					j++;
					}
				else if( j==1){
					if(i==0||i==1||i==2){
						var cell=document.createElement('td');
						cell.setAttribute('colspan',2);
						var inputs=document.createElement('input');
						inputs.setAttribute('onkeyup','goUpper(event,this.id)'); 
						inputs.setAttribute('onblur','findPayable(this.id,this.value)'); 
						inputs.setAttribute('id', this.tableId+'-sum-'+idArray[0][i]);
						cell.appendChild(inputs);
						row.appendChild(cell);
						j+=2;
					}else if(i==3){
						var cell=document.createElement('td');
						var text=document.createTextNode("Sum %");
						var pElement=document.createElement('p');
						pElement.setAttribute('align',"center");
						pElement.setAttribute('class',"highlight-insertion");
						pElement.setAttribute('style',"font-weight:bold; padding-bottom:-5px");
						pElement.appendChild(text);
						cell.appendChild(pElement);
						row.appendChild(cell);
						j++;
						
					}else if(i==7){
						var cell=document.createElement('td');
						var inputs=document.createElement('input');
												
						inputs.setAttribute('id', this.tableId+'-no-of-bags');
						inputs.setAttribute('placeholder','No of bags');
						cell.appendChild(inputs);
						row.appendChild(cell);
						j++;
					}					
					else{
						var cell=document.createElement('td');
						var inputs=document.createElement('input');
						
						inputs.setAttribute('disabled','disabled');
						inputs.setAttribute('id', this.tableId+'-sum-'+idArray[1][i-4]);
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
						pElement.setAttribute('class',"highlight-insertion");
						pElement.setAttribute('style',"font-weight:bold");
						pElement.appendChild(text);
						cell.appendChild(pElement);
						row.appendChild(cell);
						j++;
						
					}
					else if(!(i==0||i==1||i==2||i==3||i==6||i==7)){
						var cell=document.createElement('td');
						var inputs=document.createElement('input');
						
						inputs.setAttribute('disabled','disabled');
						inputs.setAttribute('id', this.tableId+'-sum-'+idArray[2][i-4]);
						cell.appendChild(inputs);
						row.appendChild(cell);
						j++;
					}else if(i==7){
						var cell=document.createElement('td');
						var inputs=document.createElement('input');
												
						inputs.setAttribute('id', this.tableId+'-no-of-kilos');
						inputs.setAttribute('placeholder','Kilograms');
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

function goThere(e,id){
	
		var key=e.keyCode;
		//1-slot-15-0
		var ids=id.split("-");
		var table=ids[0];
		var intable=ids[1];
		var row=ids[2];
		var cell=ids[3];
		if(key==37||key==38||key==39||key==40){
		
			if(cell==12){
				switch (key) {
						case 40:
						$('#'+table+"-"+intable+"-"+row+"-"+cell).focus();
						break;
                        
						case 39:
						row++;
						$('#'+table+"-"+intable+"-"+row+"-"+0).focus();
						break;
                        
                        case 38:
						//row--;
						$('#'+table+"-"+intable+"-"+row+"-"+cell).focus();
						break;
				        
                        case 37:
						
						$('#'+table+"-"+intable+"-"+row+"-"+cell).focus();
						break;
			
				}
			}
			if(row<16){
				if(cell!=12||cell!=0){
					
					switch (key) {
					case 39:
						cell++;

						$('#'+table+"-"+intable+"-"+row+"-"+cell).focus();
						break;
					case 37:
						cell--;
						$('#'+table+"-"+intable+"-"+row+"-"+cell).focus();
						break;
					case 38:
						row--;
						$('#'+table+"-"+intable+"-"+row+"-"+cell).focus();
						break;
					case 40:
						row++;
						$('#'+table+"-"+intable+"-"+row+"-"+cell).focus();
						break;
					default:
						break;
					}
				}
				else if(cell==12){
					
					$('#'+table+"-"+intable+"-"+0+"-"+0).focus();
					alert('xcvgdsf');
				}
			}
			
			else if(row=16){
				if(cell==12){
					switch (key) {
					case 39: 
						$('#'+table+'-sum-noCrates').focus();
						break;
					case 40: 
						$('#'+table+'-sum-noCrates').focus();
						break;
					case 37: 
						cell--;
						$('#'+table+"-"+intable+"-"+row+"-"+cell).focus();
						break;
					case 38: 
						row--;
						$('#'+table+"-"+intable+"-"+row+"-"+cell).focus();
						break;
					default:
						break;
					}
				}
				
				else{
					switch (key) {
						
						case 40:
							cell++;	
							row=1;
							$('#'+table+"-"+intable+"-"+row+"-"+cell).focus();
							break;
						case 38:
							row--;
							$('#'+table+"-"+intable+"-"+row+"-"+cell).focus();
							break;
						case 37:
							cell--;
							$('#'+table+"-"+intable+"-"+row+"-"+cell).focus();
							break;
						case 39:
							cell++;
							$('#'+table+"-"+intable+"-"+row+"-"+cell).focus();
							break;
						default:
						break;
					}
				}
			}
		}
	}
		
function goUpper(e,id){
	
	var key=e.keyCode;
	//1-sum-notedWeight
	var ids=id.split("-");
	var table=ids[0];
	var intable=ids[1];
	var idk=ids[2];
	
	if(idk=="noCrates"){
		if(key==38){
			
			$('#1-slot-16-0').focus();
		}else if(key==40){
			$('#'+table+'-'+intable+'-notedWeight').focus();
			
		}
		
	}
	else if(idk=="notedWeight"){
		if(key==38){
			$('#'+table+'-'+intable+'-noCrates').focus();
		}else if(key==40){
			$('#'+table+'-'+intable+'-trueWeight').focus();
			
		}
		
	}else if(idk=="trueWeight"){
		if(key==38){
			$('#'+table+'-'+intable+'-notedWeight').focus();
		}else if(key==40){
			
		}
		
	}
	
}	