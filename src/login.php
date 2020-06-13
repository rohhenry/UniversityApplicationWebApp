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
        if($stmt->num_rows == 1 && $expected_password == $password){
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
<a href="register/registerStudent.html">Register Here</a>
<div id="login_form">
<form method="post">
    <p>Username:</p>
    <input type="text" name="username">
    <p for="password">Password:</p>
    <input type="password" name="password">
    <br>
    <input type="submit" value="Sign In">
</form>
</div>
</html>