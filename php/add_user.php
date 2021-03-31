<?php

require_once('dbconfig.php');

$sqlchkrow="select max(UserID) as m from user";
$result=mysqli_query($db_connection,$sqlchkrow);
$row=mysqli_fetch_assoc($result);
$maxval=$row['m']+1;

$insertsql="INSERT INTO `user` (`UserID`)
		VALUES ('".$maxval."')";

    $result1=mysqli_query($db_connection,$insertsql);
    $to="edit_user.php";

    echo "<script language=\"JavaScript\"> window.location = \"".$to."\"</script>";
?>
