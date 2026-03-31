<?php

class Category {
    private $conn;

    public $id;
    public $category;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
        return $this->conn->query("SELECT * FROM categories ORDER BY id");
    }

    public function read_single() {
        $stmt = $this->conn->prepare("SELECT * FROM categories WHERE id=:id LIMIT 1");

        $stmt->bindParam(":id", $this->id);
        $stmt->execute();

        return $stmt;
    }

    // ✅ CREATE FIX
    public function create() {
        $query = "INSERT INTO categories (category)
                  VALUES (:category)
                  RETURNING id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":category", $this->category);

        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC)['id'];
        }

        return false;
    }

    public function update() {
        $stmt = $this->conn->prepare("UPDATE categories SET category=:category WHERE id=:id");

        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":category", $this->category);

        return $stmt->execute();
    }

    public function delete() {
        $stmt = $this->conn->prepare("DELETE FROM categories WHERE id=:id");
        $stmt->bindParam(":id", $this->id);

        return $stmt->execute();
    }
}