<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../connections.php";
require_once "../database/index.php";
require_once '../vendor/autoload.php';
date_default_timezone_set("Asia/Manila");
$dbUser = new Index();
function time_ago($timestamp){
    $time_ago = strtotime($timestamp);
    $current_time = time();
    $time_difference = $current_time - $time_ago;
    $seconds = $time_difference;
    $minutes = round($seconds / 60);
    $hours = round($seconds / 3600);
    $days = round($seconds / 86400);
    $weeks = round($seconds / 604800);
    $months = round($seconds / 2629440);
    $years = round($seconds / 31553280); 
    if($seconds <= 60){
        return "Just now";
    }
    else if($minutes <= 60){
        if($minutes == 1){
            return "one minute ago";
        }
        else{
            return "$minutes minutes ago";
        }
    }
    else if($hours <= 24){
        if($hours == 1){
            return "an hour ago";
        }
        else{
            return "$hours hrs ago";
        }
    }
    else if($days <= 7){
        if($days == 1){
            return "yesterday";
        }
        else{
            return "$days days ago";
        }
    }
    //4.3 == 52/12
    else if($weeks <= 4.3){
        if($weeks == 1){
            return "a week ago";
        }
        else{
            return "$weeks weeks ago";
        }
    }
    else if($months <= 12){
        if($months == 1){
            return "a month ago";
        }
        else{
            return "$months months ago";
        }
    }
    else{
        if($years == 1){
            return "one year ago";
        }
        else{
            return "$years years ago";
        }
    }
}

if(isset($_POST["getUserNotificationCount"])){
    $userId = $_POST["userId"];
    $getUserNotificationCount = $dbUser->getUserNotificationCount($userId);
    if($getUserNotificationCount >= 1){
    ?>
        <span class = "notification-number"><?php echo $getUserNotificationCount; ?></span>
    <?php
    }
}
if(isset($_POST["updateUserNotify"])){
    $userId = $_POST["userId"];

    $updateUserNotify = $dbUser->updateUserNotify($userId);
    if($updateUserNotify >= 1){
        //
        // $options = array(
        //     'cluster' => 'ap1',
        //     'useTLS' => true
        // );
        // $pusher = new Pusher\Pusher(
        //     'd2e24ff059b1db0ad84f',
        //     '06b24f6830930b4936c3',
        //     '1271545',
        //     $options
        // );
        // $data['message'] = "notification";
        // $pusher->trigger('my-user-notification-container', 'my-user-notification-container-event', $data);
    }
    else{
        //do nothing
    }
    ?>
    <div class = "user-notification-message" id = "load_data_notification" style="">
        <!-- JQUERY CODE-->
    </div>
    <hr>

    <div class = "load-see-more-button">
        <!-- JQUERY CODE-->
    </div> 
    <?php
}
if(isset($_POST["userCarretField"])){
    ?>
    <a class="" href="./profile.php?profile_id=<?php if(isset($_SESSION["loginuser"])){echo $_SESSION["loginuser"];}?>">
        <div class="row mt-3">
            <div class="col">
                <span class="iconify h3 ms-2" data-icon="gg:profile"></span> My Profile
            </div>
        </div>
    </a>
    <hr>
    <a class="" href="./user/accountsetting.php">
        <div class="row mt-3">
            <div class="col">
                <span class="iconify h3 ms-2" data-icon="ant-design:setting-outlined"></span> Account Settings
            </div>
        </div>
    </a>
    <hr>
    <a class="" href="./user/logout.php?logouttype=user">
        <div class="row mt-3">
            <div class="col">
            <span class="iconify h3 ms-2" data-icon="ri:shut-down-line"></span> Logout
            </div>
        </div>
    </a>
    <?php
}
if(isset($_POST["getContainerNotification"])){
    $userId = $_POST["userId"];
    $data = $dbUser->getContainerNotification($userId);
    foreach($data as $row){
        $notificationId = $row["notification_id"];
        $notificationType= $row["notification_type"];
        $notificationSenderType = $row["notification_sender_type"];   
        $notificationReceiverType = $row["notification_receiver_type"];
        $notificationSenderId = $row["notification_sender_id"];
        $notificationReceiverId = $row["notification_receiver_id"];
        $notificationMessage = $row["message"];
        $notificationSeen = $row["seen"];
        $notificationNotify = $row["notify"];
        $notificationDate = $row["date"];
        $notificationTime = $row["time"];
        $userImage = $row["user_image"];
        $userDisplayName = $row["user_display_name"];
        $userPostId = $row["user_post_id"];
        $dateTime = $notificationDate. " ".$notificationTime;
        if($notificationSeen == 1){
            ?>
            <form class = "notification-message" action = "" method = "POST" enctype = "multipart/form-data">
                <div class = "row">
                    <a href="<?php if(isset($_POST["isInsideUser"])){echo "../userpost.php?notification_id=$notificationId&post_id=$userPostId";}else{echo "./userpost.php?notification_id=$notificationId&post_id=$userPostId";}?>">
                        <div class = "col" style="">
                            <input class = "notification-id" type = "hidden" value = "<?php echo $notificationId; ?>">
                            <span class="<?php if($userDisplayName != ""){echo "text-primary";}else{ echo "text-danger"; }?>"><?php if($userDisplayName != ""){echo $userDisplayName;}else{ echo "Anonymous"; }?></span></br>
                            <?php
                            if (strlen($notificationMessage)<=159) {
                                echo $notificationMessage;
                            }
                            else{
                                echo substr($notificationMessage, 0, 159)."...";
                            }
                            ?>
                            </br>
                            <span class = ""><?php echo time_ago($dateTime); ?></span></br>
                        </div>
                    </a>
                </div>
            </form>
            <?php
        }
        else{
            ?>
            <form class = "notification-message" action = "" method = "POST" enctype = "multipart/form-data">
                <div class = "row">
                    <a href="<?php if(isset($_POST["isInsideUser"])){echo "../userpost.php?notification_id=$notificationId&post_id=$userPostId";}else{echo "./userpost.php?notification_id=$notificationId&post_id=$userPostId";}?>">
                        <div class = "col notification-message-active card-border" style="">
                            <span class="<?php if($userDisplayName != ""){echo "text-primary";}else{ echo "text-danger"; }?>"><?php if($userDisplayName != ""){echo $userDisplayName;}else{ echo "Anonymous"; }?></span></br>
                            <?php
                            if (strlen($notificationMessage)<=159) {
                                echo $notificationMessage;
                            }
                            else{
                                echo substr($notificationMessage, 0, 159)."...";
                            }
                            ?>
                            </br>
                            <span class = ""><?php echo time_ago($dateTime); ?></span></br>
                        </div>
                    </a>
                </div>
            </form>
            <?php
        }
    }
}
if(isset($_POST["scrollUserNotification"])){
    $start = $_POST["start"];
    $limit = $_POST["limit"];
    $userId = $_POST["userId"];
    $data = $dbUser->scrollUserNotification($userId,$start,$limit);
    foreach($data as $row){
        $notificationId = $row["notification_id"];
        $notificationType= $row["notification_type"];
        $notificationSenderType = $row["notification_sender_type"];   
        $notificationReceiverType = $row["notification_receiver_type"];
        $notificationSenderId = $row["notification_sender_id"];
        $notificationReceiverId = $row["notification_receiver_id"];
        $notificationMessage = $row["message"];
        $notificationSeen = $row["seen"];
        $notificationNotify = $row["notify"];
        $notificationDate = $row["date"];
        $notificationTime = $row["time"];
        $userImage = $row["user_image"];
        $userDisplayName = $row["user_display_name"];
        $userPostId = $row["user_post_id"];
        $dateTime = $notificationDate. " ".$notificationTime;
        if($notificationSeen == 1){
            ?>
            <form class = "notification-message" action = "" method = "POST" enctype = "multipart/form-data">
                <div class = "row">
                    <a href="<?php if(isset($_POST["isInsideUser"])){echo "../userpost.php?notification_id=$notificationId&post_id=$userPostId";}else{echo "./userpost.php?notification_id=$notificationId&post_id=$userPostId";}?>">
                        <div class = "col" style="">
                            <span class="<?php if($userDisplayName != ""){echo "text-primary";}else{ echo "text-danger"; }?>"><?php if($userDisplayName != ""){echo $userDisplayName;}else{ echo "Anonymous"; }?></span></br>
                            <?php
                            if (strlen($notificationMessage)<=159) {
                                echo $notificationMessage;
                            }
                            else{
                                echo substr($notificationMessage, 0, 159)."...";
                            }
                            ?>
                            </br>
                            <span class = ""><?php echo time_ago($dateTime); ?></span></br>
                        </div>
                    </a>
                </div>
            </form>
            <?php
        }
        else{
            ?>
            <form class = "notification-message" action = "" method = "POST" enctype = "multipart/form-data">
                <div class = "row">
                    <a href="<?php if(isset($_POST["isInsideUser"])){echo "../userpost.php?notification_id=$notificationId&post_id=$userPostId";}else{echo "./userpost.php?notification_id=$notificationId&post_id=$userPostId";}?>">
                        <div class = "col notification-message-active card-border" style="">
                            <span class="<?php if($userDisplayName != ""){echo "text-primary";}else{ echo "text-danger"; }?>"><?php if($userDisplayName != ""){echo $userDisplayName;}else{ echo "Anonymous"; }?></span></br>
                            <?php
                            if (strlen($notificationMessage)<=159) {
                                echo $notificationMessage;
                            }
                            else{
                                echo substr($notificationMessage, 0, 159)."...";
                            }
                            ?>
                            </br>
                            <span class = ""><?php echo time_ago($dateTime); ?></span></br>
                        </div>
                    </a>
                </div>
            </form>
            <?php
        }
    }
}
if(isset($_POST["uploadPost"])){
    $userId = $_POST["userId"];
    $data = $dbUser->getDisplayNameById($userId);
    $userDisplayName = "";
    foreach($data as $row){
        $userDisplayName = $row["user_display_name"];
    }
    //create story layout
    if($userId != "0"){
       ?>
        <div class="row justify-content-center mb-5">
           <div class="col-lg-6">
                <div class="card shadow-lg card-border">
                    <div class="card-body">
                        <form class="story-upload">
                            <input class="story-upload-hidden" type="hidden" name="storyUploadHidden" value="false"/>
                            <div class="row">
                                <div class="col-lg mb-3">
                                    <textarea class="form-control story-info" placeholder="<?php echo 'Whats your story Now '.$userDisplayName.'?';?>" name="storyInfo"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col text-center">
                                    <img id="myImage" class="img-fluid story-image display-none" src="./images/system/default-profile.png" style=""/>
                                </div>
                            </div>
                            <span class = "error-text"><p class="text-center user-image-error"></p></span>
                            <div class="row justify-content-center text-center">
                                <div class="col text-center">
                                    <p class="text-center">
                                        <label for="files" class="btn btn-primary text-white mt-2"><span class="iconify h2 me-2" data-icon="ep:picture"></span>Upload Story</label>
                                    </p>
                                    <input id = "files" type = "file" name = "userImage" style="visibility:hidden;" onchange = "showImage.call(this)"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col text-center">
                                    <button class="btn btn-success upload-story" type="submit">Post</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
           </div>
        </div>
        <?php
    }
    else{
        
    }
}
if((isset($_POST["storyUploadHidden"])) &&($_POST["storyUploadHidden"] == "true")){
    $storyInfo = $_POST["storyInfo"];
    $userId = $_POST["userId"];
    $data = $dbUser->getLastUserPostId();
    $fileName = 1;
    foreach($data as $row){
        $fileName = $row["user_post_id"];
        $fileName++;
    }
    if(!empty($_FILES["userImage"]["name"])){
        //directory of your file will go
        $folder = "../images/post/";
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
    $dateToday = date("F j, Y");
    $time = date("g:i a");
    echo $dbUser->insertStoryUpload($userId,$fileName,$storyInfo,$dateToday,$time);
}
//
if(isset($_POST["displayAllStoryScroll"])){
    $userId = $_POST["userId"];
    $start = $_POST["start"];
    $limit = $_POST["limit"];

    $data = $dbUser->displayAllStoryScroll($userId,$start,$limit);
    foreach($data as $row){
        $userPostId = $row["user_post_id"];
        $userPostImage = $row["user_post_image"];
        $userPostContent = $row["user_post_content"];
        $userPostDate = $row["user_post_date"];
        $userPostTime = $row["user_post_time"];
        $userStoryId = $row["user_story_id"];
        $userImage = $row["user_image"];
        $userDisplayName = $row["user_display_name"];
        $dateTime = $userPostDate. " ".$userPostTime;
        ?>
        <div class="row justify-content-center mb-1">
            <div class="col-lg-6">
                <div class="card card-border shadow-lg">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-2">
                                <a class="" href="./profile.php?profile_id=<?php echo $userStoryId; ?>">
                                <img class="profile-image-small" src="<?php echo "./images/user/$userImage"; ?>"/></a>
                            </div>
                            <div class="col">
                                <a class="" href="./profile.php?profile_id=<?php echo $userStoryId; ?>"><h6><?php echo $userDisplayName; ?></h6></a>
                                <a class="" href="./profile.php?profile_id=<?php echo $userStoryId; ?>"><span class = "fs-13"><?php echo time_ago($dateTime); ?></span></a>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col">
                                <a class="" href="./userpost.php?&post_id=<?php echo $userPostId;?>">
                                    <p class="text-center">
                                        <?php echo $userPostContent; ?>
                                    </p>
                                </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col text-center">
                            <a class="" href="./userpost.php?&post_id=<?php echo $userPostId;?>">
                                <img class="user-post-image" src="<?php echo "./images/post/$userPostImage"; ?>"/>
                            </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="<?php echo "commentCard".$userPostId; ?>" class="row justify-content-center">
            <div class="col-lg-6 mb-3">
                <div class="card">
                    <div class="card-body">
                        <form class="view-more-comment">
                            <input class="user-post-id" type="hidden" value="<?php echo $userPostId; ?>"/>
                            <div id="<?php echo "h".$userPostId; ?>" class="container">
                                <?php
                                //for user comment
                                $data2 = $dbUser->getPostCommentById($userPostId);
                                foreach($data2 as $row2){
                                    $userCommentId = $row2["user_comment_id"];
                                    $userCommentatorId = $row2["user_id"];
                                    $userComment = $row2["user_comment"];
                                    $userCommentDate = $row2["user_comment_date"];
                                    $userCommentTime = $row2["user_comment_time"];
                                    $userImage2 = $row2["user_image"];
                                    $userDisplayName = $row2["user_display_name"]; 
                                    $dateTime2 = $userCommentDate. " ".$userCommentTime;
                                    ?>
                                    <div id="userCommentId<?php echo $userCommentId; ?>" class="container mb-3 comment-box-color">
                                        <div class="row">
                                            <div class="col-2">
                                                <a class="" href="./profile.php?profile_id=<?php echo $userCommentatorId;?>">
                                                <img class="profile-image-small" src="<?php if($userImage2 != ""){echo "./images/user/$userImage2"; }else{echo "./images/system/anonymous.png"; }?>"/></a>
                                            </div>
                                            <div class="col-lg mb-3">
                                                <a class="" href="./profile.php?profile_id=<?php echo $userCommentatorId; ?>"><h6><?php if($userCommentatorId != 0){echo $userDisplayName; }else{echo "<span class='text-danger'>Anonymous</span>";}?></h6></a>
                                                <a class="" href="./profile.php?profile_id=<?php echo $userCommentatorId; ?>"><span class="badge bg-success"><span class = "fs-13"><?php echo time_ago($dateTime2); ?></span></span></a>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg mb-3">
                                                <p class="text-center">
                                                    <?php echo $userComment; ?>
                                                </p>
                                            </div>
                                            <?php
                                            $userPostUserId = 0;
                                            $data3 = $dbUser->getUserIdByUserPostId($userPostId);
                                            foreach($data3 as $row3){
                                                $userPostUserId = $row3["user_id"];
                                            }
                                            if($userId == $userCommentatorId && $userId != 0 || $userId == $userPostUserId){
                                                ?>
                                                <div class="col text-end">
                                                    <div class="dropdown">
                                                        <button class="btn bg-primary text-white dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <span class="iconify" data-icon="entypo:dots-three-horizontal"></span>
                                                        </button>
                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                            <li>
                                                                <form class="remove-comment">
                                                                    <input class="user-comment-id" type="hidden" value="<?php echo $userCommentId; ?>"/>
                                                                    
                                                                <a id="" class="dropdown-item remove-comment">Remove Comment</a>
                                                                </form>
                                                            
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <div id="latestCommentAppend<?php echo $userPostId; ?>" class="container">

                            </div>
                            <div class="container view-more-comment-container">
                                <?php
                                    //here na me
                                    $getPostCommentCountById = $dbUser->getPostCommentCountById($userPostId);
                                    if($getPostCommentCountById > 5){
                                        ?>
                                        <div class="row">
                                            <div class="col-lg mb-3">
                                                <a href="" class="view-more-comment">View more comments</a>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                ?>
                            </div>
                        </form>
                        <div id="<?php echo "commentTextArea".$userPostId; ?>" class="row">
                            <div class="col-2">
                                <?php
                                //for comment textarea 
                                if(isset($_SESSION["loginuser"])){
                                    $data2 = $dbUser->getUserProfileImageById($userId);
                                    foreach($data2 as $row2){
                                        $userProfileImage = $row2["user_image"];
                                        ?>
                                        <a class="" href="./profile.php?profile_id=<?php echo $userCommentatorId; ?>">
                                            <img class="profile-image-small" src="<?php echo "./images/user/$userProfileImage"; ?>"/>
                                        </a>
                                        <?php
                                    }
                                }
                                else{
                                    ?>
                                    <img class="profile-image-small" src="<?php echo "./images/system/anonymous.png"; ?>"/>
                                    <?php
                                }
                                ?>
                            </div>
                            <div class="col-lg mb-3">
                                <form class="post-comment">
                                    <input class="user-post-id" type="hidden" name="userPostId" value="<?php echo $userPostId; ?>"/>
                                    <input class="comment-box-id" type="hidden" name="commentBoxId" value="<?php echo $userPostId; ?>"/>
                                    <textarea class="form-control post-comment" placeholder="Write a comment..." name="postComment" style="height:10px;"></textarea>
                                </form>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}
if(isset($_POST["viewMoreCommentById"])){
    $userPostId = $_POST["userPostId"];
    $start = $_POST["start"];
    $limit = $_POST["limit"];
    $userId = $_POST["userId"];
    $data = $dbUser->viewMoreCommentById($userPostId,$start,$limit);
    foreach($data as $row){
        $userCommentId = $row["user_comment_id"];
        $userCommentatorId = $row["user_id"];
        $userComment = $row["user_comment"];
        $userCommentDate = $row["user_comment_date"];
        $userCommentTime = $row["user_comment_time"];
        $userImage2 = $row["user_image"];
        $userDisplayName = $row["user_display_name"]; 
        $dateTime2 = $userCommentDate. " ".$userCommentTime;
        ?>
        <div id="userCommentId<?php echo $userCommentId; ?>" class="container mb-3 comment-box-color">
            <div class="row">
                <div class="col-2">
                    <a class="" href="./profile.php?profile_id=<?php echo $userCommentatorId;?>">
                    <img class="profile-image-small" src="<?php if($userImage2 != ""){echo "./images/user/$userImage2"; }else{echo "./images/system/anonymous.png"; }?>"/></a>
                </div>
                <div class="col-lg mb-3">
                    <a class="" href="./profile.php?profile_id=<?php echo $userCommentatorId; ?>"><h6><?php if($userCommentatorId != 0){echo $userDisplayName; }else{echo "<span class='text-danger'>Anonymous</span>";}?></h6></a>
                    <a class="" href="./profile.php?profile_id=<?php echo $userCommentatorId; ?>"><span class="badge bg-success"><span class = "fs-13"><?php echo time_ago($dateTime2); ?></span></span></a>
                </div>
            </div>
            <div class="row">
                <div class="col-lg mb-3">
                    <p class="text-center">
                        <?php echo $userComment; ?>
                    </p>
                </div>
                <?php
                $userPostUserId = 0;
                $data3 = $dbUser->getUserIdByUserPostId($userPostId);
                foreach($data3 as $row3){
                    $userPostUserId = $row3["user_id"];
                }
                if($userId == $userCommentatorId && $userId != 0 || $userId == $userPostUserId){
                    ?>
                    <div class="col text-end">
                        <div class="dropdown">
                            <button class="btn bg-primary text-white dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="iconify" data-icon="entypo:dots-three-horizontal"></span>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <li>
                                    <form class="remove-comment">
                                        <input class="user-comment-id" type="hidden" value="<?php echo $userCommentId; ?>"/>
                                        
                                    <a id="" class="dropdown-item remove-comment">Remove Comment</a>
                                    </form>
                                
                                </li>
                            </ul>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
        <?php
    }
}
if(isset($_POST["insertPostComment"])){
    $userId = $_POST["userId"];
    $userPostId = $_POST["userPostId"];
    $postComment = $_POST["postComment"];

    $dateToday = date("F j, Y");
    $time = date("g:i a");
    $isSendNotification = $dbUser->insertCommentWithNotification($userId,$userPostId,$postComment,$dateToday,$time);
    $options = array(
        'cluster' => 'ap1',
        'useTLS' => true
    );
    $pusher = new Pusher\Pusher(
        'd2e24ff059b1db0ad84f',
        '06b24f6830930b4936c3',
        '1271545',
        $options
    );
    if($isSendNotification == "1"){
        $data['message'] = $userId." ".$userPostId;
        $pusher->trigger('my-user-notification', 'my-user-notification-event', $data);
        $pusher->trigger('my-user-notification-container', 'my-user-notification-container-event', $data);

    }
    $data['user_post_id'] = $userPostId;
    $data['comment_box_id_number'] = $userPostId;
    $pusher->trigger('comment-box-id-number', 'comment-box-id-number-event', $data);

}
if(isset($_POST["getOnePostCommentById"])){
    $userPostId = $_POST["userPostId"];
    $userId = $_POST["userId"];
    //for user comment
    $data = $dbUser->getOnePostCommentById($userPostId);
    foreach($data as $row){
        $userCommentId = $row["user_comment_id"];
        $userCommentatorId = $row["user_id"];
        $userComment = $row["user_comment"];
        $userCommentDate = $row["user_comment_date"];
        $userCommentTime = $row["user_comment_time"];
        $userImage2 = $row["user_image"];
        $userDisplayName = $row["user_display_name"]; 
        $dateTime2 = $userCommentDate. " ".$userCommentTime;
        ?>
        <div id="userCommentId<?php echo $userCommentId; ?>" class="container mb-3 comment-box-color">
            <div class="row">
                <div class="col-2">
                    <a class="" href="./profile.php?profile_id=<?php echo $userCommentatorId;?>">
                    <img class="profile-image-small" src="<?php if($userImage2 != ""){echo "./images/user/$userImage2"; }else{echo "./images/system/anonymous.png"; }?>"/></a>
                </div>
                <div class="col-lg mb-3">
                    <a class="" href="./profile.php?profile_id=<?php echo $userCommentatorId; ?>"><h6><?php if($userCommentatorId != 0){echo $userDisplayName; }else{echo "<span class='text-danger'>Anonymous</span>";}?></h6></a>
                    <a class="" href="./profile.php?profile_id=<?php echo $userCommentatorId; ?>"><span class="badge bg-success"><span class = "fs-13"><?php echo time_ago($dateTime2); ?></span></span></a>
                </div>
            </div>
            <div class="row">
                <div class="col-lg mb-3">
                    <p class="text-center">
                        <?php echo $userComment; ?>
                    </p>
                </div>
                <?php
                $userPostUserId = 0;
                $data3 = $dbUser->getUserIdByUserPostId($userPostId);
                foreach($data3 as $row3){
                    $userPostUserId = $row3["user_id"];
                }
                if($userId == $userCommentatorId && $userId != 0 || $userId == $userPostUserId){
                    ?>
                    <div class="col text-end">
                        <div class="dropdown">
                            <button class="btn bg-primary text-white dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="iconify" data-icon="entypo:dots-three-horizontal"></span>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <li>
                                    <form class="remove-comment">
                                        <input class="user-comment-id" type="hidden" value="<?php echo $userCommentId; ?>"/>
                                        
                                    <a id="" class="dropdown-item remove-comment">Remove Comment</a>
                                    </form>
                                    
                                </li>
                            </ul>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
        <?php
    }
}
if(isset($_POST["removeCommentById"])){
    $userCommentId = $_POST["userCommentId"];
    echo $dbUser->removeCommentById($userCommentId);
}
?>
