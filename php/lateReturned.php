<?php
require_once('./dbconfig.php');
session_start();

 $date=$_SESSION['report'];
$user ="";

$sqlLate="SELECT application.`ReturnDate`, application.`ApplicationID`,application.`Status`,application.`ApplicantID`,itemreturn.`AppID`,itemreturn.`ReturnDate`
          FROM application, itemreturn
          WHERE application.`ApplicationID` = itemreturn.`AppID` And application.`Status` ='APPROVED' AND itemreturn.`ReturnDate`>='".$date."'
          ORDER BY `ApplicantID`";
$lateresult=mysqli_query($db_connection,$sqlLate);
$numrow = mysqli_num_rows($lateresult);

$counter=1;
$zero=0;
?>

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="../css/header.css" />
        <link rel="stylesheet" type="text/css" href="../css/report4.css" />
        <title>Late Return</title>
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
                <p>&nbsp>&nbsp</p><a href="lateReturned.php">Late Return</a>
        </div>
        <hr>

        <div><a href="./AnnualReport.php"><input type="button" class="back" value="<< Back"/></a></div>
        <div class=body>
          <p><?php if($date==date('Y')."-01-01")
              echo "DATE RANGE : 01/01/".date('Y')." - ".date('d/m/Y');
          else if($date==date('Y-m')."-01")
              echo "DATE RANGE : 01/".date('m/Y')." - ".date('d/m/Y');
          else if($date==date('Y-m-d'))
              echo "DATE RANGE : ".date('d/m/Y'); ?> </p>
          <table>
              <tr>
                  <th style="width:50px" scope="col">No.</th>
                  <th style="width:300px"scope="col">Borrower</th>
                  <th style="width:300px"scope="col">Late Return Case</th>
              </tr>
              <?php while($row=mysqli_fetch_assoc($lateresult)){
                  if($row['ApplicantID']==$user){   // continue when similater user
                    continue;
                  }
                  $user=$row['ApplicantID'];
                  $sqlLate2="SELECT application.`ReturnDate`, application.`ApplicationID`,application.`Status`,application.`ApplicantID`,itemreturn.`AppID`,itemreturn.`ReturnDate`
                            FROM application, itemreturn
                            WHERE application.`ApplicationID` = itemreturn.`AppID` And application.`Status` ='APPROVED' AND itemreturn.`ReturnDate` >=application.`ReturnDate`
                            AND itemreturn.`ReturnDate`>='".$date."' AND application.`ApplicantID`= '".$user."'
                            ORDER BY `ApplicantID`";
                  $lateresult2=mysqli_query($db_connection,$sqlLate2);
                  $numrow = mysqli_num_rows($lateresult2);
                  if($numrow>0){
                ?>
              <tr>
                  <td><?php echo $counter; $counter++; ?></td>
                  <td><?php
                      $namesql = "SELECT * FROM user WHERE `UserID` = ".$row['ApplicantID'];
                      $namequery = mysqli_query($db_connection,$namesql);
                      $name = mysqli_fetch_assoc($namequery);
                      echo $name['Name'];
                      ?>
                  </td>
                  <td><?php

                      echo $numrow;
                    ?>
                  </td>
              </tr>
            <?php  }
            else{  ?>
              <tr>
                    <td><?php echo $counter; $counter++; ?></td>
                    <td><?php echo "-"; ?></td>
                    <td><?php echo "-"; ?></td>
              </tr>
          <?php }} ?>
          </table>
          <div ><?php
                $latesql = "SELECT *from itemreturn inner join application on itemreturn.AppID=application.ApplicationID   where itemreturn.ReturnDate >=application.ReturnDate and application.`Status`='approved' and itemreturn.ReturnDate >= '".$date."'";
                $late=mysqli_query($db_connection,$latesql);
                $latenum = mysqli_num_rows($late);
                if($latenum>0){
                    echo "Total item late return case: ".$latenum;
                }
                else {
                    echo "Total item late return case: ".$zero;
                }
              ?>
          </div>
        </div>
    </body>
</html>
