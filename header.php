<?php

if(isset($_SESSION['id'])){
    $userid=$_SESSION['id'];
}
if(isset($_GET['user'])){
    $logininfo=$_GET['user'];
}
else if(!isset($_GET['user'])){
    $logininfo=null;
}
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
        <link rel="stylesheet" href="css/header.css"/>
        <script src="resources/jquery/dist/jquery.slim.min.js"></script>
        <script src="resources/popper.js/dist/umd/popper.min.js"></script>
        <script src="resources/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="js/loginValidation.js"></script>
    </head>
    <body>
        <!--Nav Bar----------------------------->
       
        <nav class="navbar navbar-expand-lg navbar-dark bg-info">
            <a class="navbar-brand col-2" href="index.php">LOGO</a></div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" id="hamburger__button" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse adjustment" id="navbarSupportedContent">
                <ul class="navbar-nav">
                  
                    <?php 
                        if(isset($_SESSION['id']))
                        {
                            echo"<li class='nav-item activehome'><a class='nav-link' href=index.php?user=".$_SESSION['id']."><p class='activehomelink'><span class='fa fa-home fa-sm'></span> Home</p></a></li>";
                            echo"<li class='nav-item activeprj'><a class='nav-link' href=project.php?user=".$_SESSION['id']."><p class='activeprjlink'><span class='fa fa-tasks fa-sm'></span> Projects</p></a></li>";
                            echo"<li class='nav-item activeabout'><a class='nav-link' href='#'><p class='activeabtlink'><span class='fa fa-info fa-sm'></span> About</p></a></li>";
                            echo"<li class='nav-item activecontact'><a class='nav-link' href='#'><p class='activecntlink'><span class='fa fa-address-card fa-sm'></span> Contact</p></a></li>";
                        }
                        else if(!isset($_SESSION['id'])){
                            echo"<li class='nav-item activehome'><a class='nav-link' href='index.php'><p class='activehomelink'><span class='fa fa-home fa-sm'></span> Home</p></a></li>";
                            echo"<li class='nav-item activeprj'><a class='nav-link' href='project.php'><p class='activeprjlink'><span class='fa fa-tasks fa-sm'></span> Projects</p></a></li>";
                            echo"<li class='nav-item activeabout'><a class='nav-link' href='#'><p class='activeabtlink'><span class='fa fa-info fa-sm'></span> About</p></a></li>";
                            echo"<li class='nav-item activecontact'><a class='nav-link' href='#'><p class='activecntlink'><span class='fa fa-address-card fa-sm'></span> Contact</p></a></li>";
                        }
                    ?>

                </ul>
                <ul class="navbar-nav ml-auto">
                    <?php
                    if($logininfo == null || $userid != $logininfo){
                        echo"<li class='nav-item login__position'><a class='nav-link' id='LoginButton'><p><span class='fa fa-sign-in fa-sm'></span> Login</p></a></li>";
                    }
                    else if($userid == $logininfo){
                        echo"<li class='nav-item login__position'><a class='nav-link' href='logout.php'><p><span class='fa fa-sign-out fa-sm'></span> Logout</p></a></li>";
                    }
                    ?>
                </ul>
            </div>
        </nav>

        <!--End of Nav Bar---------------------->

        <!--Login Modal------------------------->
        <div id="loginModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg" role="content">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Login </h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form class="formclass" method="POST" action="login.php">
                            <div class="form-row">
                                <p class="col-4">Email</p>
                                <input type="email" class="col-7 form-control form-control-sm mr-1" name="email" id="email" placeholder="Enter email">
                            </div>
                            <div class="row"><span class="col-8 offset-4 error__message" id="emailError"></span></div>

                            <div class="form-row">
                                <label class="col-4">Password</label>
                                <input type="password" class="col-7 form-control form-control-sm mr-1" name="password" id="password" placeholder="Password">
                            </div>
                            <div class="row"><span class="col-8 offset-4 error__message" id="passwordError"></span></div>

                            <div class="form-row">
                                <button type="submit" class="btn btn-primary btn-sm offset-10" id="login" name="login">Sign in</button>        
                            </div><br/>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!--End of Login Modal------------------------->
        
        <script src="js/loginValidation.js"></script>
    </body>
</html>