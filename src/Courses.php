<?php
    require_once "check_session.php";
    validateSession("student");

    require_once "config.php";

    $username = $_SESSION['username'];


    function displayCoursesTaken(){
        global $mysqli, $username; 
        $sql = "SELECT Course.department, Course.number, Course.name, Taken.mark 
                FROM Course, Taken, Student
                WHERE Course.number = Taken.course_number 
                AND Course.department = Taken.course_department
                AND Taken.student_id = Student.id 
                AND Student.login_username = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        #$stmt->store_result();
        echo '<form method="post">';
        $stmt->bind_result($course_department, $course_number, $course_name, $mark);
        while($stmt->fetch()){
            echo "<b> $course_department, $course_number, $course_name, $mark </b>
            <button name=\"DeleteCourse\" type=\"submit\" value=\"$course_number|$course_department\">X</button><br><br>";
        }
        echo '</form>';
    }

    function deleteCourse(){
        global $mysqli, $username; 
        $course = $_POST['DeleteCourse'];
        $course_explode = explode('|', $course);
        $course_number = $course_explode[0];
        $course_department = $course_explode[1];

        
        $sql = "DELETE FROM Taken
                WHERE Taken.course_number = ?
                AND Taken.course_department = ?
                AND Taken.student_id = (Select id from student where Student.login_username = ?)";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("sss", $course_number, $course_department, $username);
        $stmt->execute();
    }

    function addCourse(){
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
        addCourse();
    }

    if(isset($_POST['DeleteCourse'])){
        deleteCourse();
    }

    function insertOptions(){
        global $mysqli, $username;
        $sql = "SELECT Course.number, Course.department, Course.name 
                FROM Course
                WHERE (Course.number, Course.department) NOT IN 
                (SELECT Course.number, Course.department
                FROM Course, Taken, Student
                WHERE Course.number = Taken.course_number 
                AND Course.department = Taken.course_department
                AND Taken.student_id = Student.id 
                AND Student.login_username = ?)";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($number, $department, $name);
        while($stmt->fetch()){
            echo "<option value='$number|$department'> $department $number: $name </option>";
        }
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
        background-image: url('book_750xx2290-1290-0-235.jpg');
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: cover;
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
<?php displayCoursesTaken()?>
<br>
<br>
<form method="post">
    <select name="course">
    <option selected hidden>Select Course</option>
    <?php insertOptions()?>

    </select>

    Year Taken
    <input type="text" name="year">
    Mark
    <input type="text" name="mark">
    <input type="submit" value="Add Course" name = "addCourse">
</form>
</body>
</html>