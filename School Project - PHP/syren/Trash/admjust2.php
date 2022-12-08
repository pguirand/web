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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO delit (DESCRIPTION_DELIT, TYPE_DELIT, GRAVITE_DELIT) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['DESCRIPTION_DELIT'], "text"),
                       GetSQLValueString($_POST['TYPE_DELIT'], "text"),
                       GetSQLValueString($_POST['GRAVITE_DELIT'], "text"));

  mysql_select_db($database_connex, $connex);
  $Result1 = mysql_query($insertSQL, $connex) or die(mysql_error());
}

$colname_rech_ind = "-1";
if (isset($_GET['ID_IND'])) {
  $colname_rech_ind = $_GET['ID_IND'];
}
mysql_select_db($database_connex, $connex);
$query_rech_ind = sprintf("SELECT ID_IND, EMPRINTE_IND, G_SANG_IND, SEXE_IND, NOM_IND, PRENOM_IND, DATEH_NAIS, NUM_NIF, NUM_CIF, PROFESSION, RELIGION, NUM_PASSPORT, NATIONALITE_INDIVIDU FROM individu WHERE ID_IND = %s", GetSQLValueString($colname_rech_ind, "text"));
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
<script language="JavaScript">
<!-- hide
function openNewWindow() {
 popupWin = window.open("popup_search.php",
 'open_window',
 'menubar, toolbar, location, directories, status, scrollbars=no, navigation toolbar=no, menubar=no, toolbar=no, location=no, status=no, resizable=1, dependent, width=480, height=360, left=300, top=160')
}
// done hiding -->
</script>

<script type="text/JavaScript" language="JavaScript">

function disableForm()
{
if (document.getElementById('aucunChoix').selected)
{
//alert("Infjour") ;
document.getElementById('contraventionLigne1').style.visibility='visible';
document.getElementById('contraventionLigne2').style.visibility='visible';
document.getElementById('contraventionLigne3').style.visibility='visible';

document.getElementById('arrestationLigne1').style.visibility='visible';
document.getElementById('arrestationLigne2').style.visibility='visible';
document.getElementById('arrestationLigne3').style.visibility='visible';

document.getElementById('condamnationLigne1').style.visibility='visible';
document.getElementById('condamnationLigne2').style.visibility='visible';
document.getElementById('condamnationLigne3').style.visibility='visible';
}
if (document.getElementById('contravention').selected)
{
//alert("Infjour") ;
document.getElementById('contraventionLigne1').style.visibility='visible';
document.getElementById('contraventionLigne2').style.visibility='visible';
document.getElementById('contraventionLigne3').style.visibility='visible';

document.getElementById('condamnationLigne1').style.visibility='hidden';
document.getElementById('condamnationLigne2').style.visibility='hidden';
document.getElementById('condamnationLigne3').style.visibility='hidden';

document.getElementById('arrestationLigne1').style.visibility='hidden';
document.getElementById('arrestationLigne2').style.visibility='hidden';
document.getElementById('arrestationLigne3').style.visibility='hidden';




//document.getElementById('Infmois').enabled="true" ;
//document.getElementById('Infan').enabled="true" ;

//document.getElementById('Aresjour').disabled="true" ;
//document.getElementById('Aresmois').disabled="true" ;
//document.getElementById('Aresan').disabled="true" ;

//document.getElementById('Condjour').disabled="true" ;
//document.getElementById('Condmois').disabled="true" ;
//document.getElementById('Condan').disabled="true" ;
}

if (document.getElementById('delit').selected)
{
document.getElementById('contraventionLigne1').style.visibility='hidden';
document.getElementById('contraventionLigne2').style.visibility='hidden';
document.getElementById('contraventionLigne3').style.visibility='hidden';

document.getElementById('arrestationLigne1').style.visibility='visible';
document.getElementById('arrestationLigne2').style.visibility='visible';
document.getElementById('arrestationLigne3').style.visibility='visible';

document.getElementById('condamnationLigne1').style.visibility='visible';
document.getElementById('condamnationLigne2').style.visibility='visible';
document.getElementById('condamnationLigne3').style.visibility='visible';
/*alert("delit") ;
document.getElementById('Aresjour').enabled="true" ;
document.getElementById('Aresmois').enabled="true" ;
document.getElementById('Aresan').enabled="true" ;

document.getElementById('Infjour').disabled="true" ;
document.getElementById('Infmois').disabled="true" ;
document.getElementById('Infan').disabled="true" ;

document.getElementById('Condjour').disabled="true" ;
document.getElementById('Condmois').disabled="true" ;
document.getElementById('Condan').disabled="true" ;
*/}

if (document.getElementById('crime').selected)
{
document.getElementById('contraventionLigne1').style.visibility='hidden';
document.getElementById('contraventionLigne2').style.visibility='hidden';
document.getElementById('contraventionLigne3').style.visibility='hidden';

document.getElementById('arrestationLigne1').style.visibility='visible';
document.getElementById('arrestationLigne2').style.visibility='visible';
document.getElementById('arrestationLigne3').style.visibility='hidden';

document.getElementById('condamnationLigne1').style.visibility='visible';
document.getElementById('condamnationLigne2').style.visibility='visible';
document.getElementById('condamnationLigne3').style.visibility='visible';
/*alert("crime") ;
document.getElementById('Condjour').enabled="true" ;
document.getElementById('Condmois').enabled="true" ;
document.getElementById('Condan').enabled="true" ;

document.getElementById('Aresjour').disabled="true" ;
document.getElementById('Aresmois').disabled="true" ;
document.getElementById('Aresan').disabled="true" ;

document.getElementById('Infjour').disabled="true" ;
document.getElementById('Infmois').disabled="true" ;
document.getElementById('Infan').disabled="true" ;*/

}
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
          <div class="idsection"> Direction Generale des Impots || DGI </div>
           <div class="loginbar">
            <div class="text">
                Bienvenue, <span class="fonce"><?php echo $_SESSION['MM_Username']; ?></span> :: Vous &ecirc;tes <span class="fonce"><?php echo $_SESSION['NOM_GROUPE']; ?> </span>            </div>
            <span class="logout"><a href="<?php echo $logoutAction ?>">Deconnexion</a></span>
            <div class="spacer"></div>
          </div>
             <li><a class="MenuBarItemSubmenu" href="#">Infractions</a>
		       <ul>
		        <li><a href="presavedelit.php">Enregistrer</a></li>
		        <li><a href="#">Modifier</a></li>
		        <li><a href="#">Lister</a></li>
		        <li><a href="#">Rechercher D&eacute;lit</a></li>
		        <li><a href="#">Recherche Casier</a></li>
		      </ul>
	        </li>
		    <li><a href="#">Rech. Avanc&eacute;e</a></li>
	        <li><a href="#" class="MenuBarItemSubmenu">Utilisateurs</a>
                <ul>
                  <li><a href="#">Cr&eacute;er</a></li>
                  <li><a href="#">Modifier</a></li>
                  <li><a href="#">Lister</a></li>
                  <li><a href="#">Rechercher</a></li>
                </ul>
          </li>
          <li><a href="#">Actualites</a></li>
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
              <form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="form2" id="form2">
                <p>&nbsp;</p>
                <table width="647" border="1">
                  <tr>
                    <td colspan="4">&nbsp;</td>
                  </tr>
                  <tr>
                    <td><p>NO CASIER:</p>                    </td>
                    <td></td>
                    <td>Juridiction CASIER:</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>NOM:</td>
                    <td><span style="background-color:#C4ECFF"><?php echo $row_rech_ind['NOM_IND'] ?></span></td>
                    <td>PRENOM:</td>
                    <td><?php echo $row_rech_ind['PRENOM_IND'] ?></td>
                  </tr>
                  <tr>
                    <td width="121">NIF </td>
                    <td width="182"><?php echo $row_rech_ind['NUM_NIF'] ?></td>
                    <td width="114">CIF</td>
                    <td width="202"><?php echo $row_rech_ind['NUM_CIF'] ?></td>
                  </tr>
                  <tr>
                    <td>No Passeport:</td>
                    <td><?php echo $row_rech_ind['NUM_PASSPORT'] ?></td>
                    <td>Nationalite:</td>
                    <td><?php echo $row_rech_ind['NATIONALITE_INDIVIDU'] ?></td>
                  </tr>
                  <tr>
                    <td>Groupe Sanguin:</td>
                    <td><?php echo $row_rech_ind['G_SANG_IND'] ?></td>
                    <td>Sexe:</td>
                    <td><?php echo $row_rech_ind['SEXE_IND'] ?></td>
                  </tr>
                  <tr>
                    <td>Date de Naissance:</td>
                    <td><?php echo $row_rech_ind['DATEH_NAIS'] ?></td>
                    <td>Religion:</td>
                    <td><?php echo $row_rech_ind['RELIGION'] ?></td>
                  </tr>
                  <tr>
                    <td>Profession:</td>
                    <td><?php echo $row_rech_ind['PROFESSION'] ?></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>Lieu de Naissance:</td>
                    <td colspan="3" rowspan="2">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>Adresse R&eacute;cente:</td>
                    <td colspan="3" rowspan="2">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="31" colspan="4">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>Niveau de L'infraction</td>
                    <td><label>
                    <select onchange="disableForm()" name="GRAVITE_DELIT" id="GRAVITE_DELIT">
                      <option id="aucunChoix" selected="selected">--Choisir--</option>
                      <option id="contravention">Contravention</option>
                      <option id="delit">D&eacute;lit</option>
                      <option id="crime">Crime</option>
                    </select>
                    </label></td>
                    <td rowspan="2">Type de l'infraction</td>
                    <td rowspan="2">
                      <label>
                        <input type="radio" name="TYPE_DELIT" value="radio" id="typeinf_0" />
                        Contre les personnes</label>
                      <br />
                      <label>
                        <input type="radio" name="TYPE_DELIT" value="radio" id="typeinf_1" />
                        Contre les biens</label>
                      <br />
                      <label>
                        <input type="radio" name="TYPE_DELIT" value="radio" id="typeinf_2" />
                        Contre la Nation ou L'Etat</label>
                      <br />
                      <label>
                        <input type="radio" name="TYPE_DELIT" value="radio" id="typeinf_3" />
                        En organisation</label>
                      <br />
                      <label>
                        <input type="radio" name="TYPE_DELIT" value="radio" id="typeinf_4" />
                        Crime mutuel</label>
                      <br />                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td><div align="right">
                      Description de l'infraction
                    </div></td>
                    <td colspan="3"><label for="DESCRIPTION_DELIT"></label>
                      <label for="DESCRIPTION_DELIT"></label>
                    <textarea name="DESCRIPTION_DELIT" id="DESCRIPTION_DELIT" cols="50" rows="3"></textarea></td>
                  </tr>
                  <tr>
                    <td colspan="4"><div align="center">Dates et Heures \Evenements</div></td>
                  </tr>
                  <div id="infract">
                  <tr>
                    <td id="contraventionLigne1">INFRACTION</td>
                    <td colspan="2" id="contraventionLigne2">Jour
                      <select name="Infjour" id="Infjour">
					      <option selected="selected">--</option>
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
                          <option>--</option>
                        </select>
                      Mois
                      <select name="mois" id="Infmois">
  				        <option selected="selected">--</option>					  
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
                      Ann&eacute;e
                      <select name="an" id="Infan">
					    <option selected="selected">--</option>					  
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
                      </label></td>
                    <td id="contraventionLigne3">Hre
                      <input name="textfield" type="text" id="textfield" size="3" maxlength="2" />
                      Min
                      <input name="textfield2" type="text" id="textfield2" size="3" maxlength="2" />
 (24 H)                 </td>
                  </tr></div>
                  <div id="arrest">
                  <tr>
                  
                    <td id="arrestationLigne1">ARRESTATION</td>
                    <td id="arrestationLigne2" colspan="2">Jour
                      	<select name="Aresjour" id="Aresjour">
					      <option selected="selected">--</option>					  
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
                          <option>--</option>
                        </select>
                      Mois
                      <select name="Aresmois" id="Aresmois">
					    <option selected="selected">--</option>					  
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
                      Ann&eacute;e
                      <select name="Aresan" id="Aresan">
					    <option selected="selected">--</option>					  
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
                      </select></td>
                    <td id="arrestationLigne3">Hre
                      	<input name="textfield6" type="text" id="textfield8" size="3" maxlength="2" />
                      Min
                      <input name="textfield2" type="text" id="textfield2" size="3" maxlength="2" />                      
                      (24 H)</td>
                  </tr></div>
                  <div id="condamn"><tr>
                    <td id="condamnationLigne1">CONDAMNATION</td>
                    <td id="condamnationLigne2" colspan="2">Jour 
                    	<select name="Condjour" id="Condjour">
			          <option selected="selected">--</option>					  
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
                          <option>--</option>
                        </select>
                      Mois
                      <select name="Condmois" id="Condmois">
					    <option selected="selected">--</option>					  
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
                      Ann&eacute;e
                      <select name="Condan" id="Condan">
					    <option selected="selected">--</option>					  
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
                    </select></td>
                    <td id="condamnationLigne3">Hre
                      	<input name="textfield" type="text" id="textfield" size="3" maxlength="2" />
                      Min
                      
                      <input name="textfield5" type="text" id="textfield7" size="3" maxlength="2" />
                      (24 H)</td>
                  </tr></div>
                  <tr>
                    <td>DUREE DE PEINE</td>
                    <td colspan="2"><div align="center">NB ANNEES
                      <input name="textfield4" type="text" id="textfield5" size="5" maxlength="3" /> 
                      NB MOIS
                      <input name="textfield4" type="text" id="textfield6" size="5" maxlength="2" />
                    </div></td>
                    <td><p>
                      <label>
                        <input type="radio" name="choix_peine" value="radio" id="choix_peine_0" />
                        Fermes</label>
                      <br />
                      <label>
                        <input type="radio" name="choix_peine" value="radio" id="choix_peine_1" />
                        Avec Surcil</label>
                      <br />
                    </p></td>
                  </tr>
                  <tr>
                    <td> PREVUE DE LIBERATION</td>
                    <td colspan="2">Jour
                      <select name="jour2" id="jour2">
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
Mois
<select name="mois3" id="mois3">
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
Ann&eacute;e
<select name="an2" id="an2">
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
</select></td>
                    <td>Hre
                      <input name="textfield3" type="text" id="textfield3" size="3" maxlength="2" />
Min
<input name="textfield3" type="text" id="textfield4" size="3" maxlength="2" />
(24 H)</td>
                  </tr>
                  <tr>
                    <td>MOTANT AMENDE</td>
                    <td><label for=""></label></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="23">JUGE PAR:</td>
                    <td colspan="2">&nbsp;</td>
                    <td><a href="javascript:openNewWindow()"><input type="button" value="Rechercher..." /></a></td>
                  </tr>
                  <tr>
                    <td>JUGE AU TRIBUNAL</td>
                    <td colspan="2">&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>PHOTO1 (FACE):</td>
                    <td colspan="2"><label>
                      <input type="file" name="face" id="face" />
                    </label></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>PHOTO2 (PROFIL G.):</td>
                    <td colspan="2"><input type="file" name="gauche" id="gauche" /></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>PHOTO3 (PROFIL D):</td>
                    <td colspan="2"><input type="file" name="droite" id="droite" /></td>
                    <td>&nbsp;</td>
                  </tr>
                </table>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
                <p>
                  <label>
                  
                  <input type="reset" name="Reset" id="button" value="Annuler" />
                  </label>
                  <label>
                  
                  <input type="submit" name="button2" id="button2" value="Enregistrer" />
                  </label>
                  <br />
                  <br />
                  <br />
              </p>
                <input type="hidden" name="MM_insert" value="form2" />
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
