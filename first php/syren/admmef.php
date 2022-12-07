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
	        <div class="screen"><div id="header">
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</div>
<div id="left">
          <?php include_once('menuleft.php');?>
  </div>
	  </div>
	        
<div id="right">
  <p>
    <?php
	include_once('menuh.php');
if($_GET['search'] == "")
	{
?>
    <?php
				echo $info
			?>
  </p>
  <p align="center">&nbsp;</p>
  <div class="title"> Ministere de L'Economie et des Finances.</div>
  <div class="content">
    <table cellspacing="0" cellpadding="0">
      <tr>
        <td rowspan="2" valign="top"><p>Le                       minist&egrave;re de l&rsquo;&eacute;conomie et des finances                       a pour mission fondamentale de formuler et de mettre en application                       la politique &eacute;conomique et financi&egrave;re de l&rsquo;&eacute;tat.</p></td>
        <td colspan="3" valign="top" height="75"><table border="0" cellpadding="0" cellspacing="0" width="100%">
              <!--DWLayoutTable-->
              <tbody>
                <tr>
                  <td valign="top" width="122" height="75"><img src="http://www.mefhaiti.gouv.ht/images/DSC2543v.jpg" width="100" height="75" /></td>
                </tr>
              </tbody>
        </table></td>
      </tr>
      <tr>
        <td height="8"></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td colspan="4" valign="top" height="633"><p>Le                       minist&egrave;re de l&rsquo;&eacute;conomie et des finances                       exerce les attributions suivantes :</p>
            <ul>
              <li> D&eacute;terminer la politique fiscale de l&rsquo;&eacute;tat,                         assurer la perception des imp&ocirc;ts et taxes, g&eacute;rer                         les biens de l&rsquo;&eacute;tat ;</li>
              <li> Coordonner les travaux d&rsquo;&eacute;laboration du budget                         g&eacute;n&eacute;ral de la r&eacute;publique et en assurer                         l&rsquo;ex&eacute;cution ;</li>
              <li> Assurer la gestion de la tr&eacute;sorerie ;</li>
              <li> Juger de l&rsquo;opportunit&eacute; des d&eacute;penses                         de l&rsquo;&eacute;tat ;</li>
              <li> Etablir, avec le concours de la Banque Centrale, la politique                         mon&eacute;taire du pays et en superviser l&rsquo;ex&eacute;cution                         ;</li>
              <li> Veiller &agrave; l&rsquo;application des lois sur l&rsquo;&eacute;tablissement,                         l&rsquo;organisation, le fonctionnement et le contr&ocirc;le                         des banques, bureaux de charge, institutions de cr&eacute;dit                         et compagnies d&rsquo;assurance ;</li>
              <li> Fixer les normes de la comptabilit&eacute; publique et veiller                         &agrave; leur application ;</li>
              <li> Entreprendre des &eacute;tudes de conjoncture et de pr&eacute;visions                         &eacute;conomiques ;</li>
              <li> Participer &agrave; l&rsquo;&eacute;laboration des plans                         et programmes de d&eacute;veloppement &eacute;conomique                         national ;</li>
              <li>Encourager                         les investissements nationaux et &eacute;trangers et stimuler                         la cr&eacute;ation de nouveaux emplois ;</li>
              <li>Veiller                         &agrave; l&rsquo;observance des clauses financi&egrave;res                         des contrats r&eacute;gissant les entreprises concessionnaires                         de services publics ;</li>
              <li>Exercer                         le contr&ocirc;le financier des collectivit&eacute;s territoriales                         des entreprises et &eacute;tablissements publics ou mixtes                         ;</li>
              <li>Repr&eacute;senter                         l&rsquo;&eacute;tat dans les entreprises mixtes et d&rsquo;&eacute;tat                         &agrave; caract&egrave;re financier, commercial et industriel                         et contr&ocirc;ler leurs activit&eacute;s ;</li>
              <li>Donner                         son avis &eacute;crit et motiv&eacute; sur tout projet de                         loi &agrave; caract&egrave;re &eacute;conomique, fiscal                         ou financier ;</li>
              <li>N&eacute;gocier                         et signer tout contrat, accord, convention et trait&eacute;                         &agrave; incidence &eacute;conomique et entra&icirc;nant                         des obligations financi&egrave;res pour l&rsquo;&eacute;tat                         ;</li>
              <li>Exercer                         toutes autres attributions de nature &eacute;conomique et                         financi&egrave;re d&eacute;coulant de la mission qui lui                         est assign&eacute;e </li>
            </ul></td>
      </tr>
    </table>
    <p>&nbsp;</p>
    <p><br />
    </p>
    <div class="content"></div>
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
</div>
  <div class="spacer"></div>
		<div id="footer">
			<div class="content">
			<img src="Logo.jpg" width="116" height="49" /> <a href="#">A propos de nous </a> | <a href="#">Plan du Site </a> | <a href="#">R&egrave;gle d'utilisation </a> | <a href="#">Contactez-nous</a> | &copy;2009 SYREN			</div>
		</div>
</body>
</html>
