<?php
	session_start();
	unset($_SESSION['user_fname']);
	unset($_SESSION['user_id']);
	if (isset($_POST['submit1'])){
		// $required_fields = array("email1", "password1");
		// validate_presences($required_fields);

		if(empty($errors)){

			$email = $_POST["email1"];
			$password = $_POST["password1"];

			$found_user = attempt_login($email, $password);

			if($found_user){
				$_SESSION['user_id'] = $found_user['0']['id'];
				$_SESSION['user_fname'] = $found_user['0']['fname'];
				header('Location: dashboard.php');
				die();
			} else {
				$_SESSION["message"] = "Email/Password failed.";
				header('Location: index.php');
			}
		}
	}else{
		$_SESSION["message"] = "Email/Password failed.";
		header('Location: index.php');
	}

	function find_user_by_email($email){
	    $user ="root";
    	$pass = "root";
		$dbh = new PDO('mysql:host=localhost;dbname=topobserver;port=8889',$user, $pass);

		$stmt = $dbh->prepare("SELECT * FROM user WHERE email = '{$email}' LIMIT 1");
		$stmt->execute();
		$result = $stmt->fetchall(PDO::FETCH_ASSOC);
		if ($result){
			return $result;
		}else{
		 return null;
		}
	}

	function attempt_login($email, $password){
		$user = find_user_by_email($email);
		if($user){
			if($password===$user['0']['password']){
				return $user;
			} else{
				return false;
			}
		}else{
			return false;
		}
	}
