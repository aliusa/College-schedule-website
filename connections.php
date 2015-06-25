<?php
	$tinklas = "localhost";
	$duomenu_baze = "tvarkarastis_vkk";
	$vartotojas = "root";
	$slaptazodis = "";

	try {
		$pdo = new PDO("mysql:host=$tinklas;dbname=$duomenu_baze;charset=utf8", $vartotojas, $slaptazodis);
	} catch (PDOExeption $e) {
		exit('Database error.');
	}
?>