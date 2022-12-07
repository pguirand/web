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
  $colname_loggedUser = $_POST['NOM_UTIL'];
}
mysql_select_db($database_connex, $connex);
$query_loggedUser = "SELECT * FROM utilisateur WHERE NOM_UTIL = 'colname'";
$loggedUser = mysql_query($query_loggedUser, $connex) or die(mysql_error());
$row_loggedUser = mysql_fetch_assoc($loggedUser);
$totalRows_loggedUser = mysql_num_rows($loggedUser);

$colname_updateEntiteLoad = "-1";
if (isset($_GET['ID_ENTITE'])) {
  $colname_updateEntiteLoad = $_GET['ID_ENTITE'];
}
mysql_select_db($database_connex, $connex);
$query_updateEntiteLoad = sprintf("SELECT * FROM entite, adresse, coordonnees WHERE entite.ID_ENTITE = adresse.ID_ENTITE and entite.ID_ENTITE=coordonnees.ID_ENTITE and entite.ID_ENTITE = %s", GetSQLValueString($colname_updateEntiteLoad, "text"));
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
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>

<title>SYREN | Système de Renseignement National</title>

<link href="css/style.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style10 {font-size: 10px}
#search {		background-color:#eee;
}
.style12 {font-size: 12px}
-->
</style>
<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />

<style type="text/css">
<!--
.style19 {font-size: 14px}
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
<div id="left">
          <div id="search">
            <form action="<?php echo $searchAction ?>">
              <label>
              <div class="section">
              <div align="center" class="title"><br />
              Recherche Rapide              
              </div>
              </div>
              <div align="center">
                <table width="167" style="display:none">
                  <tr>
                    <td width="60"><label>
                      <input name="rech" type="radio" value="ent"<?php if($_GET['rech'] == "") echo " checked='checked'" ?> <?php if ($_GET['rech'] == "ent") echo " checked='checked'" ?> />
                      <span class="style10">Entites</span></label></td>
                    <td width="95"><label><input type="radio" name="rech" value="publ" <?php if ($_GET['rech'] == "publ") echo " checked='checked'" ?> />
                      <span class="style10">Publications</span></label></td>
                  </tr>
                  </table>
                  
                  <p>
                    <label>
                    <input name="choix_rech" type="radio" id="entit" onclick="toggle('entit')" value="radio" checked="checked"/>
                     Entites</label>
                     <label>
                    <input type="radio" name="choix_rech" value="radio" id="publi" onclick="toggle('publi')" />
                      publications</label>
                    <br /><br />
                
              </div>
              <div align="center" class="title" id="entites" style="display:inline">
<div align="center" class="idsection">
             Entrer le nom de l'entite ci-dessus: </div>
                <p align="center">
                <input name="search" type="text" value="<?php echo $_GET['search'] ?>" size="28" onFocus="clearText(this)" onBlur="clearText(this)"/>
              </p>
       		<p align="center">
                <input name="goButton" type="submit" value="Lancer la recherche" />
              </p>
              
                        
              </div>
              <div align="center" id="publications" style="display:none">
              <div align="center" class="idsection"><a href="list_pub.php">Visualiser Publications</a></div></div>
              
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
			?>
  <div id="menutop">
		  <ul id="MenuBar2" class="MenuBarHorizontal">
				<li><a href="./">Accueil</a></li>
		      <li><a href="actugen.php">Actualites</a></li>
			  <li><a href="#">Culture</a></li>
			  <li><a href="forum2/phpBB3/index.php">Forums</a></li>
		  </ul>

</div>

  <div class="story">
    <h3 align="center">&nbsp;</h3>
    <h3 align="center">Fiche Entit&eacute;</h3>
  </div>
  <div class="story">
    <fieldset>
    <legend><span class="style10">Infos Generales</span></legend>
    <table width="98%" border="0" cellpadding="4" cellspacing="0" id="vueliste">
      <tr>
        <td colspan="3">Nom Entit&eacute;:<span class="fonce style19"><?php echo $row_updateEntiteLoad['NOM_ENTITE']; ?></span></td>
      </tr>

      <tr>
        <td width="323">No Patente:<strong><?php echo $row_updateEntiteLoad['NUM_PATENTE']; ?></strong></td>
        <td width="37">Logo:</td>
        <td width="175" rowspan="5"><img src="<?php echo $row_updateEntiteLoad['LOGO']; ?>" width="120" height="120" align="right" ></td>
      </tr>

      <tr>
        <td>Sigle : <strong><?php echo $row_updateEntiteLoad['SIGLE']; ?></strong> </td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Date de creation : <strong><?php echo $row_updateEntiteLoad['DATE_CREATION'];?></strong></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Date d'enregistrement : <strong><?php echo date ('j-M-Y h:i:s A',$row_updateEntiteLoad['DATE_SAVE']);?></strong></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Type d'entit&eacute;: <strong><?php echo $row_updateEntiteLoad['TYPE']; ?></strong></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Secteur d'activit&eacute;s: <strong><?php echo $row_updateEntiteLoad['SECTEUR_ACTIVITE']; ?></strong></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Niveau entreprise :<strong><?php echo $row_updateEntiteLoad['NIVEAU']; ?></strong></td>
        <td>Photo:</td>
        <td rowspan="7"><img src="images/photos/entites/<?php echo $row_updateEntiteLoad['photo']; ?>" width="150" height="150"></td>
      </tr>
      <tr>
        <td>site web :<strong><?php echo $row_updateEntiteLoad['SITE_WEB']; ?></strong></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Email :<strong><?php echo $row_updateEntiteLoad['EMAIL1']; ?></strong></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Adresse :<strong><?php echo $row_updateEntiteLoad['NOM_RUE']; ?></strong></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>T&eacute;l&eacute;phone1  : <strong><?php echo $row_updateEntiteLoad['NUM_TEL1']; ?></strong></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>T&eacute;l&eacute;phone2:<strong><?php echo $row_updateEntiteLoad['NUM_TEL2']; ?></strong></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>
    </fieldset>
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
<script type="text/javascript">
<!--
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"/syren/SpryAssets/SpryMenuBarDownHover.gif", imgRight:"/syren/SpryAssets/SpryMenuBarRightHover.gif"});
//-->
</script>
</body>
</html>
<?php
mysql_free_result($loggedUser);

mysql_free_result($updateEntiteLoad);
?>
