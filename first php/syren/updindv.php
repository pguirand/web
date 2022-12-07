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

mysql_select_db($database_connex, $connex);
$query_loggedUser = "SELECT * FROM utilisateur WHERE NOM_UTIL = '$nomutili'";
$loggedUser = mysql_query($query_loggedUser, $connex) or die(mysql_error());
$row_loggedUser = mysql_fetch_assoc($loggedUser);
$IDutil=$row_loggedUser['ID_UTIL'];
$totalRows_loggedUser = mysql_num_rows($loggedUser);

$colname_Recordset1 = "-1";
if (isset($_GET['ID_IND'])) {
 echo $colname_Recordset1 = $_GET['ID_IND'];
}
$colname_Recordset1 = "-1";
if (isset($_GET['ID_IND'])) {
  $colname_Recordset1 = $_GET['ID_IND'];
}
mysql_select_db($database_connex, $connex);
$query_Recordset1 = sprintf("SELECT * FROM individu, `document`, adresse, sectioncom WHERE individu.ID_IND = %s AND individu.ID_IND=`document`.ID_IND and individu.ID_IND=adresse.ID_IND and adresse.ID_SECCOM=sectioncom.ID_SECCOM ORDER BY individu.ID_IND ASC", GetSQLValueString($colname_Recordset1, "text"));
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
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE adresse SET NOM_RUE=%s, NUM_EDIFICE=%s, ID_IND=%s WHERE ID_ADRESSE=%s",
                       GetSQLValueString($_POST['NOM_RUE'], "text"),
                       GetSQLValueString($_POST['NUMERO_EDIFICE'], "int"),
                       GetSQLValueString($_POST['ID_IND'], "text"),
                       GetSQLValueString($_POST['ID_ADRESSE'], "int"));

  mysql_select_db($database_connex, $connex);
  $Result1 = mysql_query($updateSQL, $connex) or die(mysql_error());

  $updateGoTo = "updindok.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

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
/*$formatdnif = date ('Y-m-j',$datenif);
$formatdcif = date ('Y-m-j',$datecif);
$formatdpass = date ('Y-m-j',$datepass);*/


if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE individu SET G_SANG_IND=%s, SEXE_IND=%s, NOM_IND=%s, NOM_JEUNE_FILLE=%s, PRENOM_IND=%s, NUM_NIF=%s, DATE_EXPIRATION_NIF=%s, LIEU_EMISSION_NIF=%s, NUM_CIF=%s, NUM_PASSPORT=%s, LIEU_EMISSION_PASS=%s, NATIONALITE_INDIVIDU=%s, EMAIL1=%s WHERE ID_IND=%s",
                       GetSQLValueString($_POST['G_SANG_IND'], "text"),
                       GetSQLValueString($_POST['SEXE_IND'], "text"),
                       GetSQLValueString($_POST['NOM_IND'], "text"),
                       GetSQLValueString($_POST['NOM_JEUNE_FILLE'], "text"),
                       GetSQLValueString($_POST['PRENOM_IND'], "text"),
                       GetSQLValueString($_POST['NUM_NIF'], "text"),
                       GetSQLValueString($_POST['ID_IND'], "text"),
                       GetSQLValueString($_POST['LIEU_EMISSION_NIF'], "text"),
                       GetSQLValueString($_POST['NUM_CIF'], "text"),
                       GetSQLValueString($_POST['NUM_PASSPORT'], "text"),
                       GetSQLValueString($_POST['LIEU_EMISSION_PASS'], "text"),
                       GetSQLValueString($_POST['NATIONALITE_INDIVIDU'], "text"),
                       GetSQLValueString($_POST['email1'], "text"),
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO coordonnees (NUM_TEL1, NUM_TEL2, NUM_TEL3, NUM_TEL4, ID_IND) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['NUM_TEL1'], "text"),
                       GetSQLValueString($_POST['NUM_TEL2'], "text"),
                       GetSQLValueString($_POST['NUM_TEL3'], "text"),
                       GetSQLValueString($_POST['NUM_TEL4'], "text"),
                       GetSQLValueString($_POST['ID_IND'], "text"));

  mysql_select_db($database_connex, $connex);
  $Result1 = mysql_query($insertSQL, $connex) or die(mysql_error());
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
          <div id="search">
            <form action="<?php echo $searchAction ?>">
              <label>Recherche Rapide </label>
              <p>
                <input name="search" type="text" value="<?php echo $_GET['search'] ?>" />
              </p>
              <table width="167">
                <tr>
                  <td width="60"><label>
                    <input name="rech" type="radio" value="ent" checked="checked" />
                    <span class="style10">Entites</span></label></td>
                  <td width="95"><input type="radio" name="rech" value="publ" />
                      <span class="style10">Publications</span></td>
                </tr>
              </table>
              <p>
                <input name="goButton" type="submit" value="Lancer la recherche" />
              </p>
            </form>
          </div>
		  <div id="section">
<?php
if($_SESSION['MM_Username'] == "")
			{
			?>
              <form id="form1" name="form1" method="POST" action="<?php echo $loginFormAction; ?>">
                <table border="0">
                  <tr>
                    <td colspan="2"><div align="center" class="style13"><strong>Connexion</strong></div></td>
                  </tr>
                  <tr>
                    <td><span class="style13">Utilisateur</span></td>
<td><label>
                      <input name="NOM_UTIL" type="text" id="NOM_UTIL" size="15" />
                    </label></td>
                  </tr>
                  <tr>
                    <td><span class="style12 style13">Mot de passe </span></td>
<td><label>
                      <input name="MOT_PASS" type="password" id="MOT_PASS" size="15" />
                    </label></td>
                  </tr>
                </table>
                <br />
                <label>
               
                  <input type="submit" name="Submit" value="Connexion" />
                </label>
                <p><?php echo $warning; ?></p>
                <p align="center"><a href="#">Mot de passe oubli&eacute;?</a></p>
              </form>
              <?php
			  }
			  ?>
	      </div>
		  <div class="section">
            <div class="title">Actualit&eacute;s </div>
		    <ul><li></li>
		      <li></li>
		      <li><a href="entites.php?type=nongouv">
		        <!--<a href="javascript:ajaxpage('entites.php', 'content');">-->
		        </a></li>
		      <li><a href="actugen.php?">G&eacute;n&eacute;rales</a><a href="#"></a></li>
              <li><a href="entites.php?type=nongouv">Sport</a><a href="#"></a></li>
		      <li><a href="#">Culture</a></li>
	          <li><a href="#">A travers le monde...</a></li>
		    </ul>
      </div>
		  <div class="section">
            <div class="title">Forums</div>
		    <ul>
              <li>S'inscrire</li>
		      <li>Rechercher</li>
		      <li>Participer<a href="#">.</a></li>
	          <li>Visiter</li>
		    </ul>
      </div>
      <div class="section">
            <div class="title">Divers</div>
		    <ul>
              <li>Statistiques sur individus</li>
		      <li>Statitisques sur entites</li>
		      <li>Autres Statisques</li>
	          <li>Centre de sondages</li>
		    </ul>
      </div>
  </div>
	  </div>
	        
<div id="right">
 <?php 
include_once("menuh.php");
?>
  <?php
if($_GET['search'] == "")
	{
?>
  <h3>&nbsp;</h3>
  <div class="story">
    <p>&nbsp;</p>
    <div align="center" class="fonce">FORMULAIRE D'ENREGISTREMENT D'UN INDIVIDU</div></p>
    <p>&nbsp;</p>
    <form action="<?php echo $editFormAction; ?>" id="form2" name="form2" method="POST">
      <table width="732" border="0" align="center" cellpadding="0" cellspacing="0" id="midTable">
        <tr class="head">
          <td colspan="7"><div align="center" class="fonce">INFORMATIONS A REMPLIR</div></td>
        </tr>
        <tr class="style14">
          <td><span class="style14 style10 style10 style10 style10">NUMERO DOCUMENT</span></td>
        <td colspan="3"><input name="NO_DOC" type="text" class="style10 style10 style10 style10" id="NO_DOC" value="<?php echo $row_Recordset1['NO_DOC']; ?>" size="25" readonly="readonly"/> 
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
          <td>NUMERO NIF</td>
          <td colspan="3"><input name="NUM_NIF" type="text" class="style14" id="NUM_NIF" value="<?php echo strtoupper($row_Recordset1['NUM_NIF']); ?>"<?php if (($groupe != "operateur dgi")&&($groupe != "administrateur dgi")){?> readonly="readonly"<?php } ?>/></td>
          <td>NUMERO CIN</td>
          <td colspan="2"><input name="NUM_CIF" type="text" class="style14" id="NUM_CIF" value="<?php echo $row_Recordset1['NUM_CIF']; ?>"<?php if (($groupe != "operateur oni")&&($groupe != "administrateur oni")){?> readonly="readonly"<?php } ?>/></td>
        </tr>
        <tr class="style14">
          <td>DATE EXP</td>
          <td colspan="3"><span class="style14 style10 style10 style10 style10">
            <label class="style14">JOUR
            <select name="jour" class="style14" id="jour" <?php if (($groupe != "operateur dgi")&&($groupe != "administrateur dgi")){?>disabled="disabled" <?php } ?> >
              <option>01</option>
              <option>02</option>
              <option>03</option>
              <option>04</option>
              <option>05</option>
              <option>06</option>
              <option>07</option>
              <option>08</option>
              <option>09</option>
              <option>10</option>
              <option>11</option>
              <option>12</option>
              <option>13</option>
              <option>14</option>
              <option>15</option>
              <option>16</option>
              <option>17</option>
              <option>18</option>
              <option>19</option>
              <option>20</option>
              <option>21</option>
              <option>22</option>
              <option>23</option>
              <option>24</option>
              <option>25</option>
              <option>26</option>
              <option>27</option>
              <option>28</option>
              <option>29</option>
              <option>30</option>
              <option>31</option>
            </select>
&nbsp;MOIS
<select name="mois" class="style14" id="mois" <?php if (($groupe != "operateur dgi")&&($groupe != "administrateur dgi")){?> disabled="disabled"<?php } ?>>
  <option>01</option>
  <option>02</option>
  <option>03</option>
  <option>04</option>
  <option>05</option>
  <option>06</option>
  <option>07</option>
  <option>08</option>
  <option>09</option>
  <option>10</option>
  <option>11</option>
  <option>12</option>
</select>
&nbsp;ANNEE
<select name="an" class="style14" id="an" <?php if (($groupe != "operateur dgi")&&($groupe != "administrateur dgi")){?> disabled="disabled"<?php } ?>>
  <option>1800</option>
  <option>1801</option>
  <option>1802</option>
  <option>1803</option>
  <option>1804</option>
  <option>1805</option>
  <option>1806</option>
  <option>1807</option>
  <option>1808</option>
  <option>1809</option>
  <option>1810</option>
  <option>1811</option>
  <option>1812</option>
  <option>1813</option>
  <option>1814</option>
  <option>1815</option>
  <option>1816</option>
  <option>1817</option>
  <option>1818</option>
  <option>1819</option>
  <option>1820</option>
  <option>1821</option>
  <option>1822</option>
  <option>1823</option>
  <option>1824</option>
  <option>1825</option>
  <option>1826</option>
  <option>1827</option>
  <option>1828</option>
  <option>1829</option>
  <option>1830</option>
  <option>1831</option>
  <option>1832</option>
  <option>1833</option>
  <option>1834</option>
  <option>1835</option>
  <option>1836</option>
  <option>1837</option>
  <option>1838</option>
  <option>1839</option>
  <option>1840</option>
  <option>1841</option>
  <option>1842</option>
  <option>1843</option>
  <option>1844</option>
  <option>1845</option>
  <option>1846</option>
  <option>1847</option>
  <option>1848</option>
  <option>1849</option>
  <option>1850</option>
  <option>1851</option>
  <option>1852</option>
  <option>1853</option>
  <option>1854</option>
  <option>1855</option>
  <option>1856</option>
  <option>1857</option>
  <option>1858</option>
  <option>1859</option>
  <option>1860</option>
  <option>1861</option>
  <option>1862</option>
  <option>1863</option>
  <option>1864</option>
  <option>1865</option>
  <option>1866</option>
  <option>1867</option>
  <option>1868</option>
  <option>1869</option>
  <option>1870</option>
  <option>1871</option>
  <option>1872</option>
  <option>1873</option>
  <option>1874</option>
  <option>1875</option>
  <option>1876</option>
  <option>1877</option>
  <option>1878</option>
  <option>1879</option>
  <option>1880</option>
  <option>1881</option>
  <option>1882</option>
  <option>1883</option>
  <option>1884</option>
  <option>1885</option>
  <option>1886</option>
  <option>1887</option>
  <option>1888</option>
  <option>1889</option>
  <option>1890</option>
  <option>1891</option>
  <option>1892</option>
  <option>1893</option>
  <option>1894</option>
  <option>1895</option>
  <option>1896</option>
  <option>1897</option>
  <option>1898</option>
  <option>1899</option>
  <option>1900</option>
  <option>1901</option>
  <option>1902</option>
  <option>1903</option>
  <option>1904</option>
  <option>1905</option>
  <option>1906</option>
  <option>1907</option>
  <option>1908</option>
  <option>1909</option>
  <option>1910</option>
  <option>1911</option>
  <option>1912</option>
  <option>1913</option>
  <option>1914</option>
  <option>1915</option>
  <option>1916</option>
  <option>1917</option>
  <option>1918</option>
  <option>1919</option>
  <option>1920</option>
  <option>1921</option>
  <option>1922</option>
  <option>1923</option>
  <option>1924</option>
  <option>1925</option>
  <option>1926</option>
  <option>1927</option>
  <option>1928</option>
  <option>1929</option>
  <option>1930</option>
  <option>1931</option>
  <option>1932</option>
  <option>1933</option>
  <option>1934</option>
  <option>1935</option>
  <option>1936</option>
  <option>1937</option>
  <option>1938</option>
  <option>1939</option>
  <option>1940</option>
  <option>1941</option>
  <option>1942</option>
  <option>1943</option>
  <option>1944</option>
  <option>1945</option>
  <option>1946</option>
  <option>1947</option>
  <option>1948</option>
  <option>1949</option>
  <option>1950</option>
  <option>1951</option>
  <option>1952</option>
  <option>1953</option>
  <option>1954</option>
  <option>1955</option>
  <option>1956</option>
  <option>1957</option>
  <option>1958</option>
  <option>1959</option>
  <option selected="selected">1960</option>
  <option>1961</option>
  <option>1962</option>
  <option>1963</option>
  <option>1964</option>
  <option>1965</option>
  <option>1966</option>
  <option>1967</option>
  <option>1968</option>
  <option>1969</option>
  <option>1970</option>
  <option>1971</option>
  <option>1972</option>
  <option>1973</option>
  <option>1974</option>
  <option>1975</option>
  <option>1976</option>
  <option>1977</option>
  <option>1978</option>
  <option>1979</option>
  <option>1980</option>
  <option>1981</option>
  <option>1982</option>
  <option>1983</option>
  <option>1984</option>
  <option>1985</option>
  <option>1986</option>
  <option>1987</option>
  <option>1988</option>
  <option>1989</option>
  <option>1990</option>
  <option>1991</option>
  <option>1992</option>
  <option>1993</option>
  <option>1994</option>
  <option>1995</option>
  <option>1996</option>
  <option>1997</option>
  <option>1998</option>
  <option>1999</option>
  <option>2000</option>
  <option>2001</option>
  <option>2002</option>
  <option>2003</option>
  <option>2004</option>
  <option>2005</option>
  <option>2006</option>
  <option>2007</option>
  <option>2008</option>
  <option>2009</option>
  <option>2010</option>
  <option>2011</option>
  <option>2012</option>
  <option>2013</option>
  <option>2014</option>
  <option>2015</option>
  <option>2016</option>
  <option>2017</option>
  <option>2018</option>
  <option>2019</option>
  <option>2020</option>
</select>
            </label>
          </span></td>
          <td>DATE EXP</td>
          <td colspan="2">JOUR
            <select name="jour2" class="style14" id="jour2" <?php if (($groupe != "operateur oni")&&($groupe != "administrateur oni")){?>disabled="disabled" <?php } ?>>
              <option>01</option>
              <option>02</option>
              <option>03</option>
              <option>04</option>
              <option>05</option>
              <option>06</option>
              <option>07</option>
              <option>08</option>
              <option>09</option>
              <option>10</option>
              <option>11</option>
              <option>12</option>
              <option>13</option>
              <option>14</option>
              <option>15</option>
              <option>16</option>
              <option>17</option>
              <option>18</option>
              <option>19</option>
              <option>20</option>
              <option>21</option>
              <option>22</option>
              <option>23</option>
              <option>24</option>
              <option>25</option>
              <option>26</option>
              <option>27</option>
              <option>28</option>
              <option>29</option>
              <option>30</option>
              <option>31</option>
            </select>
MOIS
<select name="mois2" class="style14" id="mois2" <?php if (($groupe != "operateur oni")&&($groupe != "administrateur oni")){?> disabled="disabled"<?php } ?>>
  <option>01</option>
  <option>02</option>
  <option>03</option>
  <option>04</option>
  <option>05</option>
  <option>06</option>
  <option>07</option>
  <option>08</option>
  <option>09</option>
  <option>10</option>
  <option>11</option>
  <option>12</option>
</select>
&nbsp;ANNEE
<select name="an2" class="style14" id="an2" <?php if (($groupe != "operateur oni")&&($groupe != "administrateur oni")){?>disabled="disabled" <?php } ?>>
  <option>1800</option>
  <option>1801</option>
  <option>1802</option>
  <option>1803</option>
  <option>1804</option>
  <option>1805</option>
  <option>1806</option>
  <option>1807</option>
  <option>1808</option>
  <option>1809</option>
  <option>1810</option>
  <option>1811</option>
  <option>1812</option>
  <option>1813</option>
  <option>1814</option>
  <option>1815</option>
  <option>1816</option>
  <option>1817</option>
  <option>1818</option>
  <option>1819</option>
  <option>1820</option>
  <option>1821</option>
  <option>1822</option>
  <option>1823</option>
  <option>1824</option>
  <option>1825</option>
  <option>1826</option>
  <option>1827</option>
  <option>1828</option>
  <option>1829</option>
  <option>1830</option>
  <option>1831</option>
  <option>1832</option>
  <option>1833</option>
  <option>1834</option>
  <option>1835</option>
  <option>1836</option>
  <option>1837</option>
  <option>1838</option>
  <option>1839</option>
  <option>1840</option>
  <option>1841</option>
  <option>1842</option>
  <option>1843</option>
  <option>1844</option>
  <option>1845</option>
  <option>1846</option>
  <option>1847</option>
  <option>1848</option>
  <option>1849</option>
  <option>1850</option>
  <option>1851</option>
  <option>1852</option>
  <option>1853</option>
  <option>1854</option>
  <option>1855</option>
  <option>1856</option>
  <option>1857</option>
  <option>1858</option>
  <option>1859</option>
  <option>1860</option>
  <option>1861</option>
  <option>1862</option>
  <option>1863</option>
  <option>1864</option>
  <option>1865</option>
  <option>1866</option>
  <option>1867</option>
  <option>1868</option>
  <option>1869</option>
  <option>1870</option>
  <option>1871</option>
  <option>1872</option>
  <option>1873</option>
  <option>1874</option>
  <option>1875</option>
  <option>1876</option>
  <option>1877</option>
  <option>1878</option>
  <option>1879</option>
  <option>1880</option>
  <option>1881</option>
  <option>1882</option>
  <option>1883</option>
  <option>1884</option>
  <option>1885</option>
  <option>1886</option>
  <option>1887</option>
  <option>1888</option>
  <option>1889</option>
  <option>1890</option>
  <option>1891</option>
  <option>1892</option>
  <option>1893</option>
  <option>1894</option>
  <option>1895</option>
  <option>1896</option>
  <option>1897</option>
  <option>1898</option>
  <option>1899</option>
  <option>1900</option>
  <option>1901</option>
  <option>1902</option>
  <option>1903</option>
  <option>1904</option>
  <option>1905</option>
  <option>1906</option>
  <option>1907</option>
  <option>1908</option>
  <option>1909</option>
  <option>1910</option>
  <option>1911</option>
  <option>1912</option>
  <option>1913</option>
  <option>1914</option>
  <option>1915</option>
  <option>1916</option>
  <option>1917</option>
  <option>1918</option>
  <option>1919</option>
  <option>1920</option>
  <option>1921</option>
  <option>1922</option>
  <option>1923</option>
  <option>1924</option>
  <option>1925</option>
  <option>1926</option>
  <option>1927</option>
  <option>1928</option>
  <option>1929</option>
  <option>1930</option>
  <option>1931</option>
  <option>1932</option>
  <option>1933</option>
  <option>1934</option>
  <option>1935</option>
  <option>1936</option>
  <option>1937</option>
  <option>1938</option>
  <option>1939</option>
  <option>1940</option>
  <option>1941</option>
  <option>1942</option>
  <option>1943</option>
  <option>1944</option>
  <option>1945</option>
  <option>1946</option>
  <option>1947</option>
  <option>1948</option>
  <option>1949</option>
  <option>1950</option>
  <option>1951</option>
  <option>1952</option>
  <option>1953</option>
  <option>1954</option>
  <option>1955</option>
  <option>1956</option>
  <option>1957</option>
  <option>1958</option>
  <option>1959</option>
  <option selected="selected">1960</option>
  <option>1961</option>
  <option>1962</option>
  <option>1963</option>
  <option>1964</option>
  <option>1965</option>
  <option>1966</option>
  <option>1967</option>
  <option>1968</option>
  <option>1969</option>
  <option>1970</option>
  <option>1971</option>
  <option>1972</option>
  <option>1973</option>
  <option>1974</option>
  <option>1975</option>
  <option>1976</option>
  <option>1977</option>
  <option>1978</option>
  <option>1979</option>
  <option>1980</option>
  <option>1981</option>
  <option>1982</option>
  <option>1983</option>
  <option>1984</option>
  <option>1985</option>
  <option>1986</option>
  <option>1987</option>
  <option>1988</option>
  <option>1989</option>
  <option>1990</option>
  <option>1991</option>
  <option>1992</option>
  <option>1993</option>
  <option>1994</option>
  <option>1995</option>
  <option>1996</option>
  <option>1997</option>
  <option>1998</option>
  <option>1999</option>
  <option>2000</option>
  <option>2001</option>
  <option>2002</option>
  <option>2003</option>
  <option>2004</option>
  <option>2005</option>
  <option>2006</option>
  <option>2007</option>
  <option>2008</option>
  <option>2009</option>
  <option>2010</option>
  <option>2011</option>
  <option>2012</option>
  <option>2013</option>
  <option>2014</option>
  <option>2015</option>
  <option>2016</option>
  <option>2017</option>
  <option>2018</option>
  <option>2019</option>
  <option>2020</option>
</select></td>
        </tr>
        <tr class="style14">
          <td>LIEU EMISSION</td>
          <td colspan="3"><label>
            <input name="LIEU_EMISSION_NIF" type="text" class="style14" id="LIEU_EMISSION_NIF" value="<?php echo $row_Recordset1['LIEU_EMISSION_NIF']; ?>" size="30" <?php if (($groupe != "operateur dgi")&&($groupe != "administrateur dgi")){?>readonly="readonly"<?php } ?>/>
          </label></td>
          <td>LIEU EMISSION</td>
          <td colspan="2"><input name="LIEU_EMISSION_CIN" type="text" class="style14" id="LIEU_EMISSION_CIN" value="<?php echo $row_Recordset1['LIEU_EMISSION_CIF']; ?>" size="30"<?php if (($groupe != "operateur oni")&&($groupe != "administrateur oni")){?>readonly="readonly"<?php } ?>/></td>
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
          <td>No passeport</td>
          <td colspan="2"><input name="NUM_PASSPORT" type="text" class="style14" id="NUM_PASSPORT" value="<?php echo $row_Recordset1['NUM_PASSPORT']; ?>" <?php if (($groupe != "operateur ime")&&($groupe != "administrateur ime")){?>readonly="readonly" <?php } ?>/></td>
          <td colspan="2" rowspan="2" class="style14">NUMERO DE TELEPHONE</td>
          <td colspan="2" rowspan="2"><label>
            <span class="style14">
            <input name="NUM_TEL1" type="text" class="style14" id="NUM_TEL1" value="<?php echo $row_Recordset2['NUM_TEL1']; ?>" />
            <input name="NUM_TEL2" type="text" class="style14" id="NUM_TEL2" value="<?php echo $row_Recordset2['NUM_TEL2']; ?>" />
            </span></label>
            <span class="style14">
            <input name="NUM_TEL3" type="text" class="style14" id="NUM_TEL3" value="<?php echo $row_Recordset2['NUM_TEL3']; ?>" />
            </span>
            <input name="NUM_TEL4" type="text" class="style14" id="NUM_TEL4" value="<?php echo $row_Recordset2['NUM_TEL4']; ?>" /></td>
        </tr>
        <tr class="style14">
          <td>DATE EXP</td>
          <td colspan="2">JOUR
            <select name="jour3" class="style14" id="jour3"<?php if (($groupe != "operateur ime")&&($groupe != "administrateur ime")){?>disabled="disabled"<?php } ?>>
              <option>01</option>
              <option>02</option>
              <option>03</option>
              <option>04</option>
              <option>05</option>
              <option>06</option>
              <option>07</option>
              <option>08</option>
              <option>09</option>
              <option>10</option>
              <option>11</option>
              <option>12</option>
              <option>13</option>
              <option>14</option>
              <option>15</option>
              <option>16</option>
              <option>17</option>
              <option>18</option>
              <option>19</option>
              <option>20</option>
              <option>21</option>
              <option>22</option>
              <option>23</option>
              <option>24</option>
              <option>25</option>
              <option>26</option>
              <option>27</option>
              <option>28</option>
              <option>29</option>
              <option>30</option>
              <option>31</option>
                                                </select>
&nbsp;MOIS
<select name="mois3" class="style14" id="mois3"<?php if (($groupe != "operateur ime")&&($groupe != "administrateur ime")){?>disabled="disabled"<?php } ?>>
  <option>01</option>
  <option>02</option>
  <option>03</option>
  <option>04</option>
  <option>05</option>
  <option>06</option>
  <option>07</option>
  <option>08</option>
  <option>09</option>
  <option>10</option>
  <option>11</option>
  <option>12</option>
</select>
ANNEE
<select name="an3" class="style14" id="an3"<?php if (($groupe != "operateur ime")&&($groupe != "administrateur ime")){?> disabled="disabled"<?php } ?>>
  <option>1800</option>
  <option>1801</option>
  <option>1802</option>
  <option>1803</option>
  <option>1804</option>
  <option>1805</option>
  <option>1806</option>
  <option>1807</option>
  <option>1808</option>
  <option>1809</option>
  <option>1810</option>
  <option>1811</option>
  <option>1812</option>
  <option>1813</option>
  <option>1814</option>
  <option>1815</option>
  <option>1816</option>
  <option>1817</option>
  <option>1818</option>
  <option>1819</option>
  <option>1820</option>
  <option>1821</option>
  <option>1822</option>
  <option>1823</option>
  <option>1824</option>
  <option>1825</option>
  <option>1826</option>
  <option>1827</option>
  <option>1828</option>
  <option>1829</option>
  <option>1830</option>
  <option>1831</option>
  <option>1832</option>
  <option>1833</option>
  <option>1834</option>
  <option>1835</option>
  <option>1836</option>
  <option>1837</option>
  <option>1838</option>
  <option>1839</option>
  <option>1840</option>
  <option>1841</option>
  <option>1842</option>
  <option>1843</option>
  <option>1844</option>
  <option>1845</option>
  <option>1846</option>
  <option>1847</option>
  <option>1848</option>
  <option>1849</option>
  <option>1850</option>
  <option>1851</option>
  <option>1852</option>
  <option>1853</option>
  <option>1854</option>
  <option>1855</option>
  <option>1856</option>
  <option>1857</option>
  <option>1858</option>
  <option>1859</option>
  <option>1860</option>
  <option>1861</option>
  <option>1862</option>
  <option>1863</option>
  <option>1864</option>
  <option>1865</option>
  <option>1866</option>
  <option>1867</option>
  <option>1868</option>
  <option>1869</option>
  <option>1870</option>
  <option>1871</option>
  <option>1872</option>
  <option>1873</option>
  <option>1874</option>
  <option>1875</option>
  <option>1876</option>
  <option>1877</option>
  <option>1878</option>
  <option>1879</option>
  <option>1880</option>
  <option>1881</option>
  <option>1882</option>
  <option>1883</option>
  <option>1884</option>
  <option>1885</option>
  <option>1886</option>
  <option>1887</option>
  <option>1888</option>
  <option>1889</option>
  <option>1890</option>
  <option>1891</option>
  <option>1892</option>
  <option>1893</option>
  <option>1894</option>
  <option>1895</option>
  <option>1896</option>
  <option>1897</option>
  <option>1898</option>
  <option>1899</option>
  <option>1900</option>
  <option>1901</option>
  <option>1902</option>
  <option>1903</option>
  <option>1904</option>
  <option>1905</option>
  <option>1906</option>
  <option>1907</option>
  <option>1908</option>
  <option>1909</option>
  <option>1910</option>
  <option>1911</option>
  <option>1912</option>
  <option>1913</option>
  <option>1914</option>
  <option>1915</option>
  <option>1916</option>
  <option>1917</option>
  <option>1918</option>
  <option>1919</option>
  <option>1920</option>
  <option>1921</option>
  <option>1922</option>
  <option>1923</option>
  <option>1924</option>
  <option>1925</option>
  <option>1926</option>
  <option>1927</option>
  <option>1928</option>
  <option>1929</option>
  <option>1930</option>
  <option>1931</option>
  <option>1932</option>
  <option>1933</option>
  <option>1934</option>
  <option>1935</option>
  <option>1936</option>
  <option>1937</option>
  <option>1938</option>
  <option>1939</option>
  <option>1940</option>
  <option>1941</option>
  <option>1942</option>
  <option>1943</option>
  <option>1944</option>
  <option>1945</option>
  <option>1946</option>
  <option>1947</option>
  <option>1948</option>
  <option>1949</option>
  <option>1950</option>
  <option>1951</option>
  <option>1952</option>
  <option>1953</option>
  <option>1954</option>
  <option>1955</option>
  <option>1956</option>
  <option>1957</option>
  <option>1958</option>
  <option>1959</option>
  <option selected="selected">1960</option>
  <option>1961</option>
  <option>1962</option>
  <option>1963</option>
  <option>1964</option>
  <option>1965</option>
  <option>1966</option>
  <option>1967</option>
  <option>1968</option>
  <option>1969</option>
  <option>1970</option>
  <option>1971</option>
  <option>1972</option>
  <option>1973</option>
  <option>1974</option>
  <option>1975</option>
  <option>1976</option>
  <option>1977</option>
  <option>1978</option>
  <option>1979</option>
  <option>1980</option>
  <option>1981</option>
  <option>1982</option>
  <option>1983</option>
  <option>1984</option>
  <option>1985</option>
  <option>1986</option>
  <option>1987</option>
  <option>1988</option>
  <option>1989</option>
  <option>1990</option>
  <option>1991</option>
  <option>1992</option>
  <option>1993</option>
  <option>1994</option>
  <option>1995</option>
  <option>1996</option>
  <option>1997</option>
  <option>1998</option>
  <option>1999</option>
  <option>2000</option>
  <option>2001</option>
  <option>2002</option>
  <option>2003</option>
  <option>2004</option>
  <option>2005</option>
  <option>2006</option>
  <option>2007</option>
  <option>2008</option>
  <option>2009</option>
  <option>2010</option>
  <option>2011</option>
  <option>2012</option>
  <option>2013</option>
  <option>2014</option>
  <option>2015</option>
  <option>2016</option>
  <option>2017</option>
  <option>2018</option>
  <option>2019</option>
  <option>2020</option>
</select></td>
        </tr>
        <tr class="style14">
          <td>LIEU EMISSION</td>
          <td colspan="2"><input name="LIEU_EMISSION_PASS" type="text" class="style14" id="LIEU_EMISSION_PASS" value="<?php echo $row_Recordset1['LIEU_EMISSION_PASS']; ?>" size="30"<?php if (($groupe != "operateur ime")&&($groupe != "administrateur ime")){?>readonly="readonly"<?php } ?>/></td>
          <td colspan="2" class="style14">EMAIL</td>
          <td colspan="2"><input name="email1" type="text" class="style14" id="email1" value="<?php echo $row_Recordset1['EMAIL1']; ?>" /></td>
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
          <td colspan="7"><span class="style16"><span class="style16 style14">NUMERO EDIFICE </span>
              <input name="NUMERO_EDIFICE" type="text" class="style14" id="NUMERO_EDIFICE" value="<?php echo $row_Recordset1['NUM_EDIFICE']; ?>" size="10" />
&nbsp; &nbsp; NOM RUE
<input name="NOM_RUE" type="text" class="style14" id="NOM_RUE" value="<?php echo $row_Recordset1['NOM_RUE']; ?>" size="55" style="text-transform:uppercase"/>
          </span></td>
        </tr>
      </table>
      <?php
/*				  $dates = $_POST['jour']."-".$_POST['mois']."-".$_POST['an']."".$_POST['heure'].":".$_POST['min'];
				  $date = strtotime($dates);
				  echo date ('Y-m-j H:i:s',$date);
				  */
				  ?>
                  
      <input name="DATEH_NAIS" type="hidden" id="DATEH_NAIS" value="<?php echo date ('Y-m-d H:i:s',$date);?>" />
              
      <input type="hidden" name="ID_IND" id="ID_IND" value="<?php echo $colname_Recordset1;?>"/>
      <input name="ID_ADRESSE" type="hidden" id="ID_ADRESSE" value="<?php echo $row_Recordset1['ID_ADRESSE']; ?>" />
      <input name="ID_COORD" type="hidden" id="ID_COORD" value="<?php echo $row_Recordset1['ID_COORD']; ?>" />
      <div align="center">
        <input type="reset" name="Reset" id="button" value="Reset" />
        <input type="submit" name="button2" id="button2" value="Enregistrer" />
      </div>
      </label>
      <p align="center">&nbsp;</p>
      <p align="center">&nbsp;</p>
                  
        <input type="hidden" name="MM_update" value="form2" />
        <input type="hidden" name="MM_insert" value="form2" />
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
