<title><?php echo $__page->title; ?></title>
<link rel="icon" href="<?php echo APP_CDN.'/images/favicon.ico'; ?>"/>
<link href="<?php echo APP_CDN; ?>/css/bootstrap.css" rel="stylesheet" type="text/css">
<link href="<?php echo APP_CDN; ?>/css/bootstrap-responsive.css" rel="stylesheet" type="text/css">
<link href="<?php echo APP_CDN; ?>/css/font-awesome.css" rel="stylesheet" type="text/css">

<script type="text/javascript" src="<?php echo APP_CDN.'/js/jquery-1.10.2.js'?>"></script>
<script type="text/javascript" src="<?php echo APP_CDN.'/js/bootstrap.js'?>"></script>

<?php foreach($__page->assets as $asset) { 
		@list($type, $asset_section,$place) = $asset;
		if($place == 'HEAD') { 
			if($type == 'STYLE') {
				echo '<link rel="stylesheet" type="text/css" href="'.$asset_section.'">';
			
			}
			else if($type == 'SCRIPT') {
				echo '<script type="text/javascript" src="'.$asset_section.'" ></script>';
			}
		}
	}
?>