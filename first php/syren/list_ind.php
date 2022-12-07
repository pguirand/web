<?php
$maxRows_tester = 10;
$pageNum_tester = 0;
if (isset($_GET['pageNum_tester'])) {
  $pageNum_tester = $_GET['pageNum_tester'];
}
$startRow_tester = $pageNum_tester * $maxRows_tester;

mysql_select_db($database_connex, $connex);
$query_tester = "SELECT ID_IND, G_SANG_IND, SEXE_IND, NOM_IND, PRENOM_IND FROM individu";
$query_limit_tester = sprintf("%s LIMIT %d, %d", $query_tester, $startRow_tester, $maxRows_tester);
$tester = mysql_query($query_limit_tester, $connex) or die(mysql_error());
$row_tester = mysql_fetch_assoc($tester);

if (isset($_GET['totalRows_tester'])) {
  $totalRows_tester = $_GET['totalRows_tester'];
} else {
  $all_tester = mysql_query($query_tester);
  $totalRows_tester = mysql_num_rows($all_tester);
}
$totalPages_tester = ceil($totalRows_tester/$maxRows_tester)-1;
?><?php require_once('Connections/connex.php'); ?>
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

$colname_loggedUser = "-1";
if (isset($_POST['NOM_UTIL'])) {
  $colname_loggedUser = $_POST['NOM_UTIL'];
}
mysql_select_db($database_connex, $connex);
$query_loggedUser = sprintf("SELECT * FROM utilisateur WHERE NOM_UTIL = %s", GetSQLValueString($colname_loggedUser, "text"));
$loggedUser = mysql_query($query_loggedUser, $connex) or die(mysql_error());
$row_loggedUser = mysql_fetch_assoc($loggedUser);
$totalRows_loggedUser = mysql_num_rows($loggedUser);

$maxRows_Listind = 10;
$pageNum_Listind = 0;
if (isset($_GET['pageNum_Listind'])) {
  $pageNum_Listind = $_GET['pageNum_Listind'];
}
$startRow_Listind = $pageNum_Listind * $maxRows_Listind;

mysql_select_db($database_connex, $connex);
$query_Listind = "SELECT ID_IND, G_SANG_IND, SEXE_IND, NOM_IND, PRENOM_IND, DATEH_NAIS, NUM_NIF FROM individu";
$query_limit_Listind = sprintf("%s LIMIT %d, %d", $query_Listind, $startRow_Listind, $maxRows_Listind);
$Listind = mysql_query($query_limit_Listind, $connex) or die(mysql_error());
$row_Listind = mysql_fetch_assoc($Listind);

if (isset($_GET['totalRows_Listind'])) {
  $totalRows_Listind = $_GET['totalRows_Listind'];
} else {
  $all_Listind = mysql_query($query_Listind);
  $totalRows_Listind = mysql_num_rows($all_Listind);
}
$totalPages_Listind = ceil($totalRows_Listind/$maxRows_Listind)-1;

mysql_select_db($database_connex, $connex);
$query_tester = "SELECT ID_IND, G_SANG_IND, SEXE_IND, NOM_IND, PRENOM_IND FROM individu";
$tester = mysql_query($query_tester, $connex) or die(mysql_error());
$row_tester = mysql_fetch_assoc($tester);
$totalRows_tester = mysql_num_rows($tester);

$queryString_Listind = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Listind") == false && 
        stristr($param, "totalRows_Listind") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Listind = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Listind = sprintf("&totalRows_Listind=%d%s", $totalRows_Listind, $queryString_Listind);
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
.style2 {font-size: 9%}
#search {		background-color:#eee;
}
.style12 {font-size: 12px}
.style13 {color: #3131DF}
.style14 {color: #6F39B0}
.style15 {color: #FFFFFF}
-->
</style>
<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<!-- InstanceBeginEditable name="head" --><!-- InstanceEndEditable -->
</head>

<body>
<div class="screen"><div id="header">
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</div>
		<div id="menutop" align="center">
        <!-- InstanceBeginEditable name="EditRegion4" -->
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
		    <li><a href="#">Recherche</a></li>
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

              <form id="form1" name="form1" method="POST" action="<?php echo $loginFormAction; ?>">
                <table border="0">
                  <tr>
                    <td colspan="2"><div align="center"><strong>Connexion</strong></div></td>
                  </tr>
                  <tr>
                    <td>Utilisateur</td>
                    <td><label>
                      <input name="NOM_UTIL" type="text" id="NOM_UTIL" size="15" />
                    </label></td>
                  </tr>
                  <tr>
                    <td>Mot de passe </td>
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
			?>
              <div class="story">
		        <p align="center">LISTE DES INDIVIDUS ENREGISTRES SUR LE SYSTEME</p>
		        <form id="form2" name="form2" method="post" action="">
                  <table border="1" id="entiteliste">
                    <tr class="head">
                      <td width="10">ID_IND</td>
                      <td>NOM_IND</td>
                      <td>PRENOM_IND</td>
                      <td>SEXE</td>
                      <td>GROUPE SANGUIN</td>
                      <td>Date Naissance</td>
                    </tr>
                    <?php do { ?>
                      <tr>
                        <td width="10"><?php echo $row_Listind['ID_IND']; ?></td>
                        <td><?php echo $row_Listind['NOM_IND']; ?></td>
                        <td><?php echo $row_Listind['PRENOM_IND']; ?></td>
                        <td><?php echo $row_Listind['SEXE_IND']; ?></td>
                        <td><?php echo $row_Listind['G_SANG_IND']; ?></td>
                        <td><?php echo $row_Listind['DATEH_NAIS']; ?></td>
                      </tr>
                      <?php } while ($row_Listind = mysql_fetch_assoc($Listind)); ?>
                      
                  </table>
                  <p align="center">&nbsp;
                  
Records <?php echo ($startRow_Listind + 1) ?> to <?php echo min($startRow_Listind + $maxRows_Listind, $totalRows_Listind) ?> of <?php echo $totalRows_Listind ?>
<table border="0" align="center">
                    <tr>
                      <td><?php if ($pageNum_Listind > 0) { // Show if not first page ?>
                            <a href="<?php printf("%s?pageNum_Listind=%d%s", $currentPage, 0, $queryString_Listind); ?>">First</a>
                            <?php } // Show if not first page ?>
                      </td>
                      <td><?php if ($pageNum_Listind > 0) { // Show if not first page ?>
                            <a href="<?php printf("%s?pageNum_Listind=%d%s", $currentPage, max(0, $pageNum_Listind - 1), $queryString_Listind); ?>">Previous</a>
                            <?php } // Show if not first page ?>
                      </td>
                      <td><?php if ($pageNum_Listind < $totalPages_Listind) { // Show if not last page ?>
                            <a href="<?php printf("%s?pageNum_Listind=%d%s", $currentPage, min($totalPages_Listind, $pageNum_Listind + 1), $queryString_Listind); ?>">Next</a>
                            <?php } // Show if not last page ?>
                      </td>
                      <td><?php if ($pageNum_Listind < $totalPages_Listind) { // Show if not last page ?>
                            <a href="<?php printf("%s?pageNum_Listind=%d%s", $currentPage, $totalPages_Listind, $queryString_Listind); ?>">Last</a>
                            <?php } // Show if not last page ?>
                      </td>
                    </tr>
                  </table>
                  </p>
<p>&nbsp;</p>
		        </form>
		        <p>&nbsp;</p>
		        <p>&nbsp;</p>
		        <p>&nbsp;</p>
		      </div>
		      <?php
	}
else
	echo "le nom d'utilisateur : ".$nomutil."<br>";
	echo "l'identite de groupe : ".$id_groupe."<br>";
	echo "le mot de passe : ".$pass."<br>";
?>
            </div>
  <!-- InstanceEndEditable -->
  <div class="spacer"></div>
		<div id="footer">
			<div class="content">
			<img src="Logo.jpg" width="116" height="49" /> <a href="#">A propos de nous </a> | <a href="#">Plan du Site </a> | <a href="#">R&egrave;gle d'utilisation </a> | <a href="#">Contactez-nous</a> | &copy;2009 SYREN
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

mysql_free_result($Listind);

mysql_free_result($tester);
?>
