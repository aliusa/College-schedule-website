<?php
	require_once('connections.php');
	require('header.php');
	$currentPage = "grupe";

	$args = null;
	displayHeader($currentPage, $args);

	if ( isset($_SESSION['user_is_loggedin']) && (@$_SESSION['user_role'] === 2) )
	{
		if (isset($_GET['deleteItem'])) {
			// Ieško ar grupė turi tvarkaraščio įrašų.
			$s = selectComplex("SELECT COUNT(grupe_id) as g FROM tvarkarastis WHERE grupe_id = ".intval($_GET['id'])." LIMIT 1");
			// Jei yra įrašas grupės netrina.
			if ( $s[0]['g'] === 1) {
				die("Negalima ištrinti grupės. Grupė turi tvarkaraščio įrašų.");
			} else {
				deleteItem("grupe", $_GET['id']);
				header("Location: grupe.php");
			}
		}

		if ($_POST) {
			if ($_POST['id']) {
				try {
					$sql = "UPDATE grupe SET pavadinimas=?, elpastas=?, skyrius_id=?, forma_id=?, studijos_id=? WHERE id=?";
					$stmt = $pdo->prepare($sql);
					$stmt->execute([
						$_POST['pavadinimas'],
						$_POST['elpastas'],
						intval($_POST['skyrius_id']),
						intval($_POST['forma_id']),
						intval($_POST['studijos_id']),
						intval($_POST['id'])
						]);
					//echo "<script type='text/javascript'>alert('Duomenys sėkmingai atnaujinti!');</script>";
					header("Location: grupe");
				} catch (Exception $e) {
					echo 'Caught exception: ',  $e->getMessage(), "\n";
				}
			} else {
				try {
					$sql = "INSERT INTO grupe VALUES (NULL,?,?,?,?,?)";
					$stmt = $pdo->prepare($sql);
					$stmt->execute([
						$_POST['pavadinimas'],
						$_POST['elpastas'],
						intval($_POST['skyrius_id']),
						intval($_POST['forma_id']),
						intval($_POST['studijos_id']),
						]);
				} catch (Exception $e) {
					echo 'Caught exception: ',  $e->getMessage(), "\n";
				}
				header("Location: grupe.php");
			}
		}

		if ( !isset($_GET['id']) ) {
			die("Nepateiktas grupės ID");
		}
		$id = intval($_GET['id']);
		
		// Gaunam vieną eilutę iš lentelės su nurodytu ID.
		$row = selectSingle("grupe", $id);

		// Duomenų gavimas iš lentelės.
		$rowsSkyrius = selectBasic("skyrius");

		// Duomenų gavimas iš lentelės.
		$rowsForma = selectBasic("forma");

		// Duomenų gavimas iš lentelės.
	$rowsStudijos = selectBasic("studijos");



?>
	
		<div class="well well-lg">
			<form method="POST" action="<?=$_SERVER['REQUEST_URI']?>">
				<input type="text" name="id" hidden value="<?=$row['id']?>">
				<div class="form-group">
					<label for="pavadinimasinputas">Pavadinimas</label>
					<input type="text" class="form-control" id="pavadinimasinputas" name="pavadinimas" placeholder="Įveskite vardą" required value="<?=$row['pavadinimas']?>">
				</div>
				<div class="form-group" >
					<label for="elpastasinputas">El. paštas</label>
					<input type="email" class="form-control" id="elpastasinputas" name="elpastas" placeholder="Įveskite el.paštą" value="<?=$row['elpastas']?>" >
				</div>
				<div class="form-group">
					<label for="studijuprogramos">Studijų skyrius</label>
					<select class="form-control" name="skyrius_id" id="studijuprogramos">
<?php
						foreach ($rowsSkyrius as $key => $value) {
							$selected = ($row['skyrius_id'] === $value['id']) ? "selected" : null ;
							echo "<option value=".$value['id']." ".$selected.">".$value['pavadinimas']."</option>";
						};
?>
					</select>
				</div>
				<div class="form-group">
					<label for="studijuforma">Studijų forma</label>
					<select class="form-control" name="forma_id" id="studijuforma">
<?php
						foreach ($rowsForma as $key => $value) {
							$selected = ($row['forma_id'] === $value['id']) ? "selected" : null ;
							echo "<option value=".$value['id']." ".$selected.">".$value['pavadinimas']."</option>";
						};
?>
					</select>
				</div>
				<div class="form-group">
					<label for="studijuprograma">Studijų programa</label>
					<select class="form-control" name="studijos_id" id="studijuprograma">
<?php
						foreach ($rowsStudijos as $key => $value) {
							$selected = ($row['studijos_id'] === $value['id']) ? "selected" : null ;
							echo "<option value=".$value['id']." ".$selected.">".$value['pavadinimas']."</option>";
						};
?>
					</select>
				</div>

				<button type="submit" class="btn btn-success">Atnaujinti</button>
				<button type="reset" class="btn btn-warning">Atstatyti</button>
				<button type="button" class="btn btn-danger" onclick="location.href='grupe_redaguoti.php?deleteItem=true&id=<?=$id?>'">Ištrinti</button>
				<button type="button" class="btn btn-primary" onclick="location.href='grupe_redaguoti.php?id=<?=$id?>'">Atgal</button>
			</form>
		</div>

<?php
	} else
	{
		die("Neturi tokių teisių.");
	}
	displayFooter();