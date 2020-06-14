<?php
    session_start();

    function validateSession($type, $redirect="login.php"){
        if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
            if(isset($_SESSION["type"]) && $_SESSION["type"] == $type){
                return true;
            } else {
                header("location: " . $redirect);
            }
        }else{
            header("location: login.php");
        }
    }
?>