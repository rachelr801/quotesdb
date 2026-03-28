<?php
class Author {
    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }

    public function read($id = null){
        $query = "SELECT id, author FROM authors";

        if($id) {
            $query .= " WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$id]);
        } else{
            $stmt = $this->conn->query($query);
        }
        
        return $stmt;
    }

    public function create($data) {
        $stmt = $this->conn->prepare("INSERT INTO authors (author) VALUES (?)");
        $stmt->execute([$data->author]);
        return $this->conn->lastInsertId();
    }

    public function update($data){
        $stmt = $this->conn->prepaer("UPDATE authors SET authors=? WHERE id=?");
        $stmt->execute([$data->author, $data->id]);
        return $stmt->rowCount();
    }

    public function delete($id){
        $stmt = $this->conn->prepare("DELETE FROM authors WHERE id=?");
        return $stmt->rowCount();
    }
}