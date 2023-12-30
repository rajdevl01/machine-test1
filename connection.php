

<?php
try{
    $dbname = "mysql:host=localhost;dbname=students";
    $username = "root";
    $password = "";
    $conn = new PDO($dbname,$username,$password);


} catch(Exception $e){
    echo "Message ". $e->getMessage();
}

 ?>
