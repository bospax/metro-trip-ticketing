<?php
require_once('../../../database/db.php');
require_once('../../../helpers/functions.php');
require_once('../../../class/Driver.php');
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
$dname = '';
$dempid = '';
$dnum = '';
$id = '';
$lcode = '';
$lname = '';
$term = '';
$deptcode = '';
$deptname = '';
$empty = false;
$Driver = new Driver();
$terminal = new Terminal();
$log = new Logs();

if (isset($_POST)) {

    $type       =   $_POST['type'];
    $dname      =   strip_tags(trim($_POST['dname']));
    $dempid     =   strip_tags(trim(strtoupper($_POST['dempid'])));
    $dnum       =   strip_tags(trim(strtoupper($_POST['dnum'])));
    $id         =   strip_tags(trim(strtoupper($_POST['id'])));
    $lcode      =   strip_tags(trim(strtoupper($_POST['lcode'])));
    $lname      =   strip_tags(trim($_POST['lname']));
    $term       =   strip_tags(trim($_POST['term']));
    $deptcode   =   strip_tags(trim(strtoupper($_POST['deptcode'])));
    $deptname   =   strip_tags(trim($_POST['deptname']));

    if ($type == 'add' || $type == 'edit') {
        // validation for empty array field
        $required = array('dname', 'dempid', 'dnum', 'deptname', 'term');

        foreach($required as $field) {
            if ($_POST[$field] == '' || $_POST[$field] == 'null') {
                $empty = true;
                break;
            }
        }

        if ($empty == false) {

            if (preg_match("/^\+[0-9]{12}$/", $dnum) == true || preg_match("/^[0-9]{12}$/", $dnum) == true) {
                
            } else {
                $errors[] = 'Please enter a valid number format.';
            }

            if (preg_match('/[^a-zA-Z,._ -]/', $dname)) {
                $errors[] = 'Name must contain letters and spaces only';
            }

            if ($type == 'add') {
                $ddup = $Driver->getDupDriver($dempid);
                $mdup = $Driver->getDupMob($dnum);

                if (!empty($ddup)) {
                    $errors[] = 'Employee code already exists.';
                }

                if (!empty($mdup)) {
                    $errors[] = 'Mobile number already taken.';
                }
            }

            if ($type == 'edit') {
                $ddupid = $Driver->getDupDriverByID($dempid, $id);
                $mdupid = $Driver->getDupMobByID($dnum, $id);

                if (!empty($ddupid)) {
                    $errors[] = 'Employee code already exists.';
                }

                if (!empty($mdupid)) {
                    $errors[] = 'Mobile number already taken.';
                }
            }
            
        } else {
            $errors[] = 'Please fill up all required fields';
        }
    }

    if (!empty($errors)) {
        
        $response['type'] = 'error';
        $response['msg'] = $errors;
        $response = json_encode($response);
        echo $response;

    } else {
        
        if ($type == 'add') {

            $result_id = $Driver->addNewDriver($dname, $dempid, $dnum, $lcode, $lname, $term, $deptcode, $deptname);
            
            $getdriver = $Driver->getDriver($result_id);
            $ddata = $getdriver[0];
            $details = implode(':', $ddata);

            $act = 'Added driver data. [ID: '.$result_id.']';
            $logged = $log->addNewLog($login_id, $login_name, $login_termcode, $act, $details, $cldate);
            
            $response['type'] = 'success';
            $response['msg'] = 'Data successfully added.';
            $response = json_encode($response);
            echo $response;

        } elseif ($type == 'edit') {

            $getdriver = $Driver->getDriver($id);
            $ddata = $getdriver[0];
            $details = implode(':', $ddata);

            $act = 'Updated driver data. [ID: '.$id.']';
            $logged = $log->addNewLog($login_id, $login_name, $login_termcode, $act, $details, $cldate);

            $result = $Driver->updateDriver($dname, $dempid, $dnum, $id, $lcode, $lname, $term, $deptcode, $deptname);
            $response['type'] = 'success';
            $response['msg'] = 'Data successfully updated.';
            $response = json_encode($response);
            echo $response;

        } elseif ($type == 'delete') {

            $getdriver = $Driver->getDriver($id);
            $ddata = $getdriver[0];
            $details = implode(':', $ddata);

            $act = 'Deleted driver data. [ID: '.$id.']';
            $logged = $log->addNewLog($login_id, $login_name, $login_termcode, $act, $details, $cldate);

            $result = $Driver->deleteDriver($id);
            $response['type'] = 'success';
            $response['msg'] = 'Data successfully deleted.';

            $response = json_encode($response);
            echo $response;
            
        } elseif ($type == 'changeloc') {
            if ($term != 'null') {
                
                $terms = $terminal->getTermNameByCode($term);
                
                if (!empty($terms)) {
                    $response['type'] = 'success';
                    $tname = $terms[0]['term_name'];
                    $response['tname'] = $tname;
                }
                $response = json_encode($response);
                echo $response;
    
            } else {
                $response['type'] = 'error';
                $response['msg'] = $errors;
                $response = json_encode($response);
                echo $response;
            }
        }
    }
}

?>