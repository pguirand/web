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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_rech_av = 1;
$pageNum_rech_av = 0;
if (isset($_GET['pageNum_rech_av'])) {
  $pageNum_rech_av = $_GET['pageNum_rech_av'];
}
$startRow_rech_av = $pageNum_rech_av * $maxRows_rech_av;

mysql_select_db($database_connex, $connex);
$query_rech_av = "SELECT * FROM individu";
$query_limit_rech_av = sprintf("%s LIMIT %d, %d", $query_rech_av, $startRow_rech_av, $maxRows_rech_av);
$rech_av = mysql_query($query_limit_rech_av, $connex) or die(mysql_error());
$row_rech_av = mysql_fetch_assoc($rech_av);

if (isset($_GET['totalRows_rech_av'])) {
  $totalRows_rech_av = $_GET['totalRows_rech_av'];
} else {
  $all_rech_av = mysql_query($query_rech_av);
  $totalRows_rech_av = mysql_num_rows($all_rech_av);
}
$totalPages_rech_av = ceil($totalRows_rech_av/$maxRows_rech_av)-1;

$queryString_rech_av = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rech_av") == false && 
        stristr($param, "totalRows_rech_av") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rech_av = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rech_av = sprintf("&totalRows_rech_av=%d%s", $totalRows_rech_av, $queryString_rech_av);

$maxRows_rech_av = 8;
$pageNum_rech_av = 0;
if (isset($_GET['pageNum_rech_av'])) {
  $pageNum_rech_av = $_GET['pageNum_rech_av'];
}
$startRow_rech_av = $pageNum_rech_av * $maxRows_rech_av;

# SEXE
#=====================================

$flagfirst = "oui";	
$fscroll = 130;



	$RechAdv = $_SERVER['PHP_SELF'];
	if(isset($_GET['button2']))
		{
				echo "La recherche est lancee";
				$flagRech = "ON";
				
$var_age1 = $_GET['intage1'];
$var_age2 = $_GET['intage2'];

echo $jm = date('d-m',time());echo '<br>';
echo $an1 = date('Y',time()) - $var_age1;
echo '<br>';
echo $an2 = date('Y',time()) - $var_age2;
echo '<br>';
$ancom1 = $jm."-".$an1;echo '<br>';
$ancom2 = $jm."-".$an2;
echo '<br>';
$conv1= strtotime($ancom1);
$conv2= strtotime($ancom2);
$date1= date('Y-m-d',$conv1); echo $date1;
$date2= date('Y-m-d',$conv2); echo $date2;
echo '<br>';
$age = 0;
        while( $tdate > $dob = strtotime('+1 year', $dob))
        {
                ++$age;
        }
        echo $age;
echo '<br>';
//echo (strftime ('%Y-%m-%d',time()));

$clause_nom = "";
$clause_prenom = "";
$clause_sexe = "";
$clause_prof = "";
$clause_grsang = "";
$clause_matri = "";
$clause_etat = "";

$cl_rel_catho ="";
$cl_rel_prot = "";
$cl_rel_bapt = "";
$cl_rel_vaud = "";
$cl_rel_tem = "";
$clause_ages="";

$clause_sel_jour="";
$clause_sel_mois="";
$clause_sel_an="";

echo $var_nom = $_GET['nom'];
echo $var_prenom = $_GET['prenom'];
echo $var_sexe = $_GET['chsex'];
echo $var_prof = $_GET['chprof'];
echo $var_sang = $_GET['gsang'];
echo $var_matri = $_GET['chstat'];
echo $var_etat = $_GET['etatv'];
echo $var_rel_catho = $_GET['catho'];
echo $var_rel_prot = $_GET['prot'];
echo $var_rel_bapt = $_GET['bapt'];
echo $var_rel_vaud = $_GET['vaud'];
echo $var_rel_tem = $_GET['tem'];
echo $var_rel_pent = $_GET['pent'];

echo '<br>';

echo $var_sel_jour = $_GET['tjour'];
echo $var_sel_mois = $_GET['tmois'];
echo $var_sel_an = $_GET['tan'];

echo '<br>';

if($var_nom!="")
$clause_nom = "NOM_IND = '".$var_nom."'";
if($var_prenom!="")
$clause_prenom = "PRENOM_IND = '".$var_prenom."'";
if($var_sexe!="")
$clause_sexe = "SEXE_IND = '".$var_sexe."'";
if($var_prof!="")
$clause_prof = "PROFESSION = '".$var_prof."'";
if($var_sang!="")
$clause_grsang = "G_SANG_IND = '".$var_sang."'";
if($var_matri!="")
$clause_matri = "STATUT_MATRIMONIAL = '".$var_matri."'";
if($var_etat!="")
$clause_etat = "ETAT = '".$var_etat."'";
if($var_rel_catho!="")
$cl_rel_catho = "RELIGION = '".$var_rel_catho."'";
if($var_rel_prot!="")
$cl_rel_prot = "RELIGION = '".$var_rel_prot."'";
if($var_rel_bapt!="")
$cl_rel_bapt = "RELIGION = '".$var_rel_bapt."'";
if($var_rel_vaud!="")
$cl_rel_vaud = "RELIGION = '".$var_rel_vaud."'";
if($var_rel_tem!="")
$cl_rel_tem = "RELIGION = '".$var_rel_tem."'";
if($var_rel_pent!="")
$cl_rel_pent = "RELIGION = '".$var_rel_pent."'";

if(($var_age1 !="")&&($var_age2 !=""))
$clause_ages="DATEH_NAIS BETWEEN '".$date2."' AND '".$date1."'";

if($var_sel_jour!="")
$clause_sel_jour = "DAY (DATEH_NAIS) = '".$var_sel_jour."'";
if($var_sel_mois!="")
$clause_sel_mois = "MONTH (DATEH_NAIS) = '".$var_sel_mois."'";
if($var_sel_an!="")
$clause_sel_an = "YEAR (DATEH_NAIS) = '".$var_sel_an."'";


//CI-DESSOUS TABLEAU CONTENANT LES COLONNES DES VARIABLES RELIGION
$religion = array($cl_rel_catho,$cl_rel_prot,$cl_rel_bapt,$cl_rel_vaud,$cl_rel_tem,$cl_rel_pent);

$l=0;
while($l<=5)
{
if($religion[$l]!="")
	{
		for($m=1;$m<=5;$m++)
		{
			if($religion[$l-$m] !="")
			{
			$wor = " OR ";
			}
		}
	}
else
for($q=1;$q<=5;$q++)
{
if ($religion[$l+$q]=="")
$wor="";
}
/*if ($religion[$l+1]=="")
$wor="";
else
if ($religion[$l+2]=="")
$wor="";
*/
$addrel = $addrel.$wor.$religion[$l];
$l++;
}
$addrel;
if($addrel=="")
$clause_relig="";
else
$clause_relig="(".$addrel.")";
$clause_relig;

$critere = array($clause_nom,$clause_prenom,$clause_sexe,$clause_prof,$clause_grsang,$clause_matri,$clause_etat,$clause_relig,$clause_ages,$clause_sel_jour,$clause_sel_mois,$clause_sel_an);
$i=0;
while($i<12)
{
if ($critere[$i]!="")
   {
	  for ($n=1;$n<=12 ;$n++)
	  {
		if ($critere[$i-$n]!="") 
		{
			{	
			$conj=" AND ";
			break;
			$ind = $ind+1;
			}
		}		
	  }
	}

else
for($p=1;$p<=12;$p++)
{
	if($critere[$i+$p]=="")
	$conj="";
}

$compil = $compil.$conj.$critere[$i];

$i++;
}	
//echo $compil;
echo '<br>';							

//tester la si la requete est vide
if($compil !="")
$cond="WHERE";
else 
{
$cond="";
$aff= "NON";
}
mysql_select_db($database_connex, $connex);
echo $query_rech_av = ("SELECT * FROM individu ".$cond." ".$compil."");
$query_limit_rech_av = sprintf("%s LIMIT %d, %d", $query_rech_av, $startRow_rech_av, $maxRows_rech_av);
$rech_av = mysql_query($query_limit_rech_av, $connex) or die(mysql_error());
$row_rech_av = mysql_fetch_assoc($rech_av);
$query_rech_av;
		}

?>	
		

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<script language="javascript">
function clearText(field){

    if (field.defaultValue == field.value) field.value = '';
    else if (field.value == '') field.value = field.defaultValue;

}
</script>
<script type="text/javascript">
function toggle(divToShow) {
if (document.getElementById) {
if (divToShow == "select") {
document.getElementById('crit').style.display = "inline";
} else 
	{
	if (divToShow == "result")
	{
	document.getElementById('crit').style.display = "none";
	}
	}
}
}

function pageScroll() {
    	window.scroll(0,document.getElementById('pscroll').value); // horizontal and vertical scroll increments
    	//scrolldelay = setTimeout('pageScroll()',100); // scrolls every 100 milliseconds
}

function critereScroll() {
    	window.scroll(0,130); // horizontal and vertical scroll increments
    	//scrolldelay = setTimeout('pageScroll()',100); // scrolls every 100 milliseconds
}

function resultScroll() {
    	window.scroll(0,500); // horizontal and vertical scroll increments
    	//scrolldelay = setTimeout('pageScroll()',100); // scrolls every 100 milliseconds
}
</script>

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
<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<script type="text/javascript">
function toggledisplay(id)
{ with (document.getElementById(id).style) {
if (display == "none")
display = ""
else display = "none";
}}
</script>
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style13 {font-size: 13px}
-->
</style>
</head>

<body onLoad="pageScroll()">
<div class="screen"><div id="header">
</div>
	          <div id="left"><?php include_once('menuleft.php');?></div>
</div>
<div id="right">
  <p>
  <?php include_once('menuh.php');?>
  <br /><table id="comliste" cellpadding="0" cellspacing="0" align="center"><tr><td>
  <div class="fonce">
    <div align="center">Module	de	Recherche Avanc&eacute;e pour un individu </div>
  </div></td></tr></table><br />
  <form id="form2" name="form2" method="GET" action="<?php echo $RechAdv; ?>">

	<div align="center" id="crit">
      <table width="774" border="0" cellpadding="0" cellspacing="0" id="comliste">
        <tr class="head">
          <td colspan="6"><div align="center" class="fonce">INFORMATIONS PERSONNELLES
            
          </div></td>
        </tr>
        <tr>
          <td>Sexe :<br />
            
              <label>
                <input name="sexe" type="radio" id="sexe_0" onclick="document.getElementById('chsex').value = ''" value="radio" <?php if($var_sexe == '') echo "checked = 'checked'"?> />
                Les Deux</label>
              <br />
              <label>
                <input type="radio" name="sexe" value="radio" id="sexe_1" <?php if($var_sexe == 'Masculin') echo "checked = 'checked'"?> onclick="document.getElementById('chsex').value = 'Masculin'"/>
                Homme</label>
            <br />
              <label>
                <input type="radio" name="sexe" value="radio" id="sexe_2" <?php if($var_sexe == 'Feminin') echo "checked = 'checked'"?> onclick="document.getElementById('chsex').value = 'Feminin'" />
                Femme</label>
              <input name="chsex" id="chsex" type="hidden" size="18" />
              <br />
          </td>
          <td><label></label>
            <label>Nom:<br />
              <input name="nom" type="text" id="nom" size="30" value="<?php echo $var_nom;?>" style=" color:#000; font-style:italic; text-transform:capitalize "onclick="document.getElementById('nom3').style.color ='black'; document.getElementById('nom3').style.fontStyle='normal'"/><br />
              
              Pr&eacute;nom
              :<br />
              <input name="prenom" type="text" id="prenom" size="30" value="<?php echo $var_prenom;?>" style=" color:#000; font-style:italic; text-transform:capitalize" onclick="document.getElementById('prenom3').style.color ='black'; document.getElementById('prenom3').style.fontStyle='normal'"/>
            </label></td>
          <td>Profession:
            <select name="profession" id="profession" onchange="document.getElementById('chprof').value = document.getElementById('profession').value; if(document.getElementById('profession').value=='--Sélectionner--')document.getElementById('chprof').value = ''">
              <option selected="selected">--Sélectionner--</option>
              <option>Informaticien</option>
              <option>Ingenieur</option>
              <option>Artiste</option>
              <option>Infirmier(e)</option>
              <option>Docteur</option>
              <option>Comptable</option>
              <option>Artiste</option>
              <option></option>
          </select> <br />
          <input name="chprof" type="hidden" id="chprof" />
          </td>
          <td colspan="3" id="tdage"> <div align="center">Ages : <br />
          </div>
            <br />
            <div align="center"> entre
              <label>
                <select name="iage1" id="iage1" disabled="disabled" onchange="document.getElementById('intage1').value=document.getElementById('iage1').value">
                  <option selected="selected">0</option>
                  <option>1</option>
                  <option>2</option>
                  <option>3</option>
                  <option>4</option>
                  <option>5</option>
                  <option>6</option>
                  <option>7</option>
                  <option>8</option>
                  <option>9</option>
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
                  <option>32</option>
                  <option>33</option>
                  <option>34</option>
                  <option>35</option>
                  <option>36</option>
                  <option>37</option>
                  <option>38</option>
                  <option>39</option>
                  <option>40</option>
                  <option>41</option>
                  <option>42</option>
                  <option>43</option>
                  <option>44</option>
                  <option>45</option>
                  <option>46</option>
                  <option>47</option>
                  <option>48</option>
                  <option>49</option>
                  <option>50</option>
                  <option>51</option>
                  <option>52</option>
                  <option>53</option>
                  <option>54</option>
                  <option>55</option>
                  <option>56</option>
                  <option>57</option>
                  <option>58</option>
                  <option>59</option>
                  <option>60</option>
                  <option>61</option>
                  <option>62</option>
                  <option>63</option>
                  <option>64</option>
                  <option>65</option>
                  <option>66</option>
                  <option>67</option>
                  <option>68</option>
                  <option>69</option>
                  <option>70</option>
                  <option>71</option>
                  <option>72</option>
                  <option>73</option>
                  <option>74</option>
                  <option>75</option>
                  <option>76</option>
                  <option>77</option>
                  <option>78</option>
                  <option>79</option>
                  <option>80+</option>
                </select>
              </label>
              et
<select name="iage2" id="iage2" disabled="disabled" onchange="document.getElementById('intage2').value=document.getElementById('iage2').value">
                <option>0</option>
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
                <option>6</option>
                <option>7</option>
                <option>8</option>
                <option>9</option>
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
                <option>32</option>
                <option>33</option>
                <option>34</option>
                <option>35</option>
                <option>36</option>
                <option>37</option>
                <option>38</option>
                <option>39</option>
                <option>40</option>
                <option>41</option>
                <option>42</option>
                <option>43</option>
                <option>44</option>
                <option>45</option>
                <option>46</option>
                <option>47</option>
                <option>48</option>
                <option>49</option>
                <option>50</option>
                <option>51</option>
                <option>52</option>
                <option>53</option>
                <option>54</option>
                <option>55</option>
                <option>56</option>
                <option>57</option>
                <option>58</option>
                <option>59</option>
                <option>60</option>
                <option>61</option>
                <option>62</option>
                <option>63</option>
                <option>64</option>
                <option>65</option>
                <option>66</option>
                <option>67</option>
                <option>68</option>
                <option>69</option>
                <option>70</option>
                <option>71</option>
                <option>72</option>
                <option>73</option>
                <option>74</option>
                <option>75</option>
                <option>76</option>
                <option>77</option>
                <option>78</option>
                <option>79</option>
                <option selected="selected">80+</option>
              </select>
              ans</div><br /><input name="intage1" id="intage1" type="text" size="5" /><input name="intage2" id="intage2" type="text" size="5" />
          </td>
        </tr>
        <tr>
          <td width="138" height="88" rowspan="2">Groupe Sanguin <br />
            <select name="G_SANG_IND" class="style16" id="G_SANG_IND" onchange=" document.getElementById('gsang').value= document.getElementById('G_SANG_IND').value;if(document.getElementById('G_SANG_IND').value=='--Choisir--')document.getElementById('gsang').value=''">
              <option selected="selected">--Choisir--</option>
              <option>A+</option>
              <option>A-</option>
              <option>O+</option>
              <option>O-</option>
              <option>B+</option>
              <option>B-</option>
              <option>AB+</option>
              <option>AB-</option>
          </select><br /><input name="gsang" id="gsang" type="text" /></td>
          <td width="165" rowspan="2">Religion <br />
          <label>
              <input type="checkbox" name="relig[]" id="cato" value="catholique" onchange="if (document.getElementById('cato').checked==true)catho.value=cato.value;else catho.value=''"/>
                Catholique</label>
          <label>
            <input name="catho" type="hidden" id="catho" size="10" />
          </label>
          <br />
                      
                <label>
                  <input type="checkbox" name="relig[]" value="protestant" id="protes" onchange="if (document.getElementById('protes').checked==true)prot.value=protes.value;else prot.value=''"/>
                Protestant</label>
                <input name="prot" type="hidden" id="prot" size="10" />
                <br>
                <label>
                  <input type="checkbox" name="relig[]" id="baptc" value="baptiste" onchange="if (document.getElementById('baptc').checked==true)bapt.value=baptc.value;else bapt.value=''" />
                Baptiste</label>
                <input name="bapt" type="hidden" id="bapt" size="10" />
                <br />
               <label>
                 <input type="checkbox" name="relig[]" id="vaudc" value="Vaudouisant" onchange="if (document.getElementById('vaudc').checked==true)vaud.value=vaudc.value;else vaud.value=''"/>
 Vaudouisant</label>
               <label>
                 <input name="vaud" type="hidden" id="vaud" size="10" />
                 <br>
               </label>
              <label>
                      
                <input type="checkbox" name="relig[]" id="temc" value="temoin de Jehovah" onchange="if (document.getElementById('temc').checked==true)tem.value=temc.value;else tem.value=''"/>
Témoins de Jehovah</label>
<input name="tem" type="hidden" id="tem" size="10" /><br />
<label>
                      
                <input type="checkbox" name="relig[]" id="pentc" value="pentecotiste" onchange="if (document.getElementById('pentc').checked==true)pent.value=pentc.value;else pent.value=''"/>
Pentecotiste</label>
            <input name="pent" type="hidden" id="pent" size="10" />
            <br />
<label></label>
          </td>
          <td width="133" rowspan="2">Statut matrimonial:<br />
            
              <label>
                <input name="matri" type="radio" id="matri_0" value="radio" checked="checked" onclick="document.getElementById('chstat').value=''"/>
                Pas specifié</label>
              <br />
              <label>
                <input type="radio" name="matri" value="radio" id="matri_1" onclick="document.getElementById('chstat').value='marier'" />
                Marié(e)</label>
              <br />
              <label>
                <input type="radio" name="matri" value="radio" id="matri_2" onclick="document.getElementById('chstat').value='celibataire'" />
                Célibataire</label>
              <br />
              <label>
                <input type="radio" name="matri" value="radio" id="matri_3" onclick="document.getElementById('chstat').value='veuf(ve)'"/>
                veuf(ve)</label>
               <br /><input name="chstat" id="chstat" type="text" />
          </td>
          <td width="65" align="center" height="20" id="td1">
            <input type="radio" name="dateage" value="radio" id="dateage_0" onclick="document.getElementById('iage1').disabled=false;document.getElementById('iage2').disabled=false;document.getElementById('jour').disabled=true;document.getElementById('mois').disabled=true;document.getElementById('an').disabled=true" onmousemove="document.getElementById('td1').style.backgroundColor='#E9D1D1';document.getElementById('tdage').style.backgroundColor='#E9D1D1'" onmouseout="document.getElementById('td1').style.backgroundColor='white';document.getElementById('tdage').style.backgroundColor='white'" />
<label style="font-size:10px">Ages</label>          </td>
          <td width="134" align="center"><input type="radio" name="dateage" value="radio" id="dateage_1" checked="checked" onclick="document.getElementById('iage1').disabled=true;document.getElementById('iage2').disabled=true;document.getElementById('iage1').value='0';document.getElementById('iage2').value='80+';document.getElementById('intage1').value='';document.getElementById('intage2').value='';document.getElementById('jour').disabled=true;document.getElementById('mois').disabled=true;document.getElementById('an').disabled=true;document.getElementById('jour').value='--Jour--';document.getElementById('mois').value='--Mois--';document.getElementById('an').value='--Année--'"/> 
          <label style="font-size:10px">pas specifie</label>
</td>
          <td width="83" align="center" id="td3"><input type="radio" name="dateage" value="radio" id="dateage_2" onclick="document.getElementById('jour').disabled=false;document.getElementById('mois').disabled=false;document.getElementById('an').disabled=false;document.getElementById('iage1').disabled=true;document.getElementById('iage2').disabled=true;document.getElementById('iage1').value='0';document.getElementById('iage2').value='80+';document.getElementById('intage1').value='';document.getElementById('intage2').value=''" onmousemove="document.getElementById('td3').style.backgroundColor='#E9D1D1';document.getElementById('tddate').style.backgroundColor='#E9D1D1'" onmouseout="document.getElementById('td3').style.backgroundColor='white';document.getElementById('tddate').style.backgroundColor='white'"/>
<label style="font-size:10px">Dates</label></td>
        </tr>
        <tr>
          <td colspan="3" align="center" id="tddate">Dates de naissance<br />
        
            par annee / mois / jour 
            <div style="text-transform:lowercase";"font-size:9px">
              <select name="jour" class="style16" id="jour" disabled="disabled" onchange="if(document.getElementById('jour').value=='--Jour--'){document.getElementById('tjour').value=''}else document.getElementById('tjour').value=document.getElementById('jour').value">
                <option selected="selected">--Jour--</option>
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
              &nbsp;&nbsp;
  <select name="mois" class="style16" id="mois" disabled="disabled" onchange="if(document.getElementById('mois').value=='--Mois--'){document.getElementById('tmois').value=''} else document.getElementById('tmois').value=document.getElementById('mois').value">
    <option selected="selected">--Mois--</option>
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
  &nbsp;&nbsp;
  <select name="an" class="style16" id="an" disabled="disabled" onchange="if(document.getElementById('an').value=='--Année--'){document.getElementById('tan').value=''} else document.getElementById('tan').value=document.getElementById('an').value">
    <option selected="selected">--Ann&eacute;e--</option>
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
    <option>1960</option>
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
          </div><br />
          <input name="tjour" id="tjour" type="text" size="10" />
          <input name="tmois" id="tmois" type="text" size="10" />
          <input name="tan" id="tan" type="text" size="10" />
          </td>
        </tr>
        <tr>
          <td height="88">Possède enfant(s): <br />
            
              <label>
                <input type="radio" name="enf" value="radio" id="enf_0" onclick="document.getElementById('nbenf').disabled =false"/>
                Oui</label>
              <br />
              <label>
                <input type="radio" name="enf" value="radio" id="enf_1" onclick="document.getElementById('nbenf').disabled =true"/>
                Non</label>
              <br />
              <label>
                <input name="enf" type="radio" id="enf_2" value="radio" checked="checked" onclick="document.getElementById('nbenf').disabled =true" />
                Pas spécifié</label>
              <br />
          <br /></td>
          <td>Nombre d'enfants :<br />
          <select name="nbenf" id="nbenf" disabled="disabled">
           		<option selected="selected">--</option>
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
                <option>6</option>
                <option>7</option>
                <option>8</option>
                <option>+ 8</option>
                
          </select></td>
          <td>Etat<br />
             <label>
                <input name="etat" type="radio" id="etat_0" onclick="document.getElementById('etatv').value='';document.getElementById('jourd').disabled=true;document.getElementById('moisd').disabled=true;document.getElementById('and').disabled=true" value="radio" checked="checked"/>
                NON specifie</label>
             <br />
              <label>
                <input name="etat" type="radio" id="etat_1" value="radio" onclick="document.getElementById('jourd').disabled=true;document.getElementById('moisd').disabled=true;document.getElementById('and').disabled=true;document.getElementById('etatv').value='vivant'"/>
                Vivant</label>
              <br />
              <label>
                <input type="radio" name="etat" value="radio" id="etat_2" onclick="document.getElementById('jourd').disabled=false;document.getElementById('moisd').disabled=false;document.getElementById('and').disabled=false;document.getElementById('etatv').value='decede(e)'"/>
                Decede(e)</label>
              <br /><input name="etatv" id="etatv" type="text" />
         </td>
          <td colspan="3" align="center">Dates de deces<br />
par annee / mois / jour<br />
<div style="text-transform:lowercase";"font-size:9px">
  <select name="jourd" class="style16" id="jourd" disabled="disabled">
    <option selected="selected">--Jour--</option>
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
  &nbsp;&nbsp;
  <select name="moisd" class="style16" id="moisd" disabled="disabled">
    <option selected="selected">--Mois--</option>
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
  &nbsp;&nbsp;
  <select name="and" class="style16" id="and" disabled="disabled">
    <option selected="selected">--Année-</option>
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
    <option>1960</option>
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
</div></td>
        </tr>
      </table>
                
                
      <p>
        <input type="reset" name="Reset" id="button" value="Annuler" />
        <label>
          <input type="submit" name="button2" id="button2" value="Lancer Recherche"/>
        </label>
        <br />
      </p>
    </div>
  </form>
  <table id="comliste" cellpadding="0" cellspacing="0" align="center"><tr align="center"><td>
  <a href="javascript:critereScroll()" title="Afficher sélections"> Afficher Sélections </a>
  </td>
  <td>
  <a href="javascript:resultScroll()" title="Afficher Résultats">Voir Résultats </a>
  </td></tr>
  </table>
  <br />
	<?php 
		if ($flagRech == "ON")
		  	{
			if (($row_rech_av['G_SANG_IND'] != "") && ($aff=="NON"))
			{
			$fscroll=220;
			echo "<div align='center' class='warning'>Vous devez au moins selectionner un critere de recherche</div>";
			}
			
			else
			if($row_rech_av['G_SANG_IND'] != "")
			{
		
	?>
			  <table border="0" id="comlisteb" cellpadding="0" cellspacing="0" align="center">
		<tr class="header">
		  <td colspan="9" align="center" style="background-color:#FDF3F2"><u><strong class="fonce">Résultats</strong></u></td></tr>
        <tr class="head" style="font-size:9px">
		  <td width="85">NOM</td>
          <td width="95">PRENOM</td>
          <td width="20">SEXE</td>
          <td width="20">G.S.</td>	
          <td width="30">Date de Naisance</td>		
          <td width="30">Religion</td>
		  <td width="50">PROFESSION</td>
          <td width="20"> No. NIF</td>
		 
		  <td colspan="3">Actions</td>
		</tr>
		<?php do { ?>
			<tr <?php if ($row_rech_av['ETAT'] == "decede(e)") {?> style="background-color:#E9D1D1"<?php }?>>
			  <td>&nbsp;<?php echo strtoupper($row_rech_av['NOM_IND']); ?></td>
			  <td>&nbsp;<?php echo ucfirst(strtolower($row_rech_av['PRENOM_IND'])); ?></td>
			  <td>&nbsp;<?php echo ucfirst(strtolower($row_rech_av['SEXE_IND'])); ?></td>
			  <td>&nbsp;<?php echo $row_rech_av['G_SANG_IND']; ?></td>
              <td>&nbsp;<?php $datena=strtotime($row_rech_av['DATEH_NAIS']); echo date('d-m-Y',$datena);  ?></td>
              <td>&nbsp;<?php echo ucfirst(strtolower($row_rech_av['RELIGION'])); ?></td>
			  <td>&nbsp;<?php echo ucfirst(strtolower($row_rech_av['PROFESSION'])); ?></td>
			  <td>&nbsp;<?php echo $row_rech_av['NUM_NIF']; ?></td>
			  <td><a href="updind.php?ID_IND=<?php echo $row_rech_av['ID_IND']; ?>" title="Modifier Individu"><img src="images/pencilart.jpeg" width="20" height="20"  border="0" /></a></td>
				<td><a href="viewind.php?ID_IND=<?php echo $row_rech_av['ID_IND']; ?>" title="Visualiser Individu"><img src="images/eyeart.jpeg" width="20" height="20"  border="0" /></a></td> 
			   <?php if (($groupe == "administrateur archives")|| ($groupe == "operateur archives")){?>
			 <td><a href="filenais.php?ID_IND=<?php echo $row_rech_av['ID_IND']; ?>" title="Voir Document"><img src="images/adobe1.jpg" width="20" height="20"  border="0" /></a></td>
			 <?php }?>
			</tr>
			<?php } while ($row_rech_av = mysql_fetch_assoc($rech_av)); ?>
	  </table><br /><table border="1" style="border-style:inset" width="206" align="center" cellpadding="0" cellspacing="0">
      <tr><td colspan="2"><div align="center">Légendes</div></td></tr>
      <tr>
      <td width="79"><div align="center">D&eacute;c&eacute;d&eacute;(e)</div></td>
      <td width="121"><div align="center"><hr width="100" color="#E9D1D1"size="15" style="" /></div></td></tr>
      <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td></tr>
      </table><br />
  <table border="0" align="center">
  <tr>
    <td><?php if ($pageNum_rech_av > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_rech_av=%d%s", $currentPage, 0, $queryString_rech_av); ?>">First</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_rech_av > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_rech_av=%d%s", $currentPage, max(0, $pageNum_rech_av - 1), $queryString_rech_av); ?>">Previous</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_rech_av < $totalPages_rech_av) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_rech_av=%d%s", $currentPage, min($totalPages_rech_av, $pageNum_rech_av + 1), $queryString_rech_av); ?>">Next</a>
        <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_rech_av < $totalPages_rech_av) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_rech_av=%d%s", $currentPage, $totalPages_rech_av, $queryString_rech_av); ?>">Last</a>
        <?php } // Show if not last page ?></td>
  </tr>
</table>
      <br />
      Records <?php echo ($startRow_rech_av + 1) ?> to <?php echo min($startRow_rech_av + $maxRows_rech_av, $totalRows_rech_av) ?> of <?php echo $totalRows_rech_av ?><br />
	<?php
	$fscroll = 500;
					}
				else
				{
				$fscroll=220;
				echo "<div align='center' class='warning'>Aucun individu trouvé avec ces critères</div>";
				}
			}
			
	?>
  
  <span class="fonce">
  <input type="hidden" name="pscroll" id="pscroll" value="<?php echo $fscroll;?>"/>
</span></div>

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
<?php
mysql_free_result($rech_av);
 /*?><?php
mysql_free_result($rech_av);

mysql_free_result($loggedUser);
?><?php */?>
