<?php
/* Variables de connexion : ajustez ces param�tres selon votre propre environnement */
$serveur = "localhost";
$admin   = "root";
$mdp     = "";
$base    = "syren";
/* On r�cup�re si elle existe la valeur de la r�gion envoy�e par le formulaire */
$idr = isset($_POST['dept'])?$_POST['dept']:null;
$ida = isset($_POST['arron'])?$_POST['arron']:null;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" xml:lang="fr" />
<title>S�lectionner un d�partement selon la r�gion choisie</title>
<meta name="description" content="Listes d�roulantes dynamiques inter-d�pendantes" />
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
<p>Vous avez s�lectionn� l'arrondissement <?php echo ($arron); ?> se trouvant dans le departement <?php echo($dept); ?></p>
<?php
}
?>
<h3>Trouver un d�partement</h3>
<?php
/* On �tablit la connexion � MySQL avec mysql_pconnect() plut�t qu'avec mysql_connect()
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
    /* On active un compteur pour les d�partement */
    $nb_dept = 0;
    if($rech_dept != false)
    {
        while($ligne = mysql_fetch_assoc($rech_dept))
        {
            array_push($code_dept, $ligne['id_dept']);
            array_push($dept, $ligne['nom_dept']);
            /* On incr�mente de compteur */
            $nb_dept++;
        }
    }
    ?>
<form action="<?php echo($_SERVER['PHP_SELF']); ?>" method="post" id="chgdept">
<fieldset style="border: 3px double #333399">
<legend>S�lectionnez une r�gion</legend>
<select name="dept" id="dept" onchange="document.forms['chgdept'].submit();">
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
    <?php
    mysql_free_result($rech_dept);
    /* On commence par v�rifier si on a envoy� un num�ro de r�gion et le cas �ch�ant s'il est diff�rent de -1 */
    if(isset($idr) && $idr != -1)
    {
        /* C�ration de la requ�te pour avoir les d�partements de cette r�gion */
        $sql2 = "SELECT `id_arron`, `nom_arron` ".
        " FROM `arrondissement`".
        " WHERE `id_dept` = ". $idr ."".
        " ORDER BY `id_arron`;";
		
        if($connexion != false)
        {
            $rech_arron = mysql_query($sql2, $connexion);
            /* Un petit compteur pour les arrondissements */
            $nd = 0;
            /* On cr�e deux tableaux pour les num�ros et les noms des arrodissements */
            $code_arron = array();
            $nom_arron = array();
            /* On va mettre les num�ros et noms des arrodissements dans les deux tableaux */
            while($ligne_arron = mysql_fetch_assoc($rech_arron))
            {
                array_push($code_arron, $ligne_arron['id_arron']);
                array_push($nom_arron, $ligne_arron['nom_arron']);
                $nd++;
            }
            /* Maintenant on peut construire la liste d�roulante */
            ?>
<select name="arron" id="arron">
            <?php  
            for($d = 0; $d<$nd; $d++)
            {
                ?>
  <option value="<?php echo($code_arron[$d]); ?>"<?php echo((isset($arron) && $arron == $code_dept[$d])?" selected=\"selected\"":null); ?>><?php echo($nom_arron[$d]); ?></option>
                <?php
            }
?>
</select>

<?php
        }
        /* Un petit coup de balai */
        mysql_free_result($rech_arron);
    }
?> 
 <input type="submit" name="ok" id="ok" value="Envoyer" />
</fieldset>
</form>
<?php
    /* Termin�, on ferme la connexion */
    mysql_close($connexion);
}
else
{
    /* Si on arrive l�, c'est pas bon signe, il faut v�rifier les 
    * param�tres de connexion, mot de passe, serveur pas d�marr� etc... */
?>
<p>Un incident s'est produit lors de la connexion � la base de donn�es, veuiillez essayer � nouveau ult�rieurement.</p>
<?php
}
?>
</body>
</html>