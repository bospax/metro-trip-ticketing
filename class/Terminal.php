<?php 
class Terminal {
    private $db_handle;
    
    function __construct() {
        $this->db_handle = new DBController();
    }

    function getAllTerminal() {
        $query = "SELECT * FROM terminal";
        $result = $this->db_handle->runBaseQuery($query);
        return $result;
    }

    function getTerminalByID($id) {
        $query = "SELECT * FROM terminal WHERE id = :id";
        $params = [
            'id' => $id
        ];
        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function getTerminalByTermcode($term_code) {
        $query = "SELECT * FROM terminal WHERE `term_code` = :term_code";
        
        $params = [
            'term_code' => $term_code
        ];

        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function getDupTerm($term_code) {
        $query = "SELECT * FROM terminal WHERE `term_code` = :term_code";
        
        $params = [
            'term_code' => $term_code
        ];

        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function getDupTermByID($term_code, $tid) {
        $query = "SELECT * FROM terminal WHERE `term_code` = :term_code AND `id` != :tid";
        
        $params = [
            'term_code' => $term_code,
            'tid' => $tid
        ];

        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function getTermNameByCode($term_code) {
        $query = "SELECT * FROM terminal WHERE `term_code` = :term_code";
        
        $params = [
            'term_code' => $term_code
        ];

        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function addNewTerminal($term_code, $term_name) {
        $query = "INSERT INTO terminal (`term_code`, `term_name`) VALUE (:term_code, :term_name)";
        $params = [
            'term_code' => $term_code,
            'term_name' => $term_name
        ];

        $result = $this->db_handle->insert($query, $params);
        return $result;
    }

    function updateTerminal($term_code, $term_name, $id) {
        $query = "UPDATE `terminal` SET `term_code` = :term_code, `term_name` = :term_name WHERE id = :id";
        $params = [
            'id' => $id,
            'term_code' => $term_code,
            'term_name' => $term_name
        ];

        $result = $this->db_handle->update($query, $params);
        return $result;
    }

    function deleteTerminal($id) {
        $query = "DELETE FROM terminal WHERE id = :id";
        $params = [
            'id' => $id
        ];

        $result = $this->db_handle->delete($query, $params);
        return $result;
    }
}
?>