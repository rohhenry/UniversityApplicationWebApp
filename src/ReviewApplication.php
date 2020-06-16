<?php
    require_once "check_session.php";
    validateSession("recruiter");

    require_once "config.php";

    $username = $_SESSION['username'];

    if(isset($_POST['Review'])){
        $id = $_POST['Review'];
    }else{
        header("location: recruitermain.php");
    }

    if(isset($_POST['Accept'])){
        updateOffer('accepted');
    }else if(isset($_POST['Reject'])){
        updateOffer('rejected');
    }

    function displayStudentInfo(){
        global $mysqli, $id;
        $sql = "SELECT student.name, student.contact_info_email
                FROM student, application
                WHERE application.student_id = student.id
                AND application.id = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $stmt->bind_result($name, $email);
        while($stmt->fetch()){
            echo "<b> $name, $email </b><br>";
        }
    }

    function displayCoursesTaken(){
        global $mysqli, $id;
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
        
        $sql = "SELECT Faculty.Application_Instructions, Application.text
                FROM Application, Faculty
                WHERE Application.faculty_name = Faculty.name 
                AND Application.university_name = Faculty.university_name 
                AND Application.id = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $stmt->bind_result($instructions, $ans);
        while($stmt->fetch()){
            echo "Application Instructions: <br>$instructions<br>";
            echo "Answer: <br> <b> $ans</b><br>";
        }
    }

    function updateOffer($option){
        global $mysqli, $id;
        $sql = "UPDATE application SET offer = ? WHERE id = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("ss", $option, $id);   
        $stmt->execute();
        header("location: recruitermain.php");
    }


?>

<!doctype html>
<html>
Student Info: <br>
<?php displayStudentInfo()?>
Courses Taken: <br>
<?php displayCoursesTaken()?>
<?php displayApplication()?>
<form method="post">
<?php echo "<input type=\"hidden\" name=\"Review\" value=\"$id\">" ?>
<button type="submit" name="Accept" >Accept</button>
<button type="submit" name="Reject" >Reject</button>
</form>
</html>