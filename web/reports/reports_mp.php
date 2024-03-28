<?php
require_once('../../database/db.php');
require_once('../../helpers/functions.php');
require_once('../../class/Trip.php');
require_once('../../class/Driver.php');
require_once('../../class/Terminal.php');
require_once('../../class/User.php');
require_once('../../class/Logs.php');
require_once('../../session/session.php');
?>

<?php
date_default_timezone_set('Asia/Manila');
$cldate = date('m/d/Y h:i a');

// session_start();

$login_name = '';
$login_uname = '';
$login_type = '';
$login_termcode = '';
$login_termname = '';
$gettermcode = '';
$termcode = '';

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

$log = new Logs();


    if (isset($_POST['type'])) :
        $daterange = $_POST['daterange'];
        $termcode = $_POST['termcode'];
        $dates = explode(' - ', $daterange);
?>

<div class="col-lg-12 col-xl-3">
    <?php
        $f = $dates[0];
        $t = $dates[1];
        $drivers = [];

        $trip = new Trip();
        $results = $trip->getTripRange($f, $t);   

        if ($login_type == 'admin' && $termcode != 'null') {
            $results = $trip->getTripRangeByTermcode($f, $t, $termcode);
        } elseif ($login_type == 'admin' && $termcode == 'null') {
            $results = $trip->getTripRangeByTermcode($f, $t, $login_termcode);
        } else {
            $results = $trip->getTripRangeByTermcode($f, $t, $gettermcode);
        }

        $act = 'Generated manhour.';
        $details = $f.'-'.$t.':'.$termcode;
        $logged = $log->addNewLog($login_id, $login_name, $login_termcode, $act, $details, $cldate);

        
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

            if ($login_type == 'admin' && $termcode != 'null') {

                // $results = $trip->getTripRangeByTermcode($from, $to, $termcode);
                $results_driver = $driver->getDriverByTermcode($driver_id, $termcode);
                $results = $trip->getTripIndividualByTermcode($driver_id, $f, $t, $termcode);

            } elseif ($login_type == 'admin' && $termcode == 'null') {

                // $results = $trip->getTripRangeByTermcode($from, $to, $login_termcode);
                $results_driver = $driver->getDriverByTermcode($driver_id, $login_termcode);
                $results = $trip->getTripIndividualByTermcode($driver_id, $f, $t, $login_termcode);

            } else {

                // $results = $trip->getTripRangeByTermcode($from, $to, $gettermcode);
                $results_driver = $driver->getDriverByTermcode($driver_id, $gettermcode);
                $results = $trip->getTripIndividualByTermcode($driver_id, $f, $t, $gettermcode);
            }
    ?>

    <button class="btn-show-manhour btn btn-primary btn-xs" data-id="<?php echo ($results_driver) ? $results_driver[0]['id'] : ''; ?>"><i class="mdi mdi-plus"></i></button> <b>Driver Name: <?php echo ($results_driver) ? $results_driver[0]['name'] : ''; ?> | Terminal: <?php echo ($results_driver) ? $results_driver[0]['term'] : ''; ?> </b>
    <div class="manhour-divider"></div>
    <table id="mytabledriver-<?php echo ($results_driver) ? $results_driver[0]['id'] : ''; ?>" class="mytabledriver table table-bordered">
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

    <?php
        endfor;

        if (empty($results)) {
            ?>
                <p>No Data Available.</p>
            <?php
        }
    ?>
</div>

<script>
    $(".btn-show-manhour").click(function() {
        var driver_id = $(this).data('id');
        var driver_table = $('#mytabledriver-' + driver_id);

        driver_table.toggle('fast');
        $(this).find('i').toggleClass('mdi-plus').toggleClass('mdi-minus');
    });
</script>

<?php
    endif;
?>
