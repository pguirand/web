<?php require_once('Connections/connex.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

$nomutili=$_SESSION['MM_Username'];    
	
// ** Logout the current user. **
$user = $_SESSION['MM_Username'];
$query_idd = "SELECT max(`session`.ID_SESSION) as id FROM `session` WHERE `session`.ID_UTIL = (select id_util from utilisateur where nom_util like '$user')";
mysql_select_db($database_connex, $connex);
$idd = mysql_query($query_idd, $connex) or die(mysql_error());
$row_idd = mysql_fetch_assoc($idd);
$rowid = $row_idd['id'];
$totalRows_idd = mysql_num_rows($idd);
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";

if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
 $updateSQL = sprintf("UPDATE session SET DATE_DECONN=NOW() WHERE ID_SESSION like '$rowid'");
  mysql_select_db($database_connex, $connex);
  $Result1 = mysql_query($updateSQL, $connex) or die(mysql_error());
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



		<div id="menutop" align="center">
<ul id="MenuBar1" class="MenuBarHorizontal">
<?php 
   $groupe = $_SESSION['NOM_GROUPE'];
   
if (($groupe == "administrateur dgi")|| ($groupe == "operateur dgi"))
    $entite = "Direction Generale des Impots || DGI ";
if (($groupe == "administrateur ime")|| ($groupe == "operateur ime"))
    $entite = "Immigration et Emigration || IME ";
if (($groupe == "administrateur archives")|| ($groupe == "operateur archives"))
    $entite = "Bureau des Archives Nationales || ANH ";
if (($groupe == "administrateur oni")|| ($groupe == "operateur oni"))
    $entite = "Office National d'Identification || ONI ";
if (($groupe == "administrateur justice")|| ($groupe == "operateur justice"))
    $entite = "Direction Generale des Impots || DGI ";
if (($groupe == "administrateur interieur")|| ($groupe == "operateur interieur"))
    $entite = "Ministere de l'interieur des Collectivités Territoriales et de la Sécurité Nationale || MICTSN ";
?>
      <div class="idsection"><?php echo $entite;?></div>
      <div class="loginbar">
        <div class="text">
           Bienvenue, <span class="fonce"><?php echo $_SESSION['MM_Username']; ?></span> :: Vous &ecirc;tes <span class="fonce"><?php echo $_SESSION['NOM_GROUPE']; ?> </span>            </div>
        <span class="logout"><a href="<?php echo $logoutAction ?>">Deconnexion</a></span>
        <div class="spacer"></div>
  </div>
      <li><a href="#">Accueil</a></li>
      <li><a class="MenuBarItemSubmenu" href="#">Entites</a>
        <ul><?php
		if ($groupe == "administrateur dgi"){?>
          <li><a href="saveentites.php">Enregistrer</a></li>
          <li><a href="#">Modifier</a></li>
          <?php }?>
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
      </li><?php 
	  if (($groupe == "administrateur syren")||($groupe == "administrateur dgi")||($groupe == "administrateur ime")||($groupe == "administrateur archives")||($groupe == "administrateur oni")||($groupe == "administrateur justice")|| ($groupe == "administrateur interieur")){?>
      <li><a href="#" class="MenuBarItemSubmenu">Utilisateurs</a>
        <ul>
          <li><a href="#">Cr&eacute;er</a></li>
          <li><a href="#">Modifier</a></li>
          <li><a href="#">Lister</a></li>
          <li><a href="#">Rechercher</a></li>
        </ul>
      </li><?php } ?>
      <li><a href="#">Rech. Avanc&eacute;e</a></li>
      <li><a href="#">Actualites</a></li>
<li><a href="#">Forum</a></li>
</ul>
      </div>
<div class="spacer"></div>
<script type="text/javascript">
<!--
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"/syren/SpryAssets/SpryMenuBarDownHover.gif", imgRight:"/syren/SpryAssets/SpryMenuBarRightHover.gif"});
//-->
</script>

<?php /*?><?php
mysql_free_result($loggedUser);
?><?php */?>
