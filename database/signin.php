<?php
class SignIn extends Database{
    public function getUserEmail($userEmail){
        $sql = "
            SELECT user_id, user_email, user_password FROM user
            WHERE user_email = :userEmail
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':userEmail', $userEmail);
        $stmt->execute();
        //fetch for single and fetchAll for multiple
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function getUserIdByEmail($userEmail){
        $sql = "
            SELECT user_id FROM user
            WHERE user_email = :userEmail
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':userEmail', $userEmail);
        $stmt->execute();
        //fetch for single and fetchAll for multiple
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}
?>