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
$query_loggedUser = "SELECT * FROM utilisateur WHERE NOM_UTIL = '".$colname_loggedUser."'";
$loggedUser = mysql_query($query_loggedUser, $connex) or die(mysql_error());
$row_loggedUser = mysql_fetch_assoc($loggedUser);
$totalRows_loggedUser = mysql_num_rows($loggedUser);

$maxRows_recherche = 20;
$pageNum_recherche = 0;
if (isset($_GET['pageNum_recherche'])) {
  $pageNum_recherche = $_GET['pageNum_recherche'];
}
$startRow_recherche = $pageNum_recherche * $maxRows_recherche;

$colname_recherche = "-1";
if (isset($_GET['search'])) {
  $colname_recherche = $_GET['search'];
}
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
  $password=md5($_POST['MOT_PASS']);
  $MM_fldUserAuthorization = "";

  $MM_redirectLoginFailed = "index.php?result=no";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_connex, $connex);
  
  $LoginRS__query=sprintf("SELECT * FROM utilisateur WHERE NOM_UTIL=%s AND MOT_PASS='$password'",
  GetSQLValueString($loginUsername, "text")); 
  
  $insertSQL = sprintf("INSERT INTO session (id_util) SELECT id_util FROM utilisateur WHERE NOM_UTIL='$loginUsername'");
   
   $selectSES=("select max(id_session) as id from session where id_util = (SELECT id_util FROM utilisateur WHERE NOM_UTIL='$loginUsername')");
   $selses = mysql_query($selectSES, $connex) or die(mysql_error());
   $fecth = mysql_fetch_assoc($selses);
   $fetch1 = $fetch['id'];
   
   $total= mysql_num_rows($selses);
  $LoginRS = mysql_query($LoginRS__query, $connex) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  $LoginRS2 = mysql_query($insertSQL, $connex) or die(mysql_error());
 

  
  if ($loginFoundUser) {
     $loginStrGroup = "";


#	================================================
#	REDIRECTION SELON LE GROUPE DE L'UTILISATEUR
#	================================================
	
	#	Trouver le groupe de l'internaute logge
		$userGroup	=	$row_loggedUser['ID_GROUPE'];
		$getGroup = "SELECT * FROM utilisateur,groupe WHERE utilisateur.ID_GROUPE = '".$userGroup."' AND utilisateur.ID_GROUPE = groupe.ID_GROUPE";
//die();		
		if($resultgetGroup = mysql_query($getGroup))
			{
				while($ligneresultgetGroup = mysql_fetch_array($resultgetGroup))
				{
						$groupe		= $ligneresultgetGroup['NOM_GROUPE'];
				}
			}
switch($groupe)
	{
		case "administrateur syren"			:	$MM_redirectLoginSuccess = "admininterf5.php";
												break;
		case "super administrateur"			:	$MM_redirectLoginSuccess = "Superadmin.php";
												break;								
		case "administrateur dgi"			:	$MM_redirectLoginSuccess = "admdgi.php";
												break;	
		case "operateur dgi"				:	$MM_redirectLoginSuccess = "admdgi.php";
												break;											
		case "administrateur ime"			:	$MM_redirectLoginSuccess = "admime.php";
												break;													
		case "administrateur archives"		:	$MM_redirectLoginSuccess = "admanh.php";
												break;
		case "administrateur oni"			:	$MM_redirectLoginSuccess = "admoni.php";
												break;
       case "administrateur justice"		:	$MM_redirectLoginSuccess = "admjust.php";
												break;	
		case "ADMINISTRATEUR TRAVAIL"		:	$MM_redirectLoginSuccess = "admmast.php";
												break;													
		case "administrateur economie"		:	$MM_redirectLoginSuccess = "admmef.php";
												break;
		case "administrateur interieur"		:	$MM_redirectLoginSuccess = "admint.php";
												break;		 
																			
	}
	
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;
	$_SESSION['id_entite']	= $row_loggedUser['ID_ENTITE'];
	$_SESSION['NOM_GROUPE'] = $groupe;
	$_SESSION['ids'] = $fetch1;


	
//  $MM_redirectLoginSuccess = "/syren/admininterf5.php";
    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
include("includes/logoutCode.php");
?>

<?php

if (isset($_GET['rech']))
{
	$flagRech = "yes";
	if ($_GET['rech'] == "ent")
	{
		$table = "entite";
		$champ = "NOM_ENTITE";
	}
	else
		{
			$table = "publications";
			$champ = "TITRE_PUB";
		}
mysql_select_db($database_connex, $connex);
 $query_recherche = sprintf("SELECT * FROM ".$table.", ADRESSE, COORDONNEES WHERE ".$table.".ID_ENTITE = ADRESSE.ID_ENTITE AND ".$table.".ID_ENTITE = COORDONNEES.ID_ENTITE AND ".$champ." LIKE %s", GetSQLValueString($colname_recherche, "text"));
$query_limit_recherche = sprintf("%s LIMIT %d, %d", $query_recherche, $startRow_recherche, $maxRows_recherche);
$recherche = mysql_query($query_limit_recherche, $connex) or die(mysql_error());
$row_recherche = mysql_fetch_assoc($recherche);

if (isset($_GET['totalRows_recherche'])) {
  $totalRows_recherche = $_GET['totalRows_recherche'];
} else {
  $all_recherche = mysql_query($query_recherche);
  $totalRows_recherche = mysql_num_rows($all_recherche);
}
$totalPages_recherche = ceil($totalRows_recherche/$maxRows_recherche)-1;

}




#==================================================
#	MODULE DE RECHERCHE
#==================================================

$searchAction = $_SERVER['PHP_SELF'];
$search = $_GET['search'];

			$requet = "SELECT * FROM entite WHERE Nom='".$search."'";
				if($result = mysql_query($requet))
					{
						while($ligne = mysql_fetch_array($result))
						{
								$nom		= $ligne['Nom'];
								$groupe		= $ligne['SECTEUR_ACTIVITE'];
								$adresse	= $ligne['STATUT'];
						}
					}				
				?> 
        


<?php
if (($_GET['act'] == "logout") && ($_SESSION['MM_Username'] == ""))
	$info ="<div class='logoutok'>Vous etes deconecte !</div>";
	
if ($_GET['act'] == "denied")
	$info ="<div class='logindenied'>Vous devez vous identifier pour acceder a cette page !</div>";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<script type="text/javascript">
function toggle(divToShow) {
if (document.getElementById) {
if (divToShow == "entit") {
document.getElementById('entites').style.display = "inline";
document.getElementById('publications').style.display = "none";
} else 
	{
	if (divToShow == "publi")
	{
	document.getElementById('publications').style.display = "inline";
	document.getElementById('entites').style.display = "none";
	}
	}
}
}

</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
<title>SYREN | Système de Renseignement National</title>
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
<?php
if (isset($_GET['result']))
	{
		 $r = $_GET['result'];
	

if ($r == "no")
	{
	  $warning = "<div class='warning'>Nom d'utilisateur ou mot de passe incorrect</div>";
	}}
?>

<script src="SpryAssets/SpryMenuBar.js" type="text/javascript">
</script>
<script type="text/javascript">
function clearText(field){

    if (field.defaultValue == field.value) field.value = '';
    else if (field.value == '') field.value = field.defaultValue;

}

</script>
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	background-image: url();
}
body,td,th {
	font-size: xx-small;
}
-->
</style></head>

<body>

<div class="screen">
	<div id="header">
			
		  <p>&nbsp;</p>
		  <p>&nbsp;</p>
	</div>
	<div id="left">
<?php include_once('menuleft.php')?>  </div>
	
    <div id="right">

		<?php
		  	

		  ?>
	<?php
		#	SI LE USER EST LOGGE, AFFICHER LE LOGIN BAR
		#	============================================
		
		if(isset($_SESSION['MM_Username']))
		{
	?>
	<?php
		}
	?>
	  <?php
			echo $info;
		?>
    <div id="menutop">
		  <?php include_once('menuh.php');?></div>

<?php
if($_GET['search'] == "")
	{
?>
<h3>&nbsp;</h3>
      <p align="justify">&nbsp;</p>
      <p align="justify"><img src="log.jpg" width="252" height="126" align="right" /></p>
      <p align="justify">Avec  le d&eacute;veloppement des Nouvelles Technologies de l&rsquo;Information et de la> Communication (NTIC), l&rsquo;informatique se r&eacute;v&egrave;le un outil important et  indispensable dans la gestion des donn&eacute;es et le traitement des informations,  dans les institutions ou entreprises. Cependant, cet outil reste encore  inexploit&eacute; par bon nombre d&rsquo;institutions (ou entreprises) en Ha&iuml;ti, malgr&eacute; les  multiples efforts d&eacute;ploy&eacute;s dans le domaine pour rendre plus efficaces les  travaux de ces derniers; d&rsquo;autant plus, certains ne poss&egrave;dent pas </p>
      <p align="justify">un syst&egrave;me  informatique. En analysant minutieusement la structure du traitement de  l&rsquo;information du syst&egrave;me de renseignement National Ha&iuml;tien, nous avons constat&eacute;  qu&rsquo;elle est confront&eacute;e &agrave; de nombreux probl&egrave;mes. Notre travail, relativement &agrave;  sa mission, coiffe un &eacute;ventail d&rsquo;Institutions, soit cinq (5) grandes entit&eacute;s,  et plusieurs sous-entit&eacute;s, avec des droits et interactions entre ces derni&egrave;res.&nbsp; Donc, la gestion d&rsquo;un tel syst&egrave;me exige une  coh&eacute;rence relationnelle entre ces diff&eacute;rents entit&eacute;s et sous-entit&eacute;s. Cependant  il y a des failles qui portent les institutions &agrave; faire face &agrave; des contraintes  &agrave; plusieurs niveaux. Ces inconv&eacute;nients ou imperfections constituent un obstacle  de grande envergure dans la marche ad&eacute;quate et la gestion d&rsquo;un syst&egrave;me de  renseignement national. </p>
	      <div class="story">
	        <p align="justify">Ces  questions sont essentielles &agrave; l&rsquo;analyse des solutions. Pour ce faire, nous  sugg&eacute;rons le d&eacute;veloppement et l&rsquo;impl&eacute;mentation du SYREN (Syst&egrave;me de Renseignement National).</p>
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
//	AFFICHER CE MESSAGE SI L'INTERNAUTE N'A RIEN MIS DANS LA RECHERCHE
if($_GET['search'] == "")
	$warning = "<div class='warning'>Vous n'avez rien mis dans la recherche</div><br />
		<a href='".$_SERVER['PHP_SELF']."?search=".$_GET['search']."&rech=publ'>Essayer avec '".$_GET['search']."' dans les publications</a><br /><br />";

//	AFFICHER CE MESSAGE SI PAS DE RESULTAT
if (($row_recherche['NOM_ENTITE'] == "") && ($_GET['rech'] == "ent"))
	$warning = "<div class='warning'>Aucune entite avec '".$_GET['search']."'</div><br />";
//	echo "Aucune entite avec '".$_GET['search']."'";

if (($row_recherche['TITRE_PUB'] == "") && ($_GET['rech'] == "publ"))
	$warning = "<div class='warning'>Aucune publication avec '".$_GET['search']."'</div><br />
	<a href='".$_SERVER['PHP_SELF']."?search=".$_GET['search']."&rech=ent'>Essayer avec '".$_GET['search']."' dans les entit&eacute;s</a><br /><br />";
//	echo "Aucune publication avec '".$_GET['search']."'";
	echo $warning;
	
//	NE PAS AFFICHER LE TABLEAU DES RESULTATS SI LE RESULTAT DE LA RECHERCHE EST VIDE	-	start
if (($row_recherche['NOM_ENTITE'] != ""))
	{
?>
          <table width="107%" id="entiteliste">
            <tr class="head">
              <td width="4%">#</td>
              <td width="20%">Nom</td>
              <td width="37%">Rue</td>
              <td width="20%">eMail</td>
              <td width="19%">No Téléphone</td>
            </tr>
            <?php do { ?>
              <tr>
              	<td><?php echo $i=$i+1 ; ?></td>
   <td><a href="viewentites2.php?ID_ENTITE=<?php echo $row_recherche['ID_ENTITE']; ?>" title="Détails"><?php echo $row_recherche['NOM_ENTITE']; ?></a></td>
                <td><?php echo $row_recherche['NOM_RUE']; ?></td>
                <td><?php echo $row_recherche['EMAIL1']; ?></td>
                <td><?php echo $row_recherche['NUM_TEL1']; ?> <?php echo $row_recherche['NUM_TEL2']; ?></td>
              </tr>
              <?php } while ($row_recherche = mysql_fetch_assoc($recherche)); ?>
        </table><br />
<?php
	}
//	NE PAS AFFICHER LE TABLEAU DES RESULTATS SI LE RESULTAT DE LA RECHERCHE EST VIDE	-	fin
?>
          <a href="./">Retour accueil</a>

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
</body>
</html>
<?php
mysql_free_result($loggedUser);

?>