function showImages(id){
	
	var array=jQuery.parseJSON(id);
	//var idArray=id.split('|');
	var project=array[0];
	var vehicleNo=array[1];
	var date=array[2];
	var d=date.split('-');
	var d_i=d[0]+d[1]+d[2];
	
	d_image=d_i.replace(/:/g,"");
	d_image2=d_image.replace(" ","");
	
	var vehicleNo2=vehicleNo.replace('-','');
	project2=project.replace('-','');
	//clear all
	
	$('#image1').html("");$('#imgDesc1').html("");
	$('#image2').html("");$('#imgDesc2').html("");
	$('#image3').html("");$('#imgDesc3').html("");
	var prefix=d_image2+project+vehicleNo2;
	
	$.post('modules/mod_stockViewer/ajax/imagehandler.php',{'vehicle':vehicleNo,'project':project,'date':date},function(d){
		var path='modules/mod_insertionData/ajax/uploads/';
		data=jQuery.parseJSON(d);
	
		if(data['image1']!=""){
		$('#image1').html("");$('#imgDesc1').html("");
			$('#image1').html("<a href='"+path+prefix+data['image1']+"' rel='stockImageGroup'  ><img src="+path+prefix+data['image1']+" class='img'></a>");
			$('#imgDesc1').html(data['image_desc1']);
		}
		if(data['image2']!=""){
		$('#image2').html("");
		$('#imgDesc2').html("");
			$('#image2').html("<a href='"+path+prefix+data['image2']+"' rel='stockImageGroup'  ><img src="+path+prefix+data['image2']+" class='img'></a>");
			$('#imgDesc2').html(data['image_desc2']);
		}
		if(data['image3']!=""){
		$('#image3').html("");$('#imgDesc3').html("");
		$('#image3').html("<a href='"+path+prefix+data['image3']+"' rel='stockImageGroup'  ><img src="+path+prefix+data['image3']+" class='img'></a>");
		$('#imgDesc3').html(data['image_desc3']);
		}
		$('#imageArea').show('blind',{},800);
	
		
});
		
	}
		
		
		