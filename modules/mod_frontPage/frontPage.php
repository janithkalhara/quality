<?php defined("HEXEC") or die("Restrited Access."); ?>
<script type="text/javascript" src="libraries/fancyboxv2/jquery.fancybox.js"></script>
<link rel="stylesheet" type="text/css" href="libraries/fancyboxv2/jquery.fancybox.css" media="screen" />
<link rel="stylesheet" type="text/css" href="modules/mod_frontPage/css/layout.css" />
<link rel="stylesheet" type="text/css" href="modules/mod_frontPage/css/style6.css" />
<script language="javascript" type="text/javascript" src="libraries/highcharts/js/highcharts.js"></script>
<script language="javascript" type="text/javascript" src="modules/mod_frontPage/js/script.js"></script>
<script type="text/javascript">
 $(document).ready( function(){ 
        var buttons = { previous:$('#lofslidecontent45 .lof-previous') ,
                        next:$('#lofslidecontent45 .lof-next') };
                        
        $obj = $('#lofslidecontent45').lofJSidernews( { interval : 8000,
                                                direction       : 'opacity',    
                                                easing          : 'easeInOutQuad',
                                                duration        :1200,
                                                auto            : false,
                                                navPosition          : 'horizontal', 
                                                mainWidth:980,
                                                buttons         : buttons} );   
        $("a[rel=image_group]").fancybox({
            'transitionIn'      : 'none',
            'transitionOut'     : 'none',
            'titlePosition'     : 'over',
            'titleFormat'       : function(title, currentArray, currentIndex, currentOpts) {
                return '<span id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
            }
        });
    });
</script>
<?php 
require_once 'modules/mod_graphWizard/graphWizard.php';
require_once 'modules/mod_graphWizard/class/dataAnalyzer.php';

$graph = new graphWizard();
//$graph->importLibrary();

$pie = new pieChart('hello', '<b>Today Stocks</b> - Station Wise','graph1');
$pie->renderGraph();
			
$supChart = new SuppplerWiseChart('<b>Today Total Stocks </b> - Supplier Wise','graph2');
$supChart->setSupplierArray();
$supChart->renderGraph();

$totalQchart = new totalQuantityChart('<b>Today stocks</b> - Total Defects Quantities', 'graph3');
$totalQchart->setDefectQuantities();
$totalQchart->renderChart();
 
$totalAQChart = new totalAQuantityGraph('Total Quantities Supplied By Suppliers (Actual)','graph4');
$totalAQChart->setAqDataV2();
$totalAQChart->renderGraph();

$totalSupplierSmallChart = new totalSumSmallFruitGraph('<b>Today stocks</b> - Total Small Fruit Defect Percentages','graph5');
$totalSupplierSmallChart->renderGraph();
?>	
<div id="container">
<div id="lofslidecontent45" class="lof-slidecontent" style="width:980px; height:400px;">
  <div class="lof-main-outer" style="width:980px; height:400px;">
    <div onclick="return false" href="" class="lof-previous">Previous</div>
    <ul class="lof-main-wapper">
        <li>
	        <div class="silder-graph" style="z-index: 200" id="graph1">&nbsp;</div>      
            <div class="lof-main-item-desc"></div>
        </li> 
       	<li>
          <div class="silder-graph" style="z-index: 200" id="graph2">&nbsp;</div>            
             <div class="lof-main-item-desc"></div>
        </li> 
       	<li>
          <div class="silder-graph" style="z-index: 200" id="graph3">&nbsp;</div>             
            <div class="lof-main-item-desc"></div>
      	</li> 
        <li>
        	<div class="silder-graph" style="z-index: 200" id ="graph4">&nbsp;</div>       
            <div class="lof-main-item-desc"></div>
        </li> 
	 	<li>
	    	<div class="silder-graph" style="z-index: 200" id ="graph5"></div>    
            <div class="lof-main-item-desc">
                 <img src="images/thumbl_980x340_005.png" title="Newsflash 5" style="display:none" >   
             </div>
        </li> 
      </ul>     
         	<div onclick="return false" href="" class="lof-next">Next</div>
  	</div>
</div>
</div>
<div class="fbg">
      <div class="col c1">
        <h2><span>Image Gallery</span></h2>
        <a href="images/gherkin/40099.JPG" id="image1" rel="image_group" ><img src="images/gherkin/40099.JPG" width="65" height="65" alt="pix" /></a>
        <a href="images/gherkin/150611 Gherkins.jpg" rel="image_group"><img src="images/gherkin/150611 Gherkins.jpg" rel="lightbox" width="65" height="65" alt="pix" /></a>
        <a href="images/gherkin/gherkin.jpeg" rel="image_group"><img src="images/gherkin/gherkin.jpeg" width="65"  rel="lightbox" height="65" alt="pix" /></a>
        <a href="images/gherkin/gherkins.jpg" rel="image_group"><img src="images/gherkin/gherkins.jpg" width="65"  rel="lightbox" height="65" alt="pix" /></a>
        <a href="images/gherkin/mexicansourgherkin.jpg" rel="image_group"><img src="images/gherkin/mexicansourgherkin.jpg"  rel="lightbox" width="65" height="65" alt="pix" /></a>
        <a href="images/gherkin/Gherkin_in_jar.jpg" rel="image_group"><img src="images/gherkin/Gherkin_in_jar.jpg" width="65" height="65" alt="pix" /></a>
      </div>
      <div class="col c2"><?php 
      require_once 'modules/mod_mainPanel/classes/season.php';
      $news=new news();
      $latest=$news->getLatestNewsItem();
      ?>
        <h2><span><?php print $latest['title']?></span></h2>
        <p><?php print $latest['text']?>
        </p>
      </div>
      <div class="col c3">
        <h2><span>About</span></h2>
        <img src="images/heading.jpg" width="56" height="56" alt="pix" />
        <p>Hayleys group, a Sri Lankan conglomerate started its export oriented agricultural project in 1988 to supply Gherkins preserved in Vinegar and Brine to Pickle Packers in Australia, Europe, Japan, New Zealand & USA.
		Sri Lanka is a tropical Island with two major growing seasons i.e. February to March and May to August. <a href="#">Read more...</a></p>
      </div>
      <div class="clr"></div>
    </div>
