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
        $query = "SELECT * FROM categories WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $this->id);
        $stmt->execute();

        return $stmt;
    }

    public function create() {
        $query = "INSERT INTO categories (category) VALUES (:category)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':category', $this->category);

        return $stmt->execute();
    }

    public function update() {
        $query = "UPDATE categories SET category=:category WHERE id=:id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':category', $this->category);

        return $stmt->execute();
    }

    public function delete() {
        $query = "DELETE FROM categories WHERE id=:id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $this->id);

        return $stmt->execute();
    }
}