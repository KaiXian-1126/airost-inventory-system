<?php
require_once('dbconfig.php');
session_start();
$sql='SELECT * FROM `inventory`';
$result=mysqli_query($db_connection,$sql);
$num_row=mysqli_num_rows($result);
$counter=1;
?>
<head>
<link rel="stylesheet" type="text/css" href="../css/header.css">
<link  rel="stylesheet" type="text/css" href="../css/searchinventory.css"/>
<title>Select Inventory</title>
</head>


<body>

  <div class="header">
  <img src="../img/logo.png">
  <h1>Inventory System</h1>
  </div>

 

  <div class="refLink">
        <h2> Application Management System</h2>
        <a href="homepage.php">Home Page</a><p>&nbsp>&nbsp</p><a href='<?php 
        if ($position == "MANAGEMENT LEVEL"){
            echo "viewmyapplication_management.php";
          }else{
            echo "viewmyapplication_general.php";
          }
          ?>'>Application Management System</a>
          <p>&nbsp>&nbsp</p><p>Application Form</p>
    </div>
  <hr>
  <h2 class="title">Select 1 Inventory From List</h2>

   

  <div class="search-bar">
    <input type="text" id="search" class="search" 
    onkeyup="search_function()" class="searching" placeholder="Search....">
  </div>


  <div class="inventorylist">
      <table id="inventory_table">
        <tr>
          <th style="width: 15%;">No</th>
          <th style="width: 30%;">Item</th>
          <th style="width: 15%;">Quantity</th>
          <th style="width: 15%;">Select</th>
        </tr>
        <?php while($row=mysqli_fetch_assoc($result)){?>
        <form name="inventoryList" method="POST" action="update_application.php">
            <input type="hidden" name="appid" value="<?php echo $_SESSION['tempAppid']; ?>">
            
            <input type="hidden" name="position" value="<?php echo $_SESSION['tempPosition']; ?>">
            <input type="hidden" name="username" value="<?php echo $_SESSION['tempName']; ?>">
            <input type="hidden" name="applieddate" value="<?php echo $_SESSION['tempAppliedDate']; ?>">
            <input type="hidden" name="quantity" value="<?php echo $_SESSION['tempQuantity']; ?>">
            <input type="hidden" name="borrowdate" value="<?php echo $_SESSION['tempBorrowDate']; ?>">
            <input type="hidden" name="returndate" value="<?php echo $_SESSION['tempReturnDate']; ?>">
            <input type="hidden" name="description" value="<?php echo $_SESSION['tempDescription']; ?>">
            <input type="hidden" name="aftersearch" value="Yes">
            <tr>
                <td><?php echo $counter++;?></td>
                <td><?php echo $row['ItemName'];?></td>
                <td><?php echo $row['ItemAmount'];?></td>
                <td><input class="select" type="submit" name="select" value="SELECT"></td>
                <input type="hidden" name="item_type" value="<?php echo $row['ItemName'];?>">
                <input type="hidden" name="itemid" value="<?php echo $row['InventoryID'];?>">
            </tr>
        </form>
        <?php } ?>

      </table>
  </div>



  </div>

  <script>
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

</body>
