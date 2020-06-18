<?php
    require_once "config.php";

    $stmt;
    $res;


    function runQuery($column, $table){
        global $mysqli, $stmt, $res;
        $stmt = $mysqli->prepare("SELECT $column FROM $table");
        #$stmt->bind_param("ss", $column, $table);
        if(!$stmt){
            throw new Exception('failed to execute');
        }else{
            $stmt->execute();
            $stmt->bind_result($res);
        }
        
    }

    function displayResults(){
        global $stmt, $res;
        if(isset($_POST['run'])){
            $column = $_POST['column'];
            $table = $_POST['table'];
    
            try{
                echo "<br>Out:<br>";
                runQuery($column, $table);
                while($stmt->fetch()){echo "$res<br>";}
            }catch(Exception $e){
                echo 'query failed';
            }
    
        }
    }
    
?>

<!DOCTYPE HTML>
<html>
<form method="post">
Select: <input type="text" name="column"><br>
From: <input type="text" name ="table"><br>
<input type="submit" name="run" value="Run">
<?php displayResults()?>
</form> 
</html>