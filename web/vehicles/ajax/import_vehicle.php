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

if (!empty($_FILES)) {
    $allowedFileType = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
  
    if (!in_array($_FILES["file"]["type"], $allowedFileType)) {

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

            $plate = strip_tags(trim(strtoupper($filesop[0])));
            $loc_code = strip_tags(trim(strtoupper($filesop[1])));
            $loc_name = strip_tags(trim($filesop[2]));
            $term_code = strip_tags(trim(strtoupper($filesop[3])));

            // check if plate already exist
            $pltexist = $vehic->getVehicleByPlate($plate);

            if (!empty($pltexist)) {
                continue;
            }

            // check if location exist
            $locexist = $loc->getLocName($loc_code);

            if (empty($locexist)) {
                continue;
            }

            // check if termcode exist
            $termexist = $term->getTerminalByTermcode($term_code);

            if (empty($termexist)) {
                continue;
            }


            if (!empty($plate) && !empty($loc_code) && !empty($loc_name) && !empty($term_code)) {
                
                // insert query here
                $result = $vehic->addNewVehicle($plate, $loc_code, $loc_name, $term_code);
            
                if (!empty($result)) {
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