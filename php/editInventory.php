<?php
require_once('dbconfig.php');
$sql='SELECT * FROM `inventory`';
$result=mysqli_query($db_connection,$sql);
$num_row=mysqli_num_rows($result);
$counter=1;
?>

<head>
<link id="pagestyle" rel="stylesheet" type="text/css" href="../css/style5.css"/>
<title>Edit Inventory</title>
</head>


<body>

  <div class="header">
  <img src="../img/logo.png">
  <h1>Inventory System</h1>
  </div>

  <div class="header2">
  <h2>Inventory Management System</h2>
  <div class="refLink">
  <a href="./homepage.php">Home Page</a><p>></p><a href="manageInventory.php">Inventory Management System</a>
          <p>></p><p>Edit Inventory</p>
  </div>
  </div>
  <hr>
  <div class="header3">
    <p id="dat"></p>

  </div>


  <div class="table">
    <form name="InventoryList" action="update_Inventory.php" method="post">
      <table id="table_data">
        <tr style="background-color:rgba(230,230,230,1);">
          <th style="width:10%;">No</th>
          <th style="width:40%;">Item</th>
          <th style="width:25%;">Quantity</th>
          <th style="width:25%;">BorrowedAmount</th>
        </tr>

        <?php while($row=mysqli_fetch_assoc($result)){?>

          <tr>
          <td><?php echo $counter++; ?></td>
          <td><input type="text" value="<?php echo $row['ItemName'];?>" name="name[]"></td>
          <td class="quantity">
            <button type="button" class="btn_minus" value="quantity<?php echo $row['InventoryID'];?>" >-</button>
            <input  readonly type="text" value="<?php echo $row['ItemAmount'];?>" id="quantity<?php echo $row['InventoryID'];?>" name="qty[]">
            <!-- <input type="button" onclick="plus1()" value="+"> -->
            <button type="button" class="btn_add" value="quantity<?php echo $row['InventoryID'];?>">+</button>
            <input type="hidden" name="inventory_id[]" value="<?php echo $row['InventoryID'];?>">
          </td>

          <td class="quantity">
            <button type="button" class="btn_minus1" value="borrow_quantity<?php echo $row['InventoryID'];?>" >-</button>
            <input readonly  type="text" value="<?php echo $row['BorrowAmount'];
            ?>" id="borrow_quantity<?php echo $row['InventoryID'];?>" name="brrwqty[]">
            <button type="button" class="btn_add1" value="borrow_quantity<?php echo $row['InventoryID'];?>">+</button>
          </td>

            <td style="border:solid white 1px;">
            <a href="deleteinventory.php?inventoryid=<?php echo $row['InventoryID'];?>" onclick="return confirm('Confirm to delete?')"><img src="../img/delete.jpg"></a>
          </td>

          </tr>

        <?php } ?>

      </table>
      <div style="text-align:center; margin:30px;">
        <button type="submit" onclick="return confirm('Confirm to update?')">Update</button>
     </div>

     <div class="adduser" >
       <a href="./addinventory.php" >Add Inventory</a>
     </div>
  </div>



  </div>

  <script>
    var today=new Date();
    var date='Date: '+today.getDate()+'/'+(today.getMonth()+1)+'/'+today.getFullYear();
    document.getElementById("dat").innerHTML=date;


    var button, button_key;
       var button = document.querySelectorAll('.btn_add');
       for (button_key = 0; button_key < button.length; button_key++) {
         button[button_key].addEventListener("click", function(event) {
             var clicked_row = this.value;
             if(clicked_row){
                 document.getElementById(clicked_row).value = Number(document.getElementById(clicked_row).value) + 1;
             }

         });
       }

       var button1, button_key1;
          var button1 = document.querySelectorAll('.btn_minus');

          for (button_key1 = 0; button_key1 < button.length; button_key1++) {
            button1[button_key1].addEventListener("click", function(event) {
                var clicked_row1 = this.value;
                console.log(clicked_row1);
                if(clicked_row1){
                    document.getElementById(clicked_row1).value = Number(document.getElementById(clicked_row1).value) - 1;
                }

            });
          }

          var button2, button_key2;
             var button2 = document.querySelectorAll('.btn_add1');
             for (button_key2 = 0; button_key2 < button.length; button_key2++) {
               button2[button_key2].addEventListener("click", function(event) {
                   var clicked_row2 = this.value;
                   if(clicked_row2){
                       document.getElementById(clicked_row2).value = Number(document.getElementById(clicked_row2).value) + 1;
                   }

               });
             }

             var button3, button_key3;
                var button3 = document.querySelectorAll('.btn_minus1');
                for (button_key3 = 0; button_key3 < button.length; button_key3++) {
                  button3[button_key3].addEventListener("click", function(event) {
                      var clicked_row3 = this.value;
                      if(clicked_row3){
                          document.getElementById(clicked_row3).value = Number(document.getElementById(clicked_row3).value) - 1;
                      }

                  });
                }

  </script>

</body>
