<?php
require_once("./dbconfig.php");
session_start();
$sql="SELECT * FROM user WHERE `UserID` ='".$_SESSION['uid']."'";
$result=mysqli_query($db_connection,$sql);
$row_result = mysqli_fetch_assoc($result);

$sqlrow="select max(ReportID) as m from report";  //get max row
$result=mysqli_query($db_connection,$sqlrow);
$row=mysqli_fetch_assoc($result);
$maxval=$row['m'];

$date=date('Y-m-d');    //get date

$check = "SELECT * FROM report WHERE `DateGenerated`='".$date."' AND `UserID`='".$row_result['UserID']."'";   // check variable
$dateresult=mysqli_query($db_connection,$check);

if(isset($_POST['Annualreport']))
{

    $annual=date('Y')."-01-01";
    $_SESSION['report']=$annual;

    if(mysqli_num_rows($dateresult)>0){
       echo'<script>window.location="./AnnualReport.php"</script>';
    }
    else{
        $maxval=$maxval+1;
        $insertsql="INSERT INTO `report` (`ReportID`, `DateGenerated`, `UserID`) VALUES ('".$maxval."', '".$date."' , '".$row_result['UserID']."')";
        $result=mysqli_query($db_connection,$insertsql);
        echo'<script>window.location="./AnnualReport.php"</script>';
    }
}
else if(isset($_POST['Monthlyreport']))
{
    $monthly=date('Y-m')."-01";
    $_SESSION['report']=$monthly;

    if(mysqli_num_rows($dateresult)>0){
        echo'<script>window.location="./AnnualReport.php"</script>';
    }
    else{
        $maxval=$maxval+1;
        $insertsql="INSERT INTO `report` (`ReportID`, `DateGenerated`, `UserID`) VALUES ('".$maxval."', '".$date."' , '".$row_result['UserID']."')";
        $result=mysqli_query($db_connection,$insertsql);
        echo'<script>window.location="./AnnualReport.php"</script>';
    }
}
else if(isset($_POST['Dailyreport']))
{
    $daily=date('Y-m-d');
    $_SESSION['report']=$daily;

    if(mysqli_num_rows($dateresult)>0)
    {
        echo'<script>window.location="./AnnualReport.php"</script>';
    }
    else{
        $insertsql="INSERT INTO `report` (`ReportID`, `DateGenerated`, `UserID`) VALUES ('".$maxval."', '".$date."' , '".$row_result['UserID']."')";
        $result=mysqli_query($db_connection,$insertsql);
        echo'<script>window.location="./AnnualReport.php"</script>';
    }
}
else{
?>

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="../css/header.css" />
        <link rel="stylesheet" type="text/css" href="../css/ReportSystem1.css" />
        <title>Generate Report</title>
    </head>
    <body>
        <div class="header">
            <img src="../img/logo.png" alt="Logo">
            <h1>Inventory System</h1>
        </div>
        <div class="refLink">
            <h2>Report System</h2>
            <a href="./homepage.php">Home Page</a><p>&nbsp>&nbsp</p><p>Report System</p>
        </div>
        <hr>
        <div class="body">
            <form action="ReportSystem.php" method="post">
                <input type="submit" name="Annualreport" class="report" value="Annual Report"/>
                <br>
                <input type="submit"  name="Monthlyreport" class="report" value="Monthly Report"/></a>
                <br>
                <input type="submit" name="Dailyreport" class="report" value="Daily Report"/></a>
                <br>
          </form>
              <a href="./homepage.php"><input type="button" name="report" class="back" value="<< Back"/></a>
        </div>
    </body>
</html>

<?php } ?>
