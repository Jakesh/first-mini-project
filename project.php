<?php

session_start();
include('header.php');
require_once('pdo.php');

?>

<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Projects</title>

        <link rel="stylesheet" href="resources/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="resources/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="resources/bootstrap-social/bootstrap-social.css">
        <link rel="stylesheet" href="css/projectcss.css">
        <script src="resources/jquery/dist/jquery.slim.min.js"></script>
        <script src="resources/popper.js/dist/umd/popper.min.js"></script>
        <script src="resources/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="js/validation.js"></script>

    </head>
    <body>
        <!--ERROR------------------------>
        <?php
            if(isset($_SESSION['UpdateErr']))
            {
                echo"<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
                </button>
                <strong>".$_SESSION['UpdateErr']."
                </div>";
                unset($_SESSION['UpdateErr']);
            
            }

            else if(isset($_SESSION['UpdateScc'])){
                echo"<div class='alert alert-success alert-dismissible fade show' role='alert'>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
                </button>
                <strong>".$_SESSION['UpdateScc']."
                </div>";
                unset($_SESSION['UpdateScc']);
            }

            if(isset($_SESSION['DeleteErr']))
            {
                echo"<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
                </button>
                <strong>".$_SESSION['DeleteErr']."
                </div>";
                unset($_SESSION['DeleteErr']);
            }
            else if(isset($_SESSION['deleteScc']))
            {
                echo"<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
                </button>
                <strong>".$_SESSION['deleteScc']."
                </div>";
                unset($_SESSION['deleteScc']);
            }
            ?>

        <!--End of ERROR-->
        <!--Display Project Details--------->
        <div class="container">
            <div class="row">
                <?php
                    if($logininfo == null || !isset($_SESSION['id']) || $logininfo != $_SESSION['id'])
                    {
                       echo"<div class='col-4 col-md-1 ml-auto'><button class='addprj' type='submit' id='signin'><span class='fa fa-plus-square fa-lg'></span> Add</button></div>"; 
                    }

                    else if($userid == $logininfo)
                    {
                        echo"<div class='col-4 col-md-1 ml-auto'><button class='addprj' type='submit' id='addProject'><span class='fa fa-plus-square fa-lg'></span> Add</button></div>"; 
                    }
                ?>
                
            </div>
            <div class="row">
                <?php
                  if(isset($_SESSION['Addsuccess']))
                    {
                        echo"<div class='col-5 offset-5'><p class='success'>".$_SESSION['Addsuccess']."</p></div>";
                        unset($_SESSION['Addsuccess']);
                    }
                    else if(isset($_SESSION['error']))
                    {
                        echo"<div class='col-5 offset-5'><p class='success'>".$_SESSION['error']."</p></div>";
                        unset($_SESSION['error']);
                    }
                ?> 
            </div>
            <!--Displaying the informations-------------------------->
            <div class="row">
                <?php
                
                        $stmt = $pdo->query('SELECT * FROM projectdetails');
                        $row = $stmt->fetch(PDO::FETCH_ASSOC);
                        if(empty($row))
                        {
                            echo"<div class='media-body'><h5 class='mt-0'>No Records Found</h5></div>";
                        }

                        else if(!empty($row)){
                            if($logininfo != null && $userid == $logininfo)
                           {
                                while($row = $stmt->fetch(PDO::FETCH_ASSOC))
                                {
                                    echo"<div class='media w-100 mt-3'>";
                                    echo"<img class='media__img mr-3' src=public/CImages/".$row['img_name']." alt=".$row['img_name'].">";
                                    echo "<div class='media-body'><h5 class='mt-2 media__head'>";
                                    echo (htmlentities($row['title']));
                                    echo "</h5>";
                                    echo "<p class='d-none d-md-block media__info'>";
                                    echo (htmlentities($row['description']));
                                    echo "</p>";
                                    echo "<form class='formclass col-12 formedit ' action='' method=''>";
                                    echo "<a href=editprj.php?user=".$_SESSION['id']."&prj_id=".$row['id'].">Edit</a>&nbsp &nbsp";
                                    echo "<a href=delete.php?user=".$_SESSION['id']."&prj_id=".$row['id'].">Delete</a>";
                                    echo "</form>";
                                    echo"</div></div>";
                                }
                            }
                            else{
                                while($row = $stmt->fetch(PDO::FETCH_ASSOC))
                                {
                                    echo"<div class='media w-100 mt-3'>";
                                    echo"<img class='media__img mr-3' src=public/CImages/".$row['img_name']." alt=".$row['img_name'].">";
                                    echo "<div class='media-body'><h5 class='mt-0 media__head'>";
                                    echo (htmlentities($row['title']));
                                    echo "</h5><p class='media__info'>";
                                    echo (htmlentities($row['description']));
                                    echo"</p></div></div>";
                                    
                                }
                            }
                        }
                
                ?>
            </div>
            <!--Displaying the informations-------------------------->
        </div>
        <!--End of Project Details---------->

        <!--Add Project Modal--------------->
        <div id="addProjectModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg" role="content">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add Project</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form class="formclass" id="prjDetails" method="POST" action="addproject.php" autocomplete="off" enctype="multipart/form-data">
                            <div class="row">
                                <p class="col-12 col-md-4">Project Title: </p>
                                <input class="col-12 col-md-8" type="text" name="prjTitle" id="prjTitle" placeholder="Project Title"/>
                            </div>
                            
                            <div class="row"><span class="col-8 offset-4 text-danger" id="titleError"></span></div>

                            <div class="row">
                                <p class="col-12 col-md-4">Project Description: </p>
                                <textarea class="col-12 col-md-8" name="prjDesc" id="prjDesc" rows="5"></textarea>
                            </div>
                            
                            <div class="row"><span class="col-8 offset-4 text-danger" id="desError"></span></div>
                            <br>
                            <div class="row">
                                <p class="col-12 col-md-4">Image</p>
                                <input class="col-12 col-md-8" type="file" name="select_Image" id="select_Image"/>
                            </div>
                            <div class="row"><span class="col-8 offset-4 text-danger" id="imgError">Select Image With .jpg /.jpeg /.png. and size < 2 mb</span></div>

                            <div class="row">
                                <input class="btn btn-primary btn-sm offset-10 offset-md-11" type="submit" name="addprj" id="addprj" value="ADD"/>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--End of Project Modal------------>
        <?php include('footer.html');?>
        <script>
            $("#addProject").click(function(){
                $("#addProjectModal").modal('show');
            });

            $("#signin").click(function(){
                $("#loginModal").modal('show');
            });
        </script>
    </body>
</html>