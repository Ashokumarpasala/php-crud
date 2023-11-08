<?php
include 'bd.php';

$name = '';
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $message = $_POST['message'];
    
    $sql = "INSERT INTO crudOperation(name, message ) VALUES ('$name', '$message')";

    if ($conn->query($sql) == TRUE) {
        # code...
        echo 'Record created Suceesfull';
    } else {
        # code...
        echo "Error: " . $sql . "<br>" . $conn->error;

    }

    $conn->close();
    
} else {

}
 
?>