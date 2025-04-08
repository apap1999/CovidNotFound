<?php

include "../database_conn.php";

header('Content-Type: text/plain');
session_start();
$user_id = (isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : -1 );

class Poi {
    private $poi_id;
    private $name;
    private $address;
    private $lat;
    private $lng;
    private $rating;
    private $rating_n;
    private $populartimes;
    private $types;

    function set_poi($poi_id, $name, $address, $lat, $lng, $rating, $rating_n, $populartimes) {
        $this->poi_id = $poi_id;
        $this->name = $name;
        $this->address = $address;
        $this->lat = $lat;
        $this->lng = $lng;
        $this->rating = $rating;
        $this->rating_n = $rating_n;
        $this->populartimes = $populartimes;
    }

    function set_poi_types($types) {
        $this->types[] = $types;
    }

    function get_poi() {
        return [ "poi_id"=>$this->poi_id,
            "name"=>$this->name, 
            "address"=>$this->address,
            "lat"=>$this->lat,
            "lng"=>$this->lng,
            "rating"=>$this->rating,
            "rating_n"=>$this->rating_n,
            "populartimes"=>$this->populartimes
        ];
    }

    function get_poi_types() {
        return $this->types;
    }
}

function get_pois_array($pois) {
    $pois_array = array();
    foreach($pois as $poi) {
        $pois_array[] = $poi->get_poi();
    }
    return $pois_array;
}

if (isset($_POST['search'])) {
    
	$received = utf8_encode($_POST['search']);
    $search = json_decode($received)->search;

    $northEast = $search->northEast;
    $southWest = $search->southWest;
    $northEast_lat = $northEast->lat;
    $northEast_lng = $northEast->lng;
    $southWest_lat = $southWest->lat;
    $southWest_lng = $southWest->lng;
    $search_by = $search->search_by;
    $search_value = $search->search_value;

    if ($search_by == "name") {
        $fetchPOIs = "SELECT pois.poi_id, pois.name, pois.address, pois.latitude, pois.longitude, pois.rating, pois.rating_n, pois.populartimes FROM pois 
                    WHERE pois.latitude > '$southWest_lat'
                        AND pois.latitude < '$northEast_lat'
                        AND pois.longitude > '$southWest_lng'
                        AND pois.longitude < '$northEast_lng'
                        AND pois.name LIKE '%$search_value%';";

    } else if ($search_by == "type") {
        $fetchPOIs = "SELECT pois.poi_id, pois.name, pois.address, pois.latitude, pois.longitude, pois.rating, pois.rating_n, pois.populartimes FROM pois 
                    INNER JOIN pois_type ON pois.poi_id = pois_type.poi_id
                    INNER JOIN types ON pois_type.type_id = types.type_id
                    WHERE pois.latitude > '$southWest_lat'
                        AND pois.latitude < '$northEast_lat'
                        AND pois.longitude > '$southWest_lng'
                        AND pois.longitude < '$northEast_lng'
                        AND types.name LIKE '%$search_value%';";

    } else {
        $error = array("error"=>"[Wrong search type]");
        echo json_encode($error);
        die;
    }

    try {
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $fetchPOIs);
        mysqli_stmt_execute($stmt);
    }
    catch (Exception $err) {
        $error = array("error"=>"[SQL Error]");
        echo json_encode($error);
        die;
    }

    $poi_res = array();

    $resultData = mysqli_stmt_get_result($stmt);
    $i = 0;
    while ($row = mysqli_fetch_assoc($resultData)) {
        $poi_res[$i] = new Poi();
        $poi_res[$i]->set_poi($row["poi_id"], $row["name"], $row["address"], $row["latitude"], $row["longitude"], $row["rating"], $row["rating_n"], $row["populartimes"]);
        $i++;
    };

    if (!count($poi_res)) {
        $error = array("error"=>"[Empty Response]");
        echo json_encode($error);
    }
    else { echo json_encode(get_pois_array($poi_res)); }
    mysqli_stmt_close($stmt);
    die;
}

if (isset($_POST['estimation'])) {

    $poi_id = $_POST['estimation'];

    date_default_timezone_set("Europe/Athens");
    $current_time =  date_create()->format('Y-m-d H:i:s');
    
    $get_est = "SELECT estimation FROM visits
        WHERE poi_id = '$poi_id' AND visit_time > date_sub('$current_time', INTERVAL 2 HOUR);";

    try {
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $get_est);
        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($resultData);
        $i=0;
        $estim=0;
        if (!$row) { echo json_encode(['estimation' => 'No recent visits!']);  }
        else { 
            while($row){
                $i++;
                $estim += $row["estimation"];
                $row = mysqli_fetch_assoc($resultData);               
            } 
            $estim = $estim / $i;
            echo json_encode(['estimation' => $estim]);
        }                
        mysqli_stmt_close($stmt);
    }
    catch (Exception $err) {
        $error = array(['error' => '[SQL Failed]'.$err]);
        echo json_encode($error);
        die;
    }
}

if (isset($_POST['visits'])) {
    
	$received = utf8_encode($_POST['visits']);
    $visits = json_decode($received);
    $poi_id = $visits->poi_id;
    $estimation = $visits->estimation;
    date_default_timezone_set("Europe/Athens");
    $visit_time =  date_create()->format('Y-m-d H:i:s');

    $insert_visits = "INSERT INTO visits (user_id, poi_id, visit_time, estimation)
                    VALUES ('$user_id', '$poi_id', '$visit_time', '$estimation');";

    try {
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $insert_visits);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        echo "[SQL Success]";
    }
    catch (Exception $err) {
        echo "[SQL Failed]";
        die;
    }
}

?>