<?php 
require_once('../../../database/db.php');
require_once('../../../helpers/functions.php');
require_once('../../../class/Ptrip.php');
require_once('../../../class/Vehicle.php');
require_once('../../../class/Terminal.php');
require_once('../../../class/Driver.php');
require_once('../../../class/Location.php');

$response = [];
$vehic = new Vehicle();
$ptrip = new Ptrip();
$term = new Terminal();
$driver = new Driver();
$loc = new Location();
$invalid = [];

if (!empty($_FILES)) {
    $allowedFileType = ['csv', 'text/csv', 'application/vnd.ms-excel', 'text/xls','text/xlsx', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/octet-stream'];
  
    if (in_array($_FILES["file"]["type"], $allowedFileType)) {

        $file = $_FILES["file"];
        $file = $_FILES['file']['tmp_name'];

        $handle = fopen($file, "r");
        $ctr = 1;

        while(($filesop = fgetcsv($handle, 1000, ",")) !== false) {

            if ($ctr == 1) { 
                $ctr++;
                continue; 
            }

            // $response[] = $filesop;

            $pid   = trim($filesop[0]);
            $pdate = trim($filesop[1]);
            $ptime = 0;
            $pdid = trim($filesop[2]);
            $pdriver = trim($filesop[3]);
            $pplate = strip_tags(trim(strtoupper($filesop[4])));;
            $porg = strip_tags(trim(strtoupper($filesop[5])));
            $pdest = strip_tags(trim(strtoupper($filesop[6])));
            $pcompa = trim($filesop[7]);
            $pterm = trim($filesop[8]);

            // check for valid date format
            if (!validateDate($pdate)) {

                $err = 'Date must be in valid format. [mm/dd/yyyy]';
                $invalid[] = 'ID: ['.$pid.'] - '.$err;

                continue;
            }

            $rduptrip         = $ptrip->getDupPtrip($pdate, $pdid, $pdest);
            $rduptripvehic    = $ptrip->getDupPtripVehic($pdate, $pplate, $pdest);
            $destexist        = $ptrip->getDestExist($pdate, $pdest);

            // date, driver and dest already exist
            if (!empty($rduptrip)) {

                $err = 'A trip with that schedule already exists.';
                $invalid[] = 'ID: ['.$pid.'] - '.$err;

                continue;
            }

            // date, vehicle and dest already exist
            if (!empty($rduptripvehic)) {
                
                $err = 'The vehicle is not available on that schedule.';
                $invalid[] = 'ID: ['.$pid.'] - '.$err;

                continue;
            }

            // date and dest already exist
            if (!empty($destexist)) {

                $err = 'A trip with that destination already exists.';
                $invalid[] = 'ID: ['.$pid.'] - '.$err;

                continue;
            }

            // check if term exist
            $termexist = $term->getTerminalByTermcode($pterm);

            if (empty($termexist)) {

                $err = 'Terminal code is not registered.';
                $invalid[] = 'ID: ['.$pid.'] - '.$err;
                
                continue;
            }
            
            // check if vehicle exist
            $vehicexist = $vehic->getVehicleByPlate($pplate);

            if (!empty($vehicexist)) {
                $pplate = $vehicexist[0]['id'];
            } else {

                $err = 'Plate no is not registered.';
                $invalid[] = 'ID: ['.$pid.'] - '.$err;

                continue;
            }

            // check if driver exist
            $dexist = $driver->getDriverByTermcode($pdid, $pterm);

            if (empty($dexist)) {

                $err = 'Driver system ID not found.';
                $invalid[] = 'ID: ['.$pid.'] - '.$err;

                continue;
            }

            // check for valid org and dest
            if ($porg == $pdest) {

                $err = 'Same origin and destination is not allowed.';
                $invalid[] = 'ID: ['.$pid.'] - '.$err;

                continue;
            }

            // check if location exist
            $orgexist = $loc->getDupLoc($porg, $pterm);
            $destexist = $loc->getDupLoc($pdest, $pterm);

            if (empty($orgexist) || empty($destexist)) {

                $err = 'Location code not found.';
                $invalid[] = 'ID: ['.$pid.'] - '.$err;

                continue;
            }

            // var_dump($filesop);

            if (!empty($pdate) && !empty($porg) && !empty($pdest) && !empty($pplate) && !empty($pterm)) {
                
                // insert query here
                $result = $ptrip->addNewPtrip($pdate, $ptime, $pdid, $pdriver, $pplate, $porg, $pdest, $pcompa, $pterm);
            
                
                if (!empty($result) && !empty($invalid)) {

                    $invalid_str = implode('<br>', $invalid);

                    $response['type'] = "invalid";
                    $response['msg'] = "Not all data has been imported";
                    $response['err'] = $invalid_str;

                } elseif (!empty($result) && empty($invalid)) {

                    $response['type'] = "success";
                    $response['msg'] = "CSV Data successfully imported!";

                } else {

                    $response['type'] = "error";
                    $response['msg'] = "Problem in importing Excel Data";
                }

            } else {
                $response['type'] = "error";
                $response['msg'] = "Problem in importing Excel Data";
            }
        }

    } else { 
        $response['type'] = "error";
        $response['msg'] = "Invalid file type. Upload a CSV file.";
    }

} else {
    $response['type'] = "error";
    $response['msg'] = "Please upload a CSV file.";
}

if (empty($response)) {
    $response['type'] = "error";
    $response['msg'] = "Failed to import, No valid data detected.";
}

$response = json_encode($response);
echo $response;
?>