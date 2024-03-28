<?php
require_once('../../../database/db.php');
require_once('../../../helpers/functions.php');
require_once('../../../class/Trip.php');
require_once('../../../class/Terminal.php');
require_once('../../../class/User.php');
require_once('../../../session/session.php');

// session_start();

$login_name = '';
$login_uname = '';
$login_type = '';
$login_termcode = '';
$login_termname = '';
$gettermcode = '';

if (!isset($_SESSION['user_fm'])) {

    header('location: web/authenticate/login.php');

} else {

    $username = $_SESSION['user_fm'];
    $User = new User;
    $uresult = $User->getUsername($username);

    if (!empty($uresult)) {
        $login_id = $uresult[0]['id'];
        $login_name = $uresult[0]['aname'];
        $login_uname = $uresult[0]['username'];
        $login_type = $uresult[0]['type'];
        $login_termcode = $uresult[0]['term_code'];
    }

    $terminal = new Terminal();
    $terms = $terminal->getTermNameByCode($login_termcode);
    
    if (!empty($terms)) {
        $login_termname = $terms[0]['term_name'];
    }
}

if ($login_type != 'admin') {
    $gettermcode = $login_termcode;
}

date_default_timezone_set('Asia/Manila');
$response = [];
$errors = [];
$empty = false;
$type = '';
$plate = [];
$km = [];
$cdate =  date('m/d/Y');

if (isset($_POST)) {
    
    $Trip = new Trip;
    $result = $Trip->getKm($cdate);

    if ($login_type != 'admin') {
        $result = $Trip->getKmByTermcode($cdate, $login_termcode);
    }

    foreach ($result as $key => $value) {
        $plate[] = $result[$key]['plate_no'];
        $km[] = $result[$key]['km_run'];
    }

    $response['plate'] = $plate;
    $response['km_run'] = $km;
}

$response = json_encode($response);
echo $response;

?>