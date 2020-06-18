<?php

require_once "check_session.php";
validateSession("recruiter");

require_once "config.php";

$username = $_SESSION["username"];


function changePassword(){
    global $username, $mysqli;

    $password = $_POST['password'];
    $checkp = $_POST['checkPassword'];

    if($password != $checkp){
        echo 'password should be matched';
        return;
    }

    $sql = "UPDATE login 
            SET password = ?
            WHERE username = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ss", $password, $username);
    if($stmt->execute()){
        echo 'success';
    }else{
        echo 'failure';
    }
}

if(isset($_POST['submit'])){
    changePassword();
}

?>


<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>University Application</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
</head>
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
</h1>
<ul>
    <li><a href='logout.php'>Logout</a></li>
    <li><a href='RecruiterMain.php'>Recruiter Main</a><li>
</ul>

<body>

<div class = "register_box">
    <form method="post">
        <div class="form-row">

            <div class="form-group col-md-6">
                <label for="password">Input Your new Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="">
            </div>
            <br>
            <div class="form-group col-md-6">
                <label for="checkPassword">Re-enter new Password</label>
                <input type="password" class="form-control" id="checkPassword" name="checkPassword" placeholder="">
            </div>

        </div>

        <button type="submit" class="btn btn-primary" name ="submit" >Change Password</button>
    </form>
</div>

</body>


</html>