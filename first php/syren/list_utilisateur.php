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

$queryString_UTIL = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_UTIL") == false && 
        stristr($param, "totalRows_UTIL") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_UTIL = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_UTIL = sprintf("&totalRows_UTIL=%d%s", $totalRows_UTIL, $queryString_UTIL);

mysql_select_db($database_connex, $connex);
$query_UTIL = "SELECT U.NOM_UTIL, I.NOM_IND, I.PRENOM_IND, G.NOM_GROUPE, U.STATUT, E.NOM_ENTITE FROM utilisateur U, INDIVIDU I, ENTITE E, GROUPE G WHERE U.ID_IND=I.ID_IND AND U.ID_GROUPE = G.ID_GROUPE AND U.ID_ENTITE = E.ID_ENTITE";
$query_limit_UTIL = sprintf("%s LIMIT %d, %d", $query_UTIL, $startRow_UTIL, $maxRows_UTIL);
$UTIL = mysql_query($query_limit_UTIL, $connex) or die(mysql_error());
$row_UTIL = mysql_fetch_assoc($UTIL);

if (isset($_GET['totalRows_UTIL'])) {
  $totalRows_UTIL = $_GET['totalRows_UTIL'];
} else {
  $all_UTIL = mysql_query($query_UTIL);
  $totalRows_UTIL = mysql_num_rows($all_UTIL);
}
$totalPages_UTIL = ceil($totalRows_UTIL/$maxRows_UTIL)-1;
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
	        
<div id="right">
  <?php
if($_GET['search'] == "")
	{
?>
  <?php
				echo $info
			?><BR>
  <div class="fonce" align="center">LISTE UTILISATEUR</h3></div>
  <div class="story">
    <p>&nbsp;</p>
    <div>
      <table width="" border="0" cellpadding="0" cellspacing="0" id="entiteliste">
        <tr class="head">
       	  <td><div align="center">NOM UTILILISATEUR</div></td>
		  <td><div align="center">NOM DE L'INDIVIDU</div></td>
          <td><div align="center">PRENOM DE L'INDIVIDU</div></td>
          <td><div align="center">GROUPE D'APPARTENANCE</div></td>
          <td><div align="center">STATUT</div></td>
          <td><div align="center">NOM DE L'ENTITE</div></td>
        </tr>
        <?php do { ?>
            <tr>
              <td><div align="center"><?php echo $row_UTIL['NOM_UTIL']; ?></div></td>
              <td><div align="center"><?php echo $row_UTIL['NOM_IND']; ?></div></td>
              <td><div align="center"><?php echo $row_UTIL['PRENOM_IND']; ?></div></td>
              <td><div align="center"><?php echo $row_UTIL['NOM_GROUPE']; ?></div></td>
              <td><div align="center"><?php echo $row_UTIL['STATUT']; ?></div></td>
              <td><div align="center"><?php echo $row_UTIL['NOM_ENTITE']; ?></div></td>
              <td><a href="updentites.php?ID_ENTITE=<?php echo $row_liste_entites['ID_UTIL']; ?>" title="Modifier Entité"><img src="images/pencilart.jpeg" width="20" height="20"  border="0" /></a></td>
              <td><a href="viewentites.php?ID_ENTITE=<?php echo $row_liste_entites['ID_UTIL']; ?>" title="Visualiser Entité"><img src="images/eyeart.jpeg" width="20" height="20"  border="0" /></a></td>   
            </tr>
            <?php } while ($row_UTIL = mysql_fetch_assoc($UTIL)); ?>
      </table>
    </div>
    <p>Total<?php echo ($startRow_UTIL + 1) ?>?> <?php echo min($startRow_UTIL + $maxRows_UTIL, $totalRows_UTIL) ?> su<?php echo $totalRows_UTIL ?>Entités</p>
    <p>&nbsp;</p>
    <table border="0" align="center"->
      <tr class="head">
        <td><?php if ($pageNum_UTIL > 0) { // Show if not first page e ?>
          <a href<?php printf("%s?pageNum_UTIL=%d%s", $currentPage, 0, $queryString_UTIL); ?>">Début</a><?php } // Show if not first page e ?>        </td>
        <td><?php if ($pageNum_UTIL > 0) { // Show if not first page e ?>
          <a href<?php printf("%s?pageNum_UTIL=%d%s", $currentPage, max(0, $pageNum_UTIL - 1), $queryString_UTIL); ?>">Précédent</a><?php } // Show if not first page e ?>                    </td>
        <td><?php if ($pageNum_UTIL < $totalPages_UTIL) { // Show if not last page e ?>
          <a href<?php printf("%s?pageNum_UTIL=%d%s", $currentPage, min($totalPages_UTIL, $pageNum_UTIL + 1), $queryString_UTIL); ?>">Suivant</a>
        <?php } // Show if not last page e ?>                    </td>
        <td><?php if ($pageNum_UTIL < $totalPages_UTIL) { // Show if not last page e ?>
          <a href<?php printf("%s?pageNum_UTIL=%d%s", $currentPage, $totalPages_UTIL, $queryString_UTIL); ?>?>">Fin</a><?php } // Show if not last page e ?>        </td>
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
?>
