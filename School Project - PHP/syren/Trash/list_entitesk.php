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

$currentPage = $_SERVER["PHP_SELF"];

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
$query_loggedUser = sprintf("SELECT * FROM utilisateur WHERE NOM_UTIL = %s", GetSQLValueString($colname_loggedUser, "text"));
$loggedUser = mysql_query($query_loggedUser, $connex) or die(mysql_error());
$row_loggedUser = mysql_fetch_assoc($loggedUser);
$totalRows_loggedUser = mysql_num_rows($loggedUser);

$maxRows_liste_entites = 10;
$pageNum_liste_entites = 0;
if (isset($_GET['pageNum_liste_entites'])) {
  $pageNum_liste_entites = $_GET['pageNum_liste_entites'];
}
$startRow_liste_entites = $pageNum_liste_entites * $maxRows_liste_entites;

mysql_select_db($database_connex, $connex);
$query_liste_entites = "SELECT ID_ENTITE, NOM_ENTITE, SIGLE, SECTEUR_ACTIVITE, STATUT FROM entite";
$query_limit_liste_entites = sprintf("%s LIMIT %d, %d", $query_liste_entites, $startRow_liste_entites, $maxRows_liste_entites);
$liste_entites = mysql_query($query_limit_liste_entites, $connex) or die(mysql_error());
$row_liste_entites = mysql_fetch_assoc($liste_entites);

if (isset($_GET['totalRows_liste_entites'])) {
  $totalRows_liste_entites = $_GET['totalRows_liste_entites'];
} else {
  $all_liste_entites = mysql_query($query_liste_entites);
  $totalRows_liste_entites = mysql_num_rows($all_liste_entites);
}
$totalPages_liste_entites = ceil($totalRows_liste_entites/$maxRows_liste_entites)-1;

$queryString_liste_entites = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_liste_entites") == false && 
        stristr($param, "totalRows_liste_entites") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_liste_entites = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_liste_entites = sprintf("&totalRows_liste_entites=%d%s", $totalRows_liste_entites, $queryString_liste_entites);
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
	{
?>
              <?php
				echo $info
			?><BR>
              <div class="fonce" align="center">LISTE DES ENTITES NATIONALES</h3></div>
		      <div class="story">
		        <p>&nbsp;</p>
		        <div>
                <table width="" border="0" cellpadding="0" cellspacing="0" id="entiteliste">
                  <tr class="head">
                  	<td> No </td>
                    <td >Nom</td>
                    <td>SIGLE</td>
                    <td>SECTEUR D'ACTIVITES</td>
                    <td>STATUT</td>
                    <td colspan="2">Actions</td>
                  </tr>
                  <?php do { ?>
                    <tr>
                      <<a href="updentites.php?ID_ENTITE=td> <?php echo $i=$i+1; ?></td>
                      <td><?php echo $row_liste_entites['NOM_ENTITE']; ?></td>
                      <td><?php echo $row_liste_entites['SIGLE']; ?></td>
                      <td><?php echo $row_liste_entites['SECTEUR_ACTIVITE']; ?></td>
                      <td><?php echo $row_liste_entites['STATUT']; ?></td>
                      <td><?php echo $row_liste_entites['ID_ENTITE']; ?>" title="Modifier Entité"><img src="images/pencilart.jpeg" width="20" height="20"  border="0" /></a></td>
                      <td><a href="viewentites.php?ID_ENTITE=<?php echo $row_liste_entites['ID_ENTITE']; ?>" title="Visualiser Entité"><img src="images/eyeart.jpeg" width="20" height="20"  border="0"/></a></td>   
                    </tr>
                    <?php } while ($row_liste_entites = mysql_fetch_assoc($liste_entites)); ?>
                </table>
                
                </div>
                <p>Total  <?php echo ($startRow_liste_entites + 1) ?> à <?php echo min($startRow_liste_entites + $maxRows_liste_entites, $totalRows_liste_entites) ?> sur <?php echo $totalRows_liste_entites ?> p;</p>
                <p>&nbsp;</p>
                <table border="0" align="center"->
                  <tr class="head">
                    <td><?php if ($pageNum_liste_entites > 0) { // Show if not first page ?>
                    <a href="<?php printf("%s?pageNum_liste_entites=%d%s", $currentPage, 0, $queryString_liste_entites); ?>">Début</a>
                        <?php } // Show if not first page ?>
                    </td>
                    <td><?php if ($pageNum_liste_entites > 0) { // Show if not first page ?>
                        <a href="<?php printf("%s?pageNum_liste_entites=%d%s", $currentPage, max(0, $pageNum_liste_entites - 1), $queryString_liste_entites); ?>">Précédent</a>
                        <?php } // Show if not first page ?>
                    </td>
                    <td><?php if ($pageNum_liste_entites < $totalPages_liste_entites) { // Show if not last page ?>
                        <a href="<?php printf("%s?pageNum_liste_entites=%d%s", $currentPage, min($totalPages_liste_entites, $pageNum_liste_entites + 1), $queryString_liste_entites); ?>">Suivant</a>
                        <?php } // Show if not last page ?>
                    </td>
                    <td><?php if ($pageNum_liste_entites < $totalPages_liste_entites) { // Show if not last page ?>
                        <a href="<?php printf("%s?pageNum_liste_entites=%d%s", $currentPage, $totalPages_liste_entites, $queryString_liste_entites); ?>">Fin</a>
                        <?php } // Show if not last page ?>
                    </td>
                  </tr>
                </table>
		        <p>&nbsp;</p>
		        <p>&nbsp;</p>
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

mysql_free_result($liste_entites);
?>
