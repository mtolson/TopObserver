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
	$dbh = database();

	if ($_SERVER['REQUEST_METHOD']=='POST'){
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
        header('Location: company.php?id='.$company_id.'');
        die();
    }else{
        die();
        header('Location: index.php');
    }



