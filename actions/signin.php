<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../connections.php";
require_once "../database/signin.php";
date_default_timezone_set("Asia/Manila");
$dbUser = new SignIn();
if(isset($_POST["userLogin"])){
    $userEmail = $_POST["userEmail"];
    $userPassword = $_POST["userPassword"];
    $rememberMeCheckBox = false;
    if(isset($_POST["rememberMeCheckBox"])){
        $rememberMeCheckBox = true;
        setcookie ("user_email_login",$userEmail,time()+ (10 * 365 * 24 * 60 * 60),"/","", 0);  
        setcookie ("user_password_login",$userPassword,time()+ (10 * 365 * 24 * 60 * 60),"/","", 0);
    }
    else{

        if(isset($_COOKIE["user_email_login"])){ 
            setcookie ("user_email_login","",time()+ (10 * 365 * 24 * 60 * 60),"/","", 0);  
        }  
        if(isset($_COOKIE["user_password_login"]))   
        {  
            setcookie ("user_password_login","",time()+ (10 * 365 * 24 * 60 * 60),"/","", 0);  
        }
    }
    $data = $dbUser->getUserEmail($userEmail);
    $userEmailVer = "";
    $userPasswordVer = "";
    $userAccountStatus = 0;
    foreach($data as $row){
        $userId = $row["user_id"];
        $userEmailVer = $row["user_email"];
        $userPasswordVer = $row["user_password"];

    }
    if($userEmail != ""){
        if($userEmail === $userEmailVer){
            if(password_verify($userPassword,$userPasswordVer)){
                echo "active";
                $_SESSION["loginuser"] = $userId;
            }
            else{
                echo "wrong user or password";
                //echo "<script> alert('wrong user!');</script>";
                //echo '<script> window.location.href = "../user/signin.php"</script>';
            }
        }
        else{
            echo "wrong user or password";
            //echo "<script> alert('wrong user!');</script>";
            //echo '<script> window.location.href = "../user/signin.php"</script>';
        }
    }
    else{
        echo "wrong user or password";
    }

}
if(isset($_POST["getUserIdByEmail"])){
    $userEmail = $_POST["userEmail"];
    $data = $dbUser->getUserIdByEmail($userEmail);
    $userId = 0;
    foreach($data as $row){
        $userId = $row["user_id"];
    }
    echo $userId;
}
?>
