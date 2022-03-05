<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
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
        <link rel = "stylesheet" href = "./css/index.css"/>
        <link rel = "stylesheet" href = "./css/forgotpassword.css"/>
        <link rel = "stylesheet" href = "./css/google-font.css"/>
    </head>
    <body>
        <?php 
        include_once "./sessionlogin.php";
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
        <div class="container-fluid container-user-forgot-password">
            <div class = "row mt-5 mb-5">
                <div class = "col">
                    <div class="card mx-auto shadow bg-white rounded user-card-field">
                        <article class="card-body">
                            <div class="row mb-5">
                                <div class = "col text-center">
                                    <form class="user-forgot-password" action = "" method = "POST" enctype="multipart/form-data">
                                       <img class="img-fluid" src="./images/system/forgotpassword1.png"/>
                                       <h4>Forgot Your Password? </h4>
                                       <p>Enter your email address or phone associated with your account</p>
                                        <div class="input-group mb-3">
                                            <input class = "form-control user-forgot-email" type = "text" placeholder = "Email or phone" name = "userForgotEmail" required/>
                                        </div>
                                        <input class = "btn sign-in-button user-forgot-password text-white" type = "submit" name = "userLogin" value = "Continue"/>
                                    </form>          
                                </div>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once "./footer.php"; ?>
        <!-- Option 1: Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="./js/confirm/jquery-confirm3.3.2.min.js"></script>
        <script src="https://code.iconify.design/2/2.0.3/iconify.min.js"></script>
        <script src="./js/forgotpassword.js"></script>
    </body>
</html>