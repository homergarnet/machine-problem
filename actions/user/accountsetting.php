<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../connections.php";
require_once "../../database/user/accountsetting.php";
date_default_timezone_set("Asia/Manila");
$dbUser = new AccountSetting();
if(isset($_POST["checkUserProfile"])){
    $userId = $_POST["userId"];
    echo $dbUser->checkUserProfile($userId);
}

if(isset($_POST["getUserAccountSettingField"])){
    $userId = $_POST["userId"];
    $data = $dbUser->getUserEmailById($userId);
    foreach($data as $row){
        $userEmail = $row["user_email"];
        $userPassword = $row["user_password"];
        $text = substr($userEmail,0,10);
        $subStringUserEmail = substr_replace($userEmail,"*****",0,5);
        ?>
        <div class="row">
            <div class="col mb-3">
                <div class="card shadow bg-white rounded company-card-field card-border">
                    <article class="card-body">
                        <div class="row">
                            <div class = "col">
                                <p class="my-profile-label display-4 fw-bold">My Profile</p>
                                <p class="black-text lead">Manage and protect your account</p>
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class = "col-md-4">
                                <label>Email</label>
                            </div>
                            <div class="col-4 text-center">
                                <p class="user-email"><?php echo $subStringUserEmail; ?><p>
                            </div>
                            <div class="col-4 text-center">
                                <a class="text-primary change-email-button" href="" data-bs-toggle="modal" data-bs-target="#staticBackdrop1">Change</a>
                            </div>
                        </div>
                        <?php
                        if($userPassword != ""){
                            ?>
                            <div class="row">
                                <div class = "col-md-4">
                                    <label>Password</label>
                                </div>
                                <div class="col-4 text-center">
                                    <p class="user-password">*************<p>
                                </div>
                                <div class="col-4 text-center">
                                    <a class="text-primary change-password-button" href="" data-bs-toggle="modal" data-bs-target="#staticBackdrop1">Change</a>
                                </div>
                            </div>
                            <?php
                        }
                        ?>

                    </article>
                </div>
            </div>
        </div>
        <?php
    }
}
if(isset($_POST["getChangeEmailField"])){
    $userId = $_POST["userId"];
    $data = $dbUser->getUserEmail($userId);
    $userEmail = "";
    foreach($data as $row){
        $userEmail = $row["user_email"];
    }
    ?>
    <form class="edit-user-email">
        <div class="row">
            <div class="col">
                <p class="">Email</p>
                <span class = "error-text"><p class="text-center email-error"></p></span>
                <input class="form-control update-user-email" type="text" value="<?php echo $userEmail; ?>"/>
                <div class="d-grid gap-2 col-12 mx-auto mb-2">
                    <input class="btn update-user-email-button text-white mt-5" type="submit" value="Confirm"/>
                </div>
            </div>
        </div>
    </form>
    <?php
}
if(isset($_POST["getChangePasswordField"])){
    ?>
    <form class="update-user-password">
        <div class="container">
            <div class="row">
                <div class="col">
                    <p class="">Current Password</p>
                    <input class="form-control update-user-old-password" type="password" value=""/>
                    <p class="">New Password</p>
                    <input class="form-control update-user-new-password" type="password" value=""/>
                    <div id="user_update_pswd_info" class="display-none">
                        <h4>Password must meet the following requirements:</h4>
                        <ul class="text-left offset-md-2">
                            <li id="letter" class="invalid">At least <strong>one letter</strong></li>
                            <li id="capital" class="invalid">At least <strong>one capital letter</strong></li>
                            <li id="number" class="invalid">At least <strong>one number</strong></li>
                            <li id="length" class="invalid">Be at least <strong>8 characters</strong></li>
                            <li id="special" class="invalid">Be at least <strong>1 special characters</strong></li>
                        </ul>
                    </div>
                    <p class="">Retype New Password</p>
                    <span class = "error-text"><p class="text-center confirm-password-error"></p></span>
                    <input class="form-control update-user-retype-new-password" type="password" value=""/>
                    <div class="d-grid gap-2 col-12 mx-auto mb-2">
                        <input class="btn update-user-password-button text-white mt-5" type="submit" value="Confirm"/>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <?php
}
if(isset($_POST["getExistingEmail"])){
    $userEmail = $_POST["userEmail"];
    $userId = $_POST["userId"];
    $data = $dbUser->getExistingEmail($userId,$userEmail);
    if($data >= 1){
        echo 1;
    }
    else{
        echo 0;
    }
}
if(isset($_POST["confirmUpdateEmail"])){
    $userId = $_POST["userId"];
    $userEmail = $_POST["userEmail"];
    echo $dbUser->updateUserEmail($userId,$userEmail);
}
if(isset($_POST["confirmUpdatePassword"])){
    $userOldPassword = $_POST["userOldPassword"];
    $userNewPassword = $_POST["userNewPassword"];
    $userId = $_POST["userId"];
    $data = $dbUser->getUserPassword($userId);
    foreach($data as $row){
        $userPassword = $row["user_password"];
        if(password_verify($userOldPassword,$userPassword)){
            $dbUser->updateUserPassword($userId,$userNewPassword);
            echo 1;
        }
        else{
            echo "old password didn't match";
        }
    }
}
?>
