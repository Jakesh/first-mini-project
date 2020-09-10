<?php

require_once('pdo.php');
$email="Jakeshj11@demo.com";
$password="Jake1122@";
$stmt=$pdo->prepare('INSERT INTO admininfo (userName, password) VALUES (:un, :pass)');
$stmt->execute(array(':un'=>$email, ':pass'=>$password));

echo"added successfully";

?>



