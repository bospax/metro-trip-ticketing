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
$kmruns = $trip->getHighestKMRun();

if ($login_type != 'admin') {
    $kmruns = $trip->getHighestKMRunByTermcode($login_termcode);
}

?>

<table id="table-hkmrun" class="display responsive nowrap table table-striped table-bordered" style="width:100%">
    <thead>
        <tr>
            <th>Trip ID</th>
            <th>KM Run</th>
            <th>Plate No</th>
            <th>Origin</th>
            <th>Destination</th>
            <th>Terminal</th>
        </tr>
    </thead>
    <tbody>
    <?php if (!empty($kmruns)) : ?>
        <?php foreach ($kmruns as $k => $v) : ?>
        <tr>
            <td><?php echo $kmruns[$k]['id']; ?></td>
            <td><?php echo round($kmruns[$k]['km_run'], 1); ?></td>
            <td><?php echo $kmruns[$k]['plate_no']; ?></td>
            <td><?php echo $kmruns[$k]['origin']; ?></td>
            <td><?php echo $kmruns[$k]['destination']; ?></td>
            <td><?php echo $kmruns[$k]['term_code']; ?></td>
        </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>

<script>
        $(document).ready(function() {
            $('#table-hkmrun').DataTable({
                "pageLength": 5,
                // dom: 'Bfrtip',
                // buttons: [
                //     'copy', 'csv', 'excel'
                // ]
                "order": [[ 1, "desc" ]]
            });
        } );
</script>