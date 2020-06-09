<?php

include 'C:\xampp\htdocs\UniversityApplicationWebApp\src\UAconnect.php';
$conn = OpenCon();

$a = $_POST['phone_number'];
$b = $_POST['address'];
$c = $_POST['email'];

$sql = "INSERT INTO student (phone_number, address, email)
VALUES ($a,$b, $c)";

if ($conn->query($sql) === TRUE) {
    echo "New contact info record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
