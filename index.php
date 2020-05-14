<?php 

	//Include header and functions file
	include 'header.php';
	include 'functions.php';
	
	//Unset the session errors variable
	unset($_SESSION['errorMsg']); 
	
	//Create an object of manageExamApplication to access the profListById function
	$appFuns = new manageExamApplication;	
	
	if(!isset($_SESSION['user_id']) && $_SESSION['user_id'] == '')
	{
		header("Location:login.php");	
	}else{
		$loggedInUserDetail = $appFuns->getUserById($_SESSION['user_id']);
	}
	$currFileName =  basename($_SERVER['SCRIPT_FILENAME']);
	$homepageHtml = '';
	
	if(!empty($loggedInUserDetail)){
		
		if($loggedInUserDetail["id_role"] == 1){		
			$homepageHtml .= '<h1>Admin</h1>';
			$homepageHtml .= '<ul>';
			$homepageHtml .= '<li><a href="logout.php">Logout</a></li>';
			$homepageHtml .= '<li><a href="courses.php">Courses List</a></li>';
			$homepageHtml .= '<li><a href="admin.php">Admin</a></li>';
			$homepageHtml .= '</ul>';
			$currFileName == 'index.php' ? $homepageHtml .= '<h2>Hello Welcome '.$loggedInUserDetail['prenom'].'</h2>' : '';		
		}else{		
			$homepageHtml .= '<h1>Professeur</h1>';
			$homepageHtml .= '<ul>';
			$homepageHtml .= '<li><a href="logout.php">Logout</a></li>';
			$homepageHtml .= '<li><a href="courses.php">Courses List</a></li>';
			$homepageHtml .= '</ul>';
			$currFileName == 'index.php' ? $homepageHtml .= '<h2>Hello Welcome '.$loggedInUserDetail['prenom'].'</h2>' : '';
		}
	}

?>
<div class="container">
	<?php echo $homepageHtml; ?>
</div>