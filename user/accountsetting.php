<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$_SESSION["logintype"] = "user_account_setting";

if(!isset($_SESSION["loginuser"])){
    $protocol = $_SERVER["SERVER_PROTOCOL"];
    if(strpos($protocol,"HTTPS")){
        $protocol = "HTTPS://";
    }
    else{
        $protocol = "HTTP://";
    }
    $redirectLinkVar = $protocol.$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
	header("location: ../signin.php?page_url=".$redirectLinkVar);
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
        <link href="../js/confirm/jquery-confirm3.3.2.min.css" rel="stylesheet">
        <link rel = "stylesheet" href = "../css/index.css"/>
        <link rel = "stylesheet" href = "../css/user/accountsetting.css"/>
        <link rel = "stylesheet" href = "../css/google-font.css"/>
    </head>
    <body>
        <?php 
        include_once "../sessionlogin.php";
        include_once "../header.php";
        ?>
        </br></br></br>
        <div class="container mt-5 mb-3 container-account-setting">
            <!-- JQUERY CODE -->
        </div>
        <!-- MODAL DIALOG -->
        <div class="modal fade" id="staticBackdrop1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel"><!-- JQUERY CODE --></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- JQUERY CODE -->
                    </div>
                    <div class="modal-footer">
                        <!-- JQUERY CODE -->
                    </div>
                </div>
            </div>
        </div>
        <!-- MODAL DIALOG -->
        <div class="modal fade" id="staticBackdrop2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title modal-title-2" id="exampleModalLongTitle"><!-- JQUERY CODE --></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body modal-body-2">

                    </div>
                    <div class="modal-footer">
                        <!-- jquery code-->
                    </div>
                </div>
            </div>
        </div>
        <?php include_once "../footer.php"; ?>
        <!-- Option 1: Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="../js/confirm/jquery-confirm3.3.2.min.js"></script>
        <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
        <script src="https://code.iconify.design/2/2.0.3/iconify.min.js"></script>
        <script src="../js/user/accountsetting.js"></script>
    </body>
</html>