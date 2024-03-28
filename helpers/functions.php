<?php
// convert time to hours and mins
function convertToHoursMins($time, $format = '%02d:%02d') {
    if ($time < 1) {
        return;
    }
    $hours = floor($time / 60);
    $minutes = ($time % 60);
    return sprintf($format, $hours, $minutes);
}

function getDiffDates($date1, $date2) {
    // Formulate the Difference between two dates 
    $diff = abs($date2 - $date1);

    $years = floor($diff / (365*60*60*24));
    $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));   
    $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24)); 
    $hours = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24) / (60*60));  
    $minutes = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60) / 60);  
    $seconds = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60 - $minutes*60));

    return sprintf("%02d d, %02d h, %02d m", $days, $hours, $minutes);
}

// response to sms
function smsResponse($originator, $replyMessage) {
    // $originator = '639989889158';
    // $replyMessage = 'this is a sample response<br>thank you.';

    $curl = curl_init();

    curl_setopt_array($curl, array(
            CURLOPT_URL => "http://gn4l6.api.infobip.com/sms/2/text/single",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{ \"from\":\"RDF-MIS\", \"to\":\"$originator\", \"text\":\"$replyMessage\" }",
            CURLOPT_HTTPHEADER => array(
                "accept: application/json",
                "authorization: Basic cmRmX3ZpbmNlOnJkZlBhbXBhbmdhQDIwMjM=",
                "content-type: application/json"
        ),
    ));
        
    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);
}

function outputLocName($loc_code) {
    $loc = new Location();
    $result = $loc->getLocName($loc_code);

    return $result[0]['loc_name'];
}

function validateDate($date, $format = 'm/d/Y')
{
    $d = DateTime::createFromFormat($format, $date);
    // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
    return $d && $d->format($format) === $date;
}
?>