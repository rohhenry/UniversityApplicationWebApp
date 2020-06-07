<?php 
    require_once "pdo_constructor.php";
    
    $username = $_POST['username'];
    $password = $_POST['password'];
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