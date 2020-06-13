<?php 
    session_start();
    
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        if(isset($_SESSION["type"]) && $_SESSION["type"] == "student"){
            header("location: StudentMain.php");
        } else {
            header("location: RecruiterMain.php");
        }
        exit;
    }

    require_once "config.php";
    
    $username = "";
    $password = "";

    if(!empty($_POST['username']) && !empty($_POST['password'])){
        $username = $_POST['username'];
        $password = $_POST['password'];

        $stmt = $mysqli->prepare("SELECT password FROM login WHERE username = ?");
        $stmt->bind_param("s", $username);   
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($expected_password);
        $stmt->fetch();
        if($stmt->num_rows == 1 && $expected_password = $password){
            session_start();
            $_SESSION["loggedin"] = true;
            $_SESSION["username"] = $username;
            
            
            $stmt = $mysqli->prepare("SELECT * from student where login_username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->store_result();

            if($stmt->num_rows == 1){
                $_SESSION["type"] = "student";
                header("location: StudentMain.php");
            }else{
                $_SESSION["type"] = "recruiter";
                header("location: RecruiterMain.php");
            }
        }else{
            echo "incorrect username/password";
        }
    }
   
?>

<!DOCTYPE HTML>
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
<body>


<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tell us who you are </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h2> I am a </h2>
                <button type="button" class="btn btn-primary" onClick="Javascript:window.location.href = 'register/registerStudent.html';"> Recruiter</button>
                <button type="button" class="btn btn-primary" onClick="Javascript:window.location.href = 'register/registerRecruiter.html';" >Student</button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class = "slide_bg">
    <div class="login_box">
        <form method="post">
            <div class="form-group">
                <label for="username">User Name</label>
                <input name="username" type="username" class="form-control" id="username" placeholder="username">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input name= "password" type="password" class="form-control" id="password" placeholder="password">
            </div>
            <input class="btn btn-info" type="submit" value="Sign In">
            <button id = "regBtn" class= "btn btn-info" data-toggle="modal" data-target="#myModal"> Register</button>
        </form>
    </div>
</div>
    <script>

        let modal = document.getElementById("myModal");


        let btn = document.getElementById("regBtn");


        let span = document.getElementsByClassName("close")[0];


        btn.onclick = function(e) {
            modal.style.display = "block";
            e.preventDefault();
        }


        span.onclick = function() {
            modal.style.display = "none";
        }


        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>