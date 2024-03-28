<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/database.php';
include_once '../Models/trips.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$trips = new trips($db);
 
// query products
$stmt = $trips->read();
$num = $stmt->rowCount();
// check if more than 0 record found
if($num>0){
 
    // products array
    $trips_arr=array();
    $trips_arr["records"]=array();
    $status = 0;
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $product_item=array(
            "id" => $id,
            "termCode" => $term_code,
            "dateTrip" => $dateptrips,
            "driverName" => $ptripdname,
            "MobileNumber" => $number,
            "locationOrigin" => $ptripsorig,
            "locationDest" => $loc_name,
            "companion" => $ptripcompa,
            "isSync" => $status
        );
 
        array_push($trips_arr["records"], $product_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show products data in json format
    echo json_encode($trips_arr);
}else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no products found
    echo json_encode(
        array("message" => "No trips found.")
    );
}