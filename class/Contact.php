<?php 
class Contact {
    private $db_handle;
    
    function __construct() {
        $this->db_handle = new DBController();
    }
    
    function getAllContact() {
        $query = "SELECT * FROM contacts";
        $result = $this->db_handle->runBaseQuery($query);
        return $result;
    }
}
?>