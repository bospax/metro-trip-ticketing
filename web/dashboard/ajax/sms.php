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

$response = [];
$errors = [];
$empty = false;
$type = '';

if (isset($_POST)) {
    $type = $_POST['type'];
    
    $Sms = new Trip;
    $result = $Sms->getAllSms();

    if ($login_type != 'admin') {
        $result = $Sms->getAllSmsByTermcode($login_termcode);
    }

    $count_sms = count($result);

    $Bounce = new Trip;
    $result = $Bounce->getAllBounce();

    if ($login_type != 'admin') {
        $result = $Bounce->getAllBounceByTermcode($login_termcode);
    }

    $count_bounce = count($result);

    $total = $count_bounce + $count_sms;
    $rate = 0;

    if ($total != 0) {
        $rate =  ($count_bounce / $total) * 100;
        $rate = round($rate, 2);
    }

    $response['sms'] = $total;
    $response['rate'] = $rate;
}

$response = json_encode($response);
echo $response;

?>