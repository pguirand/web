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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}


if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE entite SET NOM_ENTITE=%s, SIGLE=%s, SECTEUR_ACTIVITE=%s, STATUT=%s, NIVEAU=%s, EMAIL1=%s, EMAIL2=%s, EMAIL3=%s, SITE_WEB=%s WHERE NUM_PATENTE=%s",
                       GetSQLValueString($_POST['Nom'], "text"),
                       GetSQLValueString($_POST['sigle'], "text"),
                       GetSQLValueString($_POST['Groupe'], "text"),
                       GetSQLValueString($_POST['statut'], "text"),
                       GetSQLValueString($_POST['Niveau'], "text"),
                       GetSQLValueString($_POST['eMail1'], "text"),
                       GetSQLValueString($_POST['eMail2'], "text"),
                       GetSQLValueString($_POST['eMail3'], "text"),
                       GetSQLValueString($_POST['siteweb'], "text"),
                       GetSQLValueString($_POST['numpat'], "text"));

  mysql_select_db($database_connex, $connex);
  $Result1 = mysql_query($updateSQL, $connex) or die(mysql_error());

  $updateGoTo = "updentitesok.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

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

mysql_select_db($database_connex, $connex);
$query_IDENTITE = "SELECT ID_ENTITE FROM entite WHERE ID_ENTITE = ID_ENTITE ORDER BY ID_ENTITE ASC";
$IDENTITE = mysql_query($query_IDENTITE, $connex) or die(mysql_error());
$row_IDENTITE = mysql_fetch_assoc($IDENTITE);
$totalRows_IDENTITE = mysql_num_rows($IDENTITE);

$colname_updateEntiteLoad = "-1";
if (isset($_GET['ID_ENTITE'])) {
  $colname_updateEntiteLoad = $_GET['ID_ENTITE'];
}
mysql_select_db($database_connex, $connex);
$query_updateEntiteLoad = sprintf("SELECT * FROM entite, adresse, coordonnees WHERE entite.ID_ENTITE = %s and entite.ID_ENTITE=adresse.id_entite and entite.ID_ENTITE = coordonnees.id_entite", GetSQLValueString($colname_updateEntiteLoad, "text"));
$updateEntiteLoad = mysql_query($query_updateEntiteLoad, $connex) or die(mysql_error());
$row_updateEntiteLoad = mysql_fetch_assoc($updateEntiteLoad);
$totalRows_updateEntiteLoad = mysql_num_rows($updateEntiteLoad);
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
.style16 {
	font-size: 36
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
		<div id="menutop" align="center">		  </div>
<div id="left">
<?php include_once('menuleft.php');?>
  </div>
	  </div>
	        
<div id="right">
  <?php
  include_once('menuh.php');
if($_GET['search'] == "")
?>
  <?php
				echo $info
			?>
  <div align="center" class="title style16"> 
      <h2>
        Forme de Modification d'entités      </h2>
  </div>
  <div class="story">
    <p>&nbsp;</p>
    <form action="<?php echo $editFormAction; ?><?php echo $editFormAction; ?>" id="form2" name="form2" method="POST">
      <table width="358" border="1" id="entiteliste">
        <tr class="head">
          <td colspan="2"><div align="center">Veuillez Remplir les champs suivants</div></td>
        </tr>
        <tr>
          <td>Numero Patente </td>
          <td><label>
              <input name="numpat" type="text" id="numpat" value="<?php echo $row_updateEntiteLoad['NUM_PATENTE']; ?>" size="17" maxlength="15" readonly="readonly"/>
          </label></td>
        <tr>
          <td width="78">Nom</td>
          <td width="215">
            <label>
              <input name="Nom" type="text" id="Nom" value="<?php echo $row_updateEntiteLoad['NOM_ENTITE']; ?>" size="50" maxlength="100" />
          </label></td>
        </tr>
        <tr>
          <td>Secteur d'activit&eacute;s</td>
          <td><label>
            <select name="Groupe" id="Groupe">
              <option value="S&eacute;curit&eacute;">S&eacute;curit&eacute;</option>
              <option value="Culture">Culture</option>
              <option value="Economie">Economie</option>
              <option selected="selected" value="Communication">Communication</option>
              <option value="Energie">Energie</option>
              <option value="Hydraulique">Hydraulique</option>
              <option value="Sant&eacute;">Sant&eacute;</option>
              <option value="Architecture">Architecture</option>
              <option value="Identification">Identification</option>
              <option value="Education">Education</option>
              <option value="Justice">Justice</option>
              <option value="Education">Education</option>
              <option value="Produits alimentaires">Produits alimentaires</option>
              <option value="jeux">jeux</option>
              <option value="Produits pharmaceutiques">Produits pharmaceutiques</option>
              <option value="Technologie">Technologie</option>
              <?php
do {  
?>
              <option value="<?php echo $row_updateEntiteLoad['SECTEUR_ACTIVITE']?>"><?php echo $row_updateEntiteLoad['SECTEUR_ACTIVITE']?></option>
              <?php
} while ($row_updateEntiteLoad = mysql_fetch_assoc($updateEntiteLoad));
  $rows = mysql_num_rows($updateEntiteLoad);
  if($rows > 0) {
      mysql_data_seek($updateEntiteLoad, 0);
	  $row_updateEntiteLoad = mysql_fetch_assoc($updateEntiteLoad);
  }
?>
                        </select>
          </label></td>
        </tr>
		              
        <tr>
          <td>Sigle</td>
          <td><input name="sigle" type="text" id="sigle" value="<?php echo $row_updateEntiteLoad['SIGLE']; ?>" size="13" maxlength="10" /></td>
        </tr>
        <tr>
          <td>Logo</td>
          <td><img src="" alt="" name="logo" width="140" height="125" id="logo" /></td>
        </tr>
        <tr>
          <td>Statut</td>
          <td><label>
              <select name="statut" id="statut">
                  <option selected="selected" value="" <?php if (!(strcmp("", $row_updateEntiteLoad['STATUT']))) {echo "selected=\"selected\"";} ?>>En Service</option>
                  <option value="" <?php if (!(strcmp("", $row_updateEntiteLoad['STATUT']))) {echo "selected=\"selected\"";} ?>>Hors-Service</option>
                  <?php
do {  
?>
                  <option value="<?php echo $row_updateEntiteLoad['STATUT']?>"<?php if (!(strcmp($row_updateEntiteLoad['STATUT'], $row_updateEntiteLoad['STATUT']))) {echo "selected=\"selected\"";} ?>><?php echo $row_updateEntiteLoad['STATUT']?></option>
                  <?php
} while ($row_updateEntiteLoad = mysql_fetch_assoc($updateEntiteLoad));
  $rows = mysql_num_rows($updateEntiteLoad);
  if($rows > 0) {
      mysql_data_seek($updateEntiteLoad, 0);
	  $row_updateEntiteLoad = mysql_fetch_assoc($updateEntiteLoad);
  }
?>
              </select>
          </label></td>
        </tr>
        <tr>
          <td>Niveau</td>
          <td><select name="Niveau" id="Niveau">
              <option>Petite</option>
              <option>Moyenne</option>
              <option>Grande</option>
              <option selected="selected">Publique</option>
            </select></td>
        </tr>
        <tr>
          <td>eMail1</td>
          <td><input name="eMail1" type="text" id="eMail1" value="<?php echo $row_updateEntiteLoad['EMAIL1']; ?>" size="23" maxlength="20" /></td>
        </tr>
        <tr>
          <td>eMail2</td>
          <td><input name="eMail2" type="text" id="eMail2" value="<?php echo $row_updateEntiteLoad['EMAIL2']; ?>" size="23" maxlength="20" /></td>
        </tr>
        <tr>
          <td>eMail3</td>
          <td><input name="eMail3" type="text" id="eMail3" value="<?php echo $row_updateEntiteLoad['EMAIL3']; ?>" size="23" maxlength="20" /></td>
        </tr>
        <tr>
          <td>Site Web </td>
          <td><input name="siteweb" type="text" id="siteweb" value="<?php echo $row_updateEntiteLoad['SITE_WEB']; ?>" size="37" maxlength="35" /></td>
        </tr>
        <tr>
          <td>Adresse </td>
          <td><input name="adresse" type="text" id="adresse" size="53" maxlength="50" /></td>
        </tr>
        <tr>
          <td>T&eacute;l&eacute;phone</td>
          <td><input name="Telephone1" type="text" id="Telephone1" value="<?php echo $row_updateEntiteLoad['NUM_TEL1']; ?>" size="17" maxlength="13" /></td>
        </tr>
        <tr>
          <td>T&eacute;l&eacute;phone</td>
          <td><input name="Telephone2" type="text" id="Telephone2" size="17" maxlength="13" /></td>
        </tr>
        <tr>
          <td>T&eacute;l&eacute;phone</td>
          <td><input name="Telephone3" type="text" id="Telephone3" value="<?php echo $row_updateEntiteLoad['NUM_TEL3']; ?>" size="17" maxlength="13" /></td>
        </tr>
        <tr>
          <td>T&eacute;l&eacute;phone</td>
          <td><input name="Telephone4" type="text" id="Telephone4" value="<?php echo $row_updateEntiteLoad['NUM_TEL4']; ?>" size="17" maxlength="13" /></td>
        </tr>
        <tr>
          <td>T&eacute;l&eacute;phone</td>
          <td><input name="Telephone5" type="text" id="Telephone5" value="<?php echo $row_updateEntiteLoad['NUM_TEL5']; ?>" size="17" maxlength="13" /></td>
        </tr>
        <tr>
          <td>T&eacute;l&eacute;phone</td>
          <td><input name="Telephone6" type="text" id="Telephone6" value="<?php echo $row_updateEntiteLoad['NUM_TEL6']; ?>" size="17" maxlength="13" /></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table>
      <p>
        <label>
        <input type="reset" name="Reset" id="button" value="Annuler" />
        </label>
        <label>
        <input type="submit" name="button2" id="button2" value="Enregistrer" /> 
        </label>
        <div align="right"><a href="admdgi.php">Retour a Administration</a></div>
      </p>
      <p>&nbsp;</p>
	                
      <input type="hidden" name="MM_update" value="form2" />
  </form>
    <p>&nbsp;</p>
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

mysql_free_result($IDENTITE);

mysql_free_result($updateEntiteLoad);
?>
<?php
$indent =  GetSQLValueString($_POST['Nom'], "text");

if ($indent != "" )
{
mysql_select_db($database_connex, $connex);
mysql_query("UPDATE COORDONNEES SET ('ID_ENTITE')=('SELECT MAX('ID_ENTITE') FROM ENTITE')"); 
mysql_close();
}
?>
