<?php
require_once('../../../database/db.php');
require_once('../../../helpers/functions.php');
require_once('../../../class/Vehicle.php');
require_once('../../../class/Driver.php');
require_once('../../../class/Location.php');
require_once('../../../class/Terminal.php');
require_once('../../../class/User.php');
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
$empty = false;
$type = '';
$driver = new Driver();
$vehicle = new Vehicle();
$location = new Location();

if (isset($_POST)) {
    $type = $_POST['type'];
    
    $drivers = $driver->getAllDrivers();
    $vehicles = $vehicle->getAllVehicles();
    $locations = $location->getAllLocation();

    if ($login_type != 'admin') {
        $drivers = $driver->getAllDriversByTermcode($login_termcode);
        $vehicles = $vehicle->getAllVehiclesByTermcode($login_termcode);
        $locations = $location->getAllLocationByTermcode($login_termcode);
    }

    $count_vehicles = count($vehicles);
    $count_drivers = count($drivers);
    $count_locations = count($locations);

    $response['totaldrivers'] = $count_drivers;
    $response['totalvehicles'] = $count_vehicles;
    $response['totallocations'] = $count_locations;
}

$response = json_encode($response);
echo $response;

?>
