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
  $insertSQL = sprintf("INSERT INTO test (nom, nom2) VALUES (%s, %s)",
                       GetSQLValueString($_POST['textfield'], "text"),
                       GetSQLValueString($_POST['textfield2'], "text"));

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
<form name="form1" action="<?php echo $editFormAction; ?>" method="POST">
<table width="200" border="1">
  <tr>
    <th width="98" scope="row">nom</th>
    <td width="86"><input type="text" name="textfield" /></td>
  </tr>
  <tr>
    <th scope="row">nom2</th>
    <td><input type="text" name="textfield2" /></td>
  </tr>
</table>

<p>
  <input type="hidden" name="hiddenField" />
  <?php 
  $noma = $_POST['textfield'];
  $nomb = $_POST['textfield2'];
  $nomab = substr ($noma,0,3).substr($nomb,0,2);
  echo $nomab;
  ?>
  <input name="nomab" type="hidden" id="nomab" value= <?php echo $nomab ?>>
</p>
<p>
  <input type="submit" name="Submit" value="Submit" />
  <input type="hidden" name="MM_insert" value="form1">
</p>
<p>&nbsp;</p>
</form>
<?php 
echo $textfield2 ;
?>
</body>
</html>

