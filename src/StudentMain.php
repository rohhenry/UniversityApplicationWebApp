<!DOCTYPE HTML>
<html>
<a href='logout.php'>Logout</a>
<br>
<a href='Courses.php'>Add/Edit Courses</a>
<br>
<a href='ApplyToUniversity.php'>Apply To University</a>
<br>
Applied Universities:
<br>
</html>

<?php 
    session_start();
    
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        if(isset($_SESSION["type"]) && $_SESSION["type"] == "student"){
            #header("location: StudentMain.php");
        } else {
            header("location: RecruiterMain.php");
        }
    }
    
    require_once "config.php";
    
    $username = $_SESSION["username"];
    $stmt = $mysqli->prepare("SELECT university_name, accepted FROM application, student WHERE application.student_id = student.id AND student.login_username = ?");
    $stmt->bind_param("s", $username);   
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($university_name, $accepted);
    while($stmt->fetch()){
        echo "<b>". $university_name. " ".  $accepted . "</b>";
    }
   
?>  