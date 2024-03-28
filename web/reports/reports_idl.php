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


<div class="col-lg-12 col-xl-3">

<?php
// session_start();

date_default_timezone_set('Asia/Manila');
$cldate = date('m/d/Y h:i a');

$login_name = '';
$login_uname = '';
$login_type = '';
$login_termcode = '';
$login_termname = '';
$gettermcode = '';
$termcode = '';
$daterange = '';
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

if (isset($_POST['daterange_idl'])) {
    $daterange = $_POST['daterange_idl'];
    $termcode = $_POST['termcode'];
    $daterange = explode(' - ', $daterange);
    $from = $daterange[0];
    $to = $daterange[1];
}

$trip = new Trip();
$result = $trip->getTripRange($from, $to);

if ($login_type == 'admin' && $termcode != 'null') {
    $result = $trip->getTripRangeByTermcode($from, $to, $termcode);
} elseif ($login_type == 'admin' && $termcode == 'null') {
    $result = $trip->getTripRangeByTermcode($from, $to, $login_termcode);
} else {
    $result = $trip->getTripRangeByTermcode($from, $to, $gettermcode);
}

$act = 'Generated idle drivers.';
$details = $from.'-'.$to.':'.$termcode;
$logged = $log->addNewLog($login_id, $login_name, $login_termcode, $act, $details, $cldate);

$dates = [];
$entry = [];
$entries = [];
$ctr = 0;

foreach ($result as $k => $value) {
    if (!in_array($result[$k]['date'], $dates)) {
        $dates[] = $result[$k]['date'];
        $entry['date'] = $result[$k]['date'];
        $entry['driver_id'] = $result[$k]['driver_id'];
        $entries[] = $entry;
    }
}

if (empty($result)) :
    ?>
        <p>No Data Available.</p>
    <?php
endif;

// var_dump($dates);

foreach ($dates as $date) :

    $driver = new Driver();
    $drivers = $driver->getAllDrivers();

    if ($login_type == 'admin' && $termcode != 'null') {
        $drivers = $driver->getAllDriversByTermcode($termcode);
    } elseif ($login_type == 'admin' && $termcode == 'null') {
        $drivers = $driver->getAllDriversByTermcode($login_termcode);
    } else {
        $drivers = $driver->getAllDriversByTermcode($gettermcode);
    }
    
?>
    <button class="btn-show-idle btn btn-primary btn-xs" data-id="<?php echo $ctr; ?>"><i class="mdi mdi-plus"></i></button> <b>Date: <?php echo $date; ?></b>
    <div class="manhour-divider"></div>
    <table id="mytableidle-<?php echo $ctr; ?>" class="mytabledriver table table-bordered">
        <thead>
            <tr class="emphasize">
                <th>ID</th>
                <th>Driver's Name</th>
                <th>Terminal</th>
                <th>Mobile Number</th>
            </tr>
        </thead>
        <tbody>

        <?php
            foreach ($drivers as $k => $value) :
                $d = $date;
                $did = $drivers[$k]['id'];
                $trip_entry = $trip->getTripEntry($d, $did);

                if (empty($trip_entry)) :
                    // echo $drivers[$k]['id'].' '.$drivers[$k]['name'].'<br>';
        ?>
            <tr>
                <td><?php echo $drivers[$k]['id']; ?></td>
                <td><?php echo $drivers[$k]['name']; ?></td>
                <td><?php echo $drivers[$k]['term']; ?></td>
                <td><?php echo $drivers[$k]['number']; ?></td>
            </tr>
        <?php
                endif;
            endforeach;
        ?>

        </tbody>
    </table>


<?php
    $ctr++;
    endforeach;
?>

</div>

<script>
    $(".btn-show-idle").click(function() {
        var driver_id = $(this).data('id');
        var driver_table = $('#mytableidle-' + driver_id);

        driver_table.toggle('fast');
        $(this).find('i').toggleClass('mdi-plus').toggleClass('mdi-minus');
    });
</script>


