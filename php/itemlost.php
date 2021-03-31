<?php
require_once('./dbconfig.php');
session_start();
$sql="SELECT * FROM user WHERE `UserID` ='".$_SESSION['uid']."'";   // get user name
$result=mysqli_query($db_connection,$sql);
$row_result = mysqli_fetch_assoc($result);
$zero=0;

$date=$_SESSION['report'];   // determine type of report by date

$sqlLost="SELECT * FROM itemreturn WHERE `ItemLoss` >'".$zero."' AND `ReturnDate`>= '".$date."' ORDER BY `ItemID`";
$lossresult=mysqli_query($db_connection,$sqlLost);
$counter=1;

?>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="../css/header.css" />
        <link rel="stylesheet" type="text/css" href="../css/report4.css" />
        <title>Item Loss</title>
    </head>
    <body>
        <div class="header">
            <img src="../img/logo.png" alt="Logo">
            <h1>Inventory System</h1>
        </div>
        <div class="refLink">
            <h2> Report System</h2>
            <a href="./homepage.php">Home Page</a><p>&nbsp>&nbsp</p><a href="./ReportSystem.php">Generate Report</a>
                <p>&nbsp>&nbsp</p><a href="AnnualReport.php">
                  <?php if($date==date('Y')."-01-01")
                      echo "Annual Report";
                  else if($date==date('Y-m')."-01")
                      echo "Monthly Report";
                  else if($date==date('Y-m-d'))
                      echo "Daily Report";
                  ?>
                </a>
                <p>&nbsp>&nbsp</p><a href="itemlost.php">Item Lost</a>
        </div>
        <hr>

        <div><a href="./AnnualReport.php"><input type="button" class="back" value="<< Back"/></a></div>
        <div class=body>
          <p><?php
              if($date==date('Y')."-01-01")
                  echo "DATE RANGE : 01/01/".date('Y')." - ".date('d/m/Y');
              else if($date==date('Y-m')."-01")
                  echo "DATE RANGE : 01/".date('m/Y')." - ".date('d/m/Y');
              else if($date==date('Y-m-d'))
                  echo "DATE RANGE : ".date('d/m/Y');
            ?>
         </p>
          <table>
              <tr>
                  <th style="width:50px" scope="col">No.</th>
                  <th style="width:300px" scope="col">Item</th>
                  <th style="width:300px"scope="col">Borrower</th>
                  <th style="width:100px" scope="col">Loss Amount</th>
                  <th style="width:200px" scope="col">Description</th>
              </tr>
              <?php if(mysqli_num_rows($lossresult)>0){
                  while($row=mysqli_fetch_assoc($lossresult)){ ?>
              <tr>
                  <td><?php echo $counter; $counter++; ?></td>
                  <td><?php
                          $sqlname= "SELECT * FROM inventory WHERE `InventoryID`='".$row['ItemID']."' ";
                          $name=mysqli_query($db_connection,$sqlname);
                          $getname=mysqli_fetch_assoc($name);
                          echo $getname['ItemName'];
                      ?>
                  </td>
                  <?php
                      $sqlitem = "SELECT * FROM itemreturn WHERE `ItemID`='".$row['ItemID']."' AND `ItemLoss` > $zero";
                      $dataquery = mysqli_query($db_connection,$sqlitem);
                      $getNumRow = mysqli_num_rows($dataquery);
                      $loop=0;
                      if($loop<$getNumRow)
                      {
                      ?>
                  <td>
                    <?php
                      $sqlapplication = "SELECT * FROM application WHERE `ApplicationID`='".$row['AppID']."' ";
                      $applicationid = mysqli_query($db_connection,$sqlapplication);
                      $applyID = mysqli_fetch_assoc($applicationid);
                      $sqluser = "SELECT * FROM user WHERE `UserID`='".$applyID['ApplicantID']."' ";
                      $getUserID = mysqli_query($db_connection,$sqluser);
                      $userid = mysqli_fetch_assoc($getUserID);
                      echo $userid['Name']; ?>
                  </td>
                  <td><?php echo $row['ItemLoss']?></td>
                  <td><?php echo $row['LossReason']?></td>
                <?php $loop++; } } ?>
              </tr>
            <?php } else{ ?>
              <tr>
                    <td><?php echo $counter; $counter++; ?></td>
                    <td><?php echo "-"; ?></td>
                    <td><?php echo "-"; ?></td>
                    <td><?php echo "-"; ?></td>
                    <td><?php echo "-"; ?></td>
              </tr>
              <?php } ?>
          </table>
          <div>
               <?php $sqlLost="SELECT * FROM itemreturn WHERE `ItemLoss` >'".$zero."' AND `ReturnDate`>= '".$date."'";
               $lost = mysqli_query($db_connection,$sqlLost);
               $dataRow =mysqli_num_rows($lost);
               $num=0;
               $totalLoss=0;
               if($dataRow>0)
               {
                 while($num<$dataRow){
                   $fetch = mysqli_fetch_assoc($lost);
                   $totalLoss += $fetch['ItemLoss'];
                   $num++;
                 }
                 echo "Total item loses: ".$totalLoss;
               }
               else {
                  echo "Total item loses: ".$zero;
               }
              ?>
          </div>
        </div>
    </body>
</html>
