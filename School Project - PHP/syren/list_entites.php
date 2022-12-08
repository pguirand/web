<?php require_once('Connections/connex.php'); ?>
<?php
// *** Validate request to login to this site.
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

$colname_loggedUser = "-1";
if (isset($_POST['NOM_UTIL'])) {
  $colname_loggedUser = $_POST['NOM_UTIL'];
}
mysql_select_db($database_connex, $connex);
$query_loggedUser = sprintf("SELECT * FROM utilisateur WHERE NOM_UTIL = %s", GetSQLValueString($colname_loggedUser, "text"));
$loggedUser = mysql_query($query_loggedUser, $connex) or die(mysql_error());
$row_loggedUser = mysql_fetch_assoc($loggedUser);
$totalRows_loggedUser = mysql_num_rows($loggedUser);

$maxRows_liste_entites = 20;
$pageNum_liste_entites = 0;
if (isset($_GET['pageNum_liste_entites'])) {
  $pageNum_liste_entites = $_GET['pageNum_liste_entites'];
}
$startRow_liste_entites = $pageNum_liste_entites * $maxRows_liste_entites;

mysql_select_db($database_connex, $connex);
$query_liste_entites = "SELECT ID_ENTITE, NOM_ENTITE, SIGLE, SECTEUR_ACTIVITE, STATUT FROM entite";
$query_limit_liste_entites = sprintf("%s LIMIT %d, %d", $query_liste_entites, $startRow_liste_entites, $maxRows_liste_entites);
$liste_entites = mysql_query($query_limit_liste_entites, $connex) or die(mysql_error());
$row_liste_entites = mysql_fetch_assoc($liste_entites);

if (isset($_GET['totalRows_liste_entites'])) {
  $totalRows_liste_entites = $_GET['totalRows_liste_entites'];
} else {
  $all_liste_entites = mysql_query($query_liste_entites);
  $totalRows_liste_entites = mysql_num_rows($all_liste_entites);
}
$totalPages_liste_entites = ceil($totalRows_liste_entites/$maxRows_liste_entites)-1;

$queryString_liste_entites = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_liste_entites") == false && 
        stristr($param, "totalRows_liste_entites") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_liste_entites = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_liste_entites = sprintf("&totalRows_liste_entites=%d%s", $totalRows_liste_entites, $queryString_liste_entites);
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
		<div id="menutop" align="center">		  </div>
<div id="left">
<?php include_once('menuleft.php');?>
  </div>
	  </div>
	        
<div id="right">
  <?php
  include_once('menuh.php');
if($_GET['search'] == "")
	{
?>
  <?php
				echo $info
			?><BR>
  <div class="fonce" align="center">LISTE DES ENTITES NATIONALES</h3></div>
  <div class="story">
    <p>&nbsp;</p>
    <div>
      <table width="" border="0" cellpadding="0" cellspacing="0" id="entiteliste">
        <tr class="head">
       	  <td> No </td>
          <td >Nom</td>
          <td>SIGLE</td>
          <td>SECTEUR D'ACTIVITES</td>
          <td>STATUT</td>
          <td colspan="2">Actions</td>
        </tr>
        <?php do { ?>
            <tr>
              <td> <?php echo $i=$i+1; ?></td>
              <td><?php echo $row_liste_entites['NOM_ENTITE']; ?></td>
              <td><?php echo $row_liste_entites['SIGLE']; ?></td>
              <td><?php echo $row_liste_entites['SECTEUR_ACTIVITE']; ?></td>
              <td><?php echo $row_liste_entites['STATUT']; ?></td>
              <?php
					  if ($_SESSION['NOM_GROUPE'] == "administrateur dgi" || $_SESSION['NOM_GROUPE'] == "operateur dgi"){?>
              <td><a href="updentites.php?ID_ENTITE=<?php echo $row_liste_entites['ID_ENTITE']; ?>" title="Modifier Entité"><img src="images/pencilart.jpeg" width="20" height="20"  border="0"</a></td>	<?php } ?>
              <td><a href="viewentites.php?ID_ENTITE=<?php echo $row_liste_entites['ID_ENTITE']; ?>" title="Visualiser Entité"><img src="images/eyeart.jpeg" width="20" height="20"  border="0"</a></td>   
            </tr>
            <?php } while ($row_liste_entites = mysql_fetch_assoc($liste_entites)); ?>
      </table>
    </div>
    <p>Total  <?php echo ($startRow_liste_entites + 1) ?> à <?php echo min($startRow_liste_entites + $maxRows_liste_entites, $totalRows_liste_entites) ?> sur <?php echo $totalRows_liste_entites ?> Entités</p>
    <p>&nbsp;</p>
    <table border="0" align="center"->
      <tr class="head">
        <td><?php if ($pageNum_liste_entites > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_liste_entites=%d%s", $currentPage, 0, $queryString_liste_entites); ?>">Début</a>
                <?php } // Show if not first page ?>        </td>
        <td><?php if ($pageNum_liste_entites > 0) { // Show if not first page ?>
                <a href="<?php printf("%s?pageNum_liste_entites=%d%s", $currentPage, max(0, $pageNum_liste_entites - 1), $queryString_liste_entites); ?>">Précédent</a>
                <?php } // Show if not first page ?>        </td>
        <td><?php if ($pageNum_liste_entites < $totalPages_liste_entites) { // Show if not last page ?>
                <a href="<?php printf("%s?pageNum_liste_entites=%d%s", $currentPage, min($totalPages_liste_entites, $pageNum_liste_entites + 1), $queryString_liste_entites); ?>">Suivant</a>
                <?php } // Show if not last page ?>        </td>
        <td><?php if ($pageNum_liste_entites < $totalPages_liste_entites) { // Show if not last page ?>
                <a href="<?php printf("%s?pageNum_liste_entites=%d%s", $currentPage, $totalPages_liste_entites, $queryString_liste_entites); ?>">Fin</a>
                <?php } // Show if not last page ?>        </td>
      </tr>
    </table>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
  </div>
  <?php
	}
else
	echo "".$nomutil."<br>";
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
mysql_free_result($loggedUser);

mysql_free_result($liste_entites);
?>
