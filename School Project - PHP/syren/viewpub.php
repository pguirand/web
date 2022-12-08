<?php require_once('Connections/connex.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

    
// ** Logout the current user. **
$user = $_SESSION['MM_Username'];
$query_idd = "SELECT max(`session`.ID_SESSION) as id FROM `session` WHERE `session`.ID_UTIL = (select id_util from utilisateur where nom_util like '$user')";
mysql_select_db($database_connex, $connex);
$idd = mysql_query($query_idd, $connex) or die(mysql_error());
$row_idd = mysql_fetch_assoc($idd);
$rowid = $row_idd['id'];
$totalRows_idd = mysql_num_rows($idd);
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";

if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
 $updateSQL = sprintf("UPDATE session SET DATE_DECONN=NOW() WHERE ID_SESSION like '$rowid'");
  mysql_select_db($database_connex, $connex);
  $Result1 = mysql_query($updateSQL, $connex) or die(mysql_error());
   //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  
  $_SESSION['id_entite'] = NULL;
  $_SESSION['groupe_id'] = NULL;
    
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
  unset($_SESSION['id_entite']);
  unset($_SESSION['groupe_id']);
	
  $logoutGoTo = "index.php?act=logout";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
    
}
?>
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

$colname_voir_pub = "-1";
if (isset($_GET['ID_PUB'])) {
  $colname_voir_pub = $_GET['ID_PUB'];
}
mysql_select_db($database_connex, $connex);
$query_voir_pub = sprintf("SELECT * FROM publications WHERE ID_PUB = %s", GetSQLValueString($colname_voir_pub, "int"));
$voir_pub = mysql_query($query_voir_pub, $connex) or die(mysql_error());
$row_voir_pub = mysql_fetch_assoc($voir_pub);
$totalRows_voir_pub = mysql_num_rows($voir_pub);

mysql_select_db($database_connex, $connex);
$query_valid = sprintf("SELECT ID_UTIL FROM utilisateur WHERE NOM_UTIL = %s", GetSQLValueString($user, "text"));
$valid = mysql_query($query_valid, $connex) or die(mysql_error());
$row_valid = mysql_fetch_assoc($valid);
$valid1=$row_valid['ID_UTIL'];
$totalRows_valid = mysql_num_rows($valid);

$ugroup = $_SESSION['NOM_GROUPE'];
if (($ugroup == "administrateur syren")||($ugroup == "administrateur dgi")||($ugroup == "administrateur ime")||($ugroup == "administrateur archives")||($ugroup == "administrateur oni")||($ugroup == "administrateur archives")||($ugroup == "administrateur interieur")) 
$statut="Approuver";
else 
$statut="En attente";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>

<title>SYREN | Syst&egrave;me de Renseignement National</title>

<link href="css/style.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
#search {		background-color:#eee;
}
.style16 {
	font-size: 16px;
	font-weight: bold;
}
-->
</style>

</head>

<body>
	        <div class="screen"><div id="header">
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</div>
		
<div id="left"><?php include_once('menuleft.php');?></div>
	  </div>
	        
<div id="right">
    <?php
	include_once('menuh.php');
if($_GET['search'] == "")
	{
?>
    <?php
				echo $info
			?><p>
           <div align="center" class="style16">Voir une  publication</div>
           <p>
  <form id="form2" name="form2" method="POST">
    <label>Sujet
    <input type="text" name="Sujet" id="Sujet" value="<?php echo $row_voir_pub['TITRE_PUB']; ?>" readonly="readonly"/>
    <br />
    <br />
    Categorie
    <input name="categorie" type="text" id="categorie" value="<?php echo $row_voir_pub['TYPE_PUB']; ?>" readonly="readonly"/>    
    <br />
    <br />
    Texte<br />
    <textarea name="textpub" id="textpub" cols="80" rows="18" readonly="readonly"><?php echo $row_voir_pub['CONTENU_PUB']; ?></textarea>
    <br />
    <br />
    <br />
    <br />
    <a href="list_pub.php">Retour &agrave; la liste</a><br />
    </label>
      </form>
  <p>              
  <p>
    <br><br><br>
    <?php
	}
else
	echo " ".$nomutil."<br>";
	echo "".$id_groupe."<br>";
	echo "".$pass."<br>";
?>
</div>
  <div class="spacer"></div>
		<div id="footer">
			<div class="content">
			<img src="Logo.jpg" width="116" height="49" /> <a href="#">A propos de nous </a> | <a href="#">Plan du Site </a> | <a href="#">R&egrave;gle d'utilisation </a> | <a href="#">Contactez-nous</a> | &copy;2009 SYREN			</div>
		</div>

</body>
</html>
<?php
mysql_free_result($voir_pub);
 /*?><?php
mysql_free_result($valid);

mysql_free_result($loggedUser);
?><?php */?>
