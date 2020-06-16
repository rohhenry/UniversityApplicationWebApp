
<?php
//include 'C:\xampp\htdocs\UniversityApplicationWebApp\src\UAconnect.php';
include "..\config.php";
//$conn = OpenCon();

function insertOptions(){
    global $mysqli;

    $sql = "SELECT university.name FROM university";
    $stmt = $mysqli->prepare($sql);
    $stmt->execute();
    $stmt->bind_result( $name);
    while($stmt->fetch()){
        echo "<option value='$name'>  $name </option>";
    }

}

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
 INSERT INTO recruiter (id, name, university_name, contact_info_email, login_username) VALUES ('$d','$c', '$i','$e', '$a');";


$result = $mysqli->multi_query($sql);


if ($result) {
    echo "New recruiter record created successfully";
    header("Location: ../Logout.php");
} else {
    echo "Error: " . $sql . "<br>" . $mysqli->error;
}

