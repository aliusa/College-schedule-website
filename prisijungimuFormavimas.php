<?php
	require_once('connections.php');
	require('header.php');
	displayHeader();

	if ( !isset($_SESSION['user_is_loggedin']) || ($_SESSION['user_role'] <> 2 ) ) die("Neturit tokių teisių");

	if (isset($_POST))
	{
		if (isset($_POST['user']) && isset($_POST['pass']) && isset($_POST['id']))
		{
			try {
				$user = $_POST['user'];
				$pass = $_POST['pass'];
				$id = intval($_POST['id']);
				$sql = "
					UPDATE destytojas
					SET
						prisijungimas = ?,
						slaptazodis = ?
					WHERE id = ?";
				$stmt = $pdo->prepare($sql);
				$stmt->execute([
					$user,
					$pass,
					$id
					]);
				//echo "<script type='text/javascript'>alert('Duomenys sėkmingai atnaujinti!');</script>";
				//header("Location: tvarkarastis.php?id=".$_POST['id']);
			} catch (Exception $e) {
				echo 'Caught exception: ',  $e->getMessage(), "\n";
			}
		}
	}

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

	echo "Generuoti naudotojo prisijumo duomenis reikia nurodyti jo ID iš DB.<hr/>";

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
?>
	<style>
	.hidden {display:none;}
	</style>
	<hr/>

	<form action="<?=$_SERVER['PHP_SELF']?>?id=<?=$_GET['id']?>" method="POST" role="form">
		<div class="form-group">
			<input type="text" class="form-control hidden" name="user" value="<?=$user?>">
			<input type="text" class="form-control hidden" name="pass" value="<?=$result?>">
			<input type="text" class="form-control hidden" name="id" value="<?=$_GET['id']?>">
		</div>

		<button type="submit" class="btn btn-primary">Įrašyti</button>
	</form>