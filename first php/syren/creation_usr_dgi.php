<?php require_once('Connections/connex.php'); ?>
<?php
$nomutil=$_POST['NOM_UTIL'];
$NOMUTIL = strtolower($nomutil);
$email = strtolower($_POST['eMail']);

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
$query_nomutil = "SELECT utilisateur.NOM_UTIL FROM utilisateur WHERE utilisateur.NOM_UTIL='$nomutil'";
$nomutil = mysql_query($query_nomutil, $connex) or die(mysql_error());
$row_nomutil = mysql_fetch_assoc($nomutil);
$totalRows_nomutil = mysql_num_rows($nomutil);

if ($totalRows_nomutil ==1) {
$existe="oui"; 
?>
<script>
window.alert('Ce nom existe deja, veuillez en choisir un autre!!!');
NOM_UTIL.focus();
</script>
<?php
}
else $existe="non";

//Cryptage du mot de passe
$mot_pass=md5($_POST['MOT_PASS']);

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1") && $existe == "non") {
  
  $insertSQL = sprintf("INSERT INTO utilisateur (NOM_UTIL, MOT_PASS, eMail, STATUT, ID_GROUPE, ID_ENTITE, ID_IND) VALUES (%s, '$mot_pass', %s, %s, %s, %s, %s)",
                       GetSQLValueString($NOMUTIL, "text"),
					   GetSQLValueString($email, "text"),
                       GetSQLValueString($_POST['STATUT'], "text"),
                       GetSQLValueString($_POST['ID_GROUPE'], "int"),
                       GetSQLValueString($_POST['ID_ENTITE'], "text"),
                       GetSQLValueString($_POST['ID_IND'], "text"));
  mysql_select_db($database_connex, $connex);
  $Result1 = mysql_query($insertSQL, $connex) or die(mysql_error());
  $insertGoTo = "saveutilok.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
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

mysql_select_db($database_connex, $connex);
$query_SELECTGROUP = "SELECT * FROM groupe where groupe.NOM_GROUPE like '%dgi%'";
$SELECTGROUP = mysql_query($query_SELECTGROUP, $connex) or die(mysql_error());
$row_SELECTGROUP = mysql_fetch_assoc($SELECTGROUP);
$totalRows_SELECTGROUP = mysql_num_rows($SELECTGROUP);

mysql_select_db($database_connex, $connex);
$query_IDENT = "SELECT entite.ID_ENTITE, entite.NOM_ENTITE FROM entite WHERE entite.SIGLE like 'dgi'";
$IDENT = mysql_query($query_IDENT, $connex) or die(mysql_error());
$row_IDENT = mysql_fetch_assoc($IDENT);
$totalRows_IDENT = mysql_num_rows($IDENT);

$colname_liste_ind = "-1";
if (isset($_GET['ID_IND'])) {
  $colname_liste_ind = $_GET['ID_IND'];
}
mysql_select_db($database_connex, $connex);
$query_liste_ind = sprintf("SELECT * FROM individu WHERE ID_IND = %s", GetSQLValueString($colname_liste_ind, "text"));
$liste_ind = mysql_query($query_liste_ind, $connex) or die(mysql_error());
$row_liste_ind = mysql_fetch_assoc($liste_ind);
$totalRows_liste_ind = mysql_num_rows($liste_ind);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>

<title>Untitled Document</title>

<script type='text/javascript'>

function formValidator(){
	// Make quick references to our fields
	var NOM_UTIL = document.getElementById('NOM_UTIL');
	var MOT_PASS = document.getElementById('MOT_PASS');
	var MOT_PASS2 = document.getElementById('MOT_PASS2');
	var eMail = document.getElementById('eMail');
	
	// Check each input in the order that it appears in the form!
	if(notEmpty(NOM_UTIL, "ERREUR Le champ nom utilisateur ne peut pas être vide!!!")){
		if(notEmpty(MOT_PASS, "ERREUR Le champ mot de passe ne peut pas être vide!!!")){
		  if(lengthRestriction(MOT_PASS, 4, 8)){
			if(notEmpty(MOT_PASS2, "ERREUR Le champ mot de passe2 ne peut pas être vide!!!")){
			  if(lengthRestriction(MOT_PASS2, 4, 8)){
				if(notEmpty(eMail, "ERREUR Le champ eMail ne peut pas être vide!!!")){					
					if(emailValidator(eMail, "Format eMail incorrect: jonh@doe.com")){
							return true;
							}
						}
					}
				}
			}
		}
	}
	
	
	return false;
	
}

function notEmpty(elem, helperMsg){
	if(elem.value.length == 0){
		alert(helperMsg);
		elem.focus(); // set the focus to this input
		return false;
	}
	return true;
}

function lengthRestriction(elem, min, max){
	var uInput = elem.value;
	if(uInput.length >= min && uInput.length <= max){
		return true;
	}else{
		alert("ERREUR La longeur du mot de passe doit être compris entre 4 et 8 charactères!!!");
		elem.focus();
		return false;
	}
}


function emailValidator(elem, helperMsg){
	var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
	if(elem.value.match(emailExp)){
		return true;
	}else{
		alert(helperMsg);
		elem.focus();
		return false;
	}
}
</script>

<script type="text/javascript" language="JavaScript">
<!--
//--------------------------------
// This code compares two fields in a form and submit it
// if they're the same, or not if they're different.
//--------------------------------
function checkPass(Form1) {
    if (Form1.MOT_PASS.value != Form1.MOT_PASS2.value)
    {
        alert('Les mots de passe ne correspondent pas!!!');
    	Form1.MOT_PASS.focus();
        return false;
    } else {
        return true;
    }
}
//-->
</script>

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
#Layer1 {
	position:absolute;
	left:139px;
	top:253px;
	width:125px;
	height:33px;
	z-index:1;
}
-->
</style>

<style type="text/css">
<!--
.style13 {font-size: 13px}
-->
</style>
</head>

<body>
	        <div class="screen"><div id="header">
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</div>
		<div id="menutop" align="center">		  </div>
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
<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>" onSubmit="return formValidator()">
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <table width="63%" border="2" id="comliste2">
    <tr>
      <td colspan="2"><div align="center"><strong>Param&egrave;tres Utilisateur </strong></div></td>
    </tr>
    <tr>
      <td class="style12">NOM INDIDVIDU</td>
      <td class="style12"><?php echo $row_liste_ind['PRENOM_IND']; ?><?php echo $row_liste_ind['NOM_JEUNE_FILLE']; ?><?php echo $row_liste_ind['NOM_IND']; ?></td>
    </tr>
    <tr>
      <td class="style12"><div align="left">NOM ENTITE</div></td>
      <td class="style12"><label>
      <select name="ID_ENTITE" id="ID_ENTITE">
        <?php
do {  
?>
        <option value="<?php echo $row_IDENT['ID_ENTITE']?>"<?php if (!(strcmp($row_IDENT['ID_ENTITE'], $row_IDENT['NOM_ENTITE']))) {echo "selected=\"selected\"";} ?>><?php echo $row_IDENT['NOM_ENTITE']?></option>
        <?php
} while ($row_IDENT = mysql_fetch_assoc($IDENT));
  $rows = mysql_num_rows($IDENT);
  if($rows > 0) {
      mysql_data_seek($IDENT, 0);
	  $row_IDENT = mysql_fetch_assoc($IDENT);
  }
?>
      </select>
      </label></td>
    </tr>
    <tr>
      <td width="164" class="style12"><div align="left">NOM UTILISATEUR</div></td>
      <td width="425" class="style12"><label>
        <input name="NOM_UTIL" type="text" id="NOM_UTIL" maxlength="15"  />
      </label></td>
    </tr>
    <tr>
      <td class="style12"><div align="left">MOT DE PASSE</div></td>
      <td class="style12"><input name="MOT_PASS" type="password" id="MOT_PASS" /></td>
    </tr>
    <tr>
      <td class="style12">CONFIRMER MOT DE PASSE</td>
      <td class="style12"><input name="MOT_PASS2" type="password" id="MOT_PASS2" onblur="return checkPass(form1)"/></td>
    </tr>
    <tr>
      <td class="style12"><div align="left">EMAIL</div></td>
      <td class="style12"><label>
        <input name="eMail" type="text" id="eMail" maxlength="30" />
      </label></td>
    </tr>
    <tr>
      <td class="style12"><div align="left">GROUPE</div></td>
      <td class="style12"><label>
        <select name="ID_GROUPE" id="ID_GROUPE">
          <?php
do {  
?>
          <option value="<?php echo $row_SELECTGROUP['ID_GROUPE']?>"><?php echo $row_SELECTGROUP['NOM_GROUPE']?></option>
          <?php
} while ($row_SELECTGROUP = mysql_fetch_assoc($SELECTGROUP));
  $rows = mysql_num_rows($SELECTGROUP);
  if($rows > 0) {
      mysql_data_seek($SELECTGROUP, 0);
	  $row_SELECTGROUP = mysql_fetch_assoc($SELECTGROUP);
  }
?>
        </select>
      </label></td>
    </tr>
    <tr>
      <td class="style12"><div align="left">STATUT</div></td>
      <td class="style12"><label>
        <select name="STATUT" id="STATUT">
          <option>Actif</option>
          <option>Inactif</option>
        </select>
      </label></td>
    </tr>
  </table>
  <p>
    <input type="submit" name="Submit" value="Valider"/>
    <input type="reset" name="Submit2" value="Annuler" />
  </p>
  <p>
    <label></label>
    <label></label>
    <input type="hidden" name="MM_insert" value="form1">
    <input name="ID_IND" type="hidden" id="ID_IND" value="<?php echo $_GET['ID_IND'] ?>" readonly="readonly" />
  </p>
          </form></div>
  <div class="spacer"></div>
		<div id="footer">
			<div class="content">
			<img src="Logo.jpg" width="116" height="49" /> <a href="#">A propos de nous </a> | <a href="#">Plan du Site </a> | <a href="#">R&egrave;gle d'utilisation </a> | <a href="#">Contactez-nous</a> | &copy;2009 SYREN			</div>
		</div>
</div>

</body>
</html>
<?php
mysql_free_result($SELECTGROUP);

mysql_free_result($IDENT);

mysql_free_result($liste_ind);

mysql_free_result($nomutil);
?>
