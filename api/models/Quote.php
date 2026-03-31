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

    // ✅ GET ALL (WITH FILTER SUPPORT)
    public function read($where = "", $params = []) {

        $query = "SELECT q.id, q.quote, a.author, c.category
                  FROM quotes q
                  JOIN authors a ON q.author_id = a.id
                  JOIN categories c ON q.category_id = c.id
                  $where
                  ORDER BY q.id";

        $stmt = $this->conn->prepare($query);

        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }

        $stmt->execute();
        return $stmt;
    }

    // ✅ GET SINGLE
    public function read_single() {

        $query = "SELECT q.id, q.quote, a.author, c.category
                  FROM quotes q
                  JOIN authors a ON q.author_id = a.id
                  JOIN categories c ON q.category_id = c.id
                  WHERE q.id = :id
                  LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();

        return $stmt;
    }

    // ✅ CREATE (POSTGRES FIX)
    public function create(){

        $query = "INSERT INTO quotes (quote, author_id, category_id)
                  VALUES (:quote, :author_id, :category_id)
                  RETURNING id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':quote', $this->quote);
        $stmt->bindParam(':author_id', $this->author_id);
        $stmt->bindParam(':category_id', $this->category_id);

        if ($stmt->execute()) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['id']; // ✅ RETURN NEW ID
        }

        return false;
    }

    // ✅ UPDATE
    public function update(){

        $query = "UPDATE quotes
                  SET quote=:quote, author_id=:author_id, category_id=:category_id
                  WHERE id=:id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':quote', $this->quote);
        $stmt->bindParam(':author_id', $this->author_id);
        $stmt->bindParam(':category_id', $this->category_id);

        return $stmt->execute();
    }

    // ✅ DELETE
    public function delete(){

        $query = "DELETE FROM quotes WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);

        return $stmt->execute();
    }
}