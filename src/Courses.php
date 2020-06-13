<!DOCTYPE html>
<html>
<h1>Courses</h1>
</html>

<?php
    require_once "config.php";
    $sql = "SELECT Course.name, Taken.mark FROM Course, Taken, Student, Mark"
    $stmt = $mysqli->prepare()
?>