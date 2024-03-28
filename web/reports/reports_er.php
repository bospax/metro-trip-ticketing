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

if (isset($_POST['daterange_er'])) {
    $dates = $_POST['daterange_er'];
    $termcode = $_POST['termcode'];
    $dates = explode(' - ', $dates);
    $from = $dates[0];
    $to = $dates[1];
}

$trip = new Trip();
$result_bounce = $trip->getBounceRange($from, $to);

if ($login_type == 'admin' && $termcode != 'null') {
    $result_bounce = $trip->getBounceRangeByTermcode($from, $to, $termcode);
} elseif ($login_type == 'admin' && $termcode == 'null') {
    $result_bounce = $trip->getBounceRangeByTermcode($from, $to, $login_termcode);
} else {
    $result_bounce = $trip->getBounceRangeByTermcode($from, $to, $gettermcode);
}

$act = 'Generated error logs.';
$details = $from.'-'.$to.':'.$termcode;
$logged = $log->addNewLog($login_id, $login_name, $login_termcode, $act, $details, $cldate);

?>

<table id="table-bounce" class="display responsive nowrap table table-striped table-bordered" style="width:100%">
    <thead>
        <tr>
            <th></th>
            <th>ID</th>
            <th>Sender</th>
            <th>Name</th>
            <th>Terminal</th>
            <th>Message</th>
            <th>Date Received</th>
            <th>Errors</th>
        </tr>
    </thead>
    <tbody>
    <?php if (!empty($result_bounce)) : ?>
        <?php foreach ($result_bounce as $k => $v) : ?>
        <tr>
            <td></td>
            <td><?php echo $result_bounce[$k]['id'] ?></td>
            <td><?php echo $result_bounce[$k]['from'] ?></td>
            <td><?php echo $result_bounce[$k]['sender_name'] ?></td>
            <td><?php echo $result_bounce[$k]['term_code'] ?></td>
            <td><?php echo $result_bounce[$k]['msg'] ?></td>
            <td><?php echo $result_bounce[$k]['receivedAt'] ?></td>
            <td><?php echo $result_bounce[$k]['remarks'] ?></td>
        </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>

<script>
        $(document).ready(function() {
            $('#table-bounce').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel'
                ]
            });
        } );
</script>
