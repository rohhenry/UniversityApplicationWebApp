<!DOCTYPE html>
<html>
<h1>Courses: </h1>
<br>
<h2>Name, Mark</h2>
<?php
    require_once "check_session.php";
    validateSession("student");

    require_once "config.php";

    $username = $_SESSION['username'];

    $sql = "SELECT Course.name, Taken.mark 
            FROM Course, Taken, Student
            WHERE Course.number = Taken.course_number 
            AND Course.department = Taken.course_department
            AND Taken.student_id = Student.id 
            AND Student.login_username = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($course_name, $mark);
    while($stmt->fetch()){
        echo "<b> $course_name, $mark </b>";
    }
?>
<form method="post">
    Mark
    <input type="text">
    <input type="submit" value="Add Course">
</form>
</html>

