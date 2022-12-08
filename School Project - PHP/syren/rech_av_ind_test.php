<?php require_once('Connections/connex.php'); ?>
<?php
/* Variables de connexion : ajustez ces paramètres selon votre propre environnement */
$serveur = "localhost";
$admin   = "root";
$mdp     = "";
$base    = "syren";
/* On récupère si elle existe la valeur de la région envoyée par le formulaire */
$idr = isset($_POST['dept'])?$_POST['dept']:null;
?>
<?php
if(isset($_POST['ok']) && isset($_POST['dept']) && $_POST['dept'] != "")
{
    $dept = $_POST['dept'];
    $arron = $_POST['arron'];
	//$commune = $_POST['comm'];
?>
<?php
}
?>
<?php
/* On établit la connexion à MySQL avec mysql_pconnect() plutôt qu'avec mysql_connect()
*  car on aura besoin de la connexion un peu plus loin dans le script */
$connexion = mysql_pconnect($serveur, $admin, $mdp);
if($connexion != false)
{
   $choixbase = mysql_select_db($base, $connexion);
    $sql1 = "SELECT `id_dept`, `nom_dept` ".
    " FROM `departement`".
    " ORDER BY `id_dept`";
    $rech_dept = mysql_query($sql1);
    $code_dept = array();
    $dept = array();
    /* On active un compteur pour les régions */
    $nb_dept = 0;
    if($rech_dept != false)
    {
        while($ligne = mysql_fetch_assoc($rech_dept))
        {
            array_push($code_dept, $ligne['id_dept']);
            array_push($dept, $ligne['nom_dept']);
            /* On incrémente de compteur */
            $nb_dept++;
        }
    }
    ?>
<?php
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
$query_departement = "SELECT * FROM departement";
$departement = mysql_query($query_departement, $connex) or die(mysql_error());
$row_departement = mysql_fetch_assoc($departement);
$totalRows_departement = mysql_num_rows($departement);

mysql_select_db($database_connex, $connex);
$query_Recordset1 = "SELECT * FROM departement ORDER BY departement.ID_DEPT";
$Recordset1 = mysql_query($query_Recordset1, $connex) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);


//$ID_DEPT_arrondissement = NULL;
if (isset($_GET['$IDDEPT'])) {
  $ID_DEPT_arrondissement = $_GET['$IDDEPT'];
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
$age1 = $_POST['age1'];
$age2 = $_POST['age2'];
$dept = $_POST['dept'];
$arrond = $_POST['arrond'];
$comm = $_POST['commune'];
$seccom = $_POST['sectcom'];
$clause_nom = "NOM_IND = '".$colname_nom."'";
$clause_prenom = "AND PRENOM_IND = '".$colname_prenom."'";
$clause_sexe = "AND SEXE_IND = '".$colname_sexe."'";
$clause_profession = "AND PROFESSION = '".$colname_profession."'";
$clause_religion = "AND RELIGION = '".$colname_profession."'";


if (($colname_nom == "") && ($colname_prenom == "") && ($colname_sexe == "") && ($colname_profession == ""))
{
//die("Vous devez specifier au moins un critere de recherche");
$cond = "";
$clause_nom = "";
$clause_prenom = "";
$clause_sexe = "";
$clause_profession = "";
}
else 
	{


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

//	EXECUTER CE CODE S'IL N'Y A PAS DE REQUETE DE RELIGION
//	======================================================
if (!isset($_POST['relig']))
	{
		mysql_select_db($database_connex, $connex);
		echo $query_rech_av = ("SELECT ID_IND, G_SANG_IND, SEXE_IND, NOM_IND, PRENOM_IND, NUM_NIF, NUM_CIF, PROFESSION, NUM_PASSPORT, EMAIL1 FROM individu ".$cond." ".$clause_nom." ".$clause_prenom." ".$clause_sexe." ".$clause_profession."");
		$query_limit_rech_av = sprintf("%s LIMIT %d, %d", $query_rech_av, $startRow_rech_av, $maxRows_rech_av);
		$rech_av = mysql_query($query_limit_rech_av, $connex) or die(mysql_error());
		$row_rech_av = mysql_fetch_assoc($rech_av);
		$query_rech_av;
	}
	
	
//	EXECUTER CE CODE S'IL Y A REQUETE DE RELIGION
//	=============================================
if (isset($_POST['relig']) && ($_POST['relig'] != ""))
	{
		# Compter le nombre de choix de religion
//		echo "Lancement";
		$inArr = array();
		if (isset($_POST['relig']))
			{
			$inArr = $_POST['relig'];
			$nbrEle = count($inArr)."<br>";
	mysql_select_db($database_connex, $connex);
 $rech_av = "SELECT ID_IND, G_SANG_IND, SEXE_IND, NOM_IND, PRENOM_IND, NUM_NIF, NUM_CIF, PROFESSION, NUM_PASSPORT, EMAIL1, RELIGION FROM individu WHERE ";
foreach ($inArr as $key => $value) {
//    print "The $key is a $value.<br>\n";
	$rech_av .="( $clause_nom $clause_prenom $clause_sexe $clause_profession AND RELIGION = '$value') OR ";
	if($key == $nbrEle -1)
		$rech_av .= "( $clause_nom $clause_prenom $clause_sexe $clause_profession AND RELIGION = '$value')";
}
//	$req1 .= "";
echo $rech_av;

			

//die ();
//		mysql_select_db($database_connex, $connex);
//		echo $query_rech_av = ("SELECT ID_IND, G_SANG_IND, SEXE_IND, NOM_IND, PRENOM_IND, NUM_NIF, NUM_CIF, PROFESSION, NUM_PASSPORT, EMAIL1 FROM individu ".$cond." ".$clause_nom." ".$clause_prenom." ".$clause_sexe." ".$clause_profession."");
		$query_limit_rech_av = sprintf("%s LIMIT %d, %d", $req1, $startRow_req1, $maxRows_req1);
		$req1 = mysql_query($query_limit_req1, $connex) or die(mysql_error());
		$row_req1 = mysql_fetch_assoc($req1);
		$query_req1;		
			}
	}

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
        <!-- InstanceBeginEditable name="EditRegion4" -->
	    <ul id="MenuBar1" class="MenuBarHorizontal">
          <div class="idsection"> Direction Generale des Impots || DGI </div>
           <div class="loginbar">
            <div class="text">
                Bienvenue, <span class="fonce"><?php echo $_SESSION['MM_Username']; ?></span> :: Vous &ecirc;tes <span class="fonce"><?php echo $_SESSION['NOM_GROUPE']; ?> </span>            </div>
            <span class="logout"><a href="<?php echo $logoutAction ?>">Deconnexion</a></span>
            <div class="spacer"></div>
          </div>
            <li><a class="MenuBarItemSubmenu" href="#">Entites</a>
                <ul>
                  <li><a href="saveentites.php">Enregistrer</a></li>
                  <li><a href="#">Modifier</a></li>
                  <li><a href="list_entites.php">Lister</a></li>
                  <li><a href="rech_entites.php">Rechercher</a></li>
                </ul>
            </li>
		    <li><a href="#" class="MenuBarItemSubmenu">Individus</a>
		      <ul>
		        <li><a href="saveind.php">Enregistrer</a></li>
		        <li><a href="#">Modifier</a></li>
		        <li><a href="#">Lister</a></li>
		        <li><a href="#">Rechercher</a></li>
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
		    <li><a href="#">Recherche Avanc&eacute;e</a></li>
		    <li><a href="#">Actualites</a></li>
		    <li><a href="#">Culture</a></li>
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
              </p>
              <div class="fonce">
                <div align="center">Module	de	Recherche Avanc&eacute;e pour un individu </div>
              </div>
              <form id="form2" name="form2" method="POST" action="<?php echo($_SERVER['PHP_SELF']); ?>">
              <div align="center">
                <table width="600" border="1">
                  <tr>
                    <td colspan="4"><div align="center" class="fonce">INFORMATIONS PERSONNELLES</div></td>
                  </tr>
                  <tr>
                    <td width="108">Par Sexe :<br>
                      <select name="sexe" id= "sexe">
                        <option value="Masculin">Homme</option>
                        <option value="Feminin">Femme</option>
                        <option value="" selected="selected">Les deux</option>
                      </select></td>
                    <td width="155"><label></label>
                      <label>Nom
                    :
                    <input type="text" name="nom" id="nom"/>
                  
Prénom
                    :
<input type="text" name="prenom" id="prenom" />
                    </label></td>
                    <td width="134"><p>Tranche d'age:<br />
Entre
    <label></label>
    <label>
    <input name="age1" type="text" id="age1" size="7" maxlength="7" />
    </label>
    et
<label></label>
                  <label>
                  <input name="age2" type="text" id="age2" size="7" maxlength="7" />
                  </label>
                    </td>
                    <td width="175"><p> Date de naissance:<br />
                        <label>
                        Ann&eacute;e</label>
                        <label>
                        <select name="annee" id="annee">
                        </select>
                        </label>
                        <br>
                      <label>
                      Mois  &nbsp;&nbsp;</label>
                      <label>
                      <select name="mois" id="mois">
                        <option value="01">01</option>
                        <option value="02">02</option>
                        <option value="03">03</option>
                        <option value="04">04</option>
                        <option value="05">05</option>
                        <option value="06">06</option>
                        <option value="07">07</option>
                        <option value="08">08</option>
                        <option value="09">09</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                      </select>
                      </label>
                      <br>
                        <label>
                        Date &nbsp;&nbsp;</label>
                        <label>
                        <select name="date" id="date">
                          <option value="01">01</option>
                          <option value="02">02</option>
                          <option value="03">03</option>
                          <option value="04">04</option>
                          <option value="05">05</option>
                          <option value="06">06</option>
                          <option value="07">07</option>
                          <option value="08">08</option>
                          <option value="09">09</option>
                          <option value="10">10</option>
                          <option value="11">11</option>
                          <option value="12">12</option>
                          <option value="13">13</option>
                          <option value="14">14</option>
                          <option value="15">15</option>
                          <option value="16">16</option>
                          <option value="17">17</option>
                          <option value="18">18</option>
                          <option value="19">19</option>
                          <option value="20">20</option>
                          <option value="21">21</option>
                          <option value="22">22</option>
                          <option value="23">23</option>
                          <option value="24">24</option>
                          <option value="25">25</option>
                          <option value="26">26</option>
                          <option value="27">27</option>
                          <option value="28">28</option>
                          <option value="29">29</option>
                          <option value="30">30</option>
                          <option value="31">31</option>
                          <option value=" "> </option>
                        </select>
                        </label>
                        <label></label></td> 
                  </tr>
                  <tr>
                    <td colspan="2"><p>Religion:<br>
                        <label>
                        <input type="checkbox" name="relig[]" value="catholique" />
                        Catholique</label>
                      
                        <label>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="checkbox" name="relig[]" value="protestant" />
                        Protestant</label><br>
                        <label>
                        <input type="checkbox" name="relig[]" value="baptiste" />
                        Baptiste</label>
                       <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                       <input type="checkbox" name="relig[]3" value="Vaudouisant" />
 Vaudouisant</label>
                       <label><br>
                       </label>
                      <label>
                      
                      <input type="checkbox" name="relig[]2" value="temoins de Jehovah" />
Témoins de Jehovah</label>
                      <br />
                    <label></label></td>
                    <td>
                      <label></label>
                    Statut Matrimonial:<br />
                    <label>
<input type="radio" name="statutm" value="celib" id="statutm_0" /> 
C&eacute;libataire</label>
                    <br />
                    <label>
                    <input type="radio" name="statutm" value="marie" id="statutm_1" />
Mari&eacute;(e)</label>
                    <br />
                    <label>
                    <input type="radio" name="statutm" value="divorce" id="statutm_2" />
Divorc&eacute;(e)</label>
                    <br />
                    <label>
                    <input type="radio" name="statutm" value="na" id="statutm_2" />
Non specifi&eacute;</label>
                    </p></td>
                    <td><label>Profession:
                        <select name="profession" id="profession">
                          <option>Informaticien</option>
                          <option>Ingenieur</option>
                          <option>Artiste</option>
                          <option>Infirmier(e)</option>
                          <option>Docteur</option>
                          <option>Comptable</option>
                          <option>Artiste</option>
                          <option selected="selected"></option>
                    </select>
                    </label></td>
                  </tr>
                  <tr>
                    <td colspan="4"><div align="center" class="fonce">Recherche Par Zone:</div></td>
                  </tr>
                  <tr>
                    <td height="27"><label>D&eacute;partement
                      
                <select name="dept" id="dept" onchange="document.forms['form2'].submit();">
                          <option value="-1" selected="selected">- - - Choisissez un departement - - -</option>
    <?php
    for($i = 0; $i < $nb_dept; $i++)
    {
?>
  <option value="<?php echo($code_dept[$i]); ?>"<?php echo((isset($idr) && $idr == $code_dept[$i])?" selected=\"selected\"":null); ?>><?php echo($dept[$i]); ?>
  </option>
<?php
    }
    ?>
</select>
    <?php
    mysql_free_result($rech_dept);
    /* On commence par vérifier si on a envoyé un numéro de région et le cas échéant s'il est différent de -1 */
    if(isset($idr) && $idr != -1)
    {
        /* Cération de la requête pour avoir les départements de cette région */
        $sql2 = "SELECT `id_arron`, `nom_arron` ".
        " FROM `arrondissement`".
        " WHERE `id_dept` = ". $idr ."".
        " ORDER BY `id_arron`;";
        if($connexion != false)
        {
            $rech_arron = mysql_query($sql2, $connexion);
            /* Un petit compteur pour les départements */
            $nd = 0;
            /* On crée deux tableaux pour les numéros et les noms des départements */
            $code_arron = array();
            $nom_arron = array();
            /* On va mettre les numéros et noms des départements dans les deux tableaux */
            while($ligne_arron = mysql_fetch_assoc($rech_arron))
            {
                array_push($code_arron, $ligne_arron['id_arron']);
                array_push($nom_arron, $ligne_arron['nom_arron']);
                $nd++;
            }
            /* Maintenant on peut construire la liste déroulante */
            ?>
                        </select>
                    </label></td>
                    <td><label>Arrondissement<br />
                  <select name="arron" id="arron">
                     <?php  
            for($d = 0; $d<$nd; $d++)
            {
                ?>
  <option value="<?php echo($code_arron[$d]); ?>"<?php echo((isset($arron) && $arron == $code_dept[$d])?" selected=\"selected\"":null); ?>><?php echo($nom_arron[$d]." (". $code_arron[$d] .")"); ?></option>
                <?php
            }
?>
</select>
<?php
        }
        /* Un petit coup de balai */
        mysql_free_result($rech_arron);
  }  
?>
                    </label></td>
                    <td><label>Commune<br />
                    <select name="commune" id="commune">
                    </select>
                    </label></td>
                    <td><label>Section Communale<br />
                  <select name="sectcom" id="sectcom">
                    </select>
                    </label></td>
                  </tr>
                </table>
                
                
                <p>
                  <input type="reset" name="Reset" id="button" value="Annuler" />
                  <label>
                  <input type="submit" name="ok" id="ok" value="Lancer Recherche" />
                  </label>
                  <br />
              </p>
              </div>
              </form>
              <?php
    /* Terminé, on ferme la connexion */
    mysql_close($connexion);
}
else
{
    /* Si on arrive là, c'est pas bon signe, il faut vérifier les 
    * paramètres de connexion, mot de passe, serveur pas démarré etc... */
?>
<p>Un incident s'est produit lors de la connexion à la base de données, veuiillez essayer à nouveau ultérieurement.</p>
<?php
}
?>
              
              <?php
#	AFFoui ICHER LE RESULTAT SI LA RECHERCHE EST EFFECTUEE
#	======================================================
if (isset($_GET['NUM_NIF']) && ($row_rechByNif['NOM_IND'] != ""))
	{
?>
              <div align="center">
   <div class="logoutok"> NIF VALIDE </div><BR>
   <div class="fonce">Résultats</div> 
      <table border="1" id="comliste">
        <tr class="head">
          <td>G_SANG_IND</td>
          <td>SEXE_IND</td>
          <td>NOM_IND</td>
          <td>PRENOM_IND</td>      
        </tr>
        <tr>
          <td><?php echo $row_rechByNif['G_SANG_IND']; ?></td>
          <td><?php echo $row_rechByNif['SEXE_IND']; ?></td>
          <td><?php echo $row_rechByNif['NOM_IND']; ?></td>
          <td><?php echo $row_rechByNif['PRENOM_IND']; ?></td>
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
        <tr>
          <td><?php echo $row_rech_av['G_SANG_IND']; ?></td>
          <td><?php echo $row_rech_av['SEXE_IND']; ?></td>
          <td><?php echo $row_rech_av['NOM_IND']; ?></td>
          <td><?php echo $row_rech_av['PRENOM_IND']; ?></td>
          <td><?php echo $row_rech_av['NUM_NIF']; ?></td>
          <td><?php echo $row_rech_av['PROFESSION']; ?></td>
          <td><?php echo $row_rech_av['EMAIL1']; ?></td>
        </tr>
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
mysql_free_result($Recordset1);

mysql_free_result($loggedUser);
?>