<?php require_once('Connections/connex.php'); ?>
<?php
mysql_select_db($database_connex, $connex);
$query_Recordset1 = "SELECT * FROM individu";
$Recordset1 = mysql_query($query_Recordset1, $connex) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<style type="text/css">
<!--
#main {
		border:1px solid blue;
		width:750px;
		height:800px;
		margin:0 auto 0 auto;	
}
#top {
		border:1px solid brown;
		padding:40px;
		float:left
		width:100px;
		height:50px;
}
#left {
		border:1px solid red;
		padding:40px;
		float:left;
		width:150px;
		height:400px;
}
#right {
		border:1px solid green;
		padding:40px;
		float:right;
		width:430px;
		height:400px;
}
#Layer1 {
	position:absolute;
	left:73px;
	top:108px;
	width:158px;
	height:55px;
	z-index:1;
}
-->
</style>
</head>
</html>
<html>
<div id=main>
<div id=top>
</div>
<div id=left>
Bienvenue sur SYREN: System de Renseignement National 
</div>
<div id=right>
</div>
</div>
</html>

<body>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
