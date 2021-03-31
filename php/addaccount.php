<?php
require_once('dbconfig.php');
$username = $_POST['username'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$password = $_POST['password'];
$referrerID = $_POST['referrerID'];

$chkreferrer = "SELECT * FROM user WHERE `UserID` = ".$referrerID." AND `Position` = 'MANAGEMENT LEVEL'";
$referrerResult = mysqli_query($db_connection, $chkreferrer);
?>
<html>
    <head>
        <title>Sign Up New Account</title>
    </head>
    <body>
        <h1>Sign Up New Account</h1>

        <?php if(mysqli_num_rows($referrerResult) == 0){ ?>
            <p>Unsuccessfully Sign Up: Invalid Referrer ID.</p>
            <a href="../signup.html">Back to sign up page</a>
        <?php 
            }
            else
            { 
                $chkid = "SELECT MAX(UserID) FROM `user`";
                $result = mysqli_query($db_connection, $chkid);
                $result_row = mysqli_fetch_assoc($result);
                $currentMaxID = $result_row['MAX(UserID)'];
                $nextID = $currentMaxID + 1;
                
                $sqlinsert = "INSERT INTO `user` (`UserID`, `Name`, `Password`, `Email`, `Phone`, `Position`) 
                VALUES (".$nextID.", '".$username."', '".$password."', '".$email."', ".$phone.", 'GENERAL MEMBER')";
                $result = mysqli_query($db_connection, $sqlinsert);
                if($result > 0){ ?>
                
                <p>Successfully Sign Up. Back to <a href="../index.php">Login Page</a> to sign in.
            <?php    
                }
                else{
            ?>
                    Unsuccessfully Sign Up: Database Error.
                    <a href="../signup.html">Back to sign up page</a>
            <?php }
        
            } ?>

    </body>
</html>
