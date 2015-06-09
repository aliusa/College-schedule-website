<?php
	function displayHeader($id ="" , $params = null) {
?>
<!DOCTYPE html>
<html>
	<head>
		<title>VKK Tvarkaraštis</title>

		<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

		<!-- Optional theme -->
		<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">-->

		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link rel="stylesheet" type="text/css" href="style.css">


		
		<script type="text/javascript" src="js/jquery.tablesorter.min.js"></script>
		<script type="text/javascript" src="js/js.js"></script>
		<!-- Include the plugin's CSS and JS: -->
		<script type="text/javascript" src="js/bootstrap-multiselect.js"></script>
		<link rel="stylesheet" href="css/bootstrap-multiselect.css" type="text/css"/>
	</head>
	<body id="<?=$id?>">



	<div class="container">
<br>
    <!-- Fixed navbar -->
    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/">VKK</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="<?php echo ($id==='tvarkarastis')?'active':'';?>"><a href="tvarkarastis.php">Tvarkaraštis</a></li>
            <li class="<?=($id==='destytojas')?'active':'';?>"><a href="destytojas.php">Dėstytojai</a></li>
            <li class="<?=($id==='grupe')?'active':'';?>"><a href="grupe.php">Grupės</a></li>
<?php
			if ($params) {
?>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Funkcijos <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
<?php
				foreach ($params as $key => $value) {
					echo "<li><a href='$value'>$key</a></li>";
				}
			}
?>
              </ul>
            </li>
          </ul><!--
          <ul class="nav navbar-nav navbar-right">
            <li><a href="../navbar/">Default</a></li>
            <li><a href="../navbar-static-top/">Static top</a></li>
            <li class="active"><a href="./">Fixed top <span class="sr-only">(current)</span></a></li>
          </ul>-->
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    

	
<?php
	}






	function displayFooter() {
?>
	</div> <!-- /container -->
	</body>
</html>
<?php
	}



function selectBasicLimit($table)
{
	global $pdo;
	$sql = "SELECT * FROM $table LIMIT 1";
	$stmt = $pdo->query($sql);
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $rows;
}

function selectBasic($table)
{
	global $pdo;
	$sql = "SELECT * FROM $table";
	$stmt = $pdo->query($sql);
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $rows;
}

function selectComplex($sql, $params = [])
{
	global $pdo;
	$stmt = $pdo->query($sql);
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $rows;
}

function selectSingle($table, $id) {
	global $pdo;
	$sql = "SELECT * FROM $table WHERE id = $id LIMIT 1";
	$stmt = $pdo->query($sql);
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	return $row;
}

function descripeTable($table)
{
	global $pdo;
	$q = $pdo->prepare("DESCRIBE $table");
	$q->execute();
	$table_fields = $q->fetchAll(PDO::FETCH_COLUMN);
	return $table_fields;
}

function headings($a)
{
	if ($a === "tvarkarastis") return ['Nr',  'Diena', 'Pradžia', 'Pabaiga', 'Grupė', 'Pogrupis', 'Dalykas', 'Dėstytojas', 'Auditorija', 'Tipas', "Pasirenkamasis"];
	if ($a === "destytojas") return ['Nr', 'Vardas', 'Pavardė', 'El.paštas'];
	if ($a === "grupe") return ["Nr", "Pavadinimas", "El.paštas", "Studijų skyrius", "Studijų forma", "Studijų programa"];
}

function deleteItem($table, $id)
{
	global $pdo;
	$sql = "DELETE FROM $table WHERE id = $id";
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
}