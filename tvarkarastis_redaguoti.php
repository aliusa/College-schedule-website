<?php
	require_once('connections.php');
	require('header.php');
	$currentPage = "tvarkarastis";
	if ( isset($_SESSION['user_is_loggedin']) && (@$_SESSION['user_role'] >= 1) )
	{
		if (@$_SESSION['user_role'] === 1)
		{
			$args = [
				"Pridėti įrašą"=>"tvarkarastis_prideti.php?des=".$_SESSION['user_id']
				];
		} elseif (@$_SESSION['user_role'] === 2)
		{
			$args = [
					"Pridėti sau įrašą"=>"tvarkarastis_prideti.php?des=".$_SESSION['user_id'],
					"Pridėti kitam įrašą"=>"tvarkarastis_prideti.php"
					];
		}
	}
	$args = !isset($args) ? null : $args ;
	displayHeader($currentPage, $args);


	if ( isset($_SESSION['user_is_loggedin']) && (@$_SESSION['user_role'] >= 1) )
	{
		// Žiūrim ar URL nuorodoje yra deleteItem kintamasis
		if (isset($_GET['deleteItem'])) {
			deleteItem("tvarkarastis", intval($_GET['id']));
			header("Location: tvarkarastis.php");
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
					// Datų eilutę paverčia į masyvą.
					$_POST['diena'] = explode(", ", $_POST['diena']);
					// Ciklina per dienas
					foreach ($_POST['diena'] as $key => $value) {
						// Ciklina per grupes.
						foreach ($_POST['grupe_id'] as $k => $v) {
							$sql = "INSERT INTO tvarkarastis VALUES (NULL,?,?,?,?,?,?,?,?,?,?)";
							$stmt = $pdo->prepare($sql);
							$stmt->execute([
								date('Y-m-d', strtotime($_POST['diena'][$key])),
								intval($_POST['pradzioslaikas_id']),
								intval($_POST['pabaigoslaikas_id']),
								intval($_POST['grupe_id'][$k]),
								intval($_POST['pogrupis']),
								intval($_POST['dalykas_id']),
								intval($_POST['destytojas_id']),
								intval($_POST['auditorija_id']),
								intval($_POST['paskaitos_tipas_id']),
								intval($_POST['pasirenkamasis']),
								]);
						}
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
		$rowsAuditorija = selectComplex("SELECT a.id aid, a.pavadinimas apav, a.skyrius_id, s.pavadinimas spav FROM auditorija AS a LEFT JOIN skyrius AS s ON a.skyrius_id = s.id ORDER BY a.skyrius_id ASC, a.pavadinimas ASC");
		$rowsPaskaitosTipas = selectBasic("paskaitos_tipas");

		$date = date('Y-m-d', strtotime($row['diena']));
?>

		<div class="well well-lg">
			<form method="POST" action="<?=$_SERVER['REQUEST_URI']?>">
				<div class="row">
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
				</div> <!-- row -->

				<div class="row">
					<div class="form-group col-xs-6 col-sm-4" >
						<label for="grupeinputas">Grupė</label>
						<select id="grupeinputas" class="multiselect" name="grupe_id">
<?php
							foreach ($rowsGrupe as $key => $value) {
								$selected = ((@$_GET['gru'] === $value['id']) || ($row['grupe_id'] === $value['id'])) ? "selected" : null ;
								echo "<option value=".$value['id']." $selected>".$value['pavadinimas']."</option>";
							};
?>
						</select>
					</div>

					<div class="form-group col-xs-3 col-sm-4">
						<label for="pogrupioinputas"><span class="hidden-xs">Pogrupis</span><span class="visible-xs">Pogr.</span></label>
						<select id="pogrupioinputas" class="form-control" name="pogrupis">
<?php 					$selected = (isset($_GET['pog'])) ? $_GET['pog'] : null ; ?>
							<option value="0" <?=$selected?> >Visi</option>
							<option value="1" <?=$selected?> >1 pogr.</option>
							<option value="2" <?=$selected?> >2 pogr.</option>
						</select>
					</div>

					<div class="form-group col-xs-3 col-sm-4" >
						<label for="pasirenkamasisinputas"><span class="hidden-xs">Pasirenkamasis</span><span class="visible-xs">Pasir.</span></label>
						<select id="pasirenkamasisinputas" class="form-control" name="pasirenkamasis">
<?php 					$selected = (isset($_GET['pasi'])) ? $_GET['pasi'] : null ; ?>
							<option value="0" <?=$selected?> >Ne</option>
							<option value="1" <?=$selected?> >Taip</option>
						</select>
					</div>
				</div> <!-- row -->

				<div class="row">
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
						<select id="destytojasinputas" name="destytojas_id" class="multiselect" >
<?php
							foreach ($rowsDestytojas as $key => $value) {
								$selected = ($row['destytojas_id'] === $value['id']) ? "selected" : null ;
								echo "<option value=".$value['id']." ".$selected.">".$value['vardas']." ".$value['pavarde']."</option>";
							};
?>
						</select>
					</div>
				</div> <!-- row -->

				<div class="row">
					<div class="form-group col-xs-6" >
						<label for="auditorijainputas">Auditorija</label>
						<select id="auditorijainputas" class="multiselect" name="auditorija_id">
<?php
							foreach ($rowsAuditorija as $key => $value) {
								$selected = ($row['auditorija_id'] === $value['aid']) ? "selected" : null ;
								echo "<option value=".$value['aid']." $selected>".$value['apav']." (".$value['spav'].")</option>";
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
				</div> <!-- row -->

				<button type="submit" class="btn btn-success">Atnaujinti</button>
				<button type="reset" class="btn btn-warning">Atstatyti</button>
				<button type="button" class="btn btn-danger" onclick="location.href='tvarkarastis_redaguoti.php?deleteItem=true&amp;id=<?=$id?>'">Ištrinti</button>
				<button type="button" class="btn btn-primary" onclick="location.href='tvarkarastis.php?id=<?=$id?>'">Atgal</button>
				<button type="button" class="btn btn-info" onclick="location.href='tvarkarastis_prideti.php?die=<?=$row['diena']?>&amp;pra=<?=$row['pradzioslaikas_id']?>&amp;pab=<?=$row['pabaigoslaikas_id']?>&amp;gru=<?=$row['grupe_id']?>&amp;pog=<?=$row['pogrupis']?>&amp;dal=<?=$row['dalykas_id']?>&amp;des=<?=$row['destytojas_id']?>&amp;aud=<?=$row['auditorija_id']?>&amp;tip=<?=$row['paskaitos_tipas_id']?>&amp;pasi=<?=$row['pasirenkamasis']?>'">Kopijuoti</button>
			</form>
		</div>

<?php
	} else
	{
		die("Neturi tokių teisių.");
	}
	displayFooter();