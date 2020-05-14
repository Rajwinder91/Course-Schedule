<?php 

	//Include index file
	include 'index.php';
	
	//Create an object of manageExamApplication to access the createUser and other associated functions
	$appFuns = new manageExamApplication;	

	if(isset($_POST['submit'])) {  
			
		//Call the createUser function to add new user in database
		$appFuns->createUser($_POST);
	}
	if($loggedInUserDetail["id_role"] != 1){
		
		header("Location:index.php");
	}
?>

<!------- Add schedule --------->
<div class="container">
	<h1>Add schedule</h1>		
	<hr>
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
	
		<div class="form-group row">
			<label class="col-sm-2 col-form-label">Prof</label>
			<div class="col-sm-10">
				<select class="form-control" name="prof">
				  <?php $appFuns->profsList(); ?>
				</select>
			</div>
		</div>
		
		<div class="form-group row">
			<label class="col-sm-2 col-form-label">Room</label>
			<div class="col-sm-10">
				<select class="form-control" name="room">				
				  <?php $appFuns->roomsList(); ?>
				</select>
			</div>
		</div>
		
		<div class="form-group row">
			<label class="col-sm-2 col-form-label">Course</label>
			<div class="col-sm-10">
				<select class="form-control" name="course">
				  <?php $appFuns->coursesList(); ?>
				</select>
			</div>
		</div>
		
		<div class="form-group row">
			<label class="col-sm-2 col-form-label">Month</label>
			<div class="col-sm-10">
				<select class="form-control" name="month">
				  <?php $appFuns->monthsList(); ?>
				</select>
			</div>
		</div>
		
		<div class="form-group row">
			<div class="col-sm-10">
			  <button type="submit" name="submit" class="btn btn-primary">Add</button>
			</div>
		</div>
	</form>
	
	<!------- Display Prof List --------->
	<h1> Profs List</h1>	
	<table> 
		<thead>
			<tr>
				<th>Prof</th>
				<th>Course</th>
				<th>Room</th>
				<th>Month</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
		<?php
			//Call the adminProfsList function to fetch all prof from database
			$appFuns->adminProfsList(); 
		?>
		</tbody>
	</table>
	<!------- Back button --------->
	<a href="index.php"><button class="btn btn-primary back-button">Back</button></a>
</div>
