<?php
require_once('../../database/db.php');
require_once('../../helpers/functions.php');
require_once('../../class/Location.php');
require_once('../../class/Driver.php');
require_once('../../class/Vehicle.php');
require_once('../../class/Trip.php');
require_once('../../class/Consump.php');
require_once('../../class/Terminal.php');
require_once('../../class/Logs.php');
require_once('../../class/User.php');
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

$f = '';
$t = '';
$plt = '';

if (isset($_POST['crange'])) {
    $dates = $_POST['crange'];
    $plt = $_POST['cplate'];
    $dates = explode(' - ', $dates);
    $f = $dates[0];
    $t = $dates[1];
}

// $f = '03/03/2020';
// $t = '03/10/2020';
// $plt = 'RLG227';

$consump = new Consump();
$trips = new Trip();
$terminal = new Terminal();
$log = new Logs();

function outputTermName($tcode) {
    $terminal = new Terminal();
    $terms = $terminal->getTermNameByCode($tcode);
    $tname = $terms[0]['term_name'];

    return $tname;
}

// var_dump($getConsump);
// var_dump($total_qty);
// var_dump($total_cost);
// var_dump($getTrips);
// var_dump($total_kmrun);

// getting the total km run
// foreach ($getTrips as $key => $value) {
//     $org = $getTrips[$key]['origin'];
//     $des = $getTrips[$key]['destination'];
    
//     $location = $org.'->'.$des;
//     $kmrun = $getTrips[$key]['km_run'];
//     $kmcost = $total_cost / $total_kmrun;
//     $gascomp = $kmrun * $kmcost;
//     $total_gascomp = $total_gascomp + $gascomp;
// }

// var_dump($total_gascomp);

$act = 'Generated fuel consumption.';
    $details = $f.'-'.$t.':'.$plt;
    $logged = $log->addNewLog($login_id, $login_name, $login_termcode, $act, $details, $cldate);

?>

<div class="col-lg-12 col-xl-3">
    <table id="table-consump-generated" class="display responsive nowrap table table-striped table-bordered" style="width:100%; border-bottom: #fff; border-left: #fff">
        <thead>
            <tr>
                <th></th>
                <th>Trip Date</th>
                <th>Department</th>
                <th>Driver Name</th>
                <th>Location</th>
                <th>KM Run</th>
                <th>Cost/KM Run</th>
                <th>Gas Consumption</th>
            </tr>
        </thead>
        <tbody>

            <?php if ($plt == "allplt") :?>

                <?php
                    $vehicle = new Vehicle();
                    $vehicles = $vehicle->getAllVehiclesByTermcode($login_termcode);
                ?>

                <?php foreach ($vehicles as $key => $value) : ?>

                    <?php
                        $entry = [];
                        $entries = [];
                        $total_cost = 0;
                        $total_qty = 0;
                        $total_kmrun = 0;
                        $total_gascomp = 0;
                    ?>

                    <?php
                        $plt = $vehicles[$key]['plate_no'];

                        $getConsump = $consump->getConsumpByVehicle($f, $t, $plt);
                        $getTrips = $trips->getTripByVehicle($f, $t, $plt);
                        
                        // getting total qty and cost
                        foreach ($getConsump as $key => $value) {
                            $total_qty = $total_qty + $getConsump[$key]['qty'];
                            $total_cost = $total_cost + str_replace(',', '', $getConsump[$key]['cost']); 
                        }
                        
                        // getting total km run
                        foreach ($getTrips as $key => $value) {
                            $kmrun = $getTrips[$key]['km_run'];
                            $total_kmrun = $total_kmrun + $kmrun;
                        }
                    ?>

                    <?php foreach ($getTrips as $key => $value) : 
                        $org = $getTrips[$key]['origin'];
                        $des = $getTrips[$key]['destination'];
                        
                        $tdate = $getTrips[$key]['date'];
                        $tdept = $getTrips[$key]['term_code'];
                        $tdriver = $getTrips[$key]['driver_name'];
                        $location = $org.' -> '.$des;
                        $kmrun = $getTrips[$key]['km_run'];
                        
                        if ($total_kmrun != 0) {
                            $kmcost = $total_cost / $total_kmrun;
                        } else {
                            $kmcost = 0;
                        }

                        $gascomp = $kmrun * $kmcost;
                        $total_gascomp = $total_gascomp + $gascomp;    
                    ?>
                    <tr>
                        <td></td>
                        <td><?php echo $tdate; ?></td>
                        <td><?php echo outputTermName($tdept); ?></td>
                        <td><?php echo $tdriver; ?></td>
                        <td><?php echo $location; ?></td>
                        <td><?php echo round($kmrun, 2); ?></td>
                        <td><?php echo number_format(round($kmcost, 4), 2); ?></td>
                        <td><?php echo round($gascomp, 2); ?></td>
                    </tr>
                    <?php endforeach; ?>

                    <?php if (!empty($getTrips)) : ?>
                    <tr>
                        <td style="border: #fff; background-color: #fff"></td>
                        <td style="border: #fff; background-color: #fff"></td>
                        <td style="border: #fff; background-color: #fff"></td>
                        <td style="border: #fff; background-color: #fff"></td>
                        <td style="border: #fff; background-color: #fff"></td>
                        <td style="border: #fff; background-color: #fff"></td>
                        <td style="border: #fff; background-color: #fff"></td>
                        <td style="border: #fff; background-color: #fff"></td>
                    </tr>
                    <tr>
                        <td style="border: #fff; background-color: #fff"></td>
                        <td style="border: #fff; background-color: #fff"></td>
                        <td style="border: #fff; background-color: #fff"></td>
                        <td style="border: #fff; background-color: #fff"></td>
                        <td style="border: #fff; background-color: #fff"></td>
                        <td style="border: #fff; background-color: #fff"></td>
                        <td style="font-weight: 700; background-color: #7e6ce0; color: #fff;">Plate No:</td>
                        <td style="font-weight: 700; background-color: #7e6ce0; color: #fff;"><?php echo $plt; ?></td>
                    </tr>
                    <tr>
                        <td style="border: #fff; background-color: #fff"></td>
                        <td style="border: #fff; background-color: #fff"></td>
                        <td style="border: #fff; background-color: #fff"></td>
                        <td style="border: #fff; background-color: #fff"></td>
                        <td style="border: #fff; background-color: #fff"></td>
                        <td style="border: #fff; background-color: #fff"></td>
                        <td style="font-weight: 700;">Total Gas (Liter):</td>
                        <td style="font-weight: 700;"><?php echo $total_qty ?></td>
                    </tr>
                    <tr>
                        <td style="border: #fff; background-color: #fff"></td>
                        <td style="border: #fff; background-color: #fff"></td>
                        <td style="border: #fff; background-color: #fff"></td>
                        <td style="border: #fff; background-color: #fff"></td>
                        <td style="border: #fff; background-color: #fff"></td>
                        <td style="border: #fff; background-color: #fff"></td>
                        <td style="font-weight: 700;">Total Cost:</td>
                        <td style="font-weight: 700;"><?php echo number_format($total_cost, 2); ?></td>
                    </tr>
                    <tr>
                        <td style="border: #fff; background-color: #fff"></td>
                        <td style="border: #fff; background-color: #fff"></td>
                        <td style="border: #fff; background-color: #fff"></td>
                        <td style="border: #fff; background-color: #fff"></td>
                        <td style="border: #fff; background-color: #fff"></td>
                        <td style="border: #fff; background-color: #fff"></td>
                        <td style="font-weight: 700;">Total KM Run:</td>
                        <td style="font-weight: 700;"><?php echo $total_kmrun; ?></td>
                    </tr>
                    <tr>
                        <td style="border: #fff; background-color: #fff"></td>
                        <td style="border: #fff; background-color: #fff"></td>
                        <td style="border: #fff; background-color: #fff"></td>
                        <td style="border: #fff; background-color: #fff"></td>
                        <td style="border: #fff; background-color: #fff"></td>
                        <td style="border: #fff; background-color: #fff"></td>
                        <td style="font-weight: 700;">Total Gas Consumption:</td>
                        <td style="font-weight: 700;"><?php echo $total_gascomp; ?></td>
                    </tr>
                    <tr>
                        <td style="border: #fff; background-color: #fff"></td>
                        <td style="border: #fff; background-color: #fff"></td>
                        <td style="border: #fff; background-color: #fff"></td>
                        <td style="border: #fff; background-color: #fff"></td>
                        <td style="border: #fff; background-color: #fff"></td>
                        <td style="border: #fff; background-color: #fff"></td>
                        <td style="border: #fff; background-color: #fff"></td>
                        <td style="border: #fff; background-color: #fff"></td>
                    </tr>
                    <tr>
                        <td style="border: #fff; background-color: #fff"></td>
                        <td style="border: #fff; background-color: #fff"></td>
                        <td style="border: #fff; background-color: #fff"></td>
                        <td style="border: #fff; background-color: #fff"></td>
                        <td style="border: #fff; background-color: #fff"></td>
                        <td style="border: #fff; background-color: #fff"></td>
                        <td style="border: #fff; background-color: #fff"></td>
                        <td style="border: #fff; background-color: #fff"></td>
                    </tr>
                    <tr>
                        <td style="border: #fff; background-color: #fff"></td>
                        <td style="border: #fff; background-color: #fff"></td>
                        <td style="border: #fff; background-color: #fff"></td>
                        <td style="border: #fff; background-color: #fff"></td>
                        <td style="border: #fff; background-color: #fff"></td>
                        <td style="border: #fff; background-color: #fff"></td>
                        <td style="border: #fff; background-color: #fff"></td>
                        <td style="border: #fff; background-color: #fff"></td>
                    </tr>
                    <?php endif; ?>

                <?php endforeach; ?>


            <?php else: ?>
                
                <?php
                    $entry = [];
                    $entries = [];
                    $total_cost = 0;
                    $total_qty = 0;
                    $total_kmrun = 0;
                    $total_gascomp = 0;
                ?>

                <?php
                    $getConsump = $consump->getConsumpByVehicle($f, $t, $plt);
                    $getTrips = $trips->getTripByVehicle($f, $t, $plt);
                    
                    // getting total qty and cost
                    foreach ($getConsump as $key => $value) {
                        $total_qty = $total_qty + $getConsump[$key]['qty'];
                        $total_cost = $total_cost + str_replace(',', '', $getConsump[$key]['cost']); 
                    }
                    
                    // getting total km run
                    foreach ($getTrips as $key => $value) {
                        $kmrun = $getTrips[$key]['km_run'];
                        $total_kmrun = $total_kmrun + $kmrun;
                    }
                ?>

                <?php foreach ($getTrips as $key => $value) : 
                    $org = $getTrips[$key]['origin'];
                    $des = $getTrips[$key]['destination'];
                    
                    $tdate = $getTrips[$key]['date'];
                    $tdept = $getTrips[$key]['term_code'];
                    $tdriver = $getTrips[$key]['driver_name'];
                    $location = $org.' -> '.$des;
                    $kmrun = $getTrips[$key]['km_run'];
                    
                    if ($total_kmrun != 0) {
                        $kmcost = $total_cost / $total_kmrun;
                    } else {
                        $kmcost = 0;
                    }

                    $gascomp = $kmrun * $kmcost;
                    $total_gascomp = $total_gascomp + $gascomp;    
                ?>
                <tr>
                    <td></td>
                    <td><?php echo $tdate; ?></td>
                    <td><?php echo outputTermName($tdept); ?></td>
                    <td><?php echo $tdriver; ?></td>
                    <td><?php echo $location; ?></td>
                    <td><?php echo round($kmrun, 2); ?></td>
                    <td><?php echo number_format(round($kmcost, 4), 2); ?></td>
                    <td><?php echo round($gascomp, 2); ?></td>
                </tr>
                <?php endforeach; ?>

                <?php if (!empty($getTrips)) : ?>
                <tr>
                    <td style="border: #fff; background-color: #fff"></td>
                    <td style="border: #fff; background-color: #fff"></td>
                    <td style="border: #fff; background-color: #fff"></td>
                    <td style="border: #fff; background-color: #fff"></td>
                    <td style="border: #fff; background-color: #fff"></td>
                    <td style="border: #fff; background-color: #fff"></td>
                    <td style="border: #fff; background-color: #fff"></td>
                    <td style="border: #fff; background-color: #fff"></td>
                </tr>
                <tr>
                    <td style="border: #fff; background-color: #fff"></td>
                    <td style="border: #fff; background-color: #fff"></td>
                    <td style="border: #fff; background-color: #fff"></td>
                    <td style="border: #fff; background-color: #fff"></td>
                    <td style="border: #fff; background-color: #fff"></td>
                    <td style="border: #fff; background-color: #fff"></td>
                    <td style="font-weight: 700; background-color: #7e6ce0; color: #fff;">Plate No:</td>
                    <td style="font-weight: 700; background-color: #7e6ce0; color: #fff;"><?php echo $plt; ?></td>
                </tr>
                <tr>
                    <td style="border: #fff; background-color: #fff"></td>
                    <td style="border: #fff; background-color: #fff"></td>
                    <td style="border: #fff; background-color: #fff"></td>
                    <td style="border: #fff; background-color: #fff"></td>
                    <td style="border: #fff; background-color: #fff"></td>
                    <td style="border: #fff; background-color: #fff"></td>
                    <td style="font-weight: 700;">Total Gas (Liter):</td>
                    <td style="font-weight: 700;"><?php echo $total_qty ?></td>
                </tr>
                <tr>
                    <td style="border: #fff; background-color: #fff"></td>
                    <td style="border: #fff; background-color: #fff"></td>
                    <td style="border: #fff; background-color: #fff"></td>
                    <td style="border: #fff; background-color: #fff"></td>
                    <td style="border: #fff; background-color: #fff"></td>
                    <td style="border: #fff; background-color: #fff"></td>
                    <td style="font-weight: 700;">Total Cost:</td>
                    <td style="font-weight: 700;"><?php echo number_format($total_cost, 2); ?></td>
                </tr>
                <tr>
                    <td style="border: #fff; background-color: #fff"></td>
                    <td style="border: #fff; background-color: #fff"></td>
                    <td style="border: #fff; background-color: #fff"></td>
                    <td style="border: #fff; background-color: #fff"></td>
                    <td style="border: #fff; background-color: #fff"></td>
                    <td style="border: #fff; background-color: #fff"></td>
                    <td style="font-weight: 700;">Total KM Run:</td>
                    <td style="font-weight: 700;"><?php echo $total_kmrun; ?></td>
                </tr>
                <tr>
                    <td style="border: #fff; background-color: #fff"></td>
                    <td style="border: #fff; background-color: #fff"></td>
                    <td style="border: #fff; background-color: #fff"></td>
                    <td style="border: #fff; background-color: #fff"></td>
                    <td style="border: #fff; background-color: #fff"></td>
                    <td style="border: #fff; background-color: #fff"></td>
                    <td style="font-weight: 700;">Total Gas Consumption:</td>
                    <td style="font-weight: 700;"><?php echo $total_gascomp; ?></td>
                </tr>
                <tr>
                    <td style="border: #fff; background-color: #fff"></td>
                    <td style="border: #fff; background-color: #fff"></td>
                    <td style="border: #fff; background-color: #fff"></td>
                    <td style="border: #fff; background-color: #fff"></td>
                    <td style="border: #fff; background-color: #fff"></td>
                    <td style="border: #fff; background-color: #fff"></td>
                    <td style="border: #fff; background-color: #fff"></td>
                    <td style="border: #fff; background-color: #fff"></td>
                </tr>
                <tr>
                    <td style="border: #fff; background-color: #fff"></td>
                    <td style="border: #fff; background-color: #fff"></td>
                    <td style="border: #fff; background-color: #fff"></td>
                    <td style="border: #fff; background-color: #fff"></td>
                    <td style="border: #fff; background-color: #fff"></td>
                    <td style="border: #fff; background-color: #fff"></td>
                    <td style="border: #fff; background-color: #fff"></td>
                    <td style="border: #fff; background-color: #fff"></td>
                </tr>
                <tr>
                    <td style="border: #fff; background-color: #fff"></td>
                    <td style="border: #fff; background-color: #fff"></td>
                    <td style="border: #fff; background-color: #fff"></td>
                    <td style="border: #fff; background-color: #fff"></td>
                    <td style="border: #fff; background-color: #fff"></td>
                    <td style="border: #fff; background-color: #fff"></td>
                    <td style="border: #fff; background-color: #fff"></td>
                    <td style="border: #fff; background-color: #fff"></td>
                </tr>
                <?php endif; ?>


            <?php endif; ?>

            
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        $('#table-consump-generated').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel'
            ]
        });
        $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-primary mr-1 ext-dt-btn');
    } );
</script>