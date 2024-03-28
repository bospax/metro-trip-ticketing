<?php
require_once('../../../database/db.php');
require_once('../../../helpers/functions.php');
require_once('../../../class/Location.php');
require_once('../../../class/Driver.php');
require_once('../../../class/Vehicle.php');
require_once('../../../class/Trip.php');
require_once('../../../class/Ptrip.php');
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

$empty       = false;
$response    = [];
$errors      = [];
$type        = '';
$id          = '';
$term_code   = '';
$dateptrips  = '';
$ptriptime   = '';
$ptripsdid   = '';
$ptripdname  = '';
$ptripsvehic = '';
$ptripsorig  = '';
$ptripsdest  = '';
$ptripcompa  = '';
$cdate       = date('m/d/Y');
$ctime       = date('h:i a');
$ptrips      = new Ptrip();
$terminal = new Terminal();
$log = new Logs();
$driver = new Driver();

if (isset($_POST)) {
    $type        = strip_tags(trim($_POST['type']));
    $id          = strip_tags(trim($_POST['id']));
    $term_code   = strip_tags(trim($_POST['term_code']));
    $dateptrips  = strip_tags(trim($_POST['dateptrips']));
    $ptriptime   = strip_tags(trim($_POST['ptriptime']));
    $ptripsdid   = strip_tags(trim($_POST['ptripsdid']));
    $ptripdname  = strip_tags(trim($_POST['ptripdname']));
    $ptripsvehic = strip_tags(trim($_POST['ptripsvehic']));
    $ptripsorig  = strip_tags(trim($_POST['ptripsorig']));
    $ptripsdest  = strip_tags(trim($_POST['ptripsdest']));
    $ptripcompa  = strip_tags(trim($_POST['ptripcompa']));

    if ($type == 'add' || $type == 'edit') {
        // validation for empty array field
        $required = array('dateptrips','ptripsdid','ptripdname','ptripsvehic','ptripsorig','ptripsdest');

        foreach($required as $field) {
            if ($_POST[$field] == '' || $_POST[$field] == 'null') {
                $empty = true;
                break;
            }
        }

        if ($empty == false) {

            $rduptrip         = $ptrips->getDupPtrip($dateptrips, $ptripsdid, $ptripsdest);
            $rduptripvehic    = $ptrips->getDupPtripVehic($dateptrips, $ptripsvehic, $ptripsdest);
            $rduptripup       = $ptrips->getDupPtripByID($dateptrips, $ptripsdid, $id, $ptripsdest);
            $rduptripvehicup  = $ptrips->getDupPtripVehicByID($dateptrips, $ptripsvehic, $id, $ptripsdest);
            $destexist        = $ptrips->getDestExist($dateptrips, $ptripsdest);
            $destexistup      = $ptrips->getDestExistByID($dateptrips, $ptripsdest, $id);

            if ($type == 'add') {
                if (!empty($rduptrip)) {
                    $errors[] = 'A trip with that schedule already exists.';
                }
    
                if (!empty($rduptripvehic)) {
                    $errors[] = 'The vehicle is not available on that schedule.';
                }

                if (!empty($destexist)) {
                    $errors[] = 'A trip with that destination already exists.';
                }
            }

            if ($type == 'edit') {
                if (!empty($rduptripup)) {
                    $errors[] = 'A trip with that schedule already exists.';
                }

                if (!empty($rduptripvehicup)) {
                    $errors[] = 'The vehicle is not available on that schedule.';
                }

                if (!empty($destexistup)) {
                    $errors[] = 'A trip with that destination already exists.';
                }
            }

            if (preg_match('/[^a-zA-Z,._ -]/', $ptripcompa) || preg_match('/[^a-zA-Z,._ -]/', $ptripcompa)) {
                $errors[] = 'Companion field must contain letters and spaces only';
            }

            if ($dateptrips <= $cdate) {
                $errors[] = 'Please select a more ensuing date.';
            }

            if ($ptripsorig == $ptripsdest) {
                $errors[] = 'Same Origin and Destination is not allowed.';
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

            $addptrip = $ptrips->addNewPtrip($dateptrips, $ptriptime, $ptripsdid, $ptripdname, $ptripsvehic, $ptripsorig, $ptripsdest, $ptripcompa, $term_code);
            
            $getptrip = $ptrips->getPTripByID($addptrip);
            $ddata = $getptrip[0];
            $details = implode(':', $ddata);

            $act = 'Added planned trip data. [ID: '.$addptrip.']';
            $logged = $log->addNewLog($login_id, $login_name, $login_termcode, $act, $details, $cldate);
            
            $response['type'] = 'success';
            $response['msg'] = 'Data successfully added.';

        } elseif($type == 'edit') {

            $getptrip = $ptrips->getPTripByID($id);
            $ddata = $getptrip[0];
            $details = implode(':', $ddata);

            $act = 'Updated planned trip data. [ID: '.$id.']';
            $logged = $log->addNewLog($login_id, $login_name, $login_termcode, $act, $details, $cldate);

            $updateptrip = $ptrips->updateTrip($dateptrips, $ptriptime, $ptripsdid, $ptripdname, $ptripsvehic, $ptripsorig, $ptripsdest, $ptripcompa, $term_code, $id);
            $response['type'] = 'success';
            $response['msg'] = 'Data successfully updated.';
    
        } elseif ($type == 'changedid') {
            // get driver by id
            if ($ptripsdid != 'null') {
                
                $pd = new Driver();
                $pdr = $pd->getDriver($ptripsdid);
                
                if (!empty($pdr)) {
                    $response['type'] = 'success';
                    $pdname = $pdr[0]['name'];
                    $response['pdname'] = $pdname;
                }
    
            } else {
                $response['type'] = 'error';
                $response['msg'] = $errors;
            }

        } elseif ($type == 'delete') {

            $getptrip = $ptrips->getPTripByID($id);
            $ddata = $getptrip[0];
            $details = implode(':', $ddata);

            $act = 'Deleted planned trip data. [ID: '.$id.']';
            $logged = $log->addNewLog($login_id, $login_name, $login_termcode, $act, $details, $cldate);

            $deleteptrip = $ptrips->deletePtrip($id);
            $response['type'] = 'success';
            $response['msg'] = 'Data successfully deleted.';

        }
    }
}

$response = json_encode($response);
echo $response;

?>