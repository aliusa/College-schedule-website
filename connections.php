<?php

	/**
	 * DB nuoroda.
	 * @var string
	 */
	$tinklas = "localhost";

	/**
	 * Database name.
	 * @var string
	 */
	$duomenu_baze = "tvarkarastis_vkk";

	/**
	 * Database username.
	 * @var string
	 */
	$vartotojas = "root";

	/**
	 * Database password.
	 * @var string
	 */
	$slaptazodis = "";

	try {
		/**
		 * Assign pdo connection.
		 * @var PDO
		 */
		$pdo = new PDO("mysql:host=$tinklas;dbname=$duomenu_baze;charset=utf8", $vartotojas, $slaptazodis);
	} catch (PDOExeption $e) {
		exit('Database error.');
	}
?>