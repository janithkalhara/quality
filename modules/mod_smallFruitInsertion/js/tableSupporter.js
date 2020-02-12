$(document).ready(function(){
	$("#date-small").datepicker({dateFormat: 'yy-mm-dd'});
	$(document).on('keyup','.table-cell',function(e){
		var table = cell = 0;
		var id = $(this).prop('id').split('-');
		table = id[1];
		cell = id[3];
		var key = e.keyCode;
		if(key == 40) nextrow = $(this).closest('tr').next('tr').length > 0?$(this).closest('tr').nextAll('tr:visible:first'):$(this).closest('table').find('tr:first');
		else if(key == 38) nextrow = $(this).closest('tr').prev('tr').length > 0?$(this).closest('tr').prevAll('tr:visible:first'):$(this).closest('table').find('tr:last');
		else nextrow = $(this).closest('tr');
		var nextIds = nextrow.prop('id').split('-');
		if(cell == 0 && key == 37) cell = 12;
		else if(cell == 12  && key == 39) cell = 0;
		else if(key == 37 ) cell --
		else if(key == 39) cell ++
		$('#table-'+table+'-'+nextIds[2]+'-'+cell).focus();
	});
	
});

