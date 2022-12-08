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
$query_departement = "SELECT * FROM departement";
$departement = mysql_query($query_departement, $connex) or die(mysql_error());
$row_departement = mysql_fetch_assoc($departement);
$totalRows_departement = mysql_num_rows($departement);
$ID_DEPT = $row_departement ['id_dept'];

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
/*if (!isset($_POST['relig']))
	{
		$affichTable = "1"; 
		mysql_select_db($database_connex, $connex);
		echo $query_rech_av = ("SELECT ID_IND, G_SANG_IND, SEXE_IND, NOM_IND, PRENOM_IND, NUM_NIF, NUM_CIF, PROFESSION, NUM_PASSPORT, EMAIL1 FROM individu ".$cond." ".$clause_nom." ".$clause_prenom." ".$clause_sexe." ".$clause_profession."");
		$query_limit_rech_av = sprintf("%s LIMIT %d, %d", $query_rech_av, $startRow_rech_av, $maxRows_rech_av);
		$rech_av = mysql_query($query_limit_rech_av, $connex) or die(mysql_error());
		$row_rech_av = mysql_fetch_assoc($rech_av);
		$query_rech_av;
	}
	*/
	
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
$RechAdv = $_SERVER['PHP_SELF'];
	if(isset($_GET['button2']))
		{
				$affichTable = "1";
				
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
		}
/*
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
	*/
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
<?php include_once('menuh.php');?>
  </p>
  <div class="fonce">
    <div align="center">Module	de	Recherche Avanc&eacute;e pour un individu </div>
  </div>

  <form id="form2" name="form2" method="GET" action="<?php echo $RechAdv; ?>">
    <div align="center">
      <table width="600" border="0" cellpadding="0" cellspacing="0" id="comliste">
        <tr class="head">
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
      </table>
                
                
      <p>
        <input type="reset" name="Reset" id="button" value="Annuler" />
        <label>
          <input type="submit" name="button2" id="button2" value="Lancer Recherche" />
        </label>
        <br />
      </p>
    </div>
              
     <?php
	 if(isset($affichTable) && ($affichTable == "1"))
	 	{
	 ?>
    <table border="0" id="comliste" cellpadding="0" cellspacing="0">
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
          <td><?php echo $row_rech_av['NOM_IND']; ?></td>
          <td><?php echo $row_rech_av['PRENOM_IND']; ?></td>
          <td><?php echo $row_rech_av['NUM_NIF']; ?></td>
          <td><?php echo $row_rech_av['PROFESSION']; ?></td>
          <td><?php echo $row_rech_av['EMAIL1']; ?></td>
        </tr>
        <?php } while ($row_rech_av = mysql_fetch_assoc($rech_av));; ?>
    </table>
    <?php
		}
	  ?>

  </form>
              
  <?php /*?>          <?php
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
    
    </div><?php */?>
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
</div>
<div class="spacer"></div>
		<div id="footer">
			<div class="content">
			<img src="Logo.jpg" width="116" height="49" /> <a href="#">A propos de nous </a> | <a href="#">Plan du Site </a> | <a href="#">R&egrave;gle d'utilisation </a> | <a href="#">Contactez-nous</a> | &copy;2009 SYREN
			</div>
		</div>
</div>
</body>
</html>
<?php /*?><?php
mysql_free_result($departement);

mysql_free_result($rech_av);

mysql_free_result($loggedUser);
?><?php */?>
