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

    if (isset($_GET['daterange'])) {
        $dates = $_GET['daterange'];
        $dates = explode(' - ', $dates);
        $from = $dates[0];
        $to = $dates[1];
    }

    $trip = new Trip();
    $result = $trip->getTripExport($from, $to);

    $cdatetime = date('mdYhi');
    $filename = 'Project Metro Trip Ticket-'.$cdatetime.'.xls';
    
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=\"$filename\"");
    
    
    $isPrintHeader = false;

    echo 'TRIP TICKET DATE: '.$from.'-'.$to."\n\n";

    $header = ['ID','Month','Date','Drivers Name','Plate No','Status','Origin','Destination','Departure','DPT Odo','Arrival','ARV Odo','Total Time','KM Run','Remarks'];

    foreach ($result as $row) {
        if (!$isPrintHeader) {
            echo implode("\t", array_values($header)) ."\n";
            $isPrintHeader = true;
        }
        echo implode("\t", array_values($row)) ."\n";
    }

    exit();
?>