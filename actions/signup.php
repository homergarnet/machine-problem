<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../connections.php";
require_once "../database/signup.php";

date_default_timezone_set("Asia/Manila");
$dbUser = new SignUp();
if(isset($_POST["getExistingEmail"])){
    $userEmail = $_POST["userEmail"];
    $data = $dbUser->getExistingEmail($userEmail);
    if($data >= 1){
        echo 1;
    }
    else{
        echo 0;
    }
}
if(isset($_POST["checkIfDateInputIsGreaterThanToday"])){
    $dateInput = $_POST["dateInput"];
    
}
//jquery
if(isset($_POST["getExistingPhone"])){
    $userPhone = $_POST["userPhone"];
    $data = $dbUser->getExistingPhone($userPhone);
    if($data >= 1){
        echo 1;
    }
    else{
        echo 0;
    }
}
if((isset($_POST["userSignUpHidden"])) &&($_POST["userSignUpHidden"] == "true")){
    $userEmail = $_POST["userEmail"];
    $userDisplayName = $_POST["userDisplayName"];
    $userBirthDate = $_POST["userBirthDate"];
    //explode the date to get month, day and year
    $birthDate = explode("/", $userBirthDate);
    //get age from date or userBirthDate
    $userAge = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
        ? ((date("Y") - $birthDate[2]) - 1)
        : (date("Y") - $birthDate[2]));
    $userPhone = $_POST["userPhone"];
    $userPassword = $_POST["userPassword"];
    $data = $dbUser->getLastAccountUserId();
    $fileName = 1;
    foreach($data as $row){
        $fileName = $row["user_id"];
        $fileName++;
    }
    if(!empty($_FILES["userImage"]["name"])){
        //directory of your file will go
        $folder = "../images/user/";
        //code for getting temporary file location
        $filetmp = $_FILES["userImage"]["tmp_name"];
        //removing the values until the "." 
        $remove = explode(".",$_FILES["userImage"]["name"]);
        $ext = end($remove);
        
        $fileName = $fileName. ".".$ext;
        //move the uploaded image into the folder: resoSys
        move_uploaded_file($filetmp, $folder.$fileName);
    }
    else{
        $fileName = "";
    }
    $token = "qwertzuiopasdfghjklyxcvbnmQWERTZUIOPASDFGHJKLYXCVBNM0123456789!$/()*";
	$token = str_shuffle($token);
	$token = substr($token, 0, 10);
    $data = $dbUser->insertAccountUser($userEmail,$userDisplayName,
    $userBirthDate,$userAge,$userPhone,$userPassword,$fileName,$token);
    echo "<script> alert('successfully account inserted!');</script>";
}
?>
