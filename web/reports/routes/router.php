<?php
require_once('../../../database/db.php');
require_once('../../../helpers/functions.php');
require_once('../../../class/Trip.php');

if (isset($_POST['type'])) {
    switch ($_POST['type']) {
        case 'table_trip':
            
            $trip = new Trip();
            $result = $trip->getAllTrip();
            require_once "../html/table_trip.php";
    
            break;
        
        default:
            # code...
            break;
    }
}

?>