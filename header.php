<html>
	<head>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"	crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="style.css" />
		<meta charset="utf-8">
	</head>
	<body>
	
	<?php 
	session_start();
	//print_r($_SESSION);

	//Display Error messages
	$errMsg = '';
	if(isset($_SESSION['errorMsg'])){
		$errMsg .= '<div class="alert alert-danger" role="alert">';
		$errMsg .=  $_SESSION['errorMsg'];
		$errMsg .= '</div>';
	}
	echo $errMsg;
	?>
	