<?php
require_once('../../../database/db.php');
require_once('../../../helpers/functions.php');
require_once('../../../class/Masterloc.php');
require_once('../../../class/Terminal.php');
require_once('../../../class/Logs.php');
require_once('../../../class/User.php');
require_once('../../../session/session.php');

// session_start();

date_default_timezone_set('Asia/Manila');
$cldate = date('m/d/Y h:i a');

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
$mastername = '';
$mastercode = '';
$id = '';
$empty = false;
$Masterloc = new Masterloc();
$terminal = new Terminal();
$log = new Logs();

if (isset($_POST)) {
    $type = strip_tags(trim($_POST['type']));
    $mastercode = strip_tags(trim(strtoupper($_POST['mastercode'])));
    $mastername = strip_tags(trim($_POST['mastername']));
    $id = strip_tags(trim($_POST['id']));

    if ($type == 'add' || $type == 'edit') {
        // validation for empty array field
        $required = array('mastercode','mastername');

        foreach($required as $field) {
            if ($_POST[$field] == '') {
                $empty = true;
                break;
            }
        }

        if ($empty == false) {

            if ($type == 'add') {
                $mlist = $Masterloc->getDupMasterloc($mastercode);

                if (!empty($mlist)) {
                    $errors[] = 'Location code already exists.';
                }
            }

            if ($type == 'edit') {
                $mlistid = $Masterloc->getDupMasterlocByID($mastercode, $id);

                if (!empty($mlistid)) {
                    $errors[] = 'Location code already exists.';
                }
            }

            // old
            // if (preg_match('/[^a-zA-Z0-9,.()_ -]/', $mastercode) || preg_match('/[^a-zA-Z0-9,.()_ -]/', $mastername)) {
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

            $addmasterloc = $Masterloc->addNewMasterloc($mastercode, $mastername);
           
            $getmloc = $Masterloc->getMasterlocByID($addmasterloc);
            $ddata = $getmloc[0];
            $details = implode(':', $ddata);

            $act = 'Added location data. [ID: '.$addmasterloc.']';
            $logged = $log->addNewLog($login_id, $login_name, $login_termcode, $act, $details, $cldate);

            $response['type'] = 'success';
            $response['msg'] = 'Data successfully added.';

        } elseif ($type == 'edit') {

            $getmloc = $Masterloc->getMasterlocByID($id);
            $ddata = $getmloc[0];
            $details = implode(':', $ddata);

            $act = 'Updated location data. [ID: '.$id.']';
            $logged = $log->addNewLog($login_id, $login_name, $login_termcode, $act, $details, $cldate);

            $updmasterloc = $Masterloc->updateMasterloc($mastercode, $mastername, $id);
            $response['type'] = 'success';
            $response['msg'] = 'Data successfully updated.';

        } elseif ($type == 'delete') {

            $getmloc = $Masterloc->getMasterlocByID($id);
            $ddata = $getmloc[0];
            $details = implode(':', $ddata);

            $act = 'Deleted location data. [ID: '.$id.']';
            $logged = $log->addNewLog($login_id, $login_name, $login_termcode, $act, $details, $cldate);

            $delmasterloc = $Masterloc->deleteMasterloc($id);
            $response['type'] = 'success';
            $response['msg'] = 'Data successfully deleted.';
        }
    }
}

$response = json_encode($response);
echo $response;

?>