<?php 

	//Include index file
	include 'index.php';
	
	//Create an object of manageApplication to access the getUserById and createUser functions
	$appFuns = new manageExamApplication;	
	
	if(!isset($_SESSION['user_id']) && $_SESSION['user_id'] == '')
	{
		header("Location:login.php");	
	}else{
		$loggedInUserDetail = $appFuns->getUserById($_SESSION['user_id']);
	}
?>

<div class="container">
	<!------- Search by Course --------->
	<h1>Search by Course Name</h1>		
	<hr>
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
		
		<div class="form-group row">
			<label class="col-sm-2 col-form-label">Course</label>
			<div class="col-sm-10">
				<select class="form-control" name="course">
				  <?php $appFuns->coursesList(); ?>
				</select>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-10">
			  <button type="submit" name="search" class="btn btn-primary">Search</button>
			</div>
		</div>
	</form>
	
	<!------- Searched list by course --------->
	<h1> Courses List for <?php echo $loggedInUserDetail['prenom']?></h1>
	<table> 
		<thead>
			<tr>
				<th>Prof</th>
				<th>Course</th>
				<th>Room</th>
				<th>Month</th>
			</tr>
		</thead>
		<tbody> 		
			<?php
			
			if(isset($_POST['search'])){  
				
				//Call the createUser function to add new user in database
				$appFuns->nonAdminProfsList($_SESSION['user_id'],$_POST['course'] );
			}else{  //die('withoseaarch');
				
				//Call the usersList function to fetch all users from database
				$appFuns->nonAdminProfsList($_SESSION['user_id']); 
			}
			?>
		</tbody>
	</table>
	<!------- Back and All button --------->
	<a href="index.php"><button class="btn btn-primary back-button">Back</button></a>
	<a href="courses.php"><button class="btn btn-primary back-button">All</button></a>
</div>

