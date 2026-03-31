<?php
    class Quote {
        // DB stuff
        private $conn;
        private $table = "quotes";

        // post properties
        public $id;
        public $quote;
        public $author_id;
        public $category_id;

        public function __construct($db) {
            $this->conn = $db;
        }

        // get all
        public function read() {
            $query = "SELECT q.id, q.quote, a.author, c.category
                    FROM quotes q
                    JOIN authors a ON q.author_id = a.id
                    JOIN categories c ON q.category_id = c.id
                    WHERE q.id = :id LIMIT 1";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $this->id);
            $stmt->execute();

            return $stmt;
        }

    	// create
        public function create(){
            $query = "INSERT INTO quotes (quote, author_id, category_id) 
                    VALUES (:quote, :author_id, :category_id)";
            
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':quote', $this->quote);
            $stmt->bindParam(':author_id', $this->author_id);
            $stmt->bindParam(':category_id', $this->category_id);
            
            return $stmt->execute();
        }

    	// update
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

    	// delete
        public function delete(){
            $query = "DELETE FROM quotes WHERE id = :id";
            $stmt = $this->conn->prepare($query);

             $stmt->bindParam(':id', $this->id);

            return $stmt->execute();
        }
    }