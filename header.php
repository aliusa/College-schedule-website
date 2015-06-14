<?php
session_start();

/**
 * Encodes unique username and IP into md5 hash. 
 * @param string $userName Unique username.
 */
function setCookieHash($userName)
{
	/**
	* Get user IP.
	*/
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$ip = $_SERVER['REMOTE_ADDR'];
	}

	$cookiehash = md5($userName . $ip);

	return $cookiehash;
}

/**
 * Sets cookie.
 * @param string $userName Unique username for login.
 */
function setCookies($userName)
{
	try {
		$cookiehash = setCookieHash($userName);

		// Sets cookie for 1 year.
		//setcookie("uname", $cookiehash,time()+3600*24*365);
		return true;
	} catch (Exception $e) {
		die("Could not set cookies.");
	}
	
}


	function displayHeader($id ="" , $params = null)
	{
?>
<!DOCTYPE html>
<html>
	<head>
		<title>VKK Tvarkaraštis</title>

		<!-- jQuery-->
		<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
		<!--<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>-->
		<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>

		<!-- Bootstrap -->
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
		<!-- Optional theme -->
		<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">-->
		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- custom stylesheet, javascript -->
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<script type="text/javascript" src="js/js.js"></script>

		<!-- Table sorter -->
		<script type="text/javascript" src="js/jquery.tablesorter.min.js"></script>

		<!-- Bootstrap dropdown multiselect -->
		<script type="text/javascript" src="js/bootstrap-multiselect.js"></script>
		<link rel="stylesheet" href="css/bootstrap-multiselect.css" type="text/css"/>

		<!-- Bootstrap multidate picker -->
		<link rel="stylesheet" href="css/bootstrap-datepicker3.standalone.min.css">
		<script src="js/bootstrap-datepicker.min.js"></script>
		
		<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
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
          </ul>
<?php

		// Tikrina ar sesija neprasidėjus.
		if (isset($_SESSION['user_is_loggedin'])) {
?>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="destytojas.php?id=<?=$_SESSION['user_id']?>"><?=$_SESSION['user_pavarde']?></a></li>
            <li><a href="logout.php">išeiti</a></li>
          </ul>
<?php
		}
		echo "</div><!--/.nav-collapse --></div></nav>";
	}
//var_dump($_SESSION); // Debug


function displayFooter()
{
	echo "</div> <!-- /container --></body></html>";
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
	try {
		global $pdo;
		$sql = "SELECT * FROM $table WHERE id = $id LIMIT 1";
		$stmt = $pdo->query($sql);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row;
	} catch (Exception $e) {
		echo 'Caught exception: ',  $e->getMessage(), "\n";
		return false;
	}
}

/*function descripeTable($table)
{
	global $pdo;
	$q = $pdo->prepare("DESCRIBE $table");
	$q->execute();
	$table_fields = $q->fetchAll(PDO::FETCH_COLUMN);
	return $table_fields;
}/**/

function headings($a)
{
	if ($a === "tvarkarastis") return ['Nr',  'Diena', 'Pradžia', 'Pabaiga', 'Grupė', 'Pogrupis', 'Dalykas', 'Dėstytojas', 'Auditorija', 'Tipas', "Pasirenkamasis"];
	if ($a === "destytojas") return ['Nr', 'Vardas', 'Pavardė', 'El. paštas'];
	if ($a === "grupe") return ["Nr", "Pavadinimas", "El. paštas", "Studijų skyrius", "Studijų forma", "Studijų programa"];
}

function deleteItem($table, $id)
{
	global $pdo;
	$sql = "DELETE FROM $table WHERE id = $id";
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
}

// Data for SESSION
function selectSingleUserByUsername($username)
{
	global $pdo;
	$sql = "SELECT d.id, d.slaptazodis, d.teises, d.pavarde FROM destytojas d WHERE d.prisijungimas = ? LIMIT 1";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$username]);
	$item = $stmt->fetchAll();
	return $item;
}



