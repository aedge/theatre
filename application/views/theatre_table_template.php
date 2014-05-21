<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
 
<?php 
foreach($css_files as $file): ?>
    <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
 
<?php endforeach; ?>
<?php foreach($js_files as $file): ?>
 
    <script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>
 
  <title>Sutton Arts Theatre</title>
  <link rel='stylesheet' type='text/css' href='<?php echo base_url()."css/theatre.css"?>' />
  <script type="text/javascript" src="<?=base_url()?>assets/js/quickadd.js"></script>
  


  <script type="text/javascript">
  $(document).ready(function() {
  
    $(".fancybox-link").fancybox();
	$(".fancybox-paid").fancybox({
		padding: 0
	});
	$(".fancybox-labels").fancybox({
		padding: 0,
		content: '<div class="popup"><span class="popuptitle">Print labels for? </span><a class="labellink" href="<?= site_url() ?>/main/labels/all" > All Members </a><a class="labellink" href="<?= site_url() ?>/main/labels/noemail" > Members without Email Addresses </a></div>',
	});
	
	//ADD IN A BUTTON TO ADD TO DROPDOWN	
	$('#addressid_input_box').append('<a href="<?=site_url()?>/address_add/popup" class="fancybox-link fancybox.ajax ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" ><span class="ui-button-text">Add</span></a>');	

	
  });
  
</script>
</head>
<body>
<!-- Beginning header -->
	<div id="divHeaderBar">
		<h1>Sutton Arts Member Database</h1> 
		<?php if($accessLevel >= 10) { ?>
			<a <?php if($this->router->fetch_method() == "users"){ echo 'class="selected"'; } ?> href='<?php echo site_url('main/users')?>  '>Users</a>
		<?php } ?>
        <a <?php if($this->router->fetch_method() == "interests"){ echo 'class="selected"'; } ?> href='<?php echo site_url('main/interests')?>'>Interests</a> 
		<a <?php if($this->router->fetch_method() == "addresses"){ echo 'class="selected"'; } ?> href='<?php echo site_url('main/addresses')?>'>Addresses</a>		
		<a <?php if($this->router->fetch_method() == "members"){ echo 'class="selected"'; } ?> href='<?php echo site_url('main/members')?>  '>Members</a>		
    </div>
<!-- End of header-->
 
    <div>
        <?php echo $output; ?>
 
    </div>
<!-- Beginning footer -->

	<div id="divFooter" ><span>&copy; 2013 Sutton Arts Theatre</span>
		<a href='<?php echo site_url('main/logout') ?>' >Logout</a> 
		<?php if($this->router->fetch_method() == "addresses"){
			echo '<a href="#" class="fancybox-labels"  > Labels </a>';
		} ?>
		<?php if($this->router->fetch_method() == "members"){
			echo '<a href="'. site_url() . '/main/paid_totals" class="fancybox-paid fancybox.ajax" > Paid Totals </a>';
		} ?>
	</div>
<!-- End of Footer -->
</body>
</html>
 