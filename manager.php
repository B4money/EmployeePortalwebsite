<?php
require_once 'config.php';
require 'master.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST["user_id"];

    try {
        // Create a PDO connection
        $connString = "mysql:host=" . DBHOST . ";dbname=" . DBNAME;
        $pdo = new PDO($connString, DBUSER, DBPASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Fetch the user details from the database
        $query = "SELECT * FROM tbluser WHERE user_id = :user_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            echo "User not found!";
            exit;
        }

        // Update the user data if submitted
        $email = !empty($_POST["email"]) ? $_POST["email"] : $user['email'];
        $pass = !empty($_POST["pass"]) ? md5($_POST["pass"]) : $user['pass'];
        $firstName = !empty($_POST["firstName"]) ? $_POST["firstName"] : $user['firstName'];
        $lastName = !empty($_POST["lastName"]) ? $_POST["lastName"] : $user['lastName'];
        $address = !empty($_POST["address"]) ? $_POST["address"] : $user['address'];
        $phone = !empty($_POST["phone"]) ? $_POST["phone"] : $user['phone'];
        $salary = !empty($_POST["salary"]) ? $_POST["salary"] : $user['salary'];
        $ssn = !empty($_POST["ssn"]) ? $_POST["ssn"] : $user['ssn'];

        $query = "UPDATE tbluser SET email = :email, pass = :pass, firstName = :firstName, 
                lastName = :lastName, address = :address, phone = :phone, 
                salary = :salary, ssn = :ssn WHERE user_id = :user_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':pass', $pass);
        $stmt->bindParam(':firstName', $firstName);
        $stmt->bindParam(':lastName', $lastName);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':salary', $salary);
        $stmt->bindParam(':ssn', $ssn);
        $stmt->bindParam(':user_id', $user_id);

        if ($stmt->execute()) {
            echo "User data updated successfully!";
        } else {
            echo "Error updating user data.";
        }

        // Close the database connection
        $pdo = null;
    } catch (PDOException $e) {
        echo "Database Error: " . $e->getMessage();
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Update User Data</title>
</head>
<body>
	<div class="container text-center">
    <h2>Udate User Data</h2>
    <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="user_id">Enter a User ID:</label>
        <input type="text" name="user_id" id="user_id" placeholder="Enter a User ID" required>
        <br><br>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" placeholder="Enter email" value="<?php echo isset($user) ? $user['email'] : ''; ?>">
        <br><br>
        <label for="pass">Password:</label>
        <input type="password" name="pass" id="pass" placeholder="Enter password">
        <br><br>
        <label for="firstName">First Name:</label>
        <input type="text" name="firstName" id="firstName" placeholder="Enter First Name" value="<?php echo isset($user) ? $user['firstName'] : ''; ?>">
        <br><br>
        <label for="lastName">Last Name:</label>
        <input type="text" name="lastName" id="lastName" placeholder="Enter Last Name" value="<?php echo isset($user) ? $user['lastName'] : ''; ?>">
        <br><br>
        <label for="address">Address:</label>
        <input type="text" name="address" id="address" placeholder="Enter address" value="<?php echo isset($user) ? $user['address'] : ''; ?>">
        <br><br>
        <label for="phone">Phone:</label>
        <input type="text" name="phone" id="phone" placeholder="Enter phone 10 digits" value="<?php echo isset($user) ? $user['phone'] : ''; ?>">
        <br><br>
        <label for="salary">Salary:</label>
        <input type="text" name="salary" id="salary" placeholder="Enter salary" value="<?php echo isset($user) ? $user['salary'] : ''; ?>">
        <br><br>
        <label for="ssn">SSN:</label>
        <input type="text" name="ssn" id="ssn" placeholder="Enter SSN 9 digits" value="<?php echo isset($user) ? $user['ssn'] : ''; ?>">
        <br><br>
		<button type="submit" class="btn btn-primary" name="Update User Data">Update User Data</button>
    </form>
	</div>
</body>
</html>
