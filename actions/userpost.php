<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../connections.php";
require_once "../database/userpost.php";
require_once '../vendor/autoload.php';
date_default_timezone_set("Asia/Manila");
$dbUser = new UserPost();
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
if(isset($_POST["updateSeenNotificationById"])){
    $notificationId = $_POST["notificationId"];
    echo $dbUser->updateSeenNotificationById($notificationId);
    ?>
    <?php
}
if(isset($_POST["getUserPostById"])){
    $postId = $_POST["postId"];
    $userId = $_POST["userId"];
    $data = $dbUser->getUserPostById($postId);
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
        <div id="userPostContainer<?php echo $userPostId; ?>" class="row justify-content-center mb-1">
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
                            <?php
                            if($userId == $userStoryId){
                                ?>
                                <div class="col text-end">
                                    <div class="dropdown">
                                        <button class="btn bg-dark text-white dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                            <span class="iconify" data-icon="entypo:dots-three-horizontal"></span>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
            
                                            <li>
                                                <a id="<?php echo $userPostId; ?>" class="dropdown-item remove-post" href="">Delete post</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
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
if(isset($_POST["getPostCommentById"])){
    $userPostId = $_POST["userPostId"];
    $userId  = $_POST["userId"];
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
}
if(isset($_POST["removePostById"])){
    $userPostId = $_POST["userPostId"];
    $userId = $_POST["userId"];
    echo $dbUser->removePostById($userPostId,$userId);
}
if(isset($_POST["removeCommentById"])){
    $userCommentId = $_POST["userCommentId"];
    echo $dbUser->removeCommentById($userCommentId);
}
?>
