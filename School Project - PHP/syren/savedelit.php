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



  

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2"))
 {
$dates = $_POST['Infjour']."-".$_POST['Infmois']."-".$_POST['Infan']."".$_POST['Infh'].":".$_POST['Infmin']; 
echo $dates;

	$date = strtotime($dates);
	echo $datea;?><br /><?php
	$format = date ('Y-m-j',$date);
	echo $format;
  $insertSQL = sprintf("INSERT INTO delit (DESCRIPTION_DELIT, TYPE_DELIT, GRAVITE_DELIT, ID_IND) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['DESCRIPTION_DELIT'], "text"),
                       GetSQLValueString($_POST['TYPE_DELIT'], "text"),
                       GetSQLValueString($_POST['GRAVITE_DELIT'], "text"),
					   GetSQLValueString($_POST['IDIND'], "text"));
					   

  mysql_select_db($database_connex, $connex);
  $Result1 = mysql_query($insertSQL, $connex) or die(mysql_error());
}

$colname_rech_ind = "-1";
if (isset($_GET['ID_IND'])) {
  $colname_rech_ind = $_GET['ID_IND'];
}
$colname_rech_ind = "-1";
if (isset($_GET['ID_IND'])) {
  $colname_rech_ind = $_GET['ID_IND'];
}
mysql_select_db($database_connex, $connex);
$query_rech_ind = sprintf("SELECT ID_IND, EMPRINTE_IND, G_SANG_IND, SEXE_IND, NOM_IND, PRENOM_IND, DATEH_NAIS, NUM_NIF, NUM_CIF, PROFESSION, RELIGION, NUM_PASSPORT, NATIONALITE_INDIVIDU FROM individu WHERE ID_IND = %s", GetSQLValueString($colname_rech_ind, "text"));
$rech_ind = mysql_query($query_rech_ind, $connex) or die(mysql_error());
$row_rech_ind = mysql_fetch_assoc($rech_ind);
$totalRows_rech_ind = mysql_num_rows($rech_ind);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>

<title>SYREN | Syst&egrave;me de Renseignement National</title>
<script language="JavaScript" type="text/javascript">
<!-- hide

var Fwin = null;
Fwin_Wid = 360;
Fwin_Hgt = 440;
Fwin_Left = (screen) ? screen.width/2 - Fwin_Wid/2 : 100;
Fwin_Top =  (screen) ? screen.availHeight/2 - Fwin_Hgt/2 : 100;
function openFormWin(url) {
Fwin = open(url,'Fwin','width='+Fwin_Wid+',height='+Fwin_Hgt+',left='+
Fwin_Left+',top='+Fwin_Top+',status=0');
setTimeout('Fwin.focus()',100);
document.getElementById('infos').style.display='inline';
}



function disableForm()
{
if (document.getElementById('aucunChoix').selected)
{
//alert("Infjour") ;
document.getElementById('contraventionLigne1').style.visibility='visible';
document.getElementById('contraventionLigne2').style.visibility='visible';
document.getElementById('contraventionLigne3').style.visibility='visible';

document.getElementById('arrestationLigne1').style.visibility='visible';
document.getElementById('arrestationLigne2').style.visibility='visible';
document.getElementById('arrestationLigne3').style.visibility='visible';

document.getElementById('condamnationLigne1').style.visibility='visible';
document.getElementById('condamnationLigne2').style.visibility='visible';
document.getElementById('condamnationLigne3').style.visibility='visible';
}
if (document.getElementById('contravention').selected)
{
//alert("Infjour") ;
document.getElementById('contraventionLigne1').style.visibility='visible';
document.getElementById('contraventionLigne2').style.visibility='visible';
document.getElementById('contraventionLigne3').style.visibility='visible';

document.getElementById('condamnationLigne1').style.visibility='hidden';
document.getElementById('condamnationLigne2').style.visibility='hidden';
document.getElementById('condamnationLigne3').style.visibility='hidden';

document.getElementById('arrestationLigne1').style.visibility='hidden';
document.getElementById('arrestationLigne2').style.visibility='hidden';
document.getElementById('arrestationLigne3').style.visibility='hidden';




//document.getElementById('Infmois').enabled="true" ;
//document.getElementById('Infan').enabled="true" ;

//document.getElementById('Aresjour').disabled="true" ;
//document.getElementById('Aresmois').disabled="true" ;
//document.getElementById('Aresan').disabled="true" ;

//document.getElementById('Condjour').disabled="true" ;
//document.getElementById('Condmois').disabled="true" ;
//document.getElementById('Condan').disabled="true" ;
}

if (document.getElementById('delit').selected)
{
document.getElementById('contraventionLigne1').style.visibility='hidden';
document.getElementById('contraventionLigne2').style.visibility='hidden';
document.getElementById('contraventionLigne3').style.visibility='hidden';

document.getElementById('arrestationLigne1').style.visibility='visible';
document.getElementById('arrestationLigne2').style.visibility='visible';
document.getElementById('arrestationLigne3').style.visibility='visible';

document.getElementById('condamnationLigne1').style.visibility='visible';
document.getElementById('condamnationLigne2').style.visibility='visible';
document.getElementById('condamnationLigne3').style.visibility='visible';
/*alert("delit") ;
document.getElementById('Aresjour').enabled="true" ;
document.getElementById('Aresmois').enabled="true" ;
document.getElementById('Aresan').enabled="true" ;

document.getElementById('Infjour').disabled="true" ;
document.getElementById('Infmois').disabled="true" ;
document.getElementById('Infan').disabled="true" ;

document.getElementById('Condjour').disabled="true" ;
document.getElementById('Condmois').disabled="true" ;
document.getElementById('Condan').disabled="true" ;
*/}

if (document.getElementById('crime').selected)
{
document.getElementById('contraventionLigne1').style.visibility='hidden';
document.getElementById('contraventionLigne2').style.visibility='hidden';
document.getElementById('contraventionLigne3').style.visibility='hidden';

document.getElementById('arrestationLigne1').style.visibility='visible';
document.getElementById('arrestationLigne2').style.visibility='visible';
document.getElementById('arrestationLigne3').style.visibility='visible';

document.getElementById('condamnationLigne1').style.visibility='visible';
document.getElementById('condamnationLigne2').style.visibility='visible';
document.getElementById('condamnationLigne3').style.visibility='visible';
/*alert("crime") ;
document.getElementById('Condjour').enabled="true" ;
document.getElementById('Condmois').enabled="true" ;
document.getElementById('Condan').enabled="true" ;

document.getElementById('Aresjour').disabled="true" ;
document.getElementById('Aresmois').disabled="true" ;
document.getElementById('Aresan').disabled="true" ;

document.getElementById('Infjour').disabled="true" ;
document.getElementById('Infmois').disabled="true" ;
document.getElementById('Infan').disabled="true" ;*/

}
}

// done hiding -->
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
   	<form name="mainForm"> 
      <p><br>
        <br>
          <a href="#" onClick="openFormWin('popup.php');return false;"></a></p>
      <table width="574" border="1">
        <tr>
          <td width="112">JUGER PAR:</td>
          <td width="321"><p></p>
            <div id="infos" style="display:none"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   NOM :
              <input name="lname" type="text"/>
                  <p></p>
                <p> PRENOM:
                  <input name="fname" type="text" />
                  <input name="id" type="hidden" />
                  </p>
            </div></td>
          <td width="119"><a href="#" onClick="openFormWin('popup.php');return false;">Rechercher...</a></td>
        </tr>
      </table>
      <p>&nbsp;                  </p>
  </form>
          
      </p>
  <form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="form2" id="form2">
    <table width="647" border="0" id="entiteliste">
      <tr class="head">
        <td colspan="4">FORME D'ENREGISTREMENT DE DELIT</td>
      </tr>
      <tr>
        <td>NOM:</td>
        <td><span style="background-color:#C4ECFF"><?php echo $row_rech_ind['NOM_IND'] ?></span></td>
        <td>PRENOM:</td>
        <td><?php echo $row_rech_ind['PRENOM_IND']?></td>
      </tr>
      <tr>
        <td width="121">NIF </td>
        <td width="182"><?php echo $row_rech_ind['NUM_NIF'] ?></td>
        <td width="114">CIF</td>
        <td width="202"><?php echo $row_rech_ind['NUM_CIF'] ?></td>
      </tr>
      <tr>
        <td>No Passeport:</td>
        <td><?php echo $row_rech_ind['NUM_PASSPORT'] ?></td>
        <td>Nationalite:</td>
        <td><?php echo $row_rech_ind['NATIONALITE_INDIVIDU'] ?></td>
      </tr>
      <tr>
        <td>Groupe Sanguin:</td>
        <td><?php echo $row_rech_ind['G_SANG_IND'] ?></td>
        <td>Sexe:</td>
        <td><?php echo $row_rech_ind['SEXE_IND'] ?></td>
      </tr>
      <tr>
        <td>Date de Naissance:</td>
        <td><?php echo $row_rech_ind['DATEH_NAIS'] ?></td>
        <td>Religion:</td>
        <td><?php echo $row_rech_ind['RELIGION'] ?></td>
      </tr>
      <tr>
        <td>Profession:</td>
        <td><?php echo $row_rech_ind['PROFESSION'] ?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Niveau de L'infraction</td>
        <td><label>
            <select onChange="disableForm()" name="GRAVITE_DELIT" id="GRAVITE_DELIT">
              <option id="aucunChoix" selected="selected">--Choisir--</option>
              <option id="contravention">Contravention</option>
              <option id="delit">D&eacute;lit</option>
              <option id="crime">Crime</option>
            </select>
        </label></td>
        <td rowspan="2">Type de l'infraction</td>
        <td rowspan="2">
          <label>
            <input type="radio" name="TYPE_DELIT" value="Contre les personnes" id="typeinf_0" />
            Contre les personnes</label>
          <br />
          <label>
            <input type="radio" name="TYPE_DELIT" value="Contre les biens" id="typeinf_1" />
            Contre les biens</label>
          <br />
          <label>
            <input type="radio" name="TYPE_DELIT" value="Contre la Nation ou L'Etat" id="typeinf_2" />
            Contre la Nation ou L'Etat</label>
          <br />
          <label>
            <input type="radio" name="TYPE_DELIT" value="En organisation" id="typeinf_3" />
            En organisation</label>
          <br />
          <label>
            <input type="radio" name="TYPE_DELIT" value="Crime mutuel" id="typeinf_4" />
            Crime mutuel</label>
          <br />                    </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><input name="IDIND" type="hidden" value="<?php echo $row_rech_ind['ID_IND']?>" /></td>
      </tr>
      <tr>
        <td><div align="right">
            Description de l'infraction
        </div></td>
        <td colspan="3"><label for="DESCRIPTION_DELIT"></label>
          <label for="DESCRIPTION_DELIT"></label>
        <textarea name="DESCRIPTION_DELIT" id="DESCRIPTION_DELIT" cols="50" rows="3"></textarea></td>
      </tr>
                  
      <tr>
        <td>PEINE Pour INFRACTIOIN</td>
        <td colspan="2"><p>
            <label>&nbsp;&nbsp;&nbsp;
              <input type="radio" name="type_peine" value="radio" id="type_peine_0" />
              Amende</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      
            <label>
               <input type="radio" name="type_peine" value="radio" id="type_peine_1" />
              Prison &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                     
            <label>
              <input type="radio" name="type_peine" value="radio" id="type_peine_2" />
              Les deux</label>
            <br />
        </p></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="23">&nbsp;</td>
        <td colspan="2"><label>
            <input type="reset" name="Reset" id="button" value="Annuler" />
          </label>
          <label>
          <input type="submit" name="button2" id="button2" value="Enregistrer" />
          </label><label for="label2"></label></td>
      </tr>
    </table>
    <input type="hidden" name="MM_insert" value="form2" />
  </form>
    <p>
      <label></label>
  </p>
    <p><br />
      <br />
      <br />
      </p>
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
