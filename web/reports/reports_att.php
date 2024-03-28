<?php
require_once('../../database/db.php');
require_once('../../helpers/functions.php');
require_once('../../class/Trip.php');
require_once('../../class/Driver.php');
require_once('../../class/Terminal.php');
require_once('../../class/User.php');
require_once('../../class/Logs.php');
require_once('../../session/session.php');

date_default_timezone_set('Asia/Manila');
$cldate = date('m/d/Y h:i a');

// session_start();

$login_name = '';
$login_uname = '';
$login_type = '';
$login_termcode = '';
$login_termname = '';
$gettermcode = '';
$dates      = '';
$emp_id     = '';
$from       = '';
$to         = '';
$entries    = [];

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

if (isset($_POST['daterange_att'])) {
    $dates  = $_POST['daterange_att'];
    $emp_id = $_POST['empid'];
    $dates  = explode(' - ', $dates);
    $from   = $dates[0];
    $to     = $dates[1];
}

// $dates = '02/05/2020 - 02/05/2020';
// $emp_id = '47';
// $dates = explode(' - ', $dates);
// $from = $dates[0];
// $to = $dates[1];

if ($emp_id == 'allemp') :

    $trip = new Trip();
    $rtrip = $trip->getTripRange($from, $to);

    if ($login_type != 'admin') {
        $rtrip = $trip->getTripRangeByTermcode($from, $to, $login_termcode);
    }

    foreach ($rtrip as $key => $value) {
        if (!in_array($rtrip[$key]['date'], $entries)) {
            $entries[] = $rtrip[$key]['date'];
        }
    }

    $driver = new Driver();
    $rdriver = $driver->getAllDrivers();

    if ($login_type != 'admin') {
        $rdriver = $driver->getAllDriversByTermcode($login_termcode);
    }

    ?>

    <table id="table-att" class="display responsive nowrap table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th></th>
                <th>Emp Code</th>
                <th>Emp Name</th>
                <th>Date</th>
                <th>Time In</th>
                <th>Time Out</th>
                <th>Loc Code</th>
                <th>Location</th>
                <th>Terminal</th>
                <th>Dept Code</th>
                <th>Dept Name</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            foreach ($rdriver as $key => $value) :
                $did = $rdriver[$key]['id'];
            ?>
                <?php if (!empty($entries)) : ?>

                    <?php foreach ($entries as $entry) : 
                        
                    $min = $trip->getMinTime($entry, $did);
                    $max = $trip->getMaxTime($entry, $did);

                    ?>
                        <?php if (!empty($min[0]['mintime'])) : ?>
                            <tr>
                                <td></td>
                                <td><?php echo $rdriver[$key]['emp_id']; ?></td>
                                <td><?php echo $rdriver[$key]['name']; ?></td>
                                <td><?php echo $entry; ?></td>
                                <td><?php echo $min[0]['mintime']; ?></td>
                                <td><?php echo $max[0]['maxtime']; ?></td>
                                <td><?php echo $rdriver[$key]['lcode']; ?></td>
                                <td><?php echo $rdriver[$key]['lname']; ?></td>
                                <td><?php echo $rdriver[$key]['term']; ?></td>
                                <td><?php echo $rdriver[$key]['deptcode']; ?></td>
                                <td><?php echo $rdriver[$key]['deptname']; ?></td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php

else :

    $trip = new Trip();
    $rtrip = $trip->getTripRange($from, $to);

    if ($login_type != 'admin') {
        $rtrip = $trip->getTripRangeByTermcode($from, $to, $login_termcode);
    }

    foreach ($rtrip as $key => $value) {
        if (!in_array($rtrip[$key]['date'], $entries)) {
            $entries[] = $rtrip[$key]['date'];
        }
    }

    $driver = new Driver();
    $rdriver = $driver->getDriver($emp_id);

    if ($login_type != 'admin') {
        $rdriver = $driver->getDriverByTermcode($emp_id, $login_termcode);
    }

    // foreach ($entries as $entry) {
    //     $min = $trip->getMinTime($entry, $emp_id);
    //     // var_dump($min[0]['mintime']);

    //     $max = $trip->getMaxTime($entry, $emp_id);
    //     // var_dump($max[0]['maxtime']);
    // }

    ?>

    <table id="table-att" class="display responsive nowrap table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th></th>
                <th>EmpCode</th>
                <th>EmpName</th>
                <th>Date</th>
                <th>Time In</th>
                <th>Time Out</th>
                <th>Loc Code</th>
                <th>Location</th>
                <th>Terminal</th>
                <th>Dept Code</th>
                <th>Dept Name</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($entries)) : ?>
            <?php foreach ($entries as $entry) : 
                
            $min = $trip->getMinTime($entry, $emp_id);
            // var_dump($min[0]['mintime']);
        
            $max = $trip->getMaxTime($entry, $emp_id);
            // var_dump($max[0]['maxtime']);
            ?>
                <?php if (!empty($min[0]['mintime'])) : ?>
                    <tr>
                        <td></td>
                        <td><?php echo $rdriver[0]['emp_id']; ?></td>
                        <td><?php echo $rdriver[0]['name']; ?></td>
                        <td><?php echo $entry; ?></td>
                        <td><?php echo $min[0]['mintime']; ?></td>
                        <td><?php echo $max[0]['maxtime']; ?></td>
                        <td><?php echo $rdriver[0]['lcode']; ?></td>
                        <td><?php echo $rdriver[0]['lname']; ?></td>
                        <td><?php echo $rdriver[0]['term']; ?></td>
                        <td><?php echo $rdriver[0]['deptcode']; ?></td>
                        <td><?php echo $rdriver[0]['deptname']; ?></td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>

    <?php

endif;


$log = new Logs();

$act = 'Generated employee attendance.';
$details = $from.'-'.$to.':'.$emp_id;
$logged = $log->addNewLog($login_id, $login_name, $login_termcode, $act, $details, $cldate);


?>

<script>
    $(document).ready(function() {
        if (!$.fn.DataTable.isDataTable('#table-fleet')) {
            $('#table-att').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel'
                ]
            });
        }
    } );
</script>