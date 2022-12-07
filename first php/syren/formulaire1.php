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
  $insertSQL = sprintf("INSERT INTO naissance (No_cert, No_registre, date_naiss, lieu_nais, nom, prenom, cin_oec, nif_oec, cin_dg, nif_dg, cin_pere, nif_pere, cin_mere, nif_mere, np_tem1, np_tem2, adr_bureau, tel_bureau) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['No_cert'], "text"),
                       GetSQLValueString($_POST['No_registre'], "text"),
                       GetSQLValueString($_POST['date_nais'], "date"),
                       GetSQLValueString($_POST['lieu_nais'], "text"),
                       GetSQLValueString($_POST['nom'], "text"),
                       GetSQLValueString($_POST['prenom'], "text"),
                       GetSQLValueString($_POST['cin_oec'], "text"),
                       GetSQLValueString($_POST['nif_oec'], "text"),
                       GetSQLValueString($_POST['cin_dg'], "text"),
                       GetSQLValueString($_POST['nif_dg'], "text"),
                       GetSQLValueString($_POST['cin_pere'], "text"),
                       GetSQLValueString($_POST['nif_pere'], "text"),
                       GetSQLValueString($_POST['cin_mere'], "text"),
                       GetSQLValueString($_POST['nif_mere'], "text"),
                       GetSQLValueString($_POST['np_tem1'], "text"),
                       GetSQLValueString($_POST['np_tem2'], "text"),
                       GetSQLValueString($_POST['adr_bureau'], "text"),
                       GetSQLValueString($_POST['tel_bureau'], "text"));

  mysql_select_db($database_connex, $connex);
  $Result1 = mysql_query($insertSQL, $connex) or die(mysql_error());

  $insertGoTo = "message2.php";
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
.style1 {font-style: italic}
-->
</style>
</head>

<body>
<div align="center">
  <h2><strong>Formulaire d'enregistrements des indvidus(Naissance)
  </strong></h2>
</div>
<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  <label><br />
  No Certificat
  <input name="No_cert" type="text" id="No_cert" maxlength="10" />
  </label>
  <p><label>No Registre
    <input name="No_registre" type="text" id="No_registre" maxlength="10" />
     </label>
  </p>
  <p><label><br />
    </label>
  </p>
  <hr align="center" width="600" />
  <p>
    <label><br />
     <br />
    Nom	   
    <input name="nom" type="text" id="nom" />
    </label>
  </p>
  <p>
    <label>Pr&eacute;nom
<input name="prenom" type="text" id="prenom" size="40" />
    </label>

    <label><br />
     <br />
    Date de Naissance
    <input name="date_nais" type="text" id="date_nais" />
    </label>
  </p>
  <p>
    <label>Lieu  de Naissance
    <input name="lieu_nais" type="text" id="lieu_nais" size="60" />
    </label>
</p>
  <p>&nbsp;</p>
  <hr align="center" width="600" />
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <label>CIN Officier Etat Civil
  <input name="cin_oec" type="text" id="cin_oec" maxlength="11" />
      <br />
      <br />
  </label>
  <label>NIF Officier Etat Civil  
<input name="nif_oec" type="text" id="nif_oec" maxlength="10" />
</div>
	  
  </label>
    </p>
    <p>
      <label>CIN Directeur G&eacute;n&eacute;ral
      <input name="cin_dg" type="text" id="cin_dg" maxlength="11" />
      </label>
    <p>NIF Directeur G&eacute;n&eacute;ral
      <input name="nif_dg" type="text" id="nif_dg" maxlength="10" />
    </p>
    <p>
      <label>CIN p&egrave;re
        <input name="cin_pere" type="text" id="cin_pere" maxlength="11" />
      </label>
      <label> NIF p&egrave;re
        <input name="nif_pere" type="text" id="nif_pere" maxlength="10" />
      </label>
    </p>
    <p>
      <label>CIN m&egrave;re
        <input name="cin_mere" type="text" id="cin_mere" maxlength="11" />
      </label>
      NIF m&egrave;re
  <input name="nif_mere" type="text" id="nif_mere" maxlength="10" />
    </p>
    </label>
    </p>
    <label><br />
    <br />
Nom et pr&eacute;noms T&eacute;moin 1
<input name="np_tem1" type="text" id="np_tem1" size="50" />
    </label>
<p> 
      <label>Nom et pr&eacute;noms T&eacute;moin 2
      <input name="np_tem2" type="text" id="np_tem2" size="50" />
      </label>
</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<hr align="center" width="600" />
    <p>&nbsp;</p>
    <p>
      <label>Adresse Bureau 
      <input name="adr_bureau" type="text" id="adr_bureau" size="50" />
      </label>

      <label> T&eacute;l&eacute;phone Bureau
<input name="tel_bureau" type="text" id="tel_bureau" size="20" />
      </label>
</p>
    <p>&nbsp;</p>
    <p class="style1">
    <label>
    <div align="center"></div>
    </label>
    <label>
  <div align="center">
      <input type="reset" name="Reset" value="Reset" />
      <input name="Button1" type="submit" id="Button1" value="Enregistrer" />
  </div>
    </label>
    </p>
    <p>&nbsp;</p>
    <input type="hidden" name="MM_insert" value="form1">
</form>
</body>
</html>
