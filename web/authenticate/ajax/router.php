<?php
require_once('../../../database/db.php');
require_once('../../../helpers/functions.php');
require_once('../../../class/User.php');
require_once('../../../web/authenticate/vendor/password.php');

$response = [];
$errors = [];
$type = '';
$aname = '';
$username = '';
$password = '';
$confirm = '';
$role = '';
$term_code = '';
$pkey = '';
$empty = false;
$pkadmin = 'ad.fHh()532W8@n~H;=Y;@n';
$pkuser = 'us5;[@w90U8J2Fg~&K8W"Wr';

if (isset($_POST)) {
    $type = $_POST['type'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($type == 'signup') {
        $aname = strip_tags(trim($_POST['aname']));
        $confirm = strip_tags(trim($_POST['confirm']));
        $role = $_POST['role'];
        $term_code = $_POST['term_code'];
        $pkey = strip_tags(trim($_POST['pkey']));

        // validation for empty array field
        $required = array('aname','username','password','confirm','pkey');

        foreach($required as $field) {
            if ($_POST[$field] == '') {
                $empty = true;
                break;
            }
        } 

        if ($empty == false) {

            $User = new User;
            $result = $User->getUsername($username);

            if (!empty($result)) {
                $errors[] = 'Username already in used.';
            }

            if (preg_match('/[^a-zA-Z0-9,._ -]/', $username) || preg_match('/[^a-zA-Z0-9,._ -]/', $aname)) {
                $errors[] = 'Special Characters are not allowed.';
            }

            if (strlen($password) < 8) {
                $errors[] = 'Password must be greater than 8 characters';
            }

            if ($password != $confirm) {
                $errors[] = 'Password did not matched.';
            }

            if ($role == 'user' && $pkey != $pkuser) {
                $errors[] = "You're not authorized to create this type of account.";
            }

            if ($role == 'admin' && $pkey != $pkadmin) {
                $errors[] = "You're not authorized to create this type of account.";
            }
            
        } else {
            $errors[] = 'All fields are required';
        }
    }

    if ($type == 'login') {
        $required = array('username','password');

        foreach($required as $field) {
            if ($_POST[$field] == '') {
                $empty = true;
                break;
            }
        } 

        if ($empty == false) {

            $User = new User;
            $result = $User->getUsername($username);

            if (!empty($result)) {
                $hashed = $result[0]['password'];

                if (!password_verify($password, $hashed)) {
                    $errors[] = 'Authentication Failed.';
                }

            } else {
                $errors[] = 'Authentication Failed.';
            }
            
        } else {
            $errors[] = 'All fields are required';
        }
    }

    if (!empty($errors)) {
        
        $response['type'] = 'error';
        $response['msg'] = $errors;

    } else {
        
        if ($type == 'signup') {

            $hashed = password_hash($password, PASSWORD_DEFAULT);

            $User = new User;
            $result = $User->addNewUser($aname, $username, $hashed, $role, $term_code);
            $response['type'] = 'success';
            $response['msg'] = 'Data successfully added.';

        } elseif ($type == 'login') {

            $User = new User;
            $result = $User->getUsername($username);

            session_start();
            $_SESSION['user_fm'] = $result[0]['username'];

            $response['type'] = 'success';
            $response['msg'] = 'Data successfully added.';
        }
    }
}

$response = json_encode($response);
echo $response;

?>