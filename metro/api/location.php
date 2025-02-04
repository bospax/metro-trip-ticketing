<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/database.php';
include_once '../Models/locations.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$locations = new Locations($db);
 
// query products
$stmt = $locations->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // products array
    $locations_arr=array();
    $locations_arr["records"]=array();
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
            "locCode" => $loc_code,
            "location" => $loc_name,
            "isSync" => $status
        );
 
        array_push($locations_arr["records"], $product_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show products data in json format
    echo json_encode($locations_arr);
}else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no products found
    echo json_encode(
        array("message" => "No Location found.")
    );
}