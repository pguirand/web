<?php
mysql_pconnect("localhost","root","");
mysql_select_db("syren");
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
                       GetSQLValueString($_POST['textfield'], "text"),
                       GetSQLValueString($_POST['textfield2'], "text"),
                       GetSQLValueString($_POST['textfield3'], "text"),
                       GetSQLValueString($_POST['textfield4'], "text"));

 if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO adresse (NOM_RUE) VALUES (%s)",
                       GetSQLValueString($_POST['textfield5'], "text"));

 }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  <label>NOM
  <input type="text" name="textfield" />
  </label>
  <p>
    <label>NUMREO PATENTE
    <input type="text" name="textfield2" />
    </label>
  </p>
  <p>
    <label>EMAIL
    <input type="text" name="textfield3" />
    </label>
  </p>
  <p>
    <label>SITE WEB
    <input type="text" name="textfield4" />
    </label>
  </p>
  <p>
    <label>RUE
    <input type="text" name="textfield5" />
    </label>
  </p>
  <p>
    <label>SEND
    <input type="submit" name="Submit" value="Submit" />
    </label>
  </p>
  <input type="hidden" name="MM_insert" value="form1">
</form>
</body>
</html>