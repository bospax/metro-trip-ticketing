<?php

class DBController {

    private $host = "localhost";
    private $user = "webdomai_pax";
    private $password = "ZlAz$)NALKsd";
    private $dbname = "webdomai_metro";
    private $dsn;
    private $conn;
    
    function __construct() {
        $this->conn = $this->connectDB();
    }
    
    //old
    // function connectDB() {
    //     $this->dsn = 'mysql:host='.$this->host.';dbname='.$this->dbname;
    //     $conn = new PDO($this->dsn, $this->user, $this->password);
    //     return $conn;
    // }
    
    //new for the Ñ
    function connectDB() {
        $this->dsn = 'mysql:host='.$this->host.';dbname='.$this->dbname.';charset=utf8mb4';
        $conn = new PDO($this->dsn, $this->user, $this->password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8mb4'"));
        return $conn;
    }
    
    function runBaseQuery($query, $params = []) {
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $results;
    }

    function insert($query, $params = []) {
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);

        return $this->conn->lastInsertId();
    }

    function update($query, $params = []) {
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
    }

    function delete($query, $params = []) {
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
    }
}
?>