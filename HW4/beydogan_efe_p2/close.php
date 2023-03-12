<?php
include("config.php");
session_start();
$cid = $_SESSION['cid'];
$name = $_SESSION['name'];

// get aid from the link
$aid = $_GET['aid'];

// delete the related account from owns table
$deleteQuery = "DELETE FROM owns WHERE aid = '$aid'";
$result = $con->query($deleteQuery);

if ( !$result) {
    echo '<script> alert("Account deletion unsuccessful!"); document.location = "welcome.php";</script>';
}

// delete the related account from the account table
$deleteQuery = "DELETE FROM account WHERE aid = '$aid'";
$result = $con->query($deleteQuery);

if( !$result) {
    echo '<script> alert("Account deletion unsuccessful!"); document.location = "welcome.php";</script>';
}
else {
    echo '<script>alert("Account was successfully deleted."); document.location = "welcome.php"; </script>';
}


?>