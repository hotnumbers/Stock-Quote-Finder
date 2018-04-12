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

require "DBU.inc";
$objDBUtil = new DbUtil;

?>



<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Stock Quote Report-Quotes</title>
  <link rel="stylesheet" href="css/style.css">

</head>

<body>
<div class="main">
	<?php require "header.php" ?>	
	
	<?php require "nav.php" ?>

	<div class="content">
	
	<h3>Company Name- Enter all or parts </h3>
	
	<form id="quoteForm" action="" method="get">
			
		<input type="text" id="quoteInput" name="symbol" value=<?php print "'{$inputSymbol}'";  ?> >
			<input class="stockQuote" type="submit" value="Quote" name="quote"  onClick="quoteForm.action='quote.php'"> 
			<input class="stockHistory" type="submit" size="20" value="History" name="history"  onClick="quoteForm.action='history.php'"> 
			<input class="stockQuote" type="submit" value="Symbol Search" name="sym" onClick="quoteForm.action='symbol.php'"> 
		</form>	
		<hr>
		
<?php // check for form data
$strSymbol = @$_REQUEST["symbol"];
if(! empty($strSymbol))
{ // process the form
// Establish dbserver connection and default database
$db = $objDBUtil->Open();


// Run a Query to get some recent quote data
$querysymbol = $objDBUtil->DBQuotes($strSymbol);
$query = "select symSymbol, symName from symbols where symSymbol like '".$inputSymbol."%' or symName like '".$inputSymbol."%'";

$result = @$db->query($query);

if($result)
{
print	"<table id='tableTitleTop'>
	
	</table>
	<table id='tableTitleBottom'>
		<tr id='black'>
			
		  <td id='left'>Company</td>
		  <td id='right'> </td>
		  <td id='tableSpace'></td>  
		  <td id='left' >Symbol</td>    
		  <td id='right'>{$result->num_rows} Entries</td>
		
		</tr>
	</table>
	
	
	
	
	<div id='tableContent'>
	<table id='quote'>
	<tbody>";
	while($row = @$result->fetch_assoc())
	{
		extract($row);
		echo "
		<tr>
		<td id='left' class='searchResult'>{$row['symName']} </td>
		<td id='right'> </td>
		<td id='tableSpace'></td>  
		<td id='left'>
		 {$row['symSymbol']}
		</td>    
		<td id='right'><a href='quote.php?symbol={$row['symSymbol']}'>Quote</a> <a href='history.php?symbol={$row['symSymbol']}'>History</a> </td>
		</tr>";
	}
	print"
	</tbody>
	</table>
	</div>
	

";



}
else
{
	
print "Can't find the data";
print "{$query}";
}
}

else
{

}
@$result->free();
$objDBUtil->Close(); // Close connection
?>
 
 </div>
		<?php require "footer.php" ?>
		
 </div>
</body>
</html>

<?php // This is the LAST section in a PHP webpage file
ob_end_flush();
?>