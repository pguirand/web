<?php require_once('Connections/connex.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

    
// ** Logout the current user. **
$user = $_SESSION['MM_Username'];
$query_idd = "SELECT max(`session`.ID_SESSION) as id FROM `session` WHERE `session`.ID_UTIL = (select id_util from utilisateur where nom_util like '$user')";
mysql_select_db($database_connex, $connex);
$idd = mysql_query($query_idd, $connex) or die(mysql_error());
$row_idd = mysql_fetch_assoc($idd);
$rowid = $row_idd['id'];
$totalRows_idd = mysql_num_rows($idd);
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";

if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
 $updateSQL = sprintf("UPDATE session SET DATE_DECONN=NOW() WHERE ID_SESSION like '$rowid'");
  mysql_select_db($database_connex, $connex);
  $Result1 = mysql_query($updateSQL, $connex) or die(mysql_error());
   //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  
  $_SESSION['id_entite'] = NULL;
  $_SESSION['groupe_id'] = NULL;
    
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
  unset($_SESSION['id_entite']);
  unset($_SESSION['groupe_id']);
	
  $logoutGoTo = "index.php?act=logout";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
    
}
?>
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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_listepub = 10;
$pageNum_listepub = 0;
if (isset($_GET['pageNum_listepub'])) {
  $pageNum_listepub = $_GET['pageNum_listepub'];
}
$startRow_listepub = $pageNum_listepub * $maxRows_listepub;

mysql_select_db($database_connex, $connex);
$query_listepub = "SELECT publications.ID_PUB, publications.TITRE_PUB, publications.TYPE_PUB, publications.DATE_PUB, publications.STATUT, utilisateur.NOM_UTIL FROM publications, utilisateur WHERE publications.ID_UTIL=utilisateur.ID_UTIL ORDER BY publications.DATE_PUB ASC";
$query_limit_listepub = sprintf("%s LIMIT %d, %d", $query_listepub, $startRow_listepub, $maxRows_listepub);
$listepub = mysql_query($query_limit_listepub, $connex) or die(mysql_error());
$row_listepub = mysql_fetch_assoc($listepub);

if (isset($_GET['totalRows_listepub'])) {
  $totalRows_listepub = $_GET['totalRows_listepub'];
} else {
  $all_listepub = mysql_query($query_listepub);
  $totalRows_listepub = mysql_num_rows($all_listepub);
}
$totalPages_listepub = ceil($totalRows_listepub/$maxRows_listepub)-1;

$queryString_listepub = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_listepub") == false && 
        stristr($param, "totalRows_listepub") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_listepub = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_listepub = sprintf("&totalRows_listepub=%d%s", $totalRows_listepub, $queryString_listepub);
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
.style2 {font-size: 9%}
#search {		background-color:#eee;
}
.style12 {font-size: 12px}
.style13 {color: #3131DF}
.style14 {color: #6F39B0}
.style15 {color: #FFFFFF}
-->
</style>

</head>

<body>
	        <div class="screen"><div id="header">
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</div>
		
<div id="left"><?php include_once('menuleft.php');?>
</div>
	  </div>
	        
<div id="right">
  <p>
    <?php
if($_GET['search'] == "")
	{
?>
    <?php
				echo $info;include_once('menuh.php');
			?>
  <DIV class="fonce" align="center"> Liste de toutes les Publication </DIV><p>
  <table border="0" id="comliste" align="center">
  <tr class="head">
    <td><div align="center">TITRE</div></td>
    <td><div align="center">TYPE</div></td>
    <td><div align="center">DATE PUBliee</div></td>
    <td><div align="center">STATUT</div></td>
    <td><div align="center">publiee par:</div></td>
    <td><div align="center">publiee par:</div></td>
  </tr>
  <?php do { ?>
  <tr>
    <td><a href="viewpub.php?ID_PUB=<?php echo $row_listepub['ID_PUB'];?>" title="Visualier"><?php echo $row_listepub['TITRE_PUB']; ?></a></td>
    <td><?php echo $row_listepub['TYPE_PUB']; ?></td>
    <td><?php echo $row_listepub['DATE_PUB']; ?></td>
    <td><?php echo $row_listepub['STATUT']; ?></td>
    <td><?php echo $row_listepub['NOM_UTIL']; ?></td>
     <td><?php echo $row_listepub['ID_PUB']; ?></td>
  </tr>
  <?php } while ($row_listepub = mysql_fetch_assoc($listepub)); ?>
</table>
  
  
  <table border="0">
    <tr>
      <td><?php if ($pageNum_listepub > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_listepub=%d%s", $currentPage, 0, $queryString_listepub); ?>">First</a>
            <?php } // Show if not first page ?>
      </td>
      <td><?php if ($pageNum_listepub > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_listepub=%d%s", $currentPage, max(0, $pageNum_listepub - 1), $queryString_listepub); ?>">Previous</a>
            <?php } // Show if not first page ?>
      </td>
      <td><?php if ($pageNum_listepub < $totalPages_listepub) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_listepub=%d%s", $currentPage, min($totalPages_listepub, $pageNum_listepub + 1), $queryString_listepub); ?>">Next</a>
            <?php } // Show if not last page ?>
      </td>
      <td><?php if ($pageNum_listepub < $totalPages_listepub) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_listepub=%d%s", $currentPage, $totalPages_listepub, $queryString_listepub); ?>">Last</a>
            <?php } // Show if not last page ?>
      </td>
    </tr>
  </table>
  <div align="center">
  
  
  
    <?php
	}
?>
  </div>
</div>
  <div class="spacer"></div>
		<div id="footer">
			<div class="content">
			<img src="Logo.jpg" width="116" height="49" /> <a href="#">A propos de nous </a> | <a href="#">Plan du Site </a> | <a href="#">R&egrave;gle d'utilisation </a> | <a href="#">Contactez-nous</a> | &copy;2009 SYREN			</div>
		</div>

</body>
</html>
<?php
mysql_free_result($listepub);
?>
