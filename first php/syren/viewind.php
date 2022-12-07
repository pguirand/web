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

$colname_loggedUser = "-1";
if (isset($_POST['NOM_UTIL'])) {
  $colname_loggedUser = $_POST['NOM_UTIL'];
}
mysql_select_db($database_connex, $connex);
$query_loggedUser = "SELECT * FROM utilisateur WHERE NOM_UTIL = 'colname'";
$loggedUser = mysql_query($query_loggedUser, $connex) or die(mysql_error());
$row_loggedUser = mysql_fetch_assoc($loggedUser);
$totalRows_loggedUser = mysql_num_rows($loggedUser);

$colname_UPDIND = "-1";
if (isset($_GET['ID_IND'])) {
  $colname_UPDIND = $_GET['ID_IND'];
}
mysql_select_db($database_connex, $connex);
$query_UPDIND = sprintf("SELECT * FROM individu, document, adresse WHERE individu.ID_IND = %s  and individu.ID_IND = document.ID_IND and individu.ID_IND = adresse.ID_IND ORDER BY individu.ID_IND ASC", GetSQLValueString($colname_UPDIND, "text"));
$UPDIND = mysql_query($query_UPDIND, $connex) or die(mysql_error());
$row_UPDIND = mysql_fetch_assoc($UPDIND);
$totalRows_UPDIND = mysql_num_rows($UPDIND);
$idpere=$row_UPDIND['NUM_IDENTIFIANT_PERE'];
$idmere=$row_UPDIND['NUM_IDENTIFIANT_MERE'];
$idtem1=$row_UPDIND['NUM_ID_TEMOIN1'];
$idtem2=$row_UPDIND['NUM_ID_TEMOIN2'];


mysql_select_db($database_connex, $connex);
			$query_pere = sprintf("SELECT ID_IND, NOM_IND, NOM_JEUNE_FILLE, PRENOM_IND, NUM_IDENTIFIANT_PERE FROM individu WHERE ID_IND = %s", GetSQLValueString( $idpere, "text"));
$pere = mysql_query($query_pere, $connex) or die(mysql_error());
$row_pere = mysql_fetch_assoc($pere);
$totalRows_pere = mysql_num_rows($pere);

mysql_select_db($database_connex, $connex);
			$query_mere = sprintf("SELECT ID_IND, NOM_IND, NOM_JEUNE_FILLE, PRENOM_IND, NUM_IDENTIFIANT_PERE FROM individu WHERE ID_IND = %s", GetSQLValueString( $idmere, "text"));
$mere = mysql_query($query_mere, $connex) or die(mysql_error());
$row_mere = mysql_fetch_assoc($mere);
$totalRows_mere = mysql_num_rows($mere);

mysql_select_db($database_connex, $connex);
			$query_tem1 = sprintf("SELECT ID_IND, NOM_IND, NOM_JEUNE_FILLE, PRENOM_IND, NUM_IDENTIFIANT_PERE FROM individu WHERE ID_IND = %s", GetSQLValueString( $idtem1, "text"));
$tem1 = mysql_query($query_tem1, $connex) or die(mysql_error());
$row_tem1 = mysql_fetch_assoc($tem1);
$totalRows_tem1 = mysql_num_rows($tem1);

mysql_select_db($database_connex, $connex);
			$query_tem2 = sprintf("SELECT ID_IND, NOM_IND, NOM_JEUNE_FILLE, PRENOM_IND, NUM_IDENTIFIANT_PERE FROM individu WHERE ID_IND = %s", GetSQLValueString( $idtem2, "text"));
$tem2 = mysql_query($query_tem2, $connex) or die(mysql_error());
$row_tem2 = mysql_fetch_assoc($tem2);
$totalRows_tem2 = mysql_num_rows($tem2);
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

<title>SYREN | Système de Renseignement National</title>

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
.style16 {font-size: 14}
.style19 {font-size: 14; font-weight: bold; }
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
    <h3 align="center">Fiche Individu</h3>
  </div>
  <div class="style16">
    <fieldset>
    <legend></legend>
                
    <table width="690" border="0" id="vueliste">
      <tr class="head">
        <td width="467" class="style19">Info individu</td>
        <td width="45"><label></label></td>
        <td width="156"><label><br />
        </label></td>
      </tr>
      <tr class="style19">
        <td colspan="3"><span class="style19">CIN:<?php echo $row_UPDIND['NUM_CIF']; ?>; NIF:<?php echo $row_UPDIND['NUM_NIF']; ?> ; NO. PASSEPORT:<?php echo $row_UPDIND['NUM_PASSPORT']; ?></span></td>
      </tr>
      <tr>
        <td class="style19">Nom:<span class="style19"> <?php echo $row_UPDIND['NOM_IND']; ?></span></td>
        <td>&nbsp;</td>
        <td rowspan="7"><img src="images/photos/individus/<?php echo $row_UPDIND['PHOTO']; ?>" width="120" height="120" align="texttop" ></td>
      </tr>
      <tr>
        <td class="style19">Prenom :<span class="style19"> <?php echo $row_UPDIND['PRENOM_IND']; ?> </span></td>
        <td><div align="right">Photo:</div></td>
      </tr>
      <tr>
        <td class="style19">Groupe Sanguin : <?php echo $row_UPDIND['G_SANG_IND']; ?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td class="style19"><span class="style12">Sexe : <span class="style19"><?php echo ucwords($row_UPDIND['SEXE_IND']); ?></span></span></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td class="style19">Adresse: <?php echo $row_UPDIND['NUM_EDIFICE']; ?>, <?php echo $row_UPDIND['NOM_RUE']; ?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td class="style19">Date/Heure Naissance: <?php echo $row_UPDIND['DATEH_NAIS']; ?> </td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td class="style19">Lieu Naissance: <?php echo $row_UPDIND['LIEU_EVENNEMENT']; ?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td class="style19">Religion: <?php echo $row_UPDIND['RELIGION']; ?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td class="style19">Nom P&egrave;re: <?php echo $row_pere['PRENOM_IND']; ?> &nbsp;<?php echo $row_pere['NOM_IND']; ?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td class="style19">Nom M&egrave;re: <?php echo $row_mere['PRENOM_IND']; ?> <?php echo $row_mere['NOM_JEUNE_FILLE']; ?> <?php echo $row_mere['NOM_IND']; ?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td class="style19">Nom Temoin 1: <?php echo $row_tem1['PRENOM_IND']; ?><?php echo $row_tem1['NOM_JEUNE_FILLE']; ?> <?php echo $row_tem1['NOM_IND']; ?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td class="style19">Nom Temoin 2: <?php echo $row_tem2['PRENOM_IND']; ?><?php echo $row_tem2['NOM_JEUNE_FILLE']; ?> <?php echo $row_tem2['NOM_IND']; ?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    </fieldset>
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

mysql_free_result($UPDIND);
?>
