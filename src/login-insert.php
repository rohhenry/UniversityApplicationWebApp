<?php
include 'C:\xampp\htdocs\UniversityApplicationWebApp\src\UAconnect.php';
$conn = OpenCon();

$a = $_GET['username'];
$b = $_GET['password'];

$sql = "INSERT INTO login (username, password)
VALUES ($a,$b)";

if ($conn->query($sql) === TRUE) {
    echo "New login record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>