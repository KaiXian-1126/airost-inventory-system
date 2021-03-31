<?php
require_once('dbconfig.php');
session_start();
$uid = $_SESSION['uid'];
//extract data from application table
$sql = "SELECT * FROM `application` WHERE `Status` = 'PENDING'";
$result = mysqli_query($db_connection, $sql);
$counter = 1;
?>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="../css/header.css" />
        <link rel="stylesheet" type="text/css" href="../css/manageapplicationpage.css" />

        <script src="../javascript/webpage.js"></script>
        <title>Application Request List</title>
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

        <div class="memberapp">
            <h2 class="title">Member Request List</h2>
            <table>
                <tr>
                    <th>No</th>
                    <th>Application ID</th>
                    <th>Applied Date</th>
                    <th>Applicant</th>
                    <th>Action</th>
                </tr>
            <?php while($resultrow = mysqli_fetch_assoc($result)){
                $appid = $resultrow['ApplicationID'];
                $applieddate = $resultrow ['AppliedDate'];
                $applicantid = $resultrow['ApplicantID'];
                $buttonname = "Click";
                $approvername;
                //extract approver name from user table
                $sqlapplicant = "SELECT `Name` from `user` WHERE `UserID` = ".$applicantid;
                $resultapplicant = mysqli_query($db_connection, $sqlapplicant);
                $resultrow_applicant = mysqli_fetch_assoc($resultapplicant);
                $applicantname = $resultrow_applicant['Name'];

            ?>
            <form action="memberapplicationform.php" method="POST">
                <tr>
                    <input type="hidden" name="appid" value="<?php echo $appid; ?>">
                    <td><?php echo $counter; $counter++; ?></td>
                    <td><?php echo $appid?></td>
                    <td><?php echo $applieddate; ?></td>
                    <td><?php echo $applicantname; ?></td>
                    <td><input type="submit" class="submit" name="submit" value="<?php echo $buttonname; ?>"></td>
                </tr>
            </form>
        <?php } ?>
            </table>
        </div>
    </body>
</html>
