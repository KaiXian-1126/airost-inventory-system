<?php
require_once('dbconfig.php');
$qty = $_POST['qty'];
$name=$_POST['name'];
$id =$_POST['inventory_id'];
$brrwqty=$_POST['brrwqty'];
// print_r($name);exit;
foreach($qty as $key=>$item_amount ){
  // UPDATE `inventory` SET `ItemAmount`=$item_amount WHERE (`InventoryID`= $id);
  $sqlupdate="UPDATE `inventory` SET `ItemAmount` = $item_amount, `ItemName`='".$name[$key]."',`BorrowAmount`='".$brrwqty[$key]."' WHERE `InventoryID` = ".$id[$key];

  $result=mysqli_query($db_connection,$sqlupdate);
}
// exit;
$to="manageInventory.php";
if ($result>0){
  //delete  Success
$msg="Update was Success";
}else{
  //delete failure
  $msg="Update is not successful";
}
goto2($to,$msg);

 ?>
