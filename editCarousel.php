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
}

else{
    $user= null;
}

$stmt1=$pdo->query('SELECT * FROM couroselimg');
$stmt2=$pdo->query('SELECT COUNT(*) FROM couroselimg')->fetchColumn();
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
                <li class="breadcrumb-item active" aria-current="page">Select</li>
            </ol>
        </nav>
        <?php
        
        if($user != null)
        { 
        ?>
        <div class="d-none d-md-block">
            <h4 class="head__text">Select Image For Update</h4>
        </div>
        <div class="container"> 
            <div class="row">
                
                <?php
                
                    if($stmt2 <= 1)
                    {
                        echo"<div class='col-12'><h4>No Records Found</h4></div>";
                    }

                    else 
                    {
                        while($row=$stmt1->fetch(PDO::FETCH_ASSOC))
                        {
                        break;
                        }
                    
                        while($row=$stmt1->fetch(PDO::FETCH_ASSOC))
                        {
                            echo"<div class='col-12 col-md-3'>";
                            echo"<a href=editCarouselfinal.php?user=".$_SESSION['id']."&edit_id=".$row['id']."><img class='editImg' src=public/CImages/".$row['Imgname']." alt=".$row['Imgname']." height='230'/></a>";
                            echo"</div>"; 
                        }
                    }

                ?>
            </div>
        </div>
        <?php
        }
        else
        {
            echo"<div class='col-12'><h4>Please login</h4></div>";
        }
        ?>
<?php include('footer.html');?>
</body>
</html>