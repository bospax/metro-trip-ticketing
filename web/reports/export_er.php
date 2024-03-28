<?php ob_start(); ?>

<?php
require_once('../../database/db.php');
require_once('../../helpers/functions.php');
require_once('../../class/Trip.php');
require_once('../../class/Driver.php');
?>

<?php
    date_default_timezone_set('Asia/Manila');
    $dates = '';
    $from = '';
    $to = '';

    if (isset($_GET['daterange_er'])) {
        $dates = $_GET['daterange_er'];
        $dates = explode(' - ', $dates);
        $from = $dates[0];
        $to = $dates[1];
    }

    $trip = new Trip();
    $result = $trip->getBounceRange($from, $to);

    $cdatetime = date('mdYhi');
    $filename = 'Project Metro Error Logs-'.$cdatetime.'.xls';
    
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=\"$filename\"");
    
    $isPrintHeader = false;

    echo 'ERROR LOGS DATE: '.$from.'-'.$to."\n\n";

    $header = ['ID','Sender','Message','Date Received','Name','Errors'];

    foreach ($result as $row) {
        if (!$isPrintHeader) {
            echo implode("\t", array_values($header)) ."\n";
            $isPrintHeader = true;
        }

        unset($row['date']);
        unset($row['to']);
        unset($row['sender_id']);

        echo implode("\t", array_values($row)) ."\n";
    }

    exit();
?>