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
$query_updateEntiteLoad = sprintf("SELECT * FROM entite WHERE ID_ENTITE = %s", GetSQLValueString($colname_updateEntiteLoad, "text"));
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
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/index.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
<!-- InstanceBeginEditable name="doctitle" -->
<title>Untitled Document</title>
<!-- InstanceEndEditable -->
<link href="css/style.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style10 {font-size: 10px}
#search {		background-color:#eee;
}
.style12 {font-size: 12px}
-->
</style>
<script src="../SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<!-- InstanceBeginEditable name="head" -->
<style type="text/css">
<!--
.style16 {
	font-size: 36
}
-->
</style>
<!-- InstanceEndEditable -->
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
		<div id="menutop" align="center">
        <!-- InstanceBeginEditable name="EditRegion4" -->
		 <ul id="MenuBar1" class="MenuBarHorizontal">
          <div class="idsection"> Direction Generale des Impots || DGI </div>
           <div class="loginbar">
            <div class="text">
                Bienvenue, <span class="fonce"><?php echo $_SESSION['MM_Username']; ?></span> :: Vous &ecirc;tes <span class="fonce"><?php echo $_SESSION['NOM_GROUPE']; ?> </span>            </div>
            <span class="logout"><a href="<?php echo $logoutAction ?>">Deconnexion</a></span>
            <div class="spacer"></div>
          </div>
            <li><a class="MenuBarItemSubmenu" href="#">Entites</a>
                <ul>
                  <li><a href="saveentites.php">Enregistrer</a></li>
                  <li><a href="list_entites.php">Lister</a></li>
                  <li><a href="rech_entites.php">Rechercher</a></li>
                </ul>
            </li>
		    <li><a href="#" class="MenuBarItemSubmenu">Individus</a>
		      <ul>
		        <li><a href="#">Enregistrer</a></li>
		        <li><a href="#">Modifier</a></li>
		        <li><a href="#">Lister</a></li>
		        <li><a href="#">Rechercher</a></li>
		      </ul>
	        </li>
		    <li><a href="#">Recherche Avanc&eacute;e</a></li>
		    <li><a href="#">Actualites</a></li>
		    <li><a href="#">Culture</a></li>
		    <li><a href="#">Forums</a></li>
	    </ul>
		<!-- InstanceEndEditable --></div>
<div id="left">
          <div id="search">
            <form action="<?php echo $searchAction ?>">
              <label>Recherche Rapide </label>
              <p>
                <input name="search" type="text" value="<?php echo $_GET['search'] ?>" />
              </p>
              <table width="167">
                <tr>
                  <td width="60"><label>
                    <input name="rech" type="radio" value="ent" checked="checked" />
                    <span class="style10">Entites</span></label></td>
                  <td width="95"><input type="radio" name="rech" value="publ" />
                      <span class="style10">Publications</span></td>
                </tr>
              </table>
              <p>
                <input name="goButton" type="submit" value="Lancer la recherche" />
              </p>
            </form>
          </div>
		  <div id="section">
<?php
if($_SESSION['MM_Username'] == "")
			{
			?>
              <form id="form1" name="form1" method="POST" action="<?php echo $loginFormAction; ?>">
                <table border="0">
                  <tr>
                    <td colspan="2"><div align="center" class="style13"><strong>Connexion</strong></div></td>
                  </tr>
                  <tr>
                    <td><span class="style13">Utilisateur</span></td>
<td><label>
                      <input name="NOM_UTIL" type="text" id="NOM_UTIL" size="15" />
                    </label></td>
                  </tr>
                  <tr>
                    <td><span class="style12 style13">Mot de passe </span></td>
<td><label>
                      <input name="MOT_PASS" type="password" id="MOT_PASS" size="15" />
                    </label></td>
                  </tr>
                </table>
                <br />
                <label>
               
                  <input type="submit" name="Submit" value="Connexion" />
              
                </label>
                <p><?php echo $warning; ?></p>
                <p align="center"><a href="#">Mot de passe oubli&eacute;?</a></p>
              </form>
              <?php
			  }
			  ?>
	      </div>
		  <div class="section">
            <div class="title">Actualit&eacute;s </div>
		    <ul><li></li>
		      <li></li>
		      <li><a href="entites.php?type=nongouv">
		        <!--<a href="javascript:ajaxpage('entites.php', 'content');">-->
		        </a></li>
		      <li><a href="actugen.php?">G&eacute;n&eacute;rales</a><a href="#"></a></li>
              <li><a href="entites.php?type=nongouv">Sport</a><a href="#"></a></li>
		      <li><a href="#">Culture</a></li>
	          <li><a href="#">A travers le monde...</a></li>
		    </ul>
      </div>
		  <div class="section">
            <div class="title">Forums</div>
		    <ul>
              <li>S'inscrire</li>
		      <li>Rechercher</li>
		      <li>Participer<a href="#">.</a></li>
	          <li>Visiter</li>
		    </ul>
      </div>
      <div class="section">
            <div class="title">Divers</div>
		    <ul>
              <li>Statistiques sur individus</li>
		      <li>Statitisques sur entites</li>
		      <li>Autres Statisques</li>
	          <li>Centre de sondages</li>
		    </ul>
      </div>
  </div>
	  </div>
	        <!-- InstanceBeginEditable name="Right" -->
		    <div id="right">
<?php
if($_GET['search'] == "")
?>
            <?php
				echo $info
			?>
            <div align="center" class="title style16"> 
                <h2>
				Forme de Modification d'entités
				</h2>
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
                        	<option value="" <?php if (!(strcmp("", $row_updateEntiteLoad['SECTEUR_ACTIVITE']))) {echo "selected=\"selected\"";} ?>>S&eacute;curit&eacute;</option>
                        	<option value="" <?php if (!(strcmp("", $row_updateEntiteLoad['SECTEUR_ACTIVITE']))) {echo "selected=\"selected\"";} ?>>Culture</option>
<option value="" <?php if (!(strcmp("", $row_updateEntiteLoad['SECTEUR_ACTIVITE']))) {echo "selected=\"selected\"";} ?>>Economie</option>
                        	<option selected="selected" value="" <?php if (!(strcmp("", $row_updateEntiteLoad['SECTEUR_ACTIVITE']))) {echo "selected=\"selected\"";} ?>>Communication</option>
                        	<option value="" <?php if (!(strcmp("", $row_updateEntiteLoad['SECTEUR_ACTIVITE']))) {echo "selected=\"selected\"";} ?>>Energie</option>
                        	<option value="" <?php if (!(strcmp("", $row_updateEntiteLoad['SECTEUR_ACTIVITE']))) {echo "selected=\"selected\"";} ?>>Hydraulique</option>
                        	<option value="" <?php if (!(strcmp("", $row_updateEntiteLoad['SECTEUR_ACTIVITE']))) {echo "selected=\"selected\"";} ?>>Sant&eacute;</option>
                        	<option value="" <?php if (!(strcmp("", $row_updateEntiteLoad['SECTEUR_ACTIVITE']))) {echo "selected=\"selected\"";} ?>>Architecture</option>
                        	<option value="" <?php if (!(strcmp("", $row_updateEntiteLoad['SECTEUR_ACTIVITE']))) {echo "selected=\"selected\"";} ?>>Identification</option>
                        	<option value="" <?php if (!(strcmp("", $row_updateEntiteLoad['SECTEUR_ACTIVITE']))) {echo "selected=\"selected\"";} ?>>Education</option>
                        	<option value="" <?php if (!(strcmp("", $row_updateEntiteLoad['SECTEUR_ACTIVITE']))) {echo "selected=\"selected\"";} ?>>Justice</option>
                        	<?php
do {  
?>
                        	<option value="<?php echo $row_updateEntiteLoad['SECTEUR_ACTIVITE']?>"<?php if (!(strcmp($row_updateEntiteLoad['SECTEUR_ACTIVITE'], $row_updateEntiteLoad['SECTEUR_ACTIVITE']))) {echo "selected=\"selected\"";} ?>><?php echo $row_updateEntiteLoad['SECTEUR_ACTIVITE']?></option>
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
                    
                    </tr>
                    <tr>
                      <td>Sigle</td>
                      <td><input name="sigle" type="text" id="sigle" value="<?php echo $row_updateEntiteLoad['SIGLE']; ?>" size="13" maxlength="10" /></td>
                    </tr>
                    <tr>
                      <td>Logo</td>
                      <td><input type="file" name="logo" id="logo" /></td>
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
                      <td><input name="Telephone1" type="text" id="Telephone1" size="17" maxlength="13" /></td>
                    </tr>
                    <tr>
                      <td>T&eacute;l&eacute;phone</td>
                      <td><input name="Telephone2" type="text" id="Telephone2" size="17" maxlength="13" /></td>
                    </tr>
                    <tr>
                      <td>T&eacute;l&eacute;phone</td>
                      <td><input name="Telephone3" type="text" id="Telephone3" size="17" maxlength="13" /></td>
                    </tr>
                    <tr>
                      <td>T&eacute;l&eacute;phone</td>
                      <td><input name="Telephone4" type="text" id="Telephone4" size="17" maxlength="13" /></td>
                    </tr>
                    <tr>
                      <td>T&eacute;l&eacute;phone</td>
                      <td><input name="Telephone5" type="text" id="Telephone5" size="17" maxlength="13" /></td>
                    </tr>
                    <tr>
                      <td>T&eacute;l&eacute;phone</td>
                      <td><input name="Telephone6" type="text" id="Telephone6" size="17" maxlength="13" /></td>
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
               
  <!-- InstanceEndEditable -->
  <div class="spacer"></div>
		<div id="footer">
			<div class="content">
			<img src="../Logo.jpg" width="116" height="49" /> <a href="#">A propos de nous </a> | <a href="#">Plan du Site </a> | <a href="#">R&egrave;gle d'utilisation </a> | <a href="#">Contactez-nous</a> | &copy;2009 SYREN
			</div>
		</div>
</div>
<script type="text/javascript">
<!--
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"/syren/SpryAssets/SpryMenuBarDownHover.gif", imgRight:"/syren/SpryAssets/SpryMenuBarRightHover.gif"});
//-->
</script>
</body>
<!-- InstanceEnd --></html>
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
