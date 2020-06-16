<?php

require_once "check_session.php";
validateSession("student");
require_once "config.php";
$username = $_SESSION["username"];


function getUniversityNotApplied()
{
    global $mysqli, $username;
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
}

function getAppId(){
    STATIC $application_id = 2000;
    $application_id++;
    $aa = "A";
    return ($aa.$application_id);
}

function displayTable(){
    global $mysqli, $username;

    $sql = "SELECT f.name, f.university_name, f.application_instructions 
                FROM faculty f order by f.university_name" ;
    $stmt = $mysqli->prepare($sql);
    $stmt->execute();
    $stmt->bind_result($faculty, $university, $instruction);
    while($stmt->fetch()){
        echo "<tr>";
        echo "<td>  $university </td> <td> $faculty </td> <td> $instruction</td>" ;
        echo "</tr>";
    }
}


function applyUniversity() {
    global $mysqli, $username, $university_name;



    $aid = "A";
    $aid .=  getAppId();
    $text = $_POST['text'];
    $offer = 'pending';
    $accepted = 'pending';
    $university_name = $_POST['university'];
    $faculty_name = $_POST['faculty'];


    $sql = "INSERT INTO APPLICATION 
                SELECT ?, ?, ?, ?, ?, ? ,Student.id
                FROM Student
                WHERE Student.login_username = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("sssssss", $aid, $text, $offer, $accepted, $university_name, $faculty_name, $username);
    if($stmt->execute()){
        echo 'success';
    }else{

        echo 'failure';
    }
}

if(isset($_POST['apply'])){
    applyUniversity();
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
<body>

<a href='logout.php'>Logout</a>
<br>
<a href='Courses.php'>Add/Edit Courses</a>
<br>
<a href='applyToUniversity.php'>Apply To University</a>
<br>
<br>
<div class = apply_box>
<form method="post">
    <div class="form-group">
        <label for="university">University</label>
        <input name="university" type="university" class="form-control" id="university" placeholder="university">
    </div>
    <div class="form-group">
        <label for="faculty">Faculty</label>
        <input name= "faculty" type="faculty" class="form-control" id="faculty" placeholder="faculty">
    </div>
    <div class="form-group">
        <label for="text">Answer for Faculty Specific Questions</label>
        <textarea name= "text" class="form-control" type="text" id="text" rows="3"></textarea>
    </div>
    <input class="btn btn-info" type="submit" value="apply" name="apply">
</form>
</div>



        <div class = "uniTable">
            <table class="table table-bordered">
            <thead>
            <tr>
                <th class="th-sm">University

                </th>
                <th class="th-sm">Faculty

                </th>
                <th class="th-sm">Instruction

                </th>
            </tr>
            </thead>
            <tbody>
            <?php displayTable();?>
            </tbody>
            </table>
        </div>
<br>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>
