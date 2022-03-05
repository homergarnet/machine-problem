<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../connections.php";
require_once "../database/profilesearch.php";
require_once '../vendor/autoload.php';
date_default_timezone_set("Asia/Manila");
$dbUser = new ProfileSearch();
if(isset($_POST["getProfileBySearch"])){
    $profileSearch = $_POST["profileSearch"];
    $userId = $_POST["userId"];
    $checkAtleastOneProfileBySearch = $dbUser->checkOneProfileBySearch($profileSearch);
    $data = $dbUser->getProfileBySearch($profileSearch);
    //when the user view profile he can edit update
    ?>
    <div class="row justify-content-center">
        <div class="card w-75 shadow-lg card-border">
            <div class="card-body">
                <?php
                if($checkAtleastOneProfileBySearch == 0){
                    ?>
                    <h1 class="text-center profile-font-color">No profile found.</h1>
                    <?php
                }
                foreach($data as $row){
                    $userProfileId = $row["user_id"];
                    $userImage = $row["user_image"];
                    $userDisplayName = $row["user_display_name"];
                    $userBirthDate = $row["user_birth_date"];
                    $userAge = $row["user_age"];
                    $userPhone = $row["user_phone"];
                    ?>
                    <div class="row justify-content-center">
                        <div class="col-lg mb-3 text-center">
                            <div class="profile-background">
                            <a class="" href="./profile.php?profile_id=<?php echo $userProfileId; ?>">
                                <img class="img-fluid profile zoom" src="<?php echo "./images/user/".$userImage; ?>"/></a>
                                </br>
                            </div>

                        </div>
                        <div class="col-lg-4 mb-3 text-center" style="background-color:rgb(208,236,198);">
                            </br>
                            </br>
                            </br>
                            </br>
                            <h3 class="profile-font-color"><?php echo $userDisplayName; ?></h3>
                        </div>
                    </div>
                    <hr>
                    <div class="row justify-content-center">
                        <div class="col-lg mb-3 text-center">
                            <h4 class="profile-font-color">Birthday</h4>
                            <p class="lead profile-font-color"><?php echo $userBirthDate; ?></p>
                        </div>

                        <div class="col-lg mb-3 text-center">
                            <h4 class="profile-font-color">Age</h4>
                        <p class="lead profile-font-color"><?php echo $userAge; ?></p>
                        </div>
                    </div>
                    <hr>
                    <div class="row justify-content-center">
                        <div class="col-lg mb-3 text-center bg-dark">
                        <h4 class="text-white">Contact</h4>
                        <p class="lead text-white"><?php echo $userPhone; ?></p>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
    <?php
}
?>
