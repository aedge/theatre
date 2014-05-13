$(function(){
	$('.datepicker-input').datepicker({
			dateFormat: "dd/mm/yy",
			showButtonPanel: true,
			changeMonth: true,
			changeYear: true
	});
	
	$('.datepicker-input-clear').button();
	
	$('.datepicker-input-clear').click(function(){
		$(this).parent().find('.datepicker-input').val("");
		return false;
	});
	
	$(".chosen-select,.chosen-multiple-select").chosen();	
	
});