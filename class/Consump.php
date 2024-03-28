<?php
class Consump {
    private $db_handle;
    
    function __construct() {
        $this->db_handle = new DBController();
    }

    function getAllConsump() {
        $query = "SELECT * FROM consump";
        $result = $this->db_handle->runBaseQuery($query);
        return $result;
    }

    function getConsumpByID($id) {
        $query = "SELECT * FROM consump WHERE `id` = :id";
        $params = [
            'id' => $id
        ];

        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function getAllConsumpByTermcode($ttermcode) {
        $query = "SELECT * FROM consump WHERE `term_code` = :ttermcode";
        $params = [
            'ttermcode' => $ttermcode
        ];

        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function getConsumpByVehicle($f, $t, $plt) {
        $query = "SELECT * FROM consump WHERE `datef` BETWEEN :f AND :t AND plate = :plt";
        $params = [
            'f' => $f,
            't' => $t,
            'plt' => $plt
        ];

        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function addNewConsump($plate, $datef, $qty, $cost, $cpl, $term) {
        $query = "INSERT INTO 
        consump (`datef`,`plate`,`qty`,`cost`,`cpl`,`term_code`) 
        VALUE (:datef, :plate, :qty, :cost, :cpl, :term)";

        $params = [
            'datef' => $datef,
            'plate' => $plate,
            'qty' => $qty,
            'cost' => $cost,
            'cpl' => $cpl,
            'term' => $term
        ];

        $result = $this->db_handle->insert($query, $params);
        return $result;
    }

    function updateConsump($plate, $datef, $qty, $cost, $cpl, $term, $id) {
        $query = "UPDATE `consump` SET 
        `datef` = :datef,
        `plate` = :plate, 
        `qty` = :qty,
        `cost` = :cost,
        `cpl` = :cpl,
        `term_code` = :term
        WHERE id = :id";

        $params = [
            'datef' => $datef,
            'plate' => $plate,
            'qty' => $qty,
            'cost' => $cost,
            'cpl' => $cpl,
            'term' => $term,
            'id' => $id
        ];

        $result = $this->db_handle->update($query, $params);
        return $result;
    }

    function deleteConsump($id) {
        $query = "DELETE FROM consump WHERE id = :id";
        $params = [
            'id' => $id
        ];

        $result = $this->db_handle->delete($query, $params);
        return $result;
    }
}

?>