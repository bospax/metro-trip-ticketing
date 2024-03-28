<?php
class trips
{

    // database connection and table name
    private $conn;

    // object properties
    public $id;
    public $term_code;
    public $dateptrips;
    public $ptripdname;
    public $ptripsorig;
    public $loc_name;
    public $ptripcompa;
    public $number;

    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // read locations
    public function read()
    {
        //select all data
        $query = "SELECT
                    pt.id,
                    pt.term_code,
                    pt.dateptrips,
                    pt.ptripdname,
                    pt.ptripsorig,
                    l.loc_name,
                    pt.ptripcompa,
                    d.number
                FROM
                ptrips as pt
                INNER JOIN drivers as d
                ON pt.ptripsdid = d.id
                INNER JOIN locations as l
                ON pt.ptripsdest = l.loc_code";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

}
