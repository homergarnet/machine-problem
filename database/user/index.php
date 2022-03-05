<?php
class Index extends Database{
    public function insertNotificationMessage($contactName,$contactEmail,$contactMessage,$dateToday,$time){
        $sql = "
            INSERT INTO notification(notification_type,notification_sender_type,notification_receiver_type,
            notification_sender_id,notification_receiver_id,
            message,date,time)
            VALUES ('client report','client', 'admin','0','1',:contactMessage,:dateToday,:time)
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':contactMessage', $contactMessage);
        $stmt->bindParam(':dateToday', $dateToday);
        $stmt->bindParam(':time', $time);
        $stmt->execute();
        $notificationId = $this->conn->lastInsertId();
        $sql = "
            INSERT INTO client_report(notification_id,client_name,client_message)
            VALUES (:notificationId,:contactName,:contactMessage)
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':notificationId', $notificationId);
        $stmt->bindParam(':contactName', $contactName);
        $stmt->bindParam(':contactMessage', $contactMessage);
        $stmt->execute();
        return true;
    }
}
?>