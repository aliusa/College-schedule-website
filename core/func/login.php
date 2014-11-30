<?php
$server = "http://localhost/vkk_schedule";
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		function testInput() {

		}
		require "../mysqli.inc.php";
		$login = testInput($_POST["loginID"]);
		$pass = testInput($_POST["loginPass"]);
		$sql = "
			SELECT *
			FROM `logins`
			WHERE `s_login` = '$login'
			LIMIT 1
		";
	} else {
		header('Location: '. $server);
		die();
	}
?>