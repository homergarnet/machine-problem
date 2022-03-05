<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../connections.php";
require_once "../../database/index.php";
date_default_timezone_set("Asia/Manila");
$dbUser = new Index();
if(isset($_POST["userCarretField"])){
    ?>
    <a class="" href="../profile.php?profile_id=<?php if(isset($_SESSION["loginuser"])){echo $_SESSION["loginuser"];}?>">
        <div class="row mt-3">
            <div class="col">
                <span class="iconify h3 ms-2" data-icon="gg:profile"></span> My Profile
            </div>
        </div>
    </a>
    <hr>
    <a class="" href="./accountsetting.php">
        <div class="row mt-3">
            
            <div class="col">
                <span class="iconify h3 ms-2" data-icon="ant-design:setting-outlined"></span> Account Settings
            </div>
        </div>
    </a>
    <hr>
    <a class="" href="./logout.php?logouttype=user">
        <div class="row mt-3">
            <div class="col">
            <span class="iconify h3 ms-2" data-icon="ri:shut-down-line"></span> Logout
            </div>
        </div>
    </a>
    <?php
}
?>
