<?php

require_once('dbconfig.php');
$vid=$_GET['inventoryid'];

$sqldelete="DELETE FROM `inventory` WHERE `InventoryID` ='$vid'";

$result=mysqli_query($db_connection,$sqldelete);
$to="editInventory.php";
if ($result>0){
  //delete  Success
$msg="Delete was Success";
}else{
  //delete failure
  $msg="Delete is not successful";
}
goto2($to,$msg);
 ?>
