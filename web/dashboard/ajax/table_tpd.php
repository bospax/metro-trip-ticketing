<?php
require_once('../../../database/db.php');
require_once('../../../helpers/functions.php');
require_once('../../../class/Trip.php');
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

$driver = new Driver();
$trip = new Trip();
$drivers = $driver->getAllDrivers();

if ($login_type != 'admin') {
    $drivers = $driver->getAllDriversByTermcode($login_termcode);
}

?>

<table id="table-tpd" class="display responsive nowrap table table-striped table-bordered" style="width:100%">
    <thead>
        <tr>
            <th>Driver ID</th>
            <th>Name</th>
            <th>Trip</th>
            <th>Error</th>
            <th>Department</th>
        </tr>
    </thead>
    <tbody>
    <?php if (!empty($drivers)) : ?>
        <?php foreach ($drivers as $k => $v) : ?>
        <tr>
            <td><?php echo $drivers[$k]['id']; ?></td>
            <td><?php echo $drivers[$k]['name']; ?></td>

            <?php
                $did = $drivers[$k]['id'];
                $tterm_code = $drivers[$k]['term'];
                $trips = $trip->getTripByIdTermcode($tterm_code, $did);
                $bounces = $trip->getBounceByIDTermcode($tterm_code, $did);
                $tripcount = count($trips);
                $bouncecount = count($bounces);
            ?>

            <td style="color: <?php echo ($tripcount != 0) ? '#36bea6' : '#f62d51' ?>;"><?php echo $tripcount; ?></td>
            <td style="color: <?php echo ($bouncecount != 0) ? '#f62d51' : '#36bea6' ?>;"><?php echo $bouncecount; ?></td>
            <td><?php echo $drivers[$k]['deptname']; ?></td>
        </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>

<script>
        $(document).ready(function() {
            $('#table-tpd').DataTable({
                "pageLength": 5,
                // dom: 'Bfrtip',
                // buttons: [
                //     'copy', 'csv', 'excel'
                // ]
            });
        } );
</script>