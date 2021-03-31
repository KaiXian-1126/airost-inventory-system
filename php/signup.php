<?php
require_once('dbconfig.php');
if(isset($_POST['username'])){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $referrerID = $_POST['referrerID'];

    $chkreferrer = "SELECT * FROM user WHERE `UserID` = ".$referrerID." AND `Position` = 'MANAGEMENT LEVEL'";
    $referrerResult = mysqli_query($db_connection, $chkreferrer);
    if(mysqli_num_rows($referrerResult) == 0){
        echo "<script>alert('Unsuccessfully Sign Up: Invalid Referrer ID.');</script>";
    }else{
        $chkuser = "SELECT * FROM user WHERE `Name` = '".$username."'";
        $userresult = mysqli_query($db_connection, $chkuser);

        if(mysqli_num_rows($userresult) > 0){
            echo "<script>alert('Username existed. Please enter other username.')</script>";
        }else{
            $chkid = "SELECT MAX(UserID) FROM `user`";
            $result = mysqli_query($db_connection, $chkid);
            $result_row = mysqli_fetch_assoc($result);
            $currentMaxID = $result_row['MAX(UserID)'];
            $nextID = $currentMaxID + 1;
            $sqlinsert = "INSERT INTO `user` (`UserID`, `Name`, `Password`, `Email`, `Phone`, `Position`)
                        VALUES (".$nextID.", '".$username."', '".$password."', '".$email."', '".$phone."', 'GENERAL MEMBER')";
            $result = mysqli_query($db_connection, $sqlinsert);
            if($result > 0){
                echo "<script>window.location = '../html/SuccessfulSignUp.html'</script>";
            }else{
                echo "<script>Unsuccessfully Sign Up: Database error.</script>";
            }
        }
    }


}
?>

<html>
    <head>
        <title>Sign Up</title>
        <link rel="stylesheet" type="text/css" href="../css/background.css">
        <link rel="stylesheet" type="text/css" href="../css/signup.css">
        <script src="../javascript/formvalidation.js"></script>
    </head>
    <body>
        <img class="header" src="../img/logo.png" alt="Logo" />
        <div class="signUpForm">
        <form action="signup.php" method="POST" onsubmit="return signUpValidation();">
            <h2>Create New Account</h2>
            <p>Username<span class="arterisk">*</span></p>
            <input type="text" name="username" value="">
            <p>Email<span class="arterisk">*</span></p>
            <input type="email" name="email" value="">
            <p>Phone<span class="arterisk">*</span></p>
            <input type="text" name="phone" value="">
            <p>Password<span class="arterisk">*</span></p>
            <input type="password" name="password" value="">
            <p>Confirm Password<span class="arterisk">*</span></p>
            <input type="password" name="confirmPassword" value="">
            <p>Referrer ID<span class="arterisk">*</span></p>
            <input type="text" name="referrerID" value="">
            <input class="signUp" type="submit" value="Sign Up">
        </form>
        </div>
    </body>
</html>
