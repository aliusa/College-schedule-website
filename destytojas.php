<?php
	require_once('connections.php');
	require('header.php');
	$currentPage = "destytojas";
	$args = isset($_GET['id']) ? ["Pridėti dėstytoją"=>"destytojas_prideti.php", "Pridėti tvarkaraščio įrašą"=>"tvarkarastis_prideti.php?des=".intval($_GET['id'])] : ["Pridėti dėstytoją"=>"destytojas_prideti.php"] ;
	displayHeader($currentPage, $args);

	if (@$_GET['id']) {
		$id = $_GET['id'];
		$row = selectComplex("
				SELECT a.id, CONCAT(a.vardas, ' ', a.pavarde) AS destytojas, a.elpastas
				FROM destytojas AS a
				WHERE id = '".$id."'
				LIMIT 1");
?>
	<div class="well well-lg">
		<table>
<?php
			$arr = headings("destytojas");
			echo "<tr><td><b>".$arr[0]."</b></td><td>".$row[0]['id']."</td></tr>"; //id
			echo "<tr><td><b>".$arr[1].' '.$arr[2]."</b></td><td>".$row[0]['destytojas']."</td></tr>"; //vardas pavardė
			echo "<tr><td><b>".$arr[3]."</b></td><td>".$row[0]['elpastas']."</td></tr>"; //elpaštas
?>
		</table>
		<a class="btn btn-primary" href="destytojas_redaguoti.php?id=<?=$id?>" role="button">Redaguoti</a>
	</div>









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
		

		echo '<table id="myTable" class="tablesorter table table-striped table-condensed table-responsive"><thead><tr>';
		$arrTvarkarastis = headings("tvarkarastis");
		//echo "<th>".$arrTvarkarastis[0]."</th>"; //id
		echo "<th>".$arrTvarkarastis[1]."</th>"; //diena
		echo "<th><span class='hidden-xs'>".$arrTvarkarastis[2]." - ".$arrTvarkarastis[3]."</span><span class='visible-xs'>Laikas</span></th>"; //pradžia
		//echo "<th>".$arrTvarkarastis[3]."</th>"; //pabaiga
		$pogrupis = ($arrTvarkarastis[5] === "0" ) ? null : " (".$arrTvarkarastis[5].")";
		echo "<th>".$arrTvarkarastis[4]."<span class='hidden-xs'>$pogrupis</span></th>"; //grupė
		//echo "<th>".$arrTvarkarastis[5]."</th>"; //pogrupis
		echo "<th>".$arrTvarkarastis[6]."</th>"; //dalykas
		//echo "<th>".$arrTvarkarastis[7]."</th>"; //dėstytojas
		echo "<th>".$arrTvarkarastis[8]."</th>"; //auditorija
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
			ORDER BY pavarde ASC, vardas ASC
			');

		echo '<table id="myTable" class="tablesorter table table-striped table-condensed table-responsive"><thead><tr>';

		// Lentelės antraštinės eilutės elementai.
		$arr = headings("destytojas");
		//echo "<th>".$arr[0]."</th>"; //id
		echo "<th>".$arr[1]."</th>"; //vardas
		echo "<th>".$arr[2]."</th>"; //pavardė 
		echo "<th class='hidden-xs'>".$arr[3]."</th>"; //email

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
			echo "<td class='hidden-xs'><a href='mailto:$elpastas?subject=Žinutė iš tvarkaraščio informacinės sistemos'>$elpastas</a></td>";
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
