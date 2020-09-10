<?php

session_start();
require_once('pdo.php');

if(isset($_POST['login'])){
    $uemail=$_POST['email'];
    if(isset($_POST['email']) && isset($_POST['password'])){
        $stmt = $pdo->prepare('SELECT userName,password FROM admininfo WHERE userName = :un');
        $stmt->execute(array('un'=>$uemail));
        $row=$stmt->fetch(PDO::FETCH_ASSOC);

        if(empty($row)){
            $_SESSION['error']="Login Failed! Wrong Email or Password.";
            header("location:index.php");
            return;
        }
        else{
            $email=htmlentities($row['userName']);
            $pass=htmlentities($row['password']);
            if($_POST['email'] == $email && $_POST['password'] == $pass){
                $_SESSION['success']="Login Successfull.";
                $id=date("his");
                $userid="Admin".$id;
                $_SESSION['id']=$userid;
                header("location:index.php?user=".$userid);
                return;
            }

            else{
                $_SESSION['error']="Login Failed! Wrong Email or Password.";
                header("location:index.php");
                return;
            }
        }
    }
    else{
        $_SESSION['error']="Fields cannot be empty";
        header("location:index.php");
        return;
    }
}
?>