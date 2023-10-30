<?php
	error_reporting(E_ALL ^ E_NOTICE);
?>	

<!DOCTYPE html>
<html lang="en">
<head>
	<title> Home Page </title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>
	<?php require_once 'config.php';?>
	<?php require_once 'master.php';?>

	<div class="container text-center">
		<?php 
			try {
				$connString = "mysql:host=" . DBHOST . ";dbname=" . DBNAME;
				$pdo = new PDO($connString, DBUSER, DBPASS);
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			} catch (PDOException $e) {
				echo "Database connection failed: " . $e->getMessage();
			}
			if(isset($_SESSION['username'])) {
				$username = $_SESSION['username'];
				$query = "SELECT firstName FROM tbluser WHERE email = :username";
				$stmt = $pdo->prepare($query);
				$stmt->bindParam(':username', $username, PDO::PARAM_STR);
				$stmt->execute();

				if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					echo "<h1>Welcome to the Employee Home Page, ". $row['firstName']."</h1>";
				}
			} else {
				echo "<h1>Welcome to the Home Page</h1>";
				echo "<h3>Please login or register</h3>";
			}
		?>
	</div>
	
	<?php require_once 'footer.php';?>
</body>
</html>
