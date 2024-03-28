<?php
require_once('../../../database/db.php');
require_once('../../../helpers/functions.php');
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

$terminal = new Terminal();
$vehicles = new Vehicle();
$drivers = new Driver();
$locations = new Location();
$terms = $terminal->getAllTerminal();

if ($login_type != 'admin') {
    $terms = $terminal->getTerminalByTermcode($login_termcode);
}

?>

<table id="table-rvpd" class="display responsive nowrap table table-striped table-bordered" style="width:100%">
    <thead>
        <tr>
            <th>Department</th>
            <th>Vehicles</th>
            <th>Drivers</th>
            <th>Locations</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($terms)) : ?>
            <?php foreach ($terms as $k => $v) : ?>
            <tr>
                <td><?php echo $terms[$k]['term_name']; ?></td>
                <?php
                    $term_code = $terms[$k]['term_code'];
                    $vlist = $vehicles->getAllVehiclesByTermcode($term_code);
                    $dlist = $drivers->getAllDriversByTermcode($term_code);
                    $llist = $locations->getAllLocationByTermcode($term_code);
                    $vcount = count($vlist);
                    $dcount = count($dlist);
                    $lcount = count($llist);
                ?>
                <td style="color: #fb987a;"><?php echo $vcount; ?></td>
                <td style="color: #7460ee;"><?php echo $dcount; ?></td>
                <td style="color: #2962FF;"><?php echo $lcount; ?></td>
            </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<script>
        $(document).ready(function() {
            $('#table-rvpd').DataTable({
                "pageLength": 5,
                // dom: 'Bfrtip',
                // buttons: [
                //     'copy', 'csv', 'excel'
                // ]
            });
        } );
</script>