
<div style="width: 400px; height: 200px;" id="div_member_renew" >
	<div class="form-field-box odd">
		<div class="form-display-as-box">Expiry Date: </div>
		<div class='form-input-box' id="expirydate_input_box">
			<input id='field-expirydate' name='expirydate' type='text' value='<?php echo $expiryDate; ?>' maxlength='10' class='datepicker-input' />
			<a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)				
		</div>
	</div>
	<div class="form-field-box even">
		<div class="form-display-as-box">Payment Type:</div>
		<div class='form-input-box' id="paymenttype_input_box">
			<?php echo $paymentTypeSelect; ?>
		</div>
	</div>
	<div class="form-field-box odd">
		<div class="form-display-as-box">Amount Paid: </div>
		<div class="form-input-box"><input id="field-amountpaid" name="amountpaid" type="text" maxlength="10,0" /></div>
	</div>
	<div style="padding: 5px;"><span id="member_renew_message"></span></div>
	<div style="padding: 5px;">
		<input class="btn btn-large" type="button" value="Save" onClick="do_quick_add(\'' . site_url() . '/member_renew/save/\');" />
	</div>
</div>