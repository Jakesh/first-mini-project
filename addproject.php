<?php

session_start();
require_once('pdo.php');

if(isset($_POST['addprj'])){


    $title=$_POST['prjTitle'];
    $description=$_POST['prjDesc'];
    
    if(isset($_POST['prjTitle']) && isset($_POST['prjDesc'])){
        $file_name = $_FILES['select_Image']['name'];
        $file_size =$_FILES['select_Image']['size'];
        $file_tmp =$_FILES['select_Image']['tmp_name'];
        $file_type=$_FILES['select_Image']['type'];
        $file_ext=strtolower(end(explode('.',$_FILES['select_Image']['name'])));
        
        if($file_ext == "jpg" || $file_ext == "jpeg" || $file_ext == "png"){
            if($file_size <= 3145728){
                    try{
                        $stmt=$pdo->prepare('INSERT INTO projectdetails (title, description, img_name) VALUES (:ttl, :desp, :iname)');

                        $stmt->execute(array(':ttl'=>$_POST['prjTitle'], ':desp'=>$_POST['prjDesc'], ':iname'=>$file_name ));
                        move_uploaded_file($file_tmp,"public/Images/".$file_name);
                        $_SESSION['Addsuccess']="Added successfully.";
                        header("location:project.php?user=".$_SESSION['id']);
                    }
                    catch(PDOException $e){
                        $_SESSION['error']="Unknow problem occured. data not inserted";
                        header("location:project.php?user=".$_SESSION['id']);
                }
            }
            else{
                $_SESSION['error']="FAILED!! file size can not be more than 2mb.";
                header("location:project.php?user=".$_SESSION['id']);
            }
        }
            else{
                $_SESSION['error']="FAILED!! extension not allowed, please choose a JPEG or PNG file.";
                header("location:project.php?user=".$_SESSION['id']);
            }
        }
            
    else{
        $_SESSION['error']="Fields cannot be empty.";
        header("location:project.php?user=".$_SESSION['id']);
    }
}

?>