<?php
#Kilian DESROCHES 
#kilian@desroches.net

session_start();

require_once('class/MyDb.lib.php');
require_once('config.inc.php');
	$connex = new MyDb();
require 'smarty/Smarty.class.php';

$smarty = new Smarty;
	$smarty->compile_check = true;
	$smarty->debugging = false;
	$smarty->assign("accueil","Accueil");
	$smarty->assign("gestion","Configuration");
	
	$smarty->assign("deco","Déconnexion : ".$_SESSION['login']."");
	$smarty->assign("liendeco","login.php?sess=des");

	
	
		$requete_catc = 'SELECT ';
$requete_catc .= 'id, ';
$requete_catc .= 'identifiant, ';
	$requete_catc .= 'passe, ';
	$requete_catc .= 'email, '; 
	$requete_catc .= 'droit,status FROM table_login WHERE identifiant = "'.$_SESSION['login'].'"';
	$listecatd = $connex->querySingleItemObject($requete_catc);
	

	
	$ip = $_SERVER['REMOTE_ADDR'];
	
		$requeteip =  'SELECT id,ip  ';
							$requeteip .= 'FROM table_ip  ';
					
							$requeteip .= 'WHERE ';
							$requeteip .= 'ip = "'. $ip.'" '; 
							$valeurip = $connex->querySingleItemObject($requeteip);
	
		if ($valeurip==FALSE){

		header('Location: login.php');
		exit;
	}else{
	
	
// On teste si la variable de session existe et contient une valeur
if(empty($_SESSION['login']))
{
// Si inexistante ou nulle, on redirige vers le formulaire de login
header('Location: login.php?sess=off');
exit();
}

	if ($listecatd->status == 0 ){

	$_SESSION['login'] = "";
	unset($_SESSION['login']);
	
	header("Location: login.php?disable=1");
	exit();
	
	}

}
?>