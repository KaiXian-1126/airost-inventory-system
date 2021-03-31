<?php
require_once('dbconfig.php');
session_start();
$uid = $_SESSION['uid'];
$sql='SELECT * FROM `application`WHERE `ApplicantID`='.$uid;
$result=mysqli_query($db_connection,$sql);
$num_row=mysqli_num_rows($result);

$counter=1;
?>

    <head>
        <link rel="stylesheet" type="text/css" href="../css/header.css" />
        <link rel="stylesheet" type="text/css" href="../css/applicationlist.css" />

    </head>
    <body>
        <div class="header">
            <img src="../img/logo.png" alt="Logo">
            <h1>Inventory System</h1>
        </div>
        <div class="refLink">
            <h2> Application Management System</h2>
            <hr>
            <a href="homepage.php">Home Page</a><p>&nbsp>&nbsp</p><a href="viewapplication.html">Application Form</a>
        </div>
        <div class = "form2">
            <a href ="applicationlist.php"><input type="button" class="ViewMyApp" value="View My Application"/></a><br>
            <a href ="requestlist.html"><input type="button" class="AppStatus" value="Approve/Disapprove Application"/></a><br>
            <a href ="inventorystatus.html">  <input type="button" class="InventoryStatus" value="Approve/Disapprove Return Inventory"/></a><br>

        <h1 class="title">My application list</h1>
        </div>
        <table class="applicationlist" style="width:70%; background-color:#C4E1F1; margin:auto; margin-bottom:200px;">
          <tr>
            <th style="width:10%;">No</th>
            <th style="width:10%;">ApplicationID</th>
            <th style="width:20%;">ApproveDate</th>
            <th style="width:10%;">ApproverID</th>
            <th style="width:20%;">Status</th>
            <th style="width:20%;"></th>
          </tr>

          <?php while($row=mysqli_fetch_assoc($result)){
            $sql3="SELECT * FROM `user` WHERE `UserID`=".$uid;
            $result3=mysqli_query($db_connection,$sql3);
            $row3=mysqli_fetch_assoc($result3); ?>
          <tr>
          <td><?php echo $counter; $counter++; ?></td>
          <td><?php echo $row['ApplicationID'];?></td>
          <td><?php echo $row['ApprovedDate'];?></td>
          <td><?php echo $row3['Name'];?></td>
            <?php if($row['ApproverID']=="0") { ?>
              <td style="color:yellow;">Pending</td>
              <td><a href="update_application.php?applicationid=<?php echo $row['ApplicationID'];?>">Edit</a></td>
            <?php }

            elseif($row['Reason']=="") { ?>
              <td style="color:green;">Approved</td>
                <td><a href="view_application.php?applicationid=<?php echo $row['ApplicationID'];?>">View</a></td>
            <?php }

            else{ ?>
              <td style="color:red;">Rejected</td>
              <td><a href="view_application.php?applicationid=<?php echo $row['ApplicationID'];?>">View</a></td>
            <?php } ?>

          </tr>
          <?php } ?>

        </table>
