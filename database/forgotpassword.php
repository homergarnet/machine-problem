<?php
class ForgotPassword extends Database{
    public function userForgotPassword($userForgotEmail){
        $userEmail = "";
   
        $sql = "
            SELECT user_email FROM user WHERE user_email = :userForgotEmail
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':userForgotEmail', $userForgotEmail);
        $stmt->execute();
        //fetch for single and fetchAll for multiple
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($data as $row){
            $userEmail = $row["user_email"];
        }
      
        if($userEmail != ""){
            return "user email";
        }

    }
    public function getUserToken($email){
        $sql = "
            SELECT user_display_name, user_token FROM user WHERE user_email = :email
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        //fetch for single and fetchAll for multiple
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result; 
    }
}
?>