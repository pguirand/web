<?php require_once('Connections/connex.php'); ?>
<?php
mysql_select_db($database_connex, $connex);
$query_Recordset1 = "SELECT id_user, id_ind, nom, prenom FROM utilisateurs";
$Recordset1 = mysql_query($query_Recordset1, $connex) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<table border="1">
  <tr>
    <td>id_user</td>
    <td>id_ind</td>
    <td>nom</td>
    <td>prenom</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_Recordset1['id_user']; ?></td>
      <td><?php echo $row_Recordset1['id_ind']; ?></td>
      <td><?php echo $row_Recordset1['nom']; ?></td>
      <td><?php echo $row_Recordset1['prenom']; ?></td>
    </tr>
    <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
