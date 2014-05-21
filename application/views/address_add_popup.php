<?php  
?>

<script type="text/javascript" src="<?=base_url()?>assets/js/quickadd.js"></script>

<script>
	var title = $('#field-title').val();
	var initial = $('#field-initials').val();
	var lastname = $('#field-lastname').val();
	var toSuggest = title; 
	var toSuggest = (toSuggest == "")?toSuggest + initial:toSuggest + " " + initial;
	var toSuggest = (toSuggest == "")?toSuggest + lastname:toSuggest + " " + lastname;
	$('#qa-field-printname').val(toSuggest);
</script>

<div style="width: 500px; height: 400px;" id="div_quick_add" >
		<div class="form-field-box odd">
			<div class="form-display-as-box">To*: </div>
			<div class="form-input-box"><input type="text" name="printname" id="qa-field-printname"></div>
		</div>
		<div class="form-field-box even">
			<div class="form-display-as-box">House Name:</div>
			<div class="form-input-box"><input type="text" name="housename" id="qa-field-housename"></div>
		</div>
		<div class="form-field-box odd">
			<div class="form-display-as-box">Line 1*: </div>
			<div class="form-input-box"><input type="text" name="addressline1" id="qa-field-addressline1"></div>
		</div>
		<div class="form-field-box even">
			<div class="form-display-as-box">Line 2: </div>
			<div class="form-input-box"><input type="text" name="addressline2" id="qa-field-addressline2"></div>
		</div>
		<div class="form-field-box odd">
			<div class="form-display-as-box">Line 3: </div>
			<div class="form-input-box"><input type="text" name="addressline3" id="qa-field-addressline3"></div>
		</div>
		<div class="form-field-box even">
			<div class="form-display-as-box">Line 4: </div>
			<div class="form-input-box"><input type="text" name="addressline4" id="qa-field-addressline4"></div>
		</div>
		<div class="form-field-box odd">
			<div class="form-display-as-box">Postcode*: </div>
			<div class="form-input-box"><input type="text" name="postcode" id="qa-field-postcode"></div>
		</div>
		<div style="padding: 5px;"><span id="quick_add_message"></span></div>
		<div style="padding: 5px;"><input class="btn btn-large" type="button" value="Save" onClick="do_quick_add('<?php echo site_url() . "/address_add/save"; ?>');" /></div>
</div>;