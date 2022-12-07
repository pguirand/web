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
.style16 {
	font-size: 16px;
	font-weight: bold;
}
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
<div id="left"><?php include_once('menuleft.php');?></div>
	  </div>
<div id="right">
<?php include_once('menuh.php');?>
  <h3 align="center">&nbsp;</h3>
  <p align="center" class="style16">Ha&iuml;ti: Le salaire minimum: du Parlement &agrave; l'Arcahaie</p>
  <div class="story">
    <p>&nbsp;</p>
    <p><em>Apr&egrave;s avoir &eacute;t&eacute; vot&eacute; par la Chambre  basse et le S&eacute;nat de la R&eacute;publique, la loi sur le salaire minimum  attend le verdict de l'Ex&eacute;cutif pour &ecirc;tre promulgu&eacute;e et mise en  vigueur. Cependant, &agrave; entendre les d&eacute;clarations du Chef de l'Etat  ha&iuml;tien, lundi &agrave; l'Arcahaie &agrave; l'occasion de la f&ecirc;te du drapeau, le  processus risque d'&ecirc;tre plus complexe que pr&eacute;vu.</em></p>
    <p>La classe ouvri&egrave;re a besoin de plus d'argent pour augmenter son pouvoir  d'achat, mais cela ne doit en aucun cas aggraver le ch&ocirc;mage et  occasionner de d&eacute;s&eacute;quilibre dans le syst&egrave;me. C'est en ces termes que le  pr&eacute;sident Ren&eacute; Pr&eacute;val a bri&egrave;vement intervenu, lundi &agrave; la Cit&eacute; du  Drapeau, sur la proposition de loi sur le salaire minimum initi&eacute; par le  d&eacute;put&eacute; Steven Beno&icirc;t et approuv&eacute; par la Chambre des d&eacute;put&eacute;s le 4  f&eacute;vrier dernier puis par le S&eacute;nat le 5 mai 2009. <br />
      <br />
Bien avant les propos tenus par le Chef de l'Etat, le Premier ministre  avait fait savoir jeudi que le gouvernement est en train de consulter  tous les secteurs concern&eacute;s en vue de prendre la d&eacute;cision qu'exige une  situation aussi d&eacute;licate.<br />
Ces d&eacute;clarations du Chef de l'Ex&eacute;cutif et du locataire de la Villa  d'Accueil risquent de prolonger davantage la promulgation de la loi sur  le salaire minimum.<br />
<br />
Pour plus d'un, la mise en garde des repr&eacute;sentants du secteur  industriel, qui s'est prononc&eacute; la semaine derni&egrave;re contre  l'augmentation du salaire minimum &agrave; 200 gourdes tel que vot&eacute; par les  deux chambres, a beaucoup influenc&eacute; la prise de position de l'Ex&eacute;cutif  sur le salaire minimum. Pour justifier sa position, l'Association des  industries d'Ha&iuml;ti (ADIH) argue qu'une telle augmentation aura pour  effet de diminuer de 50% les emplois dans le textile, de rendre Ha&iuml;ti  moins comp&eacute;titive. <br />
<br />
Certains industriels auraient m&ecirc;me menac&eacute; d'aller s'installer ailleurs si la loi Beno&icirc;t est maintenue. <br />
<br />
De tels arguments ont de quoi refroidir les ardeurs des partisans de  ''la loi Beno&icirc;t'' et surtout de l'Ex&eacute;cutif qui redoute une autre  escalade de mises &agrave; pied apr&egrave;s celles d&eacute;j&agrave; op&eacute;r&eacute;es &agrave; la T&eacute;l&eacute;co et &agrave;  l'APN. Toutefois, malgr&eacute; la force des arguments avanc&eacute;s par les tenants  du secteur de l'assemblage, d'aucuns pensent qu'ils sont venus trop  tard. Pourquoi l'ADIH a-t-elle attendu que le Parlement ait vot&eacute; la loi  avant de faire valoir son point de vue alors qu'il y a plus d'un an  qu'est lanc&eacute; le d&eacute;bat sur le salaire minimum?</p>
  </div>
</div>
<div class="spacer"></div>
		<div id="footer">
			<div class="content">
			<img src="Logo.jpg" width="116" height="49" /> <a href="#">A propos de nous </a> | <a href="#">Plan du Site </a> | <a href="#">R&egrave;gle d'utilisation </a> | <a href="#">Contactez-nous</a> | &copy;2009 SYREN
			</div>
		</div>
</div>
</body>
</html>
<?php
mysql_free_result($loggedUser);
?>
