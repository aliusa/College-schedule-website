<?php
	require_once('connections.php');
	require('header.php');
	$currentPage = "index";
	displayHeader($currentPage);

	header("Location: grupe.php");
?>
	
<?php
	displayFooter();
