<?php
require_once('dbconfig.php');
session_start();
$sql="SELECT * FROM user WHERE `UserID` ='".$_SESSION['uid']."'";   // get user name
$result1=mysqli_query($db_connection,$sql);
$getdata = mysqli_fetch_assoc($result1);

if(isset($_POST['update'])){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    $check="SELECT * FROM user WHERE `UserID` !='".$_SESSION['uid']."'";   // get user name
    $getresult = mysqli_query($db_connection,$check);
    $getrow = mysqli_num_rows($getresult);
    $num=0;
    while($num<$getrow){
        $fetch=mysqli_fetch_assoc($getresult);
        if($username==$fetch['Name']){
          echo "<script>alert('The Username had been used... Please use other name');</script>";
          echo "<script>window.location='editProfile1.php'</script>";
        }
        $num++;
    }
      $sqlupdate="UPDATE `user` SET `Name` = '$username' , `Password`= '$password',`Email` ='$email',`Phone`='$phone'  WHERE `UserID` = '".$_SESSION['uid']."'";
      $test = mysqli_query($db_connection,$sqlupdate);
      if($test>0){
        $_SESSION['pw'] = $password;
        echo "<script>alert('Successfully updated !!! ');</script>";
        echo "<script>window.location='homepage.php'</script>";
      }
}
else{
?>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="../css/header.css" />
        <link rel="stylesheet" type="text/css" href="../css/editProfile.css">
        <script src="../javascript/formvalidation.js"></script>
        <title>Edit Profile</title>
    </head>
    <body>
        <div class="header">
            <img src="../img/logo.png" alt="Logo">
            <h1>Inventory System</h1>
        </div>
        <div class="refLink">
            <h2> Edit Profile</h2>
            <a href="./homepage.php">Home Page</a><p>&nbsp>&nbsp</p><p>Edit Profile</p>
        </div>
        <hr>
        <div class="form">
        <!--   <a href="./homepage.php"><input type="button" class="back" value="<< Back"/></a>  -->
            <div class="signUpForm">
            <form action="editProfile1.php" method="POST" onsubmit="return signUpValidation();">
                <p></p>
                <p id="padding">Username<span class="arterisk">*</span></p>
                <input type="text" name="username" value="<?php echo "$getdata[Name]"; ?>">
                <p>Email<span class="arterisk">*</span></p>
                <input type="email" name="email" value="<?php echo "$getdata[Email]"; ?>">
                <p>Phone<span class="arterisk">*</span></p>
                <input type="text" name="phone" value="<?php echo "$getdata[Phone]"; ?>">
                <p>Password<span class="arterisk">*</span></p>
                <input type="password" name="password" value="<?php echo "$getdata[Password]"; ?>">
                <p>Confirm Password<span class="arterisk">*</span></p>
                <input type="password" name="confirmPassword" value="<?php echo "$getdata[Password]"; ?>">
                <input class="signUp" type="submit" value="Update" name="update">
            </form>
            </div>
    </body>
</html>
<?php } ?>
