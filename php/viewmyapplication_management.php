<?php
require_once('dbconfig.php');
session_start();
$uid = $_SESSION['uid'];
//extract data from application table
$sql = "SELECT * FROM `application` WHERE `ApplicantID` = ".$uid;
$result = mysqli_query($db_connection, $sql);
$counter = 1;
?>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="../css/header.css" />
        <link rel="stylesheet" type="text/css" href="../css/viewapplicationpage.css" />
        <script src="../javascript/webpage.js"></script>
        <title>My Application</title>
    </head>
    <body>
        <div class="header">
            <img src="../img/logo.png" alt="Logo">
            <h1>Inventory System</h1>
        </div>
        <div class="refLink">
            <h2> Application Management System</h2>
            <a href="./homepage.php">Home Page</a><p>&nbsp>&nbsp</p><p>Application Management System</p>
        </div>
        <hr>

        <div class="management-sidebar">
            <input type="button" name="viewmyform" value="View My Application" onclick="goto('viewmyapplication_management.php');"/>
            <input type="button" name="manage_member_app" value="Approve / Disapprove Application" onclick="goto('manageapplication.php');"/>
            <input type="button" name="manage_return_app" value="Approve Return Inventory" onclick="goto('returninventory.php');"/>
        </div>

        <div class="myapplist">
            <h2 class="title">My Application List</h2>
            <table>
                <tr>
                    <th>No</th>
                    <th>Application ID</th>
                    <th>Inventory</th>
                    <th>Borrow Date</th>
                    <th>Return Date</th>
                    <th>Approved Date</th>
                    <th>Person-in-charge</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            <?php while($resultrow = mysqli_fetch_assoc($result)){
                $itemid = $resultrow['InventoryID'];
                $borrowdate = $resultrow ['BorrowDate'];
                $returndate =$resultrow['ReturnDate'];
                $appid = $resultrow['ApplicationID'];
                $approveddate = $resultrow['ApprovedDate'];
                $approverid = $resultrow['ApproverID'];
                $status = $resultrow['Status'];
                $buttonname;
                //extract data from item table
                $sqlitem = "SELECT `ItemName` from `inventory` WHERE `InventoryID` = ".$itemid;
                $result_item = mysqli_query($db_connection, $sqlitem);
                $resultrow_item = mysqli_fetch_assoc($result_item);

                $itemname = $resultrow_item['ItemName'];
                $approvername;
                //extract approver name from user table
                if($approverid == NULL){
                    $approvername = "-";
                }else{
                    $sqlapprover = "SELECT `Name` from `user` WHERE `UserID` = ".$approverid;
                    $resultapprover = mysqli_query($db_connection, $sqlapprover);
                    $resultrow_approver = mysqli_fetch_assoc($resultapprover);
                    $approvername = $resultrow_approver['Name'];
                }
                if($status == "PENDING"){
                    $buttonname = "EDIT";
                }else{
                    $buttonname = "VIEW";
                }
            ?>
            <form action="<?php if($buttonname == "EDIT"){
                echo "update_application.php";
            }else{
                echo "view_application.php";
            }
            ?>" method="POST">
                <tr>
                    <input type="hidden" name="appid" value="<?php echo $appid; ?>">
                    <td><?php echo $counter; $counter++; ?></td>
                    <td><?php echo $appid?></td>
                    <td><?php echo $itemname ?></td>
                    <td><?php echo $borrowdate; ?></td>
                    <td><?php echo $returndate; ?></td>
                    <td><?php echo $approveddate?></td>
                    <td><?php echo $approvername; ?></td>
                    <td><?php echo $status ?></td>
                    <td><input type="submit" class="submit" name="submit" value="<?php echo $buttonname; ?>"></td>
                </tr>
            </form>
        <?php } ?>
            </table>
        </div>
    </body>
</html>
