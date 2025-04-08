<?php

    //Connecting to the database
    $servername = "localhost:3306";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "covid";

    //Create connection
    $conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);

    //Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

?>