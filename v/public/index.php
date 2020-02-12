<?php
date_default_timezone_set('Asia/Kolkata');
define("DS",DIRECTORY_SEPARATOR);
define("ROOT", dirname((dirname(__FILE__))));
$url = (isset($_GET['url'])) ? $_GET['url'] : null;
require_once ROOT.DS.'lib'.DS."bootstrap.php";

