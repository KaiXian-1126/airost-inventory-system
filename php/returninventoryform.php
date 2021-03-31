<?php
require_once('dbconfig.php');
$returnid = $_POST['returnid'];
//read data from itemreturn table
$sql = "SELECT * FROM `itemreturn` WHERE `ReturnID` = ".$returnid;
$result = mysqli_query($db_connection, $sql);
$result_row = mysqli_fetch_assoc($result);

if(isset($_POST['date'])){
    $returnid = $_POST['returnid'];
    $returnamount = $_POST['returnamount'];
    $lossamount = $_POST['loss'];
    $lossreason = $_POST['lossreason'];
    $validreturndate = $_POST['date'];
    $sqlupdate = "UPDATE `itemreturn` SET `ItemLoss`=".$lossamount.", `ReturnAmount`=".$returnamount.",
    `ReturnDate`='".$validreturndate."', `LossReason`='".$lossreason."'
    WHERE (`ReturnID`=".$returnid.")";
    $result = mysqli_query($db_connection, $sqlupdate);
    $id= $result_row['ItemID']."<br>";
    $inventorysql = "SELECT * FROM inventory WHERE `InventoryID`=".$result_row['ItemID'];
    $inventoryquery = mysqli_query($db_connection,$inventorysql);
    $getinventory = mysqli_fetch_assoc($inventoryquery);
    $borrowed = $getinventory['BorrowAmount']-$returnamount-$lossamount;
    $totalAmount = $getinventory['ItemAmount']-$lossamount;
    $inventoryupdate = "UPDATE `inventory` SET `ItemAmount`='".$totalAmount."', `BorrowAmount`='".$borrowed."' WHERE (`InventoryID`='".$id."')";
    $updatequery = mysqli_query($db_connection,$inventoryupdate);
  
    if($result > 0){
        echo "<script>alert('Return Form Approved.');</script>";
    }else{
        echo "<script>alert(".$sqlupdate.");</script>";
        echo "<script>alert('Unsuccessful Operation: Database Error.');</script>";
    }
    echo "<script>window.location = './returninventory.php'</script>";
}else{
    //read data from application table
    //$appid = $result_row('AppID');
    $sqlapp = "SELECT * FROM `itemreturn`
        INNER JOIN `application` ON `itemreturn`.`appid` = `application`.`ApplicationID`
        WHERE `ReturnID` = ".$returnid;
    $resultapp = mysqli_query($db_connection, $sqlapp);
    $resultrow_app = mysqli_fetch_assoc($resultapp);

    //information in application table
    $applicantid = $resultrow_app['ApplicantID'];
    $applieddate = $resultrow_app['AppliedDate'];
    $itemid = $resultrow_app['InventoryID'];
    $quantity = $resultrow_app['Amount'];
    $borrowdate = $resultrow_app['BorrowDate'];
    $returndate = $resultrow_app['ReturnDate'];
    $description = $resultrow_app['Description'];
    $approverid = $resultrow_app['ApproverID'];
    $approveddate = $resultrow_app['ApprovedDate'];

    //read data from user table
    $sqlapplicant = "SELECT `user`.`Name` FROM `application`
                    INNER JOIN `user` ON `application`.`ApplicantID` = `user`.`UserID`
                    WHERE `application`.`ApplicantID` = ".$applicantid;
    $sqlapprover = "SELECT `user`.`Name` FROM `application`
                    INNER JOIN `user` ON `application`.`ApproverID` = `user`.`UserID`
                    WHERE `application`.`ApproverID` = ".$approverid;
    $resultapplicant = mysqli_query($db_connection, $sqlapplicant);
    $resultapprover = mysqli_query($db_connection, $sqlapprover);
    $resultrow_applicant = mysqli_fetch_assoc($resultapplicant);
    $resultrow_approver = mysqli_fetch_assoc($resultapprover);

    //information in user table
    $applicantname = $resultrow_applicant['Name'];
    $approvername = $resultrow_approver['Name'];

    //read data from inventory table
    $sqlinventory = "SELECT * FROM `application`
                    INNER JOIN `inventory` ON `application`.`InventoryID` = `inventory`.`InventoryID`
                    WHERE `application`.`InventoryID` = ".$itemid;
    $resultitem = mysqli_query($db_connection, $sqlinventory);
    $resultrow_item = mysqli_fetch_assoc($resultitem);

    //information in inventory table
    $itemname = $resultrow_item['ItemName'];

?>
<html>
<head>
    <title>Return Inventory Form</title>
    <link rel="stylesheet" type="text/css" href="../css/header.css" />
    <link rel="stylesheet" type="text/css" href="../css/returninventoryform.css"/>
    <script src="../javascript/date.js"></script>
    <script src="../javascript/formvalidation.js"></script>
    <script src="../javascript/calculation.js"></script>
    <script src="../javascript/webpage.js"></script>
</head>
<body>
    <div class="header">
        <img src="../img/logo.png" alt="Logo">
        <h1>Inventory System</h1>
    </div>
    <div class="refLink">
        <h2> Application Management System</h2>
        <a href="./homepage.php">Home Page</a>
        <p>&nbsp>&nbsp</p><a href="returninventory.php">Application Management System</a>
        <p>&nbsp>&nbsp</p><p>Return Inventory Form</p>
    </div>
    <hr>
    <div class="form">
        <input type="button" class="back" value="<< Back" onclick="goto('returninventory.php');"/>
        <h2>Return Inventory Form</h2>
        <form method="POST" action="returninventoryform.php" onsubmit="return returnFormValidation();">
            <div class="grid_container">
                <input type="hidden" name="returnid" value="<?php echo $returnid; ?>">
                <p class="name">Applicant name:</p>
                <input class="name" type="text" name="username" value="<?php echo $applicantname; ?>" readonly>

                <p class="applieddate">Applied date</p>
                <input class="applieddate" type="text" name="applieddate" value="<?php echo $applieddate; ?>" readonly>

                <p class="itemborrow">Borrowed item:</p>
                <input class="itemborrow" type="text" name="itemborrow" value="<?php echo $itemname; ?>" readonly>

                <p class="quantity">Quantity:</p>
                <input class="quantity" type="number" min="1" value="<?php echo $quantity; ?>" name="quantity" readonly>

                <p class="borrowdate">Borrow date:</p>
                <input class="borrowdate" type="text" name="borrowdate" value="<?php echo $borrowdate; ?>" readonly>

                <p class="returndate">Return date:</p>
                <input class="returndate" type="text" name="returndate" value="<?php echo $returndate; ?>" readonly>

                <p class="description">Description:</p>
                <textarea cols="30" rows="5" class="description" name="description" readonly><?php echo $description; ?></textarea>

                <p class="approver">Approver:</p>
                <input type="text" class="approver" name="approver" value="<?php echo $approvername; ?>" readonly>

                <p class="approveddate">Approved on:</p>
                <input type="text" class="approveddate" name="approveddate" value="<?php echo $approveddate; ?>" readonly>

                <p class="returnamount">Return amount:</p>
                <input type="number" class="returnamount" name="returnamount" min="0" max="<?php echo $quantity; ?>" value="0" onchange="calculateLoss();">

                <p class="loss">Loss amount</p>
                <input type="number" class="loss" name="loss" min="0" value="0" onchange="calculateLoss();">

                <p class="lossreason">Item loss reason:</p>
                <textarea cols="30" rows="5" name="lossreason" class="lossreason"></textarea>

                <p class="date">Date validate return form:</p>
                <input type="text" class="date" name="date" readonly>
                <script>
                    document.getElementsByName('date')[0].value = getCurrentDate();
                </script>
                <input class="submit" type="submit" value="Approve">
            </div>
        </form>
    </div>
</body>
</html>
<?php } ?>
