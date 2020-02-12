
$(function() {
	var uploader = new plupload.Uploader({
		runtimes : 'gears,html5,flash,silverlight,browserplus',
		browse_button : 'pickfiles',
		container : 'container-uploader',
		max_file_size : '10mb',
		url : 'modules/mod_smallFruitInsertion/ajax/upload.php',
		flash_swf_url : '/plupload/js/plupload.flash.swf',
		silverlight_xap_url : '/plupload/js/plupload.silverlight.xap',
		filters : [
			{title : "Image files", extensions : "jpg,gif,png"},
			{title : "Zip files", extensions : "zip"}
		],
		resize : {width : 748, height : 460, quality : 100}
	});

	uploader.bind('Init', function(up, params) {
		$('#filelist').html("");
	});

	$('#submitMe').click(function(e) {
		$('#waiting-div').show();
		uploader.start();
		$('#waiting-div').hide();
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
var images=Array();
	uploader.bind('FilesAdded', function(up, files) {
		
		$.each(files, function(i, file) {
			
			$('#filelist').append(
				'<div id="' + file.id + '">' +
				file.name + ' (' + plupload.formatSize(file.size) + ') <b></b>' +
			'| <b>Description:<b> <input id="file-'+k+'" type="text"/><input id="file-nm-'+k+'"value="'+file.name+'" type="hidden"/></div>');
			var date=$('#date-toppane').val();
			var project=$('#project-toppane').val();
			var vehicle=$('#vehicleNo-toppane').val();
			
			//var v=vehicle.replace('-',"");
			//var v1=v.replace(/ /g,"");
			
			var extension=file.name.substr(file.name.lastIndexOf('.')+1);
			file.name=date+project+vehicle+k+"."+extension;
			images[k]=file.name;
			
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
	var str='';
	var k=0;
	uploader.bind('FileUploaded', function(up, file) {
		
		$('#' + file.id + " b").html("100%");
		//str.=file."Uploaded";
		
	});

	
	
});
