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


#	LANCEMENT DE LA RECHERCHE
#	================================

#	LANCEMENT DU CODE :
$rechByNifAction = $_SERVER['PHP_SELF'];

#	VERIFICATION DU TYPE DE LA RECHERCHE
if (isset($_GET['choixId']))
	{
	$rechFlag = "oui";
		switch($_GET['choixId'])
			{
				case	"PATENTE"			:$champs = "NUM_PATENTE";
											break;
				case	"NOM"				:$champs = "NOM_ENTITE";
											break;
				case	"SECTEUR"			:$champs = "SECTEUR_ACTIVITE";
											break;		
			}
		
		echo $champs; ?><br>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>

<title>SYREN | Syst&egrave;me de Renseignement National</title>

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


<style type="text/css">
<!--
#apDiv1 {
	position:absolute;
	left:728px;
	top:551px;
	width:138px;
	height:30px;
	z-index:1;
}
-->
</style>
</head>

<body>
	        <div id="left"><?php include_once('menuleft.php');?>
        </div>
		      
	        <div id="right">
<?php include_once('menuh.php');?>

  <h2 align="center">RECHERCHE SIMPLE ENTITE</h2>
  <p align="justify">&nbsp;</p>
<form id="form2" name="form2" method="GET" action="<?php echo $rechByNifAction; ?>">
                 
                  <h3 align="center">Recherche de l'individu pour lequel le compte sera cree:</h3>
<table width="319" height="156" border="1" id="comliste" align="center">
                    <tr class="head">
                      <td colspan="2"><div align="center">IDENTIFIANT</div></td>
                    </tr>
                    <tr>
                      <td width="154"><label>
                        <input name="NUM_PATENTE" type="text" id="NUM_PATENTE" value="<?php echo $_GET['NUM_PATENTE'] ?>" maxlength="50" />
                      </label></td>
                      <td width="160"><p>
                        <label>
        <input name="choixId" type="radio" id="RadioGroup1_0" value="PATENTE" 
						  	<?php 
								if($_GET['choixId'] == "NUM_PATENTE") 
						  			echo "checked='checked'";
								else if($_GET['choixId'] == "")
						  			echo "checked='checked'";
							?>  />
                          No De patente</label>
                        <br />
                        <label>
                      <input type="radio" name="choixId" value="NOM" <?php if($_GET['choixId'] == "NOM_ENTITE") echo "checked='checked'" ?>  id="RadioGroup1_1" />
                          Nom d'entite</label><br />
                        <label>
                            <input type="radio" name="choixId" value="SECTEUR" <?php if($_GET['choixId'] == "SECTEUR_ACTIVITE") echo "checked='checked'" ?>  id="RadioGroup1_2" />
                    Secteur d'activites</label>
                        <br />
                      </p></td>
                    </tr>
                    <tr>
                      <td><input type="submit" name="button" id="button" value="Rechercher" /></td>
                      <td><label>
                        <input type="reset" name="button2" id="button2" value="Reset" />
                      </label></td>
                    </tr>
    </table>
  </form>


<?php
#	AFFoui ICHER LE RESULTAT SI LA RECHERCHE EST EFFECTUEE
#	======================================================
if (isset($_GET['NUM_PATENTE']) && ($row_rechByNif['ID_ENTITE'] != ""))
	{
?>
  <div align="center">
   <div class="logoutok"> ENTITE VALIDE </div><BR>
   <div class="fonce">Résultats</div> 
    <table border="1" id="comliste">
      <tr class="head">
        <td>NUM PATENTE</td>
        <td>NOM ENTITE</td>
        <td>SECTEUR</td>   
        <td colspan="2">Actions</td>
      </tr>
      <?php do { ?>
        <tr>
          <td><?php echo $row_rechByNif['NUM_PATENTE']; ?></td>
          <td><?php echo $row_rechByNif['NOM_ENTITE']; ?></td>
          <td><?php echo $row_rechByNif['SECTEUR_ACTIVITE']; ?></td>
           <td><a href="updentites.php?ID_ENTITE=<?php echo $row_rechByNif['ID_ENTITE']; ?>" title="Modifier Entité"><img src="images/pencilart.jpeg" width="20" height="20"  border="0" /></a></td>
                      <td><a href="viewentites.php?ID_ENTITE=<?php echo $row_rechByNif['ID_ENTITE']; ?>" title="Visualiser Entité"><img src="images/eyeart.jpeg" width="20" height="20"  border="0" /></a></td>   	
        </tr>
        <?php } while ($row_recherche = mysql_fetch_assoc($rechByNif)); ?>
</table>
    <!--<br><br>
          <a href="creation_usr.php?ID_IND=<?php echo $row_rechByNif['ID_IND']."&NOM_IND=".$row_rechByNif['NOM_IND'] ?>">Creer le user</a> -->       
  </div>
  <?php /*?><?php
$stringnif = $_GET['NUM_NIF'];
echo $stringnif;
$nbchar = strlen($stringnif);?><br>
<?php
if ($nbchar = 10) 
	echo "NIF Invalide";
else
	echo "NIF Valide";
echo $nbchar; 
?><?php */?>
<?php
	}
	else if ($rechFlag == "oui")
	echo "Aucun resultat veuillez reentrer l'identifiant";
?>
</div>
  <div class="spacer"></div>
		<div id="footer">
			<div class="content">
			<img src="Logo.jpg" width="116" height="49" /> <a href="#">A propos de nous </a> | <a href="#">Plan du Site </a> | <a href="#">R&egrave;gle d'utilisation </a> | <a href="#">Contactez-nous</a> | &copy;2009 SYREN			</div>
		</div>
</body>
</html>
<?php
mysql_free_result($rechByNif);
?>