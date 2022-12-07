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
<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
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
  <h3 align="center">Ha&iuml;ti: Pr&eacute;val plaide pour une ind&eacute;pendance &eacute;conomique</h3>
  <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tbody>
      <tr>
        <td><table align="left" border="0" cellpadding="0" cellspacing="0">
            <tbody>
              <tr>
                <td></td>
              </tr>
              <tr>
                <td><img src="http://www.lenouvelliste.com/graphics/misc/pixel.gif" width="20" height="15" /></td>
                <td><img src="http://www.lenouvelliste.com/graphics/misc/pixel.gif" width="20" height="15" /></td>
              </tr>
            </tbody>
            </table>
          <!----------	pub.rectangles.end -->
&laquo; C'est une ind&eacute;pendance politique que nous avons acquise en  1804...Aujourd'hui, nous devons mener une autre forme de lutte afin  d'aboutir &agrave; notre ind&eacute;pendance &eacute;conomique, dont l'inexistence rend  fragile notre ind&eacute;pendance politique. &raquo; Cet appel a &eacute;t&eacute; lanc&eacute; par le  pr&eacute;sident de la R&eacute;publique, Ren&eacute; Pr&eacute;val, qui s'est rendu &agrave; l'Arcahaie,  le 18 mai 2009, &agrave; l'occasion du 206e anniversaire du drapeau national ,  c&eacute;l&eacute;br&eacute; cette ann&eacute;e sur le th&egrave;me &laquo; Drapo, senb&ograve;l dyal&ograve;g ak solidarite  nasyonal &raquo; (en fran&ccedil;ais, Drapeau, symbole de dialogue et de solidarit&eacute;  nationale &raquo;). <br />
<br />
Dans son discours d'une trentaine de minutes, prononc&eacute; quelque temps  apr&egrave;s la pose d'une gerbe de fleurs sur la place de la cit&eacute; du drapeau,  le chef de l'Etat s'est montr&eacute; visiblement r&eacute;volt&eacute; au sujet de l'aide  internationale. &laquo; Nous d&eacute;pendons trop de l'aide &eacute;trang&egrave;re &raquo;, a-t-il  d&eacute;clar&eacute; en pr&eacute;sence du Premier ministre, Mich&egrave;le D. Pierre Louis, des  ministres, des Parlementaires, des &eacute;lus locaux et de plusieurs autres  dignitaires de l'Etat et des repr&eacute;sentants de la soci&eacute;t&eacute; civile qui ont  pris part &agrave; la c&eacute;r&eacute;monie eucharistique suivie d'un Te Deum chant&eacute; par  le p&egrave;re Bichura D&eacute;luscar &agrave; la paroisse St-Pierre. &laquo; Cette ann&eacute;e, nous  avons un budget national de 80 milliards de gourdes, dont 32 milliards  seulement proviennent des recettes de l'Etat &raquo;, a regrett&eacute; M. Pr&eacute;val  qui &eacute;tait &agrave; Washington (Etats-Unis) en avril dernier &agrave; la recherche  d'un appui budg&eacute;taire aupr&egrave;s des bailleurs de fonds internationaux.<br />
<br />
Comment sortir sous la domination des pays et institutions &eacute;trang&egrave;res  qui ne conditionnent leur aide qu'&agrave; leur mani&egrave;re et qui obligent &agrave;  respecter leur condition ? &laquo; R&eacute;pondre &agrave; cette question n'est pas chose  facile, estime M. Pr&eacute;val qui appelle la population au dialogue et &agrave; la  solidarit&eacute;. Mais c'est un devoir pour nous de prot&eacute;ger notre  ind&eacute;pendance politique par une ind&eacute;pendance &eacute;conomique &raquo;. Et pour ce  faire, il faut, de l'avis du locataire du Palais national, qu'il y ait  d'abord stabilit&eacute; politique et s&eacute;curit&eacute; nationale, ces deux premi&egrave;res  conditions, s'est-il r&eacute;joui, sont d&eacute;j&agrave; r&eacute;unies. Il faut ensuite,  poursuit-il, cr&eacute;er des emplois en redynamisant surtout le secteur  agricole et augmenter &eacute;galement le prix de la main-d'oeuvre.<br />
        <br /></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </tbody>
  </table>
  <!--------------	mid.pub -->
  <!--------------	mid.pub.end -->
  <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tbody>
      <tr>
        <td>&nbsp;</td>
        <td valign="top"></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="40">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </tbody>
  </table>
  <p>&nbsp;</p>
  <div class="story">
    <p>&nbsp;</p>
  </div>
</div>
<div class="spacer"></div>
		<div id="footer">
			<div class="content">
			<img src="Logo.jpg" width="116" height="49" /> <a href="#">A propos de nous </a> | <a href="#">Plan du Site </a> | <a href="#">R&egrave;gle d'utilisation </a> | <a href="#">Contactez-nous</a> | &copy;2009 SYREN
			</div>
		</div>
</div>
<script type="text/javascript">
<!--
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"/syren/SpryAssets/SpryMenuBarDownHover.gif", imgRight:"/syren/SpryAssets/SpryMenuBarRightHover.gif"});
//-->
</script>
</body>
</html>
<?php
mysql_free_result($loggedUser);
?>
