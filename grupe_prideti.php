<?php
	require_once('connections.php');
	require('header.php');
	$currentPage = "grupe";
	displayHeader($currentPage, ["Pridėti grupę"=>"grupe_prideti.php"]);

	// Duomenų gavimas iš lentelės.
	$rowsSkyrius = selectBasic("skyrius");

	// Duomenų gavimas iš lentelės.
	$rowsForma = selectBasic("forma");

	// Duomenų gavimas iš lentelės.
	$rowsStudijos = selectBasic("studijos");

?>
	<div class="well well-lg">
		<form method="POST" action="grupe_redaguoti.php">
			<div class="form-group">
				<label for="pavadinimasinputas">Pavadinimas</label>
				<input type="text" class="form-control" id="pavadinimasinputas" name="pavadinimas" placeholder="Įveskite trumpą pavadinimą" required>
			</div>
			<div class="form-group" >
				<label for="elpastasinputas">El. paštas</label>
				<input type="email" class="form-control" id="elpastasinputas" name="elpastas" placeholder="Įveskite el.paštą">
			</div>
			<div class="form-group">
				<label for="studijuprogramos">Studijų skyrius</label>
				<select class="form-control" name="skyrius_id" id="studijuprogramos">
<?php
					foreach ($rowsSkyrius as $key => $value) {
						echo "<option value=".$value['id'].">".$value['pavadinimas']."</option>";
					};
?>
				</select>
			</div>
			<div class="form-group">
				<label for="studijuforma">Studijų forma</label>
				<select class="form-control" name="forma_id" id="studijuforma">
<?php
					foreach ($rowsForma as $key => $value) {
						echo "<option value=".$value['id'].">".$value['pavadinimas']."</option>";
					};
?>
				</select>
			</div>
			<div class="form-group">
				<label for="studijuprograma">Studijų programa</label>
				<select class="form-control" name="studijos_id" id="studijuprograma">
<?php
					foreach ($rowsStudijos as $key => $value) {
						echo "<option value=".$value['id'].">".$value['pavadinimas']."</option>";
					};
?>
				</select>
			</div>
			<button type="submit" class="btn btn-success">Pridėti</button>
			<button type="reset" class="btn btn-warning">Atstatyti</button>
		</form>
	</div>

<?php

	displayFooter();