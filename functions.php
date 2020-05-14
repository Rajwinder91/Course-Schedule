<?php 

Class manageExamApplication{
	
	/******* Start Admin and Professeur Commom Function ********/
	//Database Connection Function
	function dbConn () {
		
		//Database details
		$servername 	= "localhost";
		$databasename 	= "exam_php";
		$username 		= "root";
		$password 		= "";

		//Try Catch
		try 
		{
			$conn = new PDO("mysql:host=$servername;dbname=$databasename;charset=utf8", $username, $password);
			// set the PDO error mode to exception
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch(PDOException $e)
		{
			echo "Connection failed: " . $e->getMessage();
		}
		return $conn;		
	}
	
	//Login Function
	function loginExamApp($username, $password){
		
		//Call Connection function
		$conn = manageExamApplication::dbConn();
		
		//Try-Catch
		try
		{
			$stmt   = $conn->prepare("SELECT * FROM user WHERE login = :userName and password = :passWord LIMIT 1");
			$stmt->execute(array(':userName'=>$username, ':passWord' => $password));
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
		  
			//Check if record found in DB
			if($stmt->rowCount() > 0)
			{ 		  
				$_SESSION['user_id'] = $result['id'];
				header('location:index.php');			
		  
			}else{
			
				//Store ErrorMessages in session and refresh the page to show the error message.
				$_SESSION["errorMsg"] =  "Username and Password does not match";
				header("Refresh:0");
			}
		}
		catch(PDOException $e)
		{
		   $_SESSION["errorMsg"] =  $e->getMessage();
		}
	}
	
	//Fetch user record by user id
	function getUserById($userId){
				
		//Call Connection function
		$conn = manageExamApplication::dbConn();
		
		//Fetch user by Id from user table
		$query   	 = $conn->prepare("SELECT * FROM user WHERE id=:user_id");
		$selectUser  = $query->execute(["user_id" => $userId]);
		$result 	 = $query->fetch(PDO::FETCH_ASSOC);
		return $result;
	}
	
	//logoutApp Function
	function logoutApp(){
		
		//Start session
		session_start();
		//Destroy session
		session_destroy();
		//Redirect to login page
		header('Location: login.php');
		exit;
	}
	
	/******* End Admin and Professeur Commom Function ********/
	
	/******* Start Admin Function ********/
	
	//Fetch profsList from user table
	function profsList(){
		
		//Call Connection function
		$conn = manageExamApplication::dbConn();
		
		//Fetch all records from user table
		$query = $conn->prepare("SELECT id,prenom FROM user"); 
		$query->execute();
		
		//Intialize variable
		$profs = '';
		
		
		//Execute Loop
		while ($prof = $query->fetch()){
			$profs .= '<option value="'.$prof['id'].'">'.$prof['prenom'].'</option>';
		} 
		//Echo users list
		echo $profs;
	}
	
	//Fetch roomsList from room table
	function roomsList(){
		
		//Call Connection function
		$conn = manageExamApplication::dbConn();
		
		//Fetch all records from room table
		$query = $conn->prepare("SELECT id,description FROM room"); 
		$query->execute();
		
		//Intialize variable
		$rooms = '';
		
		
		//Execute Loop
		while ($room = $query->fetch()){
			$rooms .= '<option value="'.$room['id'].'">'.$room['description'].'</option>';
		} 
		//Echo rooms list
		echo $rooms;
	}
	
	//Fetch coursesList from course table
	function coursesList(){
		
		//Call Connection function
		$conn = manageExamApplication::dbConn();
		
		//Fetch all records from course table
		$query = $conn->prepare("SELECT id,description FROM course"); 
		$query->execute();
		
		//Intialize variable
		$courses = '';
		
		
		//Execute Loop
		while ($course = $query->fetch()){
			$courses .= '<option value="'.$course['id'].'">'.$course['description'].'</option>';
		} 
		//Echo courses list
		echo $courses;
	}
	
	//Fetch monthsList from month table
	function monthsList(){
		
		//Call Connection function
		$conn = manageExamApplication::dbConn();
		
		//Fetch all records from month table
		$query = $conn->prepare("SELECT id,description FROM month"); 
		$query->execute();
		
		//Intialize variable
		$months = '';
		
		
		//Execute Loop
		while ($month = $query->fetch()){
			$months .= '<option value="'.$month['id'].'">'.$month['description'].'</option>';
		} 
		//Echo months list
		echo $months;
	}
	
	//Create new user in database
	function createUser($user){
		
		//Call Connection function
		$conn = manageExamApplication::dbConn();		
			
		$data = [
			'iduser' 	=> $user["prof"],
			'idcourse' 	=> $user["course"],
			'idroom' 	=> $user["room"],
			'idmonth' 	=> $user["month"]
		];
	  
		//Store porf record in database
		$query = $conn->prepare("INSERT INTO schedule (iduser, idcourse, idroom, idmonth) VALUES (:iduser, :idcourse, :idroom, :idmonth)");
	  
		$save = $query->execute($data);
		
		if($save){
			header('Location: admin.php');	
		}else{
			$_SESSION['errorMsg'] = "Something went wrong, Please contact with admin!!"; 
			header("Refresh:0");
		}
		
	}
	
	//Fetch adminProfsList from schedule and associated tables
	function adminProfsList($profId = '', $courseId = ''){
		
		//Call Connection function
		$conn = manageExamApplication::dbConn();
		
		//Fetch all records from schedule table
		$query = $conn->prepare("SELECT s.id as profId, p.prenom as profName, c.description as courseName, r.description as roomName, m.description as monthName FROM schedule as s , user as p, course as c, room as r, month as m where s.iduser = p.id and s.idcourse=c.id and s.idroom=r.id and s.idmonth = m.id"); 
		$query->execute();
		
		//Intialize variable
		$profsList = '';
		
		//Execute Loop	
		while ($prof = $query->fetch()){
			$profsList .= '<tr>';
			$profsList .= '<td>'.$prof['profName'].'</td>';
			$profsList .= '<td>'.$prof['courseName'].'</td>';
			$profsList .= '<td>'.$prof['roomName'].'</td>';
			$profsList .= '<td>'.$prof['monthName'].'</td>';
			$profsList .= '<td><a href="delete.php?id='. base64_encode ($prof['profId']).'">Remove</a></td>';
			$profsList .= '</tr>';
		} 
		//Echo profs list
		echo $profsList;
		
	}	
	
	//Delete User Function
	function deleteUser($userId){ 
		
		//Call Connection function
		$conn = manageExamApplication::dbConn();
		
		//Decode the Userid
		$userId = base64_decode($userId);
		
		
		$count = $conn->prepare("DELETE FROM schedule WHERE id=:id");
		$count->bindParam(":id",$userId,PDO::PARAM_INT);
		$delete = $count->execute();

		//If user deleted from database redirect to admin page
		if($delete){
			unset($_SESSION['errorMsg']);
			header('Location: admin.php');	
		}else{
			$_SESSION['errorMsg'] = "Something went wrong, Please contact with admin!!"; 
			header("Refresh:0");
		}
		
	}
	
	/******* End Admin Function ********/
	
	/******* Start Professeur Function ********/
	//Display Prof list function for Non-Admin users
	function nonAdminProfsList($profId = '', $courseId = ''){
		
		//Call Connection function
		$conn = manageExamApplication::dbConn();
		
		if(isset($profId) && $courseId == ''){ 
			$sql = 'SELECT s.id as profId, p.prenom as profName, c.description as courseName, r.description as roomName, m.description as monthName FROM schedule as s , user as p, course as c, room as r, month as m where s.iduser = p.id and s.idcourse=c.id and s.idroom=r.id and s.idmonth = m.id and s.iduser ='.$profId;
			
		}else if(isset($profId) && isset($courseId)){
			$sql = 'SELECT s.id as profId, p.prenom as profName, c.description as courseName, r.description as roomName, m.description as monthName FROM schedule as s , user as p, course as c, room as r, month as m where s.iduser = p.id and s.idcourse=c.id and s.idroom=r.id and s.idmonth = m.id and s.iduser ='.$profId.' and s.idcourse ='.$courseId;			
		}
		
		$query = $conn->prepare($sql); 
		$query->execute();
		
		//Intialize variable
		$profsList = '';
		
		//Execute Loop
		while ($prof = $query->fetch()){
			$profsList .= '<tr>';
			$profsList .= '<td>'.$prof['profName'].'</td>';
			$profsList .= '<td>'.$prof['courseName'].'</td>';
			$profsList .= '<td>'.$prof['roomName'].'</td>';
			$profsList .= '<td>'.$prof['monthName'].'</td>';
			$profsList .= '</tr>';
		} 
		//Echo profs list
		echo $profsList;
	}	
	
	/******* End Professeur Function ********/

}

?>