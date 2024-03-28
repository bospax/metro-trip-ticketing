<?php
require_once('../../../database/db.php');
require_once('../../../helpers/functions.php');
require_once('../../../class/Fleet.php');
require_once('../../../class/User.php');
require_once('../../../class/Terminal.php');
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

if (isset($_POST['type'])) {
    switch ($_POST['type']) {
        case 'table_fleet':
            
            $fleet = new Fleet();
            $result = $fleet->getAllFleet();

            if (!empty($gettermcode)) {
                $result = $fleet->getAllFleetByTermcode($gettermcode);
            }

            require_once "../html/table_fleet.php";
    
            break;
        
        default:
            # code...
            break;
    }
}
?>