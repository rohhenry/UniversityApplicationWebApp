<?php
//include '..\UAconnect.php';
include "..\config.php";

function insertOptions(){
    global $mysqli;

    $sql = "SELECT agency.name FROM agency";
    $stmt = $mysqli->prepare($sql);
    $stmt->execute();
    $stmt->bind_result( $aname);
    while($stmt->fetch()){
        echo "<option value='$aname'>  $aname </option>";
    }
}

function addHighSchoolStudent(){
    global $mysqli;
    $a = $_POST['username'];
    $b = $_POST['password'];
    $c = $_POST['student_name'];
    $d = $_POST['student_id'];
    $e = $_POST['email'];
    $f = $_POST['phone_number'];
    $k = $_POST['address'];
    $h = $_POST['postal_code'];
    $i = $_POST['student_school'];
    $j = $_POST['agency_id'];

    $sql = " INSERT INTO login (username, password) VALUES ('$a','$b'); 
 INSERT INTO local_address (contact_info_address, postal_code) VALUES ('$k','$h');
 INSERT INTO Contact_info (phone_number,address, email) VALUES ('$f','$k', '$e');
 INSERT INTO student (id, name, contact_info_email, login_username) VALUES ('$d','$c', '$e', '$a');
 INSERT INTO highschoolstudent (school, student_id, agency_name) VALUES ('$i','$d', '$j');
";

    $result = $mysqli->multi_query($sql);


    if ($result) {
        echo "New student record created successfully";
        header("Location: ../Logout.php");
    } else {
        echo "Error: " . $sql . "<br>" . $mysqli->error;
    }
}

if(isset($_POST['submit'])){
    addHighSchoolStudent();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="registerStudent.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
</head>
<body>
<style>
    body {
        background-image: url('Abstract-Ambient-Light-Background-Day-Blue.jpg');
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: cover;
    }

</style>

<h1>
    High School Student registration page <span style="color:var(--pink)"></span>
</h1>

<h2>
    Welcome to the site! This site is designated for student registration
</h2>

<div class = "register_box">
    <form action="registerStudentHighSchool.php" method="post">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="username">User Name</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="">
            </div>
            <div class="form-group col-md-6">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="">
            </div>
        </div>
        <div class="form-group">
            <label for="student_name">Name</label>
            <input type="text" class="form-control" id="student_name" name="student_name" placeholder="">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" class="form-control" id="email" name="email" placeholder="">
        </div>
        <div class="form-group">
            <label for="phone_number">Phone Number</label>
            <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="">
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="address">Address</label>
                <input type="text" class="form-control" name="address" id="address">
            </div>
            <div class="form-group col-md-6">
                <label for="postal_code">Postal Code</label>
                <input type="text" class="form-control" name="postal_code" id="postal_code">
            </div>
        </div>
        <div class="form-group">
            <label for="student_id">Student ID</label>
            <input type="text" class="form-control" id="student_id" name="student_id" placeholder="">
        </div>
        <div class="form-group">
            <label for="student_school">High School you are in</label>
            <input type="text" class="form-control" id="student_school" name="student_school" placeholder="">
        </div>
        <div class="form-group">
            <label for="Agency_id">agency id</label>
            <select class="form-control form-control" name="agency_id">
                <option selected hidden>Select agency you have </option>
                <?php insertOptions()?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Sign in</button>
    </form>
</div>


</body>
</html>
