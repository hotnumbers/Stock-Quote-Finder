<?php // This must be the FIRST line in a PHP webpage file
ob_start(); // Enable output buffering
//
// Specify no-caching header controls for page
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
session_start();
$wherefrom = @$_SESSION['camefrom'];
$_SESSION['camefrom'] = $_SERVER["PHP_SELF"];
?>



<?php

if(isset($_GET['history']) || isset($_GET['quote'])) {


    if (isset($_GET['history'])) {
        header('Location: /history.php');
        exit();
    }

    header('Location: /quote.php');
   
}

?>



<?php 
ob_end_flush();
?>