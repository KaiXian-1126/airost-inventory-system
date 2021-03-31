<?php
    $hostname="localhost";
    $user="root";
    $password="";
    $database="airost";

    $db_connection = mysqli_connect($hostname, $user, $password, $database);

    if(mysqli_connect_errno()){
        echo "Failed to connect to database.";
    }

    function goto2 ($to,$Message){    // for delete_user.php
    	echo "<script language=\"JavaScript\">alert(\"".$Message."\") \n window.location = \"".$to."\"</script>";
    }

?>
