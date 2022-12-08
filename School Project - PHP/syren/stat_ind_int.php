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

mysql_select_db($database_connex, $connex);
$query_individus = "SELECT * FROM individu";
$individus = mysql_query($query_individus, $connex) or die(mysql_error());
$row_individus = mysql_fetch_assoc($individus);
$totalRows_individus = mysql_num_rows($individus);

mysql_select_db($database_connex, $connex);
$query_ind_g = "SELECT * FROM individu WHERE individu.SEXE_IND = 'Masculin'";
$ind_g = mysql_query($query_ind_g, $connex) or die(mysql_error());
$row_ind_g = mysql_fetch_assoc($ind_g);
$totalRows_ind_g = mysql_num_rows($ind_g);

mysql_select_db($database_connex, $connex);
$query_ind_f = "SELECT * FROM individu WHERE individu.SEXE_IND = 'Feminin'";
$ind_f = mysql_query($query_ind_f, $connex) or die(mysql_error());
$row_ind_f = mysql_fetch_assoc($ind_f);
$totalRows_ind_f = mysql_num_rows($ind_f);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/index.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
<!-- InstanceBeginEditable name="doctitle" -->
<title>SYREN | Syst&egrave;me de Renseignement National</title>

<head>
<script type="text/javascript">
function toggle(divToShow) {
if (document.getElementById) {
if (divToShow == "with") {
document.getElementById('withdiv').style.display = "inline";
document.getElementById('sexe').style.display = "none";
} else 
	{
	if (divToShow == "with2")
	{
	document.getElementById('sexe').style.display = "inline";
	document.getElementById('withdiv').style.display = "none";
	}
	}
}
}

</script>
</head>

<!-- InstanceEndEditable -->
<link href="css/style.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style10 {font-size: 10px}
#search {		background-color:#eee;
}
.style12 {font-size: 12px}
-->
</style>
<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<!-- InstanceBeginEditable name="head" --><!-- InstanceEndEditable -->
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
		<div id="menutop" align="center">
        <!-- InstanceBeginEditable name="EditRegion4" -->           -
		  <ul id="MenuBar1" class="MenuBarHorizontal">
          <div class="idsection"> Ministere de L'interieur || MICTSN</div>
           <div class="loginbar">
            <div class="text">
                Bienvenue, <span class="fonce"><?php echo $_SESSION['MM_Username']; ?></span> :: Vous &ecirc;tes <span class="fonce"><?php echo $_SESSION['NOM_GROUPE']; ?> </span>            </div>
            <span class="logout"><a href="<?php echo $logoutAction ?>">Deconnexion</a></span>
            <div class="spacer"></div>
          </div>
            <li><a href="#" class="MenuBarItemSubmenu">Individus</a>
		      <ul>
		        <li><a href="#">Rechercher</a></li>
		        <li><a href="#">Statistiques</a></li>
		      </ul>
	        </li>
		    <li><a href="#" class="MenuBarItemSubmenu">Utilisateurs</a>
		      <ul>
		        <li><a href="#">Cr&eacute;er</a></li>
		        <li><a href="#">Modifier</a></li>
		        <li><a href="#">Lister</a></li>
		        <li><a href="#">Rechercher</a></li>
		      </ul>
	        </li>
		    <li><a class="MenuBarItemSubmenu" href="#">Entites</a>
                <ul>
                  <li><a href="list_entites.php">Lister</a></li>
                  <li><a href="#">Rechercher</a></li>
                </ul>
	        </li>
		    <li><a href="#">Actualites</a></li>
		    </ul>
		<!-- InstanceEndEditable --></div>
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
	        <!-- InstanceBeginEditable name="Right" -->
		    <div id="right">
              <p>
                <?php
if($_GET['search'] == "")
	{
?>
                <?php
				echo $info
			?>
		      <form name="form" action="<?php echo $visaction;?>" method="GET"><p>
		      <div align="center">Le Module Statistique vous permet d'observer les chiffres relatifs aux Citoyens Haitiens:              
		        <p>Visusaliser par : 
		        <label>
		        <input name="visual" type="radio" id="visual_0" value="radio" checked="unchecked" id="with" 
onclick="toggle('with')"/>
Sexe</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		        <label>
	            <input name="visual" type="radio"  disabled="disabled" id="with2"
onclick="toggle('with2')" value="radio"/>
Religion</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		        <label>
		        <input type="radio" name="visual" value="radio" id="visual_2" disabled="disabled"/>
Zone d'habitation</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		        <label>
		        <input type="radio" name="visual" value="radio" id="visual_3" disabled="disabled"/>
Profession</label>
	                  
		      <p>
              
		        <input name="Submit" type="submit" value="Visualiser"  />
		      
		      </div></form>
               <table width="488" border="1" id="comliste">
                <tr class="head">
                  <td colspan="3"><div align="center">Information Statistiques sur Individus ( Par Sexe)</div></td>
                </tr>
                <tr>
                  <td width="283">Nombre de Gar&ccedil;ons</td>
                  <td width="90"><?php echo $totalRows_ind_g;?></td>
                  <td width="128"><?php echo substr(($totalRows_ind_g / $totalRows_individus)*100,0,5)." %";?></td>
                </tr>
                <tr>
                  <td>Nombre de Filles</td>
                  <td><?php echo $totalRows_ind_f;?></td>
                  <td><?php echo substr(($totalRows_ind_f / $totalRows_individus)*100,0,5)." %";?></td>
                </tr>
                <tr>
                  <td height="24">Nombre Total Individus</td>
                  <td><?php echo $totalRows_individus;?></td>
                  <td><?php echo substr(($totalRows_individus / $totalRows_individus)*100,0,5)." %";?></td>
                </tr>
              </table>
		      <p>              
		      <p>              
		      <p>              
		      <p>              
		      <p>
              <div align="center"><input type="button" value="Graphe" /></div>
              <table width="81%" height="200" border="0" align="center" id="graphliste">
              <tr> <td valign="bottom">
              <table width="50" border="0" align="center">
              <tr> <td height="<?php echo substr(($totalRows_ind_g / $totalRows_individus)*100,0,5);?>" bgcolor="#0066CC"></td></tr>
              <tr><td><div align="center"><?php echo substr(($totalRows_ind_g / $totalRows_individus)*100,0,5)." %";?></div></td></tr>
              </table>
              </td>
              <td valign="bottom">
              <table width="50" border="0" align="center">
              <tr> <td height="<?php echo substr(($totalRows_ind_f / $totalRows_individus)*100,0,5);?>" bgcolor="#0066CC"></td></tr>
              <tr><td><div align="center"><?php echo substr(($totalRows_ind_f / $totalRows_individus)*100,0,5)." %";?></div></td></tr>
              </table>
              </td>
              </tr>
              </table>
            </div>	
              
              <p>&nbsp;              </p>
              
              
              
              <p>
                <?php /*?>              <table width="600" height="400" border="0">
              <tr>
              <?php do { ?>
              		<td valign="bottom">
                    <table width="50" border="0" align="center">
                    	<tr><td height="<?php echo $row_indvidus['SEXE_IND'];?>" bgcolor="#FF0000"></td></tr>
                        </table>
                        </td>
                        <?php } while ($row_individus=mysql_fetch_assoc($indvidus));?>
                        </tr>
                        </table>
                <br><?php */?>
                <?php
	}
else
	echo " ".$nomutil."<br>";
	echo "".$id_groupe."<br>";
	echo "".$pass."<br>";
?>
                </p>
              </p>
              <p>&nbsp;  </p>
		    </div>
	        <!-- InstanceEndEditable -->
  <div class="spacer"></div>
		<div id="footer">
			<div class="content">
			<img src="Logo.jpg" width="116" height="49" /> <a href="#">A propos de nous </a> | <a href="#">Plan du Site </a> | <a href="#">R&egrave;gle d'utilisation </a> | <a href="#">Contactez-nous</a> | &copy;2009 SYREN
			</div>
		</div>
</div>
<script type="text/javascript">
<!--
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"/syren/SpryAssets/SpryMenuBarDownHover.gif", imgRight:"/syren/SpryAssets/SpryMenuBarRightHover.gif"});
//-->
</script>
</body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($individus);

mysql_free_result($ind_g);

mysql_free_result($ind_f);

mysql_free_result($loggedUser);
?>
