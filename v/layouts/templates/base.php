<!DOCTYPE HTML>
<html>
<?php include_once '../layouts/templates/head.php'; ?>
<body>
<?php include_once '../layouts/templates/header.php'; ?>
<div class="content">
<?php
	foreach ($__page->sections as $page_section) {
		include_once $page_section;
	}
?>
<?php include_once '../layouts/templates/footer.php'; ?>
<div id="modal-window" class="modal fade"></div>
</div>
</body>
</html>