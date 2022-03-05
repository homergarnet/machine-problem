<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../connections.php";
require_once "../database/resetpassword.php";
date_default_timezone_set("Asia/Manila");
$dbUser = new ResetPassword();
//jquery
if(isset($_POST["resetPasswordChecker"])){
    $userId = $_POST["userId"];
    $token = $_POST["token"];
    echo $data = $dbUser->userResetPasswordChecker($userId,$token);
    
}
//jquery TO DONE
if(isset($_POST["userResetPasswordField"])){
    $userId = $_POST["userId"];
    ?>
    
    <div class = "row mt-5 mb-5">
        <div class = "col">
            <div class="card mx-auto shadow bg-white rounded user-card-field">
                <article class="card-body">
                    <div class="row mb-5">
                        <div class = "col text-center">
                            <form class="user-reset-password" action = "../actions/user/sign-in.php" method = "POST" enctype="multipart/form-data">
                                <input class="user-id" type="hidden" value="<?php echo $userId; ?>"/>
                                <img class="img-fluid" src="./images/system/resetpassword1.png"/>
                                <h4>Set Your Password </h4>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend me-2">
                                        <span class="iconify" data-icon="fluent:key-32-filled"></span>
                                    </div>
                                    <input class = "form-control user-reset-password" type = "password" placeholder = "New Password" name = "userPassword" required/>
                                </div>
                                <div id="user_pswd_info">
                                    <h4>Password must meet the following requirements:</h4>
                                    <ul class="text-left offset-md-2">
                                        <li id="letter" class="invalid">At least <strong>one letter</strong></li>
                                        <li id="capital" class="invalid">At least <strong>one capital letter</strong></li>
                                        <li id="number" class="invalid">At least <strong>one number</strong></li>
                                        <li id="length" class="invalid">Be at least <strong>8 characters</strong></li>
                                        <li id="special" class="invalid">Be at least <strong>1 special characters</strong></li>
                                    </ul>
                                </div>
                                <span class = "error-text"><p class="text-center confirm-password-error"></p></span>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend me-2">
                                        <span class="iconify" data-icon="fluent:key-32-filled"></span>
                                    </div>
                                    <input class = "form-control user-reset-confirm-password" type = "password" placeholder = "Confirm Password" name = "userPassword" required/>
                                </div>
                                <input class = "btn user-reset-password-button text-white" type = "submit" name = "userLogin" value = "Continue"/>
                            </form>          
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </div>
    <?php
}
//jquery
if(isset($_POST["resetPasswordUserAccount"])){
    $userPassword = $_POST["userPassword"];
    $userId = $_POST["userId"];
    $token = "qwertzuiopasdfghjklyxcvbnmQWERTZUIOPASDFGHJKLYXCVBNM0123456789!$/()*";
	$token = str_shuffle($token);
	$token = substr($token, 0, 10);
    echo $data = $dbUser->resetPasswordUserAccount($userPassword,$userId,$token);
}
?>
