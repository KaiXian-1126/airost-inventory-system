<script src="../javascript/webpage.js"></script>
<?php

require_once("dbconfig.php");
          $applicationid=$_POST['appid'];
          $sql="SELECT * FROM `application` WHERE (`ApplicationID`='".$applicationid."')";
          $result=mysqli_query($db_connection,$sql);
          $row=mysqli_fetch_assoc($result);

          $sql1="SELECT * FROM `user` WHERE (`UserID`='".$row['ApplicantID']."')";
          $result1=mysqli_query($db_connection,$sql1);
          $row1=mysqli_fetch_assoc($result1);
          $position = $row1['Position'];

          $sql2="SELECT * FROM `inventory` WHERE(`InventoryID`='".$row['InventoryID']."')";
          $result2=mysqli_query($db_connection,$sql2);
          $row2=mysqli_fetch_assoc($result2);

          $sql3="SELECT * FROM `user` WHERE (`UserID`='".$row['ApproverID']."')";
          $result3=mysqli_query($db_connection,$sql3);
          $row3=mysqli_fetch_assoc($result3);

?>


<head>
    <link rel="stylesheet" type="text/css" href="../css/header.css" />
    <link rel="stylesheet" type="text/css" href="../css/applicationform_view.css" />
    <title>Application Form</title>
</head>

    <div class="header">
        <img src="../img/logo.png" alt="Logo">
        <h1>Inventory System</h1>
    </div>
    <div class="refLink">
        <h2> Application Management System</h2>
        <a href="./homepage.php">Home Page</a><p>&nbsp>&nbsp</p><a href='<?php 
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

        <h2>Application Form</h2>
        <form name="editapplication">
        <input type="button" class="back" value="<< Back" onclick='<?php 
        if ($position == 'MANAGEMENT LEVEL'){
            echo "goto(\"viewmyapplication_management.php\")";
          }else{
            echo "goto(\"viewmyapplication_general.php\")";
          }
          
          ?>'/>
        <div class="grid_container">
            <input type="hidden" name="applicationid" value="<?php echo $row["ApplicationID"]?>">
            <input type="hidden" name="position" value="<?php echo $position; ?>"">
            <p class="name">Applicant name:</p>
            <input readonly class="name" type="text" name="username" value="<?php echo $row1["Name"]?>">

            <p class="applieddate">Applied date</p>
            <input readonly class="applieddate" type="date" name="applieddate" value="<?php echo $row["AppliedDate"]?>">

            <p class="itemborrow">Item wish to borrow:</p>
            <input  readonly class="itemborrow" type="text" name="itemborrow" value="<?php echo $row2["ItemName"] ?>">


            <p class="quantity">Quantity:</p>
            <input readonly class="quantity" type="number" min="1" name="quantity" value="<?php echo $row["Amount"]?>">

            <p class="borrowdate">Borrow date:</p>
            <input readonly class="borrowdate" type="date" name="borrowdate" value="<?php echo $row["BorrowDate"]?>">

            <p class="returndate">Return date:</p>
            <input readonly class="returndate" type="date" name="returndate" value="<?php echo $row["ReturnDate"]?>">

            <p class="description">Description:</p>
            <textarea readonly class="description" name="description"><?php echo $row["Description"]?></textarea>

            <p class="status">Status:</p>
            <input readonly class="status" type="text" name="status" value="<?php echo $row["Status"]?>">

            <p class="personincharge">Person-in-charge:</p>
            <input readonly class="personincharge" type="text" name="personincharge" value="<?php echo $row3["Name"]?>">

            <p class="approveddate">Approved Date:</p>
            <input readonly class="approveddate" type="date" name="approveddate" value="<?php echo $row["ApprovedDate"]?>">

            <p class="reason">Reason:</p>
            <textarea readonly class="reason" name="reason" "><?php echo $row["Reason"]?></textarea>
          </form>
        </div>
      </div>
