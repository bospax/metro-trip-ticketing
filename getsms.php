<?php
require_once('core/init.php');

if (isset($_GET['from'])) {
    $mfrom = $_GET['from'];
    $mto = $_GET['to'];
    $msg = $_GET['text'];
    $receivedAt = $_GET['receivedAt'];

    $trip = new Trip();
    $insertIds = $trip->addNewTrip($mfrom, $mto, $msg, $receivedAt);

    // return $insertId;
    // $count = count($insertIds);

    var_dump($insertIds);
}
?>