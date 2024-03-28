<?php
require_once('../../../database/db.php');
require_once('../../../helpers/functions.php');
require_once('../../../class/Location.php');
require_once('../../../class/Masterloc.php');
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
$name = '';
$term_code = '';
$code = '';
$id = '';
$empty = false;
$Location = new Location();
$masterloc = new Masterloc();
$terminal = new Terminal();
$log = new Logs();

if (isset($_POST)) {
    $type = strip_tags(trim($_POST['type']));
    $term_code = strip_tags(trim($_POST['term_code']));
    $code = strip_tags(trim(strtoupper($_POST['code'])));
    $name = strip_tags(trim($_POST['name']));
    $id = strip_tags(trim($_POST['id']));

    if ($type == 'add' || $type == 'edit') {
        // validation for empty array field
        $required = array('code','name','term_code');

        foreach($required as $field) {
            if ($_POST[$field] == '' || $_POST[$field] == 'null') {
                $empty = true;
                break;
            }
        }

        if ($empty == false) {

            if ($type == 'add') {
                $llist = $Location->getDupLoc($code, $term_code);

                if (!empty($llist)) {
                    $errors[] = 'Location code already exists.';
                }
            }

            if ($type == 'edit') {
                $llistid = $Location->getDupLocByID($code, $term_code, $id);

                if (!empty($llistid)) {
                    $errors[] = 'Location code already exists.';
                }
            }

            //old
            // if (preg_match('/[^a-zA-Z0-9,.()_ -]/', $code) || preg_match('/[^a-zA-Z0-9,.()_ -]/', $name)) {
            //     $errors[] = 'Special characters are not allowed.';
            // }
            
            //new
            if (preg_match('/[^a-zA-Z0-9,.()_ \-ñÑ]/', $mastercode) || preg_match('/[^a-zA-Z0-9,.()_ \-ñÑ]/', $mastername)) {
                $errors[] = 'Special characters are not allowed.';
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

            $result_id = $Location->addNewLocation($code, $name, $term_code);

            $getloc = $Location->getLocByRealID($result_id);
            $ddata = $getloc[0];
            $details = implode(':', $ddata);

            $act = 'Added new location tag. [ID: '.$result_id.']';
            $logged = $log->addNewLog($login_id, $login_name, $login_termcode, $act, $details, $cldate);

            $response['id'] = $result_id;
            $response['type'] = 'success';
            $response['msg'] = 'Data successfully added.';

        } elseif ($type == 'edit') {

            $getloc = $Location->getLocByRealID($id);
            $ddata = $getloc[0];
            $details = implode(':', $ddata);

            $act = 'Updated location tag. [ID: '.$id.']';
            $logged = $log->addNewLog($login_id, $login_name, $login_termcode, $act, $details, $cldate);

            $result = $Location->updateLocation($code, $name, $term_code, $id);
            $response['type'] = 'success';
            $response['msg'] = 'Data successfully updated.';

        } elseif ($type == 'delete') {

            $getloc = $Location->getLocByRealID($id);
            $ddata = $getloc[0];
            $details = implode(':', $ddata);

            $act = 'Deleted location tag. [ID: '.$id.']';
            $logged = $log->addNewLog($login_id, $login_name, $login_termcode, $act, $details, $cldate);

            $result = $Location->deleteLocation($id);
            $response['type'] = 'success';
            $response['msg'] = 'Data successfully deleted.';
       
        } elseif ($type == 'changeloc') {

            if ($code != 'null') {
                
                $pdr = $masterloc->getMasterLocName($code);
                
                if (!empty($pdr)) {
                    $response['type'] = 'success';
                    $pdname = $pdr[0]['mastername'];
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