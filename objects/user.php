<?php
class User {
    private $conn;
    private $table_name = "user";

    public $user_id;
    public $fist_name;
    public $last_name;

    public function __construct($db){
        $this->conn = $db;
    }

    function existUser($user_id) {
        $query = "SELECT
                *
            FROM
                " . $this->table_name . "
            WHERE
                user_id = ? ";
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $user_id, PDO::PARAM_INT);
        $stmt->execute();
        if($stmt->fetch(PDO::FETCH_ASSOC)){
            return true;
        }
        return false;
    }

    function getList(){
        $query = "SELECT user_id, fist_name, last_name
            FROM
                " . $this->table_name ;
        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    function create(){
        $query = "INSERT INTO
                " . $this->table_name . "
            SET
                fist_name=:fist_name, last_name=:last_name";
        $stmt = $this->conn->prepare($query);
        $this->fist_name=htmlspecialchars(strip_tags($this->fist_name));
        $this->last_name=htmlspecialchars(strip_tags($this->last_name));
        $stmt->bindParam(":fist_name", $this->fist_name);
        $stmt->bindParam(":last_name", $this->last_name);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    function update(){
        $query = "UPDATE
                " . $this->table_name . "
            SET
                fist_name = :fist_name,
                last_name = :last_name
            WHERE
                user_id = :user_id";

        $stmt = $this->conn->prepare($query);
        $this->fist_name=htmlspecialchars(strip_tags($this->fist_name));
        $this->last_name=htmlspecialchars(strip_tags($this->last_name));
        $stmt->bindParam(':fist_name', $this->fist_name);
        $stmt->bindParam(':last_name', $this->last_name);
        $stmt->bindParam(':user_id', $this->user_id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    function delete(){
        $query = "DELETE FROM " . $this->table_name . " WHERE user_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->user_id);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}