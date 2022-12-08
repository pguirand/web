<?php require_once('Connections/connex.php'); ?>
<?php require_once('Connections/connex.php'); ?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$nomutili=$_SESSION['MM_Username'];

/*$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['NOM_UTIL'])) {
  $loginUsername=$_POST['NOM_UTIL'];
  $password=$_POST['MOT_PASS'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "/syren/admininterf.php";
  $MM_redirectLoginFailed = "./";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_connex, $connex);
  
  $LoginRS__query=sprintf("SELECT NOM_UTIL,MOT_PASS FROM utilisateur WHERE NOM_UTIL=%s AND MOT_PASS=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $connex) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;
	$_SESSION['id_entite']	= $row_loggedUser['ID_ENTITE'];

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}*/
?>

<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

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
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
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
mysql_select_db($database_connex, $connex);
$query_loggedUser = "SELECT * FROM utilisateur WHERE NOM_UTIL = '$nomutili'";
$loggedUser = mysql_query($query_loggedUser, $connex) or die(mysql_error());
$row_loggedUser = mysql_fetch_assoc($loggedUser);
$IDutil=$row_loggedUser['ID_UTIL'];
$totalRows_loggedUser = mysql_num_rows($loggedUser);

$datenif = $_POST['jour']."-".$_POST['mois']."-".$_POST['an'];
$datecif = $_POST['jour2']."-".$_POST['mois2']."-".$_POST['an2'];
$datepass = $_POST['jour3']."-".$_POST['mois3']."-".$_POST['an3'];
$photo_name = $_FILES['PHOTO']['name'];
$target_path = "images/photos/individus/photo";
$target_path2 = $target_path.basename($_FILES['photo']['name']);
$photo_namecin = $_FILES['PHOTO_CIN']['name'];
$target_pathcin = "images/photos/individus/photo";
$target_pathcin = $target_pathcin.basename($_FILES['PHOTO_CIN']['name']);
$photo_namepass = $_FILES['PHOTO_PASS']['name'];
$target_pathpass = "images/photos/individus/photo";
$target_pathpass = $target_pathcin.basename($_FILES['PHOTO_PASS']['name']);
$dateee=date("Y-m-d");
$nextyear  = date("Y")+5;
$DM = date("m-d");
$dfinal=$nextyear."-".$DM;

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE individu SET EMPRINTE_IND=%s, G_SANG_IND=%s, SEXE_IND=%s, NOM_IND=%s, NOM_JEUNE_FILLE=%s, PRENOM_IND=%s, DATEH_NAIS=%s, PHOTO=%s, PHOTO_CIN=%s, PHOTO_PASS=%s, NUM_NIF=%s, DATE_EMISSION_NIF=%s, DATE_EXPIRATION_NIF=%s, LIEU_EMISSION_NIF=%s, NUM_CIF=%s, DATE_EMISSION_CIF=%s, DATE_EXPIRATION_CIF=%s, LIEU_EMISSION_CIF=%s, NUM_PASSPORT=%s, TYPE_PASS=%s, LIEU_EMISSION_PASS=%s, DATE_EMISSION_PASS=%s, DATE_EXPIRATION_PASS=%s, NATIONALITE_INDIVIDU=%s, EMAIL1=%s, CHAMP_MODIFIER_PAR=%s WHERE ID_IND=%s",
                       GetSQLValueString($_POST['EMPRINTE_IND'], "text"),
                       GetSQLValueString($_POST['G_SANG_IND'], "text"),
                       GetSQLValueString($_POST['SEXE_IND'], "text"),
                       GetSQLValueString($_POST['NOM_IND'], "text"),
                       GetSQLValueString($_POST['NOM_JEUNE_FILLE'], "text"),
                       GetSQLValueString($_POST['PRENOM_IND'], "text"),
                       GetSQLValueString($_POST['DATEH_NAIS'], "date"),
                       GetSQLValueString($target_path, "text"),
                       GetSQLValueString($target_pathcin, "text"),
                       GetSQLValueString($target_pathpass, "text"),
                       GetSQLValueString($_POST['NUM_NIF'], "text"),
                       GetSQLValueString($_POST['DATE_EMISSION_NIF'], "date"),
                       GetSQLValueString($_POST['DATE_EXPIRATION_NIF'], "date"),
                       GetSQLValueString($_POST['LIEU_EMISSION_NIF'], "text"),
                       GetSQLValueString($_POST['NUM_CIF'], "text"),
                       GetSQLValueString($_POST['DATE_EMISSION_CIF'], "date"),
                       GetSQLValueString($_POST['DATE_EXPIRATION_CIF'], "date"),
                       GetSQLValueString($_POST['LIEU_EMISSION_CIN'], "text"),
                       GetSQLValueString($_POST['NUM_PASSPORT'], "text"),
                       GetSQLValueString($_POST['TYPE_PASS'], "text"),
                       GetSQLValueString($_POST['LIEU_EMISSION_PASS'], "text"),
                       GetSQLValueString($_POST['DATE_EMISSION_PASS'], "date"),
                       GetSQLValueString($_POST['DATE_EXPIRATION_PASS'], "date"),
                       GetSQLValueString($_POST['NATIONALITE_INDIVIDU'], "text"),
                       GetSQLValueString($_POST['email1'], "text"),
					   GetSQLValueString($IDutil, "int"),
                       GetSQLValueString($_POST['ID_IND'], "text"));

  mysql_select_db($database_connex, $connex);
  $Result1 = mysql_query($updateSQL, $connex) or die(mysql_error());

  $updateGoTo = "updindok.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE coordonnees SET NUM_TEL1=%s, NUM_TEL2=%s, NUM_TEL3=%s, NUM_TEL4=%s, ID_IND=%s WHERE ID_COORD=%s",
                       GetSQLValueString($_POST['NUM_TEL1'], "text"),
                       GetSQLValueString($_POST['NUM_TEL2'], "text"),
                       GetSQLValueString($_POST['NUM_TEL3'], "text"),
                       GetSQLValueString($_POST['NUM_TEL4'], "text"),
                       GetSQLValueString($_POST['ID_IND'], "text"),
                       GetSQLValueString($_POST['ID_COORD'], "int"));

  mysql_select_db($database_connex, $connex);
  $Result1 = mysql_query($updateSQL, $connex) or die(mysql_error());
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE adresse SET NOM_RUE=%s, NUM_EDIFICE=%s, ID_SECCOM=%s, ID_IND=%s WHERE ID_ADRESSE=%s",
                       GetSQLValueString($_POST['NOM_RUE'], "text"),
                       GetSQLValueString($_POST['NUMERO_EDIFICE'], "int"),
                       GetSQLValueString($_POST['ID_SECCOM'], "int"),
                       GetSQLValueString($_POST['ID_IND'], "text"),
                       GetSQLValueString($_POST['ID_ADRESSE'], "int"));

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

$colname_Recordset1 = "-1";
if (isset($_GET['ID_IND'])) {
  $colname_Recordset1 = $_GET['ID_IND'];
}
mysql_select_db($database_connex, $connex);
$query_Recordset1 = sprintf("SELECT * FROM individu, document, adresse, sectioncom WHERE individu.ID_IND = %s AND individu.ID_IND=`document`.ID_IND and individu.ID_IND=adresse.ID_IND and adresse.ID_SECCOM=sectioncom.ID_SECCOM ORDER BY individu.ID_IND ASC", GetSQLValueString($colname_Recordset1, "text"));
$Recordset1 = mysql_query($query_Recordset1, $connex) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_connex, $connex);
$query_COMMUNE = "SELECT * FROM commune";
$COMMUNE = mysql_query($query_COMMUNE, $connex) or die(mysql_error());
$row_COMMUNE = mysql_fetch_assoc($COMMUNE);
$totalRows_COMMUNE = mysql_num_rows($COMMUNE);

$colname_Recordset2 = "-1";
if (isset($_GET['ID_IND'])) {
  $colname_Recordset2 = $_GET['ID_IND'];
}
mysql_select_db($database_connex, $connex);
$query_Recordset2 = sprintf("SELECT * FROM individu, coordonnees WHERE individu.ID_IND = %s AND individu.ID_IND=coordonnees.ID_IND ORDER BY individu.ID_IND ASC", GetSQLValueString($colname_Recordset2, "text"));
$Recordset2 = mysql_query($query_Recordset2, $connex) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

$colname_loggedUser = "-1";
if (isset($_POST['NOM_UTIL'])) {
  $colname_loggedUser = $_POST['NOM_UTIL'];
}

/* database configuration */
$dbConfig['type']="mysql";
$dbConfig['server']="localhost";
$dbConfig['username']="root";
$dbConfig['password']="";
$dbConfig['database']="syren";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>

<title>SYREN | Syst&egrave;me de Renseignement National</title>

<script>
function activate()
{
document.getElementById('NUMERO_EDIFICE').disabled=false;
document.getElementById('NOM_RUE').disabled=false;
document.getElementById('ID_SECCOM').disabled=false;
document.getElementById('addr').style.display='inline';
}

function desactivate()
{
document.getElementById('NUMERO_EDIFICE').disabled=true;
document.getElementById('NOM_RUE').disabled=true;
document.getElementById('ID_SECCOM').disabled=true;
document.getElementById('addr').style.display='none';
}
function rand()
{
var rand1=Math.floor(Math.random() * (999 - 100 + 1) + 100);
var rand2=Math.floor(Math.random() * (999 - 100 + 1) + 100);
var rand3=Math.floor(Math.random() * (999 - 100 + 1) + 100);
var rand4=Math.floor(Math.random() * (9 - 1+ 1) + 1);
document.getElementById('NUM_NIF').value=rand1+'-'+rand2+'-'+rand3+'-'+rand4;
}
function rand2()
{
var currentTime = new Date();
var month = currentTime.getMonth() + 1;
var day = currentTime.getDate();
var year = currentTime.getFullYear();
var birth = document.getElementById('DATEH_NAIS2').value;
var splitarray = new Array(); 
splitarray= birth.split(" ");
var splitarray2 = new Array();
splitarray2= splitarray[0].split("-");
var mois = splitarray2[1];
var annee = splitarray2[0];
var rand1=Math.floor(Math.random() * (99 - 10 + 1) + 10);
var rand2=Math.floor(Math.random() * (99999 - 10000 + 1) + 10000);
var rand3=Math.floor(Math.random() * (999 - 100 + 1) + 100);
var rand4=Math.floor(Math.random() * (9 - 1+ 1) + 1);
document.getElementById('NUM_CIF').value=mois+'-'+mois+'-'+rand1+'-'+annee+'-'+mois+'-'+rand2;
}
function rand3()
{
var rand1='PP';
var rand2=Math.floor(Math.random() * (999999999 - 100000000 + 1) + 100000000);
document.getElementById('NUM_PASSPORT').value=rand1+rand2;
}
</script>

<script type="text/javascript">
function toggle_NUM_NIF(userid) {
    if (window.XMLHttpRequest) {
        http = new XMLHttpRequest();
    } else if (window.ActiveXObject) {
        http = new ActiveXObject("Microsoft.XMLHTTP");
    }
    handle = document.getElementById(userid);
    var url = 'ajax.php?';
    if(handle.value.length > 0) {
        var fullurl = url + 'do=check_NUM_NIF_exists&NUM_NIF=' + encodeURIComponent(handle.value);
        http.open("GET", fullurl, true);
        http.send(null);
        http.onreadystatechange = statechange_NUM_NIF;
    }else{
        document.getElementById('NUM_NIF_exists').innerHTML = '';
    }
}


function statechange_NUM_NIF() {
    if (http.readyState == 4) {
        var xmlObj = http.responseXML;
        var html = xmlObj.getElementsByTagName('result').item(0).firstChild.data;
        document.getElementById('NUM_NIF_exists').innerHTML = html;
    }
}
</script>

<script type="text/javascript">
function toggle_NUM_CIF(userid) {
    if (window.XMLHttpRequest) {
        http = new XMLHttpRequest();
    } else if (window.ActiveXObject) {
        http = new ActiveXObject("Microsoft.XMLHTTP");
    }
    handle = document.getElementById(userid);
    var url = 'ajaxcif.php?';
    if(handle.value.length > 0) {
        var fullurl = url + 'do=check_NUM_CIF_exists&NUM_CIF=' + encodeURIComponent(handle.value);
        http.open("GET", fullurl, true);
        http.send(null);
        http.onreadystatechange = statechange_NUM_CIF;
    }else{
        document.getElementById('NUM_CIF_exists').innerHTML = '';
    }
}


function statechange_NUM_NIF() {
    if (http.readyState == 4) {
        var xmlObj = http.responseXML;
        var html = xmlObj.getElementsByTagName('result').item(0).firstChild.data;
        document.getElementById('NUM_CIF_exists').innerHTML = html;
    }
}
</script>

<script type="text/javascript">
function toggle_NUM_PASSPORT(userid) {
    if (window.XMLHttpRequest) {
        http = new XMLHttpRequest();
    } else if (window.ActiveXObject) {
        http = new ActiveXObject("Microsoft.XMLHTTP");
    }
    handle = document.getElementById(userid);
    var url = 'ajaxpass.php?';
    if(handle.value.length > 0) {
        var fullurl = url + 'do=check_NUM_PASSPORT_exists&NUM_PASSPORT=' + encodeURIComponent(handle.value);
        http.open("GET", fullurl, true);
        http.send(null);
        http.onreadystatechange = statechange_NUM_CIF;
    }else{
        document.getElementById('NUM_PASSPORT_exists').innerHTML = '';
    }
}


function statechange_NUM_NIF() {
    if (http.readyState == 4) {
        var xmlObj = http.responseXML;
        var html = xmlObj.getElementsByTagName('result').item(0).firstChild.data;
        document.getElementById('NUM_PASSPORT_exists').innerHTML = html;
    }
}
</script>

<link href="css/style.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style10 {font-size: 10px}
#search {background-color:#eee;}
.style12 {font-size: 12px}
-->
</style>


<style type="text/css">
<!--
.style13 {font-size: 13px}
.style14 {font-size: 11px}
-->
</style>
</head>

<body>
	        <div class="screen"><div id="header">
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</div>

<div id="left">
  <?php include_once('menuleft.php');?>
  </div>
	  </div>
	        
<div id="right">
 <?php 
include_once("menuh.php");
?>
  <p>
    <?php
if($_GET['search'] == "")
	{
?>
  </p>
  <p>&nbsp;</p>
  <div class="story">
    <div align="center" class="fonce">FORMULAIRE DE MISE A JOUR DES INFORMATIONS D'UN INDIVIDU</div>
    </p>
    <p>&nbsp;</p>
    <form action="<?php echo $editFormAction; ?>" id="form2" name="form2" method="POST">
      <table width="732" border="0" align="center" cellpadding="0" cellspacing="0" id="midTable">
        <tr class="head">
          <td colspan="7"><div align="center" class="fonce">INFORMATIONS A REMPLIR</div></td>
        </tr>
        <tr class="style14">
          <td><span class="style14">NUMERO DOCUMENT</span></td>
        <td colspan="3"><input name="NO_DOC" type="text" class="style14" id="NO_DOC" value="<?php echo $row_Recordset1['NO_DOC']; ?>" size="25" readonly="readonly"/> 
          <label class="style12">
          <input name="TYPE_DOC" type="text" class="style14" id="TYPE_DOC" value="<?php echo $row_Recordset1['TYPE_DOC']; ?>" readonly="readonly" />
          </label>        
        <td width="82">ENPREINTE INDIVIDU        
        <td colspan="2"><input name="EMPRINTE_IND" type="file" id="EMPRINTE_IND"/></tr>
        <tr class="style14">
          <td width="83"><span class="style14 style10 style10 style10 style10">NOM</span></td>
<td><span class="style14 style10 style10 style10 style10">
  <label>
  <input name="NOM_IND" type="text" class="style14" id="NOM_IND" value="<?php echo strtoupper($row_Recordset1['NOM_IND']); ?>" size="33" style="text-transform:uppercase"/>
  </label>
</span></td>
        <td><span class="style14 style10 style10 style10 style10">NOM DE JEUNE FILLE</span></td>
        <td colspan="4"><span class="style14 style10 style10 style10 style10">
          <input name="NOM_JEUNE_FILLE" type="text" class="style14" id="NOM_JEUNE_FILLE" style="text-transform:uppercase" value="<?php echo $row_Recordset1['NOM_JEUNE_FILLE']; ?>" size="33" />
        </span><span class="style14 style10 style10 style10 style10">
          <label></label>
        </span></td>
        </tr>
        <tr class="style14">
          <td><span class="style14 style10 style10 style10 style10">PRENOM</span></td>
          <td colspan="3"><input name="PRENOM_IND" type="text" class="style14" id="PRENOM_IND" value="<?php echo $row_Recordset1['PRENOM_IND']; ?>" size="33"  style="text-transform:uppercase"/></td>
          <td class="style14"><span class="style14">DATE DE NAISSANCE</span></td>
          <td colspan="2" class="style14"><label>
          <input name="DATEH_NAIS2" type="text" class="style14" id="DATEH_NAIS2" value="<?php echo $row_Recordset1['DATEH_NAIS']; ?>" size="30" readonly="readonly"/>
          </label></td>
        </tr>
        <tr class="style14">
          <td><span class="style14 style10 style10 style10 style10">SEXE</span></td>
          <td width="183"><span class="style14 style10 style10 style10 style10">
            <label>
              <select name="SEXE_IND" size="1" class="style14" id="SEXE_IND">
                <option value="Masculin" <?php if (!(strcmp("Masculin", $row_Recordset1['SEXE_IND']))) {echo "selected=\"selected\"";} ?>>Masculin</option>
                <option value="Feminin" <?php if (!(strcmp("Feminin", $row_Recordset1['SEXE_IND']))) {echo "selected=\"selected\"";} ?>>Feminin</option>
                <?php
do {  
?>
                <option value="<?php echo $row_Recordset1['SEXE_IND']?>"<?php if (!(strcmp($row_Recordset1['SEXE_IND'], $row_Recordset1['SEXE_IND']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Recordset1['SEXE_IND']?></option>
                <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
              </select>
            </label>
          </span></td>
          <td width="93"><span class="style14 style10 style10 style10 style10">GROUPE SANGUIN</span></td>
          <td colspan="2"><span class="style14 style10 style10 style10 style10">
            <select name="G_SANG_IND" class="style14" id="G_SANG_IND">
              <option value="A-" <?php if (!(strcmp("A-", $row_Recordset1['G_SANG_IND']))) {echo "selected=\"selected\"";} ?>>A-</option>
<option value="O+" <?php if (!(strcmp("O+", $row_Recordset1['G_SANG_IND']))) {echo "selected=\"selected\"";} ?>>O+</option><option value="O-" <?php if (!(strcmp("O-", $row_Recordset1['G_SANG_IND']))) {echo "selected=\"selected\"";} ?>>O-</option>
              <option value="B+" <?php if (!(strcmp("B+", $row_Recordset1['G_SANG_IND']))) {echo "selected=\"selected\"";} ?>>B+</option>
<option value="B-" <?php if (!(strcmp("B-", $row_Recordset1['G_SANG_IND']))) {echo "selected=\"selected\"";} ?>>B-</option><option value="AB+" <?php if (!(strcmp("AB+", $row_Recordset1['G_SANG_IND']))) {echo "selected=\"selected\"";} ?>>AB+</option>
              <option value="AB-" <?php if (!(strcmp("AB-", $row_Recordset1['G_SANG_IND']))) {echo "selected=\"selected\"";} ?>>AB-</option>
              <?php
do {  
?><option value="<?php echo $row_Recordset1['G_SANG_IND']?>"<?php if (!(strcmp($row_Recordset1['G_SANG_IND'], $row_Recordset1['G_SANG_IND']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Recordset1['G_SANG_IND']?></option><?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
            </select>
          </span></td>
          <td width="122"><span class="style14 style10 style10 style10 style10">NATIONALITE</span></td>
          <td width="154"><span class="style14 style10 style10 style10 style10">
            <select name="NATIONALITE_INDIVIDU" class="style14" id="NATIONALITE_INDIVIDU">
              <option value="" <?php if (!(strcmp("", $row_Recordset1['NATIONALITE_INDIVIDU']))) {echo "selected=\"selected\"";} ?>>Haitienne</option>
              <option value="" <?php if (!(strcmp("", $row_Recordset1['NATIONALITE_INDIVIDU']))) {echo "selected=\"selected\"";} ?>>Autre...</option>
              <?php
do {  
?>
              <option value="<?php echo $row_Recordset1['NATIONALITE_INDIVIDU']?>"<?php if (!(strcmp($row_Recordset1['NATIONALITE_INDIVIDU'], $row_Recordset1['NATIONALITE_INDIVIDU']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Recordset1['NATIONALITE_INDIVIDU']?></option>
              <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
            </select>
          </span></td>
        </tr>
        <tr class="style14">
          <td colspan="4"><div align="center"><strong>Info Nif</strong></div></td>
          <td colspan="3"><div align="center"><strong>Info Cin</strong></div></td>
        </tr>
        <tr class="style14">
          <td>NUMERO NIF </td>
          <td colspan="3"><input name="NUM_NIF" type="text" class="style14" id="NUM_NIF" value="<?php echo $row_Recordset1['NUM_NIF']; ?>" <?php if (($groupe != "operateur dgi")&&($groupe != "administrateur dgi")){?> readonly="readonly"<?php } ?>/>
          <input type="button" name="Generer NIF" id="Generer NIF" value="G&eacute;n&eacute;rer NIF" onclick="rand();toggle_NUM_NIF('NUM_NIF')"<?php if (($groupe != "operateur dgi")&&($groupe != "administrateur dgi")|| ($row_Recordset1['NUM_NIF']!= "")){?> disabled="disabled"<?php } ?>/>
          <br />
<div id="NUM_NIF_exists" style="font-size: 11px;font-weight: bold;color:#FF3300"> </div>
          </label></td>
          <td>NUMERO CIN</td>
          <td colspan="2"><input name="NUM_CIF" type="text" class="style14" id="NUM_CIF" value="<?php echo $row_Recordset1['NUM_CIF']; ?>" size="26" <?php if (($groupe != "operateur oni")&&($groupe != "administrateur oni")|| ($row_Recordset1['NUM_CIF']!= "")){?> readonly="readonly"<?php } ?>/> 
          <input type="button" name="Generer CIF" id="Generer CIF" value="G&eacute;n&eacute;rer CIF" onclick="rand2();toggle_NUM_CIF('NUM_CIF')"<?php if (($groupe != "operateur oni")&&($groupe != "administrateur oni")|| ($row_Recordset1['NUM_CIF']!= "")){?> disabled="disabled"<?php } ?>/><br />
<div id="NUM_CIF_exists" style="font-size: 11px;font-weight: bold;color:#FF3300"> </div></td>
        </tr>
        <tr class="style14">
          <td>DATE EMISS DATE EXP</td>
          <td colspan="3"><span class="style16">
            <label>
            <input type="text" name="DATE_EMISSION_NIF" id="DATE_EMISSION_NIF" value="<?php if ($row_Recordset1['NUM_NIF']=="") echo $dateee; else echo $row_Recordset1['DATE_EMISSION_NIF'];?>" readonly="readonly"/>
            <br />
            </label>
            <label class="style14"></label>
            <label>
            <input type="text" name="DATE_EXPIRATION_NIF" id="DATE_EXPIRATION_NIF" value="<?php if ($row_Recordset1['NUM_NIF']=="") echo $dfinal; else echo $row_Recordset1['DATE_EXPIRATION_NIF'];?>" readonly="readonly"/>
            </label>
          </span></td>
          <td>DATE EMISS DATE EXP</td>
          <td colspan="2"><span class="style16">
            <label>
            <input type="text" readonly="readonly" name="DATE_EMISSION_CIF" id="DATE_EMISSION_CIF" value="<?php if ($row_Recordset1['NUM_CIF']=="") echo $dateee; else echo $row_Recordset1['DATE_EMISSION_CIF'];?>"/>
            <br />
            </label>
            <label class="style14"></label>
            <label>
            <input type="text" readonly="readonly" name="DATE_EXPIRATION_CIF" id="DATE_EXPIRATION_CIF" value="<?php if ($row_Recordset1['NUM_CIF']=="") echo $dfinal; else echo $row_Recordset1['DATE_EXPIRATION_CIF'];?>"/>
            </label>
          </span></td>
        </tr>
        <tr class="style14">
          <td>LIEU EMISSION</td>
          <td colspan="3"><label>
            <input name="LIEU_EMISSION_NIF" type="text" style="text-transform:uppercase" class="style14" id="LIEU_EMISSION_NIF" value="<?php echo $row_Recordset1['LIEU_EMISSION_NIF']; ?>" size="30" <?php if (($groupe != "operateur dgi")&&($groupe != "administrateur dgi")){?>readonly="readonly"<?php } ?>/>
          </label></td>
          <td>LIEU EMISSION</td>
          <td colspan="2"><input name="LIEU_EMISSION_CIN" style="text-transform:uppercase" type="text" class="style14" id="LIEU_EMISSION_CIN" value="<?php echo $row_Recordset1['LIEU_EMISSION_CIF']; ?>" size="30"<?php if (($groupe != "operateur oni")&&($groupe != "administrateur oni")){?>readonly="readonly"<?php } ?>/></td>
        </tr>
        <tr class="style14">
          <td>PHOTO INDIVIDU</td>
          <td colspan="3"><input type="file" name="PHOTO" id="PHOTO"<?php if (($groupe != "operateur dgi")&&($groupe != "administrateur dgi")){?> disabled="disabled"<?php } ?>/></td>
          <td>PHOTO INDIVIDU</td>
          <td colspan="2"><input type="file" name="PHOTO_CIN" id="PHOTO_CIN" <?php if (($groupe != "operateur oni")&&($groupe != "administrateur oni")){?>disabled="disabled"<?php } ?> /></td>
        </tr>
        <tr class="style14">
          <td height="21" colspan="4"><span class="style14 style10 style10 style10 style10">
            <label></label>
            <div align="center"><strong>Info Passeport        </strong></div>
          </span></td>
          <td colspan="3"><span class="style14 style10 style10 style10 style10">
            <label></label>
            <div align="center"><strong>Info additionnelles</strong></div>
          </span></td>
        </tr>
        <tr class="style14">
          <td>TYPE PASSEPORT</td>
          <td colspan="2"><label>
            <select name="TYPE_PASS" id="TYPE_PASS" <?php if (($groupe != "operateur ime")&&($groupe != "administrateur ime")){?> disabled="disabled"<?php } ?>>
              <option selected="selected" value="P" <?php if (!(strcmp("P", $row_Recordset1['TYPE_PASS']))) {echo "selected=\"selected\"";} ?>>P</option>
              <option value="T" <?php if (!(strcmp("T", $row_Recordset1['TYPE_PASS']))) {echo "selected=\"selected\"";} ?>>T</option>
              <option value="A" <?php if (!(strcmp("A", $row_Recordset1['TYPE_PASS']))) {echo "selected=\"selected\"";} ?>>A</option>
              <?php
do {  
?>
              <option value="<?php echo $row_Recordset1['TYPE_PASS']?>"<?php if (!(strcmp($row_Recordset1['TYPE_PASS'], $row_Recordset1['TYPE_PASS']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Recordset1['TYPE_PASS']?></option>
              <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
            </select>
          </label></td>
          <td colspan="2" rowspan="3" class="style14">NUMERO DE TELEPHONE</td>
          <td colspan="2" rowspan="3"><label>
            <span class="style14">
            <input name="NUM_TEL1" type="text" class="style14" id="NUM_TEL1" value="<?php echo $row_Recordset2['NUM_TEL1']; ?>" />
            <input name="NUM_TEL2" type="text" class="style14" id="NUM_TEL6" value="<?php echo $row_Recordset2['NUM_TEL2']; ?>" />
            </span></label>
            <span class="style14">
            <input name="NUM_TEL3" type="text" class="style14" id="NUM_TEL7" value="<?php echo $row_Recordset2['NUM_TEL3']; ?>" />
            </span>
            <input name="NUM_TEL4" type="text" class="style14" id="NUM_TEL8" value="<?php echo $row_Recordset2['NUM_TEL4']; ?>" /></td>
        </tr>
        <tr class="style14">
          <td>NUMERO PASSEPORT</td>
          <td colspan="2"><input name="NUM_PASSPORT" type="text" class="style14" id="NUM_PASSPORT" value="<?php echo $row_Recordset1['NUM_PASSPORT']; ?>" <?php if (($groupe != "operateur ime")&&($groupe != "administrateur ime")){?>readonly="readonly" <?php } ?>/>
          <input type="button" name="Generer NoPASS" id="Generer NoPASS" value="G&eacute;n&eacute;rer No. PASS" onclick="rand3();toggle_NUM_PASSPORT('NUM_PASSPORT')"<?php if (($groupe != "operateur ime")&&($groupe != "administrateur ime")|| ($row_Recordset1['NUM_PASSPORT']!= "")){?> disabled="disabled"<?php } ?>/></td>
        </tr>
        <tr class="style14">
          <td>DATE EMISS DATE EXP</td>
          <td colspan="2"><span class="style16">
            <label>
            <input type="text" name="DATE_EMISSION_PASS" id="DATE_EMISSION_PASS" value="<?php if ($row_Recordset1['NUM_PASSPORT']=="") echo $dateee; else echo $row_Recordset1['DATE_EMISSION_PASS'];?>" readonly="readonly"/>
            <br />
            </label>
            <label class="style14"></label>
            <label>
            <input type="text" name="DATE_EXPIRATION_PASS" id="DATE_EXPIRATION_PASS" value="<?php if ($row_Recordset1['NUM_PASSPORT']=="") echo $dfinal; else echo $row_Recordset1['DATE_EXPIRATION_PASS'];?>" readonly="readonly"/>
            </label>
          </span></td>
        </tr>
        <tr class="style14">
          <td>LIEU EMISSION</td>
          <td colspan="2"><input name="LIEU_EMISSION_PASS" style="text-transform:uppercase" type="text" class="style14" id="LIEU_EMISSION_PASS" value="<?php echo $row_Recordset1['LIEU_EMISSION_PASS']; ?>" size="30"<?php if (($groupe != "operateur ime")&&($groupe != "administrateur ime")){?>readonly="readonly"<?php } ?>/></td>
          <td colspan="2" class="style14">EMAIL</td>
          <td colspan="2">
            <input name="email1" type="text" style="text-transform:lowercase" class="style14" id="email1" value="<?php echo $row_Recordset1['EMAIL1']; ?>" />
            <input name="email2" type="text" style="text-transform:lowercase" class="style14" id="email2" value="<?php echo $row_Recordset1['EMAIL2']; ?>" />
</td>
        </tr>
        <tr class="style14">
          <td>PHOTO INDIVIDU</td>
          <td colspan="2"><input type="file" name="PHOTO_PASS" id="PHOTO_PASS" <?php if (($groupe != "operateur ime")&&($groupe != "administrateur ime")){?>disabled="disabled" <?php } ?>/></td>
          <td colspan="2" class="style14">&nbsp;</td>
          <td colspan="2">&nbsp;</td>
        </tr>
                    
                    

        <tr class="style14">
          <td colspan="7"><div align="center"><strong>Info adresse</strong></div></td>
        </tr>
        <tr class="style14">
          <td colspan="7"><p><a href="javascript:void(null)" onclick="javascript:activate()">Cliquer sur ce lien pour changer l'adresse!!!</a></p>
            <p class="style16"><span class="style16 style14">NUMERO EDIFICE </span>
              <input name="NUMERO_EDIFICE" type="text" disabled="disabled" class="style14" id="NUMERO_EDIFICE" value="<?php echo $row_Recordset1['NUM_EDIFICE']; ?>" size="10" />
  &nbsp; &nbsp; NOM RUE
  <input name="NOM_RUE" type="text"  disabled="disabled" class="style14" id="NOM_RUE" value="<?php echo $row_Recordset1['NOM_RUE']; ?>" size="55" style="text-transform:uppercase"/>
              <label>
              <input name="ID_SECCOM" type="hidden"  disabled="disabled" class="style14" id="ID_SECCOM" value="<?php echo $row_Recordset1['ID_SECCOM']; ?>"/>
              </label>
            </p></td>
        </tr>
        <tr class="style14">
          <td colspan="7"><div id="addr" style="display:none" ><?php 
							  
include_once("DynamicDropDown.class.php");    //Includes the Class file to this example Script.
$dForm = new DynamicDropDown($dbConfig);      //Creates and Object to the Script
$dFormName = "form2";                         //Assign a NAME for the Form which we will be using in this Example Script
$dForm->DataFetch();                          //Call to the DataFetch method, which will Fetch the data from the Tables.
$dForm->CreateJavaScript($dFormName);         //Call to the CreateJavaScript method,which will dynamically creates the Javascript which loads the Data to the List Box
//echo "<form name=\"$dFormName\" method=\"post\">";  //Creates a New form on this Page
$dForm->CreateListBox();                      //Call to the Member Function which will create the Form Object
//echo "</form>";                               // Close the Form
$dForm->DynamicDropDown_Close();   //Call to the Destructor type of function

				?></div></td>
        </tr>
      </table>
                  
      <input name="DATEH_NAIS" type="hidden" id="DATEH_NAIS" value="<?php echo date ('Y-m-d H:i:s',$date);?>" />
              
      <input type="hidden" name="ID_IND" id="ID_IND" value="<?php echo $colname_Recordset1;?>"/>
      <input name="ID_ADRESSE" type="hidden" id="ID_ADRESSE" value="<?php echo $row_Recordset1['ID_ADRESSE']; ?>" />
      <input name="ID_COORD" type="hidden" id="ID_COORD" value="<?php echo $row_Recordset1['ID_COORD']; ?>" />
      <label></label>
<div align="center">
        <input type="reset" name="Reset" id="button" value="Reset" />
        <input type="submit" name="button2" id="button2" value="Enregistrer" />
      </div>
      </label>
      <p align="center">&nbsp;</p>
      <p align="center">&nbsp;</p>
                  
        <input type="hidden" name="MM_update" value="form2" />
<input type="hidden" name="MM_update" value="form2" />
</form>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
  </div>
  <?php
	}
else 
	echo "".$nomutil."<br>";
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
mysql_free_result($Recordset1);

mysql_free_result($COMMUNE);

mysql_free_result($Recordset2);
?>
