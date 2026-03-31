<?php
class Category {
    private $conn;
    public $id;
    public $category;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
        $stmt = $this->conn->prepare("SELECT * FROM categories");
        $stmt->execute();
        return $stmt;
    }

    public function read_single() {
        $stmt = $this->conn->prepare("SELECT * FROM categories WHERE id = :id");
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        return $stmt;
    }

    public function create() {
        $stmt = $this->conn->prepare(
            "INSERT INTO categories (category) VALUES (:category) RETURNING id"
        );
        $stmt->bindParam(':category', $this->category);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update() {
        $stmt = $this->conn->prepare(
            "UPDATE categories SET category = :category WHERE id = :id"
        );
        $stmt->bindParam(':category', $this->category);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function delete() {
        $stmt = $this->conn->prepare("DELETE FROM categories WHERE id = :id");
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        return $stmt->rowCount();
    }
}