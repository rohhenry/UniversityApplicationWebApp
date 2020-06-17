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



    $text = $_POST['text'];
    $offer = 'pending';
    $accepted = 'pending';
    $university_name = $_POST['university'];
    $faculty_name = $_POST['faculty'];
    $aid = getAppId();
    $check_sql = "SELECT faculty_name, university_name
                FROM application a , student s
                WHERE a.student_id = s.id AND s.login_username = ? AND a.faculty_name = ? AND a.university_name = ? ;";
    $stmt = $mysqli->prepare($check_sql);
    $stmt->bind_param("sss",$username,$faculty_name,$university_name);
   $stmt->execute();
    $stmt->store_result();
    echo $stmt->num_rows;
    if($stmt->num_rows > 0){
        echo 'you already applied';
        return;
    }


    $sql = "INSERT INTO APPLICATION 
                SELECT  ?,?, ?, ?, ?, ? ,Student.id
                FROM Student
                WHERE Student.login_username = ?";
    if( $stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("sssssss",$aid, $text, $offer, $accepted, $university_name, $faculty_name, $username);
        if ($stmt->execute()) {
            echo 'application successfully submitted';
        } else {

            echo 'failure';
        }
    } else {
        echo 'error';
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

<style>
    ul {
        list-style-type: none;
        margin: 0;
        padding: 5px;
        overflow: hidden;
        background-color: lightskyblue;
    }

    li {
        float: left;
    }

    li a {
        display: block;
        color: white;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
    }

    li a:hover {
        background-color: darkgray;
    }
    body {
        background-image: url('book_750xx2290-1290-0-235.jpg');
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: cover;
    }


</style>

<body>

<ul>
    <li><a href='logout.php'>Logout</a></li>
    <li><a href='Courses.php'>Add/Edit Courses</a></li>
    <li><a href='ApplyToUniversity.php'>Apply To University</a></li>
    <li><a href='StudentMain.php'>Student Main</a><li>
</ul>


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

<br>
<br>
List of University
<br>
<br>
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