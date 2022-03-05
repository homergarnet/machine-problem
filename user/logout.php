<?php
session_start();
$logoutType = $_GET["logouttype"];
if($logoutType == "user"){
	unset($_SESSION["loginuser"]);
	unset($_SESSION["logintype"]);
	echo '<script> window.location.href = "../signin.php"</script>';
}
//session_destroy();
?>