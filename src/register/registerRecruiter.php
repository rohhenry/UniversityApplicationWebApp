
<?php
include 'C:\xampp\htdocs\UniversityApplicationWebApp\src\UAconnect.php';
$conn = OpenCon();

$a = $_GET['username'];
$b = $_GET['password'];
$c = $_GET['recruiter_name'];
$d = $_GET['recruiter_id'];
$e = $_GET['email'];
$f = $_GET['phone_number'];
$g = $_GET['address'];
$h = $_GET['postal_code'];
$i = $_GET['university_name'];

$sql = " INSERT INTO login (username, password) VALUES ('$a','$b'); 
 INSERT INTO local_address (contact_info_address, postal_code) VALUES ('$g','$h');
 INSERT INTO Contact_info (phone_number,address, email) VALUES ('$f','$g', '$e');
 INSERT INTO student (id, name, contact_info_email, login_username) VALUES ('$d','$c', 'i','$e', '$a');";


if ($conn->multi_query($sql) === TRUE) {
    echo "New recruiter record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

header("Location: ../Login.php");

$conn->close();

