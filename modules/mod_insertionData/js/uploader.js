$(function() {
	var uploader = new plupload.Uploader({
		runtimes : 'gears,html5,flash,silverlight,browserplus',
		test:'hello',
		browse_button : 'pickfiles',
		container : 'container-uploader',
		max_file_size : '10mb',
		resize : {width : 320, height : 240, quality : 90},
		url : 'modules/mod_insertionData/ajax/upload.php',
		flash_swf_url : '/plupload/js/plupload.flash.swf',
		silverlight_xap_url : '/plupload/js/plupload.silverlight.xap',
		filters : [
			{title : "Image files", extensions : "jpg,gif,png"},
			{title : "Zip files", extensions : "zip"}
		]
		
	});

	uploader.bind('Init', function(up, params) {
		$('#filelist').html("");
	});

	$('#submit-me').click(function(e) {
		uploader.start();
		e.preventDefault();
	

	});
	uploader.init();
	
$('#reset-button').click(function(){
		
		$('#filelist').html("");
		set();
	});

var k=0;
	
	function set() {
		k=0;
		$('#pickfiles').removeAttr('disabled');
	}

	uploader.bind('FilesAdded', function(up, files) {
		
		$.each(files, function(i, file) {
			
			$('#filelist').append(
				'<div id="' + file.id + '">' +
				file.name + ' (' + plupload.formatSize(file.size) + ') <b></b>' +
			'| <b>Description:<b> <input id="file-'+k+'" type="text"/><input id="file-nm-'+k+'"value="'+file.name+'" type="hidden"/></div>');
			var date=$('#date-toppane').val();
			var project=$('#project-hidden-toppane').val();
			var vehicle=$('#vehicle-toppane').val();
			var extension=file.name.substr(file.name.lastIndexOf('.')+1);
			
			file.name=date+project+vehicle+k+"."+extension;
			
			//file.name=date+"QQ"+project+"QQ"+vehicle+"QQ"+file.name;
			
			
			k++;
			if(k==3){
				
				$('#pickfiles').attr('disabled','disabled');
				
			}
		});

		up.refresh(); // Reposition Flash/Silverlight
	});

	uploader.bind('UploadProgress', function(up, file) {
		$('#' + file.id + " b").html(file.percent + "%");
	});

	uploader.bind('Error', function(up, err) {
		$('#filelist').append("<div>Error: " + err.code +
			", Message: " + err.message +
			(err.file ? ", File: " + err.file.name : "") +
			"</div>"
		);

		up.refresh(); // Reposition Flash/Silverlight
	});

	uploader.bind('FileUploaded', function(up, file) {
		$('#' + file.id + " b").html("100%");
		
		
	});

	
	
});