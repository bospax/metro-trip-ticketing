<?php
require_once('core/init.php');
date_default_timezone_set('Asia/Manila');

$action = '';
$gettermcode = '';

if ($login_type != 'admin') {
    $gettermcode = $login_termcode;
}

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

switch ($action) {
    case 'trips':
        $trip = new Trip();
        $result = $trip->getAllTrip();
        $result_sms = $trip->getAllSms();
        $result_bounce = $trip->getAllBounce();

        if (!empty($gettermcode)) {
            $result = $trip->getAllTripByTermcode($gettermcode);
            $result_sms = $trip->getAllSmsByTermcode($gettermcode);
        }

        require_once('web/trips/trips.php');
        break;

    case 'fleet':
        $fleet = new Fleet();
        $result = $fleet->getAllFleet();

        if (!empty($gettermcode)) {
            $result = $fleet->getAllFleetByTermcode($gettermcode);
        }

        require_once('web/fleet/fleet.php');
        break;

    case 'terminal':
        $terminal = new Terminal();
        $result = $terminal->getAllTerminal();
        require_once('web/terminal/terminal.php');
        break;
    
    case 'vehicles':
        $vehicle = new Vehicle();
        $result = $vehicle->getAllVehicles();
        
        if (!empty($gettermcode)) {
            $result = $vehicle->getAllVehiclesByTermcode($gettermcode);
        }

        require_once('web/vehicles/vehicles.php');
        break;

    case 'drivers':
        $driver = new Driver();
        $result = $driver->getAllDrivers();

        if (!empty($gettermcode)) {
            $result = $driver->getAllDriversByTermcode($gettermcode);
        }

        require_once('web/drivers/drivers.php');
        break;

    case 'contacts':
        $contact = new contact();
        $result = $contact->getAllContact();
        require_once('web/contacts/contacts.php');
        break;
    
    case 'locations':
        
        $location = new Location();
        $result = $location->getAllLocation();

        if (!empty($gettermcode)) {
            $result = $location->getAllLocationByTermcode($gettermcode);
        }

        require_once('web/locations/locations.php');
        break;

    case 'reports':
        $cdate = date('m/d/Y');
        $trip = new Trip();
        $result = $trip->getAllTrip();
        $result_bounce = $trip->getAllBounce();
        $result_mp = $trip->getManPower($cdate);

        require_once('web/reports/reports.php');
        break;
        
    case 'ptrips':
        require_once('web/ptrips/ptrips.php');
        break;
    
    case 'consump':
        require_once('web/consump/consump.php');
        break;

    default:
        require_once('web/dashboard/dashboard.php');
        break;
}
?>

