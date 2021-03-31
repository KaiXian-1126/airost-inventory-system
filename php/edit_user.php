<?php
require_once('dbconfig.php');
$sql='SELECT * FROM `user`';
$result=mysqli_query($db_connection,$sql);
$num_row=mysqli_num_rows($result);
$counter=1;
?>
<head>
<link id="pagestyle" rel="stylesheet" type="text/css" href="../css/style5.css"/>
<title>Edit User</title>
</head>


<body>

  <div class="header">
  <img src="../img/logo.png">
  <h1>Inventory System</h1>
  </div>

  <div class="header2">
  <h2>User Management System</h2>
  <div class="refLink">
  <a href="./homepage.php">Home Page</a><p>></p><a href="manage_user.php">User Management System</a>
          <p>></p><p>Edit User</p>
  </div>
  </div>
  <hr>
  <div class="header3">
    <p id="dat"></p>
  </div>




  <div class="table">
    <form name="UserList" action="update_user.php" method="POST">
      <table id="User_table">
        <tr>
          <th style="width:5%;">No</th>
          <th style="width:10%;">UserID</th>
          <th style="width:22%;">Name</th>
          <th style="width:17%;">Email</th>
          <th style="width:17%;">Phone</th>
          <th style="width:12%;">Position</th>
        </tr>
        <?php while($row=mysqli_fetch_assoc($result)){?>
        <tr>
        <td><?php echo $counter++;?></td>
        <input type="hidden" value="<?php echo $row['UserID'];?>" name="id[]">
        <td><input type="text" value="<?php echo $row['UserID'];?>" name="userid[]"></td>
        <td><input type="text" value="<?php echo $row['Name'];?>" name="name[]"></td>
        <td><input type="text" value="<?php echo $row['Email'];?>" name="email[]"></td>
        <td><input type="text" value="<?php echo $row['Phone'];?>" name="phone[]"></td>
        <td><input type="text" value="<?php echo $row['Position'];?>" name="position[]"></td>
        <td style="border:solid white 1px;">
        <a href="delete_user.php?userid=<?php echo $row['UserID'];?>" onclick="return confirm('Confirm to delete?')"><img src="../img/delete.jpg"></a>
        </td>
        </tr>
        <?php } ?>

      </table>
      <div style="text-align:center; margin:30px;">
        <button type="submit" onclick="return confirm('Confirm to update?')">Update</button>
     </div>

     <div class="adduser" >
       <a href="add_user.php" >Add User</a>
     </div>
    </form>
  </div>



  </div>

  <script>
    var today=new Date();
    var date='Date: '+today.getDate()+'/'+(today.getMonth()+1)+'/'+today.getFullYear();
    document.getElementById("dat").innerHTML=date;


</script>
</body>
