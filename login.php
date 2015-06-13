<?php
	require_once('connections.php');
	require('header.php');
	$currentPage = "login";
	displayHeader($currentPage);

	if ( $_POST )
	{
		/**
		 * Druska.
		 * @var string
		 */
		$salt = 'kk^^kk$topkek$alius#';

		$userName = $_POST['uniquename'];
		$userPass = $_POST['password'];

		/**
		 * Užkoduojam įvestą slaptažodį su druska.
		 * @var string
		 */
		$result = md5($userPass . $salt);

		/**
		 * Gaunam naudotojo slaptžodžio hash.
		 * @var string
		 */
		$user = selectSingleUserByUsername($userName);

		// Tikrinam ar toks pat kaip ir įvestasis
		if ( ($user <> false) && ($user[0][1] === $result) )
		{
			$_SESSION['user_is_loggedin'] = true;
			$_SESSION['user_id'] = intval($user[0][0]);
			$_SESSION['user_role'] = intval($user[0][2]);

			// Įrašom slapuką.
			//setCookies($userName);

			/**
			 * 0 - tik žiūrėti
			 * 1 - pridėti/redaguoti/trinti savo tvarkaraštį, duomenis apie save
			 * 2 - redaguoti viską
			 */
		}
	}

	// Atvaizduojam prisijungimo langą, jei nėra prisijungęs.
	if ( !isset($_SESSION['user_is_loggedin']) )
	{
	?>
	<form class="form-signin" method="POST" action="<?=$_SERVER['PHP_SELF']?>">
		<h2 class="form-signin-heading">Prisijunkite</h2>
		<label for="inputuniquename" class="sr-only">prisijungimo vardas</label>
		<input type="text" id="inputuniquename" class="form-control" placeholder="prisijungimo vardas" required autofocus autocomplete="on" name="uniquename">
		<label for="inputPassword" class="sr-only">Slaptažodis</label>
		<input type="password" id="inputPassword" class="form-control" placeholder="slaptažodis" required name="password">
		<!--<div class="checkbox">
			<label>
				<input type="checkbox" value="remember-me" name="rememberme"> Prisiminti mane
			</label>
		</div>-->
		<button class="btn btn-lg btn-primary btn-block" type="submit">Prisijungti</button>
	</form>

<?php
	} else {
		// Jei prisijungęs - nukreipiam atgal į pagrindinį.
		header("Location: index.php");
	}
	displayFooter();
