<?php
class terminals{
 
    // database connection and table name
    private $conn;
    private $table_name = "terminal";
 
    // object properties
    public $id;
    public $term_code;
    public $term_name;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read locations
    public function read(){
        //select all data
        $query = "SELECT
                    id, term_code, term_name
                FROM
                    " . $this->table_name . "
                ORDER BY
                    id";
 
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
 
        return $stmt;
    }

  
}
?>