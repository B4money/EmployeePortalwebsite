<?php
	error_reporting(E_ALL ^ E_NOTICE);
	require_once('config.php');
	
	session_start();
	unset($_SESSION['username']);
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title> Login Page </title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>


<?php include 'master.php';?>

	<div class="container text-center">
		<h1>Welcome to the Login page</h1>
	
		<form class="padding-top" role="form" method="post" action="">
			
			<label for="email">Email Address</label>
			<input type="email" placeholder="Enter your Email" name="uname" id="username">
			<br>
			<label for="pwd">Password</label>
			<input type="password" placeholder="Enter your Password" name="pwd" id="pwd">
			<br>
			<button type="submit" class="btn btn-primary">Submit</button>
		</form>	
	</div>
		<?php 
			if (isset($_POST['uname']) && isset($_POST['pwd'])){
				try{
					# set up connection string reading from config.php
					$connString = "mysql:host=" . DBHOST . ";dbname=" . DBNAME;
					$pdo = new PDO($connString, DBUSER, DBPASS);
					$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

					# prepare the SQL call to find the user based on user input
					$sql = "SELECT email FROM tbluser WHERE email='" . $_POST['uname'] . "' and pass= MD5('" . $_POST['pwd'] . "')";
					$result = fetchUserId($pdo, $sql);

					# if there's a record...
					if ($result->rowCount() == 1){
						# success! user is in the database!
						echo "the user name retrieved from the session is: ";
						echo $_SESSION['username'];

						# set the session variable for the website
						$_SESSION['username'] = $_POST['uname'];

						# refresh the browser and redirect user to the profile page
						header("Refresh:0, url=\"profile.php\"");
					}
					else{
						echo "<br/> Email does not exist! Please register!";
					}
				}
				catch (PDOException $e){
					die($e->getMessage());
				}						
			}	
		?>		

<?php require_once 'footer.php';?>
</body>
</html>
