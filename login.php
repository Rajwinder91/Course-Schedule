<?php 
	//Include header and functions file
	include 'header.php';
	include 'functions.php';
	
	//Create an object of manageExamApplication to access the LoginExamApp function
	$appFuns = new manageExamApplication;	

	//Check if it is the Login button
	if(isset($_POST['login']))
	{ 
	  $username = $_POST['username'];
	  $password = $_POST['password'];
		
	  //Call the LoginExamApp function to execute the login functionality
	  $appFuns->LoginExamApp($username, $password); 	 
	}
	if(isset($_SESSION['user_id']) && $_SESSION['user_id'] != '')
	{
		header("Location:index.php");	
	}
?>
<!------- Lofin Form --------->
<div class="container">
	<h1>Login</h1>
	<hr>
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
	  <div class="form-group row">
		<label class="col-sm-2 col-form-label">Login</label>
		<div class="col-sm-10">
		  <input type="text" class="form-control" name="username" placeholder="Username" required>
		</div>
	  </div>
	  <div class="form-group row">
		<label class="col-sm-2 col-form-label">Password</label>
		<div class="col-sm-10">
		  <input type="password" class="form-control" name="password" placeholder="Password" required>
		</div>
	  </div>
	  <div class="form-group row">
		<div class="col-sm-10">
		  <button type="submit" name="login" class="btn btn-primary">Login</button>
		</div>
	  </div>
	</form>
</div>