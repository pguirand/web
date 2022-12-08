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
  $insertSQL = sprintf("INSERT INTO entite (NOM_ENTITE, NUM_PATENTE, EMAIL1, SITE_WEB) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['NOM'], "text"),
                       GetSQLValueString($_POST['NUM_PAT'], "text"),
                       GetSQLValueString($_POST['EMAIL'], "text"),
                       GetSQLValueString($_POST['SITEWEB'], "text"));

  mysql_select_db($database_connex, $connex);
  $Result1 = mysql_query($insertSQL, $connex) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO adresse (NOM_RUE) VALUES (%s)",
                       GetSQLValueString($_POST['RUE'], "text"));

  mysql_select_db($database_connex, $connex);
  $Result1 = mysql_query($insertSQL, $connex) or die(mysql_error());
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>"><div align="left">Nom
    <input name="NOM" type="text" id="NOM" />
  </div>
  </label>
  <p align="left">
    <label>Numero Patente
    <input name="NUM_PAT" type="text" id="NUM_PAT" />
    </label>
  </p>
  <p align="left">
    <label>eMail
    <input name="EMAIL" type="text" id="EMAIL" />
    </label>
  </p>
  <p align="left">
    <label>Site web
    <input name="SITEWEB" type="text" id="SITEWEB" />
    </label>
  </p>
  <p align="left">
    <label>Nom rue
    <input name="RUE" type="text" id="RUE" />
    </label>
</p>
  <p>
    <input type="hidden" name="MM_insert" value="form1">
</p>
  <p>
    <label>SUBMIT
    <input type="submit" name="Submit" value="Submit" />
    </label>
</p>
</form>
</body>
</html>
