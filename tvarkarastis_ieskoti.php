<?php
	require_once('connections.php');
	require('header.php');
	$currentPage = "tvarkarastis";
	// Jei naudotojas prisijungęs ir teisės >= 1.
	if ( isset($_SESSION['user_is_loggedin']) && (@$_SESSION['user_role'] >= 1) )
	{
		// Jei dėstytojo teisės.
		if (@$_SESSION['user_role'] === 1)
		{
            // Dėstytojo funkcijos pasiekiamos per meniu juostą.
			$args = [
				"Pridėti įrašą"=>"tvarkarastis_prideti.php?des=".$_SESSION['user_id'],
				"Ieškoti"=>"tvarkarastis_ieskoti.php"
				];
        // Administratoriaus funkcijos pasiekiamos per meniu juostą.
		} elseif (@$_SESSION['user_role'] === 2)
		{
            // Funkcijos meniu juostoje.
			$args = [
					"Pridėti sau įrašą"=>"tvarkarastis_prideti.php?des=".$_SESSION['user_id'],
					"Pridėti įrašą"=>"tvarkarastis_prideti.php",
					"Ieškoti"=>"tvarkarastis_ieskoti.php"
					];
		}
	}
	$args = !isset($args) ? null : $args ;
	displayHeader($currentPage, $args);


	// Jei ne dėstytojas/admin - neprileidžia prie puslapio.
	if ( !isset($_SESSION['user_is_loggedin']) && !isset($_GET['id']) )
	{
		die("Neturi tokių teisių.");
	}


?>
	<!-- Paieškos forma -->
	<form action="<?=$_SERVER['PHP_SELF']?>" method="GET" class="form-inline" role="form">
	
		<div class="form-group">
            <div class="row">
                <label class="sr-only" for="">label</label>
                <input type="search" name="" id="input" class="form-control" value="" required="required" title="">
            </div>
            <div class="row">
            	<label class="sr-only" for="">label</label>
                <input type="search" name="" id="input" class="form-control" value="" required="required" title="">
            </div>
		</div>
	
		
	
		<button type="submit" class="btn btn-primary">Submit</button>
	</form>

<?php

	displayFooter();
