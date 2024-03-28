<?php 
require_once('../../../database/db.php');
require_once('../../../helpers/functions.php');
require_once('../../../class/Ptrip.php');
require_once('../../../class/Vehicle.php');
require_once('../../../class/Terminal.php');
require_once('../../../class/Driver.php');
require_once('../../../class/Location.php');
require_once('../../../class/Consump.php');

$response = [];
$vehic = new Vehicle();
$ptrip = new Ptrip();
$term = new Terminal();
$driver = new Driver();
$loc = new Location();
$consump = new Consump();
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

            $id = strip_tags(trim($filesop[0]));
            $plt = strip_tags(trim(strtoupper($filesop[1])));
            $date = strip_tags(trim($filesop[2]));
            $fuel = strip_tags(trim($filesop[3]));
            $cost = strip_tags(trim($filesop[4]));
            $termcode = strip_tags(trim($filesop[5]));

            // check if vehicle exist
            $vehicexist = $vehic->getVehicleByPlate($plt);

            if (empty($vehicexist)) {

                $err = 'Plate no is not registered.';
                $invalid[] = 'ID: ['.$id.'] - '.$err;

                continue;
            }

            // check for valid date format
            if (!validateDate($date)) {

                $err = 'Date must be in valid format. [mm/dd/yyyy]';
                $invalid[] = 'ID: ['.$id.'] - '.$err;

                continue;
            }

            // check if term exist
            $termexist = $term->getTerminalByTermcode($termcode);

            if (empty($termexist)) {

                $err = 'Terminal code is not registered.';
                $invalid[] = 'ID: ['.$id.'] - '.$err;
                
                continue;
            }

            // check if qty is valid
            if (!is_numeric($fuel)) {
                $err = 'You must enter a valid fuel quantity';
                $invalid[] = 'ID: ['.$id.'] - '.$err;
                
                continue;
            }

            // trim any commas
            $cost = str_replace(',', '', $cost);
            $cpl = $cost / $fuel;
            $cpl = round($cpl, 2);


            if (!empty($plt) && !empty($date) && !empty($fuel) && !empty($cost) && !empty($termcode)) {
                
                // insert query here
                $result = $consump->addNewConsump($plt, $date, $fuel, $cost, $cpl, $termcode);
                // $result = 1;
                
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