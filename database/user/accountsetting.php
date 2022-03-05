<?php
class AccountSetting extends Database{
    public function getUserEmailById($userId){
        $sql = "
            SELECT user_email,user_password FROM user WHERE user_id = :userId
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
        //fetch for single and fetchAll for multiple
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result; 
    }
    public function getUserEmail($userId){
        $sql = "
            SELECT user_email FROM user WHERE user_id = :userId
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
        //fetch for single and fetchAll for multiple
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result; 
    }
    public function getExistingEmail($userId,$userEmail){
        $sql = "
            SELECT user_email FROM user WHERE user_email = :userEmail AND user_id <> 
            :userId
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':userEmail', $userEmail);
        $stmt->execute();
        $data = $stmt->rowCount();
        return $data;
    }
    public function updateUserEmail($userId,$userEmail){
        $sql = "
            UPDATE user SET user_email = :userEmail
            WHERE user_id = :userId
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':userEmail', $userEmail);
        $stmt->execute();
        return true;
    }
    public function getUserPassword($userId){
        $sql = "
            SELECT user_password FROM user WHERE user_id = :userId
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
        //fetch for single and fetchAll for multiple
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function updateUserPassword($userId,$userNewPassword){
        $passwordHash = password_hash($userNewPassword,PASSWORD_DEFAULT);
        $sql = "
            UPDATE user SET user_password = :passwordHash
            WHERE user_id = :userId
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':passwordHash', $passwordHash);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
        return true;
    }

}
?>