<?php 
	session_start();
	if(!isset($_SESSION['user_id'])){
		unset($_SESSION['message']);
		$_SESSION['message'] = "Please Login";
		header("Location: index.php");
	}
	include("functions.php");
    $user_fname=$_SESSION['user_fname'];
    $user_id=$_SESSION['user_id'];
	
	try{
		if ($_SERVER['REQUEST_METHOD']=='POST'){
        	$uploaddir = './img/logos/'; 
			$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
			if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
			  $img = $_FILES['userfile']['name'];
			} else {
			  echo "File did not upload.";
			}

	        $dbh = database();
	        $user_id = $_GET['uid'];
	        $company = $_POST['company'];
	        $website = $_POST['website'];
	        $phone = $_POST['phone'];
	        $permission_id = '1';
	        $stmt=$dbh->prepare("INSERT INTO company (company, website, phone, logo) VALUES(:company, :website, :phone, :img);");
	        $stmt->bindParam(':company', $company);
			$stmt->bindParam(':website', $website);
			$stmt->bindParam(':phone', $phone);
			$stmt->bindParam(':img', $img);
	        $stmt->execute();
	        $company_id = $dbh->lastInsertId();
	        if(isset($company_id)){
		        $stmt2=$dbh->prepare("INSERT INTO company_permissions (user_id, company_id, permission_id) VALUES(:user_id, :company_id, :permission_id);");
		       	$stmt2->bindParam(':user_id', $user_id);
				$stmt2->bindParam(':company_id', $company_id);
				$stmt2->bindParam(':permission_id', $permission_id);
		       	$stmt2->execute();
	       }
	       	header('Location: dashboard.php');
	    }
	}catch(Exception $e){
		echo $e->getMessage();
	}
?>
<html>
	<head>
		<meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
		<title>TopObserver</title>
		<link href="css/bootstrap.css" rel="stylesheet">
		<link href="css/main.css" rel="stylesheet">

	</head>

	<body class="container-fluid">

		<header>
			<nav class="navbar navbar-inverse" role="navigation">
		      <div class="container-fluid">
		        <div class="navbar-header">
		          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
		            <span class="sr-only">Toggle navigation</span>
		            <span class="icon-bar"></span>
		            <span class="icon-bar"></span>
		            <span class="icon-bar"></span>
		          </button>
		          <a class="navbar-brand" href="#">
		          	<img class="nav-logo"alt="TopObserver" src="img/TopObserver.png">
		          </a>
		        </div>
		        <div id="navbar" class="collapse navbar-right navbar-collapse">
		          <ul class="nav navbar-nav">
		            <li><a href="index.php">Log Out</a></li>
		          </ul>
		        </div><!--/.nav-collapse -->
		      </div>
		    </nav>
		</header>
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-10 col-s-10 col-xs-12">
					<h3>Add Company</h3>
				</div>
				<div class="col-lg-12">
					<form enctype="multipart/form-data" action="addcompany.php?uid=<?php echo $user_id?>" method="POST">
						<label>Company</label><br><input type="text" name="company" id="compnay"><br>
						<label>Website:</label><br><input type="text" name="website" id="website"><br>
						<label>phone:</label><br><input type="text" name="phone" id="phone"><br>
						<label>File to upload:</label><input name="userfile" type="file" /><br>
						<input type="submit" value="Add" class="btn btn-primary"/>
					</form>
				</div>
			</div>
		</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://code.highcharts.com/highcharts.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
	</body>
</html>








