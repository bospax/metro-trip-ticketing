<?php 
require_once('../../../database/db.php');
require_once('../../../helpers/functions.php');
require_once('../../../class/Ptrip.php');
require_once('../../../class/Vehicle.php');
require_once('../../../class/Terminal.php');
require_once('../../../class/Driver.php');
require_once('../../../class/Location.php');
require_once('../../../class/Masterloc.php');

$response = [];
$importtype = '';
$vehic = new Vehicle();
$ptrip = new Ptrip();
$term = new Terminal();
$driver = new Driver();
$loc = new Location();
$mloc = new Masterloc();

if (!empty($_FILES)) {
    $importtype = $_POST['importtype'];
    $allowedFileType = ['application/vnd.ms-excel', 'text/xls','text/xlsx', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/octet-stream'];
  
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
            $term_code = "";
            $code = strip_tags(trim($filesop[0]));
            $name = strip_tags(trim(strtoupper($filesop[1])));

            if (isset($filesop[2])) {
                $term_code = strip_tags(trim($filesop[2]));
            }

            if ($importtype == 'loctag' && $term_code != "") {

                // check if terminal exist
                $termexist = $term->getTerminalByTermcode($term_code);

                if (empty($termexist)) {
                    continue;
                }

                // check if loc tag already exist
                $loctagexist = $loc->getDupLoc($code, $term_code);
                
                if (!empty($loctagexist)) {
                    continue;
                }

                // check if loc code already exist
                $codeexist = $mloc->getDupMasterloc($code);

                if (empty($codeexist)) {
                    continue;
                }

            } elseif ($importtype != 'loctag' && $term_code == "") {

                // check if loc code already exist
                $codeexist = $mloc->getDupMasterloc($code);

                if (!empty($codeexist)) {
                    continue;
                }
            }



            if (!empty($code) && !empty($name)) {
                
                // insert query here
                $Location = new Masterloc();
                $LocationTag = new Location();

                if ($importtype == 'loctag' && $term_code != "") {

                    $result = $LocationTag->addNewLocation($code, $name, $term_code);

                } elseif ($importtype != 'loctag' && $term_code == "") {

                    $result = $Location->addNewMasterloc($code, $name);
                }
            
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