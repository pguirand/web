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
				case	"NIF"			:	$champs = "NUM_NIF";
											break;
				case	"CIF"			:	$champs = "NUM_CIF";
											break;
				case	"NUM_PASSPORT"	:	$champs = "NUM_PASSPORT";
											break;	
				case	"NO_DOC"		:	$champs = "NO_DOC";
											break;								
			}
		
		/*$maxRows_rechByNif = 4;
		$pageNum_rechByNif = 0;
		if (isset($_GET['pageNum_rechByNif'])) {
		  $pageNum_rechByNif = $_GET['pageNum_rechByNif'];
		}
		$startRow_rechByNif = $pageNum_rechByNif * $maxRows_rechByNif;
		*/
		$colname_rechByNif = "-1";
		if (isset($_GET['NUM_NIF']) && ($champs!="NO_DOC")) {
		  $colname_rechByNif = $_GET['NUM_NIF'];
		  $colname_rechdoc = $_GET['NUM_NIF'];
		}		
			mysql_select_db($database_connex, $connex);
			$query_rechByNif = sprintf("SELECT * FROM individu WHERE ".$champs." = %s ORDER BY ".$champs." ASC", GetSQLValueString($colname_rechByNif, "text"));
			$rechByNif = mysql_query($query_rechByNif, $connex) or die(mysql_error());
			$row_rechByNif = mysql_fetch_assoc($rechByNif);
			$totalRows_rechByNif = mysql_num_rows($rechByNif);		
	}
	else {
			$champs2="NO_DOC";
			mysql_select_db($database_connex, $connex);
			$query_rechByNif = sprintf("SELECT * FROM document WHERE ".$champs2." = %s ORDER BY ".$champs2." ASC", GetSQLValueString($colname_rechByNif, "text"));
			$rechByNif = mysql_query($query_rechByNif, $connex) or die(mysql_error());
			$row_rechByNif = mysql_fetch_assoc($rechByNif);
			$totalRows_rechByNif = mysql_num_rows($rechByNif);
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

<title>Untitled Document</title>

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

  <h2 align="center">PROCESSUS D'ENREGISTREMENT D'UTILISATEUR</h2>
  <p align="justify">&nbsp;</p>
<form id="form2" name="form2" method="GET" action="<?php echo $rechByNifAction; ?>">
                 
                  <h3 align="center">Recherche de l'individu pour lequel le compte sera cree:</h3>
<table width="319" height="156" border="1" id="comliste" align="center">
                    <tr class="head">
                      <td colspan="2"><div align="center">IDENTIFIANT</div></td>
                    </tr>
                    <tr>
                      <td width="351"><label>
                        <input name="NUM_NIF" type="text" id="NUM_NIF" value="<?php echo $_GET['NUM_NIF'] ?>" maxlength="22" />
                      </label></td>
                      <td width="353"><p>
                        <label>
                        <input name="choixId" type="radio" id="RadioGroup1_0" onclick= "document.getElementById('type_doc').style.display='none'" value="NIF" checked="checked"
						  	<?php 
								if($_GET['choixId'] == "NIF") 
						  			echo "checked='checked'";
								else if($_GET['choixId'] == "")
						  			echo "checked='checked'";
							?>  />
                          NIF</label>
                        <br />
                        <label>
                        <input type="radio" name="choixId" value="CIF" onclick= "document.getElementById('type_doc').style.display='none'" <?php if($_GET['choixId'] == "CIF") echo "checked='checked'" ?>  id="RadioGroup1_1" />
                          CIF</label>
                        <br />
                        <label>
                        <input type="radio" name="choixId" value="NUM_PASSPORT" <?php if($_GET['choixId'] == "NUM_PASSPORT") echo "checked='checked'" ?>  id="RadioGroup1_2" onclick= "document.getElementById('type_doc').style.display='none'"/>
                          No Passeport</label>
                        <br />
                        <input type="radio" name="choixId" value="NO_DOC" <?php if($_GET['choixId'] == "NO_DOC") echo "checked='checked'" ?>  id="RadioGroup1_2" onclick= "document.getElementById('type_doc').style.display='none'"/>
                          No Document &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          
                       <!-- <select name="type_doc" id="type_doc" style="display:none">
                          <option>Acte de Naissance</option>
                          <option>Certificat de Bapteme</option>
                          <option>Certificat de Mariage</option>
                            <option>Acte de D&eacute;c&egrave;s</option>
                            <option selected="selected">--Selectione Type Document--</option>
                                                                            </select>-->
                      </td>
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
if (isset($_GET['NUM_NIF']) && ($row_rechByNif['NOM_IND'] != ""))
	{
?>
  <div align="center">
   <div class="logoutok"> NIF VALIDE </div><BR>
   <div class="fonce">Résultats</div> 
    <table border="1" id="comliste">
      <tr class="head">
        <td>G_SANG_IND</td>
        <td>SEXE_IND</td>
        <td>NOM_IND</td>
        <td>PRENOM_IND</td>      
      </tr>
      <tr>
        <td><?php echo $row_rechByNif['G_SANG_IND']; ?></td>
        <td><?php echo $row_rechByNif['SEXE_IND']; ?></td>
        <td><?php echo $row_rechByNif['NOM_IND']; ?></td>
        <td><?php echo $row_rechByNif['PRENOM_IND']; ?></td>
      </tr>
</table>
    <br><br>
        <a href="creation_usr.php?ID_IND=<?php echo $row_rechByNif['ID_IND']."&NOM_IND=".$row_rechByNif['NOM_IND'] ?>">Creer le user</a>  </div>
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