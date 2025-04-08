<?php

	include "../database_conn.php";
    header('Content-Type: text/plain');
	
    if (isset($_POST['chart1'])) {
        // Fetch num of Total Visits that have been registered in the DB
        $fetch_visits = "SELECT COUNT(*) FROM visits";

        try {
            $stmt = mysqli_stmt_init($conn);
        
            mysqli_stmt_prepare($stmt, $fetch_visits);
            mysqli_stmt_execute($stmt);

            $resultData = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($resultData);
    
            $total_visits = array(
                'total_visits' => $row['COUNT(*)']
            );
            echo json_encode($total_visits);
            mysqli_stmt_close($stmt);
        }
        catch (Exception $err) {
            echo json_encode(['error' => '[SQL Failed]']);
            die;
        }
    }

    if (isset($_POST['chart2'])) {
        // Fetch num of Total Confirmed Cases that have been registered in the DB
        $fetch_covid = "SELECT COUNT(*) FROM covid_cases";

        try {
            $stmt = mysqli_stmt_init($conn);
        
            mysqli_stmt_prepare($stmt, $fetch_covid);
            mysqli_stmt_execute($stmt);

            $resultData = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($resultData);
    
            $covid_cases = array(
                'covid_cases' => $row['COUNT(*)']
            );
            echo json_encode($covid_cases);
            mysqli_stmt_close($stmt);
        }
        catch (Exception $err) {
            echo json_encode(['error' => '[SQL Failed]']);
            die;
        }
    }

    if (isset($_POST['chart3'])) {
        // Fetch num of Total Visits of Confirmed Cases that have been registered in the DB
        $fetch_visits_visits = "SELECT COUNT(*) FROM visits
            INNER JOIN covid_cases ON visits.user_id = covid_cases.user_id
            WHERE ( visits.visit_time >= covid_cases.date 
                    AND date_sub(visits.visit_time, INTERVAL 7 DAY) <= covid_cases.date )
                OR ( visits.visit_time < covid_cases.date 
                    AND date_add(visits.visit_time, INTERVAL 14 DAY) >= covid_cases.date )";

        try {
            $stmt = mysqli_stmt_init($conn);
        
            mysqli_stmt_prepare($stmt, $fetch_visits_visits);
            mysqli_stmt_execute($stmt);

            $resultData = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($resultData);
    
            $covid_visits = array(
                'covid_visits' => $row['COUNT(*)']
            );
            echo json_encode($covid_visits);
            mysqli_stmt_close($stmt);
        }
        catch (Exception $err) {
            echo json_encode(['error' => '[SQL Failed]']);
            die;
        }
    }
    
    if (isset($_POST['chart4'])) {
        // Fetch num of Visits to each POI type that have been registered in the DB
        $fetch_visit_types = "SELECT types.name, COUNT(visits.visit_id) AS visits FROM visits
            INNER JOIN pois_type ON visits.poi_id = pois_type.poi_id
            INNER JOIN types ON pois_type.type_id = types.type_id
            GROUP BY types.name";

        try {
            $stmt = mysqli_stmt_init($conn);
        
            mysqli_stmt_prepare($stmt, $fetch_visit_types);
            mysqli_stmt_execute($stmt);

            $resultData = mysqli_stmt_get_result($stmt);
            
            while($row = mysqli_fetch_assoc($resultData)){
                $type[] = $row['name'];
                $visits[] = $row['visits'];
                $color[] = 'rgb(' . rand(0, 255) . ', ' . rand(0, 255) . ', ' . rand(0, 255) . ')';
            }            
            $visit_types = array('type' => $type, 'visits' => $visits, 'color' => $color);
            echo json_encode($visit_types);
            mysqli_stmt_close($stmt);
        }
        catch (Exception $err) {
            echo $err;
            // echo json_encode(['error' => '[SQL Failed]']);
            die;
        }
    }  

    if (isset($_POST['chart5'])) {
        // Fetch num of Covid Visits to each POI type that have been registered in the DB
        $fetch_covid_visit_types = "SELECT types.name, COUNT(visits.visit_id) AS visits FROM covid_cases
            INNER JOIN visits ON visits.user_id = covid_cases.user_id
            INNER JOIN pois_type ON visits.poi_id = pois_type.poi_id
            INNER JOIN types ON pois_type.type_id = types.type_id
            WHERE ( visits.visit_time >= covid_cases.date 
                    AND date_sub(visits.visit_time, INTERVAL 7 DAY) <= covid_cases.date )
                OR ( visits.visit_time < covid_cases.date 
                    AND date_add(visits.visit_time, INTERVAL 14 DAY) >= covid_cases.date )
            GROUP BY types.name";

        try {
            $stmt = mysqli_stmt_init($conn);
        
            mysqli_stmt_prepare($stmt, $fetch_covid_visit_types);
            mysqli_stmt_execute($stmt);

            $resultData = mysqli_stmt_get_result($stmt);
            
            while($row = mysqli_fetch_assoc($resultData)){
                $type[] = $row['name'];
                $visits[] = $row['visits'];
                $color[] = 'rgb(' . rand(0, 255) . ', ' . rand(0, 255) . ', ' . rand(0, 255) . ')';
            }            
            $covid_visit_types = array('type' => $type, 'visits' => $visits, 'color' => $color);
            echo json_encode($covid_visit_types);
            mysqli_stmt_close($stmt);
        }
        catch (Exception $err) {
            echo json_encode(['error' => '[SQL Failed]']);
            die;
        }
    } 
    
    if (isset($_POST['chart6'])) {

        $recived = utf8_encode($_POST['chart6']);
        $minDate = json_decode($recived)->minDate;
        $maxDate = json_decode($recived)->maxDate;
        $if_visits = json_decode($recived)->visits;
        $if_confcases = json_decode($recived)->confcases;

        $visitFilter = "SELECT visit_time FROM visits 
                            WHERE visit_time <= '$maxDate' 
                                AND visit_time >= '$minDate'  
                                ORDER BY visit_time ASC;";
        $confcaseFilter = "SELECT visit_time FROM visits 
                            INNER JOIN covid_cases ON visits.user_id = covid_cases.user_id
                            WHERE ( visits.visit_time >= covid_cases.date 
                                    AND date_sub(visits.visit_time, INTERVAL 7 DAY) <= covid_cases.date )
                                OR ( visits.visit_time < covid_cases.date 
                                    AND date_add(visits.visit_time, INTERVAL 14 DAY) >= covid_cases.date )
                                AND visit_time <= '$maxDate' 
                                AND visit_time >= '$minDate'  
                                ORDER BY visit_time ASC;";
        
        if (!($if_visits && $if_confcases)) {
            if ($if_visits && !$if_confcases) { $dateFilter = $visitFilter; } 
            elseif (!$if_visits && $if_confcases) { $dateFilter = $confcaseFilter; }
           
            try {
                $stmt = mysqli_stmt_init($conn);
                mysqli_stmt_prepare($stmt, $dateFilter);
                mysqli_stmt_execute($stmt);
        
                $resultData = mysqli_stmt_get_result($stmt);
        
                while($row = mysqli_fetch_assoc($resultData)){
                    $dateArray[] = $row["visit_time"];
                }
                $data = array('dateArray' => $dateArray);
                echo json_encode($data);
                mysqli_stmt_close($stmt);
            }
            catch (Exception $err) {
                echo json_encode(['error' => '[SQL Failed]']);
                die;
            }  
        }  else {
            try {
                $stmt = mysqli_stmt_init($conn);
                mysqli_stmt_prepare($stmt, $visitFilter);
                mysqli_stmt_execute($stmt);
        
                $resultData = mysqli_stmt_get_result($stmt);
        
                while($row = mysqli_fetch_assoc($resultData)){
                    $dateArray[] = $row["visit_time"];
                }
                mysqli_stmt_close($stmt);

                $stmt = mysqli_stmt_init($conn);
                mysqli_stmt_prepare($stmt, $confcaseFilter);
                mysqli_stmt_execute($stmt);
        
                $resultData = mysqli_stmt_get_result($stmt);
        
                while($row = mysqli_fetch_assoc($resultData)){
                    $caseArray[] = $row["visit_time"];
                }
                mysqli_stmt_close($stmt);

                $data = array('dateArray' => $dateArray, 'caseArray' => $caseArray);
                echo json_encode($data);
            }
            catch (Exception $err) {
                echo json_encode(['error' => '[SQL Failed]']);
                die;
            }
        }
    }

    if (isset($_POST['chart7'])) {

        $recived = utf8_encode($_POST['chart7']);
        $myDate = json_decode($recived)->myDate;
        $if_visits = json_decode($recived)->visits;
        $if_confcases = json_decode($recived)->confcases;

        $visitFilter = "SELECT visit_time FROM visits WHERE visit_time LIKE '$myDate %'";
        $confcaseFilter = "SELECT visit_time FROM visits 
                            INNER JOIN covid_cases ON visits.user_id = covid_cases.user_id
                            WHERE ( visits.visit_time >= covid_cases.date 
                                    AND date_sub(visits.visit_time, INTERVAL 7 DAY) <= covid_cases.date )
                                OR ( visits.visit_time < covid_cases.date 
                                    AND date_add(visits.visit_time, INTERVAL 14 DAY) >= covid_cases.date )
                                AND visit_time LIKE '$myDate %'";

        if (!($if_visits && $if_confcases)) {
            if ($if_visits && !$if_confcases) { $dateFilter = $visitFilter; } 
            elseif (!$if_visits && $if_confcases) { $dateFilter = $confcaseFilter; }

            try {
                $stmt = mysqli_stmt_init($conn);
                mysqli_stmt_prepare($stmt, $dateFilter);
                mysqli_stmt_execute($stmt);
        
                $resultData = mysqli_stmt_get_result($stmt);
        
                while($row = mysqli_fetch_assoc($resultData)){
                    $date_visits[] = $row["visit_time"];
                }
                $data = array('date_visits' => $date_visits);
                echo json_encode($data);
                mysqli_stmt_close($stmt);
            }
            catch (Exception $err) {
                echo json_encode(['error' => '[SQL Failed]']);
                die;
            } 
        } else {
            try {
                $stmt = mysqli_stmt_init($conn);
                mysqli_stmt_prepare($stmt, $visitFilter);
                mysqli_stmt_execute($stmt);
        
                $resultData = mysqli_stmt_get_result($stmt);
        
                while($row = mysqli_fetch_assoc($resultData)){
                    $dateArray[] = $row["visit_time"];
                }
                mysqli_stmt_close($stmt);

                $stmt = mysqli_stmt_init($conn);
                mysqli_stmt_prepare($stmt, $confcaseFilter);
                mysqli_stmt_execute($stmt);
        
                $resultData = mysqli_stmt_get_result($stmt);
        
                while($row = mysqli_fetch_assoc($resultData)){
                    $caseArray[] = $row["visit_time"];
                }
                mysqli_stmt_close($stmt);

                $data = array('date_visits' => $dateArray, 'caseArray' => $caseArray);
                echo json_encode($data);
            }
            catch (Exception $err) {
                echo json_encode(['error' => '[SQL Failed]']);
                die;
            }
        }   
    }
?>