<?php
require_once('../../../database/db.php');
require_once('../../../helpers/functions.php');
require_once('../../../class/Location.php');
require_once('../../../class/Driver.php');
require_once('../../../class/Vehicle.php');
require_once('../../../class/Trip.php');
require_once('../../../class/Ptrip.php');
require_once('../../../class/Consump.php');
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

$empty = false;
$response = [];
$errors = [];
$type = '';
$id = '';
$datef = '';
$plate = '';
$qty = '';
$cost = '';
$term = '';

$consump = new Consump();
$terminal = new Terminal();
$log = new Logs();

if (isset($_POST)) {
    $type = strip_tags(trim($_POST['type']));
    $id = strip_tags(trim($_POST['id']));
    $datef = strip_tags(trim($_POST['datef']));
    $plate = strip_tags(trim($_POST['plate']));
    $qty = strip_tags(trim($_POST['qty']));
    $cost = strip_tags(trim($_POST['cost']));
    $term = strip_tags(trim($_POST['term']));

    if ($type == 'add' || $type == 'edit') {
        $required = array('datef','plate','qty','cost');

        foreach($required as $field) {
            if ($_POST[$field] == '' || $_POST[$field] == 'null') {
                $empty = true;
                break;
            }
        }

        if ($empty == false) {

            if (!is_numeric($qty)) {
                $errors[] = 'You must enter a valid fuel quantity';
            }

        } else {
            $errors[] = 'Please fill up all required fields';
        }
    }

    if (!empty($errors)) {

        $response['type'] = 'error';
        $response['msg'] = $errors;

    } else {

        if ($type == 'add') {

            $cost = str_replace(',', '', $cost);
            $cpl = $cost / $qty;
            $cpl = round($cpl, 2);
            $addconsump = $consump->addNewConsump($plate, $datef, $qty, $cost, $cpl, $term);

            $getconsump = $consump->getConsumpByID($addconsump);
            $ddata = $getconsump[0];
            $details = implode(':', $ddata);

            $act = 'Added fuel transaction data. [ID: '.$addconsump.']';
            $logged = $log->addNewLog($login_id, $login_name, $login_termcode, $act, $details, $cldate);

            $response['type'] = 'success';
            $response['msg'] = 'Data successfully added.';

        } elseif($type == 'edit') {

            $cost = str_replace(',', '', $cost);
            $cpl = $cost / $qty;
            $cpl = round($cpl, 2);

            $getconsump = $consump->getConsumpByID($id);
            $ddata = $getconsump[0];
            $details = implode(':', $ddata);

            $act = 'Updated fuel transaction data. [ID: '.$id.']';
            $logged = $log->addNewLog($login_id, $login_name, $login_termcode, $act, $details, $cldate);

            $updatepconsump = $consump->updateConsump($plate, $datef, $qty, $cost, $cpl, $term, $id);
            $response['type'] = 'success';
            $response['msg'] = 'Data successfully updated.';
    
        } elseif ($type == 'delete') {

            $getconsump = $consump->getConsumpByID($id);
            $ddata = $getconsump[0];
            $details = implode(':', $ddata);

            $act = 'Deleted fuel transaction data. [ID: '.$id.']';
            $logged = $log->addNewLog($login_id, $login_name, $login_termcode, $act, $details, $cldate);

            $deleteconsump = $consump->deleteConsump($id);
            $response['type'] = 'success';
            $response['msg'] = 'Data successfully deleted.';

        }
    }
}

$response = json_encode($response);
echo $response;

?>