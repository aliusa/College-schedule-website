<?php
	try {
		$pdo = new PDO('mysql:host=localhost;dbname=tvarkarastis_dev;charset=utf8', 'root', '');
	} catch (PDOExeption $e) {
		exit('Database error.');
	}
?>