<?php
session_start();
session_destroy();

// Redirects users.
header("Location: index.php");