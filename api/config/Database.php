<?php
class Database {
    private $host = "dpg-d73jc6gule4c73eijiqg-a.oregon-postgres.render.com";
    private $db_name = "quotesdb_t5s0";
    private $username = "quotesdb_t5s0_user";
    private $password = "tff2mZDrnee2DZBlu5H9FHQCyjD51U3W";
    private $port = "5432";

    public function connect() {
        $conn = null;

        try {
            $conn = new PDO(
                "pgsql:host=$this->host;port=$this->port;dbname=$this->db_name",
                $this->username,
                $this->password
            );
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo json_encode(["message" => $e->getMessage()]);
        }

        return $conn;
    }
}