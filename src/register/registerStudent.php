


<?php
//include '..\UAconnect.php';
include "..\config.php";

//$conn = OpenCon();

$a = $_POST['username'];
$b = $_POST['password'];
$c = $_POST['student_name'];
$d = $_POST['student_id'];
$e = $_POST['email'];
$f = $_POST['phone_number'];
$k = $_POST['address'];
$h = $_POST['postal_code'];


$sql = " INSERT INTO login (username, password) VALUES ('$a','$b'); 
 INSERT INTO local_address (contact_info_address, postal_code) VALUES ('$k','$h');
 INSERT INTO Contact_info (phone_number,address, email) VALUES ('$f','$k', '$e');
 INSERT INTO student (id, name, contact_info_email, login_username) VALUES ('$d','$c', '$e', '$a');";

$result = $mysqli->multi_query($sql);


if ($result) {
    echo "New student record created successfully";
    header("Location: ../Logout.php");
} else {
    echo "Error: " . $sql . "<br>" . $mysqli->error;
}



//$conn->close();

?>

