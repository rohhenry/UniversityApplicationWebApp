<?php

include 'UAconnect.php';

$a = $_POST['address'];
$b = $_POST['postal_code'];

$sql = "INSERT INTO student (address, postal_code)
VALUES ($a,$b)";

if ($conn->query($sql) === TRUE) {
    echo "New local address record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
