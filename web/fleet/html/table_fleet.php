<?php
require_once('../../../database/db.php');
require_once('../../../helpers/functions.php');
require_once('../../../class/Driver.php');
require_once('../../../class/Terminal.php');
require_once('../../../class/User.php');

// session_start();

// $login_name = '';
// $login_uname = '';
// $login_type = '';
// $login_termcode = '';
// $login_termname = '';

// if (!isset($_SESSION['user_fm'])) {

//     header('location: web/authenticate/login.php');

// } else {

//     $username = $_SESSION['user_fm'];
//     $User = new User;
//     $uresult = $User->getUsername($username);

//     if (!empty($uresult)) {
//         $login_name = $uresult[0]['aname'];
//         $login_uname = $uresult[0]['username'];
//         $login_type = $uresult[0]['type'];
//         $login_termcode = $uresult[0]['term_code'];
//     }

//     $terminal = new Terminal();
//     $terms = $terminal->getTermNameByCode($login_termcode);
    
//     if (!empty($terms)) {
//         $login_termname = $terms[0]['term_name'];
//     }
// }

function outputTermName($tcode) {
    $terminal = new Terminal;
    $terms = $terminal->getTermNameByCode($tcode);
    $tname = $terms[0]['term_name'];

    return $tname;
}
?>

<table id="table-fleet" class="display responsive nowrap table table-striped table-bordered" style="width:100%">
    <thead>
        <tr>
            <th>Date</th>
            <th>Plate No</th>
            <!-- <th>Origin</th>
            <th>Destination</th> -->
            <th>Status</th>
            <th>Current Location</th>
            <th>Location Code</th>
            <th>Driver</th>
            <th>Department</th>
            <th>Behavior</th>
        </tr>
    </thead>
    <tbody>
    <?php if (!empty($result)) : ?>
        <?php foreach ($result as $k => $v) : ?>
        <tr>
            <td><?php echo $result[$k]['date'] ?></td>
            <td><?php echo $result[$k]['plate_no'] ?></td>
            <!-- <td><?php //echo $result[$k]['origin'] ?></td>
            <td><?php //echo $result[$k]['destination'] ?></td> -->
            <td><?php echo $result[$k]['status'] ?></td>
            <td><?php echo $result[$k]['loc_name'] ?></td>
            <td><?php echo $result[$k]['loc_code'] ?></td>
            <td><?php echo $result[$k]['driver'] ?></td>
            <td><?php echo outputTermName($result[$k]['term_code']); ?></td>
            <td><?php echo $result[$k]['behavior'] ?></td>
        </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>

<script>
    if (!$.fn.DataTable.isDataTable('#table-fleet')) {
        $('#table-fleet').DataTable({
            "pageLength": 50,
        });
        $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-primary mr-1 ext-dt-btn');
    }
</script>