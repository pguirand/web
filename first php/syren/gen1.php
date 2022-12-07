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
  <h3 align="center">Ha&iuml;ti: Le meurtrier de l'inspecteur Lain&eacute; appr&eacute;hend&eacute;</h3>
  <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tbody>
      <tr>
        <td>Cinq  jours apr&egrave;s l'assassinat de l'inspecteur de police Lain&eacute; Ac&eacute;lesse,  responsable du sous-commissariat de Martissant, la PNH a proc&eacute;d&eacute; &agrave;  l'arrestation de son pr&eacute;sum&eacute; assassin, r&eacute;pondant au nom de Franck  L&eacute;onard, alias Pappadap. Apr&egrave;s diverses op&eacute;rations men&eacute;es dans la  banlieue de Martissant, la PNH a enfin proc&eacute;d&eacute; ce mardi matin &agrave;  l'arrestation de Pappadap - dans un quartier d&eacute;nomm&eacute; &laquo; Nan Do &raquo;, zone  de Grand-Ravine - ancien fief de bandes arm&eacute;es, dont la fameuse &laquo; lame  timanch&egrave;t &raquo;.<br />
            <br />
          &laquo; Depuis la mort de l'inspecteur de police, la PNH n'a pas ch&ocirc;m&eacute;, a  indiqu&eacute; son porte-parole, Frantz Lerebours. Nous avons men&eacute; diverses  op&eacute;rations, de vendredi &agrave; aujourd'hui, au cours desquelles 17 personnes  ont &eacute;t&eacute; arr&ecirc;t&eacute;es. Certaines d'entre elles ont &eacute;t&eacute; rel&acirc;ch&eacute;es et d'autres  ont &eacute;t&eacute; retenues pour leur implication pr&eacute;sum&eacute;e dans des actes de  banditisme.&raquo;<br />
          <br />
          Au cours de ces op&eacute;rations, au moins six bandits recherch&eacute;s par la  police nationale, tels que Ti Berto, Alc&eacute; Losu&eacute;, T&eacute;l&eacute;maque Dieubon  alias Nakata, ont &eacute;t&eacute; appr&eacute;hend&eacute;s. La plupart d'entre eux, a pr&eacute;cis&eacute; M.  Lerebours, ont &eacute;t&eacute; arr&ecirc;t&eacute;s &agrave; bord de motocyclettes. A ce sujet, les  autorit&eacute;s polici&egrave;res comptent prendre des mesures plus drastiques sur  la circulation et la r&eacute;glementation des motocyclettes dans la capitale  en vue de freiner les actes de banditisme li&eacute;s &agrave; ce moyen de transport.<br />
          <br />
          Le dossier de Pappadap, qui aurait &eacute;t&eacute; d&eacute;j&agrave; appr&eacute;hend&eacute; &agrave; deux reprises  par la PNH, est &agrave; nouveau confi&eacute; &agrave; la justice ha&iuml;tienne. &laquo; Nous  souhaitons que cette fois-ci Pappadap reste derri&egrave;re les barreaux, a  soupir&eacute; M. Lerebours qui n'a pas voulu affirmer si Pappadap avait &eacute;t&eacute;  d&eacute;j&agrave; captur&eacute; pour des actes de banditisme. C'est notre travail, dit-il,  d'arr&ecirc;ter les bandits; mais il est aussi du devoir de la justice de les  juger et les punir s&eacute;v&egrave;rement.&raquo;<br />
          <br />
          Face &agrave; des tueurs qui ne cessent de semer le deuil, le porte-parole de  l'institution polici&egrave;re attribue un tel ph&eacute;nom&egrave;ne &agrave; une d&eacute;ch&eacute;ance de la  soci&eacute;t&eacute;. Il estime qu'il est du devoir des institutions d'inculquer des  notions de valeur &agrave; la jeunesse afin de parvenir &agrave; la baisse du taux de  criminalit&eacute; dans le pays. Il faisait peut-&ecirc;tre allusion au nombre de  personnes incarc&eacute;r&eacute;es pour des actes criminels dans le pays, dont la  majorit&eacute; sont des jeunes de moins de trente ans.<br />
          <br />
          &laquo; Pappadap est peut-&ecirc;tre une victime de la soci&eacute;t&eacute;, quelqu'un qui n'a  jamais &eacute;t&eacute; &agrave; l'&eacute;cole, pour apprendre l'importance de la vie, avance le  commissaire. Nous devons continuer &agrave; agir pour que la soci&eacute;t&eacute; ne  reproduise plus des gens de la trempe de Franck L&eacute;onard, qui d&eacute;cident,  quand bon leur semble, de semer le deuil dans la soci&eacute;t&eacute;. &raquo;<br />
          <br />
          Regrettant la mort de son confr&egrave;re policier tu&eacute; dans la soir&eacute;e du jeudi  soir, Frantz Lerebours indique que l'inspecteur de police Lain&eacute;  Acelesse a &eacute;t&eacute; un mod&egrave;le au sein de l'institution polici&egrave;re, vu son  engagement dans la lutte contre l'ins&eacute;curit&eacute;. Il est parti &agrave; 53 ans  pour l'au-del&agrave; sous des balles assassines au cours de sa mission,  laissant quatre (4) enfants et sa femme dans la douleur. &laquo; Nous ne  pouvons pas remplacer Lain&eacute;, mais quelque part nous avons une certaine  satisfaction en appr&eacute;hendant son meurtrier &raquo;, s'est toutefois consol&eacute;  le porte-parole de l'institution polici&egrave;re avec beaucoup d'amertume.<br />
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
        <td><em>Val&eacute;ry DAUDIER<br />
          daudiervalery@yahoo.fr</em></td>
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

</body>
</html>
<?php
mysql_free_result($loggedUser);
?>
