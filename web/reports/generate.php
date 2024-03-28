<?php
require_once('../../database/db.php');
require_once('../../helpers/functions.php');
require_once('../../class/Trip.php');

$dates = '';
$from = '';
$to = '';

if (isset($_POST['daterange_trip'])) {
    $dates = $_POST['daterange_trip'];
    $dates = explode(' - ', $dates);
    $from = $dates[0];
    $to = $dates[1];
}

$trip = new Trip();
$result = $trip->getTripRange($from, $to);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Report Generator</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="dist/style.css">
</head>
<body>
    <div class="page-header text-center">

        <img class="logo" src="assets/images/rdf_logo.jpg" alt="">
        <h4>RDF Feed, Livestock & Foods, Inc.</h4>
        <b><h5>TRIP TICKET</h5></b>
        <p>DATE FROM: <?php echo $from; ?> TO: <?php echo $to; ?></p>
    </div>

    <div class="page-footer text-center">
        
        <p class="footer-text">Project Metro</p>

    </div>

    <div class="header-space"></div>

    <table class="blueTable text-center">
        <thead>
            <tr>
                <th>Month</th>
                <th>Date</th>
                <th>Driver</th>
                <th>Plate No</th>
                <th>Origin</th>
                <th>Destination</th>
                <th>Departure</th>
                <th>DPT Odo</th>
                <th>Arrival</th>
                <th>ARV Odo</th>
                <th>Total Time</th>
                <th>KM Run</th>
            </tr>
        </thead>

        <tbody>
        <?php if (!empty($result)) : ?>
            <?php foreach ($result as $k => $v) : ?>
                <tr>
                    <td class="text-center"><?php echo $result[$k]['month'] ?></td>
                    <td class="text-center"><?php echo $result[$k]['date'] ?></td>
                    <td class="text-center"><?php echo $result[$k]['driver_name'] ?></td>
                    <td class="text-center"><?php echo $result[$k]['plate_no'] ?></td>
                    <td class="text-center"><?php echo $result[$k]['origin'] ?></td>
                    <td class="text-center"><?php echo $result[$k]['destination'] ?></td>
                    <td class="text-center"><?php echo $result[$k]['dpt_time'] ?></td>
                    <td class="text-center"><?php echo $result[$k]['dpt_odo'] ?></td>
                    <td class="text-center"><?php echo $result[$k]['arv_time'] ?></td>
                    <td class="text-center"><?php echo $result[$k]['arv_odo'] ?></td>
                    <td class="text-center"><?php echo $result[$k]['total_time'] ?></td>
                    <td class="text-center"><?php echo round($result[$k]['km_run'], 1) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>

        <tfoot>
            <!-- <tr>
                <td>
                    <div class="page-footer-space"></div>
                </td>
            </tr> -->
        </tfoot>

    </table>

    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script>
        $(document).ready(function() {
            
            window.onload = function() { window.print(); }

        });
    </script>
</body>
</html>