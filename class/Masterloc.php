<?php 
class Masterloc {
    private $db_handle;
    
    function __construct() {
        $this->db_handle = new DBController();
    }
    
    function getAllMasterloc() {
        $query = "SELECT * FROM masterloc";
        $result = $this->db_handle->runBaseQuery($query);
        return $result;
    }

    function getMasterlocByID($id) {
        $query = "SELECT * FROM masterloc WHERE `id` = :id";
        $params = [
            'id' => $id
        ];

        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function getMasterLocName($mastercode) {
        $query = "SELECT * FROM `masterloc` WHERE `mastercode` = :mastercode";
        $params = [
            'mastercode' => $mastercode
        ];

        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function addNewMasterloc($mastercode, $mastername) {
        $query = "INSERT INTO masterloc (`mastercode`,`mastername`) VALUE (:mastercode, :mastername)";
        $params = [
            'mastercode' => $mastercode,
            'mastername' => $mastername
        ];

        $result = $this->db_handle->insert($query, $params);
        return $result;
    }

    function updateMasterloc($mastercode, $mastername, $id) {
        $query = "UPDATE `masterloc` SET `mastercode` = :mastercode, `mastername` = :mastername WHERE id = :id";
        $params = [
            'id' => $id,
            'mastercode' => $mastercode,
            'mastername' => $mastername
        ];

        $result = $this->db_handle->update($query, $params);
        return $result;
    }

    function deleteMasterloc($id) {
        $query = "DELETE FROM masterloc WHERE id = :id";
        $params = [
            'id' => $id
        ];

        $result = $this->db_handle->delete($query, $params);
        return $result;
    }

    function getDupMasterloc($mastercode) {
        $query = "SELECT * FROM masterloc WHERE `mastercode` = :mastercode";
        $params = [
            'mastercode' => $mastercode
        ];
        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function getDupMasterlocByID($mastercode, $id) {
        $query = "SELECT * FROM masterloc WHERE `mastercode` = :mastercode AND id != :id";
        $params = [
            'mastercode' => $mastercode,
            'id' => $id
        ];
        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }
}
?>