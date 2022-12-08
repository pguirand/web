<?php require_once('Connections/connex.php'); ?>
<?php require_once('Connections/connex.php'); ?><?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
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
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "index.php?act=denied";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
	
 	
	if ($_POST['DESTINATION_VOL'] == "Haiti - PAP")
	$localisation = "en Haiti";
	if ($_POST['DESTINATION_VOL'] != "Haiti - PAP")
	$localisation = "hors Haiti";

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
	
 $updateSQL = sprintf("UPDATE individu SET LOCALISATION_IND=%s WHERE ID_IND=%s",
                       GetSQLValueString($localisation, "text"),
                       GetSQLValueString($_POST['hiddenField'], "text"));

  mysql_select_db($database_connex, $connex);
  $Result1 = mysql_query($updateSQL, $connex) or die(mysql_error());
}

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

$colname_rech_ind = "-1";
if (isset($_GET['ID_IND'])) {
  $colname_rech_ind = $_GET['ID_IND'];
}
mysql_select_db($database_connex, $connex);
$query_rech_ind = sprintf("SELECT * FROM individu WHERE ID_IND = %s", GetSQLValueString($colname_rech_ind, "text"));
$rech_ind = mysql_query($query_rech_ind, $connex) or die(mysql_error());
$row_rech_ind = mysql_fetch_assoc($rech_ind);
$totalRows_rech_ind = mysql_num_rows($rech_ind);

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) 
{

$dates = $_POST['jourd']."-".$_POST['moisd']."-".$_POST['and']."".	$_POST['heured'].":".$_POST['mind'];
	$date = strtotime($dates);
	$format = date ('Y-m-j H:i:s',$date);

$dateq = $_POST['joura']."-".$_POST['moisa']."-".$_POST['ana']."".	$_POST['heurea'].":".$_POST['mina'];
	$datew = strtotime($dateq);
	$formata = date ('Y-m-j H:i:s',$datew);

if ($_POST['PROVENANCE_VOL'] == "Haiti - PAP");
	$prov = "HA";
	
if ($_POST['PROVENANCE_VOL'] == "Etats-Unis - New York")
	$prov = "EN";
	
if ($_POST['PROVENANCE_VOL'] == "Etats-Unis - Washinton")
	$prov = "EW";	
	
if ($_POST['PROVENANCE_VOL'] == "Etats-Unis - Chicago")
	$prov = "EC";	
	
if ($_POST['PROVENANCE_VOL'] == "France - Paris")
	$prov = "FP";	
	
if ($_POST['PROVENANCE_VOL'] == "Canada - Montreal")
	$prov = "CM";		

if ($_POST['PROVENANCE_VOL'] == "Canada - Ottawa")
	$prov = "CO";
	
if ($_POST['PROVENANCE_VOL'] == "Panama - Panamy City")
	$prov = "PA";	
	
if ($_POST['PROVENANCE_VOL'] == "Rep. Dom.- Santo Domingo")
	$prov = "SD";
	
if ($_POST['PROVENANCE_VOL'] == "Rep. Dom. Santiago")
	$prov = "SA";	

if ($_POST['NOM_COMP_AERIENNE'] == "American Airlines")
	$aer = "A";
	
if ($_POST['NOM_COMP_AERIENNE'] == "Air France")
	$aer = "F";	

if ($_POST['NOM_COMP_AERIENNE'] == "Spirit")
	$aer = "S";

if ($_POST['NOM_COMP_AERIENNE'] == "Air Canada")
	$aer = "C";	
	
if ($_POST['NOM_COMP_AERIENNE'] == "Copa Airlines")
	$aer = "P";	

if ($_POST['NOM_COMP_AERIENNE'] == "Euro Caraibles")
	$aer = "B";	
	

	                     
$vol = $aer.$prov.substr($_POST['and'],2,4).$_POST['jourd'].$_POST['moisd'].$_POST['heured'].$_POST['mind'];
echo $vol;




	

  $insertGoTo = "savevoyageok.php?ID_VOYAGE=";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));




$insertSQL = sprintf("INSERT INTO voyage (NOM_COMP_AERIENNE, NO_VOL, PROVENANCE_VOL, DESTINATION_VOL, ID_IND) VALUES (%s, %s, %s, %s,%s)",
                       GetSQLValueString($_POST['NOM_COMP_AERIENNE'], "text"),
                       GetSQLValueString($vol, "text"),
                       GetSQLValueString($_POST['PROVENANCE_VOL'], "text"),
                       GetSQLValueString($_POST['DESTINATION_VOL'], "text"),
					   GetSQLValueString($row_rech_ind['ID_IND'], "text"));

  mysql_select_db($database_connex, $connex);
  $Result1 = mysql_query($insertSQL, $connex) or die(mysql_error());
}

$colname_rech_ind = "-1";
if (isset($_GET['ID_IND'])) {
  $colname_rech_ind = $_GET['ID_IND'];
}
mysql_select_db($database_connex, $connex);
$query_rech_ind = sprintf("SELECT * FROM individu WHERE ID_IND = %s", GetSQLValueString($colname_rech_ind, "text"));
$rech_ind = mysql_query($query_rech_ind, $connex) or die(mysql_error());
$row_rech_ind = mysql_fetch_assoc($rech_ind);
$totalRows_rech_ind = mysql_num_rows($rech_ind);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>

<title>SYREN | Syst&egrave;me de Renseignement National</title>

<link href="css/style.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style10 {font-size: 10px}
#search {		background-color:#eee;
}
.style12 {font-size: 12px}
-->
</style>


<style type="text/css">
<!--
.style13 {font-size: 13px}
-->
</style>
</head>

<body>
	        <div id="left"><?php include_once('menuleft.php');?></div>
	        
<div id="right">
  <p>
  <?php 
include_once("menuh.php");
?>  
    <?php
if($_GET['search'] == "")
	{
?>
    <?php
				echo $info
			?>
  </p>
      <form action="<?php echo $editFormAction; ?>" id="form2" name="form2" method="POST">
                  
        <p>
          <input name="hiddenField" type="hidden" id="hiddenField" value="<?php echo $row_rech_ind['ID_IND'] ?>" />
        </p>
        <p>
          <input name="hiddenField2" type="hidden" id="hiddenField2" value="<?php echo $localisation ?>" />
        </p>
        <div align="center" class="fonce" id="title">Forme d'Enregistrement de Voyages</div>
        <br />
                  
        <table width="100%" border="1" id="comliste">
          <tr class="head">
            <td colspan="4"><div align="center" class="style12"><strong>Informations personnelles de l'individu</strong></div></td>
          </tr>
          <tr>
            <td width="83">No Passeport:</td>
            <td width="198"><?php echo $row_rech_ind['NUM_PASSPORT'] ?></td>
            <td width="84">Type Passeport:</td>
            <td width="220"><?php echo $row_rech_ind['TYPE_PASS'] ?></td>
          </tr>
          <tr>
            <td>Nom:</td>
            <td><span style="background-color:#C4ECFF"><?php echo $row_rech_ind['NOM_IND'] ?></span></td>
            <td>Prenom:</td>
            <td><?php echo $row_rech_ind['PRENOM_IND'] ?></td>
          </tr>
          <tr>
            <td>Nationalit&eacute;:</td>
            <td><?php echo $row_rech_ind['NATIONALITE_INDIVIDU'] ?></td>
            <td>Groupe Sanguin:</td>
            <td><?php echo $row_rech_ind['G_SANG_IND'] ?></td>
          </tr>
          <tr>
            <td>Date de Naissance:</td>
            <td><?php echo $row_rech_ind['DATEH_NAIS'] ?></td>
            <td>SEXE:</td>
            <td><?php echo $row_rech_ind['SEXE_IND'] ?></td>
          </tr>
          <tr>
            <td>Adresse :</td>
            <td colspan="2" rowspan="2">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Telephone:</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr class="head">
            <td colspan="4"><div align="center" class="style12"><strong>informations du voyage de l'individu</strong></div></td>
          </tr>
          <tr>
            <td>Compagnie Aerienne:</td>
            <td><label for="NOM_COMP_AERIENNE"></label>
              <select name="NOM_COMP_AERIENNE" id="NOM_COMP_AERIENNE">
                <option selected="selected">American Airlines</option>
                <option>Air France</option>
                <option>Spirit</option>
                <option>Air Canada</option>
                <option>Copa Airlines</option>
                <option>Euro Caraibles</option>
            </select>                  </td>
            <td>No Vol:</td>
            <td><label for="NO_VOL"></label></td>
          </tr>
          <tr>
            <td>Pays de Provenance:</td>
            <td><label for="PROVENANCE_VOL"></label>
              <select name="PROVENANCE_VOL" id="PROVENANCE_VOL">
                <option selected="selected">Haiti - PAP</option>
                <option>Etats-Unis - New York</option>
                <option>Etats-Unis - Washinton</option>
                <option>Etats-Unis - Chicago</option>
                <option>France - Paris</option>
                <option>Canada - Montreal</option>
                <option>Canada - Ottawa</option>
                <option>Panama - Panamy City</option>
                <option>Rep. Dom.- Santo Domingo</option>
                <option>Rep. Dom. Santiago</option>
              </select>                  </td>
            <td>Pays de Destination:</td>
            <td><label for="DESTINATION_VOL"></label>
              <select name="DESTINATION_VOL" id="DESTINATION_VOL">
                <option>Haiti - PAP</option>
                <option selected="selected">Etats-Unis - New York</option>
                <option>Etats-Unis - Washinton</option>
                <option>Etats-Unis - Chicago</option>
                <option>Etats-Unis - New York</option>
                <option>France - Paris</option>
                <option>Canada - Montreal</option>
                <option>Canada - Ottawa</option>
                <option>Panama - Panamy City</option>
                <option>Rep. Dom.- Santo Domingo</option>
                <option>Rep. Dom. Santiago</option>
              </select>                  </td>
          </tr>
        </table>
        <p>	<br />
        </p>
        <label for="button"></label>
        <table border="0" align="center">
          <tr><td>
            <input type="reset" name="Reset" id="button" value="Annuler" />
            <label for="button2"></label>
            <input type="submit" name="button2" id="button2" value="Enregistrer" />
        </td></tr></table>
        <br />
        <input type="hidden" name="MM_insert" value="form2" />
        <input type="hidden" name="MM_update" value="form2" />
</p>
  </form>
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
</div>

</body>
</html>
<?php
mysql_free_result($rech_ind);

mysql_free_result($loggedUser);
?>
