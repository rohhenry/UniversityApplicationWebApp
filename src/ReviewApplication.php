<?php
    require_once "check_session.php";
    validateSession("recruiter");

    require_once "config.php";

    $username = $_SESSION['username'];

    if(isset($_POST['Review'])){
        $id = $_POST['Review'];
    }

    function displayCoursesTaken(){
        global $mysqli;
        $sql = "SELECT Course.department, Course.number, Course.name, Taken.mark 
                FROM Course, Taken, Student, Application
                WHERE Course.number = Taken.course_number 
                AND Course.department = Taken.course_department
                AND Taken.student_id = Student.id 
                AND Application.student_id = Student.id
                AND Application.id = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $stmt->bind_result($course_department, $course_number, $course_name, $mark);
        while($stmt->fetch()){
            echo "<b> $course_department, $course_number, $course_name, $mark </b><br>";
        }
    }

    function displayApplication() {
        global $mysqli,  $id;
        
        $sql = "SELECT Application.text
                FROM Application
                WHERE Application.id = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $stmt->bind_result($text);
        while($stmt->fetch()){
            echo "<b> $text</b><br>";
        }
    }
?>

<!DOCTYPE HTML>
<html>  
<?php displayCoursesTaken()?>
<?php displayApplication()?>
</html>