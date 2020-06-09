<?php 
    session_start();

    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        header("location: welcome.php");
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
        if($expected_password = $password){
            session_start();
            $_SESSION["loggedin"] = true;
            $_SESSION["username"] = $username; 
            $_SESSION["type"] = "Student";
            header("location: StudentMain.php");
        }else{
            echo "incorrect username/password";
        }
    }
   
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welocome To CPSC304</title>
    <link rel="stylesheet" href="../css/wPage.css">
</head>
<body>
<div class = "slide_bg">
    <div id="login_form">
        <form>
            <p>Username:</p>
            <input type="text" name="username">
            <p for="password">Password:</p>
            <input type="password" name="password">
            <br>
            <input type="submit" value="Sign In">
        </form>
    </div>
</div>
</body>
</html>