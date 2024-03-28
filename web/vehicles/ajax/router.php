<?php
require_once('../../../database/db.php');
require_once('../../../helpers/functions.php');
require_once('../../../class/Vehicle.php');
require_once('../../../class/Location.php');
require_once('../../../class/Terminal.php');
require_once('../../../class/Logs.php');
require_once('../../../class/User.php');
require_once('../../../session/session.php');

date_default_timezone_set('Asia/Manila');
$cldate = date('m/d/Y h:i a');

// session_start();

$login_id = '';
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
$term_code = '';
$plate = '';
$code = '';
$name = '';
$id = '';
$empty = false;
$Vehicle = new Vehicle;
$terminal = new Terminal();
$log = new Logs();

if (isset($_POST)) {
    $type   =   $_POST['type'];
    $term_code  =   strip_tags(trim($_POST['term_code']));
    $plate  =   strip_tags(trim(strtoupper($_POST['plate'])));
    $code   =   strip_tags(trim(strtoupper($_POST['code'])));
    $name   =   strip_tags(trim($_POST['name']));
    $id     =   strip_tags(trim($_POST['id']));

    if ($type == 'add' || $type == 'edit') {
        // validation for empty array field
        $required = array('plate','code', 'name', 'term_code');

        foreach($required as $field) {
            if ($_POST[$field] == '' || $_POST[$field] == 'null') {
                $empty = true;
                break;
            }
        }

        if ($empty == false) {

            if (preg_match('/[^a-zA-Z0-9,.()_ -]/', $code) || preg_match('/[^a-zA-Z0-9,.()_ -]/', $name)) {
                $errors[] = 'Special characters are not allowed.';
            }

            if ($type == 'add') {
                $rdup = $Vehicle->getDupVehic($plate);

                if (!empty($rdup)) {
                    $errors[] = 'Plate No already exists.';
                }
            }

            if ($type == 'edit') {
                $rdup = $Vehicle->getDupVehicByID($plate, $id);

                if (!empty($rdup)) {
                    $errors[] = 'Plate No already exists.';
                }
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

            $result_id = $Vehicle->addNewVehicle($plate, $code, $name, $term_code);

            $getvehic = $Vehicle->getVehicleByID($result_id);
            $ddata = $getvehic[0];
            $details = implode(':', $ddata);

            $act = 'Added vehicle data. [ID: '.$result_id.']';
            $logged = $log->addNewLog($login_id, $login_name, $login_termcode, $act, $details, $cldate);

            $response['type'] = 'success';
            $response['msg'] = 'Data successfully added.';

        } elseif ($type == 'edit') {

            $getvehic = $Vehicle->getVehicleByID($id);
            $ddata = $getvehic[0];
            $details = implode(':', $ddata);

            $act = 'Updated vehicle data. [ID: '.$id.']';
            $logged = $log->addNewLog($login_id, $login_name, $login_termcode, $act, $details, $cldate);

            $result = $Vehicle->updateVehicle($plate, $code, $name, $term_code, $id);
            $response['type'] = 'success';
            $response['msg'] = 'Data successfully updated.';

        } elseif ($type == 'delete') {

            $getvehic = $Vehicle->getVehicleByID($id);
            $ddata = $getvehic[0];
            $details = implode(':', $ddata);

            $act = 'Deleted vehicle data. [ID: '.$id.']';
            $logged = $log->addNewLog($login_id, $login_name, $login_termcode, $act, $details, $cldate);

            $result = $Vehicle->deleteVehicle($id);
            $response['type'] = 'success';
            $response['msg'] = 'Data successfully deleted.';

        } elseif ($type == 'changeloc') {
            if ($code != 'null') {
                
                $pd = new Location();
                $pdr = $pd->getLocName($code);
                
                if (!empty($pdr)) {
                    $response['type'] = 'success';
                    $pdname = $pdr[0]['loc_name'];
                    $response['plname'] = $pdname;
                }
    
            } else {
                $response['type'] = 'error';
                $response['msg'] = $errors;
            }
        }
    }
}

$response = json_encode($response);
echo $response;

?>