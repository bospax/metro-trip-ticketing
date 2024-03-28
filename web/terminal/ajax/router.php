<?php
require_once('../../../database/db.php');
require_once('../../../helpers/functions.php');
require_once('../../../class/Terminal.php');
require_once('../../../class/Logs.php');
require_once('../../../session/session.php');
require_once('../../../class/User.php');
// require_once('../../../class/Location.php');
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
$term_code = '';
$term_name = '';
$id = '';
$empty = false;
$terminal = new Terminal();
$log = new Logs();

if (isset($_POST)) {
    $type   =   $_POST['type'];
    $term_code   =   strip_tags(trim(strtoupper($_POST['term_code'])));
    $term_name   =   strip_tags(trim($_POST['term_name']));
    $id     =   strip_tags(trim($_POST['id']));

    if ($type == 'add' || $type == 'edit') {
        // validation for empty array field
        $required = array('term_code', 'term_name');

        foreach($required as $field) {
            if ($_POST[$field] == '' || $_POST[$field] == 'null') {
                $empty = true;
                break;
            }
        }

        if ($empty == false) {

            if (preg_match('/[^a-zA-Z0-9,.&()_ -]/', $term_code) || preg_match('/[^a-zA-Z0-9,.&()_ -]/', $term_name)) {
                $errors[] = 'Special characters are not allowed.';
            }

            if ($type == 'add') {
                $rdup = $terminal->getDupTerm($term_code);

                if (!empty($rdup)) {
                    $errors[] = 'Terminal Code already exists';
                }
            }

            if ($type == 'edit') {
                $rdup = $terminal->getDupTermByID($term_code, $id);

                if (!empty($rdup)) {
                    $errors[] = 'Terminal code already exists.';
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

            $result_id = $terminal->addNewTerminal($term_code, $term_name);

            $getterminal = $terminal->getTerminalByID($result_id);
            $ddata = $getterminal[0];
            $details = implode(':', $ddata);

            $act = 'Added terminal data. [ID: '.$result_id.']';
            $logged = $log->addNewLog($login_id, $login_name, $login_termcode, $act, $details, $cldate);

            $response['type'] = 'success';
            $response['msg'] = 'Data successfully added.';

        } elseif ($type == 'edit') {

            $getterminal = $terminal->getTerminalByID($id);
            $ddata = $getterminal[0];
            $details = implode(':', $ddata);

            $act = 'Updated terminal data. [ID: '.$id.']';
            $logged = $log->addNewLog($login_id, $login_name, $login_termcode, $act, $details, $cldate);

            $result = $terminal->updateTerminal($term_code, $term_name, $id);
            $response['type'] = 'success';
            $response['msg'] = 'Data successfully updated.';

        } elseif ($type == 'delete') {

            $getterminal = $terminal->getTerminalByID($id);
            $ddata = $getterminal[0];
            $details = implode(':', $ddata);

            $act = 'Deleted terminal data. [ID: '.$id.']';
            $logged = $log->addNewLog($login_id, $login_name, $login_termcode, $act, $details, $cldate);

            $result = $terminal->deleteTerminal($id);
            $response['type'] = 'success';
            $response['msg'] = 'Data successfully deleted.';

        }
    }
}

$response = json_encode($response);
echo $response;

?>