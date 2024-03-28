<?php
require_once('../../database/db.php');
require_once('../../helpers/functions.php');
require_once('../../class/Trip.php');
require_once('../../class/Driver.php');
?>

<?php
    if (isset($_POST['daterange_mp'])) :
        $daterange = $_POST['daterange_mp'];
        $dates = explode(' - ', $daterange);
        $from = $dates[0];
        $to = $dates[1];
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
        <b><h5>MAN HOUR</h5></b>
        <p>DATE FROM: <?php echo $from; ?> TO: <?php echo $to; ?></p>
    </div>

    <div class="page-footer text-center">
        
        <p class="footer-text">Project Metro</p>

    </div>

    <div class="header-space"></div>

    <div>
        <?php
            $f = $dates[0];
            $t = $dates[1];
            $drivers = [];

            $trip = new Trip();
            $results = $trip->getTripRange($f, $t);   
            
            foreach ($results as $k => $value) {
                $driver_id = $results[$k]['driver_id'];
                
                if (!in_array($driver_id, $drivers)) {
                    $drivers[] = $driver_id;
                }
            }

            for ($i = 0; $i < count($drivers); $i++) :
                $driver_id = $drivers[$i];
                $kmrun_total = 0;
                $total_time = 0;
                $driver = new Driver();
                $results_driver = $driver->getDriver($driver_id);
                $results = $trip->getTripIndividual($driver_id, $f, $t);
        ?>
        
            <div style="page-break-inside: avoid;">
            <b>Driver Name: <?php echo $results_driver[0]['name']; ?></b>
            <div class="manhour-divider"></div>
            <table id="mytabledriver-<?php echo $results_driver[0]['id']; ?>" class="mytabledriver table table-bordered" style=" width: 100%;">
                <thead>
                    <tr class="emphasize">
                        <th>Date</th>
                        <th>Plate No</th>
                        <th>Origin</th>
                        <th>Destination</th>
                        <th>Time Out</th>
                        <th>Time In</th>
                        <th>Travel Time</th>
                        <th>KM Run</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $k => $value) : 
                        $kmrun = round($results[$k]['km_run'], 1);
                        $travel_time = $results[$k]['raw_time'];
                        $kmrun_total = $kmrun_total + $kmrun;
                        $total_time = $total_time + $travel_time;
                    ?>
                    <tr>
                        <td><?php echo $results[$k]['date']; ?></td>
                        <td><?php echo $results[$k]['plate_no']; ?></td>
                        <td><?php echo $results[$k]['origin']; ?></td>
                        <td><?php echo $results[$k]['destination']; ?></td>
                        <td><?php echo $results[$k]['dpt_time']; ?></td>
                        <td><?php echo $results[$k]['arv_time']; ?></td>
                        <td><?php echo $results[$k]['total_time']; ?></td>
                        <td><?php echo $kmrun; ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php
                        $total_time = convertToHoursMins($total_time, '%02d h %02d min');
                    ?>
                    <tr>
                        <td colspan="6" class="emphasize">TOTAL:</td>
                        <td class="emphasize"><?php echo $total_time; ?></td>
                        <td class="emphasize"><?php echo $kmrun_total; ?></td>
                    </tr>
                </tbody>
            </table>
            </div>
        <?php
            endfor;
        ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script>
        $(document).ready(function() {
            
            window.onload = function() { window.print(); }

        });
    </script>
</body>
</html>

<?php
endif;
?>