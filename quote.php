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
		<h3>Enter a Company Name or Symbol to Start the Search</h3>
		<br>
		
		
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
$query = <<<HERETOouterjoin
select symSymbol, symName, qSymbol,  qQuoteDateTime,  qLastSalePrice, qAskPrice,  qBidPrice, q52WeekLow, q52WeekHigh,  qTodaysLow, qTodaysHigh, qNetChangePrice,  qNetChangePct, qShareVolumeQty,  qPreviousClosePrice, qCurrentPERatio,  qEarningsPerShare, qCashDividendAmount,  qCurrentYieldPct, qTotalOutstandingSharesQty, symMarketCap 
from symbols left outer join quotes on symSymbol=qSymbol
where symSymbol={$querysymbol}
order by qQuoteDateTime desc
limit 50
HERETOouterjoin;

$result = @$db->query($query);
if($result)
{
$row = @$result->fetch_assoc();
if($row){
extract($row);
if($qLastSalePrice!=NULL)
{


$date = date('m/d/Y');
/* if($qQuoteDateTime < 0) $qQuoteDateTime = 'ff0000';
if($qLastSalePrice < 0) $qLastSalePrice = 'ff0000';
if($qNetChangePct < 0) $qNetChangePct = 'ff0000';
if($qAskPrice < 0) $qAskPrice = 'ff0000';
if($qBidPrice < 0) $qBidPrice = 'ff0000';
if($q52WeekLow < 0) $q52WeekLow = 'ff0000';
if($q52WeekHigh < 0) $q52WeekHigh = 'ff0000';
if($qTodaysLow < 0) $qTodaysLow = 'ff0000';
if($qTodaysHigh < 0) $qTodaysHigh = 'ff0000';
if($qNetChangePrice < 0) $qNetChangePrice = 'ff0000';
if($qNetChangePct < 0) $qNetChangePct = 'ff0000';
if($qShareVolumeQty < 0) $qShareVolumeQty = 'ff0000';
if($qPreviousClosePrice < 0) $qPreviousClosePrice = 'ff0000';
if($qCurrentPERatio < 0) $qCurrentPERatio = 'ff0000';
if($qEarningsPerShare < 0) $qEarningsPerShare = 'ff0000';
if($qCashDividendAmount < 0) $qCashDividendAmount = 'ff0000';
if($qCurrentYieldPct < 0) $qCurrentYieldPct = 'ff0000';
if($qTotalOutstandingSharesQty < 0) $qTotalOutstandingSharesQty = 'ff0000';
if($symMarketCap < 0) $symMarketCap = 'ff0000'; */


$qShareVolumeQty= number_format($qShareVolumeQty);

$qTotalOutstandingSharesQty=number_format($qTotalOutstandingSharesQty);
$symMarketCap=number_format($symMarketCap);


if($qQuoteDateTime == NULL) $qQuoteDateTime = "n/a";
if($qLastSalePrice == NULL) $qLastSalePrice = "n/a";
if($qNetChangePct == NULL) $qNetChangePct = "n/a";
if($qAskPrice == NULL) $qAskPrice = "n/a";
if($qBidPrice == NULL) $qBidPrice = "n/a";
if($q52WeekLow == NULL) $q52WeekLow = "n/a";
if($q52WeekHigh == NULL) $q52WeekHigh = "n/a";
if($qTodaysLow == NULL) $qTodaysLow = "n/a";
if($qTodaysHigh ==NULL) $qTodaysHigh = "n/a";
if($qNetChangePrice == NULL) $qNetChangePrice = "n/a";
if($qNetChangePct == NULL) $qNetChangePct = "n/a";
if($qShareVolumeQty == 0) $qShareVolumeQty = "n/a";
if($qPreviousClosePrice == NULL) $qPreviousClosePrice = "n/a";
if($qCurrentPERatio == NULL) $qCurrentPERatio = "n/a";
if($qEarningsPerShare == NULL) $qEarningsPerShare = "n/a";
if($qCashDividendAmount == NULL) $qCashDividendAmount = "n/a";
if($qCurrentYieldPct == NULL) $qCurrentYieldPct = "n/a";
if($qTotalOutstandingSharesQty == 0) $qTotalOutstandingSharesQty = "n/a";
if($symMarketCap == 0) $symMarketCap = "n/a";




print "<table id='tableTitleTop'>\n";
print "<tr>
		<td id='left'>
{$row['symSymbol']}</td>";

print "			  
		
		  <td id='left'></td> 
		  <td id='tableSpace' >{$date}</td>   
		  <td id='right'>NYSE </td>
		</tr>\n";
print "</table>\n";

	
print "	<table id='tableTitleBottom'> \n";


print "			<tr>

				<td class='companyName'>{$row['symName']}</td>
			</tr>
		</table>";


print"<div id='tableContent'>\n";

print "<table id='quote'>\n";	
print "<tbody>";	
	
print "<tr>
				<td id='left'>Last</td> 
				<td id='right'>{$qLastSalePrice}</td> 
				<td id='tableSpace'><td>
				<td id='left'>Prev Close</td> 
				<td id='right'>{$qPreviousClosePrice}</td> 
			</tr>";
print "<tr>
			  <td id='left'>Change</td>
			  <td id='right'>{$qNetChangePrice}</td>
			  <td id='tableSpace'><td>
			  <td id='left'>Bid</td>
			  <td id='right'>{$qBidPrice}</td>
			</tr>";
print "<tr>
				<td id='left'>%Change</td>
				<td id='right'>{$qNetChangePct}%</td>
				<td id='tableSpace'><td>          
				<td id='left'>Ask</td>
				<td id='right'>{$qAskPrice}</td>
			</tr>";
print "<tr>
				<td id='left'>High</td>
				<td id='right'>{$qTodaysHigh}</td>
				<td id='tableSpace'><td>				
				<td id='left'>52 Week High</td>
				<td id='right'>{$q52WeekHigh}</td>
			</tr>";
print "<tr>
				<td id='left'>Low</td>
				<td id='right'>{$qTodaysLow}</td>
				<td id='tableSpace'><td>
				<td id='left'>52 Week Low</td>
				<td id='right'>{$q52WeekLow}</td>
				</tr>
";
print "<tr>
				<td id='left'>Daily Volume</td>
				<td id='right'>{$qShareVolumeQty}</td>
				<td id=tableSpace'><td>
				<td id='left'></td>
				<td id='right'></td>
			</tr>";	
print "</tbody>";			
print "</table>
		
		<table id='tableTitleBottom2'>
        <tr>
          <td class='companyName'><b>Fundamentals</b></td>
        </tr>
      </table>";
print "<table id='quote' >";
print "<tr>

          <td id='left'>PE Ratio</td>
          <td id='right'>{$qCurrentPERatio}</td>
          <td id='tableSpace'></td>
          <td id='left'>Market Cap.</td>
          <td id='right'>{$symMarketCap} Mil</td>
        </tr>";
print "<tr>
          <td id='left'>Earnings/share</td>
          <td id='right'>{$qEarningsPerShare}</td>
          <td id='tableSpace'></td>
          <td id='left'> # Shrs Out. </td>
          <td id='right'>{$qTotalOutstandingSharesQty}</td>
        </tr>";
print "<tr>
          <td id='left'>Div/Share</td>
          <td id='right'>{$qCashDividendAmount}</td>
          <td id='tableSpace'></td>
          <td id='left'>Div. Yield</td>
          <td id='right'>{$qCurrentYieldPct}%</td>
        </tr>";


print "</table>\n";
print "</div>";
}
else{ print "Symbol doesn't exist!<br><a href='symbol.php?symbol={$row['symSymbol']}'>Search your Symbol</a>";}
}

else{print "Symbol doesn't exist!";}
}

else{print "Invalid query result";	}
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