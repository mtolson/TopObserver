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
	        $dbh = database();
	        $user_id = $_GET['uid'];
	        $permission_id = '1';
	        $company_id= '15';
	        echo $user_id.'<br>';
	        echo $company_id.'<br>';
	        echo $permission_id.'<br>';
		        $stmt2=$dbh->prepare("INSERT INTO company_permissions (user_id, company_id, permission_id) VALUES(:user_id, :company_id, :permission_id);");
		       	$stmt2->bindParam(':user_id', $user_id);
				$stmt2->bindParam(':company_id', $company_id);
				$stmt2->bindParam(':permission_id', $permission_id);
		       	print_r($stmt2);
		       	$stmt2->execute();

	
?>
