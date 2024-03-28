<?php 
class Driver {
    private $db_handle;
    
    function __construct() {
        $this->db_handle = new DBController();
    }
    
    function getAllDrivers() {
        $query = "SELECT * FROM drivers";
        $result = $this->db_handle->runBaseQuery($query);
        return $result;
    }

    function getAllDriversByTermcode($termcode) {
        $query = "SELECT * FROM drivers WHERE `term` = :termcode";
        $params = [
            'termcode' => $termcode
        ];

        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function getDriver($id) {
        $query = "SELECT * FROM drivers WHERE id = :id";
        $params = [
            'id' => $id
        ];
        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function getDriverByTermcode($id, $ttermcode) {
        $query = "SELECT * FROM drivers WHERE id = :id AND `term` = :termcode";
        $params = [
            'id' => $id,
            'termcode' => $ttermcode
        ];
        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function getDupDriver($empid) {
        $query = "SELECT * FROM drivers WHERE `emp_id` = :empid";
        $params = [
            'empid' => $empid
        ];
        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function getDupDriverByID($empid, $id) {
        $query = "SELECT * FROM drivers WHERE `emp_id` = :empid AND `id` != :id";
        $params = [
            'empid' => $empid,
            'id' => $id
        ];
        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function getDupDriverByEmpID($empid) {
        $query = "SELECT * FROM drivers WHERE `emp_id` = :empid";
        $params = [
            'empid' => $empid
        ];
        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function getDupMob($mob) {
        $query = "SELECT * FROM drivers WHERE `number` = :mob";
        $params = [
            'mob' => $mob
        ];
        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function getDupMobByID($mob, $id) {
        $query = "SELECT * FROM drivers WHERE `number` = :mob AND `id` != :id";
        $params = [
            'mob' => $mob,
            'id' => $id
        ];
        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function addNewDriver($name, $empid, $number, $lcode, $lname, $term, $deptcode, $deptname) {
        $query = "INSERT INTO 
        drivers (`name`,`emp_id`,`number`,`lcode`,`lname`,`term`,`deptcode`,`deptname`) 
        VALUE (:driver, :empid, :mob, :lcode, :lname, :term, :deptcode, :deptname)";

        $params = [
            'driver'    => $name,
            'empid'     => $empid,
            'mob'       => $number,
            'lcode'     => $lcode,
            'lname'     => $lname,
            'term'      => $term,
            'deptcode'  => $deptcode,
            'deptname'  => $deptname
        ];

        $result = $this->db_handle->insert($query, $params);
        return $result;
    }

    function updateDriver($name, $emp_id, $number, $id, $lcode, $lname, $term, $deptcode, $deptname) {
        $query = "UPDATE `drivers` SET 
        `name` = :driver,
        `emp_id` = :empid, 
        `number` = :mob,
        `lcode` = :lcode,
        `lname` = :lname,
        `term` = :term,
        `deptcode` = :deptcode,
        `deptname` = :deptname
        WHERE id = :id";

        $params = [
            'id' => $id,
            'driver' => $name,
            'empid' => $emp_id,
            'mob' => $number,
            'lcode'     => $lcode,
            'lname'     => $lname,
            'term'      => $term,
            'deptcode'  => $deptcode,
            'deptname'  => $deptname
        ];

        $result = $this->db_handle->update($query, $params);
        return $result;
    }

    function deleteDriver($id) {
        $query = "DELETE FROM drivers WHERE id = :id";
        $params = [
            'id' => $id
        ];

        $result = $this->db_handle->delete($query, $params);
        return $result;
    }
}
?>