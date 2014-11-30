<?php
	require_once '../connections.php';
	$conn = dbConnect();
	$OK = true; // We use this to verify the status of the update.
	// Create the query
	$data = trim($_GET['id']);
	$sql = 'SELECT * FROM courses_names';
	// we have to tell the PDO that we are going to send values to the query
	$stmt = $conn->prepare($sql);
	// Now we execute the query passing an array toe execute();
	$results = $stmt->execute(array($data));
	// Extract the values from $result
	$row = $stmt->fetchAll();
	$error = $stmt->errorInfo();
	//echo $error[2];
	echo json_encode($row);
?>