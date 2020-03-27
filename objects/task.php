<?php
class Task {
    const ENABLED_STATUS = [
        'View',
        'In Progress',
        'Done'
    ];
    private $conn;
    private $table_name = "task";

    public $id;
    public $title;
    public $description;
    public $status;
    public $assigned_user_id = NULL;

    public function __construct($db){
        $this->conn = $db;
    }

    function checkStatus($status) {
        return in_array($status, self::ENABLED_STATUS);
    }

    function assignUser() {
        $query = "UPDATE
                " . $this->table_name . "
            SET
                assigned_user_id = :assigned_user_id
            WHERE
                id = :id";
        $stmt = $this->conn->prepare($query);
        $this->assigned_user_id = $this->assigned_user_id;
        $stmt->bindParam(':assigned_user_id', $this->assigned_user_id);
        $stmt->bindParam(':id', $this->id);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    function getList(){
        $query = "SELECT id, title, description, status, assigned_user_id
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
                title=:title, description=:description, status=:status, assigned_user_id=:assigned_user_id";
        $stmt = $this->conn->prepare($query);

        $this->title=htmlspecialchars(strip_tags($this->title));
        $this->description=htmlspecialchars(strip_tags($this->description));
        $this->status=htmlspecialchars(strip_tags($this->status));

        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":assigned_user_id", $this->assigned_user_id);

        if ($stmt->execute()) {
            return true;
        }
        if(!$stmt) {
            throw new Exception($stmt->errorInfo());
        }

        return false;
    }

    function update(){
        $query = "UPDATE
                " . $this->table_name . "
            SET
                title = :title,
                description = :description
            WHERE
                id = :id";
        $stmt = $this->conn->prepare($query);
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':description', $this->description);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    function changeStatus(){
        $query = "UPDATE
                " . $this->table_name . "
            SET
                status = :status
            WHERE
                id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':id', $this->id);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }


    function delete(){
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}