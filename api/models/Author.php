<?php
class Author {
    private $conn;
    public $id;
    public $author;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
        $stmt = $this->conn->prepare("SELECT * FROM authors");
        $stmt->execute();
        return $stmt;
    }

    public function read_single() {
        $stmt = $this->conn->prepare("SELECT * FROM authors WHERE id = :id");
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        return $stmt;
    }

    public function create() {
        $stmt = $this->conn->prepare(
            "INSERT INTO authors (author) VALUES (:author) RETURNING id"
        );
        $stmt->bindParam(':author', $this->author);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update() {
        $stmt = $this->conn->prepare(
            "UPDATE authors SET author = :author WHERE id = :id"
        );
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function delete() {
        $stmt = $this->conn->prepare("DELETE FROM authors WHERE id = :id");
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        return $stmt->rowCount();
    }
}