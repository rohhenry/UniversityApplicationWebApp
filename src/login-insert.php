<?php
include 'UAconnect.php';

$a = $_POST['username'];
$b = $_POST['password'];

$sql = "INSERT INTO login (username, password)
VALUES ($a,$b)";

if ($conn->query($sql) === TRUE) {
    echo "New login record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>