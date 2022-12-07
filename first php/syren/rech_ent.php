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
		
		$champs; ?><br><?php
		/*$maxRows_rechByNif = 4;
		$pageNum_rechByNif = 0;
		if (isset($_GET['pageNum_rechByNif'])) {
		  $pageNum_rechByNif = $_GET['pageNum_rechByNif'];
		}
		$startRow_rechByNif = $pageNum_rechByNif * $maxRows_rechByNif;
		*/
		$colname_rechByNif = "-1";
		if (isset($_GET['NUM_PATENTE'])) {
		  $colname_rechByNif = $_GET['NUM_PATENTE'];
		}		
			mysql_select_db($database_connex, $connex);
			$query_rechByNif = sprintf("SELECT * FROM entite WHERE ".$champs." = %s ORDER BY ".$champs." ASC", GetSQLValueString($colname_rechByNif, "text"));
			$rechByNif = mysql_query($query_rechByNif, $connex) or die(mysql_error());
			$row_rechByNif = mysql_fetch_assoc($rechByNif);
			$totalRows_rechByNif = mysql_num_rows($rechByNif);		
	}
	

if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}


/*if (isset($_GET['totalRows_rechByNif'])) {
  $totalRows_rechByNif = $_GET['totalRows_rechByNif'];
} else {
  $all_rechByNif = mysql_query($query_rechByNif);
  $totalRows_rechByNif = mysql_num_rows($all_rechByNif);
}
$totalPages_rechByNif = ceil($totalRows_rechByNif/$maxRows_rechByNif)-1;*/
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
	        <div class="screen"><div id="header">
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</div>
		
		      <div id="left">
<?php include_once('menuleft.php');?>
  </div>
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
                        <input name="NUM_PATENTE" type="text" id="NUM_PATENTE" value="<?php echo $_GET['NUM_PATENTE'] ?>" maxlength="30" />
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
   <?php $groupe = $_SESSION['NOM_GROUPE'];?>
    <table border="1" id="comliste">
      <tr class="head">
        <td>NUM PATENTE</td>
        <td>NOM ENTITE</td>
        <td>SECTEUR</td> 
        <?php if (($groupe == "administrateur dgi") || ($groupe == "operateur dgi"))   
		  $col = 2;
		  else $col = 1; ?>
        <td colspan="<?php  echo $col ?>">Actions</td>
      </tr>
      <?php do { ?>
        <tr>
          <td><?php echo $row_rechByNif['NUM_PATENTE']; ?></td>
          <td><?php echo $row_rechByNif['NOM_ENTITE']; ?></td>
          <td><?php echo $row_rechByNif['SECTEUR_ACTIVITE']; ?></td>
           <?php if (($groupe == "administrateur dgi")|| ($groupe == "operateur dgi")){?>
           <td><a href="updentites.php?ID_ENTITE=<?php echo $row_rechByNif['ID_ENTITE']; ?>" title="Modifier Entité"><img src="images/pencilart.jpeg" width="20" height="20"  border="0" /></a></td><?php }?>
                      <td><a href="viewentites.php?ID_ENTITE=<?php echo $row_rechByNif['ID_ENTITE']; ?>" title="Visualiser Entité"><img src="images/eyeart.jpeg" width="20" height="20"  border="0" /></a></td>   	
        </tr>
        <?php } while ($row_rechByNif = mysql_fetch_assoc($rechByNif)); ?>
</table>
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
	echo "Aucun resultat veuille reentrer l'identifiant";
?>
</div>
  <div class="spacer"></div>
		<div id="footer">
			<div class="content">
			<img src="Logo.jpg" width="116" height="49" /> <a href="#">A propos de nous </a> | <a href="#">Plan du Site </a> | <a href="#">R&egrave;gle d'utilisation </a> | <a href="#">Contactez-nous</a> | &copy;2009 SYREN			</div>
		</div>
</div>

</body>
</html>
<?php /*?><?php
mysql_free_result($rechByNif);

mysql_free_result($loggedUser);
?>
<?php */?>