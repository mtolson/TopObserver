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
	$company_id = $_GET['id'];
	if(isset($_GET['cid'])){
		$cid=$_GET['cid'];
	}else{
		$cid = NULL;
	}
	if ($_SERVER['REQUEST_METHOD']=='POST'){
        if(isset($_POST['id'])){

	        $dbh = database();
	        $cid = $_POST['id'];
	        $date = $_POST['date'];
	        $burnrate = $_POST['burnrate'];
	        $revenue = $_POST['revenue'];
	        $visitors = $_POST['visitors'];
	        $funding = $_POST['funding'];
	        $stmt=$dbh->prepare("UPDATE company_data SET date='".$date."', burnrate='".$burnrate."',revenue='".$revenue."',visitors='".$visitors."',funding='".$funding."' WHERE id='".$cid."';");
	        $stmt->execute();
	        header('Location: editmetric.php?id='.$company_id.'');
	    }else{
	    	$dbh = database();
		    $company_id = $company_id;
	        $date = $_POST['date'];
	        $burnrate = $_POST['burnrate'];
	        $revenue = $_POST['revenue'];
	        $visitors = $_POST['visitors'];
	        $funding = $_POST['funding'];
	        $stmt=$dbh->prepare("INSERT INTO company_data (company_id, date, burnrate, revenue, visitors, funding) VALUES(:company_id, :date, :burnrate, :revenue, :visitors, :funding);");
	        $stmt->bindParam(':company_id', $company_id);
	        $stmt->bindParam(':date', $date);
	        $stmt->bindParam(':burnrate', $burnrate);
	        $stmt->bindParam(':revenue', $revenue);
	        $stmt->bindParam(':visitors', $visitors);
	        $stmt->bindParam(':funding', $funding);
	        $stmt->execute();
	        header('Location: editmetric.php?id='.$company_id.'');
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
					<h3>Edit Metrics</h3>
				</div>
				<div class="col-md-2">
					<a href='company.php'class='btn btn-primary btn-sm r-float'>Back to Company</a>
				</div>

			</div>
			<div class="row">
				<div class="col-md-12">
					<img src="img/logos/<?php echo get_logo($company_id);?>" class ="border">
				</div>
			</div>
			<div class="row">
			    <div role="tabpanel" class="tab-pane col-md-12" id="editmetrics">
			    	<form action="editmetric.php?id=<?php echo $company_id?>" method="POST">
				    	<a href='editmetric.php?id=<?php echo $company_id?>&cid=new' type='button' class='btn btn-primary btn-sm r-float'>Add</a>
				    	<table class="table">
				    		<tr>
				    			<th>Date</th>
				    			<th>Burnrate</th>
				    			<th>Revenue</th>
				    			<th>Visitors</th>
				    			<th>Funding</th>
				    			<th>Edit</th>
				    		</tr>
				    		<?php echo add_metrics($company_id, $cid);?>
				    		<?php echo edit_metrics($company_id, $cid);?>
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
