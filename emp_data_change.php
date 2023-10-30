<?php
	require_once 'config.php';
	require 'master.php';
	try {
		$connString = "mysql:host=" . DBHOST . ";dbname=" . DBNAME;
		$pdo = new PDO($connString, DBUSER, DBPASS);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		// Fetch the user details from the database
		if (isset($_SESSION['username'])) {
			$username = $_SESSION['username'];
			$query = "SELECT user_id, email, pass, address, phone FROM tbluser WHERE email = :username";
			$stmt = $pdo->prepare($query);
			$stmt->bindParam(':username', $username);
			$stmt->execute();

			$user = $stmt->fetch(PDO::FETCH_ASSOC);
			$user_id = $user['user_id'];

			// Update the user data if submitted
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$email = isset($_POST['email']) && $_POST['email'] !== '' ? $_POST['email'] : $user['email'];
				$pass = isset($_POST['pass']) && $_POST['pass'] !== '' ? md5($_POST['pass']) : $user['pass'];
				$address = isset($_POST['address']) && $_POST['address'] !== '' ? $_POST['address'] : $user['address'];
				$phone = isset($_POST['phone']) && $_POST['phone'] !== '' ? $_POST['phone'] : $user['phone'];

				$query = "UPDATE tbluser SET email = :email, pass = :pass, address = :address, phone = :phone WHERE user_id = :user_id";
				$stmt = $pdo->prepare($query);
				$stmt->bindParam(':email', $email);
				$stmt->bindParam(':pass', $pass);
				$stmt->bindParam(':address', $address);
				$stmt->bindParam(':phone', $phone);
				$stmt->bindParam(':user_id', $user_id);

				if ($stmt->execute()) {
					echo "<h2>User data updated successfully!</h2>";
					echo "<h1>you will now be logged out to update data!</h1>";
					header("refresh:5;url=logout.php");
					
				} else {
					echo "Error updating user data.";
				}
			}
		}

		// Close the database connection
		$pdo = null;
	} catch (PDOException $e) {
		echo "Database Error: " . $e->getMessage();
	}
	
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Data Manager</title>
</head>
<body>
<div class="container text-center">
    <h2>Update Profile Information or Change Password</h2>
       <form method="POST" action="emp_data_change.php">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" placeholder="Enter email"><br><br>

        <label for="pass">Password:</label>
        <input type="password" id="pass" name="pass" placeholder="Enter password"><br><br>

        <label for="address">Address:</label>
        <input type="text" id="address" name="address" placeholder="Enter address"><br><br>

        <label for="phone">Phone:</label>
        <input type="tel" id="phone" name="phone" placeholder="Enter phone number"><br><br>
        <button type="submit" class="btn btn-primary" name="Update">Update Profile / Password</button>
        
    </form>
</div>
</body>
</html>
