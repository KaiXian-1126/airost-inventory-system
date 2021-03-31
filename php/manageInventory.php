<?php
require_once('dbconfig.php');
$sql='SELECT * FROM `inventory`';
$result=mysqli_query($db_connection,$sql);
$num_row=mysqli_num_rows($result);
$counter=1;
?>
<head>
<link id="pagestyle" rel="stylesheet" type="text/css" href="../css/style5.css"/>
<title>Inventory Management System</title>
</head>
<body>

  <div class="header">
  <img src="../img/logo.png">
  <h1>Inventory System</h1>
  </div>

  <div class="header2">
  <div class="refLink">
  <h2>Inventory Management System</h2>
  <a href="./homepage.php">Home Page</a><p>></p><p>Inventory Management System</p>
  </div>
  </div>
  <hr>
  <div class="header3">
    <p id="dat"></p>
    <a href="editInventory.php" class="managepage">Edit Inventory</a>
  </div>

  <div class="header4">
    <input type="text" id="search" onkeyup="search_function()" class="searching" placeholder="Search....">
    <button onclick=""><img src="../img/searching_icon.jpg"></button>
  </div>


  <div class="table">
    <form name="InventoryList">
      <table id="inventory_table">
        <tr>
          <th style="width:10%;">No</th>
          <th style="width:60%;">Item</th>
          <th style="width:15%;">Quantity</th>
          <th style="width:15%;">BorrowedAmount</th>
        </tr>
        <?php while($row=mysqli_fetch_assoc($result)){?>
            <tr>
            <td><?php echo $counter++;?></td>
            <td><?php echo $row['ItemName'];?></td>
            <td><?php echo $row['ItemAmount'];?></td>
            <td><?php echo $row['BorrowAmount']; ?></td>
        </tr>
        <?php } ?>

      </table>

    </form>
  </div>



  </div>

  <script>
    var today=new Date();
    var date='Date: '+today.getDate()+'/'+(today.getMonth()+1)+'/'+today.getFullYear();
    document.getElementById("dat").innerHTML=date;

    function search_function() {
    // Declare variables
    var search_input;
    var filter;
    var table;
    var tr;
    var td;
    var i;
    var value_name;

    search_input  = document.getElementById("search");
    filter        = search_input.value.toUpperCase();//convert ur input text to uppercase
    table         = document.getElementById("inventory_table");//get <table>
    tr            = table.getElementsByTagName("tr"); //tengok ada brp <tr> inside <table>

    // Loop through all table rows, and hide those who don't match the search query
    for (i = 0; i < tr.length; i++) {
      td = tr[i].getElementsByTagName("td")[1];// count from 0, so ur item coloum is = 1, Borrowed Quantity is =2
        console.log(td)
      if (td) {
        value_name = td.textContent || td.innerText; //take the item name
        console.log(value_name);

        if (value_name.toUpperCase().indexOf(filter) > -1) {
          tr[i].style.display = "";
        } else {
          tr[i].style.display = "none";
        }
      }
    }
  }
  </script>
</script>
</body>
