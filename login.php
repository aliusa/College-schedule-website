<?php
	require_once('connections.php');
	require('header.php');
	$currentPage = "index";
	displayHeader($currentPage);

	?>
	<form class="form-signin">
		<h2 class="form-signin-heading">Prisijunkite</h2>
		<label for="inputEmail" class="sr-only">El. paštas</label>
		<input type="email" id="inputEmail" class="form-control" placeholder="el. paštas" required autofocus>
		<label for="inputPassword" class="sr-only">Slaptažodis</label>
		<input type="password" id="inputPassword" class="form-control" placeholder="slaptažodis" required>
		<div class="checkbox">
			<label>
				<input type="checkbox" value="remember-me"> Prisiminti mane
			</label>
		</div>
		<button class="btn btn-lg btn-primary btn-block" type="submit">Prisijungti</button>
	</form>

<?php
	displayFooter();
