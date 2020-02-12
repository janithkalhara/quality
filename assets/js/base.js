$(function(){
	$(document).on('click','.system-dialog', function(e){
		e.preventDefault();
		clickedElement=$(this);
		Helper.dialog($(this));
	})
	$(document).on('click','.confirm', function(e){
		e.preventDefault();
		Helper.confirm($(this));
	});
	
	
});
$(document).ajaxComplete(function(event, xhr, settings) {
	var code,status = 0;
	try { status = $.parseJSON(xhr.responseText) } catch(e) {}
	status = (status == 0) ? xhr.status : status;
	if(status!=0 && status!= null){
		var code = status.code != undefined ? status.code : 0;
		if(code!=0){
			var msg = status.message != undefined && status.message.length > 0 ? status.message : 'Your session has expired, please login'; 
			switch(code) {
				case 401:
					Helper.wait('off');
					Helper.msg("warning",msg+ '. redirecting&hellip;',3000);
					
					setTimeout(function(){
						window.location = status.path},3000);
				case 301:
					Helper.wait('off');
					Helper.msg("warning",msg+ '. redirecting&hellip;',3000);
					setTimeout(function(){window.location = status.path},3000);
				break;
			}
		}
	}
});
var Helper = {
		msg:function(type, message, callback){
			var elem=$('body').find('#pop-message');
			elem.find('.message-content').html('<div class="message '+type+'"> '+message+'</div><i class="fa fa-close"></i>');
			elem.fadeIn();
			setTimeout(function(){
				elem.fadeOut();
			},5000)
		},
		wait:function(status) {
			var elem = $('#waiting-div');
			if(status == 'on' ) { elem.fadeIn(); }
			if(status == 'off' ) { elem.fadeOut(); }
			
		},
		lockform:function(data, form, opts){
			form.find(':submit').addClass('loading').attr('disabled',true);
		}
		,unlockForm : function($form){
			$($form).find(':submit').removeClass('loading').attr('disabled',false);
		},
		dialog:function(element){
			Helper.wait('on');
			$modal = $('#modal-window');
			var href = element.prop('href');
			$.get(href, function(data){
				Helper.wait('off');
				if(data.success) {
					$modal.html('').html(data.html);
					$modal.modal();
					
				}
			});
		},
		closeModal:function(){
			$('#modal-window').modal('hide');
		},
		confirm : function(element){
			var func = element.data('func');
			var url = element.prop('href');
			var prompt = element.data('prompt');
			bootbox.confirm(prompt, function(result) {
				if(result) {
					Helper.wait('on');
					$.get(url,function(data){
						Helper.wait('off');
						callback = window[func];
						if(typeof callback == 'function') {
							callback(data,element);
						}
					})
					
				}
			}); 
			
		}
		
		
}
if(jQuery().validate) {
	$.validator.setDefaults({
	    highlight: function(element) {
	        $(element).closest('.form-group').addClass('has-error');
	    },
	    unhighlight: function(element) {
	        $(element).closest('.form-group').removeClass('has-error');
	    },
	    errorElement: 'span',
	    errorClass: 'help-block',
	    errorPlacement: function(error, element) {
	    	if(element.closest('.validate-w').length > 0){
				element.closest('.validate-w').find('.error-w').html(error);
			} else {
				error.insertAfter(element);
		  	}
	    }
	});
	}
function format(number) {
	var num = parseFloat(number);
	//there should be a fallback
	return num.toLocaleString('en-GB',{minimumFractionDigits:2})
}

function getFloat(value) {
	value = parseFloat(value.replace(',',''));
	value = isNaN(value) ? 0 : value;
	return value;
}

function updateSummaryTable() {
	var summary = {
					scheme_value : 0,
					total_deduct : 0,
					net_scheme : 0,
					main_center_cost : 0,
					grand_total : 0,
					advance : 0,
					petty_payment:0,
					g1_incentive : 0,
					g1_weekly_incentive : 0,
					external_transport : 0,
					other_recovery : 0,
					net_pay_this_week : 0,
					cum_pay_last_week : 0,
					cum_pay_this_week : 0

			}
	summary = setValues(summary);
	$('#table-summary #scheme-value').html(format(summary.scheme_value));
	$('#table-summary #total-deduct').html(format(summary.total_deduct));
	summary.net_scheme = (summary.scheme_value - summary.total_deduct)
	$('#table-summary #net-scheme').html(format(summary.net_scheme));
	summary.grand_total = (summary.net_scheme + summary.main_center_cost);
	$('#table-summary #grand-total').html(format(summary.grand_total));
	summary.net_pay_this_week = (summary.grand_total + summary.external_transport + summary.g1_incentive + summary.g1_weekly_incentive + summary.petty_payment) - (summary.advance + summary.other_recovery);
	$('#table-summary #net-payment').html(format(summary.net_pay_this_week));
	$('#form-id-payment').val(summary.net_pay_this_week);
	summary.cum_pay_this_week = (summary.net_pay_this_week + summary.cum_pay_last_week)
	$('#table-summary #cum-payment-this').html(format(summary.cum_pay_this_week));
	$('#form-id-cum-payment').val(summary.cum_pay_this_week);
}

function setValues(summary){
	summary.scheme_value = getFloat($('#table-summary #scheme-value').html());
	summary.total_deduct = getTotalDeduction();
	summary.net_scheme = getFloat($('#table-summary #net-scheme').html());
	summary.main_center_cost = getFloat($('#table-summary #main-center-cost').html());
	summary.grand_total = getFloat($('#table-summary #grand-total').html());
	summary.advance = getFloat($('#table-summary #advance-recovery').html());
	summary.petty_payment = getFloat($('#table-summary #petty-payment').html());
	summary.external_transport = getFloat($('#table-summary #external-transport').html());
	summary.g1_weekly_incentive = getFloat($('#table-summary #weekly-incentive').html());
	if($('#g1-incentive').length>0) {
		summary.g1_incentive = getFloat($('#g1-incentive').html());
	}
	summary.other_recovery = getFloat($('#table-summary #other-recovery').html());
	summary.net_pay_this_week = getFloat($('#table-summary #net-payment').html());
	summary.cum_pay_last_week = getFloat($('#table-summary #cum-payment-last').html());
	summary.cum_pay_this_week = getFloat($('#table-summary #cum-payment-this').html());
	return summary;
}

function getTotalDeduction() {
	var rejection = st = 0;
	rejection = getFloat($('#table-summary #rejection').html());
	st = getFloat($('#table-summary #st-diff').html());
	return (rejection + st)
}




