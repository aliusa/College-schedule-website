<?php
	require_once('connections.php');
	require('header.php');
	$currentPage = "destytojas";
	displayHeader($currentPage, ["Pridėti dėstytoją"=>"destytojas_prideti.php"]);

	if (isset($_GET['deleteItem'])) {
		// Ieško ar dėstytojas turi tvarkaraščio įrašų.
		$s = selectComplex("SELECT COUNT(destytojas_id) FROM tvarkarastis WHERE destytojas_id = ".intval($_GET['id'])." LIMIT 1");
		// Jei yra įrašas grupės netrina.
		if ( $s[0]['g'] === 1) {
			die("Negalima ištrinti grupės. Grupė turi tvarkaraščio įrašų.");
		} else {
			deleteItem("destytojas", $_GET['id']);
			header("Location: destytojas.php");
		}
	}

	if ($_POST) {
		if ($_POST['id']) {
			$sql = "UPDATE destytojas SET vardas=?, pavarde=?, elpastas=? WHERE id=?";
			$stmt = $pdo->prepare($sql);
			$stmt->execute([$_POST['vardas'], $_POST['pavarde'], $_POST['elpastas'], intval($_POST['id'])]);
			//header("Location: destytojas.php?id=".$_POST['id']);
			//echo "<script type='text/javascript'>alert('Duomenys sėkmingai atnaujinti!');</script>";
		} else {
			try {
				$sql = "INSERT INTO destytojas VALUES (NULL,?,?,?)";
				$stmt = $pdo->prepare($sql);
				$stmt->execute([$_POST['vardas'], $_POST['pavarde'], $_POST['elpastas']]);
				header("Location: destytojas.php");
			} catch (Exception $e) {
				echo 'Caught exception: ',  $e->getMessage(), "\n";
			}
		}
	}

	if ( !isset($_GET['id']) ) {
		die("Nepateiktas dėstytojo ID");
	}
	$id = intval($_GET['id']);
	
	// Gaunam vieną eilutę iš lentelės su nurodytu ID.
	$row = selectSingle("destytojas", $id);

?>
	<div class="well well-lg">
		<form method="POST" action="<?=$_SERVER['REQUEST_URI']?>">
			<input type="text" name="id" hidden value="<?=$row['id']?>">
			<div class="form-group col-*-12">
				<label for="vardasinputas">Vardas</label>
				<input type="text" class="form-control" id="vardasinputas" name="vardas" placeholder="Įveskite vardą" required value="<?=$row['vardas']?>">
			</div>
			<div class="form-group col-*-12">
				<label for="pavardeinputas">Pavardė</label>
				<input type="text" class="form-control" id="pavardeinputas" name="pavarde" placeholder="Įveskite pavardę" required value="<?=$row['pavarde']?>" >
			</div>
			<div class="form-group">
				<label for="elpastasinputas">El. paštas</label>
				<input type="email" class="form-control" id="elpastasinputas" name="elpastas" placeholder="Įveskite el.paštą" value="<?=$row['elpastas']?>" >
			</div>
			<button type="submit" class="btn btn-success">Atnaujinti</button>
			<button type="reset" class="btn btn-warning">Atstatyti</button>
			<button type="button" class="btn btn-danger" onclick="location.href='destytojas_redaguoti.php?deleteItem=true&id=<?=$id?>'">Ištrinti</button>
			<button type="button" class="btn btn-primary" onclick="location.href='destytojas.php?id=<?=$id?>'">Atgal</button>
		</form>
	</div>
<?php

	displayFooter();