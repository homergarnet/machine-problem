<?php
class UserPost extends Database{
    public function updateSeenNotificationById($notificationId){
        $sql = "
            update notification set seen = '1'
            WHERE notification_id = :notificationId AND seen <> '1' AND notification_is_active = '1'
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':notificationId', $notificationId);
        $stmt->execute();
        return true;
    }
    public function getUserPostById($postId){
        $sql = "
            SELECT user_post.user_post_id,user_post.user_post_image,user_post.user_post_content,
            user_post.user_post_date,user_post.user_post_time,user.user_id AS user_story_id,user.user_image,user.user_display_name
            FROM user_post
            LEFT JOIN user ON user.user_id = user_post.user_id
            WHERE user_post.user_post_id = :postId AND user_post.user_post_is_active <> '0'
            GROUP BY user_post.user_post_id
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':postId', $postId);
        $stmt->execute();
        //fetch for single and fetchAll for multiple
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function getPostCommentById($userPostId){
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
    public function removePostById($userPostId,$userId){
        $sql = "
            UPDATE user_post
            LEFT JOIN user_comment ON user_comment.user_id = user_post.user_id AND user_comment.user_post_id = :userPostId
            LEFT JOIN notification ON notification.user_post_id = :userPostId AND notification.notification_receiver_id = :userId
            SET user_post.user_post_is_active = '0',user_comment.user_comment_is_active = '0',
            notification.notification_is_active = '0'
            WHERE user_post.user_post_id = :userPostId AND user_post.user_id = :userId
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':userPostId', $userPostId);
        $stmt->execute();
        return true;
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