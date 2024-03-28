<?php
require_once('../../../database/db.php');
require_once('../../../helpers/functions.php');
require_once('../../../class/Trip.php');
require_once('../../../class/Terminal.php');
require_once('../../../class/Logs.php');
require_once('../../../class/User.php');
require_once('../../../session/session.php');

date_default_timezone_set('Asia/Manila');
$cldate = date('m/d/Y h:i a');

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
$type = '';
$id = '';
$empty = false;
$remark = '';

$terminal = new Terminal();
$log = new Logs();

if (isset($_POST)) {
    $type = $_POST['type'];
    $id = $_POST['id'];

    if ($type == 'getremark') {

        $Trip = new Trip;
        $result = $Trip->getTrip($id);
        $response[] = $result[0]['remarks'];

    } elseif ($type == 'updateremark') {
        $remark = $_POST['remark'];

        $Trip = new Trip;

        $gettrip = $Trip->getTrip($id);
        $ddata = $gettrip[0]['remarks'];
        
        if ($ddata != '') {
            $details = $ddata;
        } else {
            $details = $remark;
        }

        $act = 'Updated trip remarks. [ID: '.$id.']';
        $logged = $log->addNewLog($login_id, $login_name, $login_termcode, $act, $details, $cldate);

        $result = $Trip->updateRemark($id, $remark);
        $response[] = 'success';
    }
}

$response = json_encode($response);
echo $response;

?>