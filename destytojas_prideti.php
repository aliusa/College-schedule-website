<?php
	require_once('connections.php');
	require('header.php');
	$currentPage = "destytojas";
	$args = ["Pridėti dėstytoją"=>"destytojas_prideti.php"];
	displayHeader($currentPage, $args);

?>
	<div class="well well-lg">
		<form method="POST" action="destytojas_redaguoti.php">
			<div class="form-group col-xs-6">
				<label for="vardasinputas">Vardas</label>
				<input type="text" class="form-control" id="vardasinputas" name="vardas" placeholder="Įveskite vardą" required>
			</div>
			<div class="form-group col-xs-6">
				<label for="pavardeinputas">Pavardė</label>
				<input type="text" class="form-control" id="pavardeinputas" name="pavarde" placeholder="Įveskite pavardę" required>
			</div>
			<div class="form-group">
				<label for="elpastasinputas">El. paštas</label>
				<input type="email" class="form-control" id="elpastasinputas" name="elpastas" placeholder="Įveskite el.paštą">
			</div>
			<button type="submit" class="btn btn-success">Pridėti</button>
			<button type="reset" class="btn btn-warning">Atstatyti</button>
		</form>
	</div>
	
<?php
	displayFooter();
