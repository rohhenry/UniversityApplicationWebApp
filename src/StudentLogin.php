<?php 

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
        if($expected_password = $password){
            echo "success";
            header("location: StudentMain.php");
        }else{
            echo "incorrect username/password";
        }
    }
   
?>

<!DOCTYPE HTML>
<html>
<form method="post">
    <p>Username:</p>
    <input type="text" name="username">
    <p for="password">Password:</p>
    <input type="password" name="password">
    <br>
    <input type="submit" value="Sign In">
</form>
</html>