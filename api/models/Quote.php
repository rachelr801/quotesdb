<?php

class Quote {
    private $conn;

    public $id;
    public $quote;
    public $author_id;
    public $category_id;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read($where = "", $params = []) {

        $query = "SELECT 
                    q.id,
                    q.quote,
                    a.author,
                    c.category
                  FROM quotes q
                  JOIN authors a ON q.author_id = a.id
                  JOIN categories c ON q.category_id = c.id
                  $where";

        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt;
    }

    public function create() {

        $stmt = $this->conn->prepare(
            "INSERT INTO quotes (quote, author_id, category_id)
             VALUES (:quote, :author_id, :category_id)
             RETURNING id"
        );

        $stmt->bindParam(':quote', $this->quote);
        $stmt->bindParam(':author_id', $this->author_id);
        $stmt->bindParam(':category_id', $this->category_id);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC); // returns ['id' => x]
    }

    public function update() {

        $stmt = $this->conn->prepare(
            "UPDATE quotes
             SET quote = :quote,
                 author_id = :author_id,
                 category_id = :category_id
             WHERE id = :id"
        );

        $stmt->bindParam(':quote', $this->quote);
        $stmt->bindParam(':author_id', $this->author_id);
        $stmt->bindParam(':category_id', $this->category_id);
        $stmt->bindParam(':id', $this->id);

        $stmt->execute();

        return $stmt->rowCount() >= 0;
    }

    public function delete() {

        $stmt = $this->conn->prepare("DELETE FROM quotes WHERE id = :id");
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();

        return $stmt->rowCount();
    }
}