<?php
class Logs {
    private $db_handle;
    
    function __construct() {
        $this->db_handle = new DBController();
    }

    function getAllLogs() {
        $query  = "SELECT * FROM `logs` ORDER BY `datecreated` DESC";
        $result = $this->db_handle->runBaseQuery($query);
        return $result;
    }

    function getAllLogsByTermcode($ttermcode) {
        $query  = "SELECT * FROM `logs` WHERE `terminal` = :ttermcode ORDER BY `datecreated` DESC";
        $params = [
            'ttermcode' => $ttermcode
        ];

        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function addNewLog($userid, $fullname, $terminal, $activity, $details, $cldate) {
        $addlq = "INSERT INTO logs (`userid`,`fullname`,`terminal`,`activity`,`details`,`datecreated`) 
        VALUES (:userid, :fullname, :terminal, :activity, :details, :cldate)";

        $addlp = [
            'userid' => $userid,
            'fullname' => $fullname,
            'terminal' => $terminal,
            'activity' => $activity,
            'details' => $details,
            'cldate' => $cldate
        ];

        $result = $this->db_handle->insert($addlq, $addlp);
        return $result;
    }
}

?>