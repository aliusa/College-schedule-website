Generuoti naudotojo prisijumo duomenis reikia nurodyti jo ID iš DB, pvz:<br/>
<i>/prisijungimuFormavimas.php?id=5</i><hr/>
<?php
	require_once('connections.php');

	/**
	 * Gauna vardą, pavardės 2 pirmas raides.
	 * @return array     jų raidės
	 */
	function generate_login()
	{
		global $pdo;
		$sql = "
			SELECT d.vardas, d.pavarde
			FROM destytojas AS d
			WHERE id = ".intval($_GET['id'])."
			LIMIT 1";
		$stmt = $pdo->query($sql);
		$row = $stmt->fetchAll();
		$vardas = substr($row[0][0], 0, 2);
		$pavarde = substr($row[0][1], 0, 2);
		return strtolower($vardas.$pavarde);
	}

	function genXnumber($cnt)
	{
		$digits = $cnt;
		return rand(pow(10, $digits-1), pow(10, $digits)-1);
	}

	// Gaunam vardą, pavardę.
	$user = generate_login();

	// Generuojam naudotojo prisijungimo vardą.
	$user = $user.genXnumber(4); //pvz - inbi5478
	echo "naudotojas: ".$user."<br/>";

	// Generuoja prisijungimo slaptažodį.
	$chars = 'ABCDEFGHIJKLMOPQRSTUVXWYZ';
	// Generuoja pirmą random raidę.
	$rand = rand(0, 24);
	$firstletter = strtolower($chars[$rand]);
	$pass = $firstletter.genXnumber(8); //pvz - k57020509
	echo "slaptažodis: ".$pass." (raw)<br/>";

	$salt = 'kk^^kk$topkek$alius#';
	$result = md5($pass . $salt); // pvz - df6664ede71b6a8c6ccdd2671a694d2d
	echo "slaptažodis: ".$result." (užkoduotas)";

