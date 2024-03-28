<?php 
class Vehicle {
    private $db_handle;
    
    function __construct() {
        $this->db_handle = new DBController();
    }
    
    function getAllVehicles() {
        $query = "SELECT * FROM vehicles";
        $result = $this->db_handle->runBaseQuery($query);
        return $result;
    }

    function getAllVehiclesByTermcode($termcode) {
        $query = "SELECT * FROM vehicles WHERE `term_code` = :termcode";
        $params = [
            'termcode' => $termcode
        ];

        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function getVehicleByID($vid) {
        $query = "SELECT * FROM vehicles WHERE id = :vid";
        $params = [
            'vid' => $vid
        ];
        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function getVehicleByPlate($vplt) {
        $clean = trim(str_replace(' ', '', $vplt));
        
        $query = "SELECT * FROM vehicles WHERE `plate_no` = :vplt OR `plate_no` = :clean";
        $params = [
            'vplt' => $vplt,
            'clean' => $clean
        ];
        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function getDupVehic($plate) {
        $query = "SELECT * FROM vehicles WHERE `plate_no` = :plate";
        
        $params = [
            'plate' => $plate
        ];

        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function getDupVehicByID($plate, $vid) {
        $query = "SELECT * FROM vehicles WHERE `plate_no` = :plate AND `id` != :vid";
        
        $params = [
            'plate' => $plate,
            'vid' => $vid
        ];

        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function addNewVehicle($plate, $code, $name, $term_code) {
        $query = "INSERT INTO vehicles (`plate_no`,`loc_code`, `loc_name`, `term_code`) VALUE (:plate, :loc_code, :loc_name, :term_code)";
        $params = [
            'plate' => $plate,
            'loc_code' => $code,
            'loc_name' => $name,
            'term_code' => $term_code
        ];

        $result = $this->db_handle->insert($query, $params);
        return $result;
    }

    function updateVehicle($plate, $code, $name, $term_code, $id) {
        $query = "UPDATE `vehicles` SET `plate_no` = :plate, `loc_code` = :loc_code, `loc_name` = :loc_name, `term_code` = :term_code WHERE id = :id";
        $params = [
            'id' => $id,
            'plate' => $plate,
            'loc_code' => $code,
            'loc_name' => $name,
            'term_code' => $term_code
        ];

        $result = $this->db_handle->update($query, $params);
        return $result;
    }

    function deleteVehicle($id) {
        $query = "DELETE FROM vehicles WHERE id = :id";
        $params = [
            'id' => $id
        ];

        $result = $this->db_handle->delete($query, $params);
        return $result;
    }
}
?>