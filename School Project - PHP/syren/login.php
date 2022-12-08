<?php 
#Kilian DESROCHES 
#kilian@desroches.net
require_once('class/MyDb.lib.php');
	require_once('config.inc.php');
	$connexion = new MyDb();
require 'smarty/Smarty.class.php';

$smarty = new Smarty;
	$smarty->compile_check = true;
	$smarty->debugging = false;
	//$smarty->assign("accueil_enabled","actif");
	$smarty->assign("titre_page","Gestion");
	$smarty->assign("explication","La connexion au gestionnaire necessite une authentification .");

	if ($_GET["disable"]==1){
	$smarty->assign("message","Votre utilisateur à été désactivé , contacter un administrateur" );
	}
	
	
	if ($_GET["sess"]=="off"){
	$smarty->assign("message","Votre session à expiré" );
	}
	
	if ($_GET["sess"]=="des"){
	session_start();
	$_SESSION['login'] = "";

	$smarty->assign("message","Vous êtes déconnecté" );
	}
	
	
	$ip = $_SERVER['REMOTE_ADDR'];
	

	
		$requeteip =  'SELECT id,ip  ';
							$requeteip .= 'FROM table_ip  ';
					
							$requeteip .= 'WHERE ';
							$requeteip .= 'ip = "'. $ip.'" '; 
							$valeurip = $connexion->querySingleItemObject($requeteip);
	
		if ($valeurip==FALSE){
		
			if ($_GET["key"]=="1983"){
	
				$req =  'INSERT  ';
				$req .= ' INTO table_ip(';
				$req .= 'ip ';
				$req .= ') VALUES (';
				$req .=  	MyDb::escapequotes($ip) . ' ';
				$req .= ')';
				$valeur = $connexion->execute($req);
				
				$smarty->assign("message","Adresse IP : ".$ip." ajouté <br><a href='login.php'>Retour à la connexion</a>");

			}else{
		
		$smarty->assign("ipcale",2);
		$smarty->assign("message","Votre adresse IP : ".$ip." n'est pas autorisé ");
		}
		
		}else{

	$smarty->assign("ipcale",1);
	
	if ($_POST["valid"]==1){
	

		$requeteident =  'SELECT id,identifiant,passe  ';
							$requeteident .= 'FROM table_login  ';
							$requeteident .= 'WHERE ';
							$requeteident .= 'identifiant = "'. $_POST['login'].'" and passe="'. $_POST['password'].'"'; 
							$valeurident = $connexion->querySingleItemObject($requeteident);
							
	if ($valeurident==FALSE){
	define('LOGIN',"hjhdhsjdksjd");
define('PASSWORD',"kdlskdlskdls");
			 // Definition des constantes et variables

}else{
define('LOGIN',$valeurident->identifiant);
define('PASSWORD',$valeurident->passe);
$errorMessage = '';
}
// Test de l'envoi du formulaire
if(!empty($_POST))
{
// Les identifiants sont transmis ?
if(!empty($_POST['login']) && !empty($_POST['password']))
{
// Sont-ils les mêmes que les constantes ?
if($_POST['login'] !== LOGIN)
{
$errorMessage = "L'identifiant est invalide";
}
elseif($_POST['password'] !== PASSWORD)
{
$errorMessage = "Le mot de passe est invalide";
}
else
{
// On ouvre la session
session_start();
// On enregistre le login en session
$_SESSION['login'] = LOGIN;
// On redirige vers le fichier accueil.php
header('Location: accueil.php');
exit();
}
}
else
{
$errorMessage = 'Veuillez saisir vos identifiants';
}
}
			
	
	$smarty->assign("message",$errorMessage);
	
	
	}
	
	}
	
	

	$smarty->display('login.html');

?>