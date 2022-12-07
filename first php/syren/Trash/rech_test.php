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
              <form id="form2" name="form2" method="post" action="<?php echo $rechByNifAction; ?>">
                <div align="center">
                  <table width="600" border="1">
                    <tr>
                      <td colspan="4"><div class="fonce">
                          <div align="center">Recherche par Identifiant</div>
                      </div></td>
                    </tr>
                    <tr>
                      <td colspan="2">No d'identificantion :<br />
                          <label>
                          <input name="choixId" type="radio" id="RadioGroup1_0" value="NIF" 
						  	<?php 
								if($_GET['choixId'] == "NIF") 
						  			echo "checked='checked'";
								else if($_GET['choixId'] == "")
						  			echo "checked='checked'";
							?>  />
                            NIF</label>
                          <br />
                          <label>
                          <input type="radio" name="choixId" value="CIF" <?php if($_GET['choixId'] == "CIF") echo "checked='checked'" ?>  id="RadioGroup1_1" />
                            CIF &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp; </label>
                          <input name="NUM_NIF" type="text" id="NUM_NIF" value="<?php echo $_GET['NUM_NIF'] ?>" maxlength="10" />
                          <br />
                          <label>
                          <input type="radio" name="choixId" value="NUM_PASSPORT" <?php if($_GET['choixId'] == "NUM_PASSPORT") echo "checked='checked'" ?>  id="RadioGroup1_2" />
                            No Passeport</label>
                          <label></label>
                      </td>
                      <td><p>Email: (si possede):<br />
                              <label>
                              <input type="text" name="email" id="email"/>
                              </label>
                      </p></td>
                      <td><label></label>
                        Nom Utlisateur (si existe):<br />
                        <label>
                          <input type="text" name="username" id="username" />
                        </label>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="4"><div align="center" class="fonce">INFORMATIONS PERSONNELLES</div></td>
                    </tr>
                    <tr>
                      <td width="118">Par Sexe :<br />
                          <label>
                          <input type="radio" name="Sexe" value="garcons" id="Sexe_0" />
                            Garcons</label>
                          <br />
                          <label>
                          <input type="radio" name="Sexe" value="filles" id="Sexe_1" />
                            Filles</label>
                          <br />
                          <label>
                          <input name="Sexe" type="radio" id="Sexe_2" value="lesdeux" checked="checked" />
                            Les deux</label>
                      </td>
                      <td width="149"><label></label>
                          <label>Nom
                            :
                            <input type="text" name="nom" id="nom"/>
                            Pr&eacute;nom
                            :
                            <input type="text" name="prenom" id="prenom" />
                        </label></td>
                      <td width="144"><p>Tranche d'age:<br />
                        Entre
                        <label>
                <select name="age1" id="age1">
                </select>
                </label>
                        et
                        <label>
                          <select name="age2" id="age2">
                          </select>
                        </label>
                      </p></td>
                      <td width="159"><p> Date de naissance:<br />
                              <label>
                              <input type="checkbox" name="an" id="an" />
                                Ann&eacute;e</label>
                              <label>
                              <select name="an2" id="an2">
                              </select>
                              </label>
                              <br />
                              <label>
                              <input type="checkbox" name="mois" id="mois" />
                                Mois  &nbsp;&nbsp;</label>
                              <label>
                              <select name="mois2" id="mois2">
                              </select>
                              </label>
                              <br />
                              <label>
                              <input type="checkbox" name="date" id="date" />
                                Date &nbsp;&nbsp;</label>
                              <label>
                              <select name="date2" id="date2">
                              </select>
                              </label>
                              <label></label>
                      </p></td>
                    </tr>
                    <tr>
                      <td colspan="2"><p>Religion:<br />
                              <label>
                              <input type="checkbox" name="catho" id="catho" />
                                Catholique</label>
                              <label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                              <input type="checkbox" name="protest" id="protest" />
                                Protestant</label>
                        <br />
                              <label>
                              <input type="checkbox" name="bapt" id="bapt" />
                                Baptiste</label>
                              <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                              <input type="checkbox" name="temoins" id="temoins" />
                                T&eacute;moins de Jehovah<br />
                        </label>
                              <label>
                              <input type="checkbox" name="Vodou" id="Vodou" />
                                Vodouisant</label>
                              <label> &nbsp;&nbsp;&nbsp;&nbsp;
                              <input type="checkbox" name="ns" id="ns" />
                                Non Specifi&eacute;</label>
                              <br />
                              <label></label>
                      </p></td>
                      <td><label></label>
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
                            </select>
                      </label></td>
                    </tr>
                    <tr>
                      <td colspan="4"><div align="center" class="fonce">Recherche Par Zone:</div></td>
                    </tr>
                    <tr>
                      <td height="27"><label>D&eacute;partement
                        <select name="dept" id="dept">
                            </select>
                      </label></td>
                      <td><label>Arrondissement
                        <select name="arrond" id="arrond">
                            </select>
                      </label></td>
                      <td><label>Commune
                        <select name="commune" id="commune">
                            </select>
                      </label></td>
                      <td><label>Section Communale
                        <select name="sectcom" id="sectcom">
                            </select>
                      </label></td>
                    </tr>
                  </table>
                </div>
              </form>
              <p>&nbsp;		      </p>
              <p>
              <br /><br /><br />
              </p><div class="warning"> 
                <p>&nbsp;</p>
                </div>
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
<?php
mysql_free_result($loggedUser);
?>
