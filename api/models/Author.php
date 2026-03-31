<?php

class Author {
    private $conn;

    public $id;
    public $author;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
        return $this->conn->query("SELECT * FROM authors ORDER BY id");
    }

    public function read_single() {
        $stmt = $this->conn->prepare("SELECT * FROM authors WHERE id=:id LIMIT 1");
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();

        return $stmt;
    }

    // CREATE FIX
    public function create() {
        $query = "INSERT INTO authors (author)
                  VALUES (:author)
                  RETURNING id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":author", $this->author);

        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC)['id'];
        }

        return false;
    }

    public function update() {
        $stmt = $this->conn->prepare("UPDATE authors SET author=:author WHERE id=:id");

        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":author", $this->author);

        return $stmt->execute();
    }

    public function delete() {
        $stmt = $this->conn->prepare("DELETE FROM authors WHERE id=:id");
        $stmt->bindParam(":id", $this->id);

        return $stmt->execute();
    }
}