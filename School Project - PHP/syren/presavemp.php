<?php require_once('Connections/connex.php'); ?>
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

$colname_Voir_ind = "-1";
if (isset($_GET['ID_IND'])) {
  $colname_Voir_ind = $_GET['ID_IND'];
}
mysql_select_db($database_connex, $connex);
$query_Voir_ind = sprintf("SELECT * FROM individu WHERE ID_IND = %s", GetSQLValueString($colname_Voir_ind, "text"));
$Voir_ind = mysql_query($query_Voir_ind, $connex) or die(mysql_error());
$row_Voir_ind = mysql_fetch_assoc($Voir_ind);
$totalRows_Voir_ind = mysql_num_rows($Voir_ind);


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
				case	"PAT"			:	$champs = "NUM_PATENTE";
											break;
				case	"NOM"			:	$champs = "NOM_ENTITE";
											break;
				case	"SIGLE"			:	$champs = "SIGLE";
											break;		
			}
		
		/*$maxRows_rechByNif = 4;
		$pageNum_rechByNif = 0;
		if (isset($_GET['pageNum_rechByNif'])) {
		  $pageNum_rechByNif = $_GET['pageNum_rechByNif'];
		}
		$startRow_rechByNif = $pageNum_rechByNif * $maxRows_rechByNif;
		*/
	$colname_rechByNif = "-1";
		if (isset($_GET['rech'])) {
		  $colname_rechByNif = $_GET['rech'];		}		
			mysql_select_db($database_connex, $connex);
			$query_rechByNif = sprintf("SELECT * FROM entite WHERE ".$champs." = %s ORDER BY ".$champs." ASC", GetSQLValueString($colname_rechByNif, "text"));
			$rechByNif = mysql_query($query_rechByNif, $connex) or die(mysql_error());
			$row_rechByNif = mysql_fetch_assoc($rechByNif);
			$totalRows_rechByNif = mysql_num_rows($rechByNif);		
	}
/*if (isset($_GET['totalRows_rechByNif'])) {
  $totalRows_rechByNif = $_GET['totalRows_rechByNif'];
} else {
  $all_rechByNif = mysql_query($query_rechByNif);
  $totalRows_rechByNif = mysql_num_rows($all_rechByNif);
}
$totalPages_rechByNif = ceil($totalRows_rechByNif/$maxRows_rechByNif)-1;*/
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/index.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
<!-- InstanceBeginEditable name="doctitle" -->
<title>Untitled Document</title>
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
<!-- InstanceBeginEditable name="head" -->
<style type="text/css">
<!--
#apDiv1 {
	position:absolute;
	left:728px;
	top:551px;
	width:138px;
	height:30px;
	z-index:1;
}
-->
</style>
<!-- InstanceEndEditable -->
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
            <li><a class="MenuBarItemSubmenu" href="#">Entites</a>
                <ul>
                  <li><a href="saveentites.php">Enregistrer</a></li>
                  <li><a href="list_entites.php">Lister</a></li>
                  <li><a href="rech_simple_entite.php">Rechercher</a></li>
                  <li><a href="Error.php">Recherche avanc&eacute;e</a></li>
              </ul>
            </li>
		    <li><a href="#" class="MenuBarItemSubmenu">Individus</a>
                <ul>
                  <li><a href="rech_simple_ind.php">Rechercher</a></li>
                  <li><a href="Error.php">Recherche avanc&eacute;e</a></li>
                </ul>
	        </li>
		    <li><a class="MenuBarItemSubmenu" href="#">Utilisateurs</a>
                <ul>
                  <li><a href="presaveuser.php">Cr&eacute;er</a>                      </li>
                  <li><a href="liste_user.php">Lister</a></li>
                  <li><a href="Error.php">Recherche</a></li>
                </ul>
	        </li>
		    <li><a href="Error.php">Actualites</a></li>
		    <li><a href="Error.php">Forums</a></li>
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


		      <h2 align="center">PROCESSUS DE SOUMISSION D'EMPLOI</h2>
		      <p align="justify">&nbsp;</p>
<form id="form2" name="form2" method="GET" action="<?php echo $rechByNifAction; ?>">
                 
                  <h3 align="center">Enregistrement d'emploi pour Mr / Mme</h3>
                  <div align="center">  
                    <p><?php echo $row_Voir_ind['NOM_IND']; ?><br />
                    <?php echo $row_Voir_ind['PRENOM_IND']; ?>
                    <p>&nbsp;</p>
                  </div>
<table width="319" height="156" border="1" id="comliste" align="center">
                    <tr class="head">
                      <td colspan="2"><div align="center">IDENTIFIANT</div></td>
                    </tr>
                    <tr>
                      <td width="154"><label>
                        <input name="rech" type="text" id="rech" value="<?php echo $_GET['NUM_PATENTE'] ?>" maxlength="60" />
                      </label></td>
                      <td width="160"><p>
                        <label>
                          <input name="choixId" type="radio" id="RadioGroup1_0" value="PAT" 
						  	<?php 
								if($_GET['choixId'] == "PAT") 
						  			echo "checked='checked'";
								else if($_GET['choixId'] == "")
						  			echo "checked='checked'";
							?>  />
                          nO pATENTE</label><br />
                        <label>
                        <input type="radio" name="choixId" value="NOM" <?php if($_GET['choixId'] == "NOM") echo "checked='checked'" ?>  id="RadioGroup1_1" />
                          NOM ENTITE</label><br />
                        <label>
                        <input type="radio" name="choixId" value="SIGLE" <?php if($_GET['choixId'] == "SIGLE") echo "checked='checked'" ?>  id="RadioGroup1_2" />
                        SIGLE
                        </label>
                        <br />
                      </p></td>
                    </tr>
                    <tr>
                      <td><input type="submit" name="button" id="button" value="Rechercher" /></td>
                      <td><label>
                        <input type="reset" name="button2" id="button2" value="Reset" />
                      </label></td>
                    </tr>
    </table>

	          </form>


<?php
#	AFFoui ICHER LE RESULTAT SI LA RECHERCHE EST EFFECTUEE
#	======================================================
if (isset($_GET['rech']) && ($row_rechByNif['NOM_ENTITE'] != ""))
	{
?>
    <div align="center">
   <div class="logoutok"> Entite valide</div><BR>
   <div class="fonce">Résultats</div> 
      <table border="1" id="comliste">
        <tr class="head">
          <td>G_SANG_IND</td>
          <td>SEXE_IND</td>
          <td>NOM_IND</td>
          <td>PRENOM_IND</td>      
        </tr>
        <tr>
          <td><?php echo $row_rechByNif['ID_ENTITE']; ?></td>
          <td><?php echo $row_rechByNif['NOM_ENTITE']; ?></td>
          <td><?php echo $row_rechByNif['NUM_PATENTE']; ?></td>
          <td><?php echo $row_rechByNif['SIGLE']; ?></td>
        </tr>
</table>
      <p><br>
        <br>
      </p>
      <p>Poste : 
                <label for="profession"></label>
                <select name="profession" id="profession">
                  <option>Comptable</option>
                  <option>Informaticien</option>
                  <option>Gestionnaire</option>
                  <option>Mecanicien</option>
                  <option>Technicien</option>
                  <option>Avocat</option>
                  <option>Pilote</option>
                  <option>Secretaire</option>
        </select>
         
                <label for="button3"></label>
      <p>Date d'embauche :    
       Jour
                          <select name="jour" id="jour">
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
                      &nbsp;
                          &nbsp;
                          Mois
                      <select name="mois" id="mois">
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
                      Année
                      <select name="an" id="an">
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
                        <option selected="selected">1960</option>
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
      <p>
        <input type="submit" name="button3" id="button3" value="Soumettre" />
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
<?php
	}
	else if ($rechFlag == "oui")
	echo "Aucun resultat veuille reentrer l'identifiant";
	 /*  <a href="creation_usr.php?ID_IND=<?php echo $row_rechByNif['ID_IND']."&NOM_IND=".$row_rechByNif['NOM_IND'] ?>">Voir Voyage(s)</a>  */    
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
mysql_free_result($Voir_ind);

mysql_free_result($rechByNif);

mysql_free_result($loggedUser);
?>
