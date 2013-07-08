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
			echo '<a href='. site_url('main/labels') .' > Labels </a>';
		} ?>
	</div>
<!-- End of Footer -->
</body>
</html>
 