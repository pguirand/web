<?php require_once('Connections/connex.php'); ?><?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
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
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "index.php?act=denied";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
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

$maxRows_liste_voyage = 15;
$pageNum_liste_voyage = 0;
if (isset($_GET['pageNum_liste_voyage'])) {
  $pageNum_liste_voyage = $_GET['pageNum_liste_voyage'];
}
$startRow_liste_voyage = $pageNum_liste_voyage * $maxRows_liste_voyage;

mysql_select_db($database_connex, $connex);
$query_liste_voyage = "SELECT * FROM voyage";
$query_limit_liste_voyage = sprintf("%s LIMIT %d, %d", $query_liste_voyage, $startRow_liste_voyage, $maxRows_liste_voyage);
$liste_voyage = mysql_query($query_limit_liste_voyage, $connex) or die(mysql_error());
$row_liste_voyage = mysql_fetch_assoc($liste_voyage);

if (isset($_GET['totalRows_liste_voyage'])) {
  $totalRows_liste_voyage = $_GET['totalRows_liste_voyage'];
} else {
  $all_liste_voyage = mysql_query($query_liste_voyage);
  $totalRows_liste_voyage = mysql_num_rows($all_liste_voyage);
}
$totalPages_liste_voyage = ceil($totalRows_liste_voyage/$maxRows_liste_voyage)-1;

$queryString_liste_voyage = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_liste_voyage") == false && 
        stristr($param, "totalRows_liste_voyage") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_liste_voyage = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_liste_voyage = sprintf("&totalRows_liste_voyage=%d%s", $totalRows_liste_voyage, $queryString_liste_voyage);
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
-->
</style>
</head>

<body>
	        <div class="screen"><div id="header">
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</div>
		<div id="menutop" align="center">		  </div>
<div id="left">
<?php include_once('menuleft.php');?>
  </div>
	  </div>
	        
<div id="right">
  <p>
    <?php
	include_once('menuh.php');
if($_GET['search'] == "")
	{
?>
    <?php
				echo $info
			?>
    <br />
    <br />
  </p>
  <div class="content"> 
    <p align="center" class="style12 style12">Liste des Voyages enregistr&eacute;s par L'immigration</p>
    <form id="form2" name="form2" method="post" action="">
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <table border="0" id="comliste" align="center" cellpadding="0" cellspacing="0">
        <tr class="head">
		  <td>No</td> 			                   
          <td>COMPAGNIE AERIENNE</td>
          <td>No VOL</td>
          <td>PROVENANCE</td>
          <td>DESTINATION</td>
          <td>ARRIVEE A</td>
          <td>DEPART A</td>
          <td>ACTIONS</td>
        </tr>
        <?php do { ?>
            <tr>
              <td><?php echo $i = $i+1; ?></td>
              <td><?php echo $row_liste_voyage['NOM_COMP_AERIENNE']; ?></td>
              <td><?php echo $row_liste_voyage['NO_VOL']; ?></td>
              <td><?php echo $row_liste_voyage['PROVENANCE_VOL']; ?></td>
              <td><?php echo $row_liste_voyage['DESTINATION_VOL']; ?></td>
              <td><?php echo $row_liste_voyage['DATE_ARRIVEE_IND']; ?></td>
              <td><?php echo $row_liste_voyage['DATE_DEPART_IND']; ?></td>
              <td><a href="viewvoyage.php?ID_VOYAGE=<?php echo $row_liste_voyage['ID_VOYAGE']; ?>" title="Détail du voyage"><img src="images/avion.jpeg" width="30" height="30"  border="0" /></a></td> 
            </tr>
            <?php } while ($row_liste_voyage = mysql_fetch_assoc($liste_voyage)); ?>
      </table>
      <p>&nbsp;Enregistrements <?php echo ($startRow_liste_voyage + 1) ?>&agrave;<?php echo min($startRow_liste_voyage + $maxRows_liste_voyage, $totalRows_liste_voyage) ?>sur <?php echo $totalRows_liste_voyage ?>
<table border="0" align="center">
                    <tr>
                      <td><?php if ($pageNum_liste_voyage > 0) { // Show if not first page ?>
                            <a href="<?php printf("%s?pageNum_liste_voyage=%d%s", $currentPage, 0, $queryString_liste_voyage); ?>"><img src="First.gif" border="0" /></a>
                            <?php } // Show if not first page ?>                      </td>
                      <td><?php if ($pageNum_liste_voyage > 0) { // Show if not first page ?>
                            <a href="<?php printf("%s?pageNum_liste_voyage=%d%s", $currentPage, max(0, $pageNum_liste_voyage - 1), $queryString_liste_voyage); ?>"><img src="Previous.gif" border="0" /></a>
                            <?php } // Show if not first page ?>                      </td>
                      <td><?php if ($pageNum_liste_voyage < $totalPages_liste_voyage) { // Show if not last page ?>
                            <a href="<?php printf("%s?pageNum_liste_voyage=%d%s", $currentPage, min($totalPages_liste_voyage, $pageNum_liste_voyage + 1), $queryString_liste_voyage); ?>"><img src="Next.gif" border="0" /></a>
                            <?php } // Show if not last page ?>                      </td>
                      <td><?php if ($pageNum_liste_voyage < $totalPages_liste_voyage) { // Show if not last page ?>
                            <a href="<?php printf("%s?pageNum_liste_voyage=%d%s", $currentPage, $totalPages_liste_voyage, $queryString_liste_voyage); ?>"><img src="Last.gif" border="0" /></a>
                            <?php } // Show if not last page ?>                      </td>
                    </tr>
      </table>
      </p>
</form>
    <p align="center">&nbsp;</p>
    <p align="center">&nbsp;</p>
    <p align="center">&nbsp;</p>
  </div>
  <?php
	}
else
	echo " ".$nomutil."<br>";
	echo "".$id_groupe."<br>";
	echo "".$pass."<br>";
?>
</div>
  <div class="spacer"></div>
		<div id="footer">
			<div class="content">
			<img src="Logo.jpg" width="116" height="49" /> <a href="#">A propos de nous </a> | <a href="#">Plan du Site </a> | <a href="#">R&egrave;gle d'utilisation </a> | <a href="#">Contactez-nous</a> | &copy;2009 SYREN			</div>
		</div>
</div>

</body>
</html>
<?php
mysql_free_result($liste_voyage);

mysql_free_result($loggedUser);
?>
