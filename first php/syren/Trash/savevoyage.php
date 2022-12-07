<?php require_once('Connections/connex.php'); ?>
<?php require_once('Connections/connex.php'); ?><?php
//initialize the session
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

$colname_rech_ind = "-1";
if (isset($_GET['ID_IND'])) {
  $colname_rech_ind = $_GET['ID_IND'];
}
mysql_select_db($database_connex, $connex);
$query_rech_ind = sprintf("SELECT * FROM individu WHERE ID_IND = %s", GetSQLValueString($colname_rech_ind, "text"));
$rech_ind = mysql_query($query_rech_ind, $connex) or die(mysql_error());
$row_rech_ind = mysql_fetch_assoc($rech_ind);
$totalRows_rech_ind = mysql_num_rows($rech_ind);

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) 
{

$dates = $_POST['jourd']."-".$_POST['moisd']."-".$_POST['and']."".	$_POST['heured'].":".$_POST['mind'];
	$date = strtotime($dates);
	$format = date ('Y-m-j H:i:s',$date);

$dateq = $_POST['joura']."-".$_POST['moisa']."-".$_POST['ana']."".	$_POST['heurea'].":".$_POST['mina'];
	$datew = strtotime($dateq);
	$formata = date ('Y-m-j H:i:s',$datew);
	





$insertSQL = sprintf("INSERT INTO voyage (NOM_COMP_AERIENNE, NO_VOL, PROVENANCE_VOL, DESTINATION_VOL, DATE_DEPART_IND, DATE_ARRIVEE_IND, ID_IND) VALUES (%s, %s, %s, %s,%s, %s, %s)",
                       GetSQLValueString($_POST['NOM_COMP_AERIENNE'], "text"),
                       GetSQLValueString($_POST['NO_VOL'], "text"),
                       GetSQLValueString($_POST['PROVENANCE_VOL'], "text"),
                       GetSQLValueString($_POST['DESTINATION_VOL'], "text"),
					   GetSQLValueString($format, "date"),
					   GetSQLValueString($formata, "date"),
					   GetSQLValueString($row_rech_ind['ID_IND'], "text"));

  mysql_select_db($database_connex, $connex);
  $Result1 = mysql_query($insertSQL, $connex) or die(mysql_error());
}

$colname_rech_ind = "-1";
if (isset($_GET['ID_IND'])) {
  $colname_rech_ind = $_GET['ID_IND'];
}
mysql_select_db($database_connex, $connex);
$query_rech_ind = sprintf("SELECT * FROM individu WHERE ID_IND = %s", GetSQLValueString($colname_rech_ind, "text"));
$rech_ind = mysql_query($query_rech_ind, $connex) or die(mysql_error());
$row_rech_ind = mysql_fetch_assoc($rech_ind);
$totalRows_rech_ind = mysql_num_rows($rech_ind);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/admdgi.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
<!-- InstanceBeginEditable name="doctitle" -->
<title>SYREN | Syst&egrave;me de Renseignement National</title>
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
<!-- InstanceBeginEditable name="head" --><!-- InstanceEndEditable -->
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
          <div class="idsection">Immigration et Emigration|| IME </div>
          <div class="loginbar">
            <div class="text">
                Bienvenue, <span class="fonce"><?php echo $_SESSION['MM_Username']; ?></span> :: Vous &ecirc;tes <span class="fonce"><?php echo $_SESSION['NOM_GROUPE']; ?> </span>            </div>
            <span class="logout"><a href="<?php echo $logoutAction ?>">Deconnexion</a></span>
            <div class="spacer"></div>
          </div>
            <li><a class="MenuBarItemSubmenu" href="#">Entites</a>
                <ul>
                  <li><a href="saveentites.php">Enregistrer</a></li>
                  <li><a href="#">Modifier</a></li>
                  <li><a href="list_entites.php">Lister</a></li>
                  <li><a href="rech_entites.php">Rechercher</a></li>
                </ul>
            </li>
		    <li><a href="#" class="MenuBarItemSubmenu">Individus</a>
		      <ul>
		        <li><a href="saveind.php">Enregistrer</a></li>
		        <li><a href="#">Modifier</a></li>
		        <li><a href="#">Lister</a></li>
		        <li><a href="#">Rechercher</a></li>
		      </ul>
	        </li>
		    <li><a href="#" class="MenuBarItemSubmenu">Utilisateurs</a>
		      <ul>
		        <li><a href="#">Cr&eacute;er</a></li>
		        <li><a href="#">Modifier</a></li>
		        <li><a href="#">Lister</a></li>
		        <li><a href="#">Rechercher</a></li>
		      </ul>
	        </li>
		    <li><a href="#">Recherche Avanc&eacute;e</a></li>
		    <li><a href="#">Actualites</a></li>
		    <li><a href="#">Culture</a></li>
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
              <form id="form2" name="form2" method="POST" action="<?php echo $editFormAction; ?>">
              
              <p>&nbsp;</p>
              <div class="title" align="center">Forme d'Enregistrement de Voyages</div><br />
              
              <table width="100%" border="1" id="comliste">
                <tr>
                  <td>&nbsp;</td>
                  <td><?php echo $row_rech_ind['ID_IND'] ?></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td width="83">No Passeport:</td>
                  <td width="198"><?php echo $row_rech_ind['NUM_PASSPORT'] ?></td>
                  <td width="84">Type Passeport:</td>
                  <td width="220"><?php echo $row_rech_ind['TYPE_PASS'] ?></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>Nom:</td>
                  <td><span style="background-color:#C4ECFF"><?php echo $row_rech_ind['NOM_IND'] ?></span></td>
                  <td>Prenom:</td>
                  <td><?php echo $row_rech_ind['PRENOM_IND'] ?></td>
                </tr>
                <tr>
                  <td>Nationalit&eacute;:</td>
                  <td><?php echo $row_rech_ind['NATIONALITE_INDIVIDU'] ?></td>
                  <td>Groupe Sanguin:</td>
                  <td><?php echo $row_rech_ind['G_SANG_IND'] ?></td>
                </tr>
                <tr>
                  <td>Date de Naissance:</td>
                  <td><?php echo $row_rech_ind['DATEH_NAIS'] ?></td>
                  <td>SEXE:</td>
                  <td><?php echo $row_rech_ind['SEXE_IND'] ?></td>
                </tr>
                <tr>
                  <td>Adresse :</td>
                  <td colspan="2" rowspan="2">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>Telephone:</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>Compagnie Aerienne:</td>
                  <td><label for="NOM_COMP_AERIENNE"></label>
                    <select name="NOM_COMP_AERIENNE" id="NOM_COMP_AERIENNE">
                      <option>American Airlines</option>
                      <option>Air France</option>
                      <option>Spirit</option>
                      <option>Air Canada</option>
                      <option>Copa Airlines</option>
                      <option>Euro Caraibles</option>
                    </select>                  </td>
                  <td>No Vol:</td>
                  <td><label for="NO_VOL"></label>
                  <input name="NO_VOL" type="text" id="NO_VOL" size="8" maxlength="6" /></td>
                </tr>
                <tr>
                  <td>Pays de Provenance:</td>
                  <td><label for="PROVENANCE_VOL"></label>
                    <select name="PROVENANCE_VOL" id="PROVENANCE_VOL">
                      <option selected="selected">Haiti - PAP</option>
                      <option>Etats-Unis - New York</option>
                      <option>Etats-Unis - Washinton</option>
                      <option>Etats-Unis - Chicago</option>
                      <option>Etats-Unis - New York</option>
                      <option>France - Paris</option>
                      <option>Canada - Montreal</option>
                      <option>Canada - Ottawa</option>
                      <option>Panama - Panamy City</option>
                      <option>Rep. Dom.- Santo Domingo</option>
                      <option>Rep. Dom. Santiago</option>
                    </select>                  </td>
                  <td>Pays de Destination:</td>
                  <td><label for="DESTINATION_VOL"></label>
                    <select name="DESTINATION_VOL" id="DESTINATION_VOL">
                    <option>Haiti - PAP</option>
                      <option selected="selected">Etats-Unis - New York</option>
                      <option>Etats-Unis - Washinton</option>
                      <option>Etats-Unis - Chicago</option>
                      <option>Etats-Unis - New York</option>
                      <option>France - Paris</option>
                      <option>Canada - Montreal</option>
                      <option>Canada - Ottawa</option>
                      <option>Panama - Panamy City</option>
                      <option>Rep. Dom.- Santo Domingo</option>
                      <option>Rep. Dom. Santiago</option>
                    </select>                  </td>
                </tr>
                <tr>
                  <td>Date et Heure de D&eacute;part:</td>
                  <td colspan="2">Jour 
                    <select name="jourd" id="jourd">
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
               
                          Mois
                          <select name="moisd" id="moisd">
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
                          Annee                      
                          <select name="and" id="and">
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
                            <option>1960</option>
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
                            <option selected="selected">2009</option>
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
                    </select></td>
                  <td><select name="heured" id="heured">
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
                      <select name="mind" id="mind">
                        <option>00</option>
                        <option>05</option>
                        <option>10</option>
                        <option>15</option>
                        <option>25</option>
                        <option>30</option>
                        <option>35</option>
                        <option>40</option>
                        <option>45</option>
                        <option>50</option>
                        <option>55</option>
                        <option>60</option>
                      </select></td>
                </tr>
                <tr>
                  <td>Date et Heure d'arriv&eacute;e</td>
                  <td colspan="2">Jour
                    <select name="joura" id="joura">
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
               
                          Mois
                          <select name="moisa" id="moisa">
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
Annee
<select name="ana" id="ana">
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
  <option>1960</option>
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
  <option selected="selected">2009</option>
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
</select></td>
                  <td><select name="heurea" id="heurea">
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
                      <select name="mind2" id="mind2">
                        <option>00</option>
                        <option>05</option>
                        <option>10</option>
                        <option>15</option>
                        <option>25</option>
                        <option>30</option>
                        <option>35</option>
                        <option>40</option>
                        <option>45</option>
                        <option>50</option>
                        <option>55</option>
                        <option>60</option>
                      </select></td>
                </tr>
                <tr>
                  <td height="34">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td colspan="2">Bon voyage !!!</td>
                </tr>
              </table>
              <p><br />
              </p>
              <label for="button"></label>
              <input type="reset" name="Reset" id="button" value="Reset" />
              <label for="button2"></label>
              <input type="submit" name="button2" id="button2" value="Enregistrer" />
              <br />
              <input type="hidden" name="MM_insert" value="form2" />
              </p>
              </form>
		      <?php
	}
else
	echo " ".$nomutil."<br>";
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
mysql_free_result($rech_ind);

mysql_free_result($loggedUser);
?>
