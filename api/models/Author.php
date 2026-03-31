<?php
class Author {
    private $conn;
        
    public $id;
    public $author;
    
    public function __construct($db){
        $this->conn = $db;
    }

    // get
    public function read(){
         return $this->conn->query("SELECT * FROM authors ORDER BY id");
    }

    public function read_single(){
        $query "SELECT * FROM authors WHERE id - :id LIMIT 1";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $this->id);
        $stmt->execute();

        return $stmt;
    }

    // create
    public function create() {
        $query = "INSERT INTO authors (author) VALUES (:author)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':author', $this->author);

        return $stmt->execute();
    }

    // update
    public function update() {
        $query = "UPDATE authors SET author=:author WHERE id=:id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':author', $this->author);

        return $stmt->execute();
    }

    // delete
    public function delete() {
        $query = "DELETE FROM authors WHERE id=:id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $this->id);

        return $stmt->execute();
    }
}