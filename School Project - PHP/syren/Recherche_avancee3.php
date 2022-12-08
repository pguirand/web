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




	$RechAdv = $_SERVER['PHP_SELF'];
	if(isset($_GET['button2']))
		{
				echo "La recherche est lancee";
				$flagRech = "ON";
				

$cond = "";
$clause_nom = "";
$clause_prenom = "";
$clause_sexe = "";
$clause_prof = "";
$clause_grsang = "";
$clause_matri = "";
$clause_etat = "";


echo $var_nom = $_GET['nom'];
echo $var_prenom = $_GET['prenom'];
echo $var_sexe = $_GET['chsex'];
echo $var_prof = $_GET['chprof'];
echo $var_sang = $_GET['gsang'];
echo $var_matri = $_GET['chstat'];
echo $var_etat = $_GET['etatv'];

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




$critere = array($clause_nom,$clause_prenom,$clause_sexe,$clause_prof,$clause_grsang);
$i=0;
while($i<5)
{
	/*$n=0;
	while($n<$i)
	{
	if(($critere[$i])!="")
	$c="AND";
	$n++;
	}*/	
if(($critere[$i])!="")
	{
	$n=$i;// $n<$i;n++)
	echo '<br>';
	echo $n; 
/*	{
	if(($critere[$n]!=""))
	$cod="AND";
	else
	$cod="";
	}*/
	}
echo $cod;	
echo $critere[$i];
//echo $c;
//echo '<br>';
$i++;
}

/*if($var_nom != "") // champ nom individu pas vide
	{
	$cond = "where";																																																																														
	$clause_nom = "NOM_IND = '".$var_nom."'";
	}

if($var_prenom != "")
	{
	$cond = "where";
	if($var_nom != "")
	{
	$clause_nom = "NOM_IND = '".$var_nom."' AND";
	$clause_prenom = "PRENOM_IND = '".$var_prenom."'";
	}
	else
	$clause_prenom = "PRENOM_IND = '".$var_prenom."'";
	}
	
	if($var_sexe != "")
	{
	{
	$cond = "where";
	$clause_sexe = "SEXE_IND = '".$var_sexe."'";
	}
	if(($var_nom!="") && ($var_prenom != ""))
	{
	$clause_nom = "NOM_IND = '".$var_nom."' AND";
	$clause_prenom = "PRENOM_IND = '".$var_prenom."' AND";
	}
	if(($var_nom!="") && ($var_prenom == ""))
	{
	$clause_nom = "NOM_IND = '".$var_nom."' AND";
	}
	if(($var_nom=="") && ($var_prenom != ""))
	{
	$clause_prenom = "PRENOM_IND = '".$var_prenom."' AND";
	}
	}
if ($var_prof != "")
	{
	{	
	$cond = "where";
	$clause_prof = "PROFESSION = '".$var_prof."'";
	}
	if($var_nom != "")
	{
	if(($var_prenom=="") && ($var_sexe ==""))
	{
	$clause_nom = "NOM_IND = '".$var_nom."' AND";
	}
	if(($var_prenom=="") && ($var_sexe !=""))
	{
	$clause_sexe = "SEXE_IND = '".$var_sexe."' AND";
	}
	if(($var_prenom!="") && ($var_sexe ==""))
	{
	$clause_nom = "NOM_IND = '".$var_nom."' AND";
	$clause_prenom = "PRENOM_IND = '".$var_prenom."' AND";
	}
	if(($var_prenom!="") && ($var_sexe !=""))
	{
	$clause_prenom = "PRENOM_IND = '".$var_prenom."' AND";
	$clause_sexe = "SEXE_IND = '".$var_sexe."' AND";
	}
	}
	else
	{
		if(($var_prenom=="") && ($var_sexe !=""))
		{
		$clause_sexe = "SEXE_IND = '".$var_sexe."' AND";
		}
	    if(($var_prenom!="") && ($var_sexe ==""))
		{
		$clause_prenom = "PRENOM_IND = '".$var_prenom."' AND";
		}
		if(($var_prenom!="") && ($var_sexe !=""))
		{
		$clause_prenom = "PRENOM_IND = '".$var_prenom."' AND";
		$clause_sexe = "SEXE_IND = '".$var_sexe."' AND";
		}
		}
	}
	if($var_sang !="")
	{
	{
	echo "test";
	$cond="where";
	$clause_grsang = "G_SANG_IND = '".$var_sang."'";
	}
	
		if($var_nom!="")
		{
			if($var_prenom!="")
			{
				{
					$clause_nom = "NOM_IND = '".$var_nom."' AND";
					$clause_prenom = "PRENOM_IND = '".$var_prenom."' AND";
				}
				if(($var_sexe=="") && ($var_prof!=""))
				{
					$clause_prof = "PROFESSION = '".$var_prof."' AND";
				}
				if(($var_sexe!="") && ($var_prof==""))
				{
					$clause_sexe = "SEXE_IND = '".$var_sexe."' AND";
				}
				if(($var_sexe!="") && ($var_prof!=""))
				{
					$clause_sexe = "SEXE_IND = '".$var_sexe."' AND";
					$clause_prof = "PROFESSION = '".$var_prof."' AND";
				}
			}
			else
			{
				$clause_nom = "NOM_IND = '".$var_nom."' AND";
				if(($var_sexe=="") && ($var_prof!=""))
				{
					$clause_prof = "PROFESSION = '".$var_prof."' AND";
				}
				if(($var_sexe!="") && ($var_prof==""))
				{
					$clause_sexe = "SEXE_IND = '".$var_sexe."' AND";
				}
				if(($var_sexe!="") && ($var_prof!=""))
				{
					$clause_sexe = "SEXE_IND = '".$var_sexe."' AND";
					$clause_prof = "PROFESSION = '".$var_prof."' AND";
				}
		}
	}
	else
	{
		
			if($var_prenom!="")
			{
				{
					$clause_prenom = "PRENOM_IND = '".$var_prenom."' AND";
				}
				if(($var_sexe=="") && ($var_prof!=""))
				{
					$clause_prof = "PROFESSION = '".$var_prof."' AND";
				}
				if(($var_sexe!="") && ($var_prof==""))
				{
					$clause_sexe = "SEXE_IND = '".$var_sexe."' AND";
				}
				if(($var_sexe!="") && ($var_prof!=""))
				{
					$clause_sexe = "SEXE_IND = '".$var_sexe."' AND";
					$clause_prof = "PROFESSION = '".$var_prof."' AND";
				}
			}
			else
			{
				if(($var_sexe=="") && ($var_prof!=""))
				{
					$clause_prof = "PROFESSION = '".$var_prof."' AND";
				}
				if(($var_sexe!="") && ($var_prof==""))
				{
					$clause_sexe = "SEXE_IND = '".$var_sexe."' AND";
				}
				if(($var_sexe!="") && ($var_prof!=""))
				{
					$clause_sexe = "SEXE_IND = '".$var_sexe."' AND";
					$clause_prof = "PROFESSION = '".$var_prof."' AND";
				}
		}
	
	}
	}*/
	

							
			
							
		
mysql_select_db($database_connex, $connex);
$query_rech_av = ("SELECT * FROM individu ".$cond." ".$clause_nom." ".$clause_prenom." ".$clause_sexe." ".$clause_prof." ".$clause_grsang." ".$clause_matri." ".$clause_etat." ");
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
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style13 {font-size: 13px}
-->
</style>
</head>

<body>
	        <div class="screen"><div id="header">
</div>
	          <div id="left"><?php include_once('menuleft.php');?></div>
	  </div>
<div id="right">
  <p>
  <?php include_once('menuh.php');?>
  <div class="fonce">
    <div align="center">Module	de	Recherche Avanc&eacute;e pour un individu </div>
  </div>
  <form id="form2" name="form2" method="GET" action="<?php echo $RechAdv; ?>">
    <div align="center">
      <table width="774" border="0" cellpadding="0" cellspacing="0" id="comliste">
        <tr class="head">
          <td colspan="4"><div align="center" class="fonce">INFORMATIONS PERSONNELLES</div></td>
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
          <td> <div align="center">Ages : <br />
          </div>
           
            <table border="0" cellspacing="0" cellpadding="0">
            <tr><td width="149">
              <label>
                <input type="radio" name="intage" value="radio" id="intage_0" checked="checked" onclick="document.getElementById('age1').disabled=true;document.getElementById('age2').disabled=true;document.getElementById('age1').value='0';document.getElementById('age2').value='80+'"/>
                Non specifié</label></td>
 <td width="125">          
              <label>
                <input type="radio" name="intage" value="radio" id="intage_1" onclick="document.getElementById('age1').disabled=false;document.getElementById('age2').disabled=false"/>
                 Intervalle</label></td></tr></table>
        
<br />
            <div align="center"> entre
              <label>
                <select name="age1" id="age1" disabled="disabled">
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
<select name="age2" id="age2" disabled="disabled">
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
              ans</div>
            </p></td>
        </tr>
        <tr>
          <td width="138" height="88">Groupe Sanguin <br />
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
          <td width="165">Religion <br />
          <label>
                  <input type="checkbox" name="relig[]" value="catholique" />
                Catholique</label><br />
                      
                <label>
                  <input type="checkbox" name="relig[]" value="protestant" />
                Protestant</label><br>
                <label>
                  <input type="checkbox" name="relig[]" value="baptiste" />
                Baptiste</label><br />
               <label>
                 <input type="checkbox" name="relig[]3" value="Vaudouisant" />
 Vaudouisant</label>
               <label><br>
               </label>
              <label>
                      
                <input type="checkbox" name="relig[]2" value="temoins de Jehovah" />
Témoins de Jehovah</label>
              <br />
          <label></label>
          </td>
          <td width="133">Statut matrimonial:<br />
            
              <label>
                <input name="matri" type="radio" id="matri_0" value="radio" checked="checked" onclick="document.getElementById('chstat').value=''"/>
                Pas specifié</label>
              <br />
              <label>
                <input type="radio" name="matri" value="radio" id="matri_1" onclick="document.getElementById('chstat').value='marie(e)'" />
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
          <td width="282" align="center">Dates de naissance<br />
          par annee / mois / jour<br />
           
                      <div style="text-transform:lowercase";"font-size:9px"> 
                        <select name="jour" class="style16" id="jour">
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
              
         
                <select name="mois" class="style16" id="mois">
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
                </select>&nbsp;&nbsp;
                <select name="an" class="style16" id="an">
              	  <option selected="Année">--Année--</option>
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
              </div>
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
          <td align="center">Dates de deces<br />
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
	<?php 
		if ($flagRech == "ON")
		  	{
				if ($row_rech_av['G_SANG_IND'] != "")
					{
	?>
			  <table border="0" id="comliste" cellpadding="0" cellspacing="0" align="center">
		<tr class="head">
		  <td>G_SANG_IND</td>
		  <td>SEXE_IND</td>
		  <td>NOM_IND</td>
		  <td>PRENOM_IND</td>
		  <td>NUM_NIF</td>
		  <td>PROFESSION</td>
		  <td colspan="3">Actions</td>
		</tr>
		<?php do { ?>
			<tr>
			  <td>&nbsp;<?php echo $row_rech_av['G_SANG_IND']; ?></td>
			  <td>&nbsp;<?php echo $row_rech_av['SEXE_IND']; ?></td>
			  <td>&nbsp;<?php echo $row_rech_av['NOM_IND']; ?></td>
			  <td>&nbsp;<?php echo $row_rech_av['PRENOM_IND']; ?></td>
			  <td>&nbsp;<?php echo $row_rech_av['NUM_NIF']; ?></td>
			  <td>&nbsp;<?php echo $row_rech_av['PROFESSION']; ?></td>
			  <td><a href="updind.php?ID_IND=<?php echo $row_rech_av['ID_IND']; ?>" title="Modifier Individu"><img src="images/pencilart.jpeg" width="20" height="20"  border="0" /></a></td>
				<td><a href="viewind.php?ID_IND=<?php echo $row_rech_av['ID_IND']; ?>" title="Visualiser Individu"><img src="images/eyeart.jpeg" width="20" height="20"  border="0" /></a></td> 
			   <?php if (($groupe == "administrateur archives")|| ($groupe == "operateur archives")){?>
			 <td><a href="filenais.php?ID_IND=<?php echo $row_rech_av['ID_IND']; ?>" title="Voir Document"><img src="images/adobe1.jpg" width="20" height="20"  border="0" /></a></td>
			 <?php }?>
			</tr>
			<?php } while ($row_rech_av = mysql_fetch_assoc($rech_av)); ?>
	  </table>
	<?php
					}
				else echo "vous n'avez aucun resultat";
			}
	?>
  
</div>

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
mysql_free_result($rech_av);

mysql_free_result($loggedUser);
?><?php */?>
