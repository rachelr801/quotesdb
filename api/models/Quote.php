<?php
    class Quote {
        // DB stuff
        private $conn;
        private $table = 'quotes';

        // post properties
        public $id;
        public $quote;
        public $author_id;
        public $category_id;

        public function __construct($db) {
            $this->conn = $db;
        }

        // get all
        public function read($params = []) {
            $query = "SELECT q.id, q.quote, a.author, c.catgory
                    FROM quotes q
                    JOIN authors a ON q.author_id = a.id
                    JOIN categories c ON q.category_id = c.id";
            
            $conditions = [];
            
            if(isset($params['id'])){
                $conditions[] = "q.id = :id";
            }
            if(isset($params['author_id'])){
                $conditions[] = "q.author_id = :author_id";
            }
            if(isset($params['category_id'])){
                $conditions[] = "q.category_id = :category_id";
            }

            if(count($conditions) > 0){
                $query .= " WHERE " . implode(" AND ", $conditions);
            }

            $stmt = $this->conn->prepare($query);

            foreach($params as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }

            $stmt->execute();
            return $stmt;
        }

        public function create($data){
            $stmt = $this->conn->prepare(
                "INSERT INTO quotes (quote, author_id, category_id) VALUES (?, ?, ?)"
            );
            
            $stmt->execute([$data->quote, $data->author_id, $data->category_id]);
            return $this->conn->lastInsertId();
        }

        public function update($data){
            $stmt = $this->conn->prepare(
                "UPDATE quotes SET quote=?, author_id=?, category_id=?, WHERE id=?"
            );

            $stmt->execute([
                $data->quote,
                $data->author_id,
                $data->category_id,
                $data->id
            ]);

            return $stmt->rowCount();
        }

        public function delete($id){
            $stmt = $this->conn->prepare("DELETE FROM quotes WHERE id=-?");
            $stmt->execute([$id]);
            return $stmt->rowCount();
        }
    }