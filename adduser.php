<?php
	session_start();
	
	include("functions.php");

	$dbh = database();
	$fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
	$message = "";
    $stmt4=$dbh->prepare("SELECT fname, lname, email FROM user WHERE email='".$email."';");
    $stmt4->execute();
    $result = $stmt4->fetchall(PDO::FETCH_ASSOC);
    
    if (isset($result['0']['email'])){
    	$_SESSION["message"] = "This email is already in use.";
    	header('Location: index.php');
    }else{
		$stmt=$dbh->prepare("INSERT INTO user (fname, lname, email, password) VALUES(:fname, :lname, :email, :password);");
        $stmt->bindParam(':fname', $fname);
        $stmt->bindParam(':lname', $lname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        $new_user_id = $dbh->lastInsertId();
        $_SESSION['user_id'] = $new_user_id;
		$_SESSION['user_fname'] = $fname;
        

        $stmt2=$dbh->prepare("SELECT id, email, comp_id FROM temp_user WHERE email='".$email."';");
        $stmt2->execute();
	    $result2 = $stmt2->fetchall(PDO::FETCH_ASSOC);
	    
	    if (isset($result2['0']['email'])){
	    	foreach ($result2 as $info) {
	    		$id = $info['id'];
	    		$permission_id = 3;
	    		$company_id = $info['comp_id'];
	    		$stmt3=$dbh->prepare("INSERT INTO company_permissions (user_id, company_id, permission_id) VALUES(:user_id, :company_id, :permission_id);");
	        	$stmt3->bindParam(':user_id', $new_user_id);
				$stmt3->bindParam(':company_id', $company_id);
				$stmt3->bindParam(':permission_id', $permission_id);
				$stmt3->execute();
				$stmt5=$dbh->prepare("DELETE FROM temp_user WHERE id =".$id."");
				$stmt5->execute();
	    	}
			header('Location: dashboard.php?id='.$company_id.'');
		}else{
			header('Location: addcompany.php');
		}
		
	}

		