<script src="../javascript/webpage.js"></script>
<script src="../javascript/formvalidation.js"></script>
<?php
require_once('dbconfig.php');
if (isset($_POST['applicationid']))  {
  if($_POST['action'] == "update"){
    $sqlupdate="UPDATE `application` SET `Amount`='".$_POST['quantity']."',`BorrowDate`='".$_POST['borrowdate']."',
                `ReturnDate`='".$_POST['returndate']."',`InventoryID`='".$_POST['itemid']."'
                ,`Description`='".$_POST['description']."' WHERE `ApplicationID`=".$_POST['applicationid'];


                $result=mysqli_query($db_connection,$sqlupdate);
                $to="applicationlist.php";
                if ($result>0){
                  //update  Success
                  echo "<script>alert('Your application updated successfully.');</script>";
                }else{
                  //update failure
                  echo "<script>alert('Failed to update application: Database error.');</script>";
                }
                $position = $_POST['position'];
                if ($position == 'MANAGEMENT LEVEL'){
                  echo "<script>goto(\"viewmyapplication_management.php\")</script>";
                }else{
                  echo "<script>goto(\"viewmyapplication_general.php\")</script>";
                }
  }else if($_POST['action'] == "delete"){
    $sqldelete = "DELETE FROM `application` WHERE `ApplicationID` = ".$_POST['applicationid'];
    $result = mysqli_query($db_connection, $sqldelete);
    $position = $_POST['position'];
    if ($result>0){
      //update  Success
      echo "<script>alert('Your application deleted successfully.');</script>";
    }else{
      //update failure
      echo "<script>alert('Failed to delete application: Database error.');</script>";
    }
    if ($position == 'MANAGEMENT LEVEL'){
      echo "<script>goto(\"viewmyapplication_management.php\")</script>";
    }else{
      echo "<script>goto(\"viewmyapplication_general.php\")</script>";
    }
  }else if($_POST['action'] == "search"){
    session_start();
    $_SESSION['tempAppid'] = $_POST["applicationid"];
    $_SESSION['tempPosition'] = $_POST["position"];
    $_SESSION['tempName'] = $_POST["username"];
    $_SESSION['tempAppliedDate'] = $_POST["applieddate"];
    $_SESSION['tempItemName'] = $_POST["item_type"];
    $_SESSION['tempItemid'] = $_POST["itemid"];
    $_SESSION['tempQuantity'] = $_POST["quantity"];
    $_SESSION['tempBorrowDate'] = $_POST["borrowdate"];
    $_SESSION['tempReturnDate'] = $_POST["returndate"];
    $_SESSION['tempDescription'] = $_POST["description"];
    echo "<script>goto('searchinventory.php')</script>";
  }

}else if(isset($_POST['aftersearch'])){ $position = $_POST['position']; ?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../css/header.css" />
    <link rel="stylesheet" type="text/css" href="../css/applicationform_update.css" />
    <title>Application Form</title>
</head>
<body>
    <div class="header">
        <img src="../img/logo.png" alt="Logo">
        <h1>Inventory System</h1>
    </div>
    <div class="refLink">
        <h2> Application Management System</h2>
        <a href="homepage.php">Home Page</a><p>&nbsp>&nbsp</p><a href='<?php 
        if ($position == "MANAGEMENT LEVEL"){
            echo "viewmyapplication_management.php";
          }else{
            echo "viewmyapplication_general.php";
          }
          ?>'>Application Management System</a>
          <p>&nbsp>&nbsp</p><p>Application Form</p>
    </div>
    <hr>
    <div class="form">
        <input type="button" class="back" value="<< Back" onclick='<?php 
        if ($position == 'MANAGEMENT LEVEL'){
            echo "goto(\"viewmyapplication_management.php\")";
          }else{
            echo "goto(\"viewmyapplication_general.php\")";
          }
          
          ?>'/>
        <h2>Application Form</h2>
        <form name="editapplication" action="update_application.php" method="post">
        <div class="grid_container">
            <input type="hidden" name="applicationid" value="<?php echo $_POST["appid"]; ?>">
            <input type="hidden" name="position" value="<?php echo $position; ?>">
            <p class="name">Applicant name:</p>
            <input readonly class="name" type="text" name="username" value="<?php echo $_POST["username"]; ?>">

            <p class="applieddate">Applied date</p>
            <input readonly class="applieddate" type="date" name="applieddate" value="<?php echo $_POST["applieddate"]?>">

            <p class="itemborrow">Item wish to borrow:</p>

            <input type="text" name="item_type" class="itemborrow" value="<?php echo $_POST['item_type'] ?>" readonly/>
            <input type="submit" class="search" value="Search" onclick="searchAction();"/>
            <input type="hidden" name="itemid" value="<?php echo $_POST['itemid']; ?>">
            
            <p class="quantity">Quantity:</p>
            <input class="quantity" type="number" min="1" name="quantity" value="<?php echo $_POST["quantity"]; ?>">
            

            <p class="borrowdate">Borrow date:</p>
            <input class="borrowdate" type="date" name="borrowdate" value="<?php echo $_POST["borrowdate"]; ?>">

            <p class="returndate">Return date:</p>
            <input class="returndate" type="date" name="returndate" value="<?php echo $_POST["returndate"]; ?>">

            <p class="description">Description:</p>
            <textarea class="description" name="description"><?php echo $_POST["description"]; ?></textarea>

            <br>

            <button type="submit" class="update" onclick="updateAction();">Update</button>
            <button type="submit" class="delete" onclick="deleteAction()">Delete</button>
            <input type="hidden" name="action">
        </div>
        </form>
      </div>
      </body>
</html>

<?php }
else{
  $applicationid=$_POST['appid'];
  $sql="SELECT * FROM `application` WHERE (`ApplicationID`='".$applicationid."')";
  $result=mysqli_query($db_connection,$sql);
  $row=mysqli_fetch_assoc($result);
 
  $sql1="SELECT * FROM `user` WHERE (`UserID`='".$row['ApplicantID']."')";
  $result1=mysqli_query($db_connection,$sql1);
  $row1=mysqli_fetch_assoc($result1);
  $position = $row1['Position'];

  $sql2="SELECT * FROM `inventory`";
  $result2=mysqli_query($db_connection,$sql2);

  $sql3="SELECT * FROM  `inventory` WHERE (`InventoryID`='".$row['InventoryID']."')";
  $result3=mysqli_query($db_connection,$sql3);
  $row3=mysqli_fetch_assoc($result3);
?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../css/header.css" />
    <link rel="stylesheet" type="text/css" href="../css/applicationform_update.css" />
    <title>Application Form</title>
</head>
<body>
    <div class="header">
        <img src="../img/logo.png" alt="Logo">
        <h1>Inventory System</h1>
    </div>
    <div class="refLink">
        <h2> Application Management System</h2>
        <a href="homepage.php">Home Page</a><p>&nbsp>&nbsp</p><a href='<?php 
        if ($position == "MANAGEMENT LEVEL"){
            echo "viewmyapplication_management.php";
          }else{
            echo "viewmyapplication_general.php";
          }
          ?>'>Application Management System</a>
          <p>&nbsp>&nbsp</p><p>Application Form</p>
    </div>
    <hr>
    <div class="form">
        <input type="button" class="back" value="<< Back" onclick='<?php 
        if ($position == 'MANAGEMENT LEVEL'){
            echo "goto(\"viewmyapplication_management.php\")";
          }else{
            echo "goto(\"viewmyapplication_general.php\")";
          }
          
          ?>'/>
        <h2>Application Form</h2>
        <form name="editapplication" action="update_application.php" method="post">
        <div class="grid_container">
            <input type="hidden" name="applicationid" value="<?php echo $row["ApplicationID"]?>">
            <input type="hidden" name="position" value="<?php echo $position; ?>"">
            <p class="name">Applicant name:</p>
            <input readonly class="name" type="text" name="username" value="<?php echo $row1["Name"]; ?>">

            <p class="applieddate">Applied date</p>
            <input readonly class="applieddate" type="date" name="applieddate" value="<?php echo $row["AppliedDate"]?>">

            <p class="itemborrow">Item wish to borrow:</p>

            <input type="text" name="item_type" class="itemborrow" value="<?php echo $row3['ItemName']; ?>" readonly/>
            <input type="submit" class="search" value="Search" onclick="searchAction();"/>
            <input type="hidden" name="itemid" value="<?php echo $row['InventoryID']; ?>">
            
            <p class="quantity">Quantity:</p>
            <input class="quantity" type="number" min="1" name="quantity" value="<?php echo $row["Amount"]; ?>">
            

            <p class="borrowdate">Borrow date:</p>
            <input class="borrowdate" type="date" name="borrowdate" value="<?php echo $row["BorrowDate"]; ?>">

            <p class="returndate">Return date:</p>
            <input class="returndate" type="date" name="returndate" value="<?php echo $row["ReturnDate"]; ?>">

            <p class="description">Description:</p>
            <textarea class="description" name="description"><?php echo $row["Description"]; ?></textarea>

            <br>

            <button type="submit" class="update" onclick="updateAction();">Update</button>
            <button type="submit" class="delete" onclick="deleteAction()">Delete</button>
            <input type="hidden" name="action">
        </div>
        </form>
      </div>
</body>
</html>
<?php } ?>