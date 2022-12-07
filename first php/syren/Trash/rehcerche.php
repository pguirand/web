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
<title>SYREN | Système de Renseignement National</title>
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
/* * * * * * * * * * * * * * * * * * * * * * *
            A Blork Engine v0.23b 
            Script du moteur

Pour les gens qui veulent modifier le moteur à leur goût, je vous ai 
mis des commentaires au cours du script qui vous aideront à vous 
repérer. 

* * * * * * * * * * * * * * * * * * * * * * *

a Blork Engine
Copyright (C) 2003 zulios

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.

* * * * * * * * * * * * * * * * * * * * * * */
?>
<?php
/* * * * * * * * * * * * * * * * * * * * * * *
Modification le 30/03/2009 - Charon44.fr
  intégration dans ZITE
* * * * * * * * * * * * * * * * * * * * * * */
?>

<?php
    include('syren/index.php');

    // Initalisation de zene, avec le template 'main'
    $zite = & new zite(__FILE__);

    // Décommenter si l'on souhaite inhiber la réécriture d'URL
    $zite->rewrite = false;

    // On génère le contenu
    $zite->builder();

  if($_POST){
    //Récupération des données du formulaire
    $action = $_POST['action'];
    $chaine = $_POST['chaine'];
    $start  = $_POST['start'];
    $multi  = $_POST['multi'];
  }

// Liste des codes htmls spéciaux 
$caractere_special=array(
'&agrave;'=>'à',
'&aacute;'=>'á',
'&acirc;'=>'â',
'&atilde;'=>'ã',
'&auml;'=>'ä',
'&aring;'=>'å',
'&aelig;'=>'æ',
'&ccedil;'=>'ç',
'&egrave;'=>'è',
'&eacute;'=>'é',
'&ecirc;'=>'ê',
'&euml;'=>'ë',
'&icirc;'=>'î',
'&iuml;'=>'ï',
'&ocirc;'=>'ô',
'&ouml;'=>'ö',
'&ugrave;'=>'ù',
'&uacute;'=>'ú',
'&ucirc;'=>'û',
'&uuml;'=>'ü',
'&amp;'=>'&',
); 
// On fait les includes de base 

$config_version="0.23b";
// nombre de résultats maximum à afficher par page
$maxipage="20";
// Configurer les dossiers à scanner 
// # ZITE # dans mon cas, je n'ai mis que "zdata"
$dossier=array( 
'dossier data'=>'zdata',
);
//(Dés)activation du scan des sous dossiers 
$scan_sousdos="off";
//Configuration des fichiers/dossiers à exclure de la recherche
//# ZITE # mettre la liste des fichiers ne devant pas être scannés
$exclu=array(
"config.ini",
"message.ini",
"files.dta",
"structure.dta",
".htaccess",

);
//Indiquez à la ligne ci dessous entre les guillemets on ou off :
//on      pour afficher l'extension des fichiers
//off     pour désactiver l'affichage de l'extension des fichiers */ 
$montre_ext="off";
// Indiquez à la ligne ci dessous entre les guillemets l'url type à utiliser dans le moteur
// si vous n'utilisez pas les pseudos frames ne modifiez pas cette url type
// utilisez [dossier] pour indiquer le dossier
// et [fichier] pour indiquer le fichier 
$go2url="[dossier]/[fichier]";

$version="0.23b"; 

// Variables par défaut 

$maxmots="20";
$maxipage="20";

if ($start=="" || $start=="0" ) { $start="1"; }

$longueur_chaine=strlen($chaine);
$chaine=trim($chaine);
$chaine=ereg_replace(" +", " ", $chaine);
$chaine2=htmlspecialchars($chaine);

$form_recherche="<form method=POST>
<input type=hidden value=\"go\" name=action>
<input type=hidden value=\"$start\" name=start>
<input type=hidden value=\"$multi\" name=multi>
<input type=text value=\"$chaine2\" maxlength=50 size=25 name=chaine>
<input type=submit value='rechercher'><br>
</form>";

?>

<!DOCT    YPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/index.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
<!-- InstanceBeginEditable name="doctitle" -->
<title>SYREN | Système de Renseignement National</title>
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
<?php if($_SESSION['MM_Username'] == NULL)
			{
			?>
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
/* * * * * * * * * * * * * * * * * * * * * * *
            A Blork Engine v0.23b 
            Script du moteur

Pour les gens qui veulent modifier le moteur à leur goût, je vous ai 
mis des commentaires au cours du script qui vous aideront à vous 
repérer. 

* * * * * * * * * * * * * * * * * * * * * * *

a Blork Engine
Copyright (C) 2003 zulios

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.

* * * * * * * * * * * * * * * * * * * * * * */
?>
<?php
/* * * * * * * * * * * * * * * * * * * * * * *
Modification le 30/03/2009 - Charon44.fr
  intégration dans ZITE
* * * * * * * * * * * * * * * * * * * * * * */
?>

<?php
    include('syren/index.php');

    // Initalisation de zene, avec le template 'main'
    $zite = & new zite(__FILE__);

    // Décommenter si l'on souhaite inhiber la réécriture d'URL
    $zite->rewrite = false;

    // On génère le contenu
    $zite->builder();

  if($_POST){
    //Récupération des données du formulaire
    $action = $_POST['action'];
    $chaine = $_POST['chaine'];
    $start  = $_POST['start'];
    $multi  = $_POST['multi'];
  }

// Liste des codes htmls spéciaux 
$caractere_special=array(
'&agrave;'=>'à',
'&aacute;'=>'á',
'&acirc;'=>'â',
'&atilde;'=>'ã',
'&auml;'=>'ä',
'&aring;'=>'å',
'&aelig;'=>'æ',
'&ccedil;'=>'ç',
'&egrave;'=>'è',
'&eacute;'=>'é',
'&ecirc;'=>'ê',
'&euml;'=>'ë',
'&icirc;'=>'î',
'&iuml;'=>'ï',
'&ocirc;'=>'ô',
'&ouml;'=>'ö',
'&ugrave;'=>'ù',
'&uacute;'=>'ú',
'&ucirc;'=>'û',
'&uuml;'=>'ü',
'&amp;'=>'&',
); 
// On fait les includes de base 

$config_version="0.23b";
// nombre de résultats maximum à afficher par page
$maxipage="20";
// Configurer les dossiers à scanner 
// # ZITE # dans mon cas, je n'ai mis que "zdata"
$dossier=array( 
'dossier data'=>'zdata',
);
//(Dés)activation du scan des sous dossiers 
$scan_sousdos="off";
//Configuration des fichiers/dossiers à exclure de la recherche
//# ZITE # mettre la liste des fichiers ne devant pas être scannés
$exclu=array(
"config.ini",
"message.ini",
"files.dta",
"structure.dta",
".htaccess",

);
//Indiquez à la ligne ci dessous entre les guillemets on ou off :
//on      pour afficher l'extension des fichiers
//off     pour désactiver l'affichage de l'extension des fichiers */ 
$montre_ext="off";
// Indiquez à la ligne ci dessous entre les guillemets l'url type à utiliser dans le moteur
// si vous n'utilisez pas les pseudos frames ne modifiez pas cette url type
// utilisez [dossier] pour indiquer le dossier
// et [fichier] pour indiquer le fichier 
$go2url="[dossier]/[fichier]";

$version="0.23b"; 

// Variables par défaut 

$maxmots="20";
$maxipage="20";

if ($start=="" || $start=="0" ) { $start="1"; }

$longueur_chaine=strlen($chaine);
$chaine=trim($chaine);
$chaine=ereg_replace(" +", " ", $chaine);
$chaine2=htmlspecialchars($chaine);

$form_recherche="<form method=POST>
<input type=hidden value=\"go\" name=action>
<input type=hidden value=\"$start\" name=start>
<input type=hidden value=\"$multi\" name=multi>
<input type=text value=\"$chaine2\" maxlength=50 size=25 name=chaine>
<input type=submit value='rechercher'><br>
</form>";

?>

<!DOCT    YPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $zite->content['menu_title'].', '.$zite->get_data('site_title') ?></title>
<link href="not-6.css" rel="stylesheet" type="text/css" />
</head>

<body>
  <div id="page">
    <div id="top">
      <h1><?php echo $zite->get_data('site_title') ?></h1>
      <h2><?php echo $zite->get_data('site_subtitle') ?></h2>
    </div>
    <div id="mid">
      <div id="side">
        <form action="./recherche.php" method="post" enctype="multipart/form-data">
          <input type=hidden value="go" name=action>
          <input type=hidden value="" name=start>
          <input type=hidden value="" name=multi>
          <input type=text size=20 name=chaine value="Rechercher" onfocus="this.value='';" class="verdana11gris">
        <?php echo $zite->content['menu'] ?>
        <?php echo $zite->get_content(module_lateral, true) ?>
        </form>
      </div>
      <div id="main">
        <h1>Recherche</h1>
          <h3>Recherche de &ldquo;<?php echo($chaine2);?>&rdquo; <span style="font-size: 60%;">- Powered By a Blork Engine</span></h3>
<?php     // On vérifie que la recherche est correctement lancée 
          if ($action!="go") { // on ne fait rien
          }
          else { // On vérifie la longueur de la recherche 
            if($longueur_chaine<3) {
              echo("Votre recherche doit comporter au moins trois caractères.<br>");
            }
            else {
              // Résultats à 0 
              $compteresultats="0"; 
              $zetotal="0"; 

              // Scan des sous dossiers sur 10 niveaux si on l'a activé 
              // On vérifie les sous-dossiers à scanner uniquement ici
              // Ensuite on les rajoute à la liste 
              // Comme ça après on n'aura plus qu'a faire un scan classique 
              // Sur tous les dossiers de la liste 
              if($scan_sousdos=="on") {
                $encore1=array();
                $encore2=array();
                foreach ($dossier as $nomdos=>$d) {
                  // Sous-dossier 1
                  $fp=opendir("$d");
                  while ($file = readdir($fp)) {
                    if ($file!='.' && $file!='..') {
                      $verif=$d."/".$file;
                      if (is_dir($verif) && !(in_array($verif, $dossier)) && !(in_array($verif, $exclu))) {
                        $dossier[]="$verif";
                        $encore1[]="$verif";
                      }
                    }
                  }
                  closedir($fp);
                  unset($fp);
                  unset($nomdos);
                }
                // Sous-dossier 2 
                foreach ($encore1 as $nom_du_soudos=>$le_soudos) {
                  $fp=opendir("$le_soudos");
                  while ($file = readdir($fp)) {
                    if($file!='.' && $file!='..') {
                      $verif=$le_soudos."/".$file; 
                      if(is_dir($verif) && !(in_array($verif, $dossier)) && !(in_array($verif, $exclu))) {
                        $dossier[]="$verif";
                        $encore2[]="$verif";
                      }
                    }
                  }
                  closedir($fp);
                  unset($fp,$nom_du_soudos,$le_soudos);
                  $encore1=array();
                }
              }
              // Passage en minuscules de la recherche
              $chaine=strtolower($chaine);
              $total_mots=0;

              // Maintenant on lance le scan classique sur les dossiers de la liste 
              // Les sous-dossiers ont été rajoutés au besoin par la fonction précédente 

              foreach($dossier as $nomdos=>$d) {
                // Sésame ouvre toi 
                $fp=opendir("$d"); 
                while($file = readdir($fp)) {
                  if ($file=="." || $file==".." || is_dir($file)) { continue; }
                  // On ne scanne pas les fichiers exclus 
                  if (in_array($file, $exclu)) { continue; }
                  // On récupère l'extension 
                  // Merci à Frédéric Bouchery pour ce regex :-) 
                  $ext = ereg_replace('^.*[.]([^.]*)$', '\\1', $file);
                  // Sélection des extensions
                  // On ne scanne que ces types de fichiers 
                  if ($ext!="php" && $ext!="txt" && $ext!="gif" && $ext!="jpg" && $ext!="png") { continue; }
                  // Maintenant on est sûr de devoir scanner le fichier
                  // On peut éxécuter tous les traitements nécessaires

                  // Détermination du type de fichier 
                  // On ne vérifiera que le nom des fichiers de type "img" (image) 
                  // alors que les fichiers de type "normal" seront entièrement retraités 
                  // car considérés comme contenant du texte lisible par le moteur. 

                  if ($ext=="php" || $ext=="txt") { $filetype="normal"; } else { $filetype="img"; }

                  // Maintenant qu'on a déterminé la place de notre fichier entre les deux types 
                  // On va appliquer des retraitements préliminaires sur les fichiers de type "normal" uniquement 
                  if($filetype=="normal") {
                    // On ouvre le contenu du fichier
                    $recupere_le_fichier=fopen("$d/$file","r");
                    $tout=fread($recupere_le_fichier,500000);
                    fclose($recupere_le_fichier);
                    // Passage en minuscules
                    $tout=strtolower($tout);
                    // On récupère le titre du fichier 
                    // Ou alors on affiche le nom avec l'extension 
                    if(strpos($tout,"<title>") && strpos($tout,"</title>")) {
                      $titre1=strstr($tout,'<title>');
                      $titre2=strstr($tout,'</title>');
                      $titre1=str_replace("$titre2","",$titre1);
                      $titre1=str_replace("<title>","",$titre1);
                      if($titre1==""){ $titre=$file; } else { $titre=$titre1; }
                    }
                    else {
                      $extpage = substr(strrchr($file, "."), 1);
                      $extpage =".".$extpage;
                      $titre=str_replace($extpage,"",$file);
                    }
                    $titre=strtolower($titre);
                    unset($titre1, $titre2);

                    // 3 étapes ici : 
                    // Etape 1 -
                    // On effectue des remplacements pour pouvoir appliquer les regex : 
                    // 1- On remplace le saut de ligne par un espace 
                    $tout = str_replace("\n"," ",$tout);
                    // 3- Les &nbsp; (code html pour un espace) sont remplacés par des espaces 
                    $tout = str_replace("&nbsp;"," ",$tout);
                    // 4- Les doubles espaces sont remplacés par un simple espace 
                    $tout = str_replace("  "," ",$tout);

                    // Etape 2- 
                    // On lance les regex 
                    // 1- On vire le code entre <head> et </head> qui contient en général tout les trucs qui ne nous intéressent pas ici (feuille de style, javascript...) 
//                    $tout = preg_replace('`<head.*?/head>`', '', $tout);
                    // 2- On vire le javascript pour éviter les bugs au cas ou une partie nous aurait échappée 
//                    $tout = preg_replace('`<script.*?/script>`', '', $tout);
                    // 3- On vire les attributs de style pour les mêmes raisons 
//                    $tout = preg_replace('`<style.*?/style>`', '', $tout);
                    // Merci encore une fois à Frédéric Bouchery pour le regex  

                    // Etape 3- 
                    // On remplace le code html des accents et autres caractères spéciaux par le terme correspondant 
                    // pour le titre ET le contenu 
                    foreach($caractere_special as $caractere_code=>$caractere_traduction) {
                      $tout = str_replace("$caractere_code","$caractere_traduction",$tout);
                      $titre = str_replace("$caractere_code","$caractere_traduction",$titre);
                    }

                    // On vire les tags
                    $tout=strip_tags($tout);

                    // Fin du retraitement 
                  }

                  // Maintenant le fichier a été retraité (si nécessaire), 
                  // on peut voir s'il contient ce qu'on cherche. 

                  // On incrémente le nb de fichiers scannés 
                  $zetotal++; 
                  if ($zetotal>9999) { continue 2; }

                  if ((strpos("$tout","$chaine")===false) && (strpos("$file","$chaine")===false) && (strpos("$titre","$chaine")===false)) {
                    // on ne trouve rien
                  }
                  else {
                    // Si on trouve la recherche = Résultats +1
                    $compteresultats++;
                    // S'il s'agit d'un fichier de type "normal"
                    if($filetype=="normal") {
                      // On compte les occurences du terme 
                      // Les occurences trouvées dans le titre comptent pour 10 (pire qu'au scrabble) car ils sont souvent explicites sur le contenu de la page 

                      $total_mots = intval(substr_count($titre,$chaine)*10 + $total_mots);
                      $total_mots = intval(substr_count($tout,$chaine) + $total_mots);

                      // On crée la description

                      $position=strpos($tout, $chaine);
                      $start_position=intval($position-50);
                      if ($start_position<0) { $start_position="0"; }
                      $fin_position=intval($longueur_chaine+100);

                      if ($position === FALSE ) {
                        $resume.="<span class='obsv'>Terme exact introuvable dans le contenu du fichier.</span>";
                      }
                      else {
                        $resume="... ";
                        $resume.=substr($tout, $start_position, $fin_position);
                        $resume.=" ... ";
                        // On met en gras le terme recherché dans la description 
                        $resume=str_replace($chaine,"<b>$chaine2</b>",$resume);
                      }
                    }
                    else {
                      // Si c'est une image ou un autre type de fichier 
                      // On adapte la description  
                      $resume="Fichier $ext";
                    }
                    // Puis dans le titre 
                    $titre=str_replace($chaine,"<b>$chaine2</b>",$titre);
                    // Calcul du pourcentage de pertinence 
                    similar_text($chaine, $tout, $p1);
                    similar_text($chaine, $titre, $p2);
                    $p=intval($p1+$p2);
                    // Si le pourcentage est supérieur ou égal à 100 on le ramène à 99 
                    // Et s'il est égal à 0 on le ramène à 1 pour qu'il puisse être réindexé (voir suite) 
                    if ($p>=100) { $p="99"; }
                    if ($p=="0") { $p="1"; }
                    // On va créer une clé identique pour chaque résultat.
                    // Le premier sera un "1", pour que la clé soit réindexée 
                    // Le suivant sera le nombre d'occurences total de mots trouvés (en dizaines) 
                    // Ensuite le pourcentage de similarité du texte + celui du titre (deux chiffres) 
                    // Enfin le numéro du résultat (4 chiffres) 
                    // Avec cette clé on pourra classer les résultats par ordre décroissant selon le chiffre obtenu, donc par pertinence. 

                    // Notes : 
                    // La clé ne doit pas commencer par 0 donc il était important de mettre en premier 
                    // un "1", ou un chiffre supérieur à 0 en tout cas.
                    // La clé ne doit pas être supérieure à 8 chiffres, sinon elle ne sera pas réindexée. 

                    // Cette bidouille me permettra par la suite avec array_unshift() de réindexer le tableau avec 
                    // des clés numériques pour pouvoir afficher uniquement les résultats souhaités, donc j'économise 
                    // du temps d'éxécution et des ressources par rapport à l'ancienne méthode qui consistait à créer
                    // un nouveau tableau. L'array_unshift() me rajoutera une valeur de clé 0 que je ne supprime pas 
                    // parce que je pourrai ainsi gérer mes résultats à partir de 1, ce qui est plus logique. 

                    // On ramène les occurences au maxi à 99 
                    // Puis on rajoute un 0 devant le chiffre s'il est inférieur à 10 
                    // Enfin on ne garde que le chiffre des dizaines 

                    if ($total_mots>=100) { $total_mots="99"; }
                    if (strlen($total_mots)==1) {
                      $total_mots=str_repeat("0",2-strlen($total_mots)).$total_mots;
                    }
                    $total_mots=substr($total_mots, 0, 1);

                    // Idem pour les pourcentages 
                    if (strlen($p)==1) {
                      $p=str_repeat("0",2-strlen($p)).$p;
                    }
                    // Et enfin le numéro du résultat 
                    $compteresultats2=$compteresultats; 
                    if (strlen($compteresultats2)<4) {
                      $compteresultats2=str_repeat("0",4-strlen($compteresultats2)).$compteresultats2;
                    }
                    // On met la première lettre du titre en majuscules
                    $titre=ucfirst($titre);
                    // URL par défaut pour les fichiers
                    // On vire l'extension si besoin
                    if ($montre_ext=="off" && $filetype!="img") {
                      $file=str_replace(".$ext","",$file);
                    }
                    if ($go2url=="") { $go_2_url="$d/$file"; }
                    else {
                      $go_2_url="$go2url";
                      $go_2_url=str_replace("[dossier]",$d,$go_2_url);
                      $go_2_url=str_replace("[fichier]",$file,$go_2_url);
                    }
                    // Source du résultat 
                    $src=" <a href=\"index.php?perma=$file\">$titre</a> <br> <span class=\"verdana12gris\">$resume</span>";

                    // On enregistre 
                    $zeresults["1".$total_mots."".$p."".$compteresultats2]="$src";

                    // On remet a zéro histoire d'éviter des doublons  
                    unset($compteresultats2,$tout,$resume,$src,$titre,$filetype,$p,$p1,$p2,$file,$ext,$total_mots,$register);
                  }
                }
                // On referme 
                // Sésame ferme toi 
                closedir($fp); 
                unset($tout,$filetype,$fp,$ext);
              }

              // Si on a des résultats
              // On les classe par ordre décroissant de pertinence 
              // Ensuite on lance un array_unshift() qui réindexe le tableau 
              // ce qui nous permet d'avoir des clés numériques et de gérer les résultats à partir de 1
              // Pour de plus amples explications vous pouvez voir un peu plus haut 
              // ou me contacter, j'essaierai de vous expliquer ça en détail. 

              if($compteresultats>0) {
                krsort($zeresults);
                array_unshift($zeresults,"rien");
              }

              // On définit les différentes variables qui serviront pour la barre de navigation 
              if ($start=="1" && $compteresultats=="0" ) { $start="0"; }
              $pourvoir=intval($start+$maxipage-1);
              if ($pourvoir>$compteresultats) { $pourvoir=$compteresultats; }
              $finstart=intval($compteresultats-$maxipage+1);
              $prevbarre=intval($start-$maxipage);
              $nextbarre=intval($start+$maxipage);
              $nb_barre="1";
              $compte_affichage=$start;

              // Changement du texte selon les résultats 
              // Entre singulier et pluriel 

              $rs=" résultat trouvé ";
              $fich=" fichier";
              if ($compteresultats>1) { $rs=" résultats trouvés "; }
              if ($zetotal>1) { $fich=" fichiers"; }

              // Maintenant on commence l'affichage 
              echo(" $compteresultats $rs sur $zetotal $fich");
              if ($compteresultats!=0) echo(" - Affichage des résultats $start à $pourvoir");

              if ($compteresultats>0) { echo("$form_recherche"); }

              // On sélectionne les éléments du tableau de résultat à afficher et on les lance 
              if($compteresultats>0) {
                foreach($zeresults as $key=>$value) {
                  if ($key>=$start && $key<$nextbarre) {
                    echo("<br><br>$value");
                    $compte_affichage++;
                  }
                }
              }

              // Et si on a trop de résultats par rapport au nombre à afficher dans la page on met la barre de navigation 
              if($compteresultats>$maxipage) {
                echo("<p align=center><br>");
                if($start!="1") {
                  echo("<a href=\"recherche.php?chaine=$chaine&action=go&choix=$choix\"><< Début</a> <a href=\"recherche.php?chaine=$chaine&action=go&start=$prevbarre&choix=$choix\">< Page précédente</a> (");
                }
                else {
                  echo("<< Début < Page précédente (");
                }
                for ($barre=1;$barre<$compteresultats;) {
                  $finbarre=intval($compteresultats-$barre);
                  echo(" <a href=\"recherche.php?chaine=$chaine&action=go&start=$barre&choix=$choix\">$nb_barre</a> ");
                  $nb_barre++;
                  $barre=intval($barre+$maxipage);
                }
                if ($start<$finstart) {
                  echo(") <a href=\"recherche.php?chaine=$chaine&action=go&start=$nextbarre&choix=$choix\">Page suivante ></a> <a href=\"recherche.php?chaine=$chaine&action=go&start=$finstart&choix=$choix\">Fin >></a>");
                }
                else {
                  echo(") Page suivante >  Fin >>");
                }
                echo("</p>");
              }
              if($compteresultats=="0") {
                echo("<p align=center><br> Votre recherche sur le terme <b>$chaine2</b> n'a donné aucun résultat. Essayez d'élargir votre recherche en y mettant moins de mots ou vérifiez son orthographe.</p>");
              }
              else {
                echo("<p align=center><br>$compteresultats $rs sur $zetotal $fich.</p>");
              }
            }
          }
          echo("$form_recherche"); ?>
      </div>
      <div id="break"></div>
    </div>
    <div id="bot">Site motorisé par <a href="http://zite.prositif.com">ZITE CMS <?php echo ZITEVER ?></a></div>
  </div>
</body>
</html>
			  <?php
if($_GET['search'] == "")
	{
?>
              <?php
				echo $info
			?>
              <h3>&nbsp;</h3>
		      <div class="story">
                <h3>Probl&eacute;matique</h3>
		        <p align="justify">&nbsp;</p>
	          </div>
		      <div class="story">
                <h3>&nbsp;</h3>
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
?>
