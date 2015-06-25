<?php
	require_once('connections.php');
	require('header.php');
	$currentPage = "grupe";
	
	if (isset($_SESSION['user_is_loggedin']) && (@$_SESSION['user_role'] === 2) )
	{
		if (isset($_GET['id']))
		{
			$args = [
					"Pridėti grupę"=>"grupe_prideti.php",
					"Pridėti tvarkaraščio įrašą"=>"tvarkarastis_prideti.php?gru=".intval($_GET['id']),
					"Pridėti savo tvarkaraščio įrašą"=>"tvarkarastis_prideti.php?gru=".intval($_GET['id'])."&des=".$_SESSION['user_id']
					];
		} else
		{
			$args = ["Pridėti grupę"=>"grupe_prideti.php"];
		}
	} elseif(@$_SESSION['user_role'] === 1)
	{
		if (isset($_GET['id']))
		{
			$args = ["Pridėti tvarkaraščio įrašą"=>"tvarkarastis_prideti.php?gru=".intval($_GET['id'])."&des=".$_SESSION['user_id']];
		}
	}
	$args = !isset($args) ? null : $args ;
	displayHeader($currentPage, $args);

	if (@$_GET['id']) {
		$id = intval($_GET['id']);
		if ( selectSingle("grupe", $id) === false ) die("Tokios grupės nėra.");
		$row = selectComplex("
				SELECT g.id gid, g.pavadinimas gpav, g.elpastas gelpastas, s.pavadinimas spav,
					f.pavadinimas fpav, st.pavadinimas stpav
				FROM grupe g
				LEFT JOIN skyrius s
				ON g.skyrius_id = s.id
				LEFT JOIN forma f
				ON g.forma_id = f.id
				LEFT JOIN studijos st
				ON g.studijos_id = st.id
				WHERE g.id = '".$id."'
				LIMIT 1");
?>
		<div class="well well-lg">
			<div class="row">
				<table>
<?php
					$arr = headings("grupe");
					$i=0;
					foreach ($row[0] as $key => $value) {
						echo "<tr><td><b>".$arr[$i]."</b></td><td>$value</td></tr>";
						$i++;
					}
?>
				</table>
			</div>
			<div class="row">
<?php
				if (isset($_SESSION['user_is_loggedin']) && (@$_SESSION['user_role'] === 2))
				{
?>
					<a class="btn btn-primary" href="grupe_redaguoti.php?id=<?=$id?>" role="button">Redaguoti</a>
<?php
				}
?>
				<div class="col-xs-8 col-sm-4 col-md-4 col-lg-4">
					<input type="search" id="search" value="" class="form-control" placeholder="Ieškoti mišriu būdu!">
				</div>
			</div>
		</div>



<?php
// Visi įrašai iš pasirinktos grupės
		try {
			// Visi vienos grupės įrašai su data didesne už šiandien.
			$rows = selectComplex("
				SELECT tv.id tvid, tv.diena tvdiena, tv.pogrupis,
					pr.laikas prlaikas,
					pa.laikas palaikas,
					gr.pavadinimas grpavadinimas, gr.id grid,
					da.pavadinimas dapavadinimas, da.id daid,
					CONCAT(de.vardas, ' ', de.pavarde) destytojas, de.id deid,
					au.pavadinimas aupavadinimas,
					pas.pavadinimas paspavadinimas,
					tv.pasirenkamasis
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
				WHERE tv.grupe_id = ".$id." AND tv.diena <> NOW()
				ORDER BY tv.diena ASC, prlaikas ASC, palaikas ASC
				");
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
		

		echo '<table id="myTable" class="tablesorter table table-striped table-condensed table-responsive table-hover"><thead><tr>';
		$arrTvarkarastis = headings("tvarkarastis");
		//echo "<th>".$arrTvarkarastis[0]."</th>"; //id
		echo "<th>".$arrTvarkarastis[1]."</th>"; //diena
		echo "<th><span class='hidden-xs'>".$arrTvarkarastis[2]." - ".$arrTvarkarastis[3]."</span><span class='visible-xs'>Laikas</span></th>"; //pradžia
		//echo "<th>".$arrTvarkarastis[3]."</th>"; //pabaiga
		//echo "<th>".$arrTvarkarastis[4]."</th>"; //grupė
		//echo "<th>".$arrTvarkarastis[5]."</th>"; //pogrupis
		echo "<th>".$arrTvarkarastis[6]."</th>"; //dalykas
		echo "<th class='hidden-xs'>".$arrTvarkarastis[7]."</th>"; //dėstytojas
		echo "<th><span class='hidden-xs'>".$arrTvarkarastis[8]."</span><span class='visible-xs'>Aud.</span></th>"; //auditorija
		echo "<th class='hidden-xs'>".$arrTvarkarastis[9]."</th>"; //paskaitos tipas
		//echo "<th>".$arrTvarkarastis[10]."</th>"; //pasirenkamasis
		echo "</tr></thead><tbody>";

		foreach ($rows as $key => $value) {
			echo "<tr onclick=\"window.document.location='tvarkarastis.php?id=".$value['tvid']."';\">";
			echo "<td>".date('m/d', strtotime($value['tvdiena']))."</td>";
			echo "<td>".date('H:i', strtotime($value['prlaikas']))." - ".date('H:i', strtotime($value['palaikas']))."</td>";
			//echo "<td>".date('H:i', strtotime($value['palaikas']))."</td>";
			$pogrupis = ($value['pogrupis'] === "0") ? null : " (".$value['pogrupis']." pogrupis)" ;
			$pasirenkamasis = ($value['pasirenkamasis'] === "0") ? null :  " (pasirenkamasis)";
			$paskaitosTipas = (strtolower($value['paspavadinimas']) === "paskaita") ? null : "<span class='visible-xs'> (".$value['paspavadinimas'].")</span>" ;
			echo "<td>".$value['dapavadinimas']."$pogrupis$pasirenkamasis$paskaitosTipas</td>";
			echo "<td class='hidden-xs'><a href='destytojas.php?id=".$value['deid']."'>".$value['destytojas']."</a></td>";
			echo "<td>".$value['aupavadinimas']."</td>";
			echo "<td class='hidden-xs'>".$value['paspavadinimas']."</td>"; //paskaitos tipas
			echo "</tr>";
		}

		echo "</tbody></table>";





 // Visos grupės
	} elseif (selectBasicLimit("grupe") === 0) {
			echo "nėra įrašų";
	} else {
		$rows = selectComplex('
			SELECT g.id gid, g.pavadinimas gpav, g.elpastas gelpastas, s.pavadinimas spav,
				f.pavadinimas fpav, st.pavadinimas stpav
			FROM grupe g
			LEFT JOIN skyrius s
			ON g.skyrius_id = s.id
			LEFT JOIN forma f
			ON g.forma_id = f.id
			LEFT JOIN studijos st
			ON g.studijos_id = st.id
			ORDER BY spav DESC, fpav DESC, gpav ASC
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
		$arr = headings("grupe");
		//echo "<th>".$arr[0]."</th>"; //id
		echo "<th>".$arr[1]."</th>"; //pavadinimas
		// Atvaizduoja eilutę, jei prisiloginęs.
		if (isset($_SESSION['user_is_loggedin']))
		{
			echo "<th class='hidden-xs'>".$arr[2]."</th>"; //el.paštas
		}
		echo "<th>".$arr[3]."</th>"; //studijų skyrius
		echo "<th>".$arr[4]."</th>"; //studijų forma
		echo "<th>".$arr[5]."</th>"; //studijų programa

		echo "</tr></thead><tbody>";

		foreach ($rows as $key => $value) {
			$gid = $rows[$key]['gid'];
			$gpav = $rows[$key]['gpav'];
			$gelpastas = ($rows[$key]['gelpastas'] <> null) ? $rows[$key]['gelpastas'] : null;
			$spav = $rows[$key]['spav'];
			$fpav = $rows[$key]['fpav'];
			$stpav = $rows[$key]['stpav'];

			echo "<tr onclick=\"window.document.location='grupe.php?id=".$gid."';\">";
			//echo "<td><a href='grupe.php?id=$gid'>$gid</a></td>";
			echo "<td>$gpav</td>";
			if (isset($_SESSION['user_is_loggedin']))
			{
				echo "<td class='hidden-xs'><a href='mailto:$gelpastas?subject=Žinutė iš tvarkaraščio informacinės sistemos'>$gelpastas</a></td>";
			}
			echo "<td>$spav</td>"; //studijų skyrius
			echo "<td>$fpav</td>"; //studijų forma
			echo "<td>$stpav</td>"; //studijų programa
			echo "</tr>\n\n";
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
