<?php
require_once('database/db.php');
require_once('helpers/functions.php');
require_once('class/Trip.php');
require_once('class/Fleet.php');
require_once('class/Vehicle.php');
require_once('class/Driver.php');
require_once('class/Contact.php');
require_once('class/Location.php');
require_once('class/User.php');
require_once('class/Ptrip.php');
require_once('class/Consump.php');
require_once('class/Terminal.php');
require_once('class/Masterloc.php');
require_once('class/Logs.php');

session_start();

$login_name = '';
$login_uname = '';
$login_type = '';
$login_termcode = '';
$login_termname = '';

if (!isset($_SESSION['user_fm'])) {

    header('location: web/authenticate/login.php');

} else {

    $username = $_SESSION['user_fm'];
    $User = new User;
    $result = $User->getUsername($username);

    if (!empty($result)) {
        $login_name = $result[0]['aname'];
        $login_uname = $result[0]['username'];
        $login_type = $result[0]['type'];
        $login_termcode = $result[0]['term_code'];
    }

    $terminal = new Terminal();
    $terms = $terminal->getTermNameByCode($login_termcode);
    
    if (!empty($terms)) {
        $login_termname = $terms[0]['term_name'];
    }
}

?>