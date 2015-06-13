<?php
	require_once('connections.php');
	require('header.php');
	$currentPage = "destytojas";
	//$args = ["Pridėti dėstytoją"=>"destytojas_prideti.php"];
	displayHeader($currentPage);

	if ( isset($_SESSION['user_is_loggedin']) && (@$_SESSION['user_role'] >= 1) ) {
?>
	<div class="well well-lg">
		<form method="POST" action="destytojas_redaguoti.php">
			<div class="row">
				<div class="form-group col-xs-6">
					<label for="vardasinputas">Vardas</label>
					<input type="text" class="form-control" id="vardasinputas" name="vardas" placeholder="Įveskite vardą" required>
				</div>
				<div class="form-group col-xs-6">
					<label for="pavardeinputas">Pavardė</label>
					<input type="text" class="form-control" id="pavardeinputas" name="pavarde" placeholder="Įveskite pavardę" required>
				</div>
			</div> <!-- row -->

			<div class="row">
				<div class="form-group col-xs-12">
					<label for="elpastasinputas">El. paštas</label>
					<input type="email" class="form-control" id="elpastasinputas" name="elpastas" placeholder="Įveskite el.paštą">
				</div>
			</div> <!-- row -->
			<button type="submit" class="btn btn-success">Pridėti</button>
			<button type="reset" class="btn btn-warning">Atstatyti</button>
		</form>
	</div>
<?php
	} else {
		die("Neturi tokių teisių.");
	}
	displayFooter();
