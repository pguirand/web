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

$colname_DOCUMENT = "-1";
if (isset($_GET['NO_DOC'])) {
  $colname_DOCUMENT = $_GET['NO_DOC'];
}
mysql_select_db($database_connex, $connex);
$query_DOCUMENT = sprintf("SELECT * FROM `document` WHERE `document`.NO_DOC=%s", GetSQLValueString($colname_DOCUMENT, "text"));
$DOCUMENT = mysql_query($query_DOCUMENT, $connex) or die(mysql_error());
$row_DOCUMENT = mysql_fetch_assoc($DOCUMENT);
$totalRows_DOCUMENT = mysql_num_rows($DOCUMENT);
echo $IDIND = $row_DOCUMENT['ID_IND'];

mysql_select_db($database_connex, $connex);
$query_individu = sprintf("SELECT * FROM individu WHERE individu.ID_IND=%s", GetSQLValueString($IDIND, "text"));
$individu = mysql_query($query_individu, $connex) or die(mysql_error());
$row_individu = mysql_fetch_assoc($individu);
$totalRows_individu = mysql_num_rows($individu);





?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
<?php include_once('menuleft.php'); ?>
  </div>
	  </div>
	        
	        
<div id="right">
<?php include_once('menuh.php');?>

  <h2 align="center">PROCESSUS DE MODIFICATION D'UN IDIVIDU</h2>
  <p align="justify">&nbsp;</p>
<form id="form2" name="form2" method="GET" action="<?php echo $rechByNifAction; ?>">
                 
                  <h3 align="center">Recherche de l'individu pour lequel on veut modifier les informations:</h3>
<table width="335" height="152" border="1" id="comliste" align="center">
                    <tr class="head">
                      <td colspan="2"><div align="center">IDENTIFIANT</div></td>
                    </tr>
                    <tr>
                      <td height="87" colspan="2"><label>
                        <div align="center">
                          NUMERO DOCUMENT: 
                          <input name="NO_DOC" type="text" id="NO_DOC" value="<?php echo $_GET['NO_DOC'] ?>" maxlength="22" />
                          </div>
                      </label>                        <p align="center">
                        <label></label></td>
      </tr>
                    <tr>
                      <td width="150"><input type="submit" name="button" id="button" value="Rechercher" /></td>
                      <td width="169"><label>
                        <input type="reset" name="button2" id="button2" value="R&eacute;initialiser" />
                      </label></td>
                    </tr>
                  </table>
  </form>


<?php
#	AFFoui ICHER LE RESULTAT SI LA RECHERCHE EST EFFECTUEE
#	======================================================
if (isset($_GET['NO_DOC']) && ($row_individu['ID_IND'] != ""))
	{
?>
  <div align="center">
   <div class="logoutok"> DOCUMENT EXISTANT</div>
   <BR>
   <div class="fonce">Résultats</div> 
    <table border="1" id="comliste">
      <tr class="head">
        <td>NUMERO DOCUMENT</td>
        <td>TYPE DOCUMENT</td>
        <td>NOM_IND</td>
        <td>PRENOM_IND</td> 
         <td colspan="2">Actions</td>     
      </tr>
      <tr>
        <td><?php echo $row_DOCUMENT['NO_DOC']; ?></td>
        <td><?php echo $row_DOCUMENT['TYPE_DOC']; ?></td>
        <td><?php echo $row_individu['NOM_IND']; ?></td>
        <td><?php echo $row_individu['PRENOM_IND']; ?></td>
        <td><a href="updindtest3.php?ID_IND=<?php echo $row_individu['ID_IND']; ?>" title="Modifier Individu"><img src="images/pencilart.jpeg" width="20" height="20"  border="0" /></a></td>
        <td><a href="viewind.php?ID_IND=<?php echo $row_individu['ID_IND']; ?>" title="Visualiser Individu"><img src="images/eyeart.jpeg" width="20" height="20"  border="0" /></a></td>
      </tr>
</table>
    <br><br>
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
	if ($row_individu['ID_IND'] = "")
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
<?php
mysql_free_result($DOCUMENT);

mysql_free_result($individu);
 /*?><?php
mysql_free_result($rechByNif);

mysql_free_result($loggedUser);
?>
<?php */?>