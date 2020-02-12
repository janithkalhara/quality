<?php
define("MOD_SOURCE", "modules/");
define("LIB_SOURCE", "libraries/base/");

class Import{
	private $source;
	private $type;
	private $targetDir;
    
	public function Import(){
		
	}
	public function importMe($source){
    	$this->source=$source;
 	    $splitted=explode("_", $source);
        if($splitted[0]=="mod"){
        	
        	$this->type="module";
        } 	
 	  $this->targetDir=$splitted[1];
    }
	
	public function importLib($lib){
		
		require_once LIB_SOURCE."/".$lib."/lib_".$lib.".php";
		
				
	}
	public function  importClass($base,$className){
		
		require_once 'modules/mod_'.$base."/class/".$className.".php";
	}
	
	public function importCSS($base,$css){
		
		print "<link href='modules/mod_".$base."/css/".$css.".css' type='text/css' rel='stylesheet'/>";
		
	}
	public function importJS($base,$js){
		
		print "<script type='text/javascript' src='modules/mod_".$base."/js/".$js.".js'></script>";
	}
	
	
}

/*
 * <?php 
global $import;
$import->importCSS('patternGenerator','patternGenerator');
?>

 * 
 * 
 * */


?>