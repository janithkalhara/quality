<?php 
ini_set('display_errors', 'Off');
define("HEXEC",1);
define("DS", DIRECTORY_SEPARATOR);
define('BASE_PATH', __DIR__);
require_once ('login/authenticater.php') ;
require_once 'includes'.DS.'call.php';
$user = new user();
$import = new Import();
$mainframe = new frameWork();
date_default_timezone_set('Asia/Kolkata');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="keywords" content="" />
<meta name="description" content="" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Quality Analysis System |<?php print  $_SESSION['SESS_FIRST_NAME']." ".$_SESSION['SESS_LAST_NAME'];?>
</title>
<link rel="ICON" href="images/favicon.png"/>
<link href="css/template.css" rel="stylesheet" type="text/css" media="screen" />
<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="screen" />
<link href="css/font-awesome.css" rel="stylesheet" type="text/css" media="screen" />

<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="libraries/jqueryCustomUI/css/custom-theme/jquery-ui-1.8.16.custom.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="libraries/jqueryCustomUI/js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="libraries/jqueryCustomUI/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/jsHelper.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('#date').datepicker();
	$('#feedback').click(function(){
		$('#feedbackform').toggle('blind',{},1000);
		});
	$(' #closefeedbackform').click(function(){
		$('#feedbackform').hide('blind',{},1000);
		});
});
</script>
</head>
<body>
	<div id="wrapper">
		<div id="header">
			<div id="logo">
			<h2 class="header">Quality Analysis System </h2><p class="slogan" >HJS Condiments LTD | Sunfrost (PVT) LTD</p>
			<?php
            $view;
            switch ($_SESSION['SESS_USERTYPE']) { 
                case "SuperAdministrator":
                    $view= "Super Administrator view";
                    break;
                case "SuperUser":
                    $view= "Super User view";
                    break;
                case "StationUser":
                    $view="StationUser view";
                    break;
                case "Supplier":
                    $view= "Supplier view";
                    break;
                default:;
            }
            ?>
			</div>
			<div id="userPanel">
			<?php include "modules/mod_userPanel/userPanel.php"; ?>
			</div>
		</div>
		<!-- end #header -->
		<?php  if($view == "StationUser view") { ?>
		<ul id="nav" style="z-index: 10000">
			<li class="current"><a href="home.php">Home</a></li>
			<li style="z-index: 10000"><a href="#">Data Insertion</a>
				<ul>
					<li><a href="home.php?option=mod_insertionData">Data Insertion(L/M)</a></li>
					<li><a href="home.php?option=mod_smallFruitInsertion">Data Insertion(Small)</a></li>
				</ul>
			</li>
			<li style="z-index: 10000"><a href="">Views </a>
				<ul>
					<li><a href="home.php?option=mod_stockViewer">View Quality Reports(L/M)</a></li>
					<li><a href="home.php?option=mod_smallFruitStockViewer">View Quality Reports(Small)</a></li>
					<li><a href="home.php?option=mod_supplierProfile">Supplier Profile</a></li>
					<li><a href="home.php?option=mod_stockByDate">Stock By Date(Large)</a></li>
					<li><a href="home.php?option=mod_stockByDateSmall">Stock By Date(Small)</a></li>
					<li><a href="home.php?option=mod_totalQuantityProject">Total Quantity(Project)</a></li>
					<li><a href="home.php?option=mod_invoiceGenerator">Generate Invoice </a></li>
					<li><a href="home.php?option=mod_crateViewer">No of Crates By Date </a></li>
					<li><a href="home.php?option=mod_tmTableViewer">View TM table </a></li>
					<li><a href="home.php?option=mod_totalStockViewer">Total Stocks</a></li>
				</ul>
			</li>

			<li style="z-index: 10000"><a href="home.php?option=mod_patternGenerator">Arrival Pattern</a></li>	
			<li style="z-index: 10000"><a href="home.php?option=mod_userViewPanel">Existing Users</a></li>
			<li style="z-index: 10000"><a href="#">Help</a>
				<ul>
					<li><a href="home.php?option=mod_help">Help</a></li>
					<li><a href="#" id="feedback" >Feedback</a></li>
				</ul>	
			</li>
		</ul>
		<?php }else{ ?>
		<ul id="nav" style="z-index: 10000">
			<li class="current"><a href="home.php">Home</a></li>
			<?php if($view == "Super Administrator view"){ ?>
			<li style="z-index: 10000"><a href="#">Data Insertion</a>
				<ul>
					<li><a href="home.php?option=mod_insertionData">Data Insertion(L/M)</a></li>
					<li><a href="home.php?option=mod_smallFruitInsertion">Data Insertion(Small)</a></li>
					<li><a href="home.php?option=mod_patternGenerator">Pattern Data Insertion</a></li>
					<li><a href="home.php?option=mod_backup">Prepare backups</a></li>
		            <li><a href="home.php?option=mod_logViewer">View Logs</a></li>
				</ul>
			</li>
			<?php } ?>
			<li style="z-index: 10000"><a href="">Views </a>
				<ul>
					<li><a href="home.php?option=mod_stockViewer">View Quality Reports(L/M)</a></li>
					<li><a href="home.php?option=mod_smallFruitStockViewer">View Quality Reports(Small)</a></li>
					<li><a href="home.php?option=mod_supplierProfile">Supplier Profile</a></li>
					<li><a href="home.php?option=mod_stockByDate">Stock By Date(Large)</a></li>
					<li><a href="home.php?option=mod_stockByDateSmall">Stock By Date(Small)</a></li>
					<li><a href="home.php?option=mod_totalQuantityProject">Total Quantity(Project)</a></li>			
					<li><a href="home.php?option=mod_invoiceGenerator">Generate Invoice </a></li>
					<li><a href="home.php?option=mod_crateViewer">No of Crates By Date </a></li>
					<li><a href="home.php?option=mod_tmTableViewer">View TM table </a></li>
					<li><a href="home.php?option=mod_totalStockViewer">Total Stocks</a></li>
				</ul>
			</li>	
			<li style="z-index: 10000"><a href="home.php?option=mod_userViewPanel">Existing Users</a></li>
			<li><a href="#">Arrival Patterns</a>
				 <ul>
				     <li><a href="home.php?option=mod_arrivalPatterns&section=view">View Arrival Patterns</a></li>
				     <li><a href="home.php?option=mod_arrivalPatterns&section=tentativeReport">View Tentative Reports</a></li>
				      <li><a href="home.php?option=mod_arrivalPatterns&section=forecastPattern">View Forecasted Reports</a></li>
				      <li><a href="home.php?option=mod_arrivalPatterns&section=forecastPatterntotal">Forecasted Total Report</a></li>
				 </ul>
		    </li>
			<li style="z-index: 10000"><a href="#">About</a>
				<ul>
					<li style="z-index: 10000"><a href="home.php?option=mod_contact">Contact Us</a></li>	
					<li style="z-index: 10000"><a href="home.php?option=mod_help&app=pdf">System documentation</a></li>
				</ul>
			</li>
			<li style="z-index: 10000"><a href="home.php?option=mod_help">Help</a></li>
			<li  style="z-index: 10000"><a href="home.php?option=mod_mail">Feedback</a></li>
		</ul>
	<?php } ?>
	<div id="page" >
	    <p  id="highlight-error" style="display:none"></p>
		<?php 
	   	if(isset($_GET['option'])){
	        $option = $_GET['option'];
	        $optionArray = explode("_", $option);          
	        $type = $optionArray[0];
	        $content = $optionArray[1];
	        
	        includePage($type,$content);    
	        
	    }
	    else{
	        if($view == "Super Administrator view" ){
	        include 'modules/mod_mainPanel/mainPanel.php';
	        include 'modules/mod_frontPage/frontPage.php';
	        
	        }else if($view == "StationUser view"){
				include 'modules/mod_mainPanel/mainPanel.php';
	        	include 'modules/mod_frontPage/frontPage.php';
	            
	        }else if($view == "Supplier view"){
	        	include 'modules/mod_frontPage/frontPage.php';
	            
	        }
	        else if($view == "Super User view"){
	        	include 'modules/mod_frontPage/frontPage.php';
	            
	        }
	    }
	
	    function includePage($type,$content){
	        if($type=="mod" ){
	            include_once 'modules/mod_'.$content.'/'.$content.'.php';
	        }   
	        if($type=="inc"){
	            include_once 'inc/inc_'.$content.'/'.$content.'.php';
	        }
	    }
	    
	    if(isset($_POST['task'])){
			$task = $_POST['task'];
			$container = $_POST;
			$taskHandler = new taskHandler();
			$user = new user();
			$userId = $user->getUserId();
			array_push($container,'user',$userId);
			$taskHandler->setTask($task,$container);
			echo $taskHandler->respond();
		}
	    ?>
		<div id="waiting-div"><img src="images/pleasewait.gif"/><p align='center'>Please Wait!</p></div>
	</div>
	</div>
	<div id="footer-wrapper">
		<div id="footer">
			<p>
				Copyright (c) 2011 Management Information System |  All rights reserved. A Solution of  <a
					href="http://www.dforz.net/"> www.dforz.net </a>
			</p>
		</div>
	</div>
</body>
</html>
