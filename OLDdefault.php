<?php  // This must be the FIRST line in a PHP webpage file
ob_start();		// Enable output buffering
?>

<?php	// Specify no-caching header controls for page
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");   			// Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");	// always modified
header("Cache-Control: no-store, no-cache, must-revalidate");	// HTTP/1.1
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");   // HTTP/1.0
?>

<?php
// ---------------------------------------------------------------
// default.php
// ---------------------------------------------------------------
?>

<html>
<head>
<title>Sample Webpage</title>
</head>
<body>

<hr>
<span><center><b>Sample PHP Webpage</b></center></span>
<hr>
<H1>Site Address ==> &nbsp;&nbsp;&nbsp;
<font color="red">
http://<b><?php echo "$_SERVER[SERVER_NAME]"; ?></b><br />
</font>
</H1>
<H2>Use FTP to access your website (HTML and PHP program files)</H2>
<H3>
<ul>
<li>Use FTP desktop client application such as FILEZILLA (recommended):<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Server Address: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;<font color="blue">cs.spu.edu</font>
</li>
<li>Use Internet Explorer Browser: <br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Enter URL Address: &nbsp;&nbsp;&nbsp;<font color="blue">ftp://cs.spu.edu</font>
</li>
</ul>
</H3>
For FTP, specify your SPU Accounts login credentials as:</H3>

<span><center>
<table border="1" bordercolor="black" cellspacing="1" cellpadding="8">
<tr>
	<td>User:</td>
	<td><b><font color="blue">accounts\userid</font></b><br />
	(note: you must specify the '<b>accounts\</b>' prefix)<br />
	</td>
</tr>
<tr>
	<td>Password:</td>
	<td><b><font color="blue">yourpassword</font></b></td>
</tr>
</table>
</center></span>

<H3>
Once logged in, you can Copy/Paste or Drag/Drop files to or from your website directory.
</H3>

<hr />
<table>
<tr>
	<td>PATH_TRANSLATED:&nbsp;&nbsp;&nbsp;</td>
	<td><?php echo "$_SERVER[PATH_TRANSLATED]"; ?></td>
</tr>
</table>
<hr />

<?php
// Example: output list of all predefined SERVER variables
// foreach($_SERVER as $key=>$val)
// {
//    echo '$_SERVER['.$key."] = $val<br />\n";
// }
?>

</body>
</html>

<?php	// This is the LAST section in a PHP webpage file
ob_end_flush();
?>
