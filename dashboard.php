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
		            <li><a href="logout.php">Log Out</a></li>
		          </ul>
		        </div><!--/.nav-collapse -->
		      </div>
		    </nav>
		</header>
		<div class="container-fluid">
			<div>
				<h3>Welcome, <?php echo $user_fname;?> </h3>
			</div>
			<div class="row">
				<div class="col-md-3">
				</div>
			</div>
			<div class="row">
				<div class="col-md-3">
					<div>
						<?php echo left_nav($user_id); ?>
					</div>
				</div>
				<div class="col-md-9">
					<div class="row">
						<?php echo thumbnails($user_id)?>
					</div>
				</div>
			</div>
		</div>
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://code.highcharts.com/highcharts.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
	<?php echo dashboard_revenue($user_id)?>

    <script>
    $(function () {
    $('#chart4').highcharts({
        credits: {
      		enabled: false
  		},
        chart: {
            backgroundColor:null,
            plotBackgroundColor: null,
            plotBorderWidth: 1,//null,
            plotShadow: false
        },
        title: {
            text: false
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
            type: 'pie',
            name: 'Browser share',
            data: [
                ['TopObserver',   10000],
                ['3DLT',       30000],
                ['Tixers',   10000]
            ]
        }]
    });
});

     </script>
	</body>
</html>
