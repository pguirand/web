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
   
  $LoginRS = mysql_query($LoginRS__query, $connex) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
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
	
		#	TROUVER LE NOM DE L'ENTITE A LAQUELLE APPARTIENT LE USER SI PAS ADMINISTRATEUR SYREN, NI SUPER ADMIN
		#	----------------------------------------------------------------------------------------------------
	//	$userEntite		= $row_loggedUser['ID_ENTITE'];
//		$getEntiteName	= "SELECT * FROM utilisateur,entite WHERE utilisateur.ID_ENTITE = '".$userEntite."' AND utilisateur.ID_ENTITE = entite.ID_ENTITE";
//		if($resultgetEntiteName = mysql_query($getEntiteName))
//			{
//				while($ligneresultgetEntiteName = mysql_fetch_array($resultgetEntiteName))
//				{
//						$entite		= $ligneresultgetEntiteName['NOM_ENTITE'];
//				}
//			}
//
//		switch($entite)
//			{
//				case "dgi"			:	if($groupe == "administrateur dgi") $MM_redirectLoginSuccess = "admdgi.php";
//										if($groupe == "operateur local") $MM_redirectLoginSuccess = "dgiadminilocal.php";
//										break;
//				case "bh"			:	if($groupe == "administrateur local") $MM_redirectLoginSuccess = "bhadminilocal.php";
//										if($groupe == "operateur local") $MM_redirectLoginSuccess = "bhadminilocal.php";
//										break;
//				case "dovliam"		:	if($groupe == "administrateur local") $MM_redirectLoginSuccess = "dovliamadminilocal.php";
//										if($groupe == "operateur local") $MM_redirectLoginSuccess = "dovliamadminilocal.php";
//										break;
//				case "dovliman"		:	if($groupe == "administrateur local") $MM_redirectLoginSuccess = "dovlimanadminilocal.php";
//										if($groupe == "operateur local") $MM_redirectLoginSuccess = "dovlimanadminilocal.php";
//										break;
//				case "me"			:	if($groupe == "administrateur local") $MM_redirectLoginSuccess = "meadminilocal.php";
//										if($groupe == "operateur local") $MM_redirectLoginSuccess = "meadminilocal.php";
//										break;
//			}	


    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;
	$_SESSION['id_entite']	= $row_loggedUser['ID_ENTITE'];
	$_SESSION['NOM_GROUPE'] = $groupe;


	
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
 $query_recherche = sprintf("SELECT * FROM ".$table.", ADRESSE, COORDONNEES WHERE ".$table.".ID_ENTITE = ADRESSE.ID_ENTITE AND ".$table.".ID_ENTITE = COORDONNEES.ID_ENTITE AND ".$champ." = %s", GetSQLValueString($colname_recherche, "text"));
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
#	MODULE DE MOT DE PASSE OUBLIE
#==================================================

if(isset($_POST['lanceCodeOublie']) && $_POST['lanceCodeOublie'] == "oui")
{
 $motPassOublie = $_SERVER['PHP_SELF'];
 $motPass = $_POST['email'];

			$motOublie = "SELECT * FROM individu,utilisateur WHERE EMAIL1 = '".$motPass."'";
				if($resultmotOublie = mysql_query($motOublie))
					{
						while($ligneresultmotOublie = mysql_fetch_array($resultmotOublie))
						{
								$email		= $ligneresultmotOublie['EMAIL1'];
						}
					}
				
				#	EMAIL DE MAIL
				#	-------------
				if ($email != "")
					{
						echo "Mail retrouve";
								$sujet ='Votre mot de passe sur syren.gouv.ht'; //le sujet
								$from ="From: info@syren.gouv.ht \r\n"; //votre email
								$from .="MIME-Version: 1.0\r\n"; //on d?fini le type mime pour le message
								$from .="Content-Type: text/html; charset=us-ascii\r\n"; //ici on d?fini le format , soit html
								$lien = "<a href='passreset.php' />";
								$message = "<html>
		 				<head>
						<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
						<title>Untitled Document</title>
						<style type='text/css'>
						<!--
						.style1 {font-family: Arial, Helvetica, sans-serif}
						.style2 {
							font-family: Georgia, 'Times New Roman', Times, serif;
							font-size: 12px;
						}
						-->
						</style>
						</head>
						
						<body>
						<table width='80%' border='1' cellpadding='5' cellspacing='0' bordercolor='#ECECFF'>
						  <tr>
							<td>
							<br />Cliquez sur ce lien pour changer votre mot de passe : <strong>".$lien."</strong></td>
						  </tr>
						</table>
						</body>
						</html> "; //entrez ici un code html
								if(mail($email,$sujet,$message,$from) && (isset($from) && isset($email) && isset($sujet) && isset($message))) // la fonction mail
									{
										
								$warning = "<div id='createsucces'>Un lien pour changer votre mot de passe a &eacute;t&eacute; envoy&eacute; &agrave; <span class=fonce>".$email."</span>. Veuillez consulter votre <span class=fonce>email</span>. <span class='fonce'><a href='clients.php'>Connexion</a></div>";
										
									//	$warning_email = "<div id='createsucces'>Vous informations ont bien &eacute;t&eacute; enregistr&eacute;es. Et des informations ont &eacute;t&eacute; envoy&eacute; au <span class=fonce>".$to."</span>. Veuillez consulter votre <span class=fonce>email</span> pour l'activation de ce compte. <span class='fonce'><a href='clients.php'>Connexion</a></span></div>";
									//	$warning_email .="<div id='thumbOK'>
//											Message envoy&eacute; &agrave; <strong>".$to."</strong>
/*										</div>";
										 	$_SESSION['email'] = NULL;      
 											unset($_SESSION['email']);
											$_SESSION['idclient'] = NULL;      
 											unset($_SESSION['idclient']);
	*/								}
								else
									{
										echo "le MAIL n'est pas parti pour ".$email." !";
										$warning = "Erreur";
										header(sprintf("Location: %s", $insertGoTo));
									}
						
					}
				else
					{
						echo "Ce mail n'est pas enregistre";
					}

}

//die("stop le code");

#==================================================
#	MODULE DE RECHERCHE
#==================================================

$searchAction = $_SERVER['PHP_SELF'];
$search = $_GET['search'];

//			$requet = "SELECT * FROM entite2 WHERE Nom='".$search."'";
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

<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
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
	<div id="menutop">	</div>
	<div id="left">
        <div id="search">
            <form action="<?php echo $searchAction ?>">
              <label>
              <div align="center"><br />
              Recherche Rapide</div>
              </label>
              <p align="center">
                <input name="search" type="text" value="<?php echo $_GET['search'] ?>" size="28" />
              </p>
              <div align="center">
                <table width="167">
                  <tr>
                    <td width="60"><label>
                      <input name="rech" type="radio" value="ent"<?php if($_GET['rech'] == "") echo " checked='checked'" ?> <?php if ($_GET['rech'] == "ent") echo " checked='checked'" ?> />
                      <span class="style10">Entites</span></label></td>
                    <td width="95"><label><input type="radio" name="rech" value="publ" <?php if ($_GET['rech'] == "publ") echo " checked='checked'" ?> />
                      <span class="style10">Publications</span></label></td>
                  </tr>
                  </table>
              </div>
              <p align="center">
                <input name="goButton" type="submit" value="Lancer la recherche" />
              </p>
            </form>
        </div>
		  <div id="section">

              <form id="form1" name="form1" method="POST" action="<?php echo $loginFormAction; ?>">				<div align="center" class="section">
                <table border="0" align="center" class="content">
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
                </div>
                </label>
                <p><?php echo $warning; ?></p>
                <p align="center"><a href="motpassoublie.php">Mot de passe oubli&eacute;?</a></p>
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
			<ul id="MenuBar2" class="MenuBarHorizontal">
				<li><a href="./">Accueil</a></li>
		      <li><a href="actugen.php">Actualites</a></li>
			  <li><a href="#">Culture</a></li>
			  <li><a href="forumint.php">Forums</a></li>
</ul>
</div>

<?php
if($_GET['search'] == "")
	{
?>
<h3>&nbsp;</h3>

      <div class="story">
	  <?php echo $warning; ?>
      	<form id="form2" name="form2" method="post" action="<?php echo $motPassOublie; ?>">
      		<table width="200" border="1">
      			<tr>
      				<td colspan="2">Mot de passe oublie</td>
      				</tr>
      			<tr>
      				<td>email</td>
      				<td><label>
      					<input type="text" name="email" id="email" />
      					</label></td>
      				</tr>
      			<tr>
      				<td>
						<input type="submit" name="valider" id="valider" value="Submit" />
						<input type="hidden" name="lanceCodeOublie" value="oui" />
					</td>
      				<td>&nbsp;</td>
      				</tr>
      			</table>
      		</form>
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
?><br />
<?php
	}
//	NE PAS AFFICHER LE TABLEAU DES RESULTATS SI LE RESULTAT DE LA RECHERCHE EST VIDE	-	fin
?>
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
var MenuBar2 = new Spry.Widget.MenuBar("MenuBar2", {imgDown:"/syren/SpryAssets/SpryMenuBarDownHover.gif", imgRight:"/syren/SpryAssets/SpryMenuBarRightHover.gif"});
//-->
</script>
</body>
</html>
<?php
mysql_free_result($loggedUser);

mysql_free_result($recherche);
?>sult($loggedUser);

mysql_free_result($recherche);
?>
rche);
?>
