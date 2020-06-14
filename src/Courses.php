<?php
    require_once "check_session.php";
    validateSession("student");

    require_once "config.php";

    $username = $_SESSION['username'];


    function displayCoursesTaken(){
        global $mysqli, $username; 
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
            echo "<b> $course_name, $mark </b><br>";
        }
    }

    function addCourseTaken(){
        
        global $mysqli, $username; 

        $mark = $_POST['mark'];
        $year = $_POST['year'];
        $course_number = $_POST['number'];
        $course_department = $_POST['department'];

        
        $sql = "INSERT INTO Taken 
                SELECT ?, ?, Student.id, ?, ?
                FROM Student
                WHERE Student.login_username = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("sssss", $mark, $year, $course_number, $course_department, $username);
        if($stmt->execute()){
            echo 'success';
        }else{
            echo 'failure';
        }
    }

    if(isset($_POST['submit'])){
        addCourseTaken();
    }
?>

<!DOCTYPE html>
<html>
<h1>Courses: </h1>
<br>
<h2>Name, Mark</h2>
<?php displayCoursesTaken() 
?>
<form method="post">
    Number
    <input type="text" name="number">
    Department
    <input type="text" name="department">
    Name
    <input type="text" name="name">
    Year
    <input type="text" name="year">
    Mark
    <input type="text" name="mark">
    <input type="submit" value="Add Course" name = "submit">
</form>
</html>