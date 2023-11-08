<?php
    $servername = "localhost";
    $username = "ashok";
    $password = "123456";
    $dbname = "crud";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>
