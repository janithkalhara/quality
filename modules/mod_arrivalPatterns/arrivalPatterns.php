<?php 
defined("HEXEC") or die("Restrited Access.");
global $import;
$import->importCSS('arrivalPatterns','style');
if(isset($_GET['section'])){
    
	$section = $_GET['section'];
    if($section == "view"){
    	include "modules/mod_arrivalPatterns/includes/patternViewer.php";
    }

    if($section == "tentativeReport"){
        include "modules/mod_arrivalPatterns/includes/tentativeReport.php";
    }

    if($section == "forecastPattern"){
        include "modules/mod_arrivalPatterns/includes/forecastPatternBig.php";
    }
    
    if($section=="forecastPatterntotal"){
        include "modules/mod_arrivalPatterns/includes/forecastPatternTotal.php";
    }
}