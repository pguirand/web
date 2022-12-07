<script type='text/javascript'>
function checkData()
    {
     var myTest  = chgdept.arron.options[chgdept.arron.options.selectedIndex].value;
     alert(myTest);
     }
</script>
<?php
/* Variables de connexion : ajustez ces paramètres selon votre propre environnement */
$serveur = "localhost";
$admin   = "root";
$mdp     = "";
$base    = "syren";
/* On récupère si elle existe la valeur de la région envoyée par le formulaire */
$idr = isset($_POST['dept'])?$_POST['dept']:null;
$ida = isset($_REQUEST['arron'])?$_REQUEST['arron']:null;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" xml:lang="fr" />
<title>Sélectionner un département selon la région choisie</title>
<meta name="description" content="Listes déroulantes dynamiques inter-dépendantes" />
<meta name="keywords" content="" />
<meta name="author" content="Cyrano" />
<meta name="generator" content="Zend Studio Environnement et WebExpert 5" />
<meta http-equiv="imagetoolbar" content="no" />
<meta http-equiv="Pragma" content="no-cache" />
</head>
<body style="font-family: verdana, helvetica, sans-serif; font-size: 85%">
<?php
if(isset($_POST['ok']) && isset($_POST['dept']) && $_POST['dept'] != "")
{
    $dept = $_POST['dept'];
    $arron = $_POST['arron'];
	$com = $_POST['com'];
?>
<p>Vous avez sélectionné l'arrondissement <?php echo ($arron); ?> se trouvant dans le departement <?php echo($dept); ?></p>
<?php
}
?>
<!--//niveau 1-->
<h3>Trouver un département</h3>
<?php
/* On établit la connexion à MySQL avec mysql_pconnect() plutôt qu'avec mysql_connect()
*  car on aura besoin de la connexion un peu plus loin dans le script */
$connexion = mysql_pconnect($serveur, $admin, $mdp);
if($connexion != false)
{
   $choixbase = mysql_select_db($base, $connexion);
    $sql1 = "SELECT `id_dept`, `nom_dept` ".
    " FROM `departement`".
    " ORDER BY `id_dept`";
    $rech_dept = mysql_query($sql1);
    $code_dept = array();
    $dept = array();
    /* On active un compteur pour les département */
    $nb_dept = 0;
    if($rech_dept != false)
    {
        while($ligne = mysql_fetch_assoc($rech_dept))
        {
            array_push($code_dept, $ligne['id_dept']);
            array_push($dept, $ligne['nom_dept']);
            /* On incrémente de compteur */
            $nb_dept++;
        }
    }
    ?>
<!--fin niveau 1-->
<!--creation forme-->
<form action="<?php echo($_SERVER['PHP_SELF']); ?>" method="post" id="chgdept">
<fieldset style="border: 3px double #333399">
<legend>Sélectionnez une région</legend>
<!--fin creation forme-->
<!--creation liste 1-->
<select name="dept" id="dept" onChange="document.forms['chgdept'].submit();">
  <option value="-1" selected="selected">- - - Choisissez un departement - - -</option>
    <?php
    for($i = 0; $i < $nb_dept; $i++)
    {
?>
  <option value="<?php echo($code_dept[$i]); ?>"<?php echo((isset($idr) && $idr == $code_dept[$i])?" selected=\"selected\"":null); ?>><?php echo($dept[$i]); ?></option>
<?php
    }
    ?>
</select>
<!--fin creation liste 1-->
<!--implementation arron-->
<?php
    mysql_free_result($rech_dept);
    /* On commence par vérifier si on a envoyé un numéro de région et le cas échéant s'il est différent de -1 */
    if(isset($idr) && $idr != -1)
    {/* Cération de la requête pour avoir les départements de cette région */
        $sql2 = "SELECT `id_arron`, `nom_arron` ".
        " FROM `arrondissement`".
        " WHERE `id_dept` = ". $idr ."".
        " ORDER BY `id_arron`;";
		
        if($connexion != false)
        {
            $rech_arron = mysql_query($sql2, $connexion);
            /* Un petit compteur pour les arrondissements */
            $nd = 0;
            /* On crée deux tableaux pour les numéros et les noms des arrodissements */
            $code_arron = array();
            $nom_arron = array();
            /* On va mettre les numéros et noms des arrodissements dans les deux tableaux */
            while($ligne_arron = mysql_fetch_assoc($rech_arron))
            {
                array_push($code_arron, $ligne_arron['id_arron']);
                array_push($nom_arron, $ligne_arron['nom_arron']);
                $nd++;
            }
		
            /* Maintenant on peut construire la liste déroulante */
?>	
<select name="arron" id="arron" onChange="document.forms['chgdept'].submit(this);">
<option value="-1" selected="selected">- - - Choisissez un arrondissement - - -</option>
            <?php  
            for($d = 0; $d<$nd; $d++)
            {
                ?>
  <option value="<?php echo($code_arron[$d]); ?>"<?php echo((isset($arron) && $arron == $code_dept[$d])?" selected=\"selected\"":null); ?>><?php echo($nom_arron[$d]); ?></option>
                <?php
            }
?>
</select>
<!--implementation commune-->
<?php
mysql_free_result($rech_arron);

/* On commence par vérifier si on a envoyé un numéro de région et le cas échéant s'il est différent de -1 */
    if(isset($ida) && $ida != -1)
    {
/*	   Cération de la requête pour avoir les départements de cette région */
        $sql3 = "SELECT `id_com`, `nom_com` ".
        " FROM `commune`".
        " WHERE `id_arron` = ". $ida ."".
        " ORDER BY `id_com`;";
		
        if($connexion != false)
        {
		  $rech_com = mysql_query($sql3, $connexion);
            /* Un petit compteur pour les arrondissements */
            $nc = 0;
            /* On crée deux tableaux pour les numéros et les noms des arrodissements */
            $code_com = array();
            $nom_com = array();
            /* On va mettre les numéros et noms des arrodissements dans les deux tableaux */
            while($ligne_com = mysql_fetch_assoc($rech_com))
			{
			  array_push($code_com, $ligne_com['id_com']);
              array_push($nom_com, $ligne_com['nom_com']);
              $nc++;
			}
			/* Maintenant on peut construire la liste déroulante */
		}

?>
<select name="com" id="com"> 
<?php  
            for($c = 0; $c<$nc; $c++)
            {
?>
<option value="<?php echo($code_com[$c]); ?>"<?php echo((isset($com) && $com == $code_com[$c])?" selected=\"selected\"":null); ?>><?php echo($nom_com[$c]); ?></option>
<?php
}
?>
</select>
<?php
}
}
?>
<!--fin implementation commune-->
<input type="submit" name="ok" id="ok" value="Envoyer" />
</fieldset>
</form>
<?php
/* Terminé, on ferme la connexion */
    mysql_close($connexion);
}
?>
<!--fin implementation arron-->
<?php
}
?>
</body>
</html>