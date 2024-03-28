<?php
require_once('../../../database/db.php');
require_once('../../../helpers/functions.php');
require_once('../../../class/Logs.php');
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

$log = new Logs();
$logs = $log->getAllLogs();

if ($login_type != 'admin') {
    $logs = $log->getAllLogsByTermcode($login_termcode);
}

?>

<table id="table-actlog" class="display responsive nowrap table table-striped table-bordered" style="width:100%">
    <thead>
        <tr>
            <th>ID</th>
            <th>Date Created</th>
            <th>User ID</th>
            <th>Name</th>
            <th>Terminal</th>
            <th>Activity</th>
            <th>Details</th>
        </tr>
    </thead>
    <tbody>
    <?php if (!empty($logs)) : ?>
        <?php foreach ($logs as $k => $v) : ?>
        <tr>
            <td><?php echo $logs[$k]['id'] ?></td>
            <td><?php echo $logs[$k]['datecreated'] ?></td>
            <td><?php echo $logs[$k]['userid'] ?></td>
            <td><?php echo $logs[$k]['fullname'] ?></td>
            <td><?php echo $logs[$k]['terminal'] ?></td>
            <td><?php echo $logs[$k]['activity'] ?></td>
            <td><?php echo $logs[$k]['details'] ?></td>
        </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>

<script>
        $(document).ready(function() {
            $('#table-actlog').DataTable({
                // dom: 'Bfrtip',
                // buttons: [
                //     'copy', 'csv', 'excel'
                // ]
                "pageLength": 5,
                "order": [[ 1, "desc" ]]
            });
        } );
</script>