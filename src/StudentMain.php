<?php
    
    require_once "check_session.php";
    validateSession("student");
    
    require_once "config.php";
    
    $username = $_SESSION["username"];

    function displayCount(){
        global $mysqli, $username;
        $sql = "SELECT count(*)
                FROM application, student 
                WHERE application.student_id = student.id
                AND student.login_username = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("s", $username);   
        $stmt->execute();
        $stmt->bind_result($count);
        while($stmt->fetch()){
            echo "<b> $count </b><br>";
        }   
    }
function displayCountGroupBy(){
    global $mysqli, $username;
    $sql = "SELECT university_name, count(*)
                FROM application, student 
                WHERE application.student_id = student.id
                AND student.login_username = ?
                group by university_name";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($uname,$count);
    while($stmt->fetch()){
        echo "<b>$uname, $count </b><br>";
    }
}



        
    function displayApplications($offer, $accepted){
        global $mysqli, $username;
        $sql = "SELECT university_name, faculty_name 
                FROM application, student 
                WHERE application.student_id = student.id
                AND application.offer = ? 
                AND application.accepted = ?
                AND student.login_username = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("sss",$offer,$accepted, $username);   
        $stmt->execute();
        $stmt->bind_result($university_name, $faculty_name);
        while($stmt->fetch()){
            echo "<b> $university_name $faculty_name</b><br>";
        }   
    }

    function displayOffers(){
        global $mysqli, $username;
        $sql = "SELECT university_name, faculty_name, application.id
                FROM application, student 
                WHERE application.student_id = student.id
                AND application.offer = 'accepted'
                AND application.accepted = 'pending'
                AND student.login_username = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("s", $username);   
        $stmt->execute();
        $stmt->bind_result($university_name, $faculty_name, $id);
        echo '<form method="post">';
        while($stmt->fetch()){
            echo "<b> $university_name $faculty_name</b> 
            <button type=\"submit\" value=$id name=\"Accept\" >Accept</button>
            <button type=\"submit\" value=$id name=\"Reject\" >Reject</button>
            <br>";
        }   
        echo '</form>';
    }

    function updateAccepted($id, $option){
        global $mysqli, $username;
        $sql = "UPDATE application SET accepted = ? WHERE id = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("ss", $option, $id);   
        $stmt->execute();
    }
    
    if(isset($_POST['Accept'])){
        $id = $_POST['Accept'];
        updateAccepted($id, 'accepted');

    }else if(isset($_POST['Reject'])){
        $id = $_POST['Reject'];
        updateAccepted($id, 'rejected');
    }

    $join = "SELECT student.id, student.name, student.contact_info_email, student.login_username
    FROM student, login WHERE login.username = student.login_username AND login.username = '$username'";

    $result = $mysqli->query($join) -> fetch_assoc();


    $status = $mysqli->prepare("SELECT highschoolstudent.agency_name, highschoolstudent.school 
                from student, highschoolstudent 
                where student.login_username = ?
                AND student.id = highschoolstudent.student_id");
    $status->bind_param("s", $username);
    $status->execute();
    $status->store_result();
//    $status->bind_result($agency,$school);

    if($status->num_rows > 0){
        $status->bind_result($agency,$school);
        $status->fetch();

    }else{
        $transfer = $mysqli->prepare("SELECT university_name
                from student, transferstudent 
                where student.login_username = ?
                AND student.id = transferstudent.student_id");
        $transfer->bind_param("s", $username);
        $transfer->execute();
        $transfer->store_result();
        $transfer->bind_result($school);    
        $transfer->fetch();
        $agency = 'not applicable';
    }

   
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
        background-image: url('3.jpg');
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: cover;
    }

    .form {
        width:400px;
        float: left;
        background-color:ivory;
        font-family:'Droid Serif',serif;
        padding-left:40px
    }
</style>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Student</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="StudentMain.php">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href='Courses.php'>Add/Edit Courses</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href='ApplyToUniversity.php'>Apply To University</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" class="nav-link disabled" href="settingStudent.php">Setting</a>
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

<body>

<div class="form">
    <h2>  </h2>
    <h2>---Student Info---</h2>
    <span>Student Name:</span> <?php echo $result['name']; ?>
    <br>
    <br>
    <span>E-mail:</span> <?php echo $result['contact_info_email']; ?>
    <br>
    <br>
    <span>Student ID:</span> <?php echo $result['id']; ?>
    <br>
    <br>
    <span>Student username:</span> <?php echo $result['login_username']; ?>
    <br>
    <br>
    <span>Student School:</span> <?php echo $school; ?>
    <br>
    <br>
    <span>Agency ID:</span> <?php echo $agency; ?>
    <br>
    <br>
    Total number of Applications Sent:
    <?php displayCount()?>
    <br>
    <br>
    Number of Applications Sent per University:
    <br>
    <?php displayCountGroupBy();?>
    <br>
    <br>
    Pending Applications:
    <br>
    <?php displayApplications("pending", "pending")?>
    <br>
    <br>
    <br>
    Offers: 
    <br>
    <?php displayOffers("accepted", "pending")?>
    <br>
    <br>
    <br>
    No Offers:
    <br>
    <?php displayApplications("rejected", "pending")?>
    <br>
    <br>
    <br>
    Accepted Offers:
    <br>
    <?php displayApplications("accepted", "accepted")?>
    <br>
    <br>
    <br>
    Rejected Offers:
    <br>
    <?php displayApplications("accepted", "rejected")?>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
        
</div>

</body>

</html>