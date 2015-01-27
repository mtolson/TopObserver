<?php
    session_start();
    $message="";
    if(isset($_SESSION['message']))
    {
        $message=$_SESSION['message'];
        unset($_SESSION['message']);
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
		            <span class="sr-only">Toggle navigations</span>
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
		            <li><a href="#sign-up">Sign Up</a></li>
		            <li style="padding-top:10px;">
		            	<form action="login.php" method="POST">
		            			<input type="text" name="email1" placeholder="email"/>
		            			<input type="password" name="password1" placeholder="password"/>
		            		<input type="submit" name="submit1" value="Login"/>

		            	</form> 
		            </li>
		          </ul>
		          
		        </div><!--/.nav-collapse -->
		      </div>
		    </nav>
		    <p style="color:red; text-align:center;"><?php echo $message?><p>
		</header>
		<div class="container-fluid">
			<div class="row btm-margin main">
				<div class="open col-md-12">
					
				</div>
				<div class="second col-md-12">
					<h1>Follow your Startup from the First Investment to the last</h1>
				</div>
			</div>
				<!-- <div class="row btm-margin hp-border">
					<div class="col-md-4">
						<a href="#" class="">
							<img src="img/portfolio-istock2.jpg" alt="" class="img-center img-responsive">
						</a>
					</div>
					<div class="col-md-4">
						<a href="#" class="">
							<img src="img/startup-istock2.jpg" alt="" class="img-center img-responsive">
						</a>
					</div>
					<div class="col-md-4">
						<a href="#reporting" class="">
							<div id="chart1" class="img-center" style="width:auto; height:300px;"></div>
						</a>
					</div>
				</div> -->
			

			<div id="portfolio" class="row btm-margin">
				<div class="col-md-12">
					<h2>Fresh Look on Managing Portfolio</h2>
				</div>
				<div class="col-md-8 col-md-offset-2">
					<p>No matter how many funds you manage, or how many investments they include, TopObserver keeps you in control. Analyze your funds' performance with high level metrics, and get quick get access to portfolio company information.</p>
				</div>
				<div class="col-md-12">
					<div class="l-img btm-margin">
						<img src="img/portfolio-istock2.jpg" class="img-center img-responsive border">
					</div>
				</div>
				<div class="col-md-2 col-md-offset-2">
					<h3 class="text-center">Control Cap Tables</h3>
				</div>
				<div class="col-md-2 col-md-offset-1">
					<a href="#sign-up" class="btn btn-primary">SIGN UP NOW ITS FREE</a>
				</div>
				<div class="col-md-2 col-md-offset-1">
					<h3 class="text-center">Track and Share Easily</h3>
				</div>
			</div>
			<div id="start-up" class="row btm-margin">
				<div class="col-md-12">
					<h2>Bright New Ideas to Managing your Startup</h2>
				</div>
				<div class="col-md-8 col-md-offset-2">
					<p>No more tedious spreadsheets, piecemeal powerpoints, or endless email chains. TopObserver gives you one place for everything and everyone. Organize your most important investment and performance data while keeping shareholders informed, all from a single online platform.</p>
				</div>
				<div class="col-md-12">
					<div class="l-img btm-margin">
						<img src="img/startup-istock2.jpg" class="img-center img-responsive border">
					</div>
				</div>
				<div class="col-md-2 col-md-offset-2">
					<h3 class="text-center">Manage Collaboratively</h3>
				</div>
				<div class="col-md-2 col-md-offset-1">
					<a href="#sign-up" class="btn btn-primary">SIGN UP NOW ITS FREE</a>
				</div>
				<div class="col-md-2 col-md-offset-1">
					<h3 class="text-center">Easy Company Intel</h3>
				</div>
			</div>
			<div id="reporting" class="row btm-margin">
				<div class="col-md-12">
					<h2>Easy Reporting</h2>
				</div>
				<div class="col-md-8 col-md-offset-2">
					<p>As your investments change, TopObserver calculates. Whether you're a founder, advisor, angel investor, incubator, venture capitalist, or limited partner, TopObserver tracks and manages all of your holdings, giving you a complete and comprehensive understanding of your portfolio's performance.</p>
				</div>
				<div class="col-md-12">
					<div class="btm-margin">
						<div id="chart2" class="img-center l-img" style="width:75%; height:457px;"></div>
					</div>
				</div>
				<div class="col-md-2 col-md-offset-2">
					<h3 class="text-center">Total Visibility</h3>
				</div>
				<div class="col-md-2 col-md-offset-1">
					<a href="#sign-up" class="btn btn-primary">SIGN UP NOW ITS FREE</a>
				</div>
				<div class="col-md-2 col-md-offset-1">
					<h3 class="text-center">Grows with You</h3>
				</div>
			</div>
			<div id="sign-up" class="row btm-margin">
				<div class="col-md-12">
					<h2>Sign Up for Free</h2>
				</div>
				<div class="col-md-6">
					<div class="l-img btm-margin">
						<img src="img/signup.png" class="img-center img-responsive">
					</div>
				</div>
				<div class="col-md-3 col-md-offset-1 register">
					<form action="adduser.php" method="POST">
						<label for="fname">First Name<span>*</span></label></br>
						<input type="text" name="fname" placeholder="First Name" id="fname" required/></br>
						<label for="lname">Last Name<span>*</span></label></br>
						<input type="text" name="lname" placeholder="Last Name" id="lname" required/></br>
						<label for="email">Email<span>*</span></label></br>
						<input type="email" name="email" placeholder="Email Address" id="email" required/></br>
						<label for="password">Password<span>*</span></label></br>
						<input type="password" name="password" placeholder="Password" id="password" required/></br>
						<p>* required</p>
						<input class="btn btn-primary"type="submit"/>
					</form>
				</div>
			</div>
		</div>



	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://code.highcharts.com/highcharts.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
	<script>
    $(function () { 
    $('#chart1').highcharts({
        credits: {
      		enabled: false
  		},
        chart: {
            type: 'line'
        },
        title: {
            text: 'Easy Reporting'
        },
        xAxis: {
            categories: ['Aug', 'Sep', 'Oct']
        },
        yAxis: {
            title: {
                text: 'Amount'
            }
        },
        series: [{
            name: 'Company 1',
            data: [2000,2345,5925]
        },{
            name: 'Company 2',
            data: [2200,2445,9925]
        }]
    });
});
    </script>
    <script>
    $(function () { 
    $('#chart2').highcharts({
        credits: {
      		enabled: false
  		},
        chart: {
            type: 'bar'
        },
        title: {
            text: 'Easy Reporting'
        },
        xAxis: {
            categories: ['Aug', 'Sep', 'Oct']
        },
        yAxis: {
            title: {
                text: 'Amount'
            }
        },
        series: [{
            name: 'Company 1',
            data: [2000,2345,5925]
        },{
            name: 'Company 2',
            data: [2200,2445,9925]
        }]
    });
});
    </script>
	</body>
</html>
	