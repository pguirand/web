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

<title>Untitled Document</title>

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
  <p>              
  <p>
    <br><br><br>
  <div class="warning"> 
    <p>MINIST&Egrave;RE DE LA JUSTICE ET DE LA S&Eacute;CURIT&Eacute; PUBLIQUE<br>
      <br><br>
      <br>
      La Direction G&eacute;n&eacute;rale des Imp&ocirc;ts (DGI) est un Service D&eacute;concentr&eacute; du  Minist&egrave;re de l'&Eacute;conomie et des Finances. Elle fonctionne suivant les  dispositions du pr&eacute;sent D&eacute;cret.</p>
    <p>La Direction G&eacute;n&eacute;rale des Imp&ocirc;ts a pour attributions essentielles : </p>
    <ol>
      <li>
        <div align="left">de mettre en application les lois fiscales; </div>
      </li>
      <li>
        <div align="left">de percevoir les imp&ocirc;ts, taxes, droits et autres revenus de l'Etat ; </div>
      </li>
      <li>
        <div align="left">d'administrer le s&eacute;questre, la faillite et les biens des successions vacantes; </div>
      </li>
      <li>
        <div align="left">d'enregistrer les actes et documents d&eacute;sign&eacute;s par la Loi; </div>
      </li>
      <li>
        <div align="left">de recevoir les fonds destin&eacute;s &agrave; la Caisse des D&eacute;p&ocirc;ts et Consignations; </div>
      </li>
      <li>
        <div align="left">de g&eacute;rer les biens du domaine priv&eacute; de l'Etat; </div>
      </li>
      <li>
        <div align="left">de repr&eacute;senter l'Etat en justice.</div>
      </li>
    </ol>
  </div>
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