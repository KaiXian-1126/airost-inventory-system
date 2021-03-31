<script src="../javascript/webpage.js"></script>
<script src="../javascript/date.js"></script>
<script src="../javascript/formvalidation.js"></script>
<?php
require_once("dbconfig.php");
session_start();
$uid = $_SESSION['uid'];

$chkreturnid = "SELECT MAX(ReturnID) FROM `itemreturn`";
$resultrid = mysqli_query($db_connection, $chkreturnid);
$resultrow_rid = mysqli_fetch_assoc($resultrid);
$returnID = $resultrow_rid['MAX(ReturnID)'] + 1;
//extract application info
$appid = $_POST['appid'];
$sql = "SELECT * FROM `application` WHERE `ApplicationID` = ".$appid;
$result = mysqli_query($db_connection, $sql);
$resultrow = mysqli_fetch_assoc($result);

$applicantID = $resultrow['ApplicantID'];
$applieddate = $resultrow['AppliedDate'];
$itemid = $resultrow['InventoryID'];
$quantity = $resultrow['Amount'];
$borrowdate = $resultrow['BorrowDate'];
$returndate = $resultrow['ReturnDate'];
$description = $resultrow['Description'];

//extract applicant name
$sqlapplicant = "SELECT `Name` FROM `user` WHERE `UserID` = ".$applicantID;
$resultapplicant = mysqli_query($db_connection, $sqlapplicant);
$resultrow_applicant = mysqli_fetch_assoc($resultapplicant);
$applicantname = $resultrow_applicant['Name'];

//select item name
$sqlitemname = "SELECT `ItemName`,`ItemAmount`,`BorrowAmount` FROM inventory WHERE `InventoryID` = ".$itemid;
$resultitem = mysqli_query($db_connection, $sqlitemname);
$resultrow_item = mysqli_fetch_assoc($resultitem);

//counter for current borrow out item
$itemname = $resultrow_item['ItemName'];
$amount = $resultrow_item['ItemAmount'];
$borrowamount = $resultrow_item['BorrowAmount'];
$currentAvailable = $amount - $borrowamount;

if(isset($_POST['reason'])){
        $currentdate = $_POST['currentdate'];
        if($_POST['action'] == "Approve"){
        $id = $itemid;
        echo $quantity."<br>";
        $currentborrow = $resultrow_item['BorrowAmount'];
        $borrow = $currentborrow+$quantity;
        $inventoryupdate = "UPDATE `inventory` SET `BorrowAmount`='".$borrow."' WHERE (`InventoryID`='".$id."')";
        $updatequery = mysqli_query($db_connection,$inventoryupdate);

        $updateapplication = "UPDATE `application` SET `ApproverID` = ".$uid.", `Status` = 'APPROVED', `Reason` = '".$_POST['reason']."',
                            `ApprovedDate` = '".$currentdate."'
                            WHERE (`ApplicationID` = ".$_POST['appid'].")";
        $result = mysqli_query($db_connection, $updateapplication);
        $sqlinsert = "INSERT INTO `itemreturn` (`ReturnID`, `AppID`, `ItemLoss`, `ReturnAmount`, `ReturnDate`, `LossReason`, `ItemID`)
        VALUES (".$_POST['rid'].", ".$_POST['appid'].", NULL, NULL, NULL, NULL,".$_POST['itemid'].")";
        $result = mysqli_query($db_connection, $sqlinsert);
        if($result > 0){
            echo "<script>alert('Successfully approved.');</script>";
        }else{
            echo "<script>alert('Failed to approve: Database error.');</script>";
        }
        echo "<script>goto('manageapplication.php');</script>";
    }else if($_POST['action'] == "Reject"){
        $updateapplication = "UPDATE `application` SET `ApproverID` = ".$uid.", `Status` = 'REJECTED', `Reason` = '".$_POST['reason']."', `ApprovedDate` = '".$currentdate."'
                                WHERE (`ApplicationID` = ".$_POST['appid'].")";
        $result = mysqli_query($db_connection, $updateapplication);
        if($result > 0){
            echo "<script>alert('Application rejected.');</script>";
        }else{
            echo "<script>alert('Failed to reject: Database error.');</script>";
        }
        echo "<script>goto('manageapplication.php');</script>";
    }

}else{

?>

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="../css/header.css" />
        <link rel="stylesheet" type="text/css" href="../css/manageapplicationform.css" />
        <title>Application Form</title>
    </head>
    <body>
        <div class="header">
            <img src="../img/logo.png" alt="Logo">
            <h1>Inventory System</h1>
        </div>
        <div class="refLink">
            <h2>Application Management System</h2>
            <a href="./homepage.php">Home Page</a><p>&nbsp>&nbsp</p><a href="manageapplication.php">Application Management System</a>
            <p>&nbsp>&nbsp</p><p>Application Form</p>
        </div>
        <hr>
        <div class="form">
            <input type="button" class="back" value="<< Back" onclick="goto('manageapplication.php');"/>
            <h2>Application Form</h2>
            <form method="POST" action="memberapplicationform.php">
                <div class="grid_container">
                    <input name="rid" type="hidden" value="<?php echo $returnID; ?>">
                    <input name="appid" type="hidden" value="<?php echo $appid; ?>">
                    <input name="applicantid" type="hidden" value="<?php echo $applicantID; ?>">
                    <input name="currentdate" type="hidden" >
                    <script>
                        document.getElementsByName('currentdate')[0].value = getCurrentDate();
                    </script>
                    <p class="name">Applicant name:</p>
                    <input class="name" type="text" name="username" value="<?php echo $applicantname ?>" readonly>
                    
                    <p class="applieddate">Applied date</p>
                    <input class="applieddate" type="text" value="<?php echo $applieddate; ?>" name="applieddate" readonly>

                    <p class="itemborrow">Item wish to borrow:</p>
                    <input class="itemborrow" type="text" value="<?php echo $itemname; ?>" name="itemborrow" readonly>
                    <input class="itemid" type="hidden" value="<?php echo $itemid; ?>" name="itemid" value="1">

                    <p class="quantity">Quantity:</p>
                    <input class="quantity" type="number" min="1" value="<?php echo $quantity; ?>" name="quantity" readonly>

                    <p class="borrowdate">Borrow date:</p>
                    <input class="borrowdate" type="text" value="<?php echo $borrowdate; ?>" name="borrowdate" readonly>

                    <p class="returndate">Return date:</p>
                    <input class="returndate" type="text" value="<?php echo $returndate; ?>" name="returndate" readonly>

                    <p class="description">Description:</p>
                    <textarea class="description" name="description" readonly><?php echo $description; ?></textarea>

                    <p class="currentamount">Item available:</p>
                    <input class="currentamount" type="number" value="<?php echo $currentAvailable; ?>" name="currentamount" readonly>

                    <p class="reason">Reject Reason:</p>
                    <textarea class="reason" name="reason"></textarea>

                    <input class="approve" type="submit" value="Approve" name="action" onclick="return applicationFormValidation();">
                    <input class="reject" type="submit" value="Reject" name="action" onclick="return chkreason();">
                </div>
            </form>
        </div>
    </body>
</html>
<?php } ?>
