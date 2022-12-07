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

$currentPage = $_SERVER["PHP_SELF"];

$colname_loggedUser = "-1";
if (isset($_POST['NOM_UTIL'])) {
  $colname_loggedUser = $_POST['NOM_UTIL'];
}
mysql_select_db($database_connex, $connex);
$query_loggedUser = sprintf("SELECT * FROM utilisateur WHERE NOM_UTIL = %s", GetSQLValueString($colname_loggedUser, "text"));
$loggedUser = mysql_query($query_loggedUser, $connex) or die(mysql_error());
$row_loggedUser = mysql_fetch_assoc($loggedUser);
$totalRows_loggedUser = mysql_num_rows($loggedUser);

$maxRows_Listind = 15;
$pageNum_Listind = 0;
if (isset($_GET['pageNum_Listind'])) {
  $pageNum_Listind = $_GET['pageNum_Listind'];
}
$startRow_Listind = $pageNum_Listind * $maxRows_Listind;

mysql_select_db($database_connex, $connex);
$query_Listind = "SELECT ID_IND, G_SANG_IND, SEXE_IND, NOM_IND, PRENOM_IND, DATEH_NAIS, NUM_NIF FROM individu ORDER BY NOM_IND ASC";
$query_limit_Listind = sprintf("%s LIMIT %d, %d", $query_Listind, $startRow_Listind, $maxRows_Listind);
$Listind = mysql_query($query_limit_Listind, $connex) or die(mysql_error());
$row_Listind = mysql_fetch_assoc($Listind);

if (isset($_GET['totalRows_Listind'])) {
  $totalRows_Listind = $_GET['totalRows_Listind'];
} else {
  $all_Listind = mysql_query($query_Listind);
  $totalRows_Listind = mysql_num_rows($all_Listind);
}
$totalPages_Listind = ceil($totalRows_Listind/$maxRows_Listind)-1;

$queryString_Listind = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Listind") == false && 
        stristr($param, "totalRows_Listind") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Listind = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Listind = sprintf("&totalRows_Listind=%d%s", $totalRows_Listind, $queryString_Listind);
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['NOM_UTIL'])) {
  $loginUsername=$_POST['NOM_UTIL'];
  $password=$_POST['MOT_PASS'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "/syren/admininterf.php";
  $MM_redirectLoginFailed = "./";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_connex, $connex);
  
  $LoginRS__query=sprintf("SELECT NOM_UTIL,MOT_PASS FROM utilisateur WHERE NOM_UTIL=%s AND MOT_PASS=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $connex) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;
	$_SESSION['id_entite']	= $row_loggedUser['ID_ENTITE'];

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<?php
if ($_GET['act'] == "logout")
	$info ="<div class='logoutok'>Vous etes deconecte !</div>";
	
if ($_GET['act'] == "denied")
	$info ="<div class='logindenied'>Vous devez vous identifier pour acceder a cette page !</div>";
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

<div id="left">
<?php include_once('menuleft.php');?>
  </div>
	  </div>
	        
<div id="right">
 <?php 
include_once("menuh.php");
?>
  <?php
if($_GET['search'] == "")
	{
?>
  <?php
				echo $info
			?>
  <h3>&nbsp;</h3>
  <div class="story">
    <p align="center">LISTE DES INDIVIDUS ENREGISTRES SUR LE SYSTEME</p>
    <form id="form2" name="form2" method="post" action="">
      <p>&nbsp;</p>
                  
      <table border="1" id="entiteliste">
        <tr class="head">
          <td>NOM</td>
          <td>PRENOM</td>
          <td>SEXE</td>
          <td>GROUPE SANGUIN</td>
          <td>Date Naissance</td>
          <td colspan="3">Actions</td>
        </tr>
            <tr>
              <td><?php echo $row_Listind['NOM_IND']; ?></td>
              <td><?php echo $row_Listind['PRENOM_IND']; ?></td>
              <td><?php echo $row_Listind['SEXE_IND']; ?></td>
              <td><?php echo $row_Listind['G_SANG_IND']; ?></td>
              <td><?php echo $row_Listind['DATEH_NAIS']; ?></td>
              <td><a href="updind.php?ID_IND=<?php echo $row_Listind['ID_IND']; ?>" title="Modifier Individu"><img src="images/pencilart.jpeg" width="20" height="20"  border="0" /></a></td>
              <td><a href="viewind.php?ID_IND=<?php echo $row_Listind['ID_IND']; ?>" title="Visualiser Individu"><img src="images/eyeart.jpeg" width="20" height="20"  border="0" /></a></td> 
             <?php if (($groupe == "administrateur archives")|| ($groupe == "operateur archives")){?>
         <td><a href="filenais.php?ID_IND=<?php echo $row_Listind['ID_IND']; ?>" title="Voir Document"><img src="images/adobe1.jpg" width="20" height="20"  border="0" /></a></td>
         <?php }?>
              </tr>
            <?php } while ($row_Listind = mysql_fetch_assoc($Listind)); ?>
      </table>
      <p align="center">&nbsp;
                  
Total <?php echo ($startRow_Listind + 1) ?> à <?php echo min($startRow_Listind + $maxRows_Listind, $totalRows_Listind) ?> sur <?php echo $totalRows_Listind ?> Individus
<table border="0" align="center">
                    <tr>
                      <td><?php if ($pageNum_Listind > 0) { // Show if not first page ?>
                            <a href="<?php printf("%s?pageNum_Listind=%d%s", $currentPage, 0, $queryString_Listind); ?>">First</a>
                            <?php } // Show if not first page ?>                      </td>
                      <td><?php if ($pageNum_Listind > 0) { // Show if not first page ?>
                            <a href="<?php printf("%s?pageNum_Listind=%d%s", $currentPage, max(0, $pageNum_Listind - 1), $queryString_Listind); ?>">Previous</a>
                            <?php } // Show if not first page ?>                      </td>
                      <td><?php if ($pageNum_Listind < $totalPages_Listind) { // Show if not last page ?>
                            <a href="<?php printf("%s?pageNum_Listind=%d%s", $currentPage, min($totalPages_Listind, $pageNum_Listind + 1), $queryString_Listind); ?>">Next</a>
                            <?php } // Show if not last page ?>                      </td>
                      <td><?php if ($pageNum_Listind < $totalPages_Listind) { // Show if not last page ?>
                            <a href="<?php printf("%s?pageNum_Listind=%d%s", $currentPage, $totalPages_Listind, $queryString_Listind); ?>">Last</a>
                            <?php } // Show if not last page ?>                      </td>
                    </tr>
      </table>
      </p>
<p>&nbsp;</p>
    </form>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
  </div>

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
mysql_free_result($loggedUser);

mysql_free_result($Listind);
?>
