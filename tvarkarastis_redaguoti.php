<?php
	require_once('connections.php');
	require('header.php');
	$currentPage = "tvarkarastis";
	displayHeader($currentPage, ["Pridėti įrašą"=>"tvarkarastis_prideti.php"]);

	if (@$_GET['deleteItem']) {
		deleteItem($_GET['table'], $_GET['id']);
		header("Location: tvarkarastis");
	}

	if ($_POST) {
		if (isset($_POST['id'])) {
			try {
				$sql = "UPDATE tvarkarastis SET diena=?, pradzioslaikas_id=?, pabaigoslaikas_id=?, grupe_id=?, pogrupis=?, dalykas_id=?, destytojas_id=?, auditorija_id=?, paskaitos_tipas_id=?, pasirenkamasis=? WHERE id=?";
				$stmt = $pdo->prepare($sql);
				$stmt->execute([
					$_POST['diena'],
					intval($_POST['pradzioslaikas_id']),
					intval($_POST['pabaigoslaikas_id']),
					intval($_POST['grupe_id']),
					intval($_POST['pogrupis']),
					intval($_POST['dalykas_id']),
					intval($_POST['destytojas_id']),
					intval($_POST['auditorija_id']),
					intval($_POST['paskaitos_tipas_id']),
					intval($_POST['pasirenkamasis']),
					intval($_POST['id'])
					]);
				//echo "<script type='text/javascript'>alert('Duomenys sėkmingai atnaujinti!');</script>";
				//header("Location: tvarkarastis.php?id=".$_POST['id']);
			} catch (Exception $e) {
				echo 'Caught exception: ',  $e->getMessage(), "\n";
			}
		} else {
			try {
				foreach ($_POST['grupe_id'] as $key => $value) {
					$sql = "INSERT INTO tvarkarastis VALUES (NULL,?,?,?,?,?,?,?,?,?,?)";
					$stmt = $pdo->prepare($sql);
					$stmt->execute([
						date('Y-m-d', strtotime($_POST['diena'])),
						intval($_POST['pradzioslaikas_id']),
						intval($_POST['pabaigoslaikas_id']),
						intval($_POST['grupe_id'][$key]),
						intval($_POST['pogrupis']),
						intval($_POST['dalykas_id']),
						intval($_POST['destytojas_id']),
						intval($_POST['auditorija_id']),
						intval($_POST['paskaitos_tipas_id']),
						intval($_POST['pasirenkamasis']),
						]);
				}
			} catch (Exception $e) {
				echo 'Caught exception: ',  $e->getMessage(), "\n";
			}
			header("Location: tvarkarastis.php");
		}
	}

	if ( !isset($_GET['id']) ) {
		die("Nepateiktas tvarkaraščio ID");
	}
	$id = intval($_GET['id']);
	
	// Gaunam vieną eilutę iš lentelės su nurodytu ID.
	$row = selectSingle("tvarkarastis", $id);

	// Duomenų gavimas iš lentelės.
	$rowsPradzia = [
		['id'=>'9','laikas'=>'07:40'],
		['id'=>'18','laikas'=>'08:25'],
		['id'=>'27','laikas'=>'09:10'],
		['id'=>'29','laikas'=>'09:20'],
		['id'=>'47','laikas'=>'10:50'],
		['id'=>'55','laikas'=>'11:30'],
		['id'=>'73','laikas'=>'13:00'],
		['id'=>'75','laikas'=>'13:10'],
		['id'=>'93','laikas'=>'14:40'],
		['id'=>'95','laikas'=>'14:50'],
		['id'=>'109','laikas'=>'16:00'],
		['id'=>'113','laikas'=>'16:20'],
		['id'=>'115','laikas'=>'16:30'],
		['id'=>'133','laikas'=>'18:00'],
		['id'=>'151','laikas'=>'19:30'],
		['id'=>'171','laikas'=>'21:00']
		];
	$rowsPabaiga = $rowsPradzia;
	$rowsGrupe = selectComplex("SELECT * FROM grupe ORDER BY pavadinimas ASC");
	$rowsDalykas = selectComplex("SELECT * FROM dalykas ORDER BY pavadinimas ASC");
	$rowsDestytojas = selectComplex("SELECT * FROM destytojas ORDER BY pavarde ASC, vardas ASC");
	$rowsAuditorija = selectBasic("auditorija");
	$rowsPaskaitosTipas = selectBasic("paskaitos_tipas");

	$date = date('Y-m-d', strtotime($row['diena']));
?>
	
	<div class="well well-lg">
		<form method="POST" action="<?=$_SERVER['REQUEST_URI']?>">
			<input type="text" name="id" hidden value="<?=$row['id']?>">
			<div class="form-group col-sm-4 col-xs-12">
				<label for="dienosinputas">Diena</label>
				<input type="date" class="form-control" id="dienosinputas" name="diena" required value="<?=$date?>" />
			</div>
			<div class="form-group col-sm-4 col-xs-6" >
				<label for="pradziainputas">Pradžia</label>
				<select class="form-control" name="pradzioslaikas_id" id="pradziainputas">
<?php
					foreach ($rowsPradzia as $key => $value) {
						$selected = ($row['pradzioslaikas_id'] === $value['id']) ? "selected" : null ;
						echo "<option value=".$value['id']." ".$selected.">".$value['laikas']."</option>";
					};
?>
				</select>
			</div>

			<div class="form-group col-sm-4 col-xs-6" >
				<label for="pabaigainputas">Pabaiga</label>
				<select class="form-control" name="pabaigoslaikas_id" id="pabaigainputas">
<?php
					foreach ($rowsPabaiga as $key => $value) {
						$selected = ($row['pabaigoslaikas_id'] === $value['id']) ? "selected" : null ;
						echo "<option value=".$value['id']." $selected>".$value['laikas']."</option>";
					};
?>
				</select>
			</div>

			<div class="form-group col-xs-4" >
				<label for="example-getting-started">Grupė</label>
<br>
				<select id="example-getting-started" name="grupe_id">
<?php
					foreach ($rowsGrupe as $key => $value) {
						$selected = ((@$_GET['gru'] === $value['id']) || ($row['grupe_id'] === $value['id'])) ? "selected" : null ;
						echo "<option value=".$value['id']." $selected>".$value['pavadinimas']."</option>";
					};
?>
				</select>
			</div>

			<div class="form-group col-xs-4">
				<label for="pogrupioinputas">Pogrupis</label>

				<input type="text" class="form-control" id="pogrupioinputas" name="pogrupis" required value="<?=$row['pogrupis']?>">
			</div>

			<div class="form-group col-xs-4" >
				<label for="pasirenkamasisinputas">Pasirenkamasis</label>
				<input type="text" class="form-control" id="pasirenkamasisinputas" name="pasirenkamasis" required value="<?=$row['pasirenkamasis']?>">
			</div>

			<div class="form-group col-md-6" >
				<label for="dalykasinputas">Dalykas</label>
				<select class="form-control" name="dalykas_id" id="dalykasinputas">
<?php
					foreach ($rowsDalykas as $key => $value) {
						$selected = ($row['dalykas_id'] === $value['id']) ? "selected" : null ;
						echo "<option value=".$value['id']." ".$selected.">".$value['pavadinimas']."</option>";
					};
?>
				</select>
			</div>

			<div class="form-group col-md-6" >
				<label for="destytojasinputas">Dėstytojas</label>
				<select class="form-control" name="destytojas_id" id="destytojasinputas">
<?php
					foreach ($rowsDestytojas as $key => $value) {
						$selected = ($row['destytojas_id'] === $value['id']) ? "selected" : null ;
						echo "<option value=".$value['id']." ".$selected.">".$value['vardas']." ".$value['pavarde']."</option>";
					};
?>
				</select>
			</div>

			<div class="form-group col-xs-6" >
				<label for="auditorijainputas">Auditorija</label>
				<select class="form-control" name="auditorija_id" id="auditorijainputas">
<?php
					foreach ($rowsAuditorija as $key => $value) {
						$selected = ($row['auditorija_id'] === $value['id']) ? "selected" : null ;
						echo "<option value=".$value['id']." ".$selected.">".$value['pavadinimas']."</option>";
					};
?>
				</select>
			</div>

			<div class="form-group col-xs-6" >
				<label for="paskaitostipoinputas">Tipas</label>
				<select class="form-control" name="paskaitos_tipas_id" id="paskaitostipoinputas">
<?php
					foreach ($rowsPaskaitosTipas as $key => $value) {
						$selected = ($row['paskaitos_tipas_id'] === $value['id']) ? "selected" : null ;
						echo "<option value=".$value['id']." ".$selected.">".$value['pavadinimas']."</option>";
					};
?>
				</select>
			</div>

			<button type="submit" class="btn btn-success">Atnaujinti</button>
			<button type="reset" class="btn btn-warning">Atstatyti</button>
			<button type="button" class="btn btn-danger" onclick="location.href='tvarkarastis_redaguoti.php?deleteItem=true&amp;table=tvarkarastis&amp;id=<?=$id?>'">Ištrinti</button>
			<button type="button" class="btn btn-primary" onclick="location.href='tvarkarastis.php?id=<?=$id?>'">Atgal</button>
			<button type="button" class="btn btn-info" onclick="location.href='tvarkarastis_prideti.php?die=<?=$row['diena']?>&amp;pra=<?=$row['pradzioslaikas_id']?>&amp;pab=<?=$row['pabaigoslaikas_id']?>&amp;gru=<?=$row['grupe_id']?>&amp;pog=<?=$row['pogrupis']?>&amp;dal=<?=$row['dalykas_id']?>&amp;des=<?=$row['destytojas_id']?>&amp;aud=<?=$row['auditorija_id']?>&amp;tip=<?=$row['paskaitos_tipas_id']?>&amp;pasi=<?=$row['pasirenkamasis']?>'">Kopijuoti</button>
		</form>
	</div>

<?php

	displayFooter();