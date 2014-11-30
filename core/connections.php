<?php
	function dbConnect() {
		$conn = null;
		$host = 'localhost';
		$db =  'vkk_schedule';
		$user = 'root';
		$pwd =  '';

		try
		{
			$conn = new PDO( 'mysql:host='.$host.';dbname='.$db.';charset=utf8', $user, $pwd );
			//echo 'Connected succesfully.<br>';
		}
		catch ( PDOException $e ) {
			echo '<p>Cannot connect to database !!</p>';
			echo '<p>'.$e.'</p>';
			exit;
		}
		return $conn;
	}

	
	try {
		$pdo = new PDO('mysql:host=localhost;dbname=vkk_schedule;charset=utf8', 'root', '');
	} catch (PDOExeption $e) {
		exit('Database error.');
	}
?>