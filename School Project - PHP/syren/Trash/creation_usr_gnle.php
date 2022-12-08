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
?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "index.php?act=denied";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO utilisateur (NOM_UTIL, MOT_PASS, STATUT, ID_GROUPE, ID_ENTITE, ID_IND, CREER_PAR) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['NOM_UTIL'], "text"),
                       GetSQLValueString($_POST['MOT_PASS'], "text"),
                       GetSQLValueString($_POST['STATUT'], "text"),
                       GetSQLValueString($_POST['ID_GROUPE'], "int"),
                       GetSQLValueString($_POST['ID_ENT'], "text"),
                       GetSQLValueString($_POST['ID_IND'], "text"),
					   GetSQLValueString($_SESSION['MM_Username'], "text"));

  mysql_select_db($database_connex, $connex);
  $Result1 = mysql_query($insertSQL, $connex) or die(mysql_error());

  $insertGoTo = "saveutilok.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>

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

mysql_select_db($database_connex, $connex);
$query_SELECTGROUP = "SELECT * FROM groupe";
$SELECTGROUP = mysql_query($query_SELECTGROUP, $connex) or die(mysql_error());
$row_SELECTGROUP = mysql_fetch_assoc($SELECTGROUP);
$totalRows_SELECTGROUP = mysql_num_rows($SELECTGROUP);

mysql_select_db($database_connex, $connex);
$query_IDENTIT = "SELECT entite.ID_ENTITE, entite.NOM_ENTITE FROM entite WHERE entite.SIGLE like 'dgi' union SELECT entite.ID_ENTITE, entite.NOM_ENTITE FROM entite WHERE entite.SIGLE like 'mast' union SELECT entite.ID_ENTITE, entite.NOM_ENTITE FROM entite WHERE entite.SIGLE like 'ime' union SELECT entite.ID_ENTITE, entite.NOM_ENTITE FROM entite WHERE entite.SIGLE like 'mef' union SELECT entite.ID_ENTITE, entite.NOM_ENTITE FROM entite WHERE entite.SIGLE like 'MICTSN' union SELECT entite.ID_ENTITE, entite.NOM_ENTITE FROM entite WHERE entite.SIGLE like 'mjsp' union SELECT entite.ID_ENTITE, entite.NOM_ENTITE FROM entite WHERE entite.SIGLE like 'oni' union SELECT entite.ID_ENTITE, entite.NOM_ENTITE FROM entite WHERE entite.SIGLE like 'anh'";
$IDENTIT = mysql_query($query_IDENTIT, $connex) or die(mysql_error());
$row_IDENTIT = mysql_fetch_assoc($IDENTIT);
$totalRows_IDENTIT = mysql_num_rows($IDENTIT);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/admdgi.dwt.php" codeOutsideHTMLIsLocked="false" -->
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
#Layer1 {
	position:absolute;
	left:139px;
	top:253px;
	width:125px;
	height:33px;
	z-index:1;
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
          <div class="idsection"> Formulaire de création d'utilisateur </div>
           <div class="loginbar">
            <div class="text">
                Bienvenue, <span class="fonce"><?php echo $_SESSION['MM_Username']; ?>
                </span> :: Vous &ecirc;tes <span class="fonce">
				<?php echo $_SESSION['NOM_GROUPE']; ?> 
                </span></div>
            <span class="logout"><a href="<?php echo $logoutAction ?>">Deconnexion</a></span>
            <div class="spacer"></div>
          </div>
            <li><a class="MenuBarItemSubmenu" href="#">Entites</a>
                <ul>
                  <li><a href="saveentites.php">Enregistrer</a></li>
                  <li><a href="list_entites.php">Lister entit&eacute;s</a></li>
                  <li><a href="rech_simple_entite.php">Rechercher</a></li>
                  <li><a href="#">Recherche Avanc&eacute;e</a></li>
                </ul>
            </li>
		    <li><a href="#" class="MenuBarItemSubmenu">Individus</a>
		      <ul>
		        <li><a href="#">Rechercher</a></li>
		        <li><a href="rech_av_ind.php">Recherche Avancee</a></li>
		        <li><a href="saveind.php">Assignation NIF...</a></li>
		      </ul>
	        </li>
		    <li><a href="#" class="MenuBarItemSubmenu">Utilisateurs</a>
                <ul>
                  <li><a href="presaveuser.php">Cr&eacute;er</a></li>
                  <li><a href="liste_user.php">Lister utilisateurs</a></li>
                  <li><a href="#">Rechercher</a></li>
                </ul>
	        </li>
		    <li><a href="#">Actualit&eacute;s</a></li>
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
<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <table width="333" border="2">
    <tr>
      <td colspan="2"><div align="center"><strong>Param&egrave;tres Utilisateur </strong></div></td>
    </tr>
    <tr>
      <td>Nom entit&eacute;</td>
      <td><label>
      <select name="ID_ENTIT" id="ID_ENTIT">
        <?php
do {  
?>
        <option value="<?php echo $row_IDENTIT['ID_ENTITE']?>"<?php if (!(strcmp($row_IDENTIT['ID_ENTITE'], $row_IDENTIT['NOM_ENTITE']))) {echo "selected=\"selected\"";} ?>><?php echo $row_IDENTIT['NOM_ENTITE']?></option>
        <?php
} while ($row_IDENTIT = mysql_fetch_assoc($IDENTIT));
  $rows = mysql_num_rows($IDENTIT);
  if($rows > 0) {
      mysql_data_seek($IDENTIT, 0);
	  $row_IDENTIT = mysql_fetch_assoc($IDENTIT);
  }
?>
      </select>
      </label></td>
    </tr>
    <tr>
      <td width="129"><div align="left">Nom utilisateur </div></td>
      <td width="188"><label>
        <input name="NOM_UTIL" type="text" id="NOM_UTIL" maxlength="8" />
      </label></td>
    </tr>
    <tr>
      <td><div align="left">Mot de passe </div></td>
      <td><input name="MOT_PASS" type="password" id="MOT_PASS" maxlength="8" /></td>
    </tr>
    <tr>
      <td><div align="left">Groupe</div></td>
      <td><label>
        <select name="ID_GROUPE" id="ID_GROUPE">
          <?php
do {  
?>
          <option value="<?php echo $row_SELECTGROUP['ID_GROUPE']?>"><?php echo $row_SELECTGROUP['NOM_GROUPE']?></option>
          <?php
} while ($row_SELECTGROUP = mysql_fetch_assoc($SELECTGROUP));
  $rows = mysql_num_rows($SELECTGROUP);
  if($rows > 0) {
      mysql_data_seek($SELECTGROUP, 0);
	  $row_SELECTGROUP = mysql_fetch_assoc($SELECTGROUP);
  }
?>
        </select>
      </label></td>
    </tr>
    <tr>
      <td><div align="left">Statut</div></td>
      <td><label>
        <select name="STATUT" id="STATUT">
          <option>Actif</option>
          <option>Inactif</option>
        </select>
      </label></td>
    </tr>
  </table>
  <p>
    <input type="submit" name="Submit" value="Valider" />
    <input type="reset" name="Submit2" value="Annuler" />
  </p>
  <p>
    <label></label>
    <label></label>
    <input type="hidden" name="MM_insert" value="form1">
    <input name="ID_IND" type="hidden" id="ID_IND" value="<?php echo $_GET['ID_IND'] ?>" readonly="readonly" />
  </p>
  </form>
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
mysql_free_result($SELECTGROUP);

mysql_free_result($IDENTIT);
?>
