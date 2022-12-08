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
$query_loggedUser = "SELECT * FROM utilisateur WHERE NOM_UTIL = '".$colname_loggedUser."'";
$loggedUser = mysql_query($query_loggedUser, $connex) or die(mysql_error());
$row_loggedUser = mysql_fetch_assoc($loggedUser);
$totalRows_loggedUser = mysql_num_rows($loggedUser);

$maxRows_recherche = 20;
$pageNum_recherche = 0;
if (isset($_GET['pageNum_recherche'])) {
  $pageNum_recherche = $_GET['pageNum_recherche'];
}
$startRow_recherche = $pageNum_recherche * $maxRows_recherche;

$colname_recherche = "-1";
if (isset($_GET['search'])) {
  $colname_recherche = $_GET['search'];
}
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

  $MM_redirectLoginFailed = "index.php?result=no";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_connex, $connex);
  
  $LoginRS__query=sprintf("SELECT * FROM utilisateur WHERE NOM_UTIL=%s AND MOT_PASS='$password'",
  GetSQLValueString($loginUsername, "text")); 
  
  $insertSQL = sprintf("INSERT INTO session (id_util) SELECT id_util FROM utilisateur WHERE NOM_UTIL='$loginUsername'");
   
   $selectSES=("select max(id_session) as id from session where id_util = (SELECT id_util FROM utilisateur WHERE NOM_UTIL='$loginUsername')");
   $selses = mysql_query($selectSES, $connex) or die(mysql_error());
   $fecth = mysql_fetch_assoc($selses);
   $fetch1 = $fetch['id'];
   
   $total= mysql_num_rows($selses);
  $LoginRS = mysql_query($LoginRS__query, $connex) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  $LoginRS2 = mysql_query($insertSQL, $connex) or die(mysql_error());
 

  
  if ($loginFoundUser) {
     $loginStrGroup = "";


#	================================================
#	REDIRECTION SELON LE GROUPE DE L'UTILISATEUR
#	================================================
	
	#	Trouver le groupe de l'internaute logge
		$userGroup	=	$row_loggedUser['ID_GROUPE'];
		$getGroup = "SELECT * FROM utilisateur,groupe WHERE utilisateur.ID_GROUPE = '".$userGroup."' AND utilisateur.ID_GROUPE = groupe.ID_GROUPE";
//die();		
		if($resultgetGroup = mysql_query($getGroup))
			{
				while($ligneresultgetGroup = mysql_fetch_array($resultgetGroup))
				{
						$groupe		= $ligneresultgetGroup['NOM_GROUPE'];
				}
			}
switch($groupe)
	{
		case "administrateur syren"			:	$MM_redirectLoginSuccess = "admininterf5.php";
												break;
		case "super administrateur"			:	$MM_redirectLoginSuccess = "Superadmin.php";
												break;								
		case "administrateur dgi"			:	$MM_redirectLoginSuccess = "admdgi.php";
												break;	
		case "operateur dgi"				:	$MM_redirectLoginSuccess = "admdgi.php";
												break;											
		case "administrateur ime"			:	$MM_redirectLoginSuccess = "admime.php";
												break;													
		case "administrateur archives"		:	$MM_redirectLoginSuccess = "admanh.php";
												break;
		case "administrateur oni"			:	$MM_redirectLoginSuccess = "admoni.php";
												break;
       case "administrateur justice"		:	$MM_redirectLoginSuccess = "admjust.php";
												break;	
		case "ADMINISTRATEUR TRAVAIL"		:	$MM_redirectLoginSuccess = "admmast.php";
												break;													
		case "administrateur economie"		:	$MM_redirectLoginSuccess = "admmef.php";
												break;
		case "administrateur interieur"		:	$MM_redirectLoginSuccess = "admint.php";
												break;		 
																			
	}
	
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;
	$_SESSION['id_entite']	= $row_loggedUser['ID_ENTITE'];
	$_SESSION['NOM_GROUPE'] = $groupe;
	$_SESSION['ids'] = $fetch1;


	
//  $MM_redirectLoginSuccess = "/syren/admininterf5.php";
    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
include("includes/logoutCode.php");
?>

<?php

if (isset($_GET['rech']))
{
	$flagRech = "yes";
	if ($_GET['rech'] == "ent")
	{
		$table = "entite";
		$champ = "NOM_ENTITE";
	}
	else
		{
			$table = "publications";
			$champ = "TITRE_PUB";
		}
mysql_select_db($database_connex, $connex);
 $query_recherche = sprintf("SELECT * FROM ".$table.", ADRESSE, COORDONNEES WHERE ".$table.".ID_ENTITE = ADRESSE.ID_ENTITE AND ".$table.".ID_ENTITE = COORDONNEES.ID_ENTITE AND ".$champ." LIKE %s", GetSQLValueString($colname_recherche, "text"));
$query_limit_recherche = sprintf("%s LIMIT %d, %d", $query_recherche, $startRow_recherche, $maxRows_recherche);
$recherche = mysql_query($query_limit_recherche, $connex) or die(mysql_error());
$row_recherche = mysql_fetch_assoc($recherche);

if (isset($_GET['totalRows_recherche'])) {
  $totalRows_recherche = $_GET['totalRows_recherche'];
} else {
  $all_recherche = mysql_query($query_recherche);
  $totalRows_recherche = mysql_num_rows($all_recherche);
}
$totalPages_recherche = ceil($totalRows_recherche/$maxRows_recherche)-1;

}




#==================================================
#	MODULE DE RECHERCHE
#==================================================

$searchAction = $_SERVER['PHP_SELF'];
$search = $_GET['search'];

			$requet = "SELECT * FROM entite WHERE Nom='".$search."'";
				if($result = mysql_query($requet))
					{
						while($ligne = mysql_fetch_array($result))
						{
								$nom		= $ligne['Nom'];
								$groupe		= $ligne['SECTEUR_ACTIVITE'];
								$adresse	= $ligne['STATUT'];
						}
					}				
				?> 
        


<?php
if (($_GET['act'] == "logout") && ($_SESSION['MM_Username'] == ""))
	$info ="<div class='logoutok'>Vous etes deconecte !</div>";
	
if ($_GET['act'] == "denied")
	$info ="<div class='logindenied'>Vous devez vous identifier pour acceder a cette page !</div>";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<script src="scripts/swfobject_modified.js" type="text/javascript"></script>
<script type="text/javascript">
function toggle(divToShow) {
if (document.getElementById) {
if (divToShow == "entit") {
document.getElementById('entites').style.display = "inline";
document.getElementById('publications').style.display = "none";
} else 
	{
	if (divToShow == "publi")
	{
	document.getElementById('publications').style.display = "inline";
	document.getElementById('entites').style.display = "none";
	}
	}
}
}

</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
<title>SYREN | Système de Renseignement National</title>
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
<?php
if (isset($_GET['result']))
	{
		 $r = $_GET['result'];
	

if ($r == "no")
	{
	  $warning = "<div class='warning'>Nom d'utilisateur ou mot de passe incorrect</div>";
	}}
?>

<script src="SpryAssets/SpryMenuBar.js" type="text/javascript">
</script>
<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
<script type="text/javascript">
function clearText(field){

    if (field.defaultValue == field.value) field.value = '';
    else if (field.value == '') field.value = field.defaultValue;

}

</script>
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	background-image: url();
}
body,td,th {
	font-size: xx-small;
}
-->
</style></head>

<body>

<div class="screen">
<a href="index.php">
	<div id="header">
	</div></a>
	<?php /*?><div id="left">
<?php include_once('menuleft.php')?>  </div><?php */?>
	
<!--    <div id="right">-->

		<?php
		  	

		  ?>
	<?php
		#	SI LE USER EST LOGGE, AFFICHER LE LOGIN BAR
		#	============================================
		
		if(isset($_SESSION['MM_Username']))
		{
	?>
	<?php
		}
	?>
	  <?php
			echo $info;
		?>
    
		  <?php include_once('menuh.php');?>
          <br /><br /><br />
      <table align="center" border="0" width="780" cellspacing="0" cellpadding="0">
      <tr>
      <td width="250" rowspan="10" background="im/SYREN_page-updated_04.jpg" style="background-position:center; background-repeat:no-repeat"> AFFICHER SONDAGES</td>
      <td width="200" rowspan="10" align="center">
      <object id="FlashID" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="267" height="272">
          <param name="movie" value="galeries des chefs d'etat haitien.swf" />
          <param name="quality" value="high" />
          <param name="wmode" value="opaque" />
          <param name="swfversion" value="6.0.65.0" />
          <!-- This param tag prompts users with Flash Player 6.0 r65 and higher to download the latest version of Flash Player. Delete it if you don’t want users to see the prompt. -->
          <param name="expressinstall" value="scripts/expressInstall.swf" />
          <!-- Next object tag is for non-IE browsers. So hide it from IE using IECC. -->
          <!--[if !IE]>-->
          <object type="application/x-shockwave-flash" data="galeries des chefs d'etat haitien.swf" width="267" height="272">
            <!--<![endif]-->
            <param name="quality" value="high" />
            <param name="wmode" value="opaque" />
            <param name="swfversion" value="6.0.65.0" />
            <param name="expressinstall" value="scripts/expressInstall.swf" />
            <!-- The browser displays the following alternative content for users with Flash Player 6.0 and older. -->
            <div>
              <h4>Content on this page requires a newer version of Adobe Flash Player.</h4>
              <p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" width="112" height="33" /></a></p>
            </div>
            <!--[if !IE]>-->
          </object>
          <!--<![endif]-->
        </object>
      </td>
      <td background="im/SYREN_page-updated_06.jpg"><marquee direction=up loop=true height="100">
Your text here
</marquee></td>
      </tr>
      <tr>
        <td background="im/SYREN_page-updated_07.jpg"></td>
      </tr>
      </table>
      <br />
      <br />
    <!-- </div>-->
      <br />
    
  	
		<div id="footer">
			<div class="content">
			<img src="Logo.jpg" width="116" height="49" /> <a href="#">A propos de nous </a> | <a href="#">Plan du Site </a> | <a href="#">R&egrave;gle d'utilisation </a> | <a href="#">Contactez-nous</a> | &copy;2009 SYREN
			</div>
		</div>
</div>
<script type="text/javascript">
<!--
swfobject.registerObject("FlashID");
//-->
</script>
</body>
</html>
<?php
mysql_free_result($loggedUser);

?>