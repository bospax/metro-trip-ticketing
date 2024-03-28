<?php ob_start(); ?>

<?php
require_once('../../database/db.php');
require_once('../../helpers/functions.php');
require_once('../../class/Trip.php');
require_once('../../class/Driver.php');
require_once('../../class/Terminal.php');
require_once('../../class/User.php');
require_once('../../session/session.php');
?>

<?php

// session_start();

$login_name = '';
$login_uname = '';
$login_type = '';
$login_termcode = '';
$login_termname = '';
$gettermcode = '';
$termcode = '';

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

    date_default_timezone_set('Asia/Manila');
    $daterange = '';
    $from = '';
    $to = '';

    if (isset($_GET['daterange_idl'])) {
        $daterange = $_GET['daterange_idl'];
        $termcode = $_GET['termcode'];
        $daterange = explode(' - ', $daterange);
        $from = $daterange[0];
        $to = $daterange[1];
    }

    $trip = new Trip();
    $result = $trip->getTripRange($from, $to);

    if ($login_type == 'admin' && $termcode != 'null') {
        $result = $trip->getTripRangeByTermcode($from, $to, $termcode);
    } elseif ($login_type == 'admin' && $termcode == 'null') {
        $result = $trip->getTripRangeByTermcode($from, $to, $login_termcode);
    } else {
        $result = $trip->getTripRangeByTermcode($from, $to, $gettermcode);
    }

    $dates = [];
    $entry = [];
    $entries = [];
    $ctr = 0;

    foreach ($result as $k => $value) {
        if (!in_array($result[$k]['date'], $dates)) {
            $dates[] = $result[$k]['date'];
            $entry['date'] = $result[$k]['date'];
            $entry['driver_id'] = $result[$k]['driver_id'];
            $entries[] = $entry;
        }
    }

    // for ($i = 0; $i < count($drivers); $i++) { 
    //     $driver_id = $drivers[$i];
    //     $driver = new Driver();
    //     $results_driver = $driver->getDriver($driver_id);
    //     $results = $trip->getTripIndividual($driver_id, $f, $t);
    //     foreach ($results as $k => $value) {
    //         // var_dump($results[$k]['driver_name']);
    //     }
    //     var_dump($results);
    // }


    $cdatetime = date('mdYhi');
    $filename = 'Project Metro Idle Drivers-'.$cdatetime.'.xls';
    
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=\"$filename\""); 
    
    $isPrintHeader = false;
    $header = ['ID','Drivers Name','Mobile Number'];
    $rows = [];

    foreach ($dates as $date) :

        if (!$isPrintHeader) {
            echo 'IDLE DRIVERS'."\n\n";
            $isPrintHeader = true;
        }

        echo  $date."\n";
        
        $isPrintHeader = false;
        $driver = new Driver();
        $drivers = $driver->getAllDrivers();

        if ($login_type == 'admin' && $termcode != 'null') {
            $drivers = $driver->getAllDriversByTermcode($termcode);
        } elseif ($login_type == 'admin' && $termcode == 'null') {
            $drivers = $driver->getAllDriversByTermcode($login_termcode);
        } else {
            $drivers = $driver->getAllDriversByTermcode($gettermcode);
        }

        foreach ($drivers as $row) :

            $d = $date;
            $did = $row['id'];
            $trip_entry = $trip->getTripEntry($d, $did);

            if (empty($trip_entry)) :

                if (!$isPrintHeader) {
                    echo implode("\t", array_values($header)) ."\n";
                    $isPrintHeader = true;
                }

                echo implode("\t", array_values($row)) ."\n";

            endif;
        endforeach;

        echo "\n";

    $ctr++;
    endforeach;
    
    exit();
?>