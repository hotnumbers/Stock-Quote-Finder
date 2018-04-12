<?php // This must be the FIRST line in a PHP webpage file
ob_start(); // Enable output buffering
// phpinclude2.php Several alternatives for require/include
//
// Specify no-caching header controls for page
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0




session_start();

$inputSymbol = @$_GET["symbol"];
if(empty($inputSymbol))
{$inputSymbol="";}


/* global $inputnameDefault;
$inputnameDefault = @$_GET["symbolDefault"]; */
/* $_GET['symbolQuote']=$_GET['symbolQuote'];
$_GET['symbolHistory']=$_GET['symbolHistory'];
$_GET['symbolQuote']=$_GET['symbol'];
 */
/* 
if(empty($inputnameDefault)&&empty($_GET['symbolQuote'])&&empty($_GET['symbolHistory'])&&isset($o_GET['mySymbol']))
{
	$inputnameDefault=$_GET['mySymbol'];
}
 if(empty($inputnameDefault)&&empty($_GET['symbolQuote'])&&empty($_GET['mySymbol'])&&isset($_GET['symbolHistory'])){
		$inputnameDefault=$_GET['symbolHistory'];
}
 if(empty($inputnameDefault)&&empty($_GET['symbolHistory'])&&empty($_GET['mySymbol'])&&isset($_GET['symbolQuote'])){
		$inputnameDefault=$_GET['symbolQuote'];
}
 if(empty($inputnameDefault)&&empty($_GET['symbolQuote'])&&empty($_GET['mySymbol'])&&empty($_GET['symbolHistory'])){
		$inputnameDefault=" ";
} */


?>


<?php
if(isset($_GET['symbol']))
{
    $value = $_GET['symbol'];

}
?>


<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Stock Quote Reports</title>
  <link rel="stylesheet" href="css/style.css">

</head>

<body>
<div class="main">
	
	<?php require "header.php" ?>	
	
	<?php require "nav.php" ?>
	
	

	<div class="content">
		
		<h2>Welcome to Stock Quote Report</h2>
		<br>
		<h3>Enter a Company Name or Symbol to Start the Search<h3>
		<br>
		<form id="quoteForm" action="" method="get">
		<input type="text" id="quoteInput" name="symbol" value=<?php print "'{$inputSymbol}'"; ?> >
		
		<input class="submitButton" type="submit" size="20" value="Search" name="quote"  onClick="quoteForm.action='quote.php'">
		</form>	
		
		
	</div>
 
	<?php require "footer.php" ?>
	
 </div>
</body>
</html>

<?php // This is the LAST section in a PHP webpage file
ob_end_flush();
?>