<?php
class Locations{
 
    // database connection and table name
    private $conn;
    private $table_name = "locations";
 
    // object properties
    public $id;
    public $term_code;
    public $loc_code;
    public $loc_name;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read locations
    public function read() {
        //select all data
        $query = "SELECT id, term_code, loc_code, loc_name FROM ". $this->table_name ." ORDER BY id";
 
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
 
        return $stmt;
    }

  
}
?>