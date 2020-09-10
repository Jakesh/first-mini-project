<?php

try{
$pdo = new PDO('mysql:host=localhost;dbname=project','root','project');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$_SESSION['connection']= "Connected successfully";
}

catch(PDOException $e){
$_SESSION['connectionFailed']= "Connection failed";
header("location:error.php?couldnotConnect");
}

?>