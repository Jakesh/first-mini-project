<?php

session_start();
require_once('pdo.php');
if(isset($_POST['deleteprj']))
{
    if(isset($_GET['user']))
    {
        if(isset($_GET['prj_id']))
        {
            try
            {
                $stmt=$pdo->prepare('DELETE FROM projectdetails WHERE id=:i');
                $stmt->execute(array(':i'=>$_GET['prj_id']));
                $_SESSION['deleteScc']="Deleted Successully.";
                header("location:project.php?user=".$_SESSION['id']);
            }
            catch(PDOException $e)
            {
                $_SESSION['DeleteErr']="Could not update the record.";
                header("location:project.php?user=".$_SESSION['id']);
            }
        }
        else
        {
            $_SESSION['DeleteErr']="Could not delete the record. ID Could not be found.";
            header("location:project.php?user=".$_SESSION['id']);
        }
    }
    else
    {
        $_SESSION['DeleteErr']="Could not delete the record. User unknown";
        header("location:project.php?user=".$_SESSION['id']);
    }
}

if(isset($_POST['cancel']))
{
    header("location:project.php?user=".$_SESSION['id']);
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
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-4 offset-md-4">
                <form class="formclass bg-warning" action="" method="POST">
                    <h5>Do you really want to delete this record!!</h5>
                    <button class="btn btn-secondary btn-sm offset-7" type="submit" name="cancel">Cancel</button>
                    <button class="btn btn-primary btn-sm bg-danger" type="submit" name="deleteprj">Confirm</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>