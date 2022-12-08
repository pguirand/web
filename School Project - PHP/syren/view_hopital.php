<?php require_once('Connections/connex.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

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
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
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

$colname_view_hop = "-1";
if (isset($_GET['ID_ENTITE'])) {
  $colname_view_hop = $_GET['ID_ENTITE'];
}
mysql_select_db($database_connex, $connex);
$query_view_hop = sprintf("SELECT * FROM entite WHERE ID_ENTITE = %s", GetSQLValueString($colname_view_hop, "text"));
$view_hop = mysql_query($query_view_hop, $connex) or die(mysql_error());
$row_view_hop = mysql_fetch_assoc($view_hop);
$totalRows_view_hop = mysql_num_rows($view_hop);
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
.style19 {font-size: 14px}
-->
</style>

<style type="text/css">
<!--
.style13 {font-size: 13px}
-->
</style>


<script language="JavaScript" type="text/javascript">

function setMaster() {
var form2 = opener.document.form2;
var popForm = document.popForm;
var currEl;
for (var i=0; i<popForm.length; i++) {
currEl = popForm[i];
if (form2[currEl.name]) {
form2[currEl.name].value = popForm[currEl.name].value;
}
}
if (opener && !opener.closed) opener.focus();
//self.close();
}
</script>
</head>

<body>
	        <div class="screen">
</div>
			  </div>
	        
<div id="right">
  
  <div class="story">
    <h3 align="center">Fiche Entit&eacute;</h3>
  </div>
  <div class="story">
    <fieldset>
    <legend><span class="style10">Infos Generales</span></legend>
    <table width="98%" border="0" cellpadding="4" cellspacing="0" id="comliste">
      <tr>
        <td colspan="3" class="style13">Nom EntitE:<span class="fonce style19"><?php echo $row_view_hop['NOM_ENTITE']; ?></span>
          <input type="hidden" name="ident" id="ident"  value="<?php echo $row_view_hop['ID_ENTITE']; ?>"/></td>
      </tr>

      <tr>
        <td width="449" class="style13">No Patente:<strong><?php echo $row_updateEntiteLoad['NUM_PATENTE']; ?></strong></td>
        <td width="89" class="style13">Logo:</td>
        <td width="120" rowspan="5" class="style13"><img src="<?php echo $row_updateEntiteLoad['LOGO']; ?>" width="102" height="111" align="right" ></td>
      </tr>

      <tr>
        <td class="style13">Sigle : <strong><?php echo $row_updateEntiteLoad['SIGLE']; ?></strong> </td>
        <td class="style13">&nbsp;</td>
      </tr>
      <tr>
        <td class="style13">Date d'enregistrement : <strong><?php echo date ('j-M-Y h:i:s A',$row_updateEntiteLoad['DATE_SAVE']);?></strong></td>
        <td class="style13">&nbsp;</td>
      </tr>
      <tr>
        <td class="style13">Secteur d'activit&eacute;s:<strong><?php echo $row_updateEntiteLoad['SECTEUR_ACTIVITE']; ?></strong></td>
        <td class="style13">&nbsp;</td>
      </tr>
      <tr>
        <td height="22" class="style13">Niveau entreprise :<strong><?php echo $row_updateEntiteLoad['NIVEAU']; ?></strong></td>
        <td class="style13">&nbsp;</td>
      </tr>
      <tr>
        <td class="style13">site web :<strong><?php echo $row_updateEntiteLoad['SITE_WEB']; ?></strong></td>
        <td class="style13">&nbsp;</td>
        <td class="style13">&nbsp;</td>
      </tr>
      <tr>
        <td class="style13">Email :<strong><?php echo $row_updateEntiteLoad['EMAIL1']; ?>/<?php echo $row_updateEntiteLoad['EMAIL2']; ?>/<?php echo $row_updateEntiteLoad['EMAIL3']; ?></strong></td>
        <td class="style13">Photo:</td>
        <td rowspan="11" class="style13"><img src="images/photos/entites/<?php echo $row_updateEntiteLoad['photo']; ?>" width="109" height="115"></td>
      </tr>
      <tr>
        <td class="style13">Adresse:<strong><?php echo $row_updateEntiteLoad['NUM_EDIFICE']; ?>,&nbsp;<?php echo $row_updateEntiteLoad['NOM_RUE']; ?> </strong></td>
        <td class="style13">&nbsp;</td>
      </tr>
      <tr>
        <td class="style13">Section communale: <strong><?php echo $row_updateEntiteLoad['NOM_SECCOM']; ?></strong></td>
        <td class="style13">&nbsp;</td>
      </tr>
      <tr>
        <td class="style13">Commune:<strong><?php echo $row_updateEntiteLoad['NOM_COM']; ?></strong></td>
        <td class="style13">&nbsp;</td>
      </tr>
      <tr>
        <td class="style13">Arrondissement: <strong><?php echo $row_updateEntiteLoad['NOM_ARRON']; ?></strong></td>
        <td class="style13">&nbsp;</td>
      </tr>
      <tr>
        <td class="style13">Departement: <strong><?php echo $row_updateEntiteLoad['NOM_DEPT']; ?></strong></td>
        <td class="style13">&nbsp;</td>
      </tr>
      <tr>
        <td class="style13">T&eacute;l&eacute;phone1  : <strong><?php echo $row_updateEntiteLoad['NUM_TEL1']; ?></strong></td>
        <td class="style13">&nbsp;</td>
      </tr>
      <tr>
        <td class="style13">T&eacute;l&eacute;phone2:<strong><?php echo $row_updateEntiteLoad['NUM_TEL2']; ?></strong></td>
        <td class="style13">&nbsp;</td>
      </tr>
      <tr>
        <td class="style13">&nbsp;</td>
        <td class="style13">&nbsp;</td>
      </tr>
      <tr>
        <td class="style13">&nbsp;</td>
        <td class="style13">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>
    </fieldset>
    
    <form name="popForm" onsubmit="setMaster()">
                <input name="NOMENT" type="hidden" value="<?php echo $row_view_hop['ID_ENTITE']; ?>">
                <input type="submit" value="Selectionner">
    </form>            
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

mysql_free_result($view_hop);
?>
