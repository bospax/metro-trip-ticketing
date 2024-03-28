<?php 
class User {
    private $db_handle;
    
    function __construct() {
        $this->db_handle = new DBController();
    }

    function getAllUser() {
        $query = "SELECT * FROM user";
        $result = $this->db_handle->runBaseQuery($query);
        return $result;
    }

    function getUsername($uname) {
        $query = "SELECT * FROM user WHERE username = :uname";
        $params = [
            'uname' => $uname
        ];
        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function authUser($uname, $pass) {
        $query = "SELECT * FROM user WHERE `username` = :uname AND `password` = :pass";
        $params = [
            'uname' => $uname,
            'pass' => $pass
        ];
        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function addNewUser($aname, $uname, $pass, $role, $term) {
        $query = "INSERT INTO user (`aname`,`username`,`password`,`type`,`term_code`) VALUE (:aname, :uname, :pass, :rol, :term_code)";
        $params = [
            'aname' => $aname,
            'uname' => $uname,
            'pass' => $pass,
            'rol' => $role,
            'term_code' => $term
        ];

        $result = $this->db_handle->insert($query, $params);
        return $result;
    }
}
?>