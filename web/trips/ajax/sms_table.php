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

if (isset($_POST)) :
    $action = $_POST['action'];
    $filter = (isset($_POST['filter'])) ? $_POST['filter'] : '';

    if ($action == 'filter_sms' || $action == 'read') :

        if ($action == 'read') {
            $result_sms = $trip->getAllSmsToday();

            if ($login_type != 'admin') {
                $result_sms = $trip->getSmsTodayByTermcode($gettermcode);
            }
        }
        
        if ($filter == 'today') {

            $result_sms = $trip->getAllSmsToday();

            if ($login_type != 'admin') {
                $result_sms = $trip->getSmsTodayByTermcode($gettermcode);
            }

        } elseif ($filter == 'all') {

            $result_sms = $trip->getAllSms();

            if ($login_type != 'admin') {
                $result_sms = $trip->getAllSmsByTermcode($gettermcode);
            }
        }

    ?>
    <table id="table-sms" class="display responsive nowrap table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th></th>
                <th>ID</th>
                <th>Sender</th>
                <th>Department</th>
                <th>Name</th>
                <th>Receiver</th>
                <th>Message</th>
                <th>Date Received</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($result_sms)) : ?>
            <?php foreach ($result_sms as $k => $v) : ?>
            <tr>
                <td></td>
                <td><?php echo $result_sms[$k]['id'] ?></td>
                <td><?php echo $result_sms[$k]['from'] ?></td>
                <td><?php echo $result_sms[$k]['term_code']; ?></td>
                <td><?php echo $result_sms[$k]['sender_name'] ?></td>
                <td><?php echo $result_sms[$k]['to'] ?></td>
                <td><?php echo $result_sms[$k]['msg'] ?></td>
                <td><?php echo $result_sms[$k]['receivedAt'] ?></td>
            </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>

    <script>
        $(document).ready(function() {
            $('#table-sms').DataTable({});
            $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-primary mr-1 ext-dt-btn');
        });
    </script>
    <?php
    
    endif;
endif;

?>