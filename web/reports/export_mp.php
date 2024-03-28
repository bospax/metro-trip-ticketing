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
    $dates = '';
    $f = '';
    $t = '';
    $drivers = [];

    if (isset($_GET['daterange_mp'])) {
        $dates = $_GET['daterange_mp'];
        $termcode = $_GET['termcode'];
        $dates = explode(' - ', $dates);
        $f = $dates[0];
        $t = $dates[1];
    }

    $trip = new Trip();
    $results = $trip->getTripRange($f, $t);   

    if ($login_type == 'admin' && $termcode != 'null') {
        $results = $trip->getTripRangeByTermcode($f, $t, $termcode);
    } elseif ($login_type == 'admin' && $termcode == 'null') {
        $results = $trip->getTripRangeByTermcode($f, $t, $login_termcode);
    } else {
        $results = $trip->getTripRangeByTermcode($f, $t, $gettermcode);
    }
    
    foreach ($results as $k => $value) {
        $driver_id = $results[$k]['driver_id'];
        
        if (!in_array($driver_id, $drivers)) {
            $drivers[] = $driver_id;
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
    $filename = 'Project Metro Man Hour-'.$cdatetime.'.xls';
    
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=\"$filename\""); 
    
    $isPrintHeader = false;
    $header = ['Date','Plate no','Origin','Destination','Time Out','Time In','Travel Time','KM Run','Remarks'];
    $rows = [];

    for ($i = 0; $i < count($drivers); $i++) { 
        $kmrun_total = 0;
        $total_time = 0;

        $driver_id = $drivers[$i];
        $driver = new Driver();
        $results_driver = $driver->getDriver($driver_id);
        $results = $trip->getTripIndividual($driver_id, $f, $t);

        if ($login_type == 'admin' && $termcode != 'null') {

            // $results = $trip->getTripRangeByTermcode($from, $to, $termcode);
            $results_driver = $driver->getDriverByTermcode($driver_id, $termcode);
            $results = $trip->getTripIndividualByTermcode($driver_id, $f, $t, $termcode);

        } elseif ($login_type == 'admin' && $termcode == 'null') {

            // $results = $trip->getTripRangeByTermcode($from, $to, $login_termcode);
            $results_driver = $driver->getDriverByTermcode($driver_id, $login_termcode);
            $results = $trip->getTripIndividualByTermcode($driver_id, $f, $t, $login_termcode);

        } else {

            // $results = $trip->getTripRangeByTermcode($from, $to, $gettermcode);
            $results_driver = $driver->getDriverByTermcode($driver_id, $gettermcode);
            $results = $trip->getTripIndividualByTermcode($driver_id, $f, $t, $gettermcode);
        }

        if (!$isPrintHeader) {
            echo 'INDIVIDUAL DRIVERS TRIP TICKET'."\n\n";
            $isPrintHeader = true;
        }

        echo  $results_driver[0]['name']."\n";
        
        $isPrintHeader = false;
        foreach ($results as $row) {
            $kmrun = round($row['km_run'], 1);
            $travel_time = $row['raw_time'];

            // $kmrun = (int)$kmrun;
            // $travel_time = (int)$travel_time;

            $kmrun_total = $kmrun_total + $kmrun;
            $total_time = $total_time + $travel_time;

            if (!$isPrintHeader) {
                echo implode("\t", array_values($header)) ."\n";
                $isPrintHeader = true;
            }
            
            unset($row['id']);
            unset($row['month']);
            unset($row['driver_id']);
            unset($row['driver_name']);
            unset($row['status']);
            unset($row['dpt_odo']);
            unset($row['arv_odo']);
            unset($row['dr_no']);
            unset($row['no_bags']);
            unset($row['raw_time']);
            unset($row['att_timein']);
            unset($row['att_timeout']);

            // var_dump($row);

            echo implode("\t", array_values($row)) ."\n";
            // var_dump($kmrun_total);
            // var_dump($total_time);
        }

        $total_time = convertToHoursMins($total_time, '%02d h %02d min');

        echo "\n";
        echo 'TOTAL KM RUN: '."\t".$kmrun_total."\n";
        echo 'TOTAL TRAVEL TIME: '."\t".$total_time."\n\n";
    }

    exit();
?>