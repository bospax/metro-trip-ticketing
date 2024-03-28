<?php 
class Location {
    private $db_handle;
    
    function __construct() {
        $this->db_handle = new DBController();
    }
    
    function getAllLocation() {
        $query = "SELECT * FROM locations";
        $result = $this->db_handle->runBaseQuery($query);
        return $result;
    }

    function getAllLocationByTermcode($termcode) {
        $query = "SELECT * FROM locations WHERE `term_code` = :termcode";
        $params = [
            'termcode' => $termcode
        ];

        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function getLocByID($lid) {
        $query = "SELECT * FROM locations WHERE loc_code = :lid";
        $params = [
            'lid' => $lid
        ];
        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function getLocByRealID($rlid) {
        $query = "SELECT * FROM locations WHERE id = :rlid";
        $params = [
            'rlid' => $rlid
        ];
        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function getDupLoc($loc_code, $term_code) {
        $query = "SELECT * FROM locations WHERE loc_code = :loc_code AND term_code = :term_code";
        $params = [
            'loc_code' => $loc_code,
            'term_code' => $term_code
        ];
        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function getDupLocByID($loc_code, $term_code, $id) {
        $query = "SELECT * FROM locations WHERE loc_code = :loc_code AND term_code = :term_code AND id != :id";
        $params = [
            'loc_code' => $loc_code,
            'term_code' => $term_code,
            'id' => $id
        ];
        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function addNewLocation($loc_code, $loc_name, $term_code) {
        $query = "INSERT INTO locations (`loc_code`,`loc_name`,`term_code`) VALUE (:loc_code, :loc_name, :term_code)";
        $params = [
            'loc_code' => $loc_code,
            'loc_name' => $loc_name,
            'term_code' => $term_code
        ];

        $result = $this->db_handle->insert($query, $params);
        return $result;
    }

    function updateLocation($loc_code, $loc_name, $term_code, $id) {
        $query = "UPDATE `locations` SET `loc_code` = :loc_code, `loc_name` = :loc_name, `term_code` = :term_code WHERE id = :id";
        $params = [
            'id' => $id,
            'loc_code' => $loc_code,
            'loc_name' => $loc_name,
            'term_code' => $term_code
        ];

        $result = $this->db_handle->update($query, $params);
        return $result;
    }

    function deleteLocation($id) {
        $query = "DELETE FROM locations WHERE id = :id";
        $params = [
            'id' => $id
        ];

        $result = $this->db_handle->delete($query, $params);
        return $result;
    }

    function getLocName($loc_code) {
        $query = "SELECT * FROM `locations` WHERE `loc_code` = :loc_code";
        $params = [
            'loc_code' => $loc_code
        ];

        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }
}
?>