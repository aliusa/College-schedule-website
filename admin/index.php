<?php

require('../includes/config.php'); 

//make sure user is logged in, function will redirect use if not logged in
login_required();

//if logout has been clicked run the logout function which will destroy any active sessions and redirect to the login page
if(isset($_GET['logout'])){
	logout();
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo SITETITLE;?></title>
	<link href="<?php echo DIR;?>css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<div id="wrapper">
		<div id="menu">
			<div id="logo">
				<a href=""><span>Vilniaus<br/>Kooperacijos<br/>Kolegija</span></a>
			</div>
			
			<div id="navbar">
				<nav>
					<a href="<?=DIRADMIN?>schedule.php" id="schedule"></a>
					<a href="<?=DIRADMIN?>staff.php" id="staff"></a>
				</nav>
			</div>
		</div>
	</div>
</body>
</html>