<?php
	require_once('connections.php');
	require('header.php');
	$currentPage = "tvarkarastis";
	if ( isset($_SESSION['user_is_loggedin']) && (@$_SESSION['user_role'] >= 1) )
	{
		if (@$_SESSION['user_role'] === 1)
		{
			$args = ["Pridėti įrašą"=>"tvarkarastis_prideti.php?des=".$_SESSION['user_id']];
		} elseif (@$_SESSION['user_role'] === 2)
		{
			$args = [
					"Pridėti sau įrašą"=>"tvarkarastis_prideti.php?des=".$_SESSION['user_id'],
					"Pridėti kitam įrašą"=>"tvarkarastis_prideti.php"
					];
		}
	} else
	{
		$args = null;
	}
	displayHeader($currentPage, $args);

	if (@$_GET['id']) {
		$id = intval($_GET['id']);
		if ( selectSingle("tvarkarastis", $id) === false ) die("Tokio tvarkaraščio nėra.");

		$row = selectComplex("
				SELECT tv.id tvid, tv.diena tvdiena,
					pr.laikas prlaikas,
					pa.laikas palaikas,
					gr.pavadinimas grpavadinimas,
					tv.grupe_id tvgrupe, tv.pogrupis,
					da.pavadinimas dapavadinimas,
					CONCAT(de.vardas, ' ', de.pavarde) destytojas, tv.destytojas_id tvdestytojas,
					au.pavadinimas aupavadinimas,
					pas.pavadinimas paspavadinimas,
					tv.pasirenkamasis pasirenkamasis
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
				WHERE tv.id = '".$id."'
				LIMIT 1");
?>
	<div class="well well-lg">
		<table>
<?php
			$arr = headings("tvarkarastis");

			$tvdiena = date('2015-m-d', strtotime($row[0]['tvdiena']));
			$prlaikas = date('H:i', strtotime($row[0]['prlaikas']));
			$palaikas = date('H:i', strtotime($row[0]['palaikas']));

			$pogrupis = intval($row[0]['pogrupis']);
			$pogrupis = ($pogrupis === 0) ? null : " (".$pogrupis." pogrupis)";
			$pasirenkamasis = ($row[0]['pasirenkamasis'] === "0") ? null : " (pasirenkamasis)";

			echo "<tr><th scope='row'>".$arr[1]."</th><td>$tvdiena</td></tr>";
			echo "<tr><th scope='row'>Laikas</th><td>$prlaikas - $palaikas</td></tr>";
			echo "<tr><th scope='row'>".$arr[4]."</th><td><a href='grupe.php?id=".$row[0]['tvgrupe']."'>".$row[0]['grpavadinimas']."</a>$pogrupis$pasirenkamasis</td></tr>";
			echo "<tr><th scope='row'>".$arr[6]."</th><td>".$row[0]['dapavadinimas']."</td></tr>";
			echo "<tr><th scope='row'>".$arr[7]."</th><td><a href='destytojas.php?id=".$row[0]['tvdestytojas']."'>".$row[0]['destytojas']."</a></td></tr>";
			echo "<tr><th scope='row'>".$arr[8]."</th><td>".$row[0]['aupavadinimas']."</td></tr>";
			echo "<tr><th scope='row'>".$arr[9]."</th><td>".$row[0]['paspavadinimas']."</td></tr>";
			/*$i=0;
			foreach ($row[0] as $key => $value) {
				echo "<tr><td><b>".$arr[$i]."</b></td><td>$value</td></tr>";
				$i++;
			}/**/
?>
		</table>
		<a class="btn btn-primary" href="tvarkarastis_redaguoti.php?id=<?=$id?>" role="button">Redaguoti</a>
	</div>
<?php







// Visi įrašai.
	} elseif (selectBasicLimit("tvarkarastis") === 0) {
			echo "nėra įrašų";
	} else {
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
			ORDER BY tv.diena ASC, prlaikas ASC, palaikas ASC
			");

		echo '<table id="myTable" class="tablesorter table table-striped table-condensed table-responsive"><thead><tr>';

		// Lentelės antraštinės eilutės elementai.
		$arr = headings("tvarkarastis");

		//echo "<th>".$arr[0]."</th>"; //id
		echo "<th>".$arr[1]."</th>"; //diena
		echo "<th>".$arr[2]."</th>"; //pradžios laikas
		echo "<th class='hidden-xs'>".$arr[3]."</th>"; //pabaigos laikas
		echo "<th>".$arr[4]."</th>"; //grupė
		//echo "<th>".$arr[5]."</th>"; //pogrupis
		echo "<th>".$arr[6]."</th>"; //dalykas
		echo "<th class='hidden-xs'>".$arr[7]."</th>"; //dėstytojas
		echo "<th class='hidden-xs'>".$arr[8]."</th>"; //auditorija
		echo "<th class='hidden-xs'>".$arr[9]."</th>"; //paskaitos tipas
		

		echo "</tr></thead><tbody>";

		foreach ($rows as $key => $value) {
			$tvid = $rows[$key]['tvid'];
			$tvdiena = date('m/d', strtotime($rows[$key]['tvdiena']));
			$prlaikas = date('H:i', strtotime($rows[$key]['prlaikas']));
			$palaikas = date('H:i', strtotime($rows[$key]['palaikas']));
			$pogrupis = intval($rows[$key]['pogrupis']);
			$pogrupis = ($pogrupis === 0) ? null : " (".$pogrupis." pogrupis)";
			$grid = intval($rows[$key]['grid']);
			$grpavadinimas = $rows[$key]['grpavadinimas'];
			$daid = intval($rows[$key]['daid']);
			$dapavadinimas = $rows[$key]['dapavadinimas'];
			$deid = intval($rows[$key]['deid']);
			$destytojas = $rows[$key]['destytojas'];
			//$auid = intval($rows[$key]['auid']);
			$aupavadinimas = $rows[$key]['aupavadinimas'];
			$paspavadinimas = $rows[$key]['paspavadinimas'];
			$pasirenkamasis = intval($rows[$key]['pasirenkamasis']);
			$pasi = ($pasirenkamasis === 0) ? null : "<br>(pasirenkamasis)";


			echo "<tr onclick=\"window.document.location='tvarkarastis.php?id=".$tvid."';\">";
			//echo "<td><a href='index.php?id=$tvid'>$tvid</a></td>";
			echo "<td>".$tvdiena."</td>";
			echo "<td>".$prlaikas."<span class='visible-xs'>(".$aupavadinimas.")</span></td>";
			echo "<td class='hidden-xs'>".$palaikas."</td>";
			echo "<td><a href='grupe.php?id=$grid'>$grpavadinimas$pogrupis$pasi</a></td>";
			//echo "<td>$pogrupis</td>";
			//echo "<td><a href='dalykas.php?id=$daid'>".$dapavadinimas."</td>";
			echo "<td>$dapavadinimas</td>";
			echo "<td class='hidden-xs'><a href='destytojas.php?id=$deid'>$destytojas</a></td>";
			echo "<td class='hidden-xs'>$aupavadinimas</td>";
			echo "<td class='hidden-xs'>$paspavadinimas</td>";
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
			}
		);
	</script>
<?php
	displayFooter();
