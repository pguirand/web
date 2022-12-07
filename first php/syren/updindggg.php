<?php require_once('Connections/connex.php'); ?>
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
$target_pathcin2 = $target_pathcin.basename($_FILES['PHOTO_CIN']['name']);
$photo_namepass = $_FILES['PHOTO_PASS']['name'];
$target_pathpass = "images/photos/individus/photo";
$target_pathpass2 = $target_pathcin.basename($_FILES['PHOTO_PASS']['name']);
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
                       GetSQLValueString($photo_name, "text"),
                       GetSQLValueString($_POST['PHOTO_CIN'], "text"),
                       GetSQLValueString($_POST['PHOTO_PASS'], "text"),
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
  $updateSQL = sprintf("UPDATE coordonnees SET NUM_TEL1=%s, NUM_TEL2=%s, NUM_TEL3=%s, NUM_TEL4=%s, CHAMP_MODIFIE_PAR=%s WHERE ID_IND=%s",
                       GetSQLValueString($_POST['NUM_TEL1'], "text"),
                       GetSQLValueString($_POST['NUM_TEL2'], "text"),
                       GetSQLValueString($_POST['NUM_TEL3'], "text"),
                       GetSQLValueString($_POST['NUM_TEL4'], "text"),
					   GetSQLValueString($IDutil, "int"),					   
                       GetSQLValueString($_POST['ID_IND'], "text"));

  mysql_select_db($database_connex, $connex);
  $Result1 = mysql_query($updateSQL, $connex) or die(mysql_error());
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE adresse SET NOM_RUE=%s, NUM_EDIFICE=%s, ID_SECCOM=%s, CHAMP_MODIFIE_PAR=%s WHERE ID_IND=%s",
                       GetSQLValueString($_POST['NOM_RUE'], "text"),
                       GetSQLValueString($_POST['NUMERO_EDIFICE'], "int"),
                       GetSQLValueString($_POST['ID_SECCOM'], "int"),
                       GetSQLValueString($_POST['ID_UTIL'], "int"),
                       GetSQLValueString($_POST['ID_IND'], "text"));

  mysql_select_db($database_connex, $connex);
  $Result1 = mysql_query($updateSQL, $connex) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO emploie (ID_IND, POSTE, CHAMP_CREE_PAR) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['ID_IND'], "text"),
                       GetSQLValueString($_POST['poste'], "text"),
                       GetSQLValueString($_POST['ID_UTIL'], "int"));

  mysql_select_db($database_connex, $connex);
  $Result1 = mysql_query($insertSQL, $connex) or die(mysql_error());
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

$colname_Recordset3 = "-1";
if (isset($_GET['ID_IND'])) {
  $colname_Recordset3 = $_GET['ID_IND'];
}
mysql_select_db($database_connex, $connex);
$query_Recordset3 = sprintf("SELECT * FROM emploie WHERE emploie.ID_IND = %s", GetSQLValueString($colname_Recordset3, "text"));
$Recordset3 = mysql_query($query_Recordset3, $connex) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

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
document.getElementById('NUMERO_EDIFICE').readOnly=false;
document.getElementById('NOM_RUE').readOnly=false;
document.getElementById('ID_SECCOM').readOnly=false;
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