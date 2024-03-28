<?php
require_once('../../database/db.php');
require_once('../../helpers/functions.php');
require_once('../../class/Trip.php');
require_once('../../class/Driver.php');
?>

<?php
    $daterange = '';
    $from = '';
    $to = '';
    
    if (isset($_POST['daterange_idl'])) {
        $daterange = $_POST['daterange_idl'];
        $daterange = explode(' - ', $daterange);
        $from = $daterange[0];
        $to = $daterange[1];
    }
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
        <b><h5>IDLE DRIVER</h5></b>
        <p>DATE FROM: <?php echo $from; ?> TO: <?php echo $to; ?></p>
    </div>

    <div class="page-footer text-center">
        
        <p class="footer-text">Project Metro</p>

    </div>

    <div class="header-space"></div>

    <div>
<?php


$trip = new Trip();
$result = $trip->getTripRange($from, $to);
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

// var_dump($dates);

foreach ($dates as $date) :

    $driver = new Driver();
    $drivers = $driver->getAllDrivers();
    
?>
<div class="pagebreak-idle" style="page-break-inside: avoid;">
    <b>Date: <?php echo $date; ?></b>
    <div class="manhour-divider"></div>
    <table id="mytableidle-<?php echo $ctr; ?>" class="mytabledriver table table-bordered">
        <thead>
            <tr class="emphasize">
                <th>ID</th>
                <th>Driver's Name</th>
                <th>Mobile Number</th>
            </tr>
        </thead>
        <tbody>

        <?php
            foreach ($drivers as $k => $value) :
                $d = $date;
                $did = $drivers[$k]['id'];
                $trip_entry = $trip->getTripEntry($d, $did);

                if (empty($trip_entry)) :
                    // echo $drivers[$k]['id'].' '.$drivers[$k]['name'].'<br>';
        ?>
            <tr>
                <td><?php echo $drivers[$k]['id']; ?></td>
                <td><?php echo $drivers[$k]['name']; ?></td>
                <td><?php echo $drivers[$k]['number']; ?></td>
            </tr>
        <?php
                endif;
            endforeach;
        ?>

        </tbody>
    </table>
</div>


<?php
    $ctr++;
    endforeach;
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