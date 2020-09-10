<?php 

session_start();
include('header.php');
require_once('pdo.php');

if(isset($_GET['user']))
{
    if($_GET['user'] == $_SESSION['id'])
    {
        $user= $_GET['user'];
    }
    else{
        $_SESSION['error']="Username invalid.";
        $user= null;
    }

    if(isset($_GET['edit_id']))
    {
        $edit_id=$_GET['edit_id'];
        $stmt=$pdo->prepare('SELECT Imgname FROM couroselimg WHERE id=:imgid');
        $stmt->execute(array(':imgid'=>$edit_id));
        $row=$stmt->fetch(PDO::FETCH_ASSOC);
    }
    else
    {
        $edit_id= null;
    }
}

else{
    $user= null;
}

///////////////////////////////////////////
if(isset($_POST['update']))
{
  if(isset($_FILES['Cimages']))
  {
    
      $file_name = $_FILES['Cimages']['name'];
      $file_size =$_FILES['Cimages']['size'];
      $file_tmp =$_FILES['Cimages']['tmp_name'];
      $file_type=$_FILES['Cimages']['type'];
      $file_extension=explode('.',$file_name);
      $file_ext=strtolower(end($file_extension));

      if($file_ext == "jpg" || $file_ext == "jpeg" || $file_ext == "png")
      {
        if($file_size <= 3145728){
          $stmt=$pdo->prepare('UPDATE couroselimg SET title=:ttl, Imgname=:Iname WHERE id=:imgid');
          $stmt->execute(array(':ttl'=>$_POST['title'], ':Iname'=>$file_name, ':imgid'=>$edit_id));
          move_uploaded_file($file_tmp,"public/CImages/".$file_name);
          $_SESSION['Addsuccess']="Updated successfully.";
        }
        else{
          $_SESSION['error']="FAILED!! file size can not be more than 2mb.";
      }
      }
      else{
          $_SESSION['error']="FAILED!! extension not allowed, please choose a JPEG or PNG file.";
        }
  }
  else{
    $_SESSION['error']="FAILED!! Image not selected.";
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
    <link rel="stylesheet" href="css/edit.css">
    <script src="resources/jquery/dist/jquery.slim.min.js"></script>
    <script src="resources/popper.js/dist/umd/popper.min.js"></script>
    <script src="resources/bootstrap/dist/js/bootstrap.min.js"></script>
    
    

</head>
<body>
        <nav aria-label="breadcrumb" class="mt-3 ml-5 mr-5">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href=<?php  echo"index.php?user=".$_SESSION['id']?>>Home</a></li>
                <li class="breadcrumb-item"><a href=<?php  echo"editCarousel.php?user=".$_SESSION['id']?>>Select</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </nav>

        <?php
            if($user != null && $edit_id != null)
            {
        ?>
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-3 offset-md-4">
                        <h5 class="ml-5 curimage">Current Image</h5>
                        <img src=<?php echo"public/CImages/".$row['Imgname'] ?> alt="Current Image" width="260" height="200" />
                    </div>
                    <div class="col-12 col-md-3">
                        <h5 class="ml-5 uimage">Update with</h5>
                        <img alt="update Image" src="public/CImages/click.png" width="260" height="200" id="updateImage"/>
                    </div>
                </div>
                <br/>
                <form class="formclass" method="POST" action="" enctype="multipart/form-data">
                    <div class="row">
                        <label class="col-3 offset-1">ID</label>
                        <label class="col-7 mr-1"><?php echo"<b>".$edit_id."</b>";?></label>
                    </div>

                    <div class="row">
                        <label class="col-3 offset-1">Title</label>
                        <input type="text" name="title" id="title" class="col-7 form-control form-control-sm mr-1">
                    </div>

                    <div class="row"><p class="col-7 offset-4" id="titleError"></p></div>

                    <div class="row">
                        <label class="col-3 offset-1">Select Image</label>
                        <input type="file" id="Cimages" name="Cimages" class="col-7 form-control-file" accept="image/*" onchange="loadFile(event)"/>
                    </div><br/>
                    <div class="row"><span class="col-8 offset-4 text-danger" id="imgError">*Select .jpg /.jpeg /.png and Size < 2 mb*</span></div>

                    <div class="row">
                        <button type="submit" class="btn btn-primary btn-sm offset-9 offset-md-10" name="update" id="update">Update</button>        
                    </div><br/>
                </form>
            </div>
        <?php
            }
            else
            {
                echo"<div class='col-12'><h4>Please login</h4></div>";
            }
        ?>
        <?php include('footer.html');?>
        <script>
            var loadFile = function(event) {
                var image = document.getElementById('updateImage');
                image.src = URL.createObjectURL(event.target.files[0]);
            };
            
            
        </script>
</body>
</html>