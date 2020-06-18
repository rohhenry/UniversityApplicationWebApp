
<?php

require_once "check_session.php";
validateSession("recruiter");

require_once "config.php";

$username = $_SESSION["username"];

function displayApplications($offer, $accepted){
    global $mysqli, $username;
    $sql = "SELECT application.university_name, faculty_name, student_id
                FROM application, recruiter
                WHERE recruiter.login_username = ?
                AND application.university_name = recruiter.university_name
                AND application.offer = ? 
                AND application.accepted = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("sss",$username, $offer,$accepted);
    $stmt->execute();
    $stmt->bind_result($university_name, $faculty_name, $student_id);
    while($stmt->fetch()){
        echo "<b> $university_name $faculty_name $student_id</b><br>";
    }
}

function division_course(){
    global $mysqli, $username;

    $sql = "SELECT c.department , c.number
                FROM course c
                WHERE not exists (
                select * from student where not exists (
                select * from application, recruiter, taken where
                application.university_name = recruiter.university_name
                AND recruiter.login_username = ?
                AND taken.student_id = application.student_id
                AND taken.course_number = c.number
                AND taken.course_department = c.department))";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s",$username);
    $stmt->execute();
    $stmt->bind_result($dept, $num);
    while($stmt->fetch()){
        echo "<b> $dept $num</b><br>";
    }
}

function displayApplicationsToReview(){
    global $mysqli, $username;
    $sql = "SELECT application.university_name, application.faculty_name, application.id
            FROM application, recruiter
            WHERE recruiter.login_username = ?
            AND application.university_name = recruiter.university_name
            AND application.offer = 'pending'
            AND application.accepted = 'pending'";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s",$username);
    $stmt->execute();
    $stmt->bind_result($university_name, $faculty_name, $id);
    echo '<form method="post" action="ReviewApplication.php">';
    while($stmt->fetch()){
        echo "<b> $university_name $faculty_name</b> 
              <button name=\"Review\" type=\"submit\" value=\"$id\">Review</button><br>";
    }
    echo '</form>';
}


$join = "SELECT recruiter.id, recruiter.name, recruiter.university_name,recruiter.contact_info_email, recruiter.login_username
    FROM recruiter WHERE  recruiter.login_username = '$username'";

$result = $mysqli->query($join) -> fetch_assoc();


?>

<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Apply University</title>
    <link rel="stylesheet" href="css/applyUni.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>

<style>

    body {
        background-image: url('DataScientist.jpg');
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: cover;
    }

    .form {
        width:400px;
        float:left;
        background-color:ivory;
        font-family:'Droid Serif',serif;
        padding-left:40px
    }
</style>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Recruiter</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="RecruiterMain.php">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" class="nav-link disabled" href="settingRec.php">Setting</a>
            </li>

        </ul>
        <div class="navbar-collapse collapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>

    </div>
</nav>

<div class="form">
    <h2>---Recruiter Info---</h2>
    <span>Recruiter Name:</span> <?php echo $result['name']; ?>
    <br>
    <br>
    <span>Affiliated University:</span> <?php echo $result['university_name']; ?>
    <br>
    <br>
    <span>E-mail:</span> <?php echo $result['contact_info_email']; ?>
    <br>
    <br>
    <span>Recruiter ID:</span> <?php echo $result['id']; ?>
    <br>
    <br>
    <span>Recruiter username:</span> <?php echo $result['login_username']; ?>
    <br>
    <br>
    Applications To Review:
    <br>
    <br>
    <?php displayApplicationsToReview()?>
    <br>
    <br>
    <br>
    Offers Given:
    <br>
    <br>
    <?php displayApplications("accepted", "pending")?>
    <br>
    <br>
    <br>
    Rejected Applications:
    <br>
    <br>
    <?php displayApplications("rejected", "pending")?>
    <br>
    <br>
    <br>
    Accepted Offers:
    <br>
    <br>
    <?php displayApplications("accepted", "accepted")?>
    <br>
    <br>
    <br>
    Rejected Offers:
    <br>
    <br>
    <?php displayApplications("accepted", "rejected")?>
    <br>
    <br>
    The course taken by all the student who applied to the university:
    <?php division_course()?>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>

</div>


</html>