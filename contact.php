<?php
	error_reporting(E_ALL ^ E_NOTICE);
	require_once'config.php';
$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data using POST method
    $name = $_POST["name"];
    $email = $_POST["email"];
    $text_message = $_POST["message"];

	
	try{
		# set up connection string reading from config.php
		$connString = "mysql:host=" . DBHOST . ";dbname=" . DBNAME;
		$pdo = new PDO($connString, DBUSER, DBPASS);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		// Insert data into database using prepared statements
        $stmt = $pdo->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $text_message]);
        // Set the message content
        $message = "Submitted!";
        // Redirect to index.php
        header("Location: contact.php");
        exit();
    } catch (PDOException $e) {
        $message = "Failed to send message. Please try again later.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Contact Us</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap3.3.6/css/bootstrap.min.css">
	<script src="https//ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	<script src="http//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>
<?php include 'master.php';?>

<div class="container">
  <div class="row">
    <div class="col-sm-8">
      <h2>Contact Us</h2>
      <p>Feel free to send us a message or give us a call at (555) 555-5555.</p>
      <form action="#" method="post">
        <div class="form-group">
          <label for="name">Name:</label>
          <input type="text" class="form-control" id="name" placeholder="Enter name" name="name">
        </div>
        <div class="form-group">
          <label for="email">Email:</label>
          <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
        </div>
        <div class="form-group">
          <label for="message">Message:</label>
          <textarea class="form-control" rows="5" id="message" name="message"></textarea>
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
      </form>
    </div>
    <div class="col-sm-4">
      <h2>Our Location</h2>
      <p>1234 Main Street, Anytown, USA</p>
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3381.1533081579056!2d-118.42201838497219!3d33.995047380633925!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80c2c6364e4a466f%3A0x4089cbad786a8766!2sAnytown%2C%20USA!5e0!3m2!1sen!2sca!4v1650700350073!5m2!1sen!2sca" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
    </div>
  </div>
</div>

<?php include 'footer.php';?>
</body>
</html>
