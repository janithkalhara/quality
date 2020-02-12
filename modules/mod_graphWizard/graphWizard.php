<?php 
defined("HEXEC") or die("Restrited Access.");
?>
<?php
require_once 'includes/Logger.php';
require_once 'modules/mod_graphWizard/class/dataAnalyzer.php';
require_once 'modules/mod_graphWizard/helper/helper.php';
require_once 'libraries/base/user/lib_user.php';
global $import;
$import->importLib("project");
$import->importLib("season");

class graphWizard{
	
	private $type;
	private $title;
	private $name;
	
	public function graphWizard(){}
	
	public function renderGraph(){}
	
	public function importLibrary(){
        print "<script  type='text/javascript' src='libraries/highcharts/js/highcharts.js'></script>";
	}
}

class pieChart extends graphWizard{
	private $type="pie";
	private $stations=array('HJS','Alawwa',"Padiyathalawa");
	private $stationsId=array(1,2,3);
	private $percentages=array();
	public  $stationQuantities=array();
	private $date;
	private $renderTo;
	private $totalstocks;
	
	public function pieChart($name,$title,$renderTo){
		$this->name = $name;
		$this->title = $title;
		$this->renderTo = $renderTo;
		$d= mktime(0, 0, 0, date("m"), date("d")-1, date("y"));
		$this->date = date("Y-m-d", $d); 
		$t = new TotalStockAnalyzer();

		if($t->getStocks()) {
			$this->totalstocks = $t->getStocks();
		}
		else {
			return false;
		}
	}
	
	public function checkStocks() {
		$ret = false;
		foreach ($this->totalstocks as $temp) {
			if($temp['dq'] != 0 || $temp['aq'] != 0 || $temp['pq'] != 0){
				$ret = true;
			}
		}
		return $ret;
	}
	
	public function renderGraph() {
		
		if($this->checkStocks()) { ?>
		<script type="text/javascript">
            var chart;
            $(document).ready(function() {
                chart = new Highcharts.Chart({
                    chart: {
                        renderTo: '<?php echo $this->renderTo?>',
                        events:{load:function(ev){$(document).resize();}},
                        plotBackgroundColor: null,
                        plotBorderWidth: null,
                        plotShadow: false
                    },
                    title: {
                        text: '<?php echo $this->title?>'
                    },
                    tooltip: {
                        formatter: function() {
                            var report='<b>'+ this.point.dq +'</b>: '+ this.point.dq_value +' kg'+ '<br/>' +
                            '<b>'+ this.point.aq +'</b>: '+ this.point.y+' kg'+'<br/>' +'<b>'+ this.point.pq +'</b>: '+ this.point.pq_value+' kg';
                            return report;
                        }
                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: true
                            },
                            showInLegend: true
                        }
                    },
                    series: [{
                        type: '<?php echo  $this->type?>',
                        name: 'Collecting Stations',
                        
                        data: [
                            {
                            	name: '<?php echo $this->stations[0]?>',
                            	dq:"<?php echo "Declared Quantity"?>",
                                dq_value:<?php if(isset($this->totalstocks[1]['dq']))echo $this->totalstocks[1]['dq'];else echo "0"?>,
                            	aq:"<?php echo "Actual Quantity"; ?>",
                                y: <?php if(isset($this->totalstocks[1]['aq']))echo $this->totalstocks[1]['aq'];else echo "0"?>,
                                pq:"<?php echo "Payable Quantity"?>",
                                pq_value:<?php if(isset($this->totalstocks[1]['pq'])) echo $this->totalstocks[1]['pq'] ;else echo "0"?>,
                                sliced: true,
                                selected: true
                            },
                            {
                                name: '<?php echo $this->stations[1]?>',
                                dq:"<?php echo "Declared Quantity"?>",
                                dq_value:<?php if(isset($this->totalstocks[2]['dq']))echo $this->totalstocks[2]['dq'];else echo "0"?>,
                                aq:"<?php echo "Actual Quantity"?>",
                                y:  <?php  if(isset($this->totalstocks[2]['aq']))echo $this->totalstocks[2]['aq'];else echo "0"?>,
                                pq:"<?php echo "Payable Quantity"?>",
                                pq_value:<?php if(isset($this->totalstocks[2]['pq'])) echo $this->totalstocks[2]['pq'] ;else echo "0"?>
                                
                            },
                            {
                                name: '<?php echo $this->stations[2]?>',
                                dq:"<?php echo "Declared Quantity"?>",
                                dq_value:<?php if(isset($this->totalstocks[3]['dq']))echo $this->totalstocks[3]['dq'];else echo "0"?>,
                                aq:"Actual Quantity",
                                y:<?php  if(isset($this->totalstocks[3]['aq']))echo $this->totalstocks[3]['aq'];else echo "0"?>,
                                dq:"<?php echo "Declared Quantity"?>",
                                dq_value:<?php if(isset($this->totalstocks[3]['dq']))echo $this->totalstocks[3]['dq'];else echo "0" ?>,
                                pq:"<?php echo "Payable Quantity"?>",
                                pq_value:<?php if(isset($this->totalstocks[3]['pq'])) echo $this->totalstocks[3]['pq'] ;else echo "0" ?>
                                
                            }
                            
                        ]
                    }]
                });
           	
            });
        </script>
		<?php 
		}
		else {
			echo "<script type='text/javascript'>";
			echo "$(document).ready(function(){";
			echo "$('#".$this->renderTo."').html(\"<p align='center' class='no-data-text'><b>Today Stocks</b> - Station Wise</p><p align='center' class='no-data-text sub'>No data to display</p>\")";
			echo "});";
			echo "</script >";
		}
	}
}
 
class SuppplerWiseChart extends  graphWizard{
	private $date;
	private $renderTo;
	private $name;
	private $suppliers;
	private $stocks;
	private $j_suppliers;
	private $j_dq=array();
	private $j_aq=array();
	private $j_pq=array();
	private $graph_min_value;
	
	public function SuppplerWiseChart($name,$renderTo){
		$this->name = $name;
		$this->renderTo = $renderTo;
		$d= mktime(0, 0, 0, date("m"), date("d")-1, date("y"));
                $this->date = date("Y-m-d", $d); 
		
	}
	
	public  function setSupplierArray(){
		$project = new Project();
		$suppliers = $this->getSuppliers();
		
		$user = new Huser();
		$supplierProjects = array();
		$suppliersStocks = array();
		foreach ($suppliers as $temp){
			array_push($supplierProjects,$project->getProjectBySupplier($temp['userId']));
		}
		
		for($i = 0;$i<count($supplierProjects);$i++){
			$suppliersStocks[$i]['DQ'] = 0;
			$suppliersStocks[$i]['AQ'] = 0;
			$suppliersStocks[$i]['PQ'] = 0;
			
			for($j=0;$j<count($supplierProjects[$i]);$j++){
				$area = $supplierProjects[$i][$j];
				$aqpqdq = $project->getAQPQDQByProjectNameAndDate($area['areaId'], $this->date);
				$suppliersStocks[$i]['DQ'] += $aqpqdq['DQ'];
                $suppliersStocks[$i]['AQ'] += $aqpqdq['AQ'];
                $suppliersStocks[$i]['PQ'] += $aqpqdq['PQ'];
			}
		}
		for($i=0;$i<count($suppliersStocks);$i++){
			$this->j_dq[$i] = $suppliersStocks[$i]['DQ'];
			$this->j_aq[$i] = $suppliersStocks[$i]['AQ'];
			$this->j_pq[$i] = $suppliersStocks[$i]['PQ'];
			$this->j_suppliers[$i] = $user->getNameById($suppliers[$i]['userId']);
		}
	}

	public function getNamesLMS(){
		$names = array();
		$user = new  Huser();
		$sups = $this->j_suppliers;
		
		if(isset($sups)){
			foreach ($sups as $temp){
				array_push($names,$user->getNameById($temp) );
			}
			return $names;
		}
		else{
			return false;
		}
	}
	
	public function getSuppliers(){
		$db = new HDatabase();
		$db->connect();
		$db->select("qa_area","DISTINCT userId");
		return $db->getResult();
	}
	
	public function getMinValue($a,$b,$c){
		$minArray = array();
		array_push($minArray, min($a));
		array_push($minArray, min($b));
	}

	public function renderGraph(){
		$rotation = count($this->j_suppliers)>5?-30:0;
		?>
		<script type="text/javascript">
            var chart;
            $(document).ready(function() {
                chart = new Highcharts.Chart({
                    chart: {
                        renderTo: '<?php print $this->renderTo ?>',
                        events:{load:function(ev){$(document).resize();}},
                        defaultSeriesType: 'column'
                    },
                    title: {
                        text: '<?php print $this->name;?>',
                        align: "center"
                        
                     
                    },
                    subtitle: {
                        text: ''
                    },
                    xAxis: {
                        
                        categories: [<?php print Helper::myImplodeToString($this->j_suppliers)?>],labels: {
                            rotation: <?php print $rotation;?>,
                            align: 'right',
                            style: {
                                 font: 'normal 10px Verdana, sans-serif'
                            }}
                    },
                    yAxis: {
                        
                        title: {
                            text: 'Quantity (kg)',
                            verticalAlign: 'top'
                                
                        }
                    },
                    legend: {
                        layout: 'horizontal',
                        backgroundColor: '#FFFFFF',
                        align: 'right',
                        verticalAlign: 'top',
                        x: 0,
                        y: 22,
                        floating: true,
                        shadow: true
                    },
                    tooltip: {
                        formatter: function() {
                            
                                var report = '<b>'+this.series.name +': </b>'+ this.y + 'kg<br/>' 
                                             ;
                                return report;
                        }
                    },
                    plotOptions: {
                        column: {
                            pointPadding: 0.2,
                            borderWidth: 0,
                            allowPointSelect: true,
                            cursor: 'pointer'
                        }
                    },
                         series: [{
                        name: 'Declared Quantity',
                        data: [<?php print implode(',', $this->j_dq)?>],
                        weightLoss:'Weight Loss',
                        f:'Rejection Percentage'
                    }, {
                        name: 'Actual Quantity',
                        data: [<?php print implode(',', $this->j_aq)?>],
                        e:'Weight Loss',
                        f:'Rejection Percentage'
                    }, {
                        name: 'Payable Quantity',
                        data: [<?php print implode(',', $this->j_pq)?>],
                       
                        e:'Weight Loss',
                        f:'Rejection Percentage'
                    }, ]
                });
            });
        </script>
		<?php 
	}
}

class totalQuantityChart{
	
	private $renderTo;
	private $date;
	private $name;
	private $j_suppliers;
	private $suppliers;
	private $stocks;
	
	private $j_offgrade = array();
	private $j_majordefects = array();
	private $j_minordefects = array();
	
	public function totalQuantityChart($name,$renderTo){
		$this->name = $name;
		$this->renderTo = $renderTo;
		$d = mktime(0, 0, 0, date("m"), date("d")-1, date("y"));
        $this->date = date("Y-m-d", $d);
	}
	
	public function setDefectQuantities(){
		$myAnalyser = new analyzer();
        $myAnalyser->setSupplierArray($this->date);
		$this->suppliers = $myAnalyser->getSuppliersLM();
		//$this->stocks=$myAnalyser->a;
		$this->stocks = $myAnalyser->stocks;
		$myAnalyser->getAveragedDefects();
		$defs = $myAnalyser->setSupplierArraysNew($this->date);
		$this->j_suppliers = Helper::myImplodeToString($this->suppliers);
        for($i=0;$i<count($this->stocks);$i++){
                array_push($this->j_offgrade,$defs[$i]['offGrade'] );
                array_push($this->j_majordefects,$defs[$i]['majorDefects'] );
                array_push($this->j_minordefects,$defs[$i]['minorDefects']);
        }
	}

	public function renderChart(){
		if(count($this->suppliers)>5)$rotation=-30;else $rotation=0;
		?>
		<script type="text/javascript">
        
            var chart;
            $(document).ready(function() {
                chart = new Highcharts.Chart({
                    chart: {
                        renderTo: '<?php print $this->renderTo?>',
                        events:{load:function(ev){$(document).resize();}},
                        defaultSeriesType: 'column'
                    },
                    title: {
                        text: '<?php print $this->name;?>'
                    },
                    subtitle: {
                        text: ''
                    },
                    xAxis: {
                        title: {
                            text: 'Supplier'
                        },
                        categories: [<?php print $this->j_suppliers?>],
                         labels: {
                            rotation: <?php print $rotation;?>,
                            align: 'right',
                            style: {
                                 font: 'normal 10px Verdana, sans-serif'
                            }
                            }
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'Quantity (%)'
                        }
                    },
                    legend: {
                        layout: 'horizontal',
                        backgroundColor: '#FFFFFF',
                        align: 'right',
                        verticalAlign: 'top',
                        x: 0,
                        y: 18,
                        floating: true,
                        shadow: true
                    },
                    tooltip: {
                        formatter: function() {
                            return ''+
                                '<b>'+this.series.name +':</b> '+ this.y +' %';
                        }
                    },
                    plotOptions: {
                        column: {
                            pointPadding: 0.2,
                            borderWidth: 0
                        }
                    },
                        series: [{
                        name: 'Off Grades',
                        data: [<?php print implode(',', $this->j_offgrade)?>]
                        
                    }, {
                        name: 'Major Deffects',
                        data: [<?php print implode(',', $this->j_majordefects)?>]
                
                    }, {
                        name: 'Minor Deffects',
                        data: [<?php print implode(',', $this->j_minordefects)?>]
                
                    }, ]
                });
            });
        </script>
		<?php 	
	}
}

class totalAQuantityGraph{
	private $j_suppliers;
	private $j_quantities;
	private $name;
	private $renderTo;
	private $myAnalyser;
	private $render;
	public function totalAQuantityGraph($name,$renderTo ){
		$this->name = $name;
		$this->renderTo = $renderTo;

	} 
	
	public function setAqDataV2(){
		$db = HDatabase::getInstance();
		$season = Season::getSeason();
		$fdate = $season['startDate'].' 00:00:00';
		$ldate = $season['endDate'].' 23:59:59';
		//getting l/m stock data
		$q = 'SELECT u.userId,u.fname,u.lname, s.id, SUM( s.quantity ) as sum
					FROM qa_user u
					INNER JOIN qa_area a ON u.userId = a.userId
					LEFT OUTER JOIN qa_stock s ON s.id = a.areaId
					WHERE a.cate_id <>5 AND s.date>"'.$fdate.'" AND s.date<"'.$ldate.'"
					AND a.season="'.$season['seasonId'].'" 
					GROUP BY u.userId, a.areaId
					';
		$db->query($q);
		$suppliers = $db->getResult();
		$render = array('names'=>array(),'values'=>array());
		foreach ($suppliers as $suppier){
			array_push($render['names'], $suppier['fname'].' '.$suppier['lname']);
			array_push($render['values'], floatval($suppier['sum']));
		}
		//getting small data
		$db->resetResult();
		$q = 'SELECT u.userId, SUM( s.total_AQ ) AS sum
				FROM qa_user u
				INNER JOIN qa_area a ON u.userId = a.userId
				INNER JOIN qa_small_crop s ON a.areaId = s.id
				WHERE a.cate_id =5 AND s.date>"'.$fdate.'" AND s.date<"'.$ldate.'"
				AND a.season="'.$season['seasonId'].'" 
				GROUP BY u.userId
				';
		$db->query($q);
		$smallSuppliers = $db->getResult();
		$user = null;
		foreach ($smallSuppliers as $sup){
			$user = Huser::get($sup['userId']);
			array_push($render['names'], $user->getName());
			array_push($render['values'], floatval($sup['sum']));
		}		
		$this->render = $render;

	}

	public function setAqData(){
		$date = date('Y-m-d');
		$this->myAnalyser = new analyzer();
		$season = $this->myAnalyser->getOngoingSeason($date);
		$this->myAnalyser->setSupplierArray($date);
        $this->myAnalyser->setTotalQuantity($date);
		$this->j_suppliers = $this->myAnalyser->getSuppliersLM();
		$smallSUppliers = $this->myAnalyser->getSmallSupplierFullName();
		$this->j_suppliers = array_merge($this->j_suppliers,$smallSUppliers);
		$this->j_quantities = $this->myAnalyser->supplierAqs;
		$smallStock = $this->myAnalyser->getSmallStockAQ($date);
		$this->j_quantities = array_merge($this->j_quantities,$smallStock);		
		$this->j_suppliers = Helper::myImplodeToString($this->j_suppliers);
	}

	public function renderGraph(){
		$rotation = count($this->render['names'])>5 ? -30: 0; 
		?>
		<script type="text/javascript">
            var chart;
            $(document).ready(function() {
                chart = new Highcharts.Chart({
                    chart: {
                        renderTo: '<?php print $this->renderTo?>',
                        defaultSeriesType: 'column'
                    },
                    title: {
                        text: '<?php print $this->name?>'
                    },
                    subtitle: {
                        text: ''
                    },
                    xAxis: {
                        title: {
                            text: 'Suppliers'
                        },
                        categories: <?php echo json_encode( $this->render['names']); ?>,
                        labels: {
                            rotation: <?php print $rotation;?>,
                            align: 'right',
                            style: {
                                 font: 'normal 10px Verdana, sans-serif'
                            }
                            }
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'Quantity (kg)'
                        }
                    },
                    legend: {
                        layout: 'horizontal',
                        backgroundColor: '#fff',
                        align: 'right',
                        verticalAlign: 'top',
                        x: 0,
                        y:18,
                        floating: true,
                        shadow: true
                    },
                    tooltip: {
                        formatter: function() {
                            return ''+
                                this.x +': '+ this.y +' kg';
                        }
                    },
                    plotOptions: {
                        column: {
                            pointPadding: 0.2,
                            borderWidth: 0
                        }
                    },
                        series: [
                                     {
                        name: 'Suppliers',
                        data: <?php echo json_encode($this->render['values']); ?>
                
                    }, ]
                });
            });
        </script>
		<?php 
	}
}

class totalSumSmallFruitGraph extends graphWizard{
	
	private $analyser;
	private $supplierStocks;
	private $name;
	private $suppliers;
	private $smallSuppliers;
	private $series;
	private $j_suppliers;
	public function totalSumSmallFruitGraph($name,$renderTo){
		$this->analyser = new analyzer();
		$this->renderTo = $renderTo;
		$this->name = $name;
		$this->setSupplierStocks();
		$this->setArrays();
	}

	public function setSupplierStocks(){
		$this->supplierStocks = $this->analyser->getStockSumsSmall();
	} 

	public function setArrays(){
		$this->suppliers = $this->analyser->getSmallSuppliersArray();
		for($i=0; $i<count($this->suppliers);$i++){
       	    $this->smallSuppliers[$i] = $this->suppliers[$i]['inchargeName'];
       }
		/* setting javascript competible array*/
       $this->j_suppliers = Helper::myImplodeToString($this->smallSuppliers);
       /* Setting series*/
       for($i=0;$i<count($this->supplierStocks);$i++){
       	    $this->series['11-14'][$i] = $this->supplierStocks[$i]['11-14'];
       	    $this->series['14-17'][$i] = $this->supplierStocks[$i]['14-17'];
       	    $this->series['17-29'][$i] = $this->supplierStocks[$i]['17-29'];
       	    $this->series['29-44'][$i] = $this->supplierStocks[$i]['29-44'];
       	    $this->series['CRS'][$i] = $this->supplierStocks[$i]['CRS'];
       }
       
	}
	
	public function renderGraph(){
		$rotation = count($this->suppliers)>5 ? -30 : 0;
		?>
		<script type="text/javascript">
            var chart;
            $(document).ready(function() {
                chart = new Highcharts.Chart({
                    chart: {
                        renderTo: '<?php print $this->renderTo;?>',
                        defaultSeriesType: 'column'
                    },
                
                    title: {
                        text: '<?php print $this->name;?>'
                    },
                    subtitle: {
                        text: ''
                    },
                    xAxis: {
                        categories: [<?php print $this->j_suppliers?>]
                    },
                    labels: {
                        rotation: <?php print $rotation;?>,
                                align: 'right',
                                style: {
                                     font: 'normal 10px Verdana, sans-serif'
                                }
                                }
                        ,
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'Percentages(%)'
                        }
                    },
                    legend: {
                        layout: 'horizontal',
                        backgroundColor: '#FFFFFF',
                        align: 'right',
                        verticalAlign: 'top',
                        x: 0,
                        y: 18,
                        floating: true,
                        shadow: true
                    },
                    tooltip: {
                        formatter: function() {
                            return ''+
                                '<b>Grade '+this.series.name +':</b> '+ this.y +'%';
                        }
                    },
                    plotOptions: {
                        column: {
                            pointPadding: 0.2,
                            borderWidth: 0,
                            point: {
                                events: {
                                    click: function() {
                                        alert(this.y);
                                    }
                                }
                        
                    }
                    }
                    
                    },
                        series: [{
                        name: '11-14',
                        data: [<?php print implode(',', $this->series['11-14'])?>]
                        
                
                    }, {
                        name: '14-17',
                        data: [<?php print implode(',', $this->series['14-17'])?>]
                
                    }, {
                        name: '17-29',
                        data: [<?php print implode(',', $this->series['17-29'])?>]
                
                    }, {
                        name: '29-44',
                        data: [<?php print implode(',', $this->series['29-44'])?>]
                
                    },
                    {
                        name: 'CRS',
                        data: [<?php print implode(',', $this->series['CRS'])?>]
                
                    }]
                });
            });
        </script>
		<?php 
	}
}
?>