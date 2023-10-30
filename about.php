<?php
	error_reporting(E_ALL ^ E_NOTICE);
	require_once('config.php');	
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title> About Page </title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="http:maxcdn.bootstrapcdn.com/bootstrap3.3.6/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>
	<?php include 'master.php';?>
	
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h1>About Us</h1>
				<p>We are a company dedicated to providing innovative solutions to businesses. Our team of experts are highly experienced and passionate about their work. We are committed to delivering the best possible service to our clients and helping them achieve their goals.</p>
			</div>
		</div>
	</div>
	
	<?php include 'footer.php';?>
</body>
</html>