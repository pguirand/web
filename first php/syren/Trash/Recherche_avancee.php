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

$maxRows_rech_av = 10;
$pageNum_rech_av = 0;
if (isset($_GET['pageNum_rech_av'])) {
  $pageNum_rech_av = $_GET['pageNum_rech_av'];
}
$startRow_rech_av = $pageNum_rech_av * $maxRows_rech_av;

# SEXE
#=====================================



$flagfirst = "oui";	
$colname_nom = $_POST['nom']; 
$colname_prenom = $_POST['prenom']; 
$colname_sexe = $_POST['sexe']; 
$colname_profession = $_POST['profession']; 
$clause_nom = "NOM_IND = '".$colname_nom."'";
$clause_prenom = "AND PRENOM_IND = '".$colname_prenom."'";
$clause_sexe = "AND SEXE_IND = '".$colname_sexe."'";
$clause_profession = "AND PROFESSION = '".$colname_profession."'";
$clause_religion = "AND SEXE_IND = '".$colname_sexe."'";
$clause_religion = "AND PROFESSION = '".$colname_profession."'";


if (($colname_nom == "") && ($colname_prenom == "") && ($colname_sexe == "") && ($colname_profession == ""))
{

//echo 	"Vous devez specifier au moins un critere de recherche" ;?><br>
<?php
	if(isset($_POST['catho']))
    $colname_catho = "Catholique";
	else
	$colname_catho = "";
	
	if(isset($_POST['bapt']))
    $colname_bapt = " Baptiste";
	else
	$colname_bapt = "";
	
	if(isset($_POST['vodou']))
    $colname_vodou = " Vodouisant";
	else
	$colname_vodou = "";
	
	if(isset($_POST['protest']))
    $colname_protest = " Protestant";
	else
	$colname_protest = "";
	
	if(isset($_POST['temoins']))
    $colname_tem = " Temoins de Jehovah";
	else
	$colname_tem = "";
	
	echo $colname_catho.$colname_protest;
	echo $colname_bapt.$colname_tem.$colname_vodou;?><br><?php
//die("Vous devez specifier au moins un critere de recherche");
$cond = "";
$clause_nom = "";
$clause_prenom = "";
$clause_sexe = "";
$clause_profession = "";
}
else 
	{

if(isset($_POST['catho']))
    $colname_catho = "Catholique";
	else
	$colname_catho = "";
	
	if(isset($_POST['bapt']))
    $colname_bapt = " Baptiste";
	else
	$colname_bapt = "";
	
	if(isset($_POST['vodou']))
    $colname_vodou = " Vodouisant";
	else
	$colname_vodou = "";
	
	if(isset($_POST['protest']))
    $colname_protest = " Protestant";
	else
	$colname_protest = "";
	
	if(isset($_POST['temoins']))
    $colname_tem = " Temoins de Jehovah";
	else
	$colname_tem = "";
	
	echo $colname_catho.$colname_protest;
	echo $colname_bapt.$colname_tem.$colname_vodou;

if ($colname_nom == "") 
	{
	$cond = "WHERE";
	$clause_nom = "";
	$clause_prenom = "PRENOM_IND = '".$colname_prenom."'";
	}
	
if ($colname_prenom == "") 
	{
	$cond = "WHERE";
	$clause_prenom = "";
	}
if  (($colname_nom == "") && ($colname_prenom == "")) 
	{
	$cond = "WHERE";
	$clause_nom = "";
	$clause_prenom = "";
	$clause_sexe = "SEXE_IND = '".$colname_sexe."'";
	}
	
if ($colname_sexe == "") 
	{
	$cond = "WHERE";
	$clause_sexe = "";
	}
	
if (($colname_nom == "") && ($colname_prenom == "") && ($colname_sexe == ""))
	{
	$clause_nom = "";
	$clause_prenom = "";
	$clause_sexe = "";
	$cond = "WHERE";
	$clause_profession = "PROFESSION = '".$colname_profession."'";
	}
if ($colname_profession == "") 
	{
	$clause_profession = "";
	$cond = "WHERE";
	}
	
if (($colname_nom != "") && ($colname_prenom != "") && ($colname_sexe != "") && ($colname_profession != "") )
$cond = "WHERE";	
}
/*
if ($colname_nom == "") 
	{
	$clause_nom = "";
	$clause_prenom = "PRENOM_IND = '".$colname_prenom."'";
	}
if ((($colname_nom) && (colname_prenom)) == "")
	{
    $clause_nom = "";
	$clause_prenom = ""; 
    $clause_sexe = "SEXE_IND = '".$colname_sexe."'";
   	}*/
	
	

mysql_select_db($database_connex, $connex);
$query_rech_av = ("SELECT ID_IND, G_SANG_IND, SEXE_IND, NOM_IND, PRENOM_IND, NUM_NIF, NUM_CIF, PROFESSION, NUM_PASSPORT, EMAIL1 FROM individu ".$cond." ".$clause_nom." ".$clause_prenom." ".$clause_sexe." ".$clause_profession."");
$query_limit_rech_av = sprintf("%s LIMIT %d, %d", $query_rech_av, $startRow_rech_av, $maxRows_rech_av);
$rech_av = mysql_query($query_limit_rech_av, $connex) or die(mysql_error());
$row_rech_av = mysql_fetch_assoc($rech_av);
$query_rech_av;

if (isset($_GET['totalRows_rech_av'])) {
  $totalRows_rech_av = $_GET['totalRows_rech_av'];
} else {
  $all_rech_av = mysql_query($query_rech_av);
  $totalRows_rech_av = mysql_num_rows($all_rech_av);
}
$totalPages_rech_av = ceil($totalRows_rech_av/$maxRows_rech_av)-1;

$maxRows_rech_av = 10;
$pageNum_rech_av = 0;
if (isset($_GET['pageNum_rech_av'])) {
  $pageNum_rech_av = $_GET['pageNum_rech_av'];
}
$startRow_rech_av = $pageNum_rech_av * $maxRows_rech_av;


#	LANCEMENT DE LA RECHERCHE
#	================================

#	LANCEMENT DU CODE :
$rechByNifAction = $_SERVER['PHP_SELF'];

#	VERIFICATION DU TYPE DE LA RECHERCHE
if (isset($_GET['choixId']))
	{
	$rechFlag = "oui";
		switch($_GET['choixId'])
			{
				case	"NIF"			:	$champs = "NUM_NIF";
											break;
				case	"CIF"			:	$champs = "NUM_CIF";
											break;
				case	"NUM_PASSPORT"	:	$champs = "NUM_PASSPORT";
											break;		
			}
		
$colname_rechByNif = "-1";
		if (isset($_GET['NUM_NIF'])) {
		  $colname_rechByNif = $_GET['NUM_NIF'];
		}		
			mysql_select_db($database_connex, $connex);
			$query_rechByNif = sprintf("SELECT * FROM individu WHERE ".$champs." = %s ORDER BY ".$champs." ASC", GetSQLValueString($colname_rechByNif, "text"));
			$rechByNif = mysql_query($query_rechByNif, $connex) or die(mysql_error());
			$row_rechByNif = mysql_fetch_assoc($rechByNif);
			$totalRows_rechByNif = mysql_num_rows($rechByNif);		
			$query_rechByNif;
	}
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/admdgi.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
<!-- InstanceBeginEditable name="doctitle" -->
<title>SYREN | Syst&egrave;me de Renseignement National</title>
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
<script src="../SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
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
        <!-- InstanceBeginEditable name="EditRegion4" -->
	    <ul id="MenuBar1" class="MenuBarHorizontal">
          <div class="idsection"> Direction Generale des Impots || DGI </div>
           <div class="loginbar">
            <div class="text">
                Bienvenue, <span class="fonce"><?php echo $_SESSION['MM_Username']; ?></span> :: Vous &ecirc;tes <span class="fonce"><?php echo $_SESSION['NOM_GROUPE']; ?> </span>            </div>
            <span class="logout"><a href="<?php echo $logoutAction ?>">Deconnexion</a></span>
            <div class="spacer"></div>
          </div>

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
              </p>
              <div class="fonce">
                <div align="center">Module	de	Recherche Avanc&eacute;e pour un individu </div>
              </div>
              <form id="form2" name="form2" method="POST" action="<?php echo $rechByNifAction; ?>">
              <div align="center">
                <table width="600" border="1">
                  <tr>
                    <td colspan="3"><div align="center" class="fonce">INFORMATIONS PERSONNELLES</div></td>
                  </tr>
                  <tr>
                    <td width="118">Par Sexe :<br>
                      <select name="sexe" id= "sexe">
                        <option value="Masculin">Homme</option>
                        <option value="Feminin">Femme</option>
                        <option value="" selected="selected">Les deux</option>
                                                                                                              </select></td>
                    <td width="149"><label></label>
                      <label>Nom
                    :
                    <input type="text" name="nom" id="nom"/>
                  
Pr�nom
                    :
<input type="text" name="prenom" id="prenom" />
                    </label></td>
                    <td>Profession:
                      <select name="profession" id="profession">
                        <option>Informaticien</option>
                        <option>Ingenieur</option>
                        <option>Artiste</option>
                        <option>Infirmier(e)</option>
                        <option>Docteur</option>
                        <option>Comptable</option>
                        <option>Artiste</option>
                        <option selected="selected"></option>
                      </select></td>
                  </tr>
                </table>
                
                
                <p>
                  <input type="reset" name="Reset" id="button" value="Annuler" />
                  <label>
                  <input type="submit" name="button2" id="button2" value="Lancer Recherche" />
                  </label>
                  <br />
              </p>
              </div>
              </form>
              
              <?php
#	AFFoui ICHER LE RESULTAT SI LA RECHERCHE EST EFFECTUEE
#	======================================================
if (isset($_GET['NUM_NIF']) && ($row_rechByNif['NOM_IND'] != ""))
	{
?>
    <div align="center">
   <div class="logoutok"> NIF VALIDE </div><BR>
   <div class="fonce">R�sultats</div> 
      <table border="1" id="comliste">
        <tr class="head">
          <td>NOM</td>
          <td>PRENOM</td>
          <td>SEXE</td>  
          <td>Groupe Sanguin</td>    
        </tr>
        <tr>
          <td><?php echo $row_rechByNif['NOM_IND']; ?></td>
          <td><?php echo $row_rechByNif['PRENOM_IND']; ?></td>
          <td><?php echo $row_rechByNif['SEXE_IND']; ?></td>
          <td><?php echo $row_rechByNif['G_SANG_IND']; ?></td>
        </tr>
</table>
      <p><br>
        <br>
        <a href="creation_usr.php?ID_IND=<?php echo $row_rechByNif['ID_IND']."&NOM_IND=".$row_rechByNif['NOM_IND'] ?>">Creer le user</a>      </p>
      <p>&nbsp;</p>
      <?php
	}
	else if ($rechFlag == "oui")
	echo "...";
	
?>
    
      <table border="1" id="comliste">
        <tr class="head">
          <td>G_SANG_IND</td>
          <td>SEXE_IND</td>
          <td>NOM_IND</td>
          <td>PRENOM_IND</td>
          <td>NUM_NIF</td>
          <td>PROFESSION</td>
          <td>EMAIL1</td>
        </tr>
        <?php do { ?>
          <tr>
            <td><?php echo $row_rech_av['G_SANG_IND']; ?></td>
            <td><?php echo $row_rech_av['SEXE_IND']; ?></td>
            <td><a href="updind.php?ID_IND=<?php echo $row_rech_av['ID_IND']; ?>"> <?php echo $row_rech_av['NOM_IND']; ?></a></td>
            <td><?php echo $row_rech_av['PRENOM_IND']; ?></td>
            <td><?php echo $row_rech_av['NUM_NIF']; ?></td>
            <td><?php echo $row_rech_av['PROFESSION']; ?></td>
            <td><?php echo $row_rech_av['EMAIL1']; ?></td>
          </tr>
          <?php } while ($row_rech_av = mysql_fetch_assoc($rech_av)); ?>
      </table>
    </div>
      <?php /*?><?php
$stringnif = $_GET['NUM_NIF'];
echo $stringnif;
$nbchar = strlen($stringnif);?><br>
<?php
if ($nbchar = 10) 
	echo "NIF Invalide";
else
	echo "NIF Valide";
echo $nbchar; 
?><?php */?>

            </div>
            </p>

              <?php
	}
else
	echo " ".$nomutil."<br>";
	echo "".$id_groupe."<br>";
	echo "".$pass."<br>";
?>
            </div>
	        <!-- InstanceEndEditable -->
  <div class="spacer"></div>
		<div id="footer">
			<div class="content">
			<img src="../Logo.jpg" width="116" height="49" /> <a href="#">A propos de nous </a> | <a href="#">Plan du Site </a> | <a href="#">R&egrave;gle d'utilisation </a> | <a href="#">Contactez-nous</a> | &copy;2009 SYREN
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
<?php /*?><?php
mysql_free_result($rech_av);

mysql_free_result($loggedUser);
?><?php */?>
