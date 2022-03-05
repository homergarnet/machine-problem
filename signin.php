<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if(isset($_REQUEST["page_url"])){
    $pageUrl = $_REQUEST["page_url"];
}
else{
    $pageUrl = "";
}
if(isset($_SESSION["loginuser"])){
    $redirectLink = $_REQUEST["page_url"];
    if($redirectLink == ""){
        header("location: ./index.php");
    }
    else{
        header("location: ".$redirectLink);
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>
        </title>
        <meta charset = "utf-8">
        <meta name = "viewport" content = "width=device-width, initial-scale= 1.0">
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <!-- FOR confirm dialog jquery -->
        <link href="./js/confirm/jquery-confirm3.3.2.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker3.css" rel="stylesheet" id="bootstrap-css">
        <link rel = "stylesheet" href = "./css/index.css"/>
        <link rel = "stylesheet" href = "./css/google-font.css"/>
        <link rel = "stylesheet" href = "./css/signin.css"/>
        
    </head>
    <body>
        <input id="url-page" type="hidden" value="<?php echo $pageUrl; ?>"/>
        <?php 
        include_once "./sessionlogin.php";
        if(isset($_SESSION["loginuser"])){
            $_SESSION["logintype"] = "user_profile";
        }
        else{
            $_SESSION["logintype"] = "none";
        }
        include_once "./header.php";
        ?>
        </br></br></br>
        <div class="container-fluid bg-white header-mobile">
            <div class="row">
                <div class="col mt-3 mb-3">
                    <a class="nav-link" href="./index.php">
                        
                        <img class="img-fluid system-logo-header-mobile" src="./images/system/social.png"/>
                    </a>
                </div>
                <div class="col text-end mt-3 mb-3">
                    <button class="btn header-close bg-dark text-white" type="button">
                        <span class="iconify h2" data-icon="bi:x-lg"></span>
                    </button>
                </div>
            </div>
            <div class="row me-3">
                <div class="col"><a class="home-mobile" href="#home"><h1>View Post</h1></a></div>
            </div>
            <div class="row me-3">
                <div class="col"><a class="" href="./signin.php"><h1>Login</h1></a></div>
            </div>
            <div class="row">
                <div class="col"><a class="" href="./signup.php"><h1>Sign Up</h1></a></div>
            </div>
        </div>
        <div class="container">
            <div class="row justify-content-center mt-5 mb-5">
                <div class = "col-lg-6 shadow bg-white rounded">
                    <div class="card mt-3 mb-3">
                        <div class="card-body">
                            <form class="user-sign-in">
                                <input class="user-sign-up-hidden" type="hidden" name="userSignUpHidden"  value="false"/>
                                <h2 class="text-center font-weight-bold">Sign In</h2>
                                <p class="text-center">You're signing in for Story Online</p>
 
                               
                                <div class="input-group justify-content-center mb-3">
                                    <span class="iconify h3 me-2" data-icon="carbon:email"></span>
                                    <input class = "form-control user-email" type = "text" name = "userEmail" placeholder="Email" value="<?php if(isset($_COOKIE["user_email_login"])) { echo $_COOKIE["user_email_login"]; } ?>"/>
                                </div>
                            
                                <div class="input-group justify-content-center mb-3">
                                    <span class="iconify h3 me-2" data-icon="fluent:key-32-filled"></span>
                                    <input class = "form-control user-password" type = "password" placeholder="Password" name = "userPassword" value="<?php if(isset($_COOKIE["user_password_login"])) { echo $_COOKIE["user_password_login"]; } ?>"/>
                                </div>
                                <div class="form-check ms-5 mb-2">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        value=""
                                        id="rememberMeCheckBox"
                                        name="rememberMeCheckBox"
                                        <?php if(isset($_COOKIE["user_email_login"])) { ?> checked <?php } ?>
                                    />
                                    <label class="form-check-label" for="rememberMeCheckBox">
                                        Remember me
                                    </label>
                                </div>
                                <div class="d-grid gap-2 col-12 mx-auto mb-2">
                                    <button class="btn user-sign-in text-white col-md-12" type="submit">Sign In</button>
                                </div>
                                <div class="row mt-5">
                                    <div class="col-lg text-center">
                                    <p class="h6"><a class="text-primary" href="./forgotpassword.php">Forgot My Password</a></p>
                                    </div>
                                    <hr>
                                    <div class="col-lg text-center">
                                        <p class="h6"> <a class="text-primary" href="./signup.php">Create new account</a></p>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once "./footer.php"; ?>
        <!-- Option 1: Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="./js/confirm/jquery-confirm3.3.2.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
        <script src="https://code.iconify.design/2/2.0.3/iconify.min.js"></script>
        <script src="./js/signin.js"></script>
    </body>
</html>