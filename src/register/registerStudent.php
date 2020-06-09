
<?php
include 'C:\xampp\htdocs\UniversityApplicationWebApp\src\UAconnect.php';
$conn = OpenCon();

$a = $_GET['username'];
$b = $_GET['password'];
$c = $_GET['student_name'];
$d = $_GET['student_id'];
$e = $_GET['email'];
$f = $_GET['phone_number'];
$g = $_GET['address'];
$h = $_GET['postal_code'];

$conn->multi_query(" Many SQL queries ; "); // OK
while ($conn->next_result()) {;} // flush multi_queries
$conn->query(" INSERT INTO login (username, password) VALUES ($a,$b) "); // now executed!
$conn->query(" INSERT INTO local_address (contact_info_address, postal_code) VALUES ($g,$h) "); // now executed!
$conn->query(" INSERT INTO Contact_info (phone_number,address, email) VALUES ($f,$g, $e) "); // now executed!
$conn->query(" INSERT INTO student (id, name, contact_info_email, login_username) VALUES ($d,$c, $e, $a)"); // now executed!


if ($conn->query($sql) === TRUE) {
    echo "New student record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

