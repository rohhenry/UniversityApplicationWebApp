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
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Apply University</title>
    <link rel="stylesheet" href="css/applyUni.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/ReviewApplication.css">
</head>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Recruiter</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="RecruiterMain.php">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" class="nav-link disabled" href="settingRec.php">Setting</a>
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
<div class="container">
<div class="center">
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
</div>
</div>
</body>
</html>