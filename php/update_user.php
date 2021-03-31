<?php
require_once('dbconfig.php');
$id = $_POST['userid'];
$name=$_POST['name'];
$email =$_POST['email'];
$phone =$_POST['phone'];
$position =$_POST['position'];
$user_id=$_POST['id'];

foreach($id as $key=>$userid ){
  $sqlupdate="UPDATE `user` SET `UserID` = $userid, `Name`='".$name[$key]."'
  , `Email` ='".$email[$key]."', `Phone` ='".$phone[$key]."',
  `Position` ='".$position[$key]."' WHERE `UserID` = ".$user_id[$key];

  $result=mysqli_query($db_connection,$sqlupdate);
}
// exit;
$to="manage_user.php";
if ($result>0){
  //delete  Success
$msg="Update was Success";
}else{
  //delete failure
  $msg="Update is not successful";
}
goto2($to,$msg);

 ?>
