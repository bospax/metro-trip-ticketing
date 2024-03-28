<?php
require_once('../../../database/db.php');
require_once('../../../helpers/functions.php');
require_once('../../../class/Trip.php');
require_once('../../../class/Location.php');
require_once('../../../class/Terminal.php');
require_once('../../../class/Logs.php');
require_once('../../../class/User.php');
require_once('../../../session/session.php');

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

$filter = '';

$trip = new Trip();

function thisOutputLocName($loc_code) {
    $loc = new Location();
    $result = $loc->getLocName($loc_code);

    return $result[0]['loc_name'];
}

function outputTermName($tcode) {
    $terminal = new Terminal;
    $terms = $terminal->getTermNameByCode($tcode);
    $tname = $terms[0]['term_name'];

    return $tname;
}

if (isset($_POST)) :
    $action = $_POST['action'];
    $filter = (isset($_POST['filter'])) ? $_POST['filter'] : '';

    if ($action == 'filter_trip' || $action == 'read') :

        if ($action == 'read') {
            $result = $trip->getAllTripToday();

            if ($login_type != 'admin') {
                $result = $trip->getTripTodayByTermcode($gettermcode);
            }
        }
        
        if ($filter == 'today') {

            $result = $trip->getAllTripToday();

            if ($login_type != 'admin') {
                $result = $trip->getTripTodayByTermcode($gettermcode);
            }

        } elseif ($filter == 'all') {

            $result = $trip->getAllTrip();

            if ($login_type != 'admin') {
                $result = $trip->getTripByTermcode($gettermcode);
            }
        }

    ?>
    <table id="table-trips" class="display responsive nowrap table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th></th>
                <th>Trip ID</th>
                <th>Department</th>
                <th>Month</th>
                <th>Plate No</th>
                <th>Driver Name</th>
                <th>Departure</th>
                <th>Origin</th>
                <th>Destination</th>
                <th>Arrival</th>
                <th>Status</th>
                <th>DPT Odo</th>
                <th>ARV Odo</th>
                <th>Total Time</th>
                <th>KM Run</th>
                <th>Companion</th>
                <th>Remarks</th>
                <th>Add Remarks:</th>
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
                <td><?php echo $result[$k]['date'].' '.$result[$k]['dpt_time']; ?></td>
                <td><?php echo $result[$k]['origin']; ?></td>
                <td><?php echo $result[$k]['destination']; ?></td>
                <td><?php echo $result[$k]['datein'].' '.$result[$k]['arv_time']; ?></td>
                <td><?php echo $result[$k]['status']; ?></td>
                <td><?php echo $result[$k]['dpt_odo']; ?></td>
                <td><?php echo $result[$k]['arv_odo']; ?></td>
                <td><?php echo $result[$k]['total_time']; ?></td>
                <td><?php echo round($result[$k]['km_run'], 1); ?></td>
                <td><?php echo $result[$k]['compa']; ?></td>
                <td><?php echo $result[$k]['remarks']; ?></td>
                <td>
                    <button id="btn-trip-remark" data-toggle="modal" data-target="#modal-trip-remark" class="btn btn-success btn-xs" data-id="<?php echo $result[$k]['id'] ?>"><i class="mdi mdi-plus"></i></button>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>

    <script>
        $(document).ready(function() {
            $('#table-trips').DataTable({});
            $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-primary mr-1 ext-dt-btn');
        });
    </script>
    <?php
    
    endif;
endif;

?>