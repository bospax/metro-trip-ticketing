<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/database.php';
include_once '../Models/tripTicket.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$tickets = new TripTickets($db);

$getId = isset($_GET['id']) ? $_GET['id'] : die();

// query products
$stmt = $tickets->read($getId);
$num = $stmt->rowCount();

// check if more than 0 record found
if ($num > 0) {
 
  
    // products array
    $tickets_arr = array();
    $tickets_arr["records"] = array();

    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);

        $item = array(
            "id" => $id,
            "datein" => $datein,
            "plate_no" => $plate_no,
            "status" => $status,
            "origin" => $origin,
            "destination" => $destination,
            "dpt_odo" => $dpt_odo,
            "arv_odo" => $arv_odo,
        );

        array_push($tickets_arr["records"], $item);
    }

    // set response code - 200 OK
    http_response_code(200);

    // show products data in json format
    echo json_encode($tickets_arr);
}else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no products found
    echo json_encode(
        array("message" => "No Trip Ticket found.")
    );
}