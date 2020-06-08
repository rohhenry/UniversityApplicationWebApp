<?php 

    function logout(){
        // Initialize the session
        session_start();
        
        // Unset all of the session variables
        $_SESSION = array();
        
        // Destroy the session.
        session_destroy();
        
        // Redirect to login page
        header("location: StudentLogin.php");
        exit;
    }


    if (isset($_GET['logout'])){
        logout();
    }
?>


<!DOCTYPE HTML>
<html>
<a href='StudentMain.php?logout=true'>logout</a>
</html>