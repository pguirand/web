<?php


function __autoload($nom_de_la_classe)
{
	if(is_file($GLOBALS['RACINE'] . '/spidernet/class/' . $nom_de_la_classe . '.lib.php'))
	{
		require_once($GLOBALS['RACINE'] . '/spidernet/class/' . $nom_de_la_classe . '.lib.php');
	}

}
require_once('./config.inc.php');


?>
