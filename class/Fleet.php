<?php 
class Fleet {
    private $db_handle;
    
    function __construct() {
        $this->db_handle = new DBController();
    }
    
    function getAllFleet() {
        date_default_timezone_set('Asia/Manila');
        $cdate =  date('m/d/Y');

        $query = "SELECT * FROM fleet WHERE `date` = :cdate";
        $params = [
            'cdate' => $cdate
        ];
        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function getAllFleetByTermcode($termcode) {
        date_default_timezone_set('Asia/Manila');
        $cdate =  date('m/d/Y');

        $query = "SELECT * FROM fleet WHERE `date` = :cdate AND `term_code` = :termcode";
        $params = [
            'cdate' => $cdate,
            'termcode' => $termcode
        ];
        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }
}
?>