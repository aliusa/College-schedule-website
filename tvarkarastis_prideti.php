<?php
	require_once('connections.php');
	require('header.php');
	$currentPage = "tvarkarastis";
	displayHeader($currentPage, ["Pridėti įrašą"=>"tvarkarastis_prideti.php"]);


	// Duomenų gavimas iš lentelės.
	//$rowsPradzia = selectBasic("pradzioslaikas");
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
	$rowsDestytojas = selectComplex("SELECT * FROM destytojas ORDER BY pavarde ASC");
	$rowsAuditorija = selectComplex("SELECT a.id aid, a.pavadinimas apav, a.skyrius_id, s.pavadinimas spav FROM auditorija AS a LEFT JOIN skyrius AS s ON a.skyrius_id = s.id ORDER BY a.skyrius_id ASC, a.pavadinimas ASC");
	$rowsPaskaitosTipas = selectComplex("SELECT * FROM paskaitos_tipas ORDER BY id ASC");

?>
	<div class="well well-lg">
		<form method="POST" action="tvarkarastis_redaguoti.php">

			<div class="form-group" id="cia-yra-multidate">
				<label for="dienosinputas">Diena</label>
<?php
				// Jei pateikta diena - ją ir rodyti. Kitu atveju rodyti šiandienos dieną.
				$diena = (isset($_GET['die'])) ? $_GET['die'] : null ;
?>
				<div class="input-group date">
					<input type="text" class="form-control" id="dienosinputas" value="<?=$diena?>" required name="diena"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
				</div>
			</div> <!-- .form-group -->
		

			<div class="row">
				<div class="form-group col-xs-6" >
					<label for="pradziainputas">Pradžia</label>
					<select class="form-control" name="pradzioslaikas_id" id="pradziainputas" required>
<?php
						//echo "<option value='' selected>&#60;&#60;Pradžia&#62&#62;&#62;</option>";
						foreach ($rowsPradzia as $key => $value) {
							$selected = (@$_GET['pra'] === $value['id']) ? "selected" : null ;
							echo "<option value=".$value['id']." $selected>".$value['laikas']."</option>";
						};
?>
					</select>
				</div> <!-- .form-group .col-xs-6 -->

				<div class="form-group col-xs-6" >
					<label for="pabaigainputas">Pabaiga</label>
					<select class="form-control" name="pabaigoslaikas_id" id="pabaigainputas">
<?php
						//echo "<option value='' selected>&#60;&#60;&#60;Pabaiga&#62;&#62;&#62;</option>";
						foreach ($rowsPabaiga as $key => $value) {
							$selected = (@$_GET['pab'] === $value['id']) ? "selected" : null ;
							echo "<option value=".$value['id']." $selected>".$value['laikas']."</option>";
						};
?>
					</select>
				</div> <!-- form-group col-xs-6 -->
			</div> <!-- row -->

			<div class="row">
				<div class="form-group col-xs-6 col-sm-4" >
					<label for="grupeinputas">Grupė</label><br>
					<select id="grupeinputas" class="multiselect" multiple="multiple" name="grupe_id[]">
<?php
						foreach ($rowsGrupe as $key => $value) {
							$selected = (@$_GET['gru'] === $value['id']) ? "selected" : null ;
							echo "<option value=".$value['id']." $selected>".$value['pavadinimas']."</option>";
						};
?>
					</select>
				</div> <!-- form-group col-xs-6 col-sm-4 -->

				<div class="form-group col-xs-3 col-sm-4">
					<label for="pogrupioinputas"><span class="hidden-xs">Pogrupis</span><span class="visible-xs">Pogr.</span></label>
<!--<?php
					$arr = [
						['value'=>'1 p.','key'=>'1','class'=>'radio-primary'],
						['value'=>'2 p.','key'=>'2','class'=>'radio-primary'],
						['value'=>'visi','key'=>'0','class'=>'radio-success']
						];
					$checked = ( isset($_GET['pog']) ) ? "checked" : "checked" ;
					foreach ($arr as $key => $value) {
?>
						<div class="radio radio-inline <?=$value['class']?>">
						<input type="radio" id="pogrupioinputas<?=$value['key']?>" name="pogrupis" value="<?=$value['key']?>" <?=$checked?> >
						<label for="pogrupioinputas<?=$value['key']?>"><?=$value['value']?></label>
						</div>
<?php
					}
?>
-->


					<select id="pogrupioinputas" class="form-control" name="pogrupis">
<?php 					$selected = (isset($_GET['pog'])) ? $_GET['pog'] : null ; ?>
						<option value="0" <?=$selected?> >Visi</option>
						<option value="1" <?=$selected?> >1 pogr.</option>
						<option value="2" <?=$selected?> >2 pogr.</option>
					</select>
				</div> <!-- form-group col-xs-3 col-sm-4 -->

				<div class="form-group col-xs-3 col-sm-4" >
					<label for="pasirenkamasisinputas"><span class="hidden-xs">Pasirenkamasis</span><span class="visible-xs">Pasirenk.</span></label>
<!--<?php
					$arr = [['value'=>'Taip','key'=>'0','class'=>'radio-success'],['value'=>'Ne','key'=>'1','class'=>'radio-danger']];
					$checked = ( isset($_GET['pasi']) ) ? "checked" : "checked" ;
					foreach ($arr as $key => $value) {
?>
						<div class="radio radio-inline <?=$value['class']?>">
						<input type="radio" id="pasirenkamasisinputas<?=$value['key']?>" name="pasirenkamasis" value="<?=$value['key']?>" <?=$checked?> >
						<label for="pasirenkamasisinputas<?=$value['key']?>"><?=$value['value']?></label>
						</div>
<?php
					}
?>				-->

					<select id="pasirenkamasisinputas" class="form-control" name="pasirenkamasis">
<?php 					$selected = (isset($_GET['pasi'])) ? $_GET['pasi'] : null ; ?>
						<option value="0" <?=$selected?> >Ne</option>
						<option value="1" <?=$selected?> >Taip</option>
					</select>
				</div> <!-- form-group col-xs-3 col-sm-4 -->
			</div> <!-- row -->

			<div class="row">
				<div class="form-group col-xs-6" >
					<label for="dalykasinputas">Dalykas</label>
					<select class="multiselect" name="dalykas_id" id="dalykasinputas">
<?php
						//echo "<option value='' selected>&#60;&#60;&#60;Dalykas&#62;&#62;&#62;</option>";
						foreach ($rowsDalykas as $key => $value) {
							$selected = (@$_GET['dal'] === $value['id']) ? "selected" : null ;
							echo "<option value=".$value['id']." $selected>".$value['pavadinimas']."</option>";
						};
?>
					</select>
				</div> <!-- form-group col-xs-6 -->

				<div class="form-group col-xs-6">
					<label for="destytojasinputas">Dėstytojas</label>
					<select id="destytojasinputas" name="destytojas_id" class="multiselect" >
<?php
						foreach ($rowsDestytojas as $key => $value) {
							$selected = (@$_GET['des'] === $value['id']) ? "selected" : null ;
							echo "<option value=".$value['id']." $selected>".$value['vardas']." ".$value['pavarde']."</option>";
						};
?>
					</select>
				</div> <!-- form-group col-xs-6 -->
			</div> <!-- row -->

			<div class="row">
				<div class="form-group col-xs-6" >
					<label for="auditorijainputas">Auditorija</label>
					<select id="auditorijainputas" class="multiselect" name="auditorija_id">
<?php
						foreach ($rowsAuditorija as $key => $value) {
							$selected = (@$_GET['aud'] === $value['aid']) ? "selected" : null ;
							echo "<option value=".$value['aid']." $selected>".$value['apav']." (".$value['spav'].")</option>";
						};
?>
					</select>
				</div> <!-- form-group col-xs-6 -->

				<div class="form-group col-xs-6" >
					<label for="paskaitostipoinputas">Tipas</label>
					<select class="form-control" name="paskaitos_tipas_id" id="paskaitostipoinputas">
<?php
						foreach ($rowsPaskaitosTipas as $key => $value) {
							$selected = (@$_GET['tip'] === $value['id']) ? "selected" : null ;
							echo "<option value=".$value['id']." $selected>".$value['pavadinimas']."</option>";
						};
?>
					</select>
				</div> <!-- form-group col-xs-6 -->
			</div> <!-- row -->

			<button type="submit" class="btn btn-success">Pridėti</button>
			<button type="reset" class="btn btn-warning">Atstatyti</button>
		</form>
	</div>
<script type="text/javascript">
	$('#cia-yra-multidate .input-group.date').datepicker({
    format: "yyyy-mm-dd",
    language: "lt",
    multidate: true,
    multidateSeparator: ", "
});
</script>

<?php

	displayFooter();