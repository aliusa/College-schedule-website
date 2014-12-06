<?php
if (!defined('included')){
	//die('You cannot access this file directly!');
	require('../includes/config.php');
	header('Location: '.DIRADMIN);
}?>
<div id="menu">
	<div id="logo">
		<a href="<?=DIRADMIN?>"><span>Vilniaus<br/>Kooperacijos<br/>Kolegija</span></a>
	</div>
	
	<div id="navbar">
		<nav>
			<a href="<?=DIRADMIN?>schedule" id="schedule" title="tvarkaraštis" class="<?=($currentPage==='schedule')?'currentPage':'';?>" ></a>
			<a href="<?=DIRADMIN?>courses" id="courses" title="dalykai" rel="prefetch" class="<?=($currentPage==='courses')?'currentPage':'';?>" ></a>
			<a href="<?=DIRADMIN?>staff" id="staff" title="dėstytojai" rel="prefetch" class="<?=($currentPage==='staff')?'currentPage':'';?>" ></a>
			<a href="<?=DIRADMIN?>groups" id="groups" title="grupės" rel="prefetch" class="<?=($currentPage==='groups')?'currentPage':'';?>" ></a>
			<a href="<?=DIRADMIN?>charts" id="charts" title="statistika" rel="prefetch" class="<?=($currentPage==='charts')?'currentPage':'';?>" ></a>
			<a href="<?=DIRADMIN?>?logout" id="logout" title="išeiti" ></a>
		</nav>
	</div>
</div>