<?php

session_start();
require_once('pdo.php');

if(isset($_POST['editprj']))
{
    if(isset($_GET['user']))
    {
        if(isset($_GET['prj_id']))
        {
            if(isset($_POST['prjTitle']) && isset($_POST['prjDesc']))
            {
                if(isset($_FILES['image']))
                {
                $file_name = $_FILES['image']['name'];
                $file_size =$_FILES['image']['size'];
                $file_tmp =$_FILES['image']['tmp_name'];
                $file_type=$_FILES['image']['type'];
                $file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));
                if($file_ext == "jpg" || $file_ext == "jpeg" || $file_ext == "png")
                {
                    if($file_size <= 2097152)
                    {
                        try{
                            $stmt=$pdo->prepare('UPDATE projectdetails SET title=:ttl, description=:desp, img_name=:iname WHERE id=:prjid');
    
                            $stmt->execute(array(':ttl'=>$_POST['prjTitle'], ':desp'=>$_POST['prjDesc'], ':iname'=>$file_name, ':prjid'=>$_GET['prj_id'] ));
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
                        $_SESSION['error']="Image size cannot be more than 2 mb.";
                        header("location:project.php?user=".$_SESSION['id']);
                    }
                }
                else{
                    $_SESSION['error']="Extension should be jpg/ jpeg/ png.";
                    header("location:project.php?user=".$_SESSION['id']);
                }
            }
            else{
                $_SESSION['error']="Image not selected.";
                header("location:project.php?user=".$_SESSION['id']);
            }
        }
            else{
                $_SESSION['error']="Fields cannot be empty.";
                header("location:project.php?user=".$_SESSION['id']);
            }
        }
        else
        {
            $_SESSION['UpdateErr']="Could not update the record. ID Could not be found.";
            header("location:project.php?user=".$_SESSION['id']);
        }
    }
    else
        {
            $_SESSION['UpdateErr']="Could not update the record. User unknown";
            header("location:project.php?user=".$_SESSION['id']);
        }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="resources/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="resources/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="resources/bootstrap-social/bootstrap-social.css">
    <link rel="stylesheet" href="css/projectcss.css">
    <link rel="stylesheet" href="css/editproject.css">
    <script src="resources/jquery/dist/jquery.slim.min.js"></script>
    <script src="js/editValidation.js"></script>
</head>
<body>
    <?php include('header.php'); ?>
        <nav aria-label="breadcrumb" class="mt-3 ml-5 mr-5">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href=<?php  echo"project.php?user=".$_SESSION['id']?>>Projects</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </nav>
        <div class="container">
            <br/>
            <form class="formclass" id="prjDetails" method="POST" action="" autocomplete="off" enctype="multipart/form-data">
                <div class="row">
                    <p class="col-12 col-md-4">Project Title: </p>
                    <input class="col-12 col-md-7" type="text" name="prjTitle" id="prjTitle" placeholder="Project Title"/>
                </div><br/>
                            
                <div class="row"><span class="col-8 offset-4 text-danger" id="ttlError"></span></div>

                <div class="row">
                    <p class="col-12 col-md-4">Project Description: </p>
                    <textarea class="col-12 col-md-7" name="prjDesc" id="prjDesc" rows="5"></textarea>
                </div><br/>
                            
                <div class="row"><span class="col-8 offset-4 text-danger" id="dError"></span></div>
                <br>

                <div class="row">
                    <p class="col-12 col-md-4">Image</p>
                    <input class="col-12 col-md-7" type="file" name="image" id="image"/>
                </div>

                <div class="row"><span class="col-8 offset-4 text-danger" id="imgError">*Select.jpg /.jpeg /.png. and size < 3mb*</span></div>

                <div class="row">
                    <input class="btn btn-primary btn-sm offset-10 offset-md-10" type="submit" name="editprj" id="editprj" value="Update"/>
                </div>
                <br/>
            </form>

        </div>
        <?php include('footer.html');?>
        <script src="resources/popper.js/dist/umd/popper.min.js"></script>
        <script src="resources/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>