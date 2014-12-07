<?php

if (!defined('included')){
	die('You cannot access this file directly!');
}

function login($user, $pass){

   //strip all tags from varible   
   $user = strip_tags(mysql_real_escape_string($user));
   $pass = strip_tags(mysql_real_escape_string($pass));

   $pass = md5($pass);

   // check if the user id and password combination exist in database
   $sql = "SELECT * FROM logins WHERE s_login = '$user' AND s_pass = '$pass'";
   $result = mysql_query($sql) or die('Query failed. ' . mysql_error());
      
   if (mysql_num_rows($result) == 1) {
      // the username and password match,
      // set the session
	  $_SESSION['authorized'] = true;
					  
	  // direct to admin
      header('Location: '.DIRADMIN);
	  exit();
   } else {
	// define an error message
	$_SESSION['error'] = 'Sorry, wrong username or password';
   }
}

// Authentication
function logged_in() {
	if(@$_SESSION['authorized'] == true) {
		return true;
	} else {
		return false;
	}	
}

function login_required() {
	if(logged_in()) {	
		return true;
	} else {
		header('Location: '.DIRADMIN.'login');
		exit();
	}	
}

function logout(){
	unset($_SESSION['authorized']);
	header('Location: '.DIRADMIN.'login');
	exit();
}

// Render error messages
function messages() {
    $message = '';
    if(@$_SESSION['success'] != '') {
        $message = '<div class="msg-ok">'.$_SESSION['success'].'</div>';
        $_SESSION['success'] = '';
    }
    if(@$_SESSION['error'] != '') {
        $message = '<div class="msg-error">'.$_SESSION['error'].'</div>';
        $_SESSION['error'] = '';
    }
    echo "$message";
}

function errors($error){
	if (!empty($error))
	{
			$i = 0;
			while ($i < count($error)){
			$showError.= "<div class=\"msg-error\">".$error[$i]."</div>";
			$i ++;}
			echo $showError;
	}// close if empty errors
} // close function


/***********************************************/
class Staff{
	public function fetch_all() {
		global $pdo;
		$query = $pdo->prepare("
			SELECT * FROM staff ORDER BY staff_lastName");
		$query->execute();
		return $query->fetchall();
	}
}



?>