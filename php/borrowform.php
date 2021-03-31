<script src="../javascript/webpage.js"></script>
<script src="../javascript/date.js"></script>
<script src="../javascript/formvalidation.js"></script>
<?php
require_once("dbconfig.php");
session_start();
$uid = $_SESSION['uid'];

$sql = "SELECT `Name` from user WHERE `UserID` = ".$uid;
$result = mysqli_query($db_connection, $sql);
$result_row = mysqli_fetch_assoc($result);
$username = $result_row['Name'];

if(isset($_POST['itemborrow'])){
    if($_POST['action'] == "submit"){
        $nextID = $_POST['appid'];
        $applieddate = $_POST['applieddate'];
        $itemid = $_POST['itemid'];
        $quantity = $_POST['quantity'];
        $borrowdate = $_POST['borrowdate'];
        $returndate = $_POST['returndate'];
        $description = $_POST['description'];

        $sqlinsert = "INSERT INTO `application` (`ApplicationID`, `ApplicantID`, `AppliedDate`, `ApprovedDate`, `Amount`, `BorrowDate`, `ReturnDate`, `Status`, `Description`, `ApproverID`, `InventoryID`, `Reason`) VALUES
        (".$nextID.", ".$uid.", '".$applieddate."', NULL, ".$quantity.", '".$borrowdate."', '".$returndate."', 'PENDING', '".$description."', NULL, ".$itemid.", NULL)";
        $result = mysqli_query($db_connection, $sqlinsert);
        if($result > 0){
            echo "<script>alert('Your application submitted successfully.');</script>";
            echo "<script>window.location = './homepage.php'</script>";
        }else{
            echo "<script>alert('Failed to submit application: Database error.');</script>";
            echo "<script>window.location = 'borrowform.php'</script>";
        }
    }else if($_POST['action'] == "search"){
        $_SESSION['tempAppid'] = $_POST["appid"];
        $_SESSION['tempItemid'] = $_POST["itemid"];
        $_SESSION['tempQuantity'] = $_POST["quantity"];
        $_SESSION['tempBorrowDate'] = $_POST["borrowdate"];
        $_SESSION['tempReturnDate'] = $_POST["returndate"];
        $_SESSION['tempDescription'] = $_POST["description"];
        echo "<script>goto('searchborrowitem.php')</script>";

    }
   
}else if (isset($_POST['aftersearch'])){ ?>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="../css/header.css" />
        <link rel="stylesheet" type="text/css" href="../css/borrowform.css" />
        <title>Borrow Form</title>
    </head>
    <body>
        <div class="header">
            <img src="../img/logo.png" alt="Logo">
            <h1>Inventory System</h1>
        </div>
        <div class="refLink">
            <h2> Item Borrow System</h2>
            <a href="./homepage.php">Home Page</a><p>&nbsp>&nbsp</p><a href="borrowform.php">Borrow Form</a>
        </div>
        <hr>
        <div class="form">
            <a href="./homepage.php"><input type="button" class="back" value="<< Back"/></a>
            <h2>Borrow Form</h2>
            <form method="POST" action="borrowform.php">
                <div class="grid_container">
                    <input name="appid" type="hidden" value="<?php echo $_POST['appid']; ?>">
                    <p class="name"><span class="arterisk">*</span>Applicant name:</p>
                    <input class="name" type="text" name="username" value="<?php echo $username ?>" readonly>

                    <p class="applieddate"><span class="arterisk">*</span>Applied date</p>
                    <input class="applieddate" type="date" name="applieddate" readonly>
                    <script>
                        document.getElementsByName("applieddate")[0].value = getCurrentDate();
                    </script>

                    <p class="itemborrow"><span class="arterisk">*</span>Item wish to borrow:</p>
                    <input class="itemborrow" type="text" name="itemborrow" value="<?php echo $_POST['item_type']; ?>" readonly>
                    <input class="itemid" type="hidden" name="itemid" value="<?php echo $_POST['itemid']; ?>">
                    <input class="search" type="submit" name="search" value="Search" onclick="searchAction();">

                    <p class="quantity"><span class="arterisk">*</span>Quantity:</p>
                    <input class="quantity" type="number" min="1" max="999" value="<?php echo $_POST['quantity']; ?>" name="quantity">

                    <p class="borrowdate"><span class="arterisk">*</span>Borrow date:</p>
                    <input class="borrowdate" type="date" name="borrowdate" value="<?php echo $_POST['borrowdate']; ?>">

                    <p class="returndate"><span class="arterisk">*</span>Return date:</p>
                    <input class="returndate" type="date" name="returndate" value="<?php $_POST['returndate']; ?>">

                    <p class="description">Description:</p>
                    <textarea class="description" name="description"><?php echo $_POST['description']; ?></textarea>

                    <input class="submit" type="submit" value="Submit" onclick="return borrowFormValidation();">
                </div>
                <input type="hidden" name="action">
            </form>
        </div>
    </body>
</html>

<?php
}
else{
    $chkAppId = "SELECT MAX(ApplicationID) FROM `application`";
    $result = mysqli_query($db_connection, $chkAppId);
    $result_row = mysqli_fetch_assoc($result);
    $currentMaxID = $result_row['MAX(ApplicationID)'];
    $nextID = $currentMaxID + 1;
?>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="../css/header.css" />
        <link rel="stylesheet" type="text/css" href="../css/borrowform.css" />
        <title>Borrow Form</title>
    </head>
    <body>
        <div class="header">
            <img src="../img/logo.png" alt="Logo">
            <h1>Inventory System</h1>
        </div>
        <div class="refLink">
            <h2> Item Borrow System</h2>
            <a href="./homepage.php">Home Page</a><p>&nbsp>&nbsp</p><p>Borrow Form</p>
        </div>
        <hr>
        <div class="form">
            <a href="./homepage.php"><input type="button" class="back" value="<< Back"/></a>
            <h2>Borrow Form</h2>
            <form method="POST" action="borrowform.php">
                <div class="grid_container">
                    <input name="appid" type="hidden" value="<?php echo $nextID; ?>">
                    <p class="name"><span class="arterisk">*</span>Applicant name:</p>
                    <input class="name" type="text" name="username" value="<?php echo $username ?>" readonly>

                    <p class="applieddate"><span class="arterisk">*</span>Applied date</p>
                    <input class="applieddate" type="date" name="applieddate" readonly>
                    <script>
                        document.getElementsByName("applieddate")[0].value = getCurrentDate();
                    </script>

                    <p class="itemborrow"><span class="arterisk">*</span>Item wish to borrow:</p>
                    <input class="itemborrow" type="text" name="itemborrow" readonly>
                    <input class="itemid" type="hidden" name="itemid">
                    <input class="search" type="submit" name="search" value="Search" onclick="searchAction();">

                    <p class="quantity"><span class="arterisk">*</span>Quantity:</p>
                    <input class="quantity" type="number" min="1" max="999" value="1" name="quantity">

                    <p class="borrowdate"><span class="arterisk">*</span>Borrow date:</p>
                    <input class="borrowdate" type="date" name="borrowdate">

                    <p class="returndate"><span class="arterisk">*</span>Return date:</p>
                    <input class="returndate" type="date" name="returndate">

                    <p class="description">&nbspDescription:</p>
                    <textarea class="description" name="description"></textarea>

                    <input class="submit" type="submit" value="Submit" onclick="return borrowFormValidation();">
                    <input type="hidden" name="action">
                </div>
            </form>
        </div>
    </body>
</html>
<?php } ?>
