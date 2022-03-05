<?php
class SignUp extends Database{
    public function getExistingEmail($userEmail){
        $sql = "
            SELECT user_email FROM user WHERE user_email = :userEmail
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':userEmail', $userEmail);
        $stmt->execute();
        $data = $stmt->rowCount();
        return $data;
    }
    public function getExistingPhone($userPhone){
        $sql = "
            SELECT user_phone FROM user WHERE user_phone = :userPhone
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':userPhone', $userPhone);
        $stmt->execute();
        $data = $stmt->rowCount();
        return $data;
    }
    public function getLastAccountUserId(){
        $sql = "
            SELECT user_id FROM user
            WHERE user_is_active <> 0
            ORDER BY user_id DESC LIMIT 1
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        //fetch for single and fetchAll for multiple
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function insertAccountUser($userEmail,$userDisplayName,
    $userBirthDate,$userAge,$userPhone,$userPassword,$fileName,$token){
        $passwordHash = password_hash($userPassword,PASSWORD_DEFAULT);
        $sql = "
            INSERT INTO user(user_email,user_password,user_image,user_display_name,user_birth_date,
            user_age,user_phone,user_token)
            VALUES (:userEmail, :passwordHash,:fileName,:userDisplayName,:userBirthDate,
            :userAge,:userPhone,:token)
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':userEmail', $userEmail);
        $stmt->bindParam(':passwordHash', $passwordHash);
        $stmt->bindParam(':fileName', $fileName);
        $stmt->bindParam(':userDisplayName', $userDisplayName);
        $stmt->bindParam(':userBirthDate', $userBirthDate);
        $stmt->bindParam(':userAge', $userAge);
        $stmt->bindParam(':userPhone', $userPhone);
        $stmt->bindParam(':token', $token);
        $stmt->execute();
        return true;
    }
}
?>