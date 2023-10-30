
	<?php
	error_reporting(E_ALL ^ E_NOTICE);
	// Check if form was submitted
	require_once('config.php');		
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title> Upload Files Page </title>
	<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">	
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		
		<style>
		.container {
		max-width: 450px;
		}
		</style>
<?php include 'master.php';?>

<body>
	<div class="container mt-5">
		<div class="row">
			<div class="form-group col-md-8">
			    <form action="" method="POST" enctype="multipart/form-data"class="mb-3">
			        <h2 class="text-center mb-5">Upload Files</h2>
					<p class="text-center mb-5">
			            Select files to upload:
						<!-- Single File Upload -->
			            <!--<input type='file' name='file1' id='file1'>-->
					<div class="user-image mb-3 text-center">
						<div style="width: 100px; height: 100px; overflow: hidden; background: #cccccc; margin: 0 auto">
							<img src="..." class="figure-img img-fluid rounded" id="imgPlaceholder" alt="">
						 </div>
							 </div>
							  <div class="custom-file text-center">
								<!-- Multi-File Upload -->
								<br/>
								<input type="file" name="files[]" multiple class="custom-file-input" id="chooseFile">
								<label class="custom-file-label" for="chooseFile"></label>
								<button type='submit' value='Upload' name='submit'class="btn btn-primary btn-block mt-4">
								 Upload
								</button>
								<h2>Upload Results</h2>
								<?php
									if(isset($_POST['submit'])) {
										
										/* Single File Upload */
										//$files = $_FILES['file1'];
										
										/* Multi-File Upload */
										$files = $_FILES['files'];

										uploadFiles($files);
										
									}
									else {
										echo "No files selected.";
									}
								?>
							  </div>
							</form>
						</div>
					</div>
			        </p>
			    </form>
		    </div>		
		</div>
		<?php include 'footer.php';?>	    	
    </div>

</head>
</body>
</html>