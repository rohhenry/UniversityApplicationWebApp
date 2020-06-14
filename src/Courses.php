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
        #$stmt->store_result();
        $stmt->bind_result($course_name, $mark);
        while($stmt->fetch()){
            echo "<b> $course_name, $mark </b><br>";
        }
    }

    function addCourseTaken(){
        global $mysqli, $username; 

        $mark = $_POST['mark'];
        $year = $_POST['year'];

        $course = $_POST['course'];
        $course_explode = explode('|', $course);
        $course_number = $course_explode[0];
        $course_department = $course_explode[1];

        
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

    if(isset($_POST['addCourse'])){
        addCourseTaken();
    }

    function insertOptions(){
        global $mysqli, $username;

        $sql = "SELECT Course.number, Course.department, Course.name 
                FROM Course";
        $stmt = $mysqli->prepare($sql);
        $stmt->execute();
        $stmt->bind_result($number, $department, $name);
        while($stmt->fetch()){
            echo "<option value='$number|$department'> $department $number: $name </option>";
        }

    }
?>

<!DOCTYPE html>
<html>
<h1>Courses: </h1>
<br>
<h2>Name, Mark</h2>
<?php displayCoursesTaken()?>
<form method="post">
    <select name="course">
    <?php insertOptions()?>
    </select>
    <!-- Number
    <input type="text" name="number">
    Department
    <input type="text" name="department">
    Name
    <input type="text" name="name"> -->
    Year Taken
    <input type="text" name="year">
    Mark
    <input type="text" name="mark">
    <input type="submit" value="Add Course" name = "addCourse">
</form>
</html>