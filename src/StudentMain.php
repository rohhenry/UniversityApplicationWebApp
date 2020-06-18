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
        echo "<tr>";
        echo "<td>  $uname </td> <td> $count </td>" ;
        echo "</tr>";
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
        padding:10px;
        height: 100%;
        background-color:ivory;
        border-radius: 10px;
        border: 2px solid #040004;
        text-align: center;

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
<br>
<br>
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="form">
            <h2>Student Information</h2>
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
            </div>
        </div>
        <div class="col-md-4">
            <div class = "form">
                <h4>Pending Applications</h4>
                <br>
                <?php displayApplications("pending", "pending")?>
                <br>
                <h4>Offers:</h4>
                <br>
                <?php displayOffers("accepted", "pending")?>

                <h4>No Offers</h4>
                <br>
                <?php displayApplications("rejected", "pending")?>

                <h4>Accepted Offers:</h4>
                <br>
                <?php displayApplications("accepted", "accepted")?>

                <h4>Rejected Offers:</h4>
                <br>
                <?php displayApplications("accepted", "rejected")?>
                <br>
                <br>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form">
                <br>
                Total number of Applications Sent:
                <?php displayCount()?>
                <br>
                <br>
                <h5>Number of Applications Sent per University</h5>
                <br>
                <table class="table table-bordered table-dark">
                    <thead>
                    <tr>
                        <th class="th-sm">University

                        </th>
                        <th class="th-sm">Numbers

                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php displayCountGroupBy();?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


</body>


<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</html>