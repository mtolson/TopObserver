<?php
    session_start();
    unset($_SESSION['logged']);
    include("functions.php");
    $dbh = database();
    if ($_SERVER['REQUEST_METHOD']=='POST'){
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $stmt=$dbh->prepare("INSERT INTO user (fname, lname, email, password) VALUES(:fname, :lname, :email, :password);");
        $stmt->bindParam(':fname', $fname);
        $stmt->bindParam(':lname', $lname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        $_SESSION['logged'] = $dhb->prepare(mysql_insert_id())
        header('Location: dashboard.html');
        die();
    }else{
        die();
        header('Location: index.php');
    }

    // function password_encrypt($password){
    //     $hash_format = "$2y$10$";
    //     $salt_length = 22;
    //     $salt = generate_salt($salt_length);
    //     $hash = crypt($password, $format_and_salt);
    //     return $hash;
    // }

    // function generate_salt($length){
    //     $unique_random_string = md5(uniqid(mt_rand(),true));
    //     $base64_string = base64_encode(unique_random_string);
    //     $modified_base64_string = str_replace('+','.',$base64_string);
    //     $salt = substr($modifed_base64_string, 0, $length);
    //     return $salt;
    // }

    // function password_check($password, $existing_hash){
    //     $hash = crypt($password, $existing_hash);
    //     if ($hash === $exisiting_hash){
    //         return true;
    //     } else{
    //         return false;
    //     }
    // }
?>