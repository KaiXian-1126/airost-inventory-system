<script src="../javascript/function.js"></script>
<script src="../javascript/date.js"></script>
<?php
  require_once("dbconfig.php");
  session_start();
if(!isset($_SESSION['uid'])){
    echo "<script>alert('Please login first.');</script>";
    echo "<script>window.location = '../index.php'</script>";
}else{
  $sql="SELECT * FROM user WHERE `UserID` ='".$_SESSION['uid']."'";
  $result=mysqli_query($db_connection,$sql);
  $row_result = mysqli_fetch_assoc($result);

if(isset($_POST['Logout']))
{
  session_destroy();
  echo "<script>window.location='../index.php'</script>";
}
else{
?>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="../css/header.css" />
        <link rel="stylesheet" type="text/css" href="../css/homepage1.css" />
        <title>Homepage</title>
    </head>
    <body>
        <div class="header">
            <img src="../img/logo.png" alt="Logo">
            <h1>Inventory System</h1>
        </div>
        <?php
          $nextdaydate = date("Y-m-d", strtotime("+1 day"));
          $sql_message = "SELECT * FROM `itemreturn` INNER JOIN `application` 
                        ON `itemreturn`.`AppID` = `application`.`ApplicationID`
                        WHERE `application`.`ApplicantID` = ".$_SESSION['uid'].
                        " AND `application`.`ReturnDate` = '".$nextdaydate."'";
          
          $result_message = mysqli_query($db_connection, $sql_message);
          $num_row = mysqli_num_rows($result_message);
        ?>
        <div class="navibar">
            <a href="#notification" onclick="showNotification();">
                <img class="message-button" src="../img/notification.png" alt="notification"/>
            </a>
            <?php

                if($num_row != 0){
            ?>
                <span class="message-amount"><?php echo $num_row; ?></span>
                <div class="message-content">
                    <?php 
                        while($resultrow_message = mysqli_fetch_assoc($result_message)){
                    ?>
                        <a class="message" href="#">
                        <?php  
                            echo "Your approved application (ID: ".$resultrow_message['AppID'].") left 1 day to be expired."
                                ." Please be alert to return item."; ?>
                        </a>
                    <?php 
                        /*
                        $sql_messageupdate = "UPDATE `notification` SET `Status` = 'read' 
                                        WHERE `NotificationID` = ".$resultrow_message['NotificationID'];
                        
                        mysqli_query($db_connection, $sql_messageupdate);}
                        */
                    } ?>  
                </div>
            <?php }else{ ?>
                <div class="message-content">
                <a class="message" href="#">No Notification</a>
                </div>
            <?php }?>
        </div>
        <br>
            <div class="gridcontainer">
                <div class="border"></div>
                <div class="profile">
                    <img src="../img/home.png" alt="image" id="circle">
                </div>
                <div class="name">
                    <?php echo "$row_result[Name]"; ?>
                </div>
                <div class="profiledetail">
                    <p id="position"><?php echo "$row_result[Position]"; ?></p>
                    <table>
                       <tr>
                         <td>Email
                         <td>:
                         <td><?php echo "$row_result[Email]"; ?>
                      </tr>
                      <tr>
                          <td>Phone No
                          <td>:
                          <td><?php echo "$row_result[Phone]"; ?>
                      </tr>
                    </table>
                </div>
                <div class="profilebutton1">
                    <a href="editProfile1.php"><input type="button" name="edit" value="Edit" id="userbutton"></a>
                </div>
                <div class="profilebutton2">
                    <form action="homepage.php" method="post">
                    <input type="submit" name="Logout" value="Logout" id="userbutton";>
                      </form>
                </div>

              <?php 
            if(!$_SESSION['pw']==""){  
              if($row_result['Position']=="MANAGEMENT LEVEL") {   ?>
                    <div class="selection1">
                        <a href="./borrowform.php"><input type="button" name="borrowItem" value="Borrow Item" class="button"></a>
                    </div>
                    <div class="selection2">
                          <a href="./viewmyapplication_management.php"><input type="button" name="viewApplication" value="View Application" class="button"></a>
                    </div>
                    <div class="selection3">
                        <a href="./manageInventory.php"><input type="button" name="manageInventory" value="Manage Inventory" class="button"></a>
                    </div>
                    <div class="selection4">
                        <a href="./ReportSystem.php"><input type="button" name="generateReport" value="Generate Report" class="button"></a>
                    </div>
                    <div class="selection5">
                        <a href="./manage_user.php"><input type="button" name="manageUser" value="Manage User" class="button"></a>
                    </div>
              <?php  } else {  ?>
                    <div class="selection1">
                        <a href="./borrowform.php"><input type="button" name="borrowItem" value="Borrow Item" class="button"></a>
                    </div>
                    <div class="selection2">
                        <a href="./viewmyapplication_general.php"><input type="button" name="viewApplication" value="View Application" class="button"></a>
                      </div>
           <?php  } }?>
            </div>
    </body>
</html>

<?php  } } ?>