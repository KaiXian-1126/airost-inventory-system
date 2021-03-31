<?php

require_once('dbconfig.php');

$sqlchkrow="select max(InventoryID) as m from inventory";
$result=mysqli_query($db_connection,$sqlchkrow);
$row=mysqli_fetch_assoc($result);
$maxval=$row['m']+1;

$insertsql="INSERT INTO `inventory` (`InventoryID`)
		VALUES ('".$maxval."')";

    $result1=mysqli_query($db_connection,$insertsql);
    $to="editInventory.php";

    echo "<script language=\"JavaScript\"> window.location = \"".$to."\"</script>";
?>
