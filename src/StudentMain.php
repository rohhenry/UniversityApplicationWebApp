

<?php
    
    require_once "check_session.php";
    validateSession("student");
    
    require_once "config.php";
    
    $username = $_SESSION["username"];
    $stmt = $mysqli->prepare("SELECT university_name, accepted FROM application, student WHERE application.student_id = student.id AND student.login_username = ?");
    $stmt->bind_param("s", $username);   
    $stmt->execute();
    $stmt->store_result();


    #elisa update


    $join = "SELECT student.id, student.name, student.contact_info_email, student.login_username
    FROM student, login WHERE login.username = student.login_username AND login.username = '$username'";

    $result = $mysqli->query($join) -> fetch_assoc();

   
?>

<!DOCTYPE HTML>
<html>

<!--<a href='logout.php'>Logout</a>-->
<!--<br>-->
<!--<a href='Courses.php'>Add/Edit Courses</a>-->
<!--<br>-->
<!--<a href='ApplyToUniversity.php'>Apply To University</a>-->
<!--<br>-->

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
        float:left;
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
    <li><a href='Courses.php'>Add/Edit Courses</a></li>
    <li><a href='ApplyToUniversity.php'>Apply To University</a></li>
    <li><a href='ModifyOffer.php'>Manage the Offer</a></li>
</ul>

<div class="form">
    <h2>---Student Info---</h2>
    <span>Student Name:</span> <?php echo $result['name']; ?>
    <br>
    <span>E-mail:</span> <?php echo $result['contact_info_email']; ?>
    <br>
    <span>Student ID:</span> <?php echo $result['id']; ?>
    <br>
    <span>Student username:</span> <?php echo $result['login_username']; ?>
    <br>
    <span>University have applied:</span> <?php
    $stmt->bind_result($university_name, $accepted);
    while($stmt->fetch()){
        echo "<b>". $university_name. " ".  $accepted . "</b>";
    }
    ?>
    <br>
    <br>
</div>


</html>