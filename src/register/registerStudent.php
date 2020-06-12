


<?php
include 'C:\xampp\htdocs\UniversityApplicationWebApp\src\UAconnect.php';
//include "..\config.php";

$conn = OpenCon();

$a = $_GET['username'];
$b = $_GET['password'];
$c = $_GET['student_name'];
$d = $_GET['student_id'];
$e = $_GET['email'];
$f = $_GET['phone_number'];
$k = $_GET['address'];
$h = $_GET['postal_code'];


$sql = " INSERT INTO login (username, password) VALUES ('$a','$b'); 
 INSERT INTO local_address (contact_info_address, postal_code) VALUES ('$k','$h');
 INSERT INTO Contact_info (phone_number,address, email) VALUES ('$f','$k', '$e');
 INSERT INTO student (id, name, contact_info_email, login_username) VALUES ('$d','$c', '$e', '$a');";


if ($conn->multi_query($sql) === TRUE) {

    echo "New student record created successfully";
    header("Location: ../Login.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}



$conn->close();

?>

