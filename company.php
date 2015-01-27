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
				<div class="col-md-8 col-s-8 col-xs-12">
					<h3>Welcome, <?php echo $user_fname;?></h3>
				</div>
				<div class="col-md-4 page-btns">
					<?php echo admin_function($company_id, $user_id);?>
					
				</div>

			</div>
			<div class="row">
				<div class="col-md-3">
				</div>
				<div class="col-md-3 thumbnail">
					<img src="img/logos/<?php echo get_logo($company_id);?>" class ="border">
				</div>
				<div class="col-md-6">
					<?php echo company_funding($company_id);?>
				</div>
			</div>
			<div class="row">
				<div class="col-md-3">
					<div>
						<?php echo left_nav($user_id); ?>
					</div>
				</div>
				<div class="col-md-9 ">
					<div role="tabpanel">
				 		 <ul class="nav nav-tabs" role="tablist">
				    		<li role="presentation" class="active"><a href="#dashboard" aria-controls="dashboard" role="tab" data-toggle="tab">Dashboard</a></li>
				    		<li role="presentation"><a href="#captable" aria-controls="captable" role="tab" data-toggle="tab">Cap Table</a></li>
				  		</ul>
					  	<div class="tab-content">
						    <div role="tabpanel" class="tab-pane active" id="dashboard">
						    	<?php echo admin_edit($company_id, $user_id);?>
						    	<div id="chart2" class='col-md-12'></div>
						    	<div id="chart1" class='col-md-6'></div>
						    	<div id="chart3" class='col-md-6'></div>
						    </div>
						    <div role="tabpanel" class="tab-pane" id="captable">
						    	<h3><center>Coming soon</center></h3>
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
    <?php echo company_chart($company_id,'2','1') ?>
    <?php echo company_chart($company_id,'1','1') ?>
    <?php echo company_chart($company_id,'3','1') ?>

    
	</body>
</html>
