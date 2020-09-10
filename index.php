<?php

session_start();
include('header.php');
require_once('pdo.php');

$stmt;
$stmt1=$pdo->query('SELECT COUNT(*) FROM couroselimg')->fetchColumn();

if(isset($_POST['add']))
{
  if(isset($_FILES['Cimages']))
  {
    if($stmt1 < 5)
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
          $stmt=$pdo->prepare('INSERT INTO couroselimg (title, Imgname) VALUES (:ttl, :Iname)');
          $stmt->execute(array(':ttl'=>$_POST['title'], ':Iname'=>$file_name));
          move_uploaded_file($file_tmp,"public/CImages/".$file_name);
          $_SESSION['Addsuccess']="Added successfully.";
        }
        else{
          $_SESSION['error']="FAILED!! file size can not be more than 3mb.";
      }
      }
      else{
          $_SESSION['error']="FAILED!! extension not allowed, please choose a JPEG or PNG file.";
        }
  }
  else{
    $_SESSION['error']="FAILED!! Image limit for slideshow reached please Delete the existing images.";
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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Home</title>

    <link rel="stylesheet" href="resources/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="resources/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="resources/bootstrap-social/bootstrap-social.css">
    <link rel="stylesheet" href="css/indx.css">
    <script src="resources/jquery/dist/jquery.slim.min.js"></script>
    <script src="resources/popper.js/dist/umd/popper.min.js"></script>
    <script src="resources/bootstrap/dist/js/bootstrap.min.js"></script>
</head>
<body>
    
    <!--ERROR Messages------------------------->
        <?php
        
        if(isset($_SESSION['error']))
        {
            echo"<div class='alert alert-warning alert-dismissible fade show' role='alert'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
              <span aria-hidden='true'>&times;</span>
            </button>
            <strong>".$_SESSION['error']."
          </div>";
          unset($_SESSION['error']);
        }

        else if(isset($_SESSION['success'])){
            echo"<div class='alert alert-success alert-dismissible fade show' role='alert'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
              <span aria-hidden='true'>&times;</span>
            </button>
            <strong>".$_SESSION['success']."
          </div>";
          unset($_SESSION['success']);
        }
        else if(isset($_SESSION['Addsuccess']))
        {
          echo"<div class='alert alert-success alert-dismissible fade show' role='alert'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
              <span aria-hidden='true'>&times;</span>
            </button>
            <strong>".$_SESSION['Addsuccess']."
          </div>";
          unset($_SESSION['Addsuccess']);
        }
        ?>

    <!--End of ERROR Messages------------------>

    <!--Displaying Images to all users--------->
    <div class="container">
      <div class="row">
          
            
              <?php
                if($logininfo == null)
                {
                   echo""; 
                }

                else if($userid == $logininfo)
                {
                    if($stmt1 <= 1)
                    {
                      echo"<div class='col-2 col-md-1 offset-10 select__Img'><p class='selectImg' id='addSlideshowImg'><span class='fa fa-plus fa-lg'></span> Add</p></div>";
                    }
                    else if($stmt1 > 0 && $stmt1 <= 5 )
                    {
                      echo"<div class='col-2 col-md-1 offset-8 offset-md-10 select__Img'><p class='selectImg' id='addSlideshowImg'><span class='fa fa-plus fa-lg'></span> Add</p></div>";
                      echo"<div class='col-2 col-md-1 select__Img'><a class='selectImg' href=editCarousel.php?user=".$_SESSION['id']."><span class='fa fa-edit fa-lg'></span> Edit</a></div>";
                    }
                  
                    else if($stmt1 > 5)
                    {
                      echo"<div class='col-2 col-md-1 offset-10 offset-md-11 select__Img'><a class='selectImg' href=''><span class='fa fa-edit fa-lg'></span> Edit</a></div>";
                    }     
                }
              ?>
          
      </div>
      <div class="row">
          <div class="col-12">
                <?php
                
                 
                  if( $stmt1 <= 1)
                  {
                    echo"<div id='slideshow' class='carousel slide' data-ride='carousel'>";
                      echo"<div class='carousel-inner'>";
                        echo"<div class='carousel-item active'>";
                          echo"<img class='cimages' src='public/CImages/404.jpg' alt='404' width='400' height='200'/>";
                          echo"<div class='carousel-caption d-none d-md-block'>";
                          echo"<h5>ERROR</h5>";
                          echo"<p class='c__para'>Sorry No Images Found</p>";
                          echo"</div>";
                        echo"</div>";
                      echo"</div>";
                      echo"<a class='carousel-control-prev' href='#carouselExampleControls' role='button' data-slide='prev'>";
                      echo"<span class='carousel-control-prev-icon' aria-hidden='true'></span>";
                      echo"<span class='sr-only'>Previous</span>";
                      echo"</a>";
                      echo"<a class='carousel-control-next' href='#carouselExampleControls' role='button' data-slide='next'>";
                      echo"<span class='carousel-control-next-icon' aria-hidden='true'></span>";
                      echo"<span class='sr-only'>Next</span>";
                      echo"</a>";
                    echo"</div>";
                  }
                  else
                  {
                    $stmt=$pdo->query('SELECT * FROM couroselimg WHERE NOT id=1');
                    echo"<div id='slideshow' class='carousel slide' data-ride='carousel'>";
                    echo"<div class='carousel-inner'>";
                      while($row=$stmt->fetch(PDO::FETCH_ASSOC))
                      {
                        if($row['id'] == 9)
                        {
                          echo"<div class='carousel-item active fixed'>";
                            echo"<img class='d-block w-100 img-responsive' src=public/CImages/".$row['Imgname']." alt=".$row['Imgname']." height='350'/>";
                             echo"<div class='carousel-caption'>";
                            echo"<h5 class='c__title'>".$row['title']."</h5>";
                            echo"</div>";
                          echo"</div>";
                        }
                          else
                          {
                            echo"<div class='carousel-item'>";
                              echo"<img class='d-block w-100 img-responsive' src=public/CImages/".$row['Imgname']." alt=".$row['Imgname']." height='350'/>";
                              echo"<div class='carousel-caption'>";
                              echo"<h5 class='c__title'>".$row['title']."</h5>";
                              echo"</div>";
                            echo"</div>";
                          }                     
                      }
                    
                      echo"</div>";
                      echo"<a class='carousel-control-prev' href='#slideshow' role='button' data-slide='prev'>";
                      echo"<span class='carousel-control-prev-icon' aria-hidden='true'></span>";
                      echo"<span class='sr-only'>Previous</span>";
                      echo"</a>";
                      echo"<a class='carousel-control-next' href='#slideshow' role='button' data-slide='next'>";
                      echo"<span class='carousel-control-next-icon' aria-hidden='true'></span>";
                      echo"<span class='sr-only'>Next</span>";
                      echo"</a>";
                      echo"</div>";
                  }
                
                ?>
                <br/>
          </div>  
      </div>
    </div>
    <!--End of Displaying Images--------------->

    <!--Adding Carousel images-->
      <div id="courosel_img" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg" role="content">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add Images </h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form class="formclass align-items-center" method="POST" action="" enctype="multipart/form-data">
                            <div class="row">
                                <label class="col-4">Title</label>
                                <input type="text" id="title" name="title" class="col-7 form-control form-control-sm mr-1">
                            </div>
                            <div class="form-row"><p class="col-7 offset-4" id="titleError"></p></div>

                            <div class="row">
                                <label class="col-4">Select Images</label>
                                <input type="file" name="Cimages" class="col-12 col-md-7 form-control-file">
                            </div>
                            <div class="row"><span class="col-8 offset-4 text-warning">*Select .jpg /.jpeg /.png, file size < 2 mb*</span></div>
                            <div class="row">
                                <button type="submit" class="btn btn-primary btn-sm offset-10" id="add" name="add">Add</button>        
                            </div><br/>
                        </form>
                    </div>
                </div>
            </div>
      </div>
    <!--End of Courosel images-->
    <?php include('footer.html');?>
    <script>
      $("#addSlideshowImg").click(function(){
        $("#courosel_img").modal('show');
      });
      $(function(){
        $("#slideshow").carousel( { interval: 3000 } );
      });

    </script>
</body>
</html>