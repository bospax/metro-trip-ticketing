<?php
require_once('../../database/db.php');
require_once('../../helpers/functions.php');
require_once('../../class/Trip.php');

$dates = '';
$from = '';
$to = '';

if (isset($_POST['daterange_er'])) {
    $dates = $_POST['daterange_er'];
    $dates = explode(' - ', $dates);
    $from = $dates[0];
    $to = $dates[1];
}

$trip = new Trip();
$result_bounce = $trip->getBounceRange($from, $to);

// var_dump($result_bounce);

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
        <b><h5>ERROR LOGS</h5></b>
        <p>DATE FROM: <?php echo $from; ?> TO: <?php echo $to; ?></p>
    </div>

    <div class="page-footer text-center">
        
        <p class="footer-text">Project Metro</p>

    </div>

    <div class="header-space"></div>

    <table class="blueTable text-center">
        <thead>
            <tr>
                <th>Sender</th>
                <th>Name</th>
                <th>Message</th>
                <th>Date Received</th>
                <th>Errors</th>
            </tr>
        </thead>

        <tbody>
        <?php if (!empty($result_bounce)) : ?>
            <?php foreach ($result_bounce as $k => $v) : ?>
                <tr>
                    <td><?php echo $result_bounce[$k]['from'] ?></td>
                    <td><?php echo $result_bounce[$k]['sender_name'] ?></td>
                    <td><?php echo $result_bounce[$k]['msg'] ?></td>
                    <td><?php echo $result_bounce[$k]['receivedAt'] ?></td>
                    <td><?php echo $result_bounce[$k]['remarks'] ?></td>
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