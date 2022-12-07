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
 echo $colname_loggedUser = $_POST['NOM_UTIL'];
}
mysql_select_db($database_connex, $connex);
$query_loggedUser = sprintf("SELECT * FROM utilisateur WHERE NOM_UTIL = %s", GetSQLValueString($colname_loggedUser, "text"));
$loggedUser = mysql_query($query_loggedUser, $connex) or die(mysql_error());
$row_loggedUser = mysql_fetch_assoc($loggedUser);
echo $idutil=$row_loggedUser['ID_UTIL'];
$totalRows_loggedUser = mysql_num_rows($loggedUser);

mysql_select_db($database_connex, $connex);
$query_ident = "SELECT * FROM individu";
$ident = mysql_query($query_ident, $connex) or die(mysql_error());
$row_ident = mysql_fetch_assoc($ident);
$totalRows_ident = mysql_num_rows($ident);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

  $dates = $_POST['jour']."-".$_POST['mois']."-".$_POST['an']."".$_POST['heure'].":".$_POST['min'];
  $dateb = $_POST['jour'].$_POST['mois'].$_POST['an'];
  $date = strtotime($dates);
  $datef = date('Y-m-j H:i:s',$date);
  $name = strtoupper(substr($_POST['PRENOM_IND'],1,2).substr($_POST['NOM_IND'],-3,2));
  $IDIND = $name.$dateb.$totalRows_ident;
  $IDSECCOM = $_POST['secom'];
  echo $_SESSION['MM_Username'];

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
	$dates = $_POST['jour']."-".$_POST['mois']."-".$_POST['an']."".	$_POST['heure'].":".$_POST['min'];
	$date = strtotime($dates);
	$format = date ('Y-m-j H:i:s',$date);
	$formatH = time ('H:i:s',$date);
	$formatD = date ('Y-m-j',$date);
	
  $insertSQL = sprintf("INSERT INTO individu (G_SANG_IND, SEXE_IND, NOM_IND, PRENOM_IND, DATEH_NAIS, NATIONALITE_INDIVIDU, ID_IND, NUM_IDENTIFIANT_PERE, NUM_IDENTIFIANT_MERE, NUM_IDENTIFIANT_OEC, NUM_IDENTIFIANT_TEMOIN1, NUM_IDENTIFIANT_TEMOIN2, CHAMP_CREE_PAR) VALUES (%s, %s, %s, %s, %s, %s,%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['G_SANG_IND'], "text"),
                       GetSQLValueString($_POST['SEXE_IND'], "text"),
                       GetSQLValueString($_POST['NOM_IND'],"text"),
                       GetSQLValueString($_POST['PRENOM_IND'], "text"),
                       GetSQLValueString($format, "date"),
					   GetSQLValueString($_POST['NATIONALITE_INDIVIDU'], "text"),
					   GetSQLValueString($IDIND, "text"),
					   GetSQLValueString($_POST['id'], "text"),				
					   GetSQLValueString($_POST['idm'], "text"),
					   GetSQLValueString($_POST['idoec'], "text"),
					   GetSQLValueString($_POST['id1'], "text"),
					   GetSQLValueString($_POST['id2'], "text"),
					   GetSQLValueString($UTILI, "text"));
					   

  mysql_select_db($database_connex, $connex);
  $Result1 = mysql_query($insertSQL, $connex) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO adresse (NOM_RUE, ID_IND, ID_SECCOM) VALUES (%s,%s, %s)",
                       GetSQLValueString($_POST['NOM_RUE'], "text"),
					   GetSQLValueString($IDIND, "text"),
					   GetSQLValueString($_POST['secom'], "int"));

  mysql_select_db($database_connex, $connex);
  $Result1 = mysql_query($insertSQL, $connex) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO document (NO_DOC, TYPE_DOC, LIEU_EVENNEMENT, DATE_EVENNEMENT, HEURE_EVENNEMENT, ID_IND) VALUES (%s, %s, %s,%s, %s, %s)",
                       GetSQLValueString($_POST['NO_DOC'], "text"),
					   GetSQLValueString($_POST['TYPE_DOC'], "text"),
                       GetSQLValueString($_POST['LIEU_EVENNEMENT'], "text"),
					   GetSQLValueString($formatD, "date"),
					   GetSQLValueString($formatH, "time"),
					   GetSQLValueString($IDIND, "text"));

  mysql_select_db($database_connex, $connex);
  $Result1 = mysql_query($insertSQL, $connex) or die(mysql_error());
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

/* database configuration */
$dbConfig['type']="mysql";
$dbConfig['server']="localhost";
$dbConfig['username']="root";
$dbConfig['password']="";
$dbConfig['database']="syren";

if ($_GET['act'] == "logout")
	$info ="<div class='logoutok'>Vous etes deconecte !</div>";
	
if ($_GET['act'] == "denied")
	$info ="<div class='logindenied'>Vous devez vous identifier pour acceder a cette page !</div>";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/admdgi.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
<!-- InstanceBeginEditable name="doctitle" -->
<title>SYREN | Syst&egrave;me de Renseignement National</title>
<script language="JavaScript" type="text/javascript">
<!-- hide

var Fwin = null;
Fwin_Wid = 480;
Fwin_Hgt = 440;
Fwin_Left = (screen) ? screen.width/2 - Fwin_Wid/2 : 100;
Fwin_Top =  (screen) ? screen.availHeight/2 - Fwin_Hgt/2 : 100;
function openFormWin(url) {
Fwin = open(url,'Fwin','width='+Fwin_Wid+',height='+Fwin_Hgt+',left='+
Fwin_Left+',top='+Fwin_Top+',status=0');
setTimeout('Fwin.focus()',100);
document.getElementById('prop').style.display='inline';
}
function openFormWin2(url) {
Fwin = open(url,'Fwin','width='+Fwin_Wid+',height='+Fwin_Hgt+',left='+
Fwin_Left+',top='+Fwin_Top+',status=0');
setTimeout('Fwin.focus()',100);
document.getElementById('prop1').style.display='inline';
}
function openFormWin3(url) {
Fwin = open(url,'Fwin','width='+Fwin_Wid+',height='+Fwin_Hgt+',left='+
Fwin_Left+',top='+Fwin_Top+',status=0');
setTimeout('Fwin.focus()',100);
document.getElementById('prop2').style.display='inline';
}
function openFormWin4(url) {
Fwin = open(url,'Fwin','width='+Fwin_Wid+',height='+Fwin_Hgt+',left='+
Fwin_Left+',top='+Fwin_Top+',status=0');
setTimeout('Fwin.focus()',100);
document.getElementById('prop3').style.display='inline';
}
function openFormWin5(url) {
Fwin = open(url,'Fwin','width='+Fwin_Wid+',height='+Fwin_Hgt+',left='+
Fwin_Left+',top='+Fwin_Top+',status=0');
setTimeout('Fwin.focus()',100);
document.getElementById('prop4').style.display='inline';
}
</script>
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
.style16 {font-size: 11px}
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
        <div class="loginbar">
            <div class="text">
                Bienvenue, <span class="fonce"><?php echo $_SESSION['MM_Username']; ?></span> :: Vous &ecirc;tes <span class="fonce"><?php echo $_SESSION['NOM_GROUPE']; ?> </span>            </div>
            <span class="logout"><a href="<?php echo $logoutAction ?>">Deconnexion</a></span>
            <div class="spacer"></div>
          </div>
        <ul id="MenuBar1" class="MenuBarHorizontal">
        <li><a class="MenuBarItemSubmenu" href="#">Entites</a>
                <ul>
                  <li><a href="#">Rechercher</a></li>
                  <li><a href="#">Lister</a></li>
              </ul>
            </li>
		    <li><a href="#">Actualites</a></li>
	      <li><a class="MenuBarItemSubmenu" href="#">Evenements</a>
                <ul>
                  <li><a class="MenuBarItemSubmenu" href="#">Item 3.1</a>
                      <ul>
                        <li><a href="#">Item 3.1.1</a></li>
                        <li><a href="#">Item 3.1.2</a></li>
                    </ul>
                  </li>
                  <li><a href="#">Item 3.2</a></li>
                  <li><a href="#">Item 3.3</a></li>
            </ul>
	        </li>
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
              <p>
                <?php
if($_GET['search'] == "")
	{
?>
                <?php
				echo $info
			?>
              </p>
              <div class="story">
                <div align="center" class="fonce">
                  <p>FORMULAIRE D'ENREGISTREMENT D'UN INDIVIDU</p>
                </div>
                <form id="form2" name="form2" method="POST" action="<?php echo $editFormAction; ?>">
		          <table border="0" cellpadding="0" cellspacing="0" id="midTable" align="center">
                    <tr class="head">
                      <td colspan="6" class="header" align="center">INFORMATIONS A REMPLIR</td>
                    </tr>
                    <tr>
                      <td width="86">TYPE DOCUMENT</td>
                      <td colspan="2"><span class="style10 style10 style16">
                      <input name="TYPE_DOC" type="text" id="TYPE_DOC" value="NAISSANCE" size="20" readonly="readonly"/>
                      </span></td>
                      <td width="78">NUMERO DOCUMENT</td>
                      <td colspan="2"><input name="NO_DOC" type="text" id="NO_DOC" size="20" maxlength="8" /></td>
                    </tr>
                    <tr>
                      <td>NOM </td>
                      <td colspan="2"><input name="NOM_IND" type="text" id="NOM_IND" size="20" /></td>
                      <td>PRENOM</td>
                      <td colspan="2"><input name="PRENOM_IND" type="text" id="PRENOM_IND" size="33" /></td>
                    </tr>
                    <tr>
                      <td>SEXE</td>
                      <td width="122"><span class="style16">
                        <label>
                          <select name="SEXE_IND" id="SEXE_IND">
                            <option>Masculin</option>
                            <option>Feminin</option>
                          </select>
                        </label>
                      </span></td>
                      <td width="56">GROUPE SANGUIN</td>
                      <td><select name="G_SANG_IND" id="G_SANG_IND">
                        <option selected="selected">A+</option>
                        <option>A-</option>
                        <option>O+</option>
                        <option>O-</option>
                        <option>B+</option>
                        <option>B-</option>
                        <option>AB+</option>
                        <option>AB-</option>
                      </select></td>
                      <td width="83">NATIONALITE</td>
                      <td width="135"><select name="NATIONALITE_INDIVIDU" id="NATIONALITE_INDIVIDU">
                        <option>Haitienne</option>
                        <option>Autre...</option>
                      </select></td>
                    </tr>
                    <tr>
                      <td>DATE DE NAISSANCE</td>
                      <td colspan="5"><span class="style16">
                        <label>Jour
                          <select name="jour" id="jour">
                            <option selected="selected">01</option>
                            <option>02</option>
                            <option>03</option>
                            <option>04</option>
                            <option>05</option>
                            <option>06</option>
                            <option>07</option>
                            <option>08</option>
                            <option>09</option>
                            <option>10</option>
                            <option>11</option>
                            <option>12</option>
                            <option>13</option>
                            <option>14</option>
                            <option>15</option>
                            <option>16</option>
                            <option>17</option>
                            <option>18</option>
                            <option>19</option>
                            <option>20</option>
                            <option>21</option>
                            <option>22</option>
                            <option>23</option>
                            <option>24</option>
                            <option>25</option>
                            <option>26</option>
                            <option>27</option>
                            <option>28</option>
                            <option>29</option>
                            <option>30</option>
                            <option>31</option>
                            <option>--</option>
                        </select>
  &nbsp;
                          &nbsp;
                          Mois
                          <select name="mois" id="mois">
                               <option>01</option>
                            <option>02</option>
                            <option>03</option>
                            <option>04</option>
                            <option>05</option>
                            <option>06</option>
                            <option>07</option>
                            <option>08</option>
                            <option>09</option>
                            <option>10</option>
                            <option>11</option>
                            <option>12</option>
                        </select>
  &nbsp;&nbsp;
                        AnnEe
                          <select name="an" id="an">
                            <option>1800</option>
                            <option>1801</option>
                            <option>1802</option>
                            <option>1803</option>
                            <option>1804</option>
                            <option>1805</option>
                            <option>1806</option>
                            <option>1807</option>
                            <option>1808</option>
                            <option>1809</option>
                            <option>1810</option>
                            <option>1811</option>
                            <option>1812</option>
                            <option>1813</option>
                            <option>1814</option>
                            <option>1815</option>
                            <option>1816</option>
                            <option>1817</option>
                            <option>1818</option>
                            <option>1819</option>
                            <option>1820</option>
                            <option>1821</option>
                            <option>1822</option>
                            <option>1823</option>
                            <option>1824</option>
                            <option>1825</option>
                            <option>1826</option>
                            <option>1827</option>
                            <option>1828</option>
                            <option>1829</option>
                            <option>1830</option>
                            <option>1831</option>
                            <option>1832</option>
                            <option>1833</option>
                            <option>1834</option>
                            <option>1835</option>
                            <option>1836</option>
                            <option>1837</option>
                            <option>1838</option>
                            <option>1839</option>
                            <option>1840</option>
                            <option>1841</option>
                            <option>1842</option>
                            <option>1843</option>
                            <option>1844</option>
                            <option>1845</option>
                            <option>1846</option>
                            <option>1847</option>
                            <option>1848</option>
                            <option>1849</option>
                            <option>1850</option>
                            <option>1851</option>
                            <option>1852</option>
                            <option>1853</option>
                            <option>1854</option>
                            <option>1855</option>
                            <option>1856</option>
                            <option>1857</option>
                            <option>1858</option>
                            <option>1859</option>
                            <option>1860</option>
                            <option>1861</option>
                            <option>1862</option>
                            <option>1863</option>
                            <option>1864</option>
                            <option>1865</option>
                            <option>1866</option>
                            <option>1867</option>
                            <option>1868</option>
                            <option>1869</option>
                            <option>1870</option>
                            <option>1871</option>
                            <option>1872</option>
                            <option>1873</option>
                            <option>1874</option>
                            <option>1875</option>
                            <option>1876</option>
                            <option>1877</option>
                            <option>1878</option>
                            <option>1879</option>
                            <option>1880</option>
                            <option>1881</option>
                            <option>1882</option>
                            <option>1883</option>
                            <option>1884</option>
                            <option>1885</option>
                            <option>1886</option>
                            <option>1887</option>
                            <option>1888</option>
                            <option>1889</option>
                            <option>1890</option>
                            <option>1891</option>
                            <option>1892</option>
                            <option>1893</option>
                            <option>1894</option>
                            <option>1895</option>
                            <option>1896</option>
                            <option>1897</option>
                            <option>1898</option>
                            <option>1899</option>
                            <option>1900</option>
                            <option>1901</option>
                            <option>1902</option>
                            <option>1903</option>
                            <option>1904</option>
                            <option>1905</option>
                            <option>1906</option>
                            <option>1907</option>
                            <option>1908</option>
                            <option>1909</option>
                            <option>1910</option>
                            <option>1911</option>
                            <option>1912</option>
                            <option>1913</option>
                            <option>1914</option>
                            <option>1915</option>
                            <option>1916</option>
                            <option>1917</option>
                            <option>1918</option>
                            <option>1919</option>
                            <option>1920</option>
                            <option>1921</option>
                            <option>1922</option>
                            <option>1923</option>
                            <option>1924</option>
                            <option>1925</option>
                            <option>1926</option>
                            <option>1927</option>
                            <option>1928</option>
                            <option>1929</option>
                            <option>1930</option>
                            <option>1931</option>
                            <option>1932</option>
                            <option>1933</option>
                            <option>1934</option>
                            <option>1935</option>
                            <option>1936</option>
                            <option>1937</option>
                            <option>1938</option>
                            <option>1939</option>
                            <option>1940</option>
                            <option>1941</option>
                            <option>1942</option>
                            <option>1943</option>
                            <option>1944</option>
                            <option>1945</option>
                            <option>1946</option>
                            <option>1947</option>
                            <option>1948</option>
                            <option>1949</option>
                            <option>1950</option>
                            <option>1951</option>
                            <option>1952</option>
                            <option>1953</option>
                            <option>1954</option>
                            <option>1955</option>
                            <option>1956</option>
                            <option>1957</option>
                            <option>1958</option>
                            <option>1959</option>
                            <option selected="selected">1960</option>
                            <option>1961</option>
                            <option>1962</option>
                            <option>1963</option>
                            <option>1964</option>
                            <option>1965</option>
                            <option>1966</option>
                            <option>1967</option>
                            <option>1968</option>
                            <option>1969</option>
                            <option>1970</option>
                            <option>1971</option>
                            <option>1972</option>
                            <option>1973</option>
                            <option>1974</option>
                            <option>1975</option>
                            <option>1976</option>
                            <option>1977</option>
                            <option>1978</option>
                            <option>1979</option>
                            <option>1980</option>
                            <option>1981</option>
                            <option>1982</option>
                            <option>1983</option>
                            <option>1984</option>
                            <option>1985</option>
                            <option>1986</option>
                            <option>1987</option>
                            <option>1988</option>
                            <option>1989</option>
                            <option>1990</option>
                            <option>1991</option>
                            <option>1992</option>
                            <option>1993</option>
                            <option>1994</option>
                            <option>1995</option>
                            <option>1996</option>
                            <option>1997</option>
                            <option>1998</option>
                            <option>1999</option>
                            <option>2000</option>
                            <option>2001</option>
                            <option>2002</option>
                            <option>2003</option>
                            <option>2004</option>
                            <option>2005</option>
                            <option>2006</option>
                            <option>2007</option>
                            <option>2008</option>
                            <option>2009</option>
                            <option>2010</option>
                            <option>2011</option>
                            <option>2012</option>
                            <option>2013</option>
                            <option>2014</option>
                            <option>2015</option>
                            <option>2016</option>
                            <option>2017</option>
                            <option>2018</option>
                            <option>2019</option>
                            <option>2020</option>
                          </select>
                        </label>
                      </span></td>
                    </tr>
                    <tr>
                      <td>HEURE DE NAISSANCE</td>
                      <td colspan="5"><span class="style16">
                        <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hre.&nbsp;
                          <select name="heure" id="heure">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                            <option>6</option>
                            <option>7</option>
                            <option>8</option>
                            <option>9</option>
                            <option>10</option>
                            <option>11</option>
                            <option selected="selected">12</option>
                            <option>13</option>
                            <option>14</option>
                            <option>15</option>
                            <option>16</option>
                            <option>17</option>
                            <option>18</option>
                            <option>19</option>
                            <option>20</option>
                            <option>21</option>
                            <option>22</option>
                            <option>23</option>
                            <option>24</option>
                          </select>
  &nbsp;&nbsp;&nbsp;
                          
                        Min.
                        <select name="min" id="min">
                          <option>00</option>
                          <option>01</option>
                          <option>02</option>
                          <option>03</option>
                          <option>04</option>
                          <option>05</option>
                          <option>06</option>
                          <option>07</option>
                          <option>08</option>
                          <option>09</option>
                          <option>10</option>
                          <option>11</option>
                          <option>12</option>
                          <option>13</option>
                          <option>14</option>
                          <option>15</option>
                          <option>16</option>
                          <option>17</option>
                          <option>18</option>
                          <option>19</option>
                          <option>20</option>
                          <option>21</option>
                          <option>22</option>
                          <option>23</option>
                          <option>24</option>
                          <option>25</option>
                          <option>26</option>
                          <option>27</option>
                          <option>28</option>
                          <option>29</option>
                          <option>30</option>
                          <option>31</option>
                          <option>32</option>
                          <option>33</option>
                          <option>34</option>
                          <option>35</option>
                          <option>36</option>
                          <option>37</option>
                          <option>38</option>
                          <option>39</option>
                          <option>40</option>
                          <option>41</option>
                          <option>42</option>
                          <option>43</option>
                          <option>44</option>
                          <option>45</option>
                          <option>46</option>
                          <option>47</option>
                          <option>48</option>
                          <option>49</option>
                          <option>50</option>
                          <option>51</option>
                          <option>52</option>
                          <option>53</option>
                          <option>54</option>
                          <option>55</option>
                          <option>56</option>
                          <option>57</option>
                          <option>58</option>
                          <option>59</option>
                          <option>60</option>
                        </select>
                        (format 24h)</label>
                      </span></td>
                    </tr>
                    <tr>
                      <td>N&eacute;(e) &agrave;</td>
                      <td colspan="5"><input name="LIEU_EVENNEMENT" type="text" id="LIEU_EVENNEMENT" /></td>
                    </tr>
                    <tr>
                      <td colspan="6" class="header" align="center">Adresse</td>
                    </tr>
                    <tr>
                      <td colspan="6"><?php 
							  
include_once("DynamicDropDown.class.php");    //Includes the Class file to this example Script.
$dForm = new DynamicDropDown($dbConfig);      //Creates and Object to the Script
$dFormName = "form2";                         //Assign a NAME for the Form which we will be using in this Example Script
$dForm->DataFetch();                          //Call to the DataFetch method, which will Fetch the data from the Tables.
$dForm->CreateJavaScript($dFormName);         //Call to the CreateJavaScript method,which will dynamically creates the Javascript which loads the Data to the List Box
//echo "<form name=\"$dFormName\" method=\"post\">";  //Creates a New form on this Page
$dForm->CreateListBox();                      //Call to the Member Function which will create the Form Object
//echo "</form>";                               // Close the Form
$dForm->DynamicDropDown_Close();   //Call to the Destructor type of function

				?>
                        <p align="left" class="style16">
                    <label></label>
                          <label>
                          No 
                        
                            <input type="text" name="numero" id="numero" size="10"/>&nbsp;&nbsp;&nbsp;&nbsp;
 Nom Rue:
 <input name="NOM_RUE" type="text" id="NOM_RUE" size="55" />
                         
                        </label></td>
                    </tr>
                    <tr>
                      <td><a href="#" onClick="openFormWin('popupere.php');return false;">Rechercher Père</a></p>                            </td>
                      <td colspan="2"><div id="prop" style="display:none">NOM &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <input name="lname" type="text" readonly="readonly"/> PRENOM : <input name="fname" type="text" readonly="readonly"/> <input name="id" type="hidden" /></div></td>
                      <td><a href="#" onClick="openFormWin2('popupmere.php');return false;">Rechercher M&egrave;re	</a></td>
                      <td colspan="2"><div id="prop1" style="display:none">NOM &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <input name="lnamem" type="text" readonly="readonly"/> PRENOM : <input name="fnamem" type="text" readonly="readonly"/> <input name="idm" type="hidden" /></div></td>
                    </tr>
                    <tr>
                      <td><a href="#" onClick="openFormWin3('popuptem1.php');return false;">Rechercher 1er temoin</a></td>
                      <td colspan="2"><div id="prop2" style="display:none">NOM &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <input name="lname1" type="text" readonly="readonly"/> PRENOM : <input name="fname1" type="text" readonly="readonly"/> <input name="id1" type="hidden" /></div></td>
                      <td><a href="#" onClick="openFormWin4('popuptem2.php');return false;">Rechercher 2eme temoin</a></td>
                      <td colspan="2"><div id="prop3" style="display:none">NOM &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <input name="lname2" type="text" readonly="readonly"/> PRENOM : <input name="fname2" type="text" readonly="readonly"/> <input name="id2" type="hidden" /></div></td>
                    </tr>
                    
                    <tr>
                      <td><a href="#" onClick="openFormWin5('popupoec.php');return false;">Rechercher Officier Etat Civil</a></td>
                      <td colspan="2"><div id="prop4" style="display:none">NOM &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <input name="lnameoec" type="text" readonly="readonly"/> PRENOM : <input name="fnameoec" type="text" readonly="readonly"/> <input name="idoec" type="hidden" /></div>
                      </td>
                      <td colspan="3">&nbsp;</td>
                    </tr>
                  </table>
                  <p>
                    <?php

				  //$test ="1980-05-02";
				  //echo date ('Y-m-d', $test);
				  /*echo $name;*/
				  /*echo $dateb;*/
				  /*echo $totalRows_ident;*/
				  //$name = substr($_POST['PRENOM_IND'],1,2).substr($_POST['NOM_IND'],-3,2);
				  //$IDIND = $name.$dateb.$totalRows_ident;
				  //echo $IDIND;
/*				  $dates = $_POST['jour']."-".$_POST['mois']."-".$_POST['an']."".$_POST['heure'].":".$_POST['min'];
				  $date = strtotime($dates);
				  echo date ('Y-m-j H:i:s',$date);
				  */
				  ?><input name="DATEH_NAIS" type="hidden" id="DATEH_NAIS" value="<?php echo date ('Y-m-d H:i:s',$date);?>" />
                    <input name="IDIND" type="hidden" id="IDIND" value="<?php echo $IDIND;?>" />
                  </p>
                  <div align="center">
		            <input type="reset" name="Reset" id="button" value="Reset" />
		            <input type="submit" name="button2" id="button2" value="Enregistrer" />
		            <input type="hidden" name="MM_insert" value="form2" />
		        </div>
                
	            </form>
	          </div>
		      <?php

	}
else 
	echo "".$nomutil."<br>";
	echo "".$id_groupe."<br>";
	echo "".$pass."<br>";
?>
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

mysql_free_result($ident);
?>
