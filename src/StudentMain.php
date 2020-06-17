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

<br>
<style>
    ul {
        list-style-type: none;
        margin: 0;
        padding: 5px;
        overflow: hidden;
        background-color: lightskyblue;
    }

    li {
        float: left;
    }

    li a {
        display: block;
        color: white;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
    }

    li a:hover {
        background-color: darkgray;
    }
    body {
        background-image: url('device_cleaning_hero_6.jpg');
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

<h1>
    Welcome to the student main page!
</h1>
<ul>
    <li><a href='logout.php'>Logout</a></li>
    <li><a href='Courses.php'>Add/Remove Courses</a></li>
    <li><a href='ApplyToUniversity.php'>Apply To University</a></li>
</ul>

<div class="form">
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


</html>