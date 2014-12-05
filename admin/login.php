<?php

require('../includes/config.php'); 
if(logged_in()) {header('Location: '.DIRADMIN);}
?>
<!DOCTYPE>
<html>
<head>
<meta http-equiv="Content-Type" charset="UTF-8" />
<title><?php echo SITETITLE;?></title>
<link rel="stylesheet" href="<?php echo DIR;?>css/login.css" type="text/css" />
</head>
<body>
<?php 
	if(@$_POST['submit']) {
		login($_POST['username'], $_POST['password']);
	}
?>
	<div id="lwidth">
		<div id="loginHeader"><p><?php echo messages();?></p></div>
		<div id="content">
			<div id="login">
				<form method="post" action="">
					<input type="text" name="username" placeholder="slapyvardis" /><br/>
					<input type="text" name="password" placeholder="slaptažodis" /><br/>
					<input type="submit" name="submit" class="button" value="Prisijungti" />
				</form>
			</div>
		</div>
	</div>
</body>
</html>