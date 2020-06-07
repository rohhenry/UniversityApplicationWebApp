<?php
include 'UAconnect.php';

$a = $_POST['id'];
$b = $_POST['name'];
$c = $_POST['contact_info_email'];
$d = $_POST['login_username'];

$sql = "INSERT INTO student (id, name, contact_info_email, login_username)
VALUES ($a,$b, $c, $d)";

if ($conn->query($sql) === TRUE) {
    echo "New student record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>