<?php 
class Trip {
    private $db_handle;
    
    function __construct() {
        $this->db_handle = new DBController();
    }
    
    function getAllTrip() {
        $query  = "SELECT * FROM trips ORDER BY `date` DESC";
        $result = $this->db_handle->runBaseQuery($query);
        return $result;
    }

    function getAllTripToday() {
        date_default_timezone_set('Asia/Manila');
        $cdate = date('m/d/Y');

        $query  = "SELECT * FROM trips WHERE `date` = :cdate ORDER BY `date` DESC";
        $params = [
            'cdate' => $cdate
        ];

        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function getTripByTermcode($ttermcode) {
        $query  = "SELECT * FROM trips WHERE `term_code` = :termcode ORDER BY `date` DESC";
        $params = [
            'termcode' => $ttermcode
        ];

        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function getTripTodayByTermcode($ttermcode) {
        date_default_timezone_set('Asia/Manila');
        $cdate = date('m/d/Y');

        $query  = "SELECT * FROM trips WHERE `date` = :cdate AND `term_code` = :termcode ORDER BY `date` DESC";
        $params = [
            'cdate' => $cdate,
            'termcode' => $ttermcode
        ];

        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function getTripByIdTermcode($ttermcode, $did) {
        $query  = "SELECT * FROM trips WHERE `term_code` = :termcode AND `driver_id` = :did ORDER BY `date` DESC";
        $params = [
            'termcode' => $ttermcode,
            'did' => $did
        ];

        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function getAllTripByTermcode($ttermcode) {
        $query  = "SELECT * FROM trips WHERE `term_code` = :termcode ORDER BY `date` DESC";
        $params = [
            'termcode' => $ttermcode
        ];

        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function getAllTripByTermcodeYesterdate($ttermcode, $yestdate) {
        $query  = "SELECT * FROM trips WHERE `term_code` = :termcode AND `date` = :yestdate ORDER BY `date` DESC";
        $params = [
            'termcode' => $ttermcode,
            'yestdate' => $yestdate
        ];

        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function getTripEntry($d, $did) {
        $query  = "SELECT * FROM trips WHERE `date` = :d AND `driver_id` = :did";
        $params = [
            'd'     => $d,
            'did'   => $did
        ];

        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function getTripRange($f, $t) {
        $query  = "SELECT * FROM trips WHERE STR_TO_DATE(`date`, '%m/%d/%Y') BETWEEN STR_TO_DATE(:f, '%m/%d/%Y') AND STR_TO_DATE(:t, '%m/%d/%Y') ORDER BY `date`";
        $params = [
            'f' => $f,
            't' => $t
        ];

        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function getTripRangeByTermcode($f, $t, $ttermcode) {
        $query  = "SELECT * FROM trips WHERE STR_TO_DATE(`date`, '%m/%d/%Y') BETWEEN STR_TO_DATE(:f, '%m/%d/%Y') AND STR_TO_DATE(:t, '%m/%d/%Y') AND `term_code` = :termcode ORDER BY `date`";
        $params = [
            'f' => $f,
            't' => $t,
            'termcode' => $ttermcode
        ];

        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function getTripExport($f, $t) {
        $query  = "SELECT `id`,`month`,`date`,`driver_name`,`plate_no`,`status`,`origin`,`destination`,`dpt_time`,`dpt_odo`,`arv_time`,`arv_odo`,`total_time`,`km_run`,`remarks` FROM trips WHERE `date` BETWEEN :f AND :t";
        $params = [
            'f' => $f,
            't' => $t
        ];

        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function getTrip($id) {
        $query  = "SELECT * FROM trips WHERE id = :id";
        $params = [
            'id' => $id
        ];

        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function getTripIndividual($driver_id, $f, $t) {
        $query = "SELECT * FROM trips WHERE `driver_id` = :driver_id AND `date` BETWEEN :f AND :t";
        $params = [
            'driver_id' => $driver_id,
            'f'         => $f,
            't'         => $t
        ];

        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function getTripIndividualByTermcode($driver_id, $f, $t, $ttermcode) {
        $query = "SELECT * FROM trips WHERE `driver_id` = :driver_id AND `date` BETWEEN :f AND :t AND `term_code` = :termcode";
        $params = [
            'driver_id' => $driver_id,
            'f'         => $f,
            't'         => $t,
            'termcode'  => $ttermcode
        ];

        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function getManPower($cdate) {
        $query  = "SELECT driver_name, `date`, SUM(raw_time) FROM trips GROUP BY raw_time";
        $result = $this->db_handle->runBaseQuery($query);
        return $result;
    }

    function getManPowerRange($f, $t) {
        $query  = "SELECT driver_name, `date`, SUM(raw_time) FROM trips WHERE `date` BETWEEN :f AND :t GROUP BY raw_time";
        $params = [
            'f' => $f,
            't' => $t
        ];
        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function getRawTime($date) {
        $query  = "SELECT `plate_no`,`raw_time` FROM trips WHERE `date` = :cdate";
        $params = [
            'cdate' => $date
        ];
        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function getRawTimeByTermcode($date, $ttermcode) {
        $query  = "SELECT `plate_no`,`raw_time` FROM trips WHERE `date` = :cdate AND `term_code` = :ttermcode";
        $params = [
            'cdate' => $date,
            'ttermcode' => $ttermcode
        ];
        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function getKm($date) {
        $query  = "SELECT `plate_no`,`km_run` FROM trips WHERE `date` = :cdate";
        $params = [
            'cdate' => $date
        ];
        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function getKmByTermcode($date, $ttermcode) {
        $query  = "SELECT `plate_no`,`km_run` FROM trips WHERE `date` = :cdate AND `term_code` = :ttermcode";
        $params = [
            'cdate' => $date,
            'ttermcode' => $ttermcode
        ];
        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function getAllSms() {
        $query  = "SELECT * FROM sms ORDER BY `receivedAt` DESC";
        $result = $this->db_handle->runBaseQuery($query);
        return $result;
    }

    function getAllSmsToday() {
        date_default_timezone_set('Asia/Manila');
        $cstart = date('m/d/Y');
        $cstart = $cstart.' 01:00';

        $cend = date('m/d/Y');
        $cend = $cend.' 24:00';

        $query  = "SELECT * FROM sms WHERE `receivedAt` BETWEEN :cstart AND :cend ORDER BY `receivedAt` DESC";

        $params = [
            'cstart' => $cstart,
            'cend' => $cend
        ];

        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function getSmsTodayByTermcode($smstermcode) {
        date_default_timezone_set('Asia/Manila');
        $cstart = date('m/d/Y');
        $cstart = $cstart.' 01:00';

        $cend = date('m/d/Y');
        $cend = $cend.' 24:00';

        $query  = "SELECT * FROM sms WHERE `receivedAt` BETWEEN :cstart AND :cend AND `term_code` = :termcode  ORDER BY `receivedAt` DESC";

        $params = [
            'cstart' => $cstart,
            'cend' => $cend,
            'termcode' => $smstermcode
        ];

        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function getAllSmsByTermcode($smstermcode) {
        $query  = "SELECT * FROM sms WHERE `term_code` = :termcode ORDER BY `receivedAt` DESC";
        $params = [
            'termcode' => $smstermcode
        ];
    
        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function updateRemark($id, $remark) {
        $query  = "UPDATE trips SET remarks = :remark WHERE id = :id";
        $params = [
            'id'     => $id,
            'remark' => $remark
        ];
        $result = $this->db_handle->update($query, $params);
    }

    function getAllBounce() {
        $query  = "SELECT * FROM bounce ORDER BY `receivedAt` DESC";
        $result = $this->db_handle->runBaseQuery($query);
        return $result;
    }

    function getAllBounceByTermcode($ttermcode) {
        $query  = "SELECT * FROM bounce WHERE `term_code` = :termcode ORDER BY `date` DESC";
        $params = [
            'termcode' => $ttermcode
        ];

        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function getBounceByIDTermcode($ttermcode, $did) {
        $query  = "SELECT * FROM bounce WHERE `term_code` = :termcode AND `sender_id` = :did ORDER BY `date` DESC";
        $params = [
            'termcode' => $ttermcode,
            'did' => $did
        ];

        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function getAllBounceByTermcodeYesterdate($ttermcode, $yestdate) {
        $query  = "SELECT * FROM bounce WHERE `term_code` = :ttermcode AND `date` = :yestdate ORDER BY `receivedAt` DESC";
        $params = [
            'ttermcode' => $ttermcode,
            'yestdate' => $yestdate
        ];

        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function getBounceRange($f, $t) {
        $query  = "SELECT * FROM bounce WHERE STR_TO_DATE(`date`, '%m/%d/%Y') BETWEEN STR_TO_DATE(:f, '%m/%d/%Y') AND STR_TO_DATE(:t, '%m/%d/%Y')";
        $params = [
            'f' => $f,
            't' => $t
        ];

        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function getBounceRangeByTermcode($f, $t, $ttermcode) {
        $query  = "SELECT * FROM bounce WHERE STR_TO_DATE(`date`, '%m/%d/%Y') BETWEEN STR_TO_DATE(:f, '%m/%d/%Y') AND STR_TO_DATE(:t, '%m/%d/%Y') AND `term_code` = :termcode";
        $params = [
            'f' => $f,
            't' => $t,
            'termcode' => $ttermcode
        ];

        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function getMinTime($d, $did) {
        $query = "SELECT MIN(`att_timein`) AS `mintime` FROM trips WHERE `date` = :d AND `driver_id` = :did";
        $params = [
            'd'   => $d,
            'did' => $did
        ];

        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function getMaxTime($d, $did) {
        $query  = "SELECT MAX(`att_timeout`) AS `maxtime` FROM trips WHERE `date` = :d AND `driver_id` = :did";
        $params = [
            'd'   => $d,
            'did' => $did
        ];

        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function getMatchingTrip($pdate, $pdest) {
        $query = "SELECT * FROM trips WHERE `date` = :pdate AND `destination` = :pdest";
        $params = [
            'pdate' => $pdate,
            'pdest' => $pdest
        ];

        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function getMatchTripV2($f, $t, $dest) {
        $query = "SELECT * FROM trips WHERE `date` BETWEEN :f AND :t AND `destination` = :pdest";
        $params = [
            'f' => $f,
            't' => $t,
            'pdest' => $dest
        ];

        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function getMatchTripV2ByTermcode($f, $t, $dest, $termcode) {
        $query = "SELECT * FROM trips WHERE `date` BETWEEN :f AND :t AND `destination` = :pdest AND `term_code` = :termcode";
        $params = [
            'f' => $f,
            't' => $t,
            'pdest' => $dest,
            'termcode' => $termcode
        ];

        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function getMatchingTripByTermcode($pdate, $pdest, $ttermcode) {
        $query = "SELECT * FROM trips WHERE `date` = :pdate AND `destination` = :pdest AND `term_code` = :ttermcode";
        $params = [
            'pdate' => $pdate,
            'pdest' => $pdest,
            'ttermcode' => $ttermcode
        ];

        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function getMatchingTripByTermcodeV2($pdest, $ttermcode) {
        $query = "SELECT * FROM trips WHERE `destination` = :pdest AND `term_code` = :ttermcode";
        $params = [
            'pdest' => $pdest,
            'ttermcode' => $ttermcode
        ];

        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function getTripByDate($pdate) {
        $query = "SELECT * FROM trips WHERE `date` = :pdate ORDER BY `date`";
        $params = [
            'pdate' => $pdate
        ];

        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function getTripByDateAndTermcode($pdate, $ttermcode) {
        $query = "SELECT * FROM trips WHERE `date` = :pdate AND `term_code` = :ttermcode ORDER BY `date`";
        $params = [
            'pdate' => $pdate,
            'ttermcode' => $ttermcode
        ];

        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function getTripByVehicle($f, $t, $plt) {
        $query = "SELECT * FROM trips WHERE `date` BETWEEN :f AND :t AND plate_no = :plt";
        $params = [
            'f' => $f,
            't' => $t,
            'plt' => $plt
        ];

        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function getLongestTime() {
        $query = "SELECT * FROM trips ORDER BY `total_time` DESC LIMIT 20";
        $result = $this->db_handle->runBaseQuery($query);
        return $result;
    }

    function getHighestKMRun() {
        $query = "SELECT * FROM trips ORDER BY `km_run` DESC LIMIT 20";
        $result = $this->db_handle->runBaseQuery($query);
        return $result;
    }

    function getHighestKMRunByTermcode($termcode) {
        $query = "SELECT * FROM trips WHERE `term_code` = :termcode ORDER BY `km_run` DESC LIMIT 20";
        $params = [
            'termcode' => $termcode
        ];
          
        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function getLongestTimeByTermcode($termcode) {
        $query = "SELECT * FROM trips WHERE `term_code` = :termcode ORDER BY `total_time` DESC LIMIT 20";
        $params = [
            'termcode' => $termcode
        ];
          
        $result = $this->db_handle->runBaseQuery($query, $params);
        return $result;
    }

    function addNewTrip($mfrom, $mto, $msg, $receivedAt) {

        date_default_timezone_set('Asia/Manila');

        // $addt       = strtotime('+4 hour, +55 minutes');$termcode   = strip_tags(trim(strtoupper($msg[0])));
        $msg        = explode('-', $msg);
        $mob        = strip_tags(trim($mfrom));
        $insertIds  = [];
        $params     = [];
        $errors     = [];
        $cdate      = date('m/d/Y');
        $cmonth     = date('F');
        $ctime      = date('h:i a');
        $ctime_att  = date('H:i:s');
        $cdatetime  = date('m/d/Y h:i a');
        $rmk        = '';
        $termcode   = '';

        if (count($msg) == 7) {
            $termcode   = strip_tags(trim(strtoupper($msg[0])));
            $plate      = strip_tags(trim(strtoupper($msg[1])));
            $stat       = strip_tags(trim(strtoupper($msg[2])));
            $loc        = strip_tags(trim(strtoupper($msg[3])));
            $odo        = strip_tags(trim(strtoupper($msg[4])));
            $compa      = strip_tags(trim($msg[5]));
            $rmk        = strip_tags(trim($msg[6]));
        }

        // /*================================================= 
        // ERROR TRAPPING
        // ===================================================*/
        // check if number is registered
        $qmob = 'SELECT * FROM drivers WHERE `number` = :mob';
        $pmob = [
            'mob' => $mob
        ];
        $rmob = $this->db_handle->runBaseQuery($qmob, $pmob);

        if (empty($rmob)) {
            $errors[] = 'Ang iyong numero ay hindi nakarehistro';
        }

        // check if number is registered and term code
        $tqmob = 'SELECT * FROM drivers WHERE `number` = :mob AND `term` = :termcode';
        $tpmob = [
            'mob' => $mob,
            'termcode' => $termcode
        ];
        $trmob = $this->db_handle->runBaseQuery($tqmob, $tpmob);

        if (empty($trmob)) {
            $errors[] = 'Ang iyong numero ay hindi nakarehistro sa iyong departamento';
        }

        // check the length of the msg
        if (count($msg) < 7 || count($msg) > 7) {
            
            $errors[] = 'May mali sa keyword na iyong nilagay';

        } else {
            // check for valid term code
            $qterm = 'SELECT * FROM terminal WHERE `term_code` = :termcode';
            $pterm = [
                'termcode' => $termcode
            ];
            $rterm = $this->db_handle->runBaseQuery($qterm, $pterm);

            if (empty($rterm)) {
                $errors[] = 'Ang iyong terminal ay hindi nakarehistro.';
            }

            // check for plate no
            $pqvec = 'SELECT * FROM vehicles WHERE `plate_no` = :plate';
            $ppvec = [
                'plate' => $plate
            ];
            $prvec = $this->db_handle->runBaseQuery($pqvec, $ppvec);

            if (empty($prvec)) {
                $errors[] = 'Ang iyong plaka ay hindi nakarehistro.';
            }

            // check for plate no and term code
            $tpqvec = 'SELECT * FROM vehicles WHERE `plate_no` = :plate AND `term_code` = :termcode';
            $tppvec = [
                'plate' => $plate,
                'termcode' => $termcode
            ];
            $tprvec = $this->db_handle->runBaseQuery($tpqvec, $tppvec);

            if (empty($tprvec)) {
                $errors[] = 'Ang iyong plaka ay hindi nakarehistro sa iyong departamento';
            }

            // check for location
            $qloc = 'SELECT * FROM locations WHERE `loc_code` = :loc';
            $ploc = [
                'loc' => $loc
            ];
            $rloc = $this->db_handle->runBaseQuery($qloc, $ploc);

            if (empty($rloc)) {
                $errors[] = 'May mali sa lokasyon na iyong nilagay';
            }

            // check for location and term code
            $tqloc = 'SELECT * FROM locations WHERE `loc_code` = :loc AND `term_code` = :termcode';
            $tploc = [
                'loc' => $loc,
                'termcode' => $termcode
            ];
            $trloc = $this->db_handle->runBaseQuery($tqloc, $tploc);

            if (empty($trloc)) {
                $errors[] = 'Ang iyong lokasyon ay hindi nakarehistro sa iyong departamento';
            }

            // check for valid odometer
            if (!is_numeric($odo)) {
                $errors[] = 'May mali sa odometer na iyong nilagay';
            }

            // check for status
            if ($stat != 'OUT' && $stat != 'IN') {
                $errors[] = 'May mali sa status code na iyong nilagay';
            }

            if (empty($errors)) {
                 if ($stat == 'OUT') {

                    // select current status of vehicle
                    $qvec = 'SELECT * FROM vehicles WHERE plate_no = :plate';
                    $pvec = [
                        'plate' => $plate
                    ];
                    $rvec = $this->db_handle->runBaseQuery($qvec, $pvec);

                    $ecurrent_loc = '';

                    if (!empty($rvec)) {
                        $ecurrent_loc = $rvec[0]['loc_code'];
                    }

                    $qout = 'SELECT * FROM trips WHERE `plate_no` = :plate AND `status` = :stat';
                    $pout = [
                        'plate' => $plate,
                        'stat'  => $stat
                    ];
                    $rout = $this->db_handle->runBaseQuery($qout, $pout);

                    $estat      = '';
                    $eorigin    = '';
                    $edest      = '';

                    if (!empty($rout)) {
                        $estat      = $rout[0]['status'];
                        $eorigin    = $rout[0]['origin'];
                        $edest      = $rout[0]['destination'];
                    }

                    // check for valid location
                    if (!empty($rout) && $stat == $estat) {
                            $errors[] = 'Ang sasakyan ay kasalukuyan naka OUT - Mula dito: '.outputLocName($ecurrent_loc).'. Dapat: Mag IN sa iyong destinasyon.';
                    } else {
                        if ($ecurrent_loc != $loc) {
                            $errors[] = 'Icheck ang iyong lokasyon - Lokasyon: '.outputLocName($ecurrent_loc).'. Dapat: Mag OUT sa '.outputLocName($ecurrent_loc);
                        }
                    }

                    // // check for duplicate
                    // if (!empty($rout) && $loc == $ecurrent_loc && $estat != 'OUT') {
                    //     $errors[] = 'Nakalabas kana - Mula dito: '.outputLocName($eorigin).'. Dapat: Kapag nakalabas na, Huwag na mag OUT ulit.';
                    // }
                    
                } elseif ($stat == 'IN') {

                    $estatus = 'OUT';

                    // select current status of vehicle
                    $qvec = 'SELECT * FROM vehicles WHERE plate_no = :plate';
                    $pvec = [
                        'plate' => $plate
                    ];
                    $rvec = $this->db_handle->runBaseQuery($qvec, $pvec);

                    $ecurrent_loc = '';

                    if (!empty($rvec)) {
                        $ecurrent_loc = $rvec[0]['loc_code'];
                    }

                    $qin = 'SELECT * FROM trips WHERE `plate_no` = :plate AND `status` = :stat';
                    $pin = [
                        'plate' => $plate,
                        'stat'  => $estatus
                    ];
                    $rin = $this->db_handle->runBaseQuery($qin, $pin);

                    $estat = '';
                    $eorigin = '';
                    $edest = '';

                    if (!empty($rin)) {
                        $estat      = $rin[0]['status'];
                        $eorigin    = $rin[0]['origin'];
                        $edest      = $rin[0]['destination'];
                    }

                    // check if trip exists
                    if (empty($rin)) {
                        $errors[] = 'Naka-IN ka dito. Kailangan mag out - Lokasyon: '.outputLocName($ecurrent_loc).'. Dapat: Mag OUT sa '.outputLocName($ecurrent_loc);
                    }

                    // check for valid in
                    if ($loc == $eorigin && $loc != 'OTHER') {
                        $errors[] = 'Icheck ang iyong lokasyon - Galing ka dito: '.outputLocName($ecurrent_loc).'. Dapat: Mag IN ka sa iyong destination.';
                    }
                }
            }
        }

        if (!empty($errors)) {
            $error      = implode(', ', $errors);
            $msg        = implode('-', $msg);
            $error_str  = 'Error occured: '.$error;

            $qdriver = "SELECT * FROM drivers WHERE `number` = :mob";
            $pdriver = [
                'mob' => $mob
            ];
            $rdriver = $this->db_handle->runBaseQuery($qdriver, $pdriver);

            if (count($rdriver) > 0) {
                $driver     = $rdriver[0]['name'];
                $driver_id  = $rdriver[0]['id'];
                $driver_termcode = $rdriver[0]['term'];
            } else {
                $driver     = '';
                $driver_id  = '';
                $driver_termcode = '';
            }

            $qbounce = 'INSERT INTO bounce (`from`,`msg`,`receivedAt`,`sender_name`,`sender_id`,`remarks`,`date`,`term_code`) 
            VALUES (:mfrom, :msg, :receivedAt, :driver, :driver_id, :err, :cdate, :term_code)';

            $pbounce = [
                'mfrom'         => $mfrom,
                'msg'           => $msg,
                'receivedAt'    => $cdatetime,
                'driver'        => $driver,
                'driver_id'     => $driver_id,
                'err'           => $error,
                'cdate'         => $cdate,
                'term_code'     => $termcode
            ];

            $rbounce = $this->db_handle->insert($qbounce, $pbounce);

            smsResponse($mob, $error_str);
        }

        if (empty($errors)) :

            /*================================================= 
            SELECT DRIVERS BASED ON NUMBER
            ===================================================*/
            $qdriver = "SELECT * FROM drivers WHERE `number` = :mob";
            
            $pdriver = [
                'mob' => $mob
            ];

            $rdriver = $this->db_handle->runBaseQuery($qdriver, $pdriver);

            if (count($rdriver) > 0) {
                $driver     = $rdriver[0]['name'];
                $driver_id  = $rdriver[0]['id'];
                $driver_termcode = $rdriver[0]['term'];
            } else {
                $driver     = '';
                $driver_id  = '';
                $driver_termcode = '';
            }

            /*================================================= 
            INSERTING INTO TRIPS TABLE
            ===================================================*/
            switch ($stat) {
                case 'OUT':

                    // update the fleet list
                    $qfleet = 'SELECT * FROM fleet WHERE `plate_no` = :plate';
                    $pfleet = [
                        'plate' => $plate
                    ];
                    $rfleet = $this->db_handle->runBaseQuery($qfleet, $pfleet);

                    // get location name and code
                    $qloc = 'SELECT * FROM locations WHERE `loc_code` = :loc AND `term_code` = :termcode';

                    $ploc = [
                        'loc' => $loc,
                        'termcode' => $termcode
                    ];

                    $rloc = $this->db_handle->runBaseQuery($qloc, $ploc);

                    if (!empty($rloc)) {
                        $loc_code = $rloc[0]['loc_code'];
                        $loc_name = $rloc[0]['loc_name'];
                    }

                    if (!empty($rfleet)) {

                        $id = $rfleet[0]['id'];

                        if (count($msg) == 7 && $loc == 'OTHER') {
                            $qfleetup = 'UPDATE fleet SET `status` = :stat, `loc_code` = :loc_code, `loc_name` = :loc_name, `driver` = :driver, `driver_id` = :driver_id, `odo` = :odo, `behavior` = :bev, `term_code` = :term_code WHERE id = :id';
                        
                            $pfleetup = [
                                'stat'      => $stat,
                                'loc_code'  => $loc_code,
                                'loc_name'  => $rmk,
                                'driver'    => $driver,
                                'driver_id' => $driver_id,
                                'odo'       => $odo,
                                'bev'       => 'Travelling',
                                'id'        => $id,
                                'term_code' => $termcode
                            ];

                        } else {

                            $qfleetup = 'UPDATE fleet SET `status` = :stat, `loc_code` = :loc_code, `loc_name` = :loc_name, `driver` = :driver, `driver_id` = :driver_id, `odo` = :odo, `behavior` = :bev, `term_code` = :term_code WHERE id = :id';
                        
                            $pfleetup = [
                                'stat'      => $stat,
                                'loc_code'  => $loc_code,
                                'loc_name'  => $loc_name,
                                'driver'    => $driver,
                                'driver_id' => $driver_id,
                                'odo'       => $odo,
                                'bev'       => 'Travelling',
                                'id'        => $id,
                                'term_code' => $termcode
                            ];
                        }

                        $insertId = $this->db_handle->update($qfleetup, $pfleetup);
                        $insertIds[] = $insertId;

                    } else {

                        if (count($msg) == 7 && $loc == 'OTHER') {
                            $qfleet = 'INSERT INTO fleet (`date`,`plate_no`,`status`,`loc_code`,`loc_name`,`driver`,`driver_id`,`odo`,`behavior`,`term_code`) 
                            VALUES (:cdate, :plate, :stat, :loc_code, :loc_name, :driver, :driver_id, :odo, :bev, :term_code)';

                            $pfleet = [
                                'cdate'     => $cdate,
                                'plate'     => $plate,
                                'stat'      => $stat,
                                'loc_code'  => $loc_code,
                                'loc_name'  => $rmk,
                                'driver'    => $driver,
                                'driver_id' => $driver_id,
                                'odo'       => $odo,
                                'bev'       => 'Travelling',
                                'term_code' => $termcode
                            ];

                        } else {

                            $qfleet = 'INSERT INTO fleet (`date`,`plate_no`,`status`,`loc_code`,`loc_name`,`driver`,`driver_id`,`odo`,`behavior`,`term_code`) 
                            VALUES (:cdate, :plate, :stat, :loc_code, :loc_name, :driver, :driver_id, :odo, :bev, :term_code)';

                            $pfleet = [
                                'cdate'     => $cdate,
                                'plate'     => $plate,
                                'stat'      => $stat,
                                'loc_code'  => $loc_code,
                                'loc_name'  => $loc_name,
                                'driver'    => $driver,
                                'driver_id' => $driver_id,
                                'odo'       => $odo,
                                'bev'       => 'Travelling',
                                'term_code' => $termcode
                            ];
                        }

                        $insertId = $this->db_handle->update($qfleet, $pfleet);
                        $insertIds[] = $insertId;

                    }
                    
                    if (count($msg) == 7 && $loc == 'OTHER') {
                        $qtrip = 'INSERT INTO trips (`month`,`date`,`driver_id`,`driver_name`,`plate_no`,`status`,`origin`,`dpt_time`,`dpt_odo`,`remarks`, `att_timein`, `compa`, `term_code`) 
                        VALUES (:mo, :cdate, :driver_id, :driver, :plate, :stat, :loc, :ctime, :odo, :rmk, :att_timein, :compa, :term_code)';
                        
                        $ptrip = [
                            'mo'            => $cmonth,
                            'cdate'         => $cdate,
                            'driver_id'     => $driver_id,
                            'driver'        => $driver,
                            'plate'         => $plate,
                            'stat'          => $stat,
                            'loc'           => $loc,
                            'ctime'         => $ctime,
                            'odo'           => $odo,
                            'rmk'           => $rmk,
                            'att_timein'    => $ctime_att,
                            'compa'         => $compa,
                            'term_code'     => $termcode
                        ];

                    } else {

                        $qtrip = 'INSERT INTO trips (`month`,`date`,`driver_id`,`driver_name`,`plate_no`,`status`,`origin`,`dpt_time`,`dpt_odo`,`att_timein`,`compa`,`term_code`) 
                        VALUES (:mo, :cdate, :driver_id, :driver, :plate, :stat, :loc, :ctime, :odo, :att_timein, :compa, :term_code)';
                        
                        $ptrip = [
                            'mo'            => $cmonth,
                            'cdate'         => $cdate,
                            'driver_id'     => $driver_id,
                            'driver'        => $driver,
                            'plate'         => $plate,
                            'stat'          => $stat,
                            'loc'           => $loc,
                            'ctime'         => $ctime,
                            'odo'           => $odo,
                            'att_timein'    => $ctime_att,
                            'compa'         => $compa,
                            'term_code'     => $termcode
                        ];
                    }
                    

                    $insertId = $this->db_handle->insert($qtrip, $ptrip);
                    $insertIds[] = $insertId;

                    $succ_str = 'Matagumpay na nakapag OUT - Lokasyon: '.$loc;
                    smsResponse($mob, $succ_str);

                    break;

                case 'IN':
                    
                    $status = 'OUT';

                    $qtrip = 'SELECT * FROM trips WHERE `plate_no` = :plate AND `status` = :stat';

                    $ptrip = [
                        'plate' => $plate,
                        'stat'  => $status
                    ];

                    $rtrip = $this->db_handle->runBaseQuery($qtrip, $ptrip);

                    $count = count($rtrip); 

                    if ($count > 0) {

                        $id = $rtrip[0]['id'];
                        $cdateout = $rtrip[0]['date'];
                        $time = $rtrip[0]['dpt_time'];
                        $ctime = date('h:i a');

                        // check for driver shifting
                        $prevdid = $rtrip[0]['driver_id'];

                        if ($driver_id != $prevdid) {
                            $odriver = $rtrip[0]['driver_name'];
                            if (!empty($odriver)) {
                                $driver = $odriver.' -> '.$driver;
                            }
                        }
                        
                        if (!empty($rtrip[0]['remarks'])) {
                            $ormks = [];
                            $ormks[] = $rtrip[0]['remarks'];
                            $ormks[] = $rmk;
                            $ormk = implode(' -> ', $ormks);
                        } else {
                            $ormk = $rmk;
                        }

                        if (!empty($rtrip[0]['compa'])) {
                            $ocompas = [];
                            $ocompas[] = $rtrip[0]['compa'];
                            $ocompas[] = $compa;
                            $ocompa = implode(' -> ', $ocompas);
                        } else {
                            $ocompa = $compa;
                        }

                        // $total_time = strtotime($ctime) - strtotime($time);
                        // $total_time_raw = $total_time / 60;
                        // $total_time = convertToHoursMins($total_time_raw, '%02d h %02d min');

                        $datetimeout = $cdateout.' '.$time;
                        $datetimein = $cdate.' '.$ctime;

                        $datetimeout = strtotime($datetimeout);  
                        $datetimein = strtotime($datetimein);

                        $total_time_raw = abs($datetimeout - $datetimein) / 60;
                        $total_time = getDiffDates($datetimeout, $datetimein);

                        $dpt_odo = $rtrip[0]['dpt_odo'];
                        $kmrun = ($odo - $dpt_odo);

                        if (count($msg) == 7 && $loc == 'OTHER') {
                            $query = 'UPDATE trips SET `datein` = :datein, `driver_id` = :driver_id, `driver_name` = :driver, `status` = :stat, `destination` = :loc, `arv_time` = :ctime, 
                            `arv_odo` = :odo, `total_time` = :total_time, `km_run` = :kmrun, `raw_time` = :raw_time, `remarks` = :rmk, `att_timeout` = :att_timeout, `compa` = :compa, `term_code` = :term_code WHERE `id` = :id';
                            
                            $params = [
                                'datein'        => $cdate,
                                'driver_id'     => $driver_id,
                                'driver'        => $driver,
                                'stat'          => $stat,
                                'loc'           => $loc,
                                'ctime'         => $ctime,
                                'odo'           => $odo,
                                'total_time'    => $total_time,
                                'kmrun'         => $kmrun,
                                'raw_time'      => $total_time_raw,
                                'rmk'           => $ormk,
                                'id'            => $id,
                                'att_timeout'   => $ctime_att,
                                'compa'         => $ocompa,
                                'term_code'     => $termcode
                            ];

                        } else {

                            $query = 'UPDATE trips SET `datein` = :datein, `driver_id` = :driver_id, `driver_name` = :driver, `status` = :stat, `destination` = :loc, `arv_time` = :ctime, 
                            `arv_odo` = :odo, `total_time` = :total_time, `km_run` = :kmrun, `raw_time` = :raw_time, `att_timeout` = :att_timeout, `compa` = :compa, `term_code` = :term_code WHERE `id` = :id';
                            
                            $params = [
                                'datein'        => $cdate,
                                'driver_id'     => $driver_id,
                                'driver'        => $driver,
                                'stat'          => $stat,
                                'loc'           => $loc,
                                'ctime'         => $ctime,
                                'odo'           => $odo,
                                'total_time'    => $total_time,
                                'kmrun'         => $kmrun,
                                'raw_time'      => $total_time_raw,
                                'id'            => $id,
                                'att_timeout'   => $ctime_att,
                                'compa'         => $ocompa,
                                'term_code'     => $termcode
                            ];
                        }
                        
                        $insertId = $this->db_handle->update($query, $params);
                        $insertIds[] = $insertId;

                        // get location name and code
                        $qloc = 'SELECT * FROM locations WHERE `loc_code` = :loc AND `term_code` = :termcode';

                        $ploc = [
                            'loc' => $loc,
                            'termcode' => $termcode
                        ];

                        $rloc = $this->db_handle->runBaseQuery($qloc, $ploc);

                        if (!empty($rloc)) {
                            $loc_code = $rloc[0]['loc_code'];
                            $loc_name = $rloc[0]['loc_name'];
                        }
                        
                        // update vehicle current location
                        if (count($msg) == 7 && $loc == 'OTHER') {
                            $qvec = 'UPDATE vehicles SET `loc_code` = :loc_code, `loc_name` = :loc_name WHERE `plate_no` = :plate';

                            $pvec = [
                                'loc_code'  => $loc_code,
                                'loc_name'  => $rmk,
                                'plate'     => $plate
                            ];

                        } else {

                            $qvec = 'UPDATE vehicles SET `loc_code` = :loc_code, `loc_name` = :loc_name WHERE `plate_no` = :plate';

                            $pvec = [
                                'loc_code'  => $loc_code,
                                'loc_name'  => $loc_name,
                                'plate'     => $plate
                            ];
                        }

                        $insertId = $this->db_handle->update($qvec, $pvec);
                        $insertIds[] = $insertId;

                        // update the fleet list
                        $qfleet = 'SELECT * FROM fleet WHERE `plate_no` = :plate';
                        $pfleet = [
                            'plate' => $plate
                        ];
                        $rfleet = $this->db_handle->runBaseQuery($qfleet, $pfleet);

                        if (!empty($rfleet)) {

                            $id = $rfleet[0]['id'];

                            if (count($msg) == 7 && $loc == 'OTHER') {
                                $qfleetup = 'UPDATE fleet SET `status` = :stat, `loc_code` = :loc_code, `loc_name` = :loc_name, `driver_id` = :driver_id, `driver` = :driver, `odo` = :odo, `behavior` = :bev, `term_code` = :term_code WHERE id = :id';
                            
                                $pfleetup = [
                                    'stat'      => $stat,
                                    'loc_code'  => $loc_code,
                                    'loc_name'  => $rmk,
                                    'driver_id' => $driver_id,
                                    'driver'    => $driver,
                                    'odo'       => $odo,
                                    'bev'       => 'Idle',
                                    'id'        => $id,
                                    'term_code' => $termcode
                                ];

                            } else {

                                $qfleetup = 'UPDATE fleet SET `status` = :stat, `loc_code` = :loc_code, `loc_name` = :loc_name, `driver_id` = :driver_id, `driver` = :driver, `odo` = :odo, `behavior` = :bev, `term_code` = :term_code WHERE id = :id';
                            
                                $pfleetup = [
                                    'stat'      => $stat,
                                    'loc_code'  => $loc_code,
                                    'loc_name'  => $loc_name,
                                    'driver_id' => $driver_id,
                                    'driver'    => $driver,
                                    'odo'       => $odo,
                                    'bev'       => 'Idle',
                                    'id'        => $id,
                                    'term_code' => $termcode
                                ];
                            }
    
                            $insertId = $this->db_handle->update($qfleetup, $pfleetup);
                            $insertIds[] = $insertId;
    
                        }

                        $succ_str = 'Matagumpay na nakapag IN - Lokasyon: '.$loc;
                        smsResponse($mob, $succ_str);
                        
                    }
        
                    break;
                
                default:
                    # code...
                    break;
            }

            /*================================================= 
            INSERTING INTO SMS TABLE
            ===================================================*/
            $msg = implode('-', $msg);
            
            $qsms = 'INSERT INTO sms (`from`,`to`,`msg`,`receivedAt`,`sender_name`,`sender_id`, `term_code`) VALUES (:mfrom, :mto, :msg, :receivedAt, :driver, :driver_id, :term_code)';

            $psms = [
                'mfrom'         => $mfrom,
                'mto'           => $mto,
                'msg'           => $msg,
                'receivedAt'    => $cdatetime,
                'driver'        => $driver,
                'driver_id'     => $driver_id,
                'term_code'     => $termcode
            ];

            $insertId = $this->db_handle->insert($qsms, $psms);
            $insertIds[] = $insertId;

        endif;
        
        return $errors;

    }
}
?>