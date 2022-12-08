<?php require_once('Connections/connex.php'); ?>
<script type='text/javascript'>
function emailValidator(eMail1, helperMsg)
                    {
	                 var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
	                 if(eMail1.value.match(emailExp)){
		                                              return true;
	                                                 }
                     else{
		                  alert(helperMsg);         
		                  return false;
						  eMail1.focus();

	                     }
                     }
</script>
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

function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO adresse (NOM_RUE) VALUES (%s)",
                       GetSQLValueString($_POST['adresse'], "text"));

  mysql_select_db($database_connex, $connex);
  $Result1 = mysql_query($insertSQL, $connex) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
$dates = $_POST['jour']."-".$_POST['mois']."-".$_POST['an'];
$dateb = $_POST['jour'].$_POST['mois'].$_POST['an'];
$date = strtotime($dates);
$format = date ('Y-m-j',$date);
$logo_name = $_FILES['logo']['name'];
$name = strtoupper(substr($_POST['NOM'],1,2));
$pat = substr($_POST['numpat'],2,5);
$IDENT = $name.$dateb.$pat.$totalRows_IDENTITE;
$target_path = "images/photos/entites/";
$target_path = $target_path.basename($_FILES['logo']['name']);
$type_file = $_FILES['fichier']['type'];


 //if( !strstr($type_file, 'jpg') && !strstr($type_file, 'jpeg') && !strstr($type_file, 'bmp') && !strstr($type_file, 'gif') )
//    {
//        
//		exit("Le fichier n'est pas une image");
//		 
//  }

	 //if(move_uploaded_file($_FILES['logo']['tmp_name'], $target_path)) {
     //echo "Le fichier ".  basename( $_FILES['logo']['name']).
    // " a été transféré.";
	 //} 
	 //else{
	//	 echo "Le transfert a échoué. Recommencer.";
	 //}
$insertSQL = sprintf("INSERT INTO entite (ID_ENTITE, NOM_ENTITE, NUM_PATENTE, SIGLE, SECTEUR_ACTIVITE, STATUT, NIVEAU, EMAIL1, EMAIL2, EMAIL3, SITE_WEB, LOGO, CREER_PAR) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
  					   GetSQLValueString($IDENT, "text"),
                       GetSQLValueString($_POST['Nom'], "text"),
                       GetSQLValueString($_POST['numpat'], "text"),
                       GetSQLValueString($_POST['sigle'], "text"),
                       GetSQLValueString($_POST['Groupe'], "text"),
                       GetSQLValueString($_POST['statut'], "text"),
                       GetSQLValueString($_POST['Niveau'], "text"),
                       GetSQLValueString($_POST['eMail1'], "text"),
                       GetSQLValueString($target_path, "text"),
                       GetSQLValueString($_POST['eMail3'], "text"),
                       GetSQLValueString($_POST['siteweb'], "text"),
                       GetSQLValueString($logo_name, "text"),	
					   GetSQLValueString($_SESSION['MM_Username'], "text"));				   

  mysql_select_db($database_connex, $connex);
  $Result1 = mysql_query($insertSQL, $connex) or die(mysql_error());
  
  die();
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO coordonnees (NUM_TEL1, NUM_TEL2, NUM_TEL3, NUM_TEL4, NUM_TEL5, NUM_TEL6) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['Telephone1'], "text"),
                       GetSQLValueString($_POST['Telephone2'], "text"),
                       GetSQLValueString($_POST['Telephone3'], "text"),
                       GetSQLValueString($_POST['Telephone4'], "text"),
                       GetSQLValueString($_POST['Telephone5'], "text"),
                       GetSQLValueString($_POST['Telephone6'], "text"));

  mysql_select_db($database_connex, $connex);
  $Result1 = mysql_query($insertSQL, $connex) or die(mysql_error());

  $insertGoTo = "saveentitesok.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
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

$colname_loggedUser = "-1";
if (isset($_POST['NOM_UTIL'])) {
  $colname_loggedUser = $_POST['NOM_UTIL'];
}
mysql_select_db($database_connex, $connex);
$query_loggedUser = "SELECT * FROM utilisateur WHERE NOM_UTIL = 'colname'";
$loggedUser = mysql_query($query_loggedUser, $connex) or die(mysql_error());
$row_loggedUser = mysql_fetch_assoc($loggedUser);
$totalRows_loggedUser = mysql_num_rows($loggedUser);

mysql_select_db($database_connex, $connex);
$query_ident = "SELECT * FROM entite";
$ident = mysql_query($query_ident, $connex) or die(mysql_error());
$row_ident = mysql_fetch_assoc($ident);
$totalRows_ident = mysql_num_rows($ident);

mysql_select_db($database_connex, $connex);
$query_IDENTITE = "SELECT ID_ENTITE FROM entite WHERE ID_ENTITE = ID_ENTITE ORDER BY ID_ENTITE ASC";
$IDENTITE = mysql_query($query_IDENTITE, $connex) or die(mysql_error());
$row_IDENTITE = mysql_fetch_assoc($IDENTITE);
$totalRows_IDENTITE = mysql_num_rows($IDENTITE);
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
          <div class="idsection"> Direction Generale des Impots || DGI </div>
          <div class="loginbar">
            <div class="text"> Bienvenue, <span class="fonce"><?php echo $_SESSION['MM_Username']; ?></span> :: Vous &ecirc;tes <span class="fonce"><?php echo $_SESSION['NOM_GROUPE']; ?> </span> </div>
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
                <li><a href="#">Recherche Avanc&eacute;e</a></li>
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
		    <div id="right">
<?php
if($_GET['search'] == "")
?>
            <?php
				echo $info
			?>
            <div align="center" class="title style12"> 
                <h2>
				Formulaire d'enregistrement d'entités				</h2>
              </div>
		      <div class="story">
		        <p>&nbsp;</p>


		        <form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="form2" id="form2"  onsubmit="emailValidator(document.getElementById('eMail1'), 'Not a Valid Email')">  
                  <table width="358" border="1" id="entiteliste">
                    <tr class="head">
                      <td colspan="2"><div align="center">Veuillez Remplir les champs suivants</div></td>
                    </tr>
                    <tr>
                      <td>Numero Patente </td>
                      <td><label>
                        <input name="numpat" type="text" id="numpat" size="17" maxlength="15" />
                      </label></td>
                    <tr>
                      <td width="78">Nom</td>
                      <td width="215">
					  <label>
                        <input name="Nom" type="text" id="Nom" size="50" maxlength="100" />
                      </label></td>
                    </tr>
                    <tr>
                      <td>Groupe</td>
                      <td><label>
                        <select name="Groupe" id="Groupe">
                          <option>S&eacute;curit&eacute;</option>
                          <option>Culture</option>
                          <option>Economie</option>
                          <option selected="selected">Communication</option>
                          <option>Energie</option>
                          <option>Hydraulique</option>
                          <option>Sant&eacute;</option>
                          <option>Architecture</option>
                          <option>Identification</option>
                          <option>Education</option>
                          <option>Justice</option>
                          <option>Education</option>
                          <option>Produits alimentaires</option>
                          <option>jeux</option>
                          <option>Produits pharmaceutiques</option>
                          <option>Technologie</option>
                        </select>
                      </label></td>
                      <tr>
                      <td>Sigle</td>
                      <td><input name="sigle" type="text" id="sigle" size="13" maxlength="10" /></td>
                    </tr>
                    <tr>
                      <td height="46">Logo</td>
                      <td><label>
                        <input type="file" name="logo" id="logo" />
                      </label></td>
                    </tr>
                    <tr>
                      <td>Statut</td>
                      <td><label>
                        <select name="statut" id="statut">
                          <option selected="selected">En Service</option>
                          <option>Hors-Service</option>
                      </select>
                      </label></td>
                    </tr>
                    <tr>
                      <td>Niveau Ebtreprise</td>
                      <td><select name="Niveau" id="Niveau">
                        <option selected="selected">Petite</option>
                        <option>Moyenne</option>
                        <option>Grande</option>
                        <option>mini</option>
                      </select></td>
                    </tr>
                    <tr>
                      <td>Date de Cr&eacute;ation</td>
                      <td><label>Jour
                          <select name="jour" id="jour">
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
                      Année
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
                      </label></td>
                    </tr>
                    <tr>
                      <td>eMail1</td>
                      <td><input name="eMail1" type="text" id="eMail1" size="23" maxlength="20" /></td>
                    </tr>
                    <tr>
                      <td>eMail2</td>
                      <td><input name="eMail2" type="text" id="eMail2" size="23" maxlength="20" /></td>
                    </tr>
                    <tr>
                      <td>eMail3</td>
                      <td><input name="eMail3" type="text" id="eMail3" size="23" maxlength="20" /></td>
                    </tr>
                    <tr>
                      <td>Site Web </td>
                      <td><input name="siteweb" type="text" id="siteweb" size="37" maxlength="35" /></td>
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
                    <div align="right"><a href="admdgi.php">Retour &agrave; Administration</a></div>
                  </p>
                  <p>&nbsp;</p>
	              <input type="hidden" name="MM_insert" value="form2">
		          <input type="hidden" name="uname" id="uname" value="<?php echo $_SESSION['MM_Username']; ?>"/>
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

mysql_free_result($ident);
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
