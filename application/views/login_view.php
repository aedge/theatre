<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Sutton Arts Theatre</title>
  <link rel='stylesheet' type='text/css' href='<?php echo base_url()."css/theatre.css"?>' />
</head>
<body>
   <div id="divLoginBox">
	 <div id="divLoginHeader">
		<h1>Sutton Arts Member Database</h1>    
	 </div>
	 <div id="divLoginForm" >
		 <?php echo form_open('login'); ?>
			<fieldset class="fieldSetLogin">
			 <label for="username">Username:</label>
			 <input type="text" size="20" id="username" name="username"/>
			 <label for="password">Password:</label>
			 <input type="password" size="20" id="password" name="password"/>
			 <button type="submit" name="login" value="login" id="loginBtn">Login</button>
			 <span id="spnErrors"><?php echo validation_errors(); ?></span>
			</fieldset>
		 </form>
	 </div>
 </div>
</body>
</html>

