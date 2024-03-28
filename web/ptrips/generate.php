<?php
require_once('../../database/db.php');
require_once('../../helpers/functions.php');
require_once('../../class/Trip.php');
require_once('../../class/Driver.php');
require_once('../../class/Ptrip.php');
require_once('../../class/Vehicle.php');
require_once('../../class/Location.php');
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
$termcode = '';

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
?>

<?php
    $f = '';
    $t = '';

    if (isset($_POST['prange'])) {
        $dates = $_POST['prange'];
        $termcode = $_POST['termcode'];
        $dates = explode(' - ', $dates);
        $f = $dates[0];
        $t = $dates[1];
    }

    // $f       = '04/10/2020';
    // $t       = '04/15/2020';
    // $termcode = '2103';

    $ptrips  = new Ptrip();
    $trips   = new Trip();
    $vehic   = new Vehicle();
    $rptrips = $ptrips->getPtripByDaterange($f, $t);

    if ($login_type == 'admin' && $termcode != 'null') {
        $rptrips = $ptrips->getPtripByDaterangeAndTermcode($f, $t, $termcode);
    } elseif ($login_type == 'admin' && $termcode == 'null') {
        $rptrips = $ptrips->getPtripByDaterangeAndTermcode($f, $t, $login_termcode);
    } else {
        $rptrips = $ptrips->getPtripByDaterangeAndTermcode($f, $t, $gettermcode);
    }

    $dates   = [];
    $entry   = [];
    $entries = [];

    foreach ($rptrips as $key => $value) {
        $pid = $rptrips[$key]['id'];
        
        if (!in_array($rptrips[$key]['dateptrips'], $dates)) {
            $dates[] = $rptrips[$key]['dateptrips'];
        }
    }

    for ($i=0; $i < count($dates); $i++) {
        $d          = $dates[$i];
        $pentries   = $ptrips->getPtripByDate($d);

        if (!empty($pentries)) {

            foreach ($pentries as $key => $value) {
                $pid     = $pentries[$key]['id'];
                $pdate   = $pentries[$key]['dateptrips'];
                $pdriver = $pentries[$key]['ptripdname'];
                $ptcode  = $pentries[$key]['term_code'];
                $pplate  = $pentries[$key]['ptripsvehic'];
                $pplate  = outputPlateNo($pplate);
                $pdest   = $pentries[$key]['ptripsdest'];
    
                $rtrips = $trips->getMatchTripV2($pdate, $t, $pdest);

                if ($login_type == 'admin' && $termcode != 'null') {
                    $rtrips = $trips->getMatchTripV2ByTermcode($pdate, $t, $pdest, $termcode);
                } elseif ($login_type == 'admin' && $termcode == 'null') {
                    $rtrips = $trips->getMatchTripV2ByTermcode($pdate, $t, $pdest, $login_termcode);
                } else {
                    $rtrips = $trips->getMatchTripV2ByTermcode($pdate, $t, $pdest, $gettermcode);
                }
    
                // var_dump($rtrips);
    
                if (!empty($rtrips)) {

                    foreach ($rtrips as $key => $value) {
                        $tdate = $rtrips[$key]['date'];
                        $tdriver = $rtrips[$key]['driver_name'];
                        $tplate = $rtrips[$key]['plate_no'];
                        $tdest = $rtrips[$key]['destination'];
                        $tterm = $rtrips[$key]['term_code'];
                        $tcompa = $rtrips[$key]['compa'];
                        $tstatus = 'Travelled';

                        $rmk = '--';
                        $dstart = strtotime($pdate);  
                        $dend = strtotime($tdate);

                        $diff = abs($dend - $dstart);
                        $years = floor($diff / (365*60*60*24));
                        $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));   
                        $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24)); 

                        $entry['epid'] = $pid;
                        $entry['edate'] = $pdate;
                        $entry['edriver'] = $tdriver;
                        $entry['eplate'] = $tplate;
                        $entry['edest'] = $tdest;
                        $entry['etermcode'] = $tterm;

                        if ($days != 0) {
                            $rmk = $days.' day/s Delayed';
                        }

                        $entry['ermk'] = $rmk;
                        $entry['ecompa'] = $tcompa;
                        $entry['estatus'] = $tstatus.' - '.$tdate;

                        $entries[] = $entry;

                        // var_dump($days);
                    }
                }
            }
        }
    }

    // var_dump($entries);

    $act = 'Generated planned trip.';
    $details = $f.'-'.$t.':'.$termcode;
    $logged = $log->addNewLog($login_id, $login_name, $login_termcode, $act, $details, $cldate);
?>

<div class="col-lg-12 col-xl-3">
    <table id="table-ptrips-generated" class="display responsive nowrap table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>PID</th>
                <th>Terminal</th>
                <th>Planned Date</th>
                <th>Driver</th>
                <th>Plate No</th>
                <th>Destination</th>
                <th>Companion</th>
                <th>Status</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($entries as $k => $v) : ?>
            <tr>
                <td><?php echo $entries[$k]['epid']; ?></td>
                <td><?php echo $entries[$k]['etermcode']; ?></td>
                <td><?php echo $entries[$k]['edate']; ?></td>
                <td><?php echo $entries[$k]['edriver']; ?></td>
                <td><?php echo $entries[$k]['eplate']; ?></td>
                <td><?php echo outputLocName($entries[$k]['edest']); ?></td>
                <td><?php echo $entries[$k]['ecompa']; ?></td>
                <td><span class="badge badge-pill badge-success"><?php echo $entries[$k]['estatus']; ?></span></td>
                <td><?php echo ($entries[$k]['ermk'] != '--') ? '<span class="badge badge-pill badge-danger">'.$entries[$k]['ermk'].'</span>' : $entries[$k]['ermk']; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        $('#table-ptrips-generated').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel'
            ]
        });
        $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-primary mr-1 ext-dt-btn');
    } );
</script>