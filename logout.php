<?php 

	//Include functions file
	include 'functions.php';
	
	//Create an object of manageExamApplication to access the logoutApp function
	$appFuns = new manageExamApplication;	
	
	//Logout the app by calling the logoutApp function
	$appFuns->logoutApp();

?>