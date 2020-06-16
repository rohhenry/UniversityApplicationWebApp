
<?php

require_once "check_session.php";
validateSession("recruiter");

require_once "config.php";

$username = $_SESSION["username"];

function displayApplications($offer, $accepted){
    global $mysqli, $username;
    $sql = "SELECT application.university_name, faculty_name, student_id
                FROM application, review, recruiter
                WHERE recruiter.login_username = 'a'
                AND recruiter.id = review.recruiter_id
                AND application.id = review.Application_id
                AND application.offer = ? 
                AND application.accepted = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ss",$offer,$accepted);
    $stmt->execute();
    $stmt->bind_result($university_name, $faculty_name, $student_id);
    while($stmt->fetch()){
        echo "<b> $university_name $faculty_name $student_id</b><br>";
    }
}

function displayOffers(){
    global $mysqli, $username;
    $sql = "SELECT application.university_name, faculty_name, student_id
                FROM application, review, recruiter
                WHERE recruiter.login_username = 'a'
                AND recruiter.id = review.recruiter_id
                AND application.id = review.Application_id
                AND application.offer = ? 
                AND application.accepted = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ss",$offer,$accepted);
    $stmt->execute();
    $stmt->bind_result($university_name, $faculty_name, $id);
    echo '<form method="post">';
    while($stmt->fetch()){
        echo "<b> $university_name $faculty_name</b> 
            <button type=\"submit\" value=$id name=\"Accept\" >Accept</button>
            <button type=\"submit\" value=$id name=\"Reject\" >Reject</button>
            <br>";
    }
    echo '</form>';
}

function updateAccepted($id, $option){
    global $mysqli, $username;
    $sql = "UPDATE application SET accepted = ? WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ss", $option, $id);
    $stmt->execute();
}

if(isset($_POST['Accept'])){
    $id = $_POST['Accept'];
    updateAccepted($id, 'accepted');

}else if(isset($_POST['Reject'])){
    $id = $_POST['Reject'];
    updateAccepted($id, 'rejected');
}


$join = "SELECT recruiter.id, recruiter.name, recruiter.university_name,recruiter.contact_info_email, recruiter.login_username
    FROM recruiter WHERE  recruiter.login_username = '$username'";

$result = $mysqli->query($join) -> fetch_assoc();


?>

<!DOCTYPE HTML>
<html>


<br>
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
        background-image: url('DataScientist.jpg');
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: cover;
    }

    .form {
        width:400px;
        float:left;
        background-color:ivory;
        font-family:'Droid Serif',serif;
        padding-left:40px
    }
</style>

<h1>
    Welcome to the recruiter main page!
</h1>
<ul>
    <li><a href='logout.php'>Logout</a></li>
<!--    <li><a href='Courses.php'>Add/Edit Courses</a></li>-->
<!--    <li><a href='ApplyToUniversity.php'>Apply To University</a></li>-->
</ul>

<div class="form">
    <h2>---Recruiter Info---</h2>
    <span>Recruiter Name:</span> <?php echo $result['name']; ?>
    <br>
    <br>
    <span>Affiliated University:</span> <?php echo $result['university_name']; ?>
    <br>
    <br>
    <span>E-mail:</span> <?php echo $result['contact_info_email']; ?>
    <br>
    <br>
    <span>Recruiter ID:</span> <?php echo $result['id']; ?>
    <br>
    <br>
    <span>Recruiter username:</span> <?php echo $result['login_username']; ?>
    <br>
    <br>
    Pending Applications:
    <br>
    <?php displayApplications("pending", "pending")?>
    Offers:
    <br>
    <?php displayOffers("accepted", "pending")?>
    No Offers:
    <br>
    <?php displayApplications("rejected", "pending")?>
    <br>
    Accepted Offers:
    <br>
    <?php displayApplications("accepted", "accepted")?>
    Rejected Offers:
    <br>
    <?php displayApplications("accepted", "rejected")?>

</div>


</html>