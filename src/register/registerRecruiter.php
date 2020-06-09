
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

$conn->multi_query(" Many SQL queries ; "); // OK
while ($conn->next_result()) {;} // flush multi_queries
$conn->query(" INSERT INTO login (username, password) VALUES ($a,$b) "); // now executed!
$conn->query(" INSERT INTO local_address (contact_info_address, postal_code) VALUES ($g,$h) "); // now executed!
$conn->query(" INSERT INTO Contact_info (phone_number,address, email) VALUES ($f,$g, $e) "); // now executed!
$conn->query(" INSERT INTO recruiter (id, name, university_name, contact_info_email, login_username) VALUES ($d,$c,$i, $e, $a)"); // now executed!


if ($conn->query($sql) === TRUE) {
    echo "New student record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

