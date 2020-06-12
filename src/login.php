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
        $expected_password = "";

        $stmt = $mysqli->prepare("SELECT password FROM login WHERE username = ?");
        $stmt->bind_param("s", $username);   
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($expected_password);
        if(if $stmt->num_rows == 1 && $expected_password = $password){
            session_start();
            $_SESSION["loggedin"] = true;
            $_SESSION["username"] = $username;
            
            
            $_SESSION["type"] = "student";
            header("location: StudentMain.php");
        }else{
            echo "incorrect username/password";
        }
    }
   
?>

<!DOCTYPE HTML>
<html>
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