<?php
class TripTickets{
 
    // database connection and table name
    private $conn;
    private $table_name = "trips";
 
    // object properties
    public $id;
    public $datein;
    public $plate_no;
    public $status;
    public $origin;
    public $destination;
    public $dpt_odo;
    public $arv_odo;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    public function read($id) {
        //select all data
        $query = "SELECT id, datein, plate_no, status, origin, destination, dpt_odo, arv_odo FROM ". $this->table_name ."
        WHERE plate_no = ? ORDER BY id";
 
          // prepare query statement
          $stmt = $this->conn->prepare($query);

          // bind id of product to be updated
          $stmt->bindParam(1, $id);
  
          // execute query
          $stmt->execute();
 
        return $stmt;
    }

  
}
?>