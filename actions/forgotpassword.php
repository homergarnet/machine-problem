<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../connections.php";
require_once "../database/forgotpassword.php";
date_default_timezone_set("Asia/Manila");
$dbUser = new ForgotPassword();
if(isset($_POST["userForgotPassword"])){
    $userForgotEmail = $_POST["userForgotEmail"];
    echo $data = $dbUser->userForgotPassword($userForgotEmail);
}
if(isset($_POST["userEmailField"])){
    $email = $_POST["email"];
    $data = $dbUser->getUserToken($email);
    $userDisplayName = "";
    $token = "";
    foreach($data as $row){
        $userDisplayName = $row["user_display_name"];
        $token = $row["user_token"];
    }
    $accountType = "user";
    include_once "../phpmailer/index.php";
    ?>
    <div class = "row mt-5 mb-5">
        <div class = "col">
            <div class="card mx-auto shadow bg-white rounded user-card-field">
                <article class="card-body">
                    <div class="row mb-5">
                        <div class = "col text-center">
                            <img class="img-fluid" src="./images/system/forgotpassword2.png"/>
                            <h4>Password Reset Request Sent</h4>
                            <p class="text-center">A password reset message was sent to your email. Please
                                click the link in email message to reset your password reset message in a few
                                moments, please check your spam, junk, or other folder it might be.
                            </p></p>
                        </div>
                    </div>
            </article>
        </div>
    </div>
    <?php
}

?>
