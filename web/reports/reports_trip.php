<?php
require_once('../../database/db.php');
require_once('../../helpers/functions.php');
require_once('../../class/Trip.php');
require_once('../../class/Location.php');
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
$dates = '';
$from = '';
$to = '';

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

if (isset($_POST['daterange_trip'])) {
    $dates = $_POST['daterange_trip'];
    $termcode = $_POST['termcode'];
    $dates = explode(' - ', $dates);
    $from = $dates[0];
    $to = $dates[1];
}

$trip = new Trip();
$result = $trip->getTripRange($from, $to);

if ($login_type == 'admin' && $termcode != 'null') {
    $result = $trip->getTripRangeByTermcode($from, $to, $termcode);
} elseif ($login_type == 'admin' && $termcode == 'null') {
    $result = $trip->getTripRangeByTermcode($from, $to, $login_termcode);
} else {
    $result = $trip->getTripRangeByTermcode($from, $to, $gettermcode);
}

$act = 'Generated trip ticket.';
$details = $from.'-'.$to.':'.$termcode;
$logged = $log->addNewLog($login_id, $login_name, $login_termcode, $act, $details, $cldate);

?>

<table id="table-trips" class="display responsive nowrap table table-striped table-bordered" style="width:100%">
    <thead>
        <tr>
            <th></th>
            <th>Trip ID</th>
            <th>Terminal</th>
            <th>Month</th>
            <th>Plate No</th>
            <th>Driver Name</th>
            <th>Departure</th>
            <th>Time of Departure</th>
            <th>Origin</th>
            <th>Destination</th>
            <th>Arrival</th>
            <th>Time of Arrival</th>
            <th>Status</th>
            <th>DPT Odo</th>
            <th>ARV Odo</th>
            <th>Total Time</th>
            <th>KM Run</th>
            <th>Companion</th>
            <th>Remarks</th>
        </tr>
    </thead>
    <tbody>
    <?php if (!empty($result)) : ?>
        <?php foreach ($result as $k => $v) : ?>
        <tr>
            <td></td>
            <td><?php echo $result[$k]['id']; ?></td>
            <td><?php echo $result[$k]['term_code']; ?></td>
            <td><?php echo $result[$k]['month']; ?></td>
            <td><?php echo $result[$k]['plate_no']; ?></td>
            <td><?php echo $result[$k]['driver_name']; ?></td>
            <td><?php echo $result[$k]['date']; ?></td>
            <td><?php echo $result[$k]['dpt_time']; ?></td>
            <td><?php echo outputLocName($result[$k]['origin']); ?></td>
            <td><?php echo (!empty($result[$k]['destination'])) ? outputLocName($result[$k]['destination']) : '' ; ?></td>
            <td><?php echo $result[$k]['datein']; ?></td>
            <td><?php echo $result[$k]['arv_time']; ?></td>
            <td><?php echo $result[$k]['status']; ?></td>
            <td><?php echo $result[$k]['dpt_odo']; ?></td>
            <td><?php echo $result[$k]['arv_odo']; ?></td>
            <td><?php echo $result[$k]['total_time']; ?></td>
            <td><?php echo round($result[$k]['km_run'], 1); ?></td>
            <td><?php echo $result[$k]['compa']; ?></td>
            <td><?php echo $result[$k]['remarks']; ?></td>
        </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>

<script>
        $(document).ready(function() {
            $('#table-trips').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel'
                ]
            });

        } );
</script>