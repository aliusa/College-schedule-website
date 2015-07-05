<?php
	require_once('connections.php');
	require('header.php');
	$currentPage = "destytojas";
	// Allow for admins roles.
	if (@$_SESSION['user_role'] === 2)
	{
		if ( isset($_GET['id']) )
		{
			/**
			 * Nuorodos meniu juostoje, funkcijų pasirinkime.
			 * @var array
			 */
			$args = [
					"Pridėti dėstytoją"=>"destytojas_prideti.php",
					"Pridėti šiam dėstytojui tvarkaraščio įrašą"=>"tvarkarastis_prideti.php?des=".intval($_GET['id']),
					"Pridėti savo tvarkaraščio įrašą"=>"tvarkarastis_prideti.php?des=".$_SESSION['user_id']
					];
		} else
		{
			$args = ["Pridėti dėstytoją"=>"destytojas_prideti.php"];
		}
	// Allow for lecturer roles.
	} elseif (@$_SESSION['user_role'] === 1)
	{
		if ( isset($_GET['id']) && (@$_SESSION['user_id'] === intval($_GET['id'])) )
		{
			$args = ["Pridėti tvarkaraščio įrašą"=>"tvarkarastis_prideti.php?des=".$_SESSION['user_id']];
		}
	}
	$args = !isset($args) ? null : $args ;
	displayHeader($currentPage, $args);

	if (@$_GET['id']) {
		/**
		 * ID of lecturer from GET
		 * @var int
		 */
		$id = intval($_GET['id']);
		if ( selectSingle("destytojas", $id) === false ) die("Tokio destytojo nėra.");
		/**
		 * Viena eilutė iš dėstytojo lentelės
		 * @var array
		 */
		$row = selectComplex("
				SELECT a.id, CONCAT(a.vardas, ' ', a.pavarde) AS destytojas, a.elpastas
				FROM destytojas AS a
				WHERE id = '".$id."'
				LIMIT 1");
?>
	<div class="well well-lg">
		<div class="row">
			<table>
<?php
				/**
				 * Dėstytojo aprašymo antraštės.
				 * @var string
				 */
				$arr = headings("destytojas");
				echo "<tr><td><b>".$arr[0]."</b></td><td>".$row[0]['id']."</td></tr>"; //id
				echo "<tr><td><b>".$arr[1].' '.$arr[2]."</b></td><td>".$row[0]['destytojas']."</td></tr>"; //vardas pavardė
				echo "<tr><td><b>".$arr[3]."</b></td><td>".$row[0]['elpastas']."</td></tr>"; //elpaštas
?>
			</table>
		</div>
		<div class="row">
<?php
			// Redaguoti gali tik teises lygiu 2 arba pats save.
			if ( (@$_SESSION['user_role'] === 2) || (@$_SESSION['user_id'] === $id) )
			{
?>
				<a class="btn btn-primary" href="destytojas_redaguoti.php?id=<?=$id?>" role="button">Redaguoti</a>
<?php
			}
?>
			<div class="col-xs-8 col-sm-4 col-md-4 col-lg-4">
				<input type="search" id="search" value="" class="form-control" placeholder="Ieškoti mišriu būdu!">
			</div>
		</div>
	</div> <!-- well well-lg -->









<?php
// Visi vieno dėstytojo tvarkaraščio įrašai.
		try {
			// Visi vienos grupės įrašai su data didesne už šiandien.
			$rows = selectComplex("
				SELECT tv.id tvid, tv.diena tvdiena, tv.pogrupis, tv.pasirenkamasis,
					pr.laikas prlaikas,
					pa.laikas palaikas,
					gr.pavadinimas grpavadinimas, gr.id grid,
					da.pavadinimas dapavadinimas, da.id daid,
					CONCAT(de.vardas, ' ', de.pavarde) destytojas, de.id deid,
					au.pavadinimas aupavadinimas,
					pas.pavadinimas paspavadinimas
				FROM tvarkarastis tv
				LEFT JOIN pradzioslaikas pr
				ON tv.pradzioslaikas_id = pr.id
				LEFT JOIN pabaigoslaikas pa
				ON tv.pabaigoslaikas_id = pa.id
				LEFT JOIN grupe gr
				ON tv.grupe_id = gr.id
				LEFT JOIN dalykas da
				ON tv.dalykas_id = da.id
				LEFT JOIN destytojas de
				ON tv.destytojas_id = de.id
				LEFT JOIN auditorija au
				ON tv.auditorija_id = au.id
				LEFT JOIN paskaitos_tipas pas
				ON tv.paskaitos_tipas_id = pas.id
				WHERE tv.destytojas_id = ".$id." AND tv.diena <> NOW()
				ORDER BY tv.diena ASC, prlaikas ASC, palaikas ASC
				");
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
		
?>

<?php
		echo '<table id="myTable" class="tablesorter table table-striped table-condensed table-responsive table-hover"><thead><tr>';
		/**
		 * Tvarkaraščio lentelės antraštės.
		 * @var array
		 */
		$arrTvarkarastis = headings("tvarkarastis");
		//echo "<th>".$arrTvarkarastis[0]."</th>"; //id
		echo "<th>".$arrTvarkarastis[1]."</th>"; //diena
		echo "<th><span class='hidden-sm hidden-xs'>".$arrTvarkarastis[2]." - ".$arrTvarkarastis[3]."</span><span class='visible-sm visible-xs'>Laikas</span></th>"; //pradžia
		//echo "<th>".$arrTvarkarastis[3]."</th>"; //pabaiga
		$pogrupis = ($arrTvarkarastis[5] === "0" ) ? null : " (".$arrTvarkarastis[5].")";
		echo "<th>".$arrTvarkarastis[4]."<span class='hidden-xs'>$pogrupis</span></th>"; //grupė
		//echo "<th>".$arrTvarkarastis[5]."</th>"; //pogrupis
		echo "<th>".$arrTvarkarastis[6]."</th>"; //dalykas
		//echo "<th>".$arrTvarkarastis[7]."</th>"; //dėstytojas
		echo "<th><span class='hidden-sm hidden-xs'>".$arrTvarkarastis[8]."</span><span class='visible-sm visible-xs'>Aud.</span></th>"; //auditorija
		echo "<th class='hidden-xs'>".$arrTvarkarastis[9]."</th>"; //paskaitos tipas
		echo "</tr></thead><tbody>";

		foreach ($rows as $key => $value) {
			echo "<tr onclick=\"window.document.location='tvarkarastis.php?id=".$value['tvid']."';\">";
			echo "<td>".date('m/d', strtotime($value['tvdiena']))."</td>";
			$prad = date('H:i', strtotime($value['prlaikas']));
			$pab = date('H:i', strtotime($value['palaikas']));
			echo "<td><span class='hidden-xs'>$prad - $pab</span><span class='visible-xs'>$prad - $pab<span></td>";
			//echo "<td>".date('H:i', strtotime($value['palaikas']))."</td>";
			$pogrupis = ($value['pogrupis'] === "0") ? null : " <span class='visible-xs'>\n</span>(".$value['pogrupis']." pogr.)" ;
			$pasirenkamasis = ($value['pasirenkamasis'] === "0" ) ? null : " <span class='visible-xs'>\n</span>(pasirenk.)";
			echo "<td><a href='grupe.php?id=".$value['grid']."'>".$value['grpavadinimas']."</a>$pogrupis$pasirenkamasis</td>";
			$paskaitosTipas = (strtolower($value['paspavadinimas']) === "paskaita") ? null : "<span class='visible-xs'> (".$value['paspavadinimas'].")</span>" ;
			echo "<td>".$value['dapavadinimas']."$paskaitosTipas</td>"; // dalykas
			//echo "<td>".$value['destytojas']."</td>"; //destytojas
			echo "<td>".$value['aupavadinimas']."</td>"; //auditorija
			echo "<td class='hidden-xs'>".$value['paspavadinimas']."</td>"; //paskaitos tipas
			echo "</tr>";
		}

		echo "</tbody></table>";










// Visų dėstytojų įrašai.
	} elseif (selectBasicLimit("destytojas") === 0) {
			echo "nėra įrašų";
	} else {
		$rows = selectComplex('
			SELECT *
			FROM destytojas
			WHERE paslepti = 0
			ORDER BY pavarde ASC, vardas ASC
			');
?>
		<div class="row">
			<div class="col-lg-4 col-lg-offset-4">
				<input type="search" id="search" value="" class="form-control" placeholder="Ieškoti mišriu būdu!">
			</div>
		</div>
<?php
		echo '<table id="myTable" class="tablesorter table table-striped table-condensed table-responsive table-hover"><thead><tr>';

		// Lentelės antraštinės eilutės elementai.
		$arr = headings("destytojas");
		//echo "<th>".$arr[0]."</th>"; //id
		echo "<th>".$arr[1]."</th>"; //vardas
		echo "<th>".$arr[2]."</th>"; //pavardė
		if (isset($_SESSION['user_is_loggedin']))
		{
			echo "<th class='hidden-xs'>".$arr[3]."</th>"; //email
		}

		echo "</tr></thead><tbody>";

		foreach ($rows as $key => $value) {
			$id = $rows[$key]['id'];
			$vardas = $rows[$key]['vardas'];
			$pavarde = $rows[$key]['pavarde'];
			$elpastas = $rows[$key]['elpastas'];

			echo "<tr onclick=\"window.document.location='destytojas.php?id=".$id."';\">";
			//echo "<td><a href='destytojas.php?id=$id'>$id</a></td>";
			echo "<td>$vardas</td>";
			echo "<td>$pavarde</td>";
			if (isset($_SESSION['user_is_loggedin']))
			{
				echo "<td class='hidden-xs'><a href='mailto:$elpastas?subject=Žinutė iš tvarkaraščio informacinės sistemos'>$elpastas</a></td>";
			}
			echo "</tr>";
		}

		echo "</tbody></table>";
	}
?>
	<script type="text/javascript">
		//initialize table sorter script
		$(document).ready(function() 
			{
				$("#myTable").tablesorter();
				$('#myTable').searchable();
			}
		);
	</script>
<?php
	displayFooter();
