<?php
class Category {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read($id = null) {
        $query = "SELECT id, category FROM categories";

        if($id) {
            $query .= " WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$id]);
        } else {
            $stmt = $this->conn->query($query);
        }

        return $stmt;
    }

    public function create($data) {
        $stmt = $this->conn->prepare("INSERT INTO categories (category) VALUES (?)");
        $stmt->exeucte([$id]);
        return $stmt->rowCount();
    }
}