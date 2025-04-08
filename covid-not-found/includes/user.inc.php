<?php

include "../database_conn.php";

header('Content-Type: text/plain');
session_start();
$user_id = (isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : -1 );

// Confirm Covid Case Button
if (isset($_POST['confcase'])) {
    
	$received = utf8_encode($_POST['confcase']);
    $confcase = json_decode($received);
    $date = $confcase->date;

    // Check for recent covid case
    $recent_case = "SELECT * FROM covid_cases 
                        WHERE date >= date_sub('$date', INTERVAL 14 DAY)
                        AND user_id = '$user_id'; ";

    try {
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $recent_case);
        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($resultData);
        if (!$row) { 
            $insert_confcase = "INSERT INTO covid_cases (user_id, date)
                    VALUES ('$user_id', '$date');";

            try {
                $stmt = mysqli_stmt_init($conn);
                mysqli_stmt_prepare($stmt, $insert_confcase);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
                echo "[SQL Success]";
            }
            catch (Exception $err) {
                echo "[SQL Failed]";
                die;
            }        
        }
        else { echo "[Recent case exists]"; }                

        mysqli_stmt_close($stmt);
    }
    catch (Exception $err) {
        echo "[SQL Failed]";
        die;
    }
}

if (isset($_POST['is_admin'])) {
    if (isset($_SESSION['user_id'])) {
        $data = array('user_id' => $_SESSION['user_id'], 'user_name' => $_SESSION["user_name"], 'is_admin' => $_SESSION['is_admin']);
        echo json_encode($data);
    } else { echo "[No session running!]"; }  
}

if (isset($_POST['my_visits'])) {
    $get_my_visits = "SELECT pois.name, visit_time FROM visits INNER JOIN pois ON visits.poi_id = pois.poi_id WHERE user_id = '$user_id';";

    try {
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $get_my_visits);
        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt);
    
        while($row = mysqli_fetch_assoc($resultData)){
            $my_visits[] = array("poi_name" => $row["name"], "visit_time" => $row["visit_time"]);
        }
        echo json_encode($my_visits);
        mysqli_stmt_close($stmt);        
    }
    catch (Exception $err) {
        echo json_encode(["error" => $err]);
        die;
    } 
}

if (isset($_POST['my_cases'])) {
    $get_my_cases = "SELECT * FROM covid_cases WHERE user_id = '$user_id';";

    try {
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $get_my_cases);
        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt);
        $i = 1;
        while($row = mysqli_fetch_assoc($resultData)){
            $my_cases[] = array("covid_case" => $i++, "covid_time" => $row["date"]);
        }
        echo json_encode($my_cases);
        mysqli_stmt_close($stmt);        
    }
    catch (Exception $err) {
        echo json_encode(["error" => $err]);
        die;
    }  
}

if (isset($_POST['possible_contact'])) {

    date_default_timezone_set("Europe/Athens");
    $current_time =  date_create()->format('Y-m-d H:i:s');

    $possible_contact = "SELECT pois.name, visits.visit_time FROM visits
                            INNER JOIN pois ON visits.poi_id = pois.poi_id 
                            WHERE visits.user_id = '$user_id'
                                AND visits.visit_time >= date_sub('$current_time', INTERVAL 7 DAY)
                                AND visits.poi_id IN (
                                    SELECT covid_visits.poi_id FROM visits AS covid_visits
                                    INNER JOIN covid_cases ON covid_visits.user_id = covid_cases.user_id
                                    WHERE covid_visits.visit_time >= date_sub('$current_time', INTERVAL 7 DAY)
                                        AND covid_cases.user_id <> '$user_id'
                                        AND visits.visit_time >= date_sub(covid_visits.visit_time, INTERVAL 2 HOUR)
                                        AND visits.visit_time <= date_add(covid_visits.visit_time, INTERVAL 2 HOUR)
                                );";

    try {
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $possible_contact);
        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt);
        while($row = mysqli_fetch_assoc($resultData)){
            $possible_cases[] = array("poi_name" => $row["name"], "visit_time" => $row["visit_time"]);
        }
        echo json_encode($possible_cases);
        mysqli_stmt_close($stmt);        
    }
    catch (Exception $err) {
        echo json_encode(["error" => $err]);
        die;
    }
}

if (isset($_POST['has_covid'])) {

    date_default_timezone_set("Europe/Athens");
    $current_time =  date_create()->format('Y-m-d');

    $has_covid = "SELECT COUNT(*) AS covid FROM covid_cases
                    WHERE covid_cases.user_id = '$user_id'
                        AND covid_cases.date >= date_sub('$current_time', INTERVAL 14 DAY);";

    try {
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $has_covid);
        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($resultData);
        if ($row["covid"] > 0){
            $covid = ["has_covid" => "You have Covid!"];
        } else if ($row["covid"] == 0) {
            $covid = ["not_covid" => "You don't have Covid!"];
        }
        echo json_encode($covid);
        mysqli_stmt_close($stmt);        
    }
    catch (Exception $err) {
        echo json_encode(["error" => $err]);
        die;
    }
}
?>