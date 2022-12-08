<?php require_once('Connections/connex.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$maxRows_UTIL = 20;
$pageNum_UTIL = 0;
if (isset($_GET['pageNum_UTIL'])) {
  $pageNum_UTIL = $_GET['pageNum_UTIL'];
}
$startRow_UTIL = $pageNum_UTIL * $maxRows_UTIL;

mysql_select_db($database_connex, $connex);
$query_UTIL = "SELECT U.NOM_UTIL, I.NOM_IND, I.PRENOM_IND, G.NOM_GROUPE, U.STATUT, E.NOM_ENTITE FROM utilisateur U, INDIVIDU I, ENTITE E, GROUPE G  WHERE U.ID_IND=I.ID_IND AND U.ID_GROUPE = G.ID_GROUPE AND U.ID_ENTITE = E.ID_ENTITE";
$query_limit_UTIL = sprintf("%s LIMIT %d, %d", $query_UTIL, $startRow_UTIL, $maxRows_UTIL);
$UTIL = mysql_query($query_limit_UTIL, $connex) or die(mysql_error());
$row_UTIL = mysql_fetch_assoc($UTIL);

if (isset($_GET['totalRows_UTIL'])) {
  $totalRows_UTIL = $_GET['totalRows_UTIL'];
} else {
  $all_UTIL = mysql_query($query_UTIL);
  $totalRows_UTIL = mysql_num_rows($all_UTIL);
}
$totalPages_UTIL = ceil($totalRows_UTIL/$maxRows_UTIL)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>

<title>SYREN | Syst&egrave;me de Renseignement National</title>

<link href="css/style.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style10 {font-size: 10px}
#search {		background-color:#eee;
}
.style12 {font-size: 12px}
-->
</style>


<style type="text/css">
<!--
.style13 {font-size: 13px}
.style14 {
	font-size: 24px;
	font-weight: bold;
}
-->
</style>
</head>

<body>
	        <div class="screen"><div id="header">
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</div>
<div id="left">
<?php include_once('menuleft.php');?>
</div>
            
  <div id="right">
  <?php
  include_once("menuh.php"); ?>
  <table border="0" width="720"><tr><td><div align="center" class="style14">Liste Utilisateurs</div></td>
  </tr></table></div>          
  <table border="0" id="comliste">
  <tr class="head">    
    <td><div align="center">NOM UTILILISATEUR</div></td>
    <td><div align="center">NOM DE L'INDIVIDU</div></td>
    <td><div align="center">PRENOM DE L'INDIVIDU</div></td>
    <td><div align="center">GROUPE D'APPARTENANCE</div></td>
    <td><div align="center">STATUT</div></td>
    <td><div align="center">NOM DE L'ENTITE</div></td>
  </tr>
    <?php do { ?>
    </div>
    <tr>
      <td><div align="center"><?php echo $row_UTIL['NOM_UTIL']; ?></div></td>
      <td><div align="center"><?php echo $row_UTIL['NOM_IND']; ?></div></td>
      <td><div align="center"><?php echo $row_UTIL['PRENOM_IND']; ?></div></td>
      <td><div align="center"><?php echo $row_UTIL['NOM_GROUPE']; ?></div></td>
      <td><div align="center"><?php echo $row_UTIL['STATUT']; ?></div></td>
      <td><div align="center"><?php echo $row_UTIL['NOM_ENTITE']; ?></div></td>   
    </tr>
      <?php } while ($row_UTIL = mysql_fetch_assoc($UTIL)); ?>
  </div>
            </table>
  <div class="spacer"></div>
		<div id="footer">
			<div class="content">
			<img src="Logo.jpg" width="116" height="49" /> <a href="#">A propos de nous </a> | <a href="#">Plan du Site </a> | <a href="#">R&egrave;gle d'utilisation </a> | <a href="#">Contactez-nous</a> | &copy;2009 SYREN			</div>
		</div>
</div>

</body>
</html>
<?php
mysql_free_result($UTIL);
?>
