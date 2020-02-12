	<?php
	class EditHelper{
		protected $id;
		protected $date;
		protected $vehicleNo;
		private $db;
		protected $headers=array();
		protected $tms=array();
		protected $centerFakes=array();
		protected $gradeStocks=array();
		protected $project;
		protected $grades=array();
		protected $samples=array();
		
		public function __construct($id,$v,$d){
			
			$data=new stdClass();
			$data->id=$id;
			$data->v=$v;
			$data->d=$d;
			$_SESSION['data']=serialize($data);
			
			$this->id=$id;
			$this->date=$d;
			$this->vehicleNo=$v;
			$this->db=new HDatabase();
			$this->db->connect();
			$this->project=new Project();
		
		}
		public function initialize(){
			//loadinf headers 
			$this->loadHeaders();
			$this->loadTms();
			$this->loadGradeStocks();
			$this->loadGrades();
			$this->loadSamples();
		}
		private function loadGrades(){
			
			$from ='qa_area as a ,qa_grade as g ';
			$where="a.cate_id=g.cate_id AND a.areaId='{$this->id}'";
			$select="a.cate_id as cate_id,g.gradeId as grade, g.sampleWeight as sampleWeight, g.fruitCount as fc";
			$this->db->resetResult();
			$this->db->select($from,$select,$where);
			$grades=$this->db->getResult();
			if($grades){
				$this->grades['cate']=$grades[0]['cate_id'];
				/* can append needed data here */
				$this->grades['data']=$grades;
			}else{
				$this->grades=false;
			}
		}
		
		
		private function loadHeaders(){
			//setting header data.
			$this->db->resetResult();
			$where="id='".$this->id."' AND vehicleNo='".$this->vehicleNo."' AND date='".$this->date."'";
			$this->db->select("qa_stock","*",$where);
			$headers=$this->db->getResult();
			
			
			//activating headers 
			if($headers){
				//setting areaName 
				$area=$this->project->getProjectNameById($this->id);
				$headers[0]['areaId']=$area['areaName'];
				$this->headers=$headers[0];
			}else{
				throw new Exception("Cannot find the stock.", "399");
			}
			
		}
		
		public function activateAll(){
			?>
			<script type="text/javascript" src="modules/mod_insertionData/js/edit/mappings.js"></script>
			<script type="text/javascript">
				var headers=<?php print json_encode($this->headers)?>;
				var tms=<?php print json_encode($this->tms)?>;
				var centerFakes=<?php ($this->centerFakes)?print json_encode($this->centerFakes):print "false"?>;
				var gradeStocks=<?php (!empty($this->gradeStocks))?print json_encode($this->gradeStocks):print "false"?>;
				var samples=<?php (!empty($this->samples))?print json_encode($this->samples):print "false"?>;
				var grades=<?php ($this->grades)?print json_encode($this->grades):print false;?>;
				var gradeCate=grades.cate;
				var gradeIndexSuffix='-gradeId';
				var gradeSuffix='-grade';
				var gradeVals=grades.data;
				var fc;
				var tmTableSettled=false;
				var tmTableClicked=0;
				var finalCalc={};
				var checker = null;
				
				$('#selectGrade').val(gradeCate);
				//setting data to fields
				$(document).ready(function(){
					$('#date-toppane').val(headers.date);
					$('#project-toppane').val(headers.id);
					$('#project-toppane').select2('destroy');
					//$('#project-toppane').val(headers.areaId);
					$('#project-toppane').attr('disabled','disabled');
					$('#vehicle-toppane').val(headers.vehicleNo);
	
					$('input:radio[name="delivery"]').filter('[value="'+headers.handovering+'"]').attr('checked', true);
					$('input:radio[name="cover"]').filter('[value="'+headers.lorryCovering+'"]').attr('checked', true);
					$('input:radio[name="smell"]').filter('[value="'+headers.badSmell+'"]').attr('checked', true);
					$('input:radio[name="otherThings"]').filter('[value="'+headers.otherGoods+'"]').attr('checked', true);
					$('input:radio[name="colorcode"]').filter('[value="'+headers.labelling+'"]').attr('checked', true);
					$('input:radio[name="qualityReport"]').filter('[value="'+headers.qualityReports+'"]').attr('checked', true);
	
					//setting tm table data
	
					for(var i=0;i<tms.length;i++){
						$('#centerTable input#center'+i).val(tms[i].center);
						$('#centerTable input#tm'+i).val(tms[i].tmNo);
						$('#centerTable input#tm'+i).val(tms[i].tmNo);
						$('#centerTable input#gr-'+i+"-1").val(tms[i].grade1);
						$('#centerTable input#gr-'+i+"-2").val(tms[i].grade2);
						$('#centerTable input#gr-'+i+"-3").val(tms[i].grade3);
						$('#centerTable input#gr-'+i+"-4").val(tms[i].grade4);
						$('#centerTable input#gr-'+i+"-5").val(tms[i].grade5);
						}
					///setting base center table
					for(var i=0;i<6;i++){
						if(centerFakes[i]){
						$('#centerName input#centerName'+(i+1)).val(centerFakes[i].centerName);
						$('#centerName input#'+(i+1)+'-tmToppane').val(centerFakes[i].TMno);
							}
						}
					//setting tm table clicked flag
					$('div#tmTable-link').click(function(){
						if(tmTableClicked==0){
							
							tmTableClicked=1;
						}else{
							tmTableClicked=0;
							tmTableSettled=true;
							setDQFinals();
							
						}
						});
					
					
				//setting grade values :
				
					var tempGrade;
					//triggering blur function
					$('table#1-slot input').removeAttr('onblur');
					$('table#1-slot input').blur(function(){
							if($(this).val()!=0 || $(this).val()!=""){
								var id=$(this).attr('id');
								refixTable(id);
							}
						});
					///
					//init final calculations
					activateFinaleCalc(1);
					$('input#submit-me').removeAttr('onclick');
					$('input#submit-me').click(function(){
						sendData();
						});
					
					});
				//refixing the table
				function refixTable(id){
					var arr=id.toString().split("-")
					var table=arr[0];
					var row=arr[2];
					var col=arr[3];
					/* settting sum of */
					//1-slot-1-3
					var counter=0,target,sum=0;
					for(var i=0;i<13;i++){
						target="#"+table+"-slot-1-"+i;
						if($(target).val()!=0 && $(target).val()!=""){
								sum+=parseInt($(target).val());counter++;
							}
				
						}
					$('#'+table+'-slot-1-13').val(sum);
					var avgFc=Math.round(sum/counter);
					$('#'+table+'-avgFruitCount').val(avgFc);
					//setting sum
					
					for(var j=2;j<17;j++){
						sum=0;counter=0;
						for(var i=0;i<13;i++){
							target="#"+table+"-slot-"+j+"-"+i;
							if($(target).val()!="" && !isNaN($(target).val())){
									sum+=parseInt($(target).val());counter++;
								}
							}
						//setting sum
						(!isNaN(sum))?$('#'+table+'-slot-'+j+'-13').val(sum):$('#'+table+'-slot-'+j+'-13').val('');
						$('#'+table+'-slot-'+j+'-13').val(sum);
						var samplesCounter=counter;
						var divider=avgFc*samplesCounter*fc;
						var per=Math.round(sum/divider*10000)/100;
					
						if(per!=0){
							
							if(!isNaN(per)){
								$('#'+table+'-slot-'+j+'-14').val(per);
							}else{
								
								$('#'+table+'-slot-'+j+'-14').val('0');		
								
							}
						}
					}
					//changing table final calcs//1-slot-2-14
					var offGrade=0;
					var defects=0;
					for(var j=2;j<4;j++){
						offGrade+=parseFloat($('#'+table+'-slot-'+j+'-14').val());
						}
					$('#'+table+'-sum-defectGrade-sum').val(Math.round(offGrade*100)/100);
					if(offGrade > 10){
						offGrade = offGrade - 10;
						offGrade = Math.round(offGrade*100)/100;
						$('#'+table+'-sum-defectGrade-reduced').val(offGrade);
					}else{
						$('#'+table+'-sum-defectGrade-reduced').val(0);
						}
					for(var j=4;j<15;j++){
						defects+=parseFloat($('#'+table+'-slot-'+j+'-14').val());
						}
					$('#'+table+'-sum-defects-sum').val(Math.round(defects*100)/100);
					var reduces=parseFloat($('#'+table+'-slot-16-14').val());
					var reductionsDefect = reductions[table-1];
					if(defects > reductionsDefect){
						reduces+=Math.round((defects - reductionsDefect)*100)/100;
						}
					reduces = Math.round((reduces)*100)/100;
					$('#'+table+'-sum-defects-reduced').val(reduces);
					reduceTotal = reduces + offGrade;
					AQ = $('#'+table+"-sum-trueWeight").val();
					if(AQ != '' || AQ!=0){
						PQ = AQ - (AQ*reduceTotal/100);
						PQ = Math.round(PQ*100)/100;
						$('#'+table+'-sum-pq-sum').val(PQ);
					}


					
				}
				
				function setDQFinals(){
					//centerTable gr-0-1
					for(var i=0;i<4;i++){
						var val=0;
							for(var j=0;j<20;j++){
								tmp=$('#centerTable input#gr-'+j+'-'+(i+1)).val();
								val+=(!isNaN(parseFloat(tmp)))?parseFloat(tmp):0;
								
							}
							finalCalc['grade'+(i+1)]=val;
						}
					for(var i=0;i<4;i++){
						$('#'+(i+1)+'-sum-notedWeight').val(finalCalc['grade'+(i+1)]);
					}
				}
				
				function activateFinaleCalc(table){
					
						$('#'+table+'-sum-noCrates').removeAttr('onblur');
						$('#'+table+'-sum-noCrates').blur(function(){
							var dq=$('#'+table+'-sum-notedWeight').val();
							if( dq!='' ){
								$('#'+table+'-sum-notedWeight').val(finalCalc['grade'+table]);
							}else{
								alert('Please complete TM table data.\nIt seems you have to fill declared quantity in manual');
								}
							
							});
						
						$('#'+table+'-sum-trueWeight').blur(function(){
							var dq=$('#'+table+'-sum-notedWeight').val();
							var aq=parseFloat($(this).val());
							if( dq!='' || aq!='' ){
								var o=parseFloat($('#'+table+'-sum-defectGrade-reduced').val());
								var g=parseFloat($('#'+table+'-sum-defects-reduced').val());
								var totalR=o+g;
								var rest=aq-(aq*totalR/100);
								$('#'+table+'-sum-pq-sum').val(Math.round(rest*100)/100);
							}
							else{
								alert("You haven't fill declared quantity or actual quantity field(s) .\nPlease fill them correctly");
									
								}
							
							});
						
					}
				
				
				function count(obj){
	
					  var result = 0;
					  for(var prop in obj) {
					    if (obj.hasOwnProperty(prop)) {
					    // or Object.prototype.hasOwnProperty.call(obj, prop)
					      result++;
					    }
					  }
					  return result;
				}
				
				function loadStocks(eFlag){
	
					var key=parseInt(eFlag)-1;
					var temp=$('#'+eFlag+'-gradeId').val();
					temp=temp.trim();
					var tempArr=temp.split(":");
					var targetGrade=tempArr[0];
					fc=tempArr[1];
					
					var data=getDataByGrade(targetGrade);
					//displaying grade stock data
					var target,value;
					if(data){
						var stockData=data.value;
						for(var i=0;i<map.length;i++){
							target="#"+eFlag+map[i].key;
							$(target).val(stockData[map[i].value]);
							loadSamples(eFlag,targetGrade,fc,stockData);	
						}
					}
					//setting samples ;
					activateFinaleCalc(eFlag);
					$('table#'+eFlag+'-slot input').removeAttr('onblur');	
					$('table#'+eFlag+'-slot input').blur(function(){
						if($(this).val()!=0 || $(this).val()!=""){
							var id=$(this).attr('id');
							refixTable(id);
						}
					});
					
					setDQFinals();
					}
				function loadSamples(targetTable,grade,fruitCount,data){
	
					
					var samples=getSamplesByGrade(grade);
					var sampleCount=samples.length;
					var divider=fruitCount*sampleCount*data.averageFruitCount;
					var sample,target;
						for(var i=0;i<samples.length;i++){
							sample=getValue(samples,"sampleId",i);
							for(var j=0;j<mapSamples.length;j++){
								target='#'+targetTable+mapSamples[j].key+i;
								$(target).val(sample[mapSamples[j].value]);
							
								
								}
							
							}
					var sum,per,target;
					for(var k=0;k<percentMap.length;k++ ){
						sum=data[percentMap[k].value];
						per=Math.round((sum/divider)*10000)/100;
						target="#"+targetTable+percentMap[k].key;
						$(target).val(per)
						}
					}
	
				
				function getSamplesByGrade(g){
					var gradeSamples=[];
					for(var i=0;i<samples.length;i++){
	
							if(samples[i].gradeId==g){
								gradeSamples.push(samples[i]);
								}
						
						}
					return gradeSamples;
	
					}
				
				function getDataByGrade(g){
					for(var i=0;i<gradeStocks.length;i++){
						if(gradeStocks[i].key==g){
							return gradeStocks[i];
							}
						
						}
					return false;
	
					}
				function getValue(data,key,value){
					key=key.toString();
					for(var i=0;i<data.length;i++){
					
						if(data[i][key]==value){
							
							return data[i];
							}
						}
					return false;
					}
			</script>
	<script type="text/javascript" src="modules/mod_insertionData/js/edit/sender.js"></script>	
			<?php 
		
		}
		
		public function loadTms() {
			
			$this->db->resetResult();
			$where="id='".$this->id."' AND vehicleNo='".$this->vehicleNo."' AND date='".$this->date."'";
			$this->db->select("qa_centerQuantity","*",$where);
			$tms=$this->db->getResult();
			if($tms){
				$this->tms=$tms;
			}else{
				$this->tms=false;
			}
			/* loading center fakes */
			$this->db->resetResult();
			$this->db->select("qa_center_fakes","*",$where);
			$centerFakes=$this->db->getResult();
			if($centerFakes){
				$this->centerFakes=$centerFakes;
			}else{
				$this->centerFakes=false;
			}
			
			
		}
		
		
		public function loadGradeStocks(){
			
			$this->db->resetResult();
			$where="id='".$this->id."' AND vehicleNo='".$this->vehicleNo."' AND date='".$this->date."'";
			$this->db->select("qa_gradeStock","*",$where);
			$gradeStock=$this->db->getResult();
			$gradeStocks=array();
			
			if($gradeStock){
				$i=0;
				foreach ($gradeStock as $temp){
					
					$gradeStocks[$i]["key"]=$temp['gradeId'];
					$gradeStocks[$i]['value']=array_slice($temp, 5);
					$i++;
				}
				
			}else{
				$gradeStocks=false;
			}
		//setting object gradestocks 
			$this->gradeStocks=$gradeStocks;
		
		}
			
		function loadSamples(){
			$this->db->resetResult();
			$where="id='".$this->id."' AND vehicleNo='".$this->vehicleNo."' AND date='".$this->date."'";
			$orderBy="gradeId";
			$select="id,sampleId,gradeId,centerId,fruitCount,smallFruit,largeFruit,flyAttacked,peeledOff,boreAttacked,
					sandEmbedded,shrivelled,deformed,virusAttacked,mechanicalDamaged,yellowish,rustPatches,fruits45,accepted,spoiled";
			$this->db->select("qa_sample",$select,$where,$orderBy);
			$samples=$this->db->getResult();
			if($samples){
				foreach ($samples as $temp){
					$this->samples[]=$temp;
						
				}
			}else{
				return false;
			}
	
		}
		
		
		public function __destruct(){
			$this->activateAll();
			
		}
		
	}