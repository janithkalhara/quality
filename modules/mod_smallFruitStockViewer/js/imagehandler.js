function showImages(id){
	
	var ids = jQuery.parseJSON(id);
	var project = ids[0];
	var vehicleNo = ids[1];
	var date = ids[2];
	var path = 'modules/mod_smallFruitInsertion/ajax/uploads/';
	var result;
	 $('#waiting-div').show();
	$.ajax({
		url:"modules/mod_smallFruitStockViewer/ajax/imagehandler.php",
		type:'post',
		dataType:"html",
		data:{'vehicle':vehicleNo,'project':project,'date':date},
		async:false,
		success:function(d){
			if(d.success == true){
				$('#waiting-div').hide();
				$('#image1').html("");$('#image2').html("");$('#image3').html("");
				$('#imgDesc1').html("");
				$('#imgDesc2').html("");
				$('#imgDesc3').html("");
				for(var i=0;i<result.length;i++){
					var imageReal=result[i]['image'].replace('-','');
					$('#image'+(i+1)).html("<a href='"+path+imageReal+"' rel='stockImageGroup'  ><img src="+path+imageReal+" class='img'></a>");
					$('#imgDesc'+(i+1)).html(result[i]['desc']);
				}
				$('#imageArea').show('blind',{},800);
			}else{
				$('#waiting-div').hide();
				alert("This stock does not contain any images");
			}
		}
	
	});
	
}