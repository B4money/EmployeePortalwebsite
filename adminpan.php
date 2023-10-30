<?php
	error_reporting(E_ALL ^ E_NOTICE);
	require_once('config.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>
<?php include 'master.php';?>	
	<div class="container text-center">
		<h2>Admin Panel</h2>
		<p>Roles: Employee = 1 Manager = 2 Administrator = 3 </p>
		<h2>Update User Role ID</h2>
		<form class="padding-top" method="post">
			<div class="form-group">
				<label for="userID">User ID:</label>
				<input type="text" role="form" placeholder="Enter A User ID" id="userID" name="userID" required>
			</div>
			<div class="form-group">
				<label for="roleID">Role ID:</label>
				<input type="text" role="form" placeholder="Enter A Role ID" id="roleID" name="roleID" required>
			</div>
			<button type="submit" class="btn btn-primary" name="updateUser">Update Tables</button>
		</form>

		<h2>Remove User From Database by User ID</h2>
			<form class="padding-top" method="post">
				<div class="form-group">
					<label for="userIDD">User ID:</label>
					<input type="text" role="form" placeholder="Enter A User ID" id="userIDD" name="userIDD" required>
				</div>
				<button type="submit" class="btn btn-primary" name="deleteUser">Delete User</button>
			</form>
	</div>
</body>
</html>	

<?php
	if (isset($_SESSION['username'])) {
		$connString = "mysql:host=" . DBHOST . ";dbname=" . DBNAME;
		$pdo = new PDO($connString, DBUSER, DBPASS);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if (isset($_POST['updateUser'])) {
				$userID = $_POST['userID'];
				$roleID = $_POST['roleID'];
				
				# Update user_role table
				$sqlUserRole = "UPDATE user_role SET role_id = :roleID WHERE user_id = :userID";
				$stmtUserRole = $pdo->prepare($sqlUserRole);
				$stmtUserRole->bindParam(':roleID', $roleID);
				$stmtUserRole->bindParam(':userID', $userID);
				$stmtUserRole->execute();
				
				# Update tbluser table
				$sqlTblUser = "UPDATE tbluser SET role_id = :roleID WHERE user_id = :userID";
				$stmtTblUser = $pdo->prepare($sqlTblUser);
				$stmtTblUser->bindParam(':roleID', $roleID);
				$stmtTblUser->bindParam(':userID', $userID);
				$stmtTblUser->execute();
				
				echo "Tables updated successfully.";
				exit;
			} elseif (isset($_POST['deleteUser'])) {
				$userID = $_POST['userIDD'];

					# Delete from user_role table
				$sqlDeleteUserRole = "DELETE FROM user_role WHERE user_id = :userID";
				$stmtDeleteUserRole = $pdo->prepare($sqlDeleteUserRole);
				$stmtDeleteUserRole->bindParam(':userID', $userID);
				$stmtDeleteUserRole->execute();

				# Delete from tbluser table
				$sqlDeleteTblUser = "DELETE FROM tbluser WHERE user_id = :userID";
				$stmtDeleteTblUser = $pdo->prepare($sqlDeleteTblUser);
				$stmtDeleteTblUser->bindParam(':userID', $userID);
				$stmtDeleteTblUser->execute();


				echo "Rows deleted successfully.";
				exit;
			}
		}
	} else {
		header("Location: index.php");
		exit;
	}
?>