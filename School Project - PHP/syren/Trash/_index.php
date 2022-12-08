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
  $insertSQL = sprintf("INSERT INTO individu (nom, prenom) VALUES (%s, %s)",
                       GetSQLValueString($_POST['nom'], "text"),
                       GetSQLValueString($_POST['prenom'], "text"));

  mysql_select_db($database_connex, $connex);
  $Result1 = mysql_query($insertSQL, $connex) or die(mysql_error());
}

mysql_select_db($database_connex, $connex);
$query_Recordset1 = "SELECT * FROM individu";
$Recordset1 = mysql_query($query_Recordset1, $connex) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<p>&nbsp; </p>

<table border="1">
  <tr>
    <td>id_ind</td>
    <td>nom</td>
    <td>prenom</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_Recordset1['id_ind']; ?></td>
      <td><?php echo $row_Recordset1['nom']; ?></td>
      <td><?php echo $row_Recordset1['prenom']; ?></td>
    </tr>
    <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
</table>
<form id="form1" name="form1" method="post" action="<?php echo $editFormAction; ?>">
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <table width="438" height="236" border="1">
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td width="104">Nom</td>
      <td width="318"><label>
        <input name="nom" type="text" id="nom" />
      </label></td>
    </tr>
    <tr>
      <td>Prenom</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><label>
        <input type="submit" name="Submit2" value="Submit" />
      </label>
        <label>
        <input type="reset" name="Submit3" value="Reset" />
      </label></td>
    </tr>
  </table>
  <input name="prenom" type="text" id="prenom" />
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>
    <input type="submit" name="Submit" value="Submit" />
  </p>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
