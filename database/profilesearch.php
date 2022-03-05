<?php
class ProfileSearch extends Database{
    public function checkOneProfileBySearch($profileSearch){
        $sql = "
            SELECT *
            FROM user
            WHERE user_display_name =:profileSearch
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':profileSearch', $profileSearch);
        $stmt->execute();
        $result = $stmt->rowCount();
        return $result;
    }
    public function getProfileBySearch($profileSearch){
        $sql = "
            SELECT user_id,user_image,user_display_name,user_birth_date,user_age,user_phone FROM user WHERE user_display_name =:profileSearch
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':profileSearch', $profileSearch);
        $stmt->execute();
        //fetch for single and fetchAll for multiple
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result; 
    }
}
?>