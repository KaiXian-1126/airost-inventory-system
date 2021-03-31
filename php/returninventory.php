<?php
require_once('dbconfig.php');
$counter = 1;
$sql = "SELECT * FROM `itemreturn`";
$result = mysqli_query($db_connection, $sql);
$linkedpage;
$status;

?>
<html>
    <head>
        <title>Return Inventory List</title>
        <link rel="stylesheet" type="text/css" href="../css/header.css"/>
        <link rel="stylesheet" type="text/css" href="../css/returninventorypage.css"/>
        <script src="../javascript/webpage.js"></script>
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
        <div class="returnlist">
            <h2 class="title">Return Inventory List</h2>
            <table>
                <tr>
                    <th>
                        <p>No</p>
                    </th>
                    <th>
                        <p>Application ID</p>
                    </th>
                    <th>
                        <p>Applicant</p>
                    </th>
                    <th>
                        <p>Approved Date</p>
                    </th>
                    <th>
                        <p>Borrow Date Range</p>
                    </th>
                    <th>
                        <p>Approver</p>
                    </th>
                    <th>
                        <p>Status</p>
                    </th>
                </tr>
                <?php while($result_row = mysqli_fetch_assoc($result)){
                    $appid = $result_row['AppID'];
                    if($result_row['ReturnAmount'] == NULL){
                        $status = "ON BORROW";
                        $linkedpage = "returninventoryform.php";
                    }else{
                        $status = "RETURNED";
                        $linkedpage = "viewreturnform.php";
                    }

                ?>
                <tr>
                    <form action="<?php echo $linkedpage; ?>" method="POST">
                    <td><?php echo $counter; ?></td>
                    <td><?php echo $appid; ?></td>
                    <?php




                        $sqluser = "SELECT `user`.`Name` FROM `application` INNER JOIN `user`
                        ON `application`.`ApplicantID` = `user`.`UserID` WHERE `ApplicationID` = ".$appid;
                        $sqlapprover = "SELECT `user`.`Name` FROM `application` INNER JOIN `user`
                        ON `application`.`ApproverID` = `user`.`UserID` WHERE `ApplicationID` = ".$appid;
                        $sqldate = "SELECT `AppliedDate`,`BorrowDate`, `ReturnDate`, `ApprovedDate` FROM `application` WHERE `ApplicationID` = ".$appid;
                        $resultuser = mysqli_query($db_connection, $sqluser);
                        $resultapprover = mysqli_query($db_connection, $sqlapprover);
                        $resultdate = mysqli_query($db_connection, $sqldate);
                        $resultrow_user = mysqli_fetch_assoc($resultuser);
                        $resultrow_approver = mysqli_fetch_assoc($resultapprover);
                        $resultrow_date = mysqli_fetch_assoc($resultdate);
                        $applicant = $resultrow_user['Name'];
                        $approveddate = $resultrow_date['ApprovedDate'];
                        $borrowdate = $resultrow_date['BorrowDate'];
                        $returndate = $resultrow_date['ReturnDate'];
                        $approver = $resultrow_approver['Name'];
                    ?>
                    <input type="hidden" name="returnid" value="<?php echo $result_row['ReturnID']; ?>">
                    <td><?php echo $applicant; ?></td>
                    <td><?php echo $approveddate; ?></td>
                    <td><?php echo $borrowdate." to ".$returndate; ?></td>
                    <td><?php echo $approver ?></td>
                    <td><input class="button" type="submit" value="<?php echo $status ?>"></td>
                    </form>
                </tr>
                <?php $counter += 1; }  ?>

            </table>
        </div>
    </body>
<html>
