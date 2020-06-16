
<?php
//include 'C:\xampp\htdocs\UniversityApplicationWebApp\src\UAconnect.php';
include "..\config.php";
//$conn = OpenCon();

function insertOptions(){
    global $mysqli;

    $sql = "SELECT university.name FROM university";
    $stmt = $mysqli->prepare($sql);
    $stmt->execute();
    $stmt->bind_result( $uniname);
    while($stmt->fetch()){
        echo "<option value='$uniname'>  $uniname </option>";
    }

}
function addRecruiter()
{
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

}
if(isset($_POST['submit'])){
    addRecruiter();
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
        background-image: url('images.jpg');
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: cover;
    }

</style>

<h1>Recruiter  registration  page <span style="color:var(--pink)"></span>
</h1>

<h2>Welcome to the site! This site is designated to recruiter register for the account <span style="color:var(--pink)"></span>
</h2>
<div class = "register_box">
    <form action="registerRecruiter.php" method="post">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="username">User Name</label>
                <input type="username" class="form-control" name="username" id="username" placeholder="">
            </div>
            <div class="form-group col-md-6">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="">
            </div>
        </div>
        <div class="form-group">
            <label for="recruiter_name">Name</label>
            <input type="text" class="form-control" name="recruiter_name" id="recruiter_name" placeholder="">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" class="form-control" name="email" id="email" placeholder="">
        </div>
        <div class="form-group">
            <label for="phone_number">Phone Number</label>
            <input type="text" class="form-control" name="phone_number" id="phone_number" placeholder="">
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="address">Address</label>
                <input type="text" class="form-control" name="address"  id="address">
            </div>
            <div class="form-group col-md-6">
                <label for="postal_code">Postal Code</label>
                <input type="text" class="form-control" name="postal_code" id="postal_code">
            </div>
        </div>
        <div class="form-group">
            <label for="recruiter_id">Recruiter ID</label>
            <input type="text" class="form-control" name="recruiter_id" id="recruiter_id" placeholder="">
        </div>
        <div class="form-group">
            <select class="form-control form-control">
                <option selected hidden>Select University you affiliated to </option>
                <?php insertOptions()?>
            </select>
            <!--        <label for="university_name">University Name</label>-->
            <!--        <input type="text" class="form-control" name="university_name" id="university_name" placeholder="">-->
        </div>

        <button type="submit" class="btn btn-primary" name ="submit">Sign in</button>
    </form>
</div>

</body>
</html>



