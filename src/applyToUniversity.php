<?php

require_once "check_session.php";
validateSession("student");
require_once "config.php";

$username = $_SESSION["username"];
//$join = "SELECT university.name FROM university WHERE univeristy.name NOT IN (SELECT university_name FROM application, student WHERE application.student_id = student.id AND student.login_username = '$username')";
$stmt = $mysqli->prepare("SELECT Faculty.university_name, Faculty.name FROM Faculty WHERE (Faculty.university_name, Faculty.name) NOT IN (SELECT Application.university_name, Application.faculty_name FROM application, student WHERE application.student_id = student.id AND student.login_username=?)");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($university_name, $faculty_name);
//$result = $mysqli->query($join)->fetch_assoc();
//echo($result[name]);
while($stmt->fetch()){
    echo "<b> $university_name, $faculty_name</b><br>";
}


?>

<!DOCTYPE HTML>
<html>
<a href='logout.php'>Logout</a>
<br>
<a href='Courses.php'>Add/Edit Courses</a>
<br>
<a href='applyToUniversity.php'>Apply To University</a>
<br>
Applied Universities:
<br>
</html>
