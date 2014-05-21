function do_quick_add(saveURL) {

	var printname = $('#qa-field-printname').val();
	var housename = $('#qa-field-housename').val();
	var address1  = $('#qa-field-addressline1').val();
	var address2  = $('#qa-field-addressline2').val();
	var address3  = $('#qa-field-addressline3').val();
	var address4  = $('#qa-field-addressline4').val();
	var postcode  = $('#qa-field-postcode').val();	
	
	if(printname.replace(/^\s\s*/, '').replace(/\s\s*$/, '') == ""){
		$('#quick_add_message').html('To is required');
		return;
	}
	if(address1.replace(/^\s\s*/, '').replace(/\s\s*$/, '') == ""){
		$('#quick_add_message').html('Address Line 1 is required');
		return;
	}
	if(postcode.replace(/^\s\s*/, '').replace(/\s\s*$/, '') == ""){
		$('#quick_add_message').html('Postcode is required');
		return;
	}
	
	$.post( saveURL, 
		   { printname: printname, housename: housename, address1: address1, address2: address2, address3: address3, address4: address4, postcode: postcode }, 
			function(data) {
				if(data.indexOf("ERROR:") == -1){
					$('#field-addressid').prepend('<option value="' + data + '">' + address1 + ' </option>');
					//REBUILD SELECT BOX				
					$("#field-addressid").prop('selectedIndex', 0);
					$('#field-addressid').trigger("liszt:updated");
					//DISPLAY SUCCESS MESSAGE									
					$('#quick_add_message').html('Successfully inserted a new address record');
					$.fancybox.close( );
				}
	});
}