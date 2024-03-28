<?php
class Ptrip {
    private $db_handle;
    
    function __construct() {
        $this->db_handle = new DBController();
    }

    function getAllPtrip() {
        $query  = "SELECT * FROM ptrips ORDER BY `datecreated` DESC";
        $result = $this->db_handle->runBaseQuery($query);
        return $result;
    }

    function getAllPtripByTermcode($ttermcode) {
        $query  = "SELECT * FROM ptrips WHERE `term_code` = :ttermcode ORDER BY `datecreated` DESC";
        $params = [
            'ttermcode' => $ttermcode
        ];

        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function getPTripByID($id) {
        $query  = "SELECT * FROM ptrips WHERE `id` = :id";
        $params = [
            'id' => $id
        ];

        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function getDupPtrip($dateptrips, $ptripsdid, $ptripsdest) {
        $query = "SELECT * FROM ptrips WHERE `dateptrips` = :dateptrips AND `ptripsdid` = :ptripsdid AND `ptripsdest` = :ptripsdest";
        
        $params = [
            'dateptrips' => $dateptrips,
            'ptripsdid'  => $ptripsdid,
            'ptripsdest' => $ptripsdest
        ];

        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function getDupPtripVehic($dateptrips, $ptripsvehic, $ptripsdest) {
        $query = "SELECT * FROM ptrips WHERE `dateptrips` = :dateptrips AND `ptripsvehic` = :ptripsvehic AND `ptripsdest` = :ptripsdest";
        
        $params = [
            'dateptrips'    => $dateptrips,
            'ptripsvehic'   => $ptripsvehic,
            'ptripsdest'    => $ptripsdest
        ];

        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function getDupPtripByID($dateptrips, $ptripsdid, $id, $ptripsdest) {
        $query = "SELECT * FROM ptrips WHERE `dateptrips` = :dateptrips AND `ptripsdid` = :ptripsdid AND `id` != :id AND `ptripsdest` = :ptripsdest";
        
        $params = [
            'id'         => $id,
            'dateptrips' => $dateptrips,
            'ptripsdid'  => $ptripsdid,
            'ptripsdest' => $ptripsdest
        ];

        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function getDupPtripVehicByID($dateptrips, $ptripsvehic, $id, $ptripsdest) {
        $query = "SELECT * FROM ptrips WHERE `dateptrips` = :dateptrips AND `ptripsvehic` = :ptripsvehic AND `id` != :id AND `ptripsdest` = :ptripsdest";
        
        $params = [
            'id'            => $id,
            'dateptrips'    => $dateptrips,
            'ptripsvehic'   => $ptripsvehic,
            'ptripsdest'    => $ptripsdest
        ];

        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function getDestExist($dateptrips, $ptripsdest) {
        $query = "SELECT * FROM ptrips WHERE `dateptrips` = :dateptrips AND `ptripsdest` = :ptripsdest";
        
        $params = [
            'ptripsdest' => $ptripsdest,
            'dateptrips' => $dateptrips
        ];

        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function getDestExistByID($dateptrips, $ptripsdest, $id) {
        $query = "SELECT * FROM ptrips WHERE `dateptrips` = :dateptrips AND `ptripsdest` = :ptripsdest AND `id` != :id";
        
        $params = [
            'dateptrips' => $dateptrips,
            'ptripsdest' => $ptripsdest,
            'id' => $id,
        ];

        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function getPtripByDaterange($f, $t) {
        $query  = "SELECT * FROM ptrips WHERE `dateptrips` BETWEEN :f AND :t ORDER BY `datecreated`";
        $params = [
            'f' => $f,
            't' => $t
        ];

        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function getPtripByDaterangeAndTermcode($f, $t, $ttermcode) {
        $query  = "SELECT * FROM ptrips WHERE `dateptrips` BETWEEN :f AND :t AND `term_code` = :ttermcode ORDER BY `datecreated`";
        $params = [
            'f' => $f,
            't' => $t,
            'ttermcode' => $ttermcode
        ];

        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function getPtripByDate($pdate) {
        $query  = "SELECT * FROM ptrips WHERE `dateptrips` = :pdate ORDER BY `dateptrips`";
        $params = [
            'pdate' => $pdate
        ];

        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function getPtripByDateAndTermcode($pdate, $ttermcode) {
        $query  = "SELECT * FROM ptrips WHERE `dateptrips` = :pdate AND `term_code` = :ttermcode ORDER BY `dateptrips`";
        $params = [
            'pdate' => $pdate,
            'ttermcode' => $ttermcode
        ];

        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function updateTrip($dateptrips, $ptriptime, $ptripsdid, $ptripdname, $ptripsvehic, $ptripsorig, $ptripsdest, $ptripcompa, $term_code, $id) {
        $query = "UPDATE ptrips SET 
        `dateptrips`  = :dateptrips,
        `ptriptime`   = :ptriptime,
        `ptripsdid`   = :ptripsdid,
        `ptripdname`  = :ptripdname,
        `ptripsvehic` = :ptripsvehic,
        `ptripsorig`  = :ptripsorig,
        `ptripsdest`  = :ptripsdest,
        `ptripcompa`  = :ptripcompa,
        `term_code`   = :term_code
        WHERE `id`    = :id";

        $params = [
            'dateptrips'  => $dateptrips,
            'ptriptime'   => $ptriptime,
            'ptripsdid'   => $ptripsdid,
            'ptripdname'  => $ptripdname,
            'ptripsvehic' => $ptripsvehic,
            'ptripsorig'  => $ptripsorig,
            'ptripsdest'  => $ptripsdest,
            'ptripcompa'  => $ptripcompa,
            'term_code'   => $term_code,
            'id'          => $id
        ];
        
        $result = $this->db_handle->update($query, $params);
        return $result;
    }

    function addNewPtrip($dateptrips, $ptriptime, $ptripsdid, $ptripdname, $ptripsvehic, $ptripsorig, $ptripsdest, $ptripcompa, $term_code) {
        $query = "INSERT INTO ptrips (`dateptrips`,`ptriptime`,`ptripsdid`,`ptripdname`,`ptripsvehic`,`ptripsorig`,`ptripsdest`,`ptripcompa`,`term_code`) 
        VALUE (:dateptrips, :ptriptime, :ptripsdid, :ptripdname, :ptripsvehic, :ptripsorig, :ptripsdest, :ptripcompa, :term_code)";
        
        $params = [
            'dateptrips'    => $dateptrips,
            'ptriptime'     => $ptriptime,
            'ptripsdid'     => $ptripsdid,
            'ptripdname'    => $ptripdname,
            'ptripsvehic'   => $ptripsvehic,
            'ptripsorig'    => $ptripsorig,
            'ptripsdest'    => $ptripsdest,
            'ptripcompa'    => $ptripcompa,
            'term_code'     => $term_code
        ];

        $result = $this->db_handle->insert($query, $params);
        return $result;
    }

    function deletePtrip($id) {
        $query = "DELETE FROM ptrips WHERE id = :id";

        $params = [
            'id' => $id
        ];

        $result = $this->db_handle->insert($query, $params);
        return $result;
    }
}

?>