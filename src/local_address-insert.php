<?php

include 'C:\xampp\htdocs\UniversityApplicationWebApp\src\UAconnect.php';
$conn = OpenCon();

$a = $_POST['address'];
$b = $_POST['postal_code'];

$sql = "INSERT INTO student (contact_info_address, postal_code)
VALUES ($a,$b)";

if ($conn->query($sql) === TRUE) {
    echo "New local address record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
