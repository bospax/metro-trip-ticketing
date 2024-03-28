<?php
require_once('../../../database/db.php');
require_once('../../../helpers/functions.php');
require_once('../../../class/Ptrip.php');
require_once('../../../class/Vehicle.php');
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
$termcode = '';
// $daterange = '';
// $from = '';
// $to = '';

if (!isset($_SESSION['user_fm'])) {

    header('location: web/authenticate/login.php');

} else {

    $username = $_SESSION['user_fm'];
    $User = new User;
    $uresult = $User->getUsername($username);

    if (!empty($uresult)) {
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

function outputPlateNo($vid) {
    $vehic = new Vehicle();
    $result = $vehic->getVehicleByID($vid);

    return $result[0]['plate_no'];
}

function outputLocNameByID($lid) {
    $loc = new Location();
    $result = $loc->getLocByID($lid);

    return $result[0]['loc_name'];
}

function outputTermName($tcode) {
    $terminal = new Terminal();
    $terms = $terminal->getTermNameByCode($tcode);

    return $terms[0]['term_name'];
}

$ptrips = new Ptrip();
$result = $ptrips->getAllPtrip();

if ($login_type != 'admin') {
    $result = $ptrips->getAllPtripByTermcode($login_termcode);
}

?>

<table id="table-ptrips" class="display responsive nowrap table table-striped table-bordered" style="width:100%">
    <thead>
        <tr>
            <th></th>
            <th>ID</th>
            <th>Department</th>
            <th>Trip Date</th>
            <th class="d-none">Trip Time</th>
            <th class="ptrip-hidden">Driver ID</th>
            <th>Driver Name</th>
            <th class="ptrip-hidden">Vehicle ID</th>
            <th>Plate No</th>
            <th class="ptrip-hidden">Origin ID</th>
            <th class="ptrip-hidden">Destination ID</th>
            <th>Origin</th>
            <th>Destination</th>
            <th>Companion</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    <?php if (!empty($result)) : ?>
        <?php foreach ($result as $k => $v) : ?>
        <tr>
            <td></td>
            <td><?php echo $result[$k]['id']; ?></td>
            <td><?php echo outputTermName($result[$k]['term_code']); ?></td>
            <td class="dateptrips"><?php echo $result[$k]['dateptrips']; ?></td>
            <td class="ptriptime d-none"><?php echo $result[$k]['ptriptime']; ?></td>
            <td class="ptripsdid ptrip-hidden"><?php echo $result[$k]['ptripsdid']; ?></td>
            <td class="ptripdname"><?php echo $result[$k]['ptripdname']; ?></td>
            <td class="ptripsvehic ptrip-hidden"><?php echo $result[$k]['ptripsvehic']; ?></td>
            <td><?php echo outputPlateNo($result[$k]['ptripsvehic']); ?></td>
            <td class="ptripsorig ptrip-hidden"><?php echo $result[$k]['ptripsorig']; ?></td>
            <td class="ptripsdest ptrip-hidden"><?php echo $result[$k]['ptripsdest']; ?></td>
            <td><?php echo outputLocNameByID($result[$k]['ptripsorig']); ?></td>
            <td><?php echo outputLocNameByID($result[$k]['ptripsdest']); ?></td>
            <td class="ptripcompa"><?php echo $result[$k]['ptripcompa']; ?></td>
            <td>
                <button id="btn-edit-ptrip" class="btn btn-success btn-xs" data-id="<?php echo $result[$k]['id']; ?>"><i class="mdi mdi-border-color"></i></button>
                <button id="btn-del-ptrip" class="btn btn-danger btn-xs" data-id="<?php echo $result[$k]['id']; ?>"><i class="mdi mdi-window-close"></i></button>
            </td>
        </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#table-ptrips').DataTable({
            // dom: 'Bfrtip',
            // buttons: [
            //     'copy', 'csv', 'excel'
            // ]
        });
        $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-primary mr-1 ext-dt-btn');
    } );
</script>