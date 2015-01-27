<?php 
	session_start();
	if(!isset($_SESSION['user_id'])){
		$message = $_SESSION["message"];
		unset($_SESSION['message']);
		$_SESSION['message'] = "Please Login";
		header("Location: index.php");
	}
	$message = "";
	if (isset($_SESSION["message"])){
		$message = $_SESSION["message"];
		unset($_SESSION['message']);
	}
	include("functions.php");
    $user_fname=$_SESSION['user_fname'];
    $user_id=$_SESSION['user_id'];
	$company_id = $_GET['id'];
	
	if(isset($_GET['cid'])){
		$cid=$_GET['cid'];
	}else{
		$cid = NULL;
	}
	
	if ($_SERVER['REQUEST_METHOD']=='POST'){
        if(isset($_POST['user_id'])){
	        $dbh = database();
	        $user_id = $_POST['user_id'];
	        $fname = $_POST['fname'];
	        $lname = $_POST['lname'];
	        $email = $_POST['email'];
	        $role = $_POST['role'];
	        $cp_id = $_POST['id'];
	        $stmt=$dbh->prepare("UPDATE user u SET u.fname = '".$fname."', u.lname = '".$lname."', u.email = '".$email."'where u.id =".$user_id.";");
	        $stmt->execute();
	        $stmt2=$dbh->prepare("UPDATE company_permissions SET permission_id=".$role." where id =".$cp_id.";");
	        $stmt2->execute();
	        header('Location: admin.php?id='.$company_id.'');
	    }elseif(isset($_GET['add'])){
	    	$dbh = database();
	        $email1 = $_POST['email'];
	        $stmt=$dbh->prepare("SELECT fname, lname, email, id FROM user WHERE email='".$email1."';");
	        $stmt->execute();
	        $result = $stmt->fetchall(PDO::FETCH_ASSOC);
	        if (isset($result['0']['email'])){
	        	$permission_id = 3;
	        	$id=$result['0']['id'];
	        	$dbh = database();
	        	$stmt=$dbh->prepare("INSERT INTO company_permissions (user_id, company_id, permission_id) VALUES(:user_id, :company_id, :permission_id);");
	        	$stmt->bindParam(':user_id', $id);
				$stmt->bindParam(':company_id', $company_id);
				$stmt->bindParam(':permission_id', $permission_id);
				$stmt->execute();
				header('Location: admin.php?id='.$company_id.'');
	        }else{
	        	$dbh = database();
	        	$email = $_POST['email'];
	        	$stmt=$dbh->prepare("INSERT INTO temp_user (email, comp_id) VALUES(:email, :company_id);");
	        	$stmt->bindParam(':email', $email);
				$stmt->bindParam(':company_id', $company_id);
				$stmt->execute();
				$_SESSION["message"] = "No Email found. When user signs up with that email they will have view access.";
				header('Location: admin.php?id='.$company_id.'');
	        }
	    }
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
					<h3>Edit/Add Users</h3>
				</div>
				<div class="col-md-2">
					<a href='company.php?id=<?php echo $company_id?>'class='btn btn-primary btn-sm r-float'>Back to Company</a>
				</div>

			</div>
			<div class="row">
				<div class="col-md-3 thumbnail">
					<img src="img/logos/<?php echo get_logo($company_id);?>" class ="border">
				</div>
			</div>
			<div class="row">
			    <p class="r-float"><?php echo $message?></p>
			    <div role="tabpanel" class="tab-pane col-md-12" id="editmetrics">
			    	<form action="admin.php?id=<?php echo $company_id?>&add=y" method="POST" class='r-float'>
			    		<input type='text' name='email' id='email' placeholder='email address'/>
			    		<input type='submit' class='btn btn-primary btn-sm' value='Add User'/>
			    	</form>
			    	<!-- a href='add.php?id=<?php echo $company_id?>&cid=new' type='button' class='btn btn-primary btn-sm r-float'>Add User</a> -->
			    	<form action="admin.php?id=<?php echo $company_id?>" method="POST">
				    	<table class="table">
				    		<tr>
				    			<th>First Name</th>
				    			<th>Last Name</th>
				    			<th>Email</th>
				    			<th>Access</th>
				    		</tr>
				    		<?php echo edit_users($company_id, $cid);?>
				    	</table>
				    </form>
			    </div>
			</div>
					  	

					  	</div>
					</div>
				</div>
			</div>
		</div>
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://code.highcharts.com/highcharts.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    
	</body>
</html>
