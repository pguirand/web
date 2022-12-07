<?php require_once('Connections/connex.php'); ?>
<?php
$currentPage = $_SERVER["PHP_SELF"];

mysql_select_db($database_connex, $connex);
$query_Recordset1 = "SELECT sect_act, nom, cigle, adresse FROM entites";
$Recordset1 = mysql_query($query_Recordset1, $connex) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$queryString_Recordset1 = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Recordset1") == false && 
        stristr($param, "totalRows_Recordset1") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Recordset1 = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Recordset1 = sprintf("&totalRows_Recordset1=%d%s", $totalRows_Recordset1, $queryString_Recordset1);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<style type="text/css">
<!--
#Layer1 {
	position:relative;
	left:108px;
	top:217px;
	width:576px;
	height:109px;
	z-index:1;
}
#Layer2 {
	position:absolute;
	left:55px;
	top:199px;
	width:634px;
	height:134px;
	z-index:1;
}
-->
</style>
</head>

<body>
<?php
echo $ty = $_GET['type'];

if ($ty == "gouv")
	{
		echo "Code pr entite gouver";
	}
else echo "Code pour entite NON gouver";
?>
<h2 align="center">Liste des entittes gouvernementales</h2>
<p align="center">&nbsp;</p>
<p align="center">&nbsp;</p>

<table border="1" align="center">
  <tr>
    <td>nom entite </td>
    <td>secteur d'activit&eacute;s </td>
    <td>cigle</td>
    <td>adresse</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_Recordset1['nom']; ?></td>
      <td><?php echo $row_Recordset1['sect_act']; ?></td>
      <td><?php echo $row_Recordset1['cigle']; ?></td>
      <td><?php echo $row_Recordset1['adresse']; ?></td>
    </tr>
    <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
</table>
<p align="center">&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
