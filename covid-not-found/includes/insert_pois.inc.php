<?php

	include "../database_conn.php";

	header('Content-Type: text/plain');

	if (isset($_POST['pois'])) {
		$file = utf8_encode($_POST['pois']);
		$data = json_decode($file);

		foreach($data as $tmp_poi) {
			$status_return = insert_poi($tmp_poi, $conn);	
		}

		if ($status_return != 'ERROR') { echo "[Status: 200] Data Inserted Successfully!"; }
	}

	if (isset($_POST['delete'])) { delete_all($conn); }


	function insert_poi($tmp_poi, $conn) {
		if (isset($tmp_poi->id)) { $tmp_id = $tmp_poi->id; } else { $tmp_id = null; }
		if (isset($tmp_poi->name)) { $tmp_name = $tmp_poi->name; } else { $tmp_name = null; } 
		if (isset($tmp_poi->address)) { $tmp_address = $tmp_poi->address; } else { $tmp_address = null; } 
		if (isset($tmp_poi->rating)) { $tmp_rating = $tmp_poi->rating; } else { $tmp_rating = null; } 
		if (isset($tmp_poi->rating_n)) { $tmp_rating_n = $tmp_poi->rating_n; } else { $tmp_rating_n = null; } 
		if (isset($tmp_poi->coordinates)) { $tmp_coordinates = $tmp_poi->coordinates; } else { $tmp_coordinates = null; } 
		if (isset($tmp_coordinates->lat)) { $tmp_latitude = $tmp_coordinates->lat; } else { $tmp_latitude = null; } 
		if (isset($tmp_coordinates->lng)) { $tmp_longitude = $tmp_coordinates->lng; } else { $tmp_longitude = null; } 
		if (isset($tmp_poi->populartimes)) { $tmp_populartimes = json_encode($tmp_poi->populartimes); } else { $tmp_populartimes = null; }

		$insert_poi = "INSERT INTO pois (poi_id, name, address, latitude, longitude, rating, rating_n, populartimes)
						VALUES ('$tmp_id','$tmp_name','$tmp_address','$tmp_latitude','$tmp_longitude','$tmp_rating','$tmp_rating_n','$tmp_populartimes');";

		try {
			$stmt = mysqli_stmt_init($conn);
			mysqli_stmt_prepare($stmt, $insert_poi);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
			insert_types($tmp_poi, $conn);
		}
		catch (Exception $err) {
			// Handle the Duplicate entries and update the columns!
			if(strpos($err, 'Duplicate entry') == true){
				mysqli_stmt_close($stmt);
				update_poi($tmp_poi, $conn);
			} else{
				mysqli_stmt_close($stmt);
				echo "[SQL Failed]";
				return 'ERROR';
				die;
			}
		}    	
	}

	function insert_types($tmp_poi, $conn) {
		if (isset($tmp_poi->id)) { $tmp_id = $tmp_poi->id; } else { $tmp_id = null; } 
		if (isset($tmp_poi->types)) { $tmp_types = $tmp_poi->types; } else { $tmp_types = null; }

		foreach($tmp_types as $type) {
			$select_type = "SELECT COUNT(*) FROM types WHERE name = '$type';";
			$insert_type = "INSERT INTO types (name) VALUES ('$type');";
			$insert_pois_type = "INSERT INTO pois_type (poi_id, type_id)
									SELECT '$tmp_id', type_id FROM types
										WHERE name = '$type';";
			
			try {
				$stmt = mysqli_stmt_init($conn);			
				mysqli_stmt_prepare($stmt, $select_type);
				mysqli_stmt_execute($stmt);

				$resultData = mysqli_stmt_get_result($stmt);
				$row = mysqli_fetch_assoc($resultData);
		
				if ($row['COUNT(*)'] == 0){
					mysqli_stmt_prepare($stmt, $insert_type);
					mysqli_stmt_execute($stmt);
				}
				mysqli_stmt_prepare($stmt, $insert_pois_type);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_close($stmt);
			}
			catch (Exception $err) {
				echo $err;
				return 'ERROR';
				die;
			} 				
		}
	}

	function update_poi($tmp_poi, $conn) {
		if (isset($tmp_poi->id)) { $tmp_id = $tmp_poi->id; } else { $tmp_id = null; }
		if (isset($tmp_poi->rating)) { $tmp_rating = $tmp_poi->rating; } else { $tmp_rating = null; } 
		if (isset($tmp_poi->rating_n)) { $tmp_rating_n = $tmp_poi->rating_n; } else { $tmp_rating_n = null; } 
		if (isset($tmp_poi->populartimes)) { $tmp_populartimes = json_encode($tmp_poi->populartimes); } else { $tmp_populartimes = null; }

		$insert_poi = "UPDATE pois 
						SET rating = '$tmp_rating', rating_n = '$tmp_rating_n', populartimes = '$tmp_populartimes'
							WHERE poi_id = '$tmp_id';";

		try {
			$stmt = mysqli_stmt_init($conn);
			mysqli_stmt_prepare($stmt, $insert_poi);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
			
		}
		catch (Exception $err) {
			echo $err;
			return 'ERROR';
			die;
		} 	
	}

	function delete_all($conn) {
		$delete_poi_types = "DELETE FROM poi_types;";
		$delete_visits = "DELETE FROM visits;";			
		$delete_pois = "DELETE FROM pois;";
		$delete_covid_cases = "DELETE FROM covid_cases;";


		try {
			$stmt = mysqli_stmt_init($conn);
			mysqli_stmt_prepare($stmt, $delete_poi_types);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_prepare($stmt, $delete_pois);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_prepare($stmt, $delete_visits);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_prepare($stmt, $delete_covid_cases);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
			echo "Deleted Successfully!";
		}
		catch (Exception $err) {
			echo $err;
			die;
		}
	}

?>
