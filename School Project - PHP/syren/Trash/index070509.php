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

$maxRows_recherche = 10;
$pageNum_recherche = 0;
if (isset($_GET['pageNum_recherche'])) {
  $pageNum_recherche = $_GET['pageNum_recherche'];
}
$startRow_recherche = $pageNum_recherche * $maxRows_recherche;

$colname_recherche = "-1";
if (isset($_GET['search'])) {
  $colname_recherche = $_GET['search'];
}
if ($_GET['rech'] == "ent")
	{
		$table = "entite";
		$champ = "Nom";
	}
	else
		{
			$table = "publications";
			$champ = "TITRE_PUB";
		}
mysql_select_db($database_connex, $connex);
$query_recherche = "SELECT * FROM ".$table." WHERE ".$champ." = 'colname'";
$recherche = mysql_query($query_recherche, $connex) or die(mysql_error());
$row_recherche = mysql_fetch_assoc($recherche);
$totalRows_recherche = mysql_num_rows($recherche);
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
  
  $LoginRS__query=sprintf("SELECT NOM_UTIL, MOT_PASS FROM utilisateur WHERE NOM_UTIL=%s AND MOT_PASS=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $connex) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

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
#==================================================
#	MODULE DE RECHERCHE
#==================================================

$searchAction = $_SERVER['PHP_SELF'];
$search = $_GET['search'];

			$requet = "SELECT * FROM entite2 WHERE Nom='".$search."'";
				if($result = mysql_query($requet))
					{
						while($ligne = mysql_fetch_array($result))
						{
								$nom		= $ligne['Nom'];
								$groupe		= $ligne['Groupe'];
								$adresse	= $ligne['adresse'];
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
<title>SYREN | Syst?me de Renseignement National</title>
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
</head>

<body>
<div class="screen">
  <div id="header">
			
		  <p>&nbsp;</p>
    <p>&nbsp;</p>
  </div>
<div id="menutop">
		  	  <ul id="MenuBar1" class="MenuBarHorizontal">
		      <li><a class="MenuBarItemSubmenu" href="#">Entit&eacute;s</a>
		          <ul>
		            <li><a href="#">Rechercher</a></li>
		            <li><a href="/syren/rech_entites.php">Lister</a></li>
	            </ul>
	          </li>
		      <li><a href="#">Actualit&eacute;s</a></li>
		      <li><a class="MenuBarItemSubmenu" href="#">Ev&eacute;nements</a>
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
  </div>
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
                    <td colspan="2"><div align="center"><strong>Login </strong></div></td>
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
                <label></label>
                <input type="submit" name="Submit" value="Connexion" />
                <p><?php echo $warning; ?></p>
                <p align="center"><a href="#">Mot de passe oubli&eacute;?</a></p>
              </form>
	      </div>
		  <div class="section">
            <div class="title">Actualit&eacute;s Internationales</div>
		    <ul>
              <li><a href="entites1.php",'content'>
                <!--<a href="javascript:ajaxpage('entites.php', 'content');">-->
                Entites gouvernementales </a></li>
		      <li><a href="entites.php?type=nongouv">
		        <!--<a href="javascript:ajaxpage('entites.php', 'content');">-->
		        Entit&eacute;s non Gouvernemantales</a></li>
		      <li><a href="#">Institutions Priv&eacute;es </a></li>
		      <li><a href="#">Institutions Publiques </a><a href="#">Soci&eacute;t&eacute;s Anonymes</a></li>
	        </ul>
	      </div>
		  <div class="section">
            <div class="title">Actualit?s locales</div>
		    <ul>
              <li><a href="#">Demographie</a></li>
		      <li><a href="#">Statistique</a></li>
		      <li><a href="#">Listing...</a></li>
		      <li><a href="#">Recherche...</a></li>
		      <li><a href="formulaire1.php?type=nongouv"> Enregistrement </a></li>
	        </ul>
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
          <h3>&nbsp;</h3>
          <h3>Pr&eacute;ambule <?php echo $row_loggedUser['ID_ENTITE']; ?></h3>
          <p align="justify">Avec  le d&eacute;veloppement des Nouvelles Technologies de l&rsquo;Information et de la<a href="#"></a> Communication (NTIC), l&rsquo;informatique se r&eacute;v&egrave;le un outil important et  indispensable dans la gestion des donn&eacute;es et le traitement des informations,  dans les institutions ou entreprises. Cependant, cet outil reste encore  inexploit&eacute; par bon nombre d&rsquo;institutions (ou entreprises) en Ha&iuml;ti, malgr&eacute; les  multiples efforts d&eacute;ploy&eacute;s dans le domaine pour rendre plus efficaces les  travaux de ces derniers; d&rsquo;autant plus, certains ne poss&egrave;dent pas </p>
         
		    <p align="justify">un syst&egrave;me  informatique. En analysant minutieusement la structure du traitement de  l&rsquo;information du syst&egrave;me de renseignement National Ha&iuml;tien, nous avons constat&eacute;  qu&rsquo;elle est confront&eacute;e &agrave; de nombreux probl&egrave;mes. Notre travail, relativement &agrave;  sa mission, coiffe un &eacute;ventail d&rsquo;Institutions, soit cinq (5) grandes entit&eacute;s,  et plusieurs sous-entit&eacute;s, avec des droits et interactions entre ces derni&egrave;res.&nbsp; Donc, la gestion d&rsquo;un tel syst&egrave;me exige une  coh&eacute;rence relationnelle entre ces diff&eacute;rents entit&eacute;s et sous-entit&eacute;s. Cependant  il y a des failles qui portent les institutions &agrave; faire face &agrave; des contraintes  &agrave; plusieurs niveaux. Ces inconv&eacute;nients ou imperfections constituent un obstacle  de grande envergure dans la marche ad&eacute;quate et la gestion d&rsquo;un syst&egrave;me de  renseignement national. </p>
	      <div class="story">
            <h3>&nbsp;</h3>
		    <p align="justify">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; N&rsquo;est-il pas important pour  l&rsquo;&Eacute;tat de penser &agrave; promouvoir un syst&egrave;me de renseignement national?&nbsp; Et, &agrave; travers ce syst&egrave;me d&rsquo;information  fiable, arriver &agrave; g&eacute;rer mieux et coordonner les activit&eacute;s des diff&eacute;rentes  Institutions et Entreprises du pays? Et, comment peut-on&nbsp; agir pour doter l&rsquo;Etat d&rsquo;un syst&egrave;me de  renseignement national fiable pour la bonne marche du pays? </p>
		    
		    <p align="justify">Ces  questions sont essentielles &agrave; l&rsquo;analyse des solutions. Pour ce faire, nous  sugg&eacute;rons le d&eacute;veloppement et l&rsquo;impl&eacute;mentation du <strong>SYREN</strong> (Syst&egrave;me de Renseignement National).</p>
	      </div>
		  <div class="story">
            <h3>Objectifs</h3>
		    <ul>
              <li>S&eacute;curite de &nbsp;l&rsquo;information.</li>
		      <li>Diminution du d&eacute;lai des requ&ecirc;tes</li>
		      <li>Automatisation des processus.</li>
		      <li>Partage de l&rsquo;information</li>
		      <li>Interconnexion des entit&eacute;s</li>
		      <li>Unicit&eacute; de l&rsquo;information</li>
		      <li>Optimiser le syst&egrave;me  d&rsquo;enregistrement.</li>
		      <li>Syst&egrave;me statistique</li>
		      <li>Exploitation Empreinte digitale.</li>
		      <li>Contr&ocirc;le de fraude. </li>
	        </ul>
		    <p>&nbsp;</p>
	      </div>
		  <?php
	}
else
	{

//	AFFICHER CE MESSAGE SI PAS DE RESULTAT
if (($row_recherche['Nom'] == "") && ($_GET['rech'] == "ent"))
	echo "Aucune entite avec '".$_GET['search']."'";
if (($row_recherche['TITRE_PUB'] == "") && ($_GET['rech'] == "publ"))
	echo "Aucune publication avec '".$_GET['search']."'";
?>
          <table id="entiteliste">
            <tr class="head">
              <td>#</td>
              <td>Nom</td>
              <td>Groupe</td>
              <td>adresse</td>              
            </tr>
            <?php do { ?>
              <tr>
              	<td><?php echo $i=$i+1 ; ?></td>
                <td><?php echo $row_recherche['Nom']; ?><?php echo $row_recherche['TITRE_PUB']; ?></td>
                <td><?php echo $row_recherche['Groupe']; ?></td>
                <td><?php echo $row_recherche['adresse']; ?></td>
              </tr>
              <?php } while ($row_recherche = mysql_fetch_assoc($recherche)); ?>
          </table><br />
          <a href="./">Retour accueil</a>
          <!--<table width="200" border="1">
  <tr>
    <td>Nom</td>
    <td>Groupe</td>
    <td>Adresse</td>
  </tr>
  <tr>
    <td><?php echo "le nom d'utilisateur : ".$nom; ?></td>
    <td><?php echo "le nom d'utilisateur : ".$nom; ?></td>
    <td><?php echo "le nom d'utilisateur : ".$nom; ?></td>
  </tr>
</table>-->
<?php
}
?>
  </div>
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
</html>
<?php
mysql_free_result($loggedUser);

mysql_free_result($recherche);
?>
