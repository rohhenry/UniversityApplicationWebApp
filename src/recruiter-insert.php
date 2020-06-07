<?php
include 'UAconnect.php';

$a = $_POST['id'];
$b = $_POST['name'];
$c = $_POST['university_name'];
$d = $_POST['contact_info_email'];
$e = $_POST['login_username'];

$sql = "INSERT INTO student (id, name,university_name, contact_info_email, login_username)
VALUES ($a,$b, $c, $d,$e)";

if ($conn->query($sql) === TRUE) {
    echo "New recruiter record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>