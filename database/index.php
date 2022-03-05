<?php
class Index extends Database{

    public function getUserNotificationCount($userId){
        $sql = "
            SELECT notification_id FROM notification WHERE notification_receiver_type = 'User' AND notification_receiver_id = :userId AND notification_is_active <> '0'
            AND notify <> '1'
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
        $result = $stmt->rowCount();
        return $result;
    }
    public function updateUserNotify($userId){
        $sql = "
            UPDATE notification SET notify = '1'
            WHERE notification_receiver_type = 'User' AND notification_receiver_id = :userId AND notify <> '1'
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
        $result = $stmt->rowCount();
        return $result;
    }
    public function getContainerNotification($userId){
        $sql = "
            SELECT notification.notification_id,notification.notification_type,
            notification.notification_sender_type,notification.notification_receiver_type,
            notification.notification_sender_id,notification.notification_receiver_id,
            notification.message,notification.seen,notification.notify,notification.date,
            notification.time,user.user_image,user.user_display_name,user_post.user_post_id
            FROM notification
            LEFT JOIN user ON user.user_id = notification.notification_sender_id
            LEFT JOIN user_post ON user_post.user_post_id = notification.user_post_id
            WHERE notification.notification_receiver_type = 'User' AND notification.notification_receiver_id = :userId AND notification.notification_is_active <> '0'
            GROUP BY notification.notification_id
            ORDER BY notification.notification_id DESC LIMIT 1
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
        //fetch for single and fetchAll for multiple
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function scrollUserNotification($userId,$start,$limit){
        $sql = "
            SELECT notification.notification_id,notification.notification_type,
            notification.notification_sender_type,notification.notification_receiver_type,
            notification.notification_sender_id,notification.notification_receiver_id,
            notification.message,notification.seen,notification.notify,notification.date,
            notification.time,user.user_image,user.user_display_name,user_post.user_post_id
            FROM notification
            LEFT JOIN user ON user.user_id = notification.notification_sender_id
            LEFT JOIN user_post ON user_post.user_post_id = notification.user_post_id
            WHERE notification.notification_receiver_type = 'User' AND notification.notification_receiver_id = :userId AND notification.notification_is_active <> '0'
            GROUP BY notification.notification_id
            ORDER BY notification.notification_id DESC LIMIT $start, $limit
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
        //fetch for single and fetchAll for multiple
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function getDisplayNameById($userId){
        $sql = "
            SELECT user_display_name FROM user WHERE user_id = :userId
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
        //fetch for single and fetchAll for multiple
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result; 
    }
    public function getLastUserPostId(){
        $sql = "
            SELECT user_post_id FROM user_post
            WHERE user_post_is_active <> '0'
            ORDER BY user_post_id DESC LIMIT 1
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        //fetch for single and fetchAll for multiple
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function insertStoryUpload($userId,$fileName,$storyInfo,$dateToday,$time){
        $sql = "
            INSERT INTO user_post(user_id,user_post_image,user_post_content,user_post_date,
            user_post_time)
            VALUES (:userId, :fileName,:storyInfo,:dateToday,:time)
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':fileName', $fileName);
        $stmt->bindParam(':storyInfo', $storyInfo);
        $stmt->bindParam(':dateToday', $dateToday);
        $stmt->bindParam(':time', $time);
        $stmt->execute();
        return true;
    }
    public function displayAllStoryScroll($userId,$start,$limit){
        $sql = "
            SELECT user_post.user_post_id,user_post.user_post_image,user_post.user_post_content,
            user_post.user_post_date,user_post.user_post_time,user.user_id AS user_story_id,user.user_image,user.user_display_name
            FROM user_post
            LEFT JOIN user ON user.user_id = user_post.user_id
            WHERE user_post.user_post_is_active <> '0' 
            GROUP BY user_post.user_post_id
            ORDER BY user_post.user_post_id DESC LIMIT $start, $limit
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        //fetch for single and fetchAll for multiple
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function getPostCommentCountById($userPostId){
        $sql = "
            SELECT user_comment.user_comment_id,user_comment.user_id,user_comment.user_comment,user_comment.user_comment_date,user_comment.user_comment_time,user.user_image,user.user_display_name 
            FROM user_comment 
            LEFT JOIN user ON user.user_id = user_comment.user_id
            WHERE user_comment.user_post_id = :userPostId AND user_comment.user_comment_is_active <> '0'
            GROUP BY user_comment.user_comment_id
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':userPostId', $userPostId);
        $stmt->execute();
        $result = $stmt->rowCount();
        return $result;
    }
    public function getUserIdByUserPostId($userPostId){
        $sql = "
            SELECT user_id FROM user_post
            WHERE user_post_id = :userPostId AND user_post_is_active <> '0'
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':userPostId', $userPostId);
        $stmt->execute();
        //fetch for single and fetchAll for multiple
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result; 
    }
    public function insertCommentWithNotification($userId,$userPostId,$postComment,$dateToday,$time){
        $isSendNotification = false;
        $sql = "
            INSERT INTO user_comment(user_id,user_post_id,user_comment,user_comment_date,
            user_comment_time)
            VALUES (:userId, :userPostId,:postComment,:dateToday,:time)
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':userPostId', $userPostId);
        $stmt->bindParam(':postComment', $postComment);
        $stmt->bindParam(':dateToday', $dateToday);
        $stmt->bindParam(':time', $time);
        $stmt->execute();
        $senderId = $userId; 
        $receiverId = 0;
        $sql = "
            SELECT user_id
            FROM user_post
            WHERE user_post_id = :userPostId AND user_post_is_active <> '0'
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':userPostId', $userPostId);
        $stmt->execute();
        //fetch for single and fetchAll for multiple
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($data as $row){
            $receiverId = $row["user_id"];
        }
        //do not send notification
        if($userId == $receiverId){
            $isSendNotification = false;
        }
        //send notification
        else{
            $sql = "
                INSERT INTO notification(notification_type,notification_sender_type,notification_receiver_type,
                notification_sender_id,notification_receiver_id,user_post_id,
                message,date,time)
                VALUES ('Notification','User', 'User',:senderId,:receiverId,:userPostId,'Commented on your post',:dateToday,:time)
            ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':senderId', $senderId);
            $stmt->bindParam(':receiverId', $receiverId);
            $stmt->bindParam(':userPostId', $userPostId);
            $stmt->bindParam(':dateToday', $dateToday);
            $stmt->bindParam(':time', $time);
            $stmt->execute();
            $isSendNotification = true;
        }

        return $isSendNotification;
    }
    public function getPostCommentById($userPostId){
        $sql = "
            SELECT user_comment.user_comment_id,user_comment.user_id,user_comment.user_comment,user_comment.user_comment_date,user_comment.user_comment_time,user.user_image,user.user_display_name 
            FROM user_comment 
            LEFT JOIN user ON user.user_id = user_comment.user_id
            WHERE user_comment.user_post_id = :userPostId AND user_comment.user_comment_is_active <> '0'
            GROUP BY user_comment.user_comment_id
            ORDER BY user_comment.user_comment_id ASC LIMIT 0,5
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':userPostId', $userPostId);
        $stmt->execute();
        //fetch for single and fetchAll for multiple
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result; 
    }
    public function getOnePostCommentById($userPostId){
        $sql = "
            SELECT user_comment.user_comment_id,user_comment.user_id,user_comment.user_comment,user_comment.user_comment_date,user_comment.user_comment_time,user.user_image,user.user_display_name 
            FROM user_comment 
            LEFT JOIN user ON user.user_id = user_comment.user_id
            WHERE user_comment.user_post_id = :userPostId AND user_comment.user_comment_is_active <> '0'
            GROUP BY user_comment.user_comment_id
            ORDER BY user_comment.user_comment_id DESC LIMIT 1
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':userPostId', $userPostId);
        $stmt->execute();
        //fetch for single and fetchAll for multiple
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result; 
    }
    public function getUserProfileImageById($userId){
        $sql = "
            SELECT user_image FROM user WHERE user_id = :userId
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
        //fetch for single and fetchAll for multiple
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result; 
    }
    public function viewMoreCommentById($userPostId,$start,$limit){
        $sql = "
            SELECT user_comment.user_comment_id,user_comment.user_id,user_comment.user_comment,user_comment.user_comment_date,user_comment.user_comment_time,user.user_image,user.user_display_name 
            FROM user_comment 
            LEFT JOIN user ON user.user_id = user_comment.user_id
            WHERE user_comment.user_post_id = :userPostId AND user_comment.user_comment_is_active <> '0'
            GROUP BY user_comment.user_comment_id
            ORDER BY user_comment.user_comment_id ASC LIMIT $start,$limit
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':userPostId', $userPostId);
        $stmt->execute();
        //fetch for single and fetchAll for multiple
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function removeCommentById($userCommentId){
        $sql = "
            UPDATE user_comment
            
            SET user_comment_is_active = '0'
            WHERE user_comment_id = :userCommentId
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':userCommentId', $userCommentId);
        $stmt->execute();
        return true;
    }
}
?>