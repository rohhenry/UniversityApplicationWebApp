<?php

require_once "check_session.php";
validateSession("student");
require_once "config.php";
$username = $_SESSION["username"];

$join = "SELECT student.id, student.name, student.contact_info_email, student.login_username
    FROM student, login WHERE login.username = student.login_username AND login.username = '$username'";

$result = $mysqli->query($join) -> fetch_assoc();

$student_id = $result['id'];


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
    STATIC $application_id = 1000;
    $application_id++;
    return $application_id;
}

function applyUniversity() {
    global $mysqli, $username, $student_id;


    $apply = $_POST['university'];
    $aid = "A";
    $aid .= getAppId();
    $text = '';
    $offer = 'pending';
    $accepted = 'pending';
    $name_explode = explode('|', $apply);
    $university_name = $name_explode[0];
    $faculty_name = $name_explode[1];

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

function insertOptions(){
    global $mysqli, $username;

    $sql = "SELECT f.name, f.university_name 
                FROM faculty f order by f.university_name" ;
    $stmt = $mysqli->prepare($sql);
    $stmt->execute();
    $stmt->bind_result($faculty, $university);
    while($stmt->fetch()){
        echo "<option value=$university|$faculty> $university: $faculty </option>";
    }

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
<a href='StudentMain.php'>Student Main</a>
<br>
Applied Universities:
<?php getUniversityNotApplied();?>
<br>
<form method="post">
    <select name="university">
        <option selected hidden>Select Option</option>
        <?php insertOptions()?>

    </select>

    <input type="submit" value="apply" name = "apply">
</form>
</html>
