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
  <title>Stock Quote Report-History</title>
  <link rel="stylesheet" href="css/style.css">

</head>

<body>
<div class="main">
	<?php require "header.php" ?>	
	
	<?php require "nav.php" ?>

	<div class="content">
		<h3>Enter a Company Name or Symbol to Start the Search</h3>
		<br>
		
		
		
		
		
		<form id="quoteForm" action="" method="get">

		
		<input type="text" id="quoteInput" name="symbol" value=<?php print "'{$inputSymbol}'"; ?> >
		
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
$query = <<<HERETOouterjoin
select symSymbol, symName, qSymbol, qQuoteDateTime, qLastSalePrice, qNetChangePrice, qNetChangePct,qShareVolumeQty
from symbols left outer join quotes on symSymbol=qSymbol
where symSymbol={$querysymbol}
order by qQuoteDateTime desc
limit 500
HERETOouterjoin;

$result = @$db->query($query);
if($result)
{
$row = @$result->fetch_assoc();

if($row==NULL){print "Symbol doesn't exist!";}
else{
extract($row);
if($qQuoteDateTime==NULL)
{print "Symbol doesn't exist!<br><a href='symbol.php?symbol={$row['symSymbol']}'>Search your Symbol</a>";}
else{
print "<table id='tableTitleTop'>\n";
print "<tr>
		<td id='left'>
{$row['symSymbol']}</td>";

print "			  
		
		  <td id='left'></td> 
		  <td id='tableSpace' >2017-05-05 16:02:00</td>   
		  <td id='right'>NYSE </td>
		</tr>\n";
print "</table>\n";
	
print "	<table id='tableTitleBottom'> \n";


print "			<tr>

				<td class='companyName'>{$row['symName']}</td>
			</tr>
		</table>";


print"<div id='tableContent'>\n";
print "<table id='tableTitleBottom' >
        <tr>
          
          <td id='left'><b>Date</b></td>
          <td id='right'><b>Last</b></td>
          <td id='right'><b>Change</b></td>
          <td id='right'><b>% Chg</b></td>
          <td id='right'><b>Volume</b></td>
        </tr>

      </table>";
print "<table id='history'>\n";	
print "<tbody>\n";		
while($row = @$result->fetch_assoc())
{
extract($row); // create $vars from all fields in the row

/* if($qQuoteDateTime < 0) $qQuoteDateTime = 'ff0000';


if($qLastSalePrice < 0) $qLastSalePrice = "ff0000";
if($qNetChangePct < 0) $qNetChangePct = "ff0000";

if($qNetChangePrice < 0) $qNetChangePrice = "ff0000";

if($qShareVolumeQty < 0) $qShareVolumeQty = "ff0000"; */


if($qQuoteDateTime == NULL) $qQuoteDateTime = "No Quote Data";
if($qLastSalePrice == NULL) $qLastSalePrice = "-.--";
if($qNetChangePrice == NULL) $qNetChangePrice = "-.--";
if($qNetChangePct == NULL) $qNetChangePct = "No Quote Data";
if($qShareVolumeQty == NULL) $qShareVolumeQty = "-.--";

$qShareVolumeQty= number_format($qShareVolumeQty);


print "<tr>";
print "<td id='left'>{$qQuoteDateTime}</td>"; 


if($qLastSalePrice<0){
print "<td id='right' style='color:red'>{$qLastSalePrice}</td>";}
else{
	
	print "<td id='right'>{$qLastSalePrice}</td>"; 
}

if($qNetChangePrice<0){
print "<td id='right' style='color:red'>{$qNetChangePrice}</td>";}
else{
	
	print "<td id='right'>+{$qNetChangePrice}</td>"; 
}

if($qNetChangePct<0){
print "<td id='right' style='color:red'>{$qNetChangePct}%</td>";}
else{
	
	print "<td id='right'>+{$qNetChangePct}%</td>"; 
}

print "<td id='right'>\${$qShareVolumeQty}</td>";




/* print "<td id='right'>\${$qLastSalePrice}</td>";
print "<td id='right'>\${$qNetChangePrice}</td>";
print "<td id='right'>{$qNetChangePct}</td>"; */


print "</tr>\n";
}

print "</tbody>";
print "</table>\n";
print "</div>";

}
}
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