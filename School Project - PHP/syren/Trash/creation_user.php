<?php require_once('Connections/connex.php'); ?>
<?php
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO utilisateur (NOM_UTIL, MOT_PASS, ID_GROUPE, STATUT) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['NOM_UTIL'], "text"),
                       GetSQLValueString($_POST['MOT_PASS'], "text"),
                       GetSQLValueString($_POST['ID_GROUPE'], "text"),
                       GetSQLValueString($_POST['STATUT'], "text"));

  mysql_select_db($database_connex, $connex);
  $Result1 = mysql_query($insertSQL, $connex) or die(mysql_error());

  $insertGoTo = "accueil.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<style type="text/css">
<!--
#Layer1 {
	position:absolute;
	left:112px;
	top:243px;
	width:214px;
	height:31px;
	z-index:1;
}
-->
</style>
</head>
<body>

<div id="Layer1">
  <div align="center">
    <input name="Submit2" type="submit" id="Submit2" value="Valider" />  
    <input name="reset" type="reset" id="reset" value="Annuler" />
  </div>
</div>
<h2 align="center">Formulaire de creation d'utlisateur</h2>
<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  <p>&nbsp;</p>
  <table width="333" border="0">
    <tr>
      <td colspan="2"><div align="center"></div></td>
    </tr>
    <tr>
      <td width="129"><div align="center">Nom utilisateur </div></td>
      <td width="188"><label>
        <input name="NOM_UTIL" type="text" id="NOM_UTIL" maxlength="8" />
      </label></td>
    </tr>
    <tr>
      <td><div align="center">Mot de passe </div></td>
      <td><input name="MOT_PASS" type="password" id="MOT_PASS" maxlength="8" /></td>
    </tr>
    <tr>
      <td><div align="center">Groupe</div></td>
      <td><input name="ID_GROUPE" type="text" id="ID_GROUPE" /></td>
    </tr>
    <tr>
      <td><div align="center">Statut</div></td>
      <td><input name="STATUT" type="text" id="STATUT" maxlength="8" /></td>
    </tr>
  </table>
  <p>
    <label></label>
  </p>
  <p>
    <label></label>
    <label></label>
  </p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <input type="hidden" name="MM_insert" value="form1">
</form>
</body>
</html>
