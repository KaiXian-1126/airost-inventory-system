<?php
require_once("./php/dbconfig.php");
session_start();
if(isset($_SESSION['uid'])){
    echo "<script>window.location = './php/homepage.php'</script>";
}
else if(isset($_POST['username']) && isset($_POST['password'])){
    $sql = "SELECT * FROM `user`
    WHERE `Name` = '".$_POST['username']."' AND `Password` = '".$_POST['password']."'";

    $result = mysqli_query($db_connection, $sql);
    $num_row = mysqli_num_rows($result);
    if($num_row > 0){
        $result_row = mysqli_fetch_assoc($result);
        $_SESSION['uid'] = $result_row['UserID'];
        $_SESSION['pw']  = $result_row['Password'];
        echo "<script>window.location = './php/homepage.php'</script>";
    }else{
        echo "<script>alert('Invalid Username and Password')</script>";
        echo "<script>window.location = './index.php'</script>";
    }

}
else{ ?>
<html>
    <head>
        <title>Login Page</title>
        <link rel="stylesheet" type="text/css" href="./css/background.css">
        <link rel="stylesheet" type="text/css" href="./css/login.css">
    </head>
    <body>
        <div id="login">
            <div id="design">
                <h1>Airost<br> Inventory System</h1>
                <img class="logo" src="./img/logo.png" alt="Logo"/>
            </div>

            <div id="loginForm">
                <form action="index.php" method="post">
                    <h2>Login</h2>
                    <p>Username</p>
                    <input type="text" name="username" value="">
                    <p>Password</p>
                    <input type="password" name="password" value="">
                    <input class="login" type="submit" value="Login">
                    <p id="noacc">Don't have an account?</p>
                    <a href="./php/signup.php">Sign up</a>
                </form>

            </div>
        </div>
   <?php } ?>
    </body>
</html>
