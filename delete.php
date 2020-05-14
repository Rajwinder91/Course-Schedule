<?php 

	//Include functions file
	include 'functions.php';
	
	//Create an object of manageApplication to access the deleteUser function
	$appFuns = new manageExamApplication;	
	
	if(isset($_GET["id"])){
		//Call deleteUser function for deleting the user from database
		$appFuns->deleteUser($_GET["id"]);
	}

?>