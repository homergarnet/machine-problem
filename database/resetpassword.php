<?php
class ResetPassword extends Database{
    public function userResetPasswordChecker($userId,$token){
        $sql = "
            SELECT user_id FROM user WHERE user_email = :userId AND user_token = :token
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':token', $token);
        $stmt->execute();
        $result = $stmt->rowCount();
        return $result;
    }
    public function resetPasswordUserAccount($userPassword,$userId,$token){
        $passwordHash = password_hash($userPassword,PASSWORD_DEFAULT);
        $sql = "
            UPDATE user SET user_password = :passwordHash, user_token = :token
            WHERE user_id =:userId
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':passwordHash', $passwordHash);
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
        return true;
    }
}
?>