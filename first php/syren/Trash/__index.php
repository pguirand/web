<?php require_once('Connections/connex.php'); ?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['NOM_UTIL'])) {
  $loginUsername=$_POST['NOM_UTIL'];
  $password=$_POST['MOT_PASS'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "interadmin1.php";
  $MM_redirectLoginFailed = "accueil.php?result=no";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_connex, $connex);
  
  $LoginRS__query=sprintf("SELECT * FROM utilisateur WHERE NOM_UTIL='%s' AND MOT_PASS='%s'",
    get_magic_quotes_gpc() ? $loginUsername : addslashes($loginUsername), get_magic_quotes_gpc() ? $password : addslashes($password)); 
   
  $LoginRS = mysql_query($LoginRS__query, $connex) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;
//	$_SESSION['nom'] = $row_LoginRS['']

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>


<?php
#========================
# RECHERCHE
#===========================


$searchAction = $_SERVER['PHP_SELF'];
//echo $_GET['search'];
			$requet = "SELECT * FROM utilisateur WHERE NOM_UTIL='".$_GET['search']."'";
				if($result = mysql_query($requet))
					{
						while($ligne = mysql_fetch_array($result))
						{
						$nomutil		= $ligne['NOM_UTIL'];
						$pass				= $ligne['MOT_PASS'];
						$id_groupe			= $ligne['ID_GROUPE'];					
							
						}
					}				




?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- DW6 -->
<head>
<!-- Copyright 2005 Macromedia, Inc. All rights reserved. -->
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>SYREN | Système de Renseignement National</title>
<link rel="stylesheet" href="2col_leftNav.css" type="text/css" />
<script type="text/javascript">

/***********************************************
* Dynamic Ajax Content- © Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/

var bustcachevar=1 //bust potential caching of external pages after initial request? (1=yes, 0=no)
var loadedobjects=""
var rootdomain="http://"+window.location.hostname
var bustcacheparameter=""

function ajaxpage(url, containerid){
var page_request = false
if (window.XMLHttpRequest) // if Mozilla, Safari etc
page_request = new XMLHttpRequest()
else if (window.ActiveXObject){ // if IE
try {
page_request = new ActiveXObject("Msxml2.XMLHTTP")
} 
catch (e){
try{
page_request = new ActiveXObject("Microsoft.XMLHTTP")
}
catch (e){}
}
}
else
return false
page_request.onreadystatechange=function(){
loadpage(page_request, containerid)
}
if (bustcachevar) //if bust caching of external page
bustcacheparameter=(url.indexOf("?")!=-1)? "&"+new Date().getTime() : "?"+new Date().getTime()
page_request.open('GET', url+bustcacheparameter, true)
page_request.send(null)
}

function loadpage(page_request, containerid){
if (page_request.readyState == 4 && (page_request.status==200 || window.location.href.indexOf("http")==-1))
document.getElementById(containerid).innerHTML=page_request.responseText
}

function loadobjs(){
if (!document.getElementById)
return
for (i=0; i<arguments.length; i++){
var file=arguments[i]
var fileref=""
if (loadedobjects.indexOf(file)==-1){ //Check to see if this object has not already been added to page before proceeding
if (file.indexOf(".js")!=-1){ //If object is a js file
fileref=document.createElement('script')
fileref.setAttribute("type","text/javascript");
fileref.setAttribute("src", file);
}
else if (file.indexOf(".css")!=-1){ //If object is a css file
fileref=document.createElement("link")
fileref.setAttribute("rel", "stylesheet");
fileref.setAttribute("type", "text/css");
fileref.setAttribute("href", file);
}
}
if (fileref!=""){
document.getElementsByTagName("head").item(0).appendChild(fileref)
loadedobjects+=file+" " //Remember this object as being already added to page
}
}
}

</script>
<style type="text/css">
<!--
p
	{
		margin: 2px;
		padding: 0px;
	}
#Layer1 {
	position:absolute;
	left:6px;
	top:162px;
	width:142px;
	height:7px;
	z-index:1;
}
#Layer2 {
	position:absolute;
	left:5px;
	top:285px;
	width:182px;
	height:34px;
	z-index:1;
	display: none;	
}

#search
	{
		background-color:#eee;
	}
#erreurlogin
	{
	border:1px solid red;
	padding: 5px;
	text-align:center;
	color:red;
	background-color:#fff;
	}
.style1 {color: #7D9FD4}
.style2 {font-size: 9%}
.style3 {
	font-size: xx-large;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-style: italic;
}
.style6 {color: #FF0000}
.style7 {	color: #0000FF;
	font-style: italic;
}
.style8 {color: #0000FF}
.style10 {font-size: 10px}
-->
</style>
<?php
if (isset($_GET['result']))
	{
		 $r = $_GET['result'];
	

if ($r == "yes")
	{
	$warning = "Good login";
	//echo '<div id="message".style.display='block';>';
	}
	else  $warning = "<div id='erreurlogin'>Mauvais nom d'utlisateur ou mot de passe</div>";
	}
?>
</head>
<!-- The structure of this file is exactly the same as 2col_rightNav.html;
     the only difference between the two is the stylesheet they use -->
<body>
<div class="screen">

<div class="style1" id="Layer2">
  <div align="center" id="message">Mot de passe ou utilisateur incorrect </div>
</div>
<div id="masthead">
  <h1 id="siteName" class="hidden"><span class="style3"><span class="style6">SYREN</span> <span class="style6"><span class="style8">|</span></span></span><span class="style7">Syst&egrave;me de Renseignement National </span></h1>
  <div id="globalNav" class="hidden"><a href="administration.php">Actualit&eacute;s</a> | <a href="#">Culture </a> | <a href="#">Ev&egrave;nements </a> | <a href="#">Centre Statistique </a> | <a href="#">Forums </a> | <a href="#">Recherche</a> | <a href="#">Aide &amp; Assistance </a></div>
</div>
<!-- end masthead -->

<div id="content">
  <div id="breadCrumb"></div>
  <h2 id="pageName">&nbsp;</h2>

<?php
if($_GET['search'] == "")
	{
?>
  <div class="feature"> <img src="Logo.jpg" alt="" width="230" height="118" />
    <h3>Pr&eacute;ambule </h3>
    <p align="justify">Avec  le d&eacute;veloppement des Nouvelles Technologies de l&rsquo;Information et de la<a href="#"></a>  Communication (NTIC), l&rsquo;informatique se r&eacute;v&egrave;le un outil important et  indispensable dans la gestion des donn&eacute;es et le traitement des informations,  dans les institutions ou entreprises. Cependant, cet outil reste encore  inexploit&eacute; par bon nombre d&rsquo;institutions (ou entreprises) en Ha&iuml;ti, malgr&eacute; les  multiples efforts d&eacute;ploy&eacute;s dans le domaine pour rendre plus efficaces les  travaux de ces derniers; d&rsquo;autant plus, certains ne poss&egrave;dent pas un syst&egrave;me  informatique. En analysant minutieusement la structure du traitement de  l&rsquo;information du syst&egrave;me de renseignement National Ha&iuml;tien, nous avons constat&eacute;  qu&rsquo;elle est confront&eacute;e &agrave; de nombreux probl&egrave;mes. Notre travail, relativement &agrave;  sa mission, coiffe un &eacute;ventail d&rsquo;Institutions, soit cinq (5) grandes entit&eacute;s,  et plusieurs sous-entit&eacute;s, avec des droits et interactions entre ces derni&egrave;res.&nbsp; Donc, la gestion d&rsquo;un tel syst&egrave;me exige une  coh&eacute;rence relationnelle entre ces diff&eacute;rents entit&eacute;s et sous-entit&eacute;s. Cependant  il y a des failles qui portent les institutions &agrave; faire face &agrave; des contraintes  &agrave; plusieurs niveaux. Ces inconv&eacute;nients ou imperfections constituent un obstacle  de grande envergure dans la marche ad&eacute;quate et la gestion d&rsquo;un syst&egrave;me de  renseignement national. </p>
  </div>
  <div class="story">
    <h3>Probl&eacute;matique</h3>
    <p align="justify">Le syst&egrave;me de renseignement, est un ensemble de donn&eacute;es  qui, selon le degr&eacute; de formalisation et les objectifs poursuivis, pourra  permettre de d&eacute;crire, d'expliquer, de pr&eacute;dire et d'agir sur des entit&eacute;s. Il a pour r&ocirc;le de fournir des  informations sur l&rsquo;ensemble des individus et institutions d&rsquo;un pays. Pourtant,  d&rsquo;apr&egrave;s les &eacute;tudes men&eacute;es par Le GARR, en 2004 et 2007 de concert avec d&rsquo;autres  organisations travaillant sur la probl&eacute;matique, ont confirm&eacute; le dysfonctionnement,  la situation d&eacute;plorable du syst&egrave;me en termes de&nbsp;: Traitement des donn&eacute;es,  Fiabilit&eacute; des informations, Partage de donn&eacute;es, Prise de d&eacute;cisions, etc.Jusqu'&agrave; pr&eacute;sent, les informations dont dispose l&rsquo;Etat sur l&rsquo;identit&eacute; des  citoyens restent archa&iuml;que et l&rsquo;authenticit&eacute; de ces informations ne peut &ecirc;tre garantie  dans un pays o&ugrave; la d&eacute;linquance et la criminalit&eacute; font toujours la une.<br />
      <br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; N&rsquo;est-il pas important pour  l&rsquo;&Eacute;tat de penser &agrave; promouvoir un syst&egrave;me de renseignement national?&nbsp; Et, &agrave; travers ce syst&egrave;me d&rsquo;information  fiable, arriver &agrave; g&eacute;rer mieux et coordonner les activit&eacute;s des diff&eacute;rentes  Institutions et Entreprises du pays? Et, comment peut-on&nbsp; agir pour doter l&rsquo;Etat d&rsquo;un syst&egrave;me de  renseignement national fiable pour la bonne marche du pays? </p>
    <p align="justify">Ces  questions sont essentielles &agrave; l&rsquo;analyse des solutions. Pour ce faire, nous  sugg&eacute;rons le d&eacute;veloppement et l&rsquo;impl&eacute;mentation du <strong>SYREN</strong> (Syst&egrave;me de Renseignement National).</p>
  </div>
  <div class="story">
    <h3>Objectifs</h3>
    <ul>
      <li>S&eacute;curite de &nbsp;l&rsquo;information.</li>
      <li>Diminution du d&eacute;lai des requ&ecirc;tes</li>
      <li>Automatisation des processus.</li>
      <li>Partage de l&rsquo;information</li>
      <li>Interconnexion des entit&eacute;s</li>
      <li>Unicit&eacute; de l&rsquo;information</li>
      <li>Optimiser le syst&egrave;me  d&rsquo;enregistrement.</li>
      <li>Syst&egrave;me statistique</li>
      <li>Exploitation Empreinte digitale.</li>
      <li>Contr&ocirc;le de fraude.    </li>
    </ul>
    <p>&nbsp;</p>
  </div>
  <?php
	}
else
	echo "le nom d'utilisateur : ".$nomutil."<br>";
	echo "l'identite de groupe : ".$id_groupe."<br>";
	echo "le mot de passe : ".$pass."<br>";
?>
</div>


<!--end content -->
<div id="navBar">
  <div id="search">
    <form action="<?php echo $searchAction ?>">
      <label>Recherche Rapide </label>
      <p>
        <input name="search" type="text" size="30" value="<?php echo $_GET['search'] ?>" />
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
  <div id="sectionLinks">
    <ul>
      <form id="form1" name="form1" method="POST" action="<?php echo $loginFormAction; ?>">
        <table width="219" border="0">
          <tr>
            <td colspan="2"><div align="center"><strong>Login </strong></div></td>
          </tr>
          <tr>
            <td width="87">Utilisateur</td>
            <td width="90"><label>
              <input name="NOM_UTIL" type="text" id="NOM_UTIL" size="15" /></label></td>
          </tr>
          <tr>
            <td>Mot de passe </td>
            <td><label>
              <input name="MOT_PASS" type="password" id="MOT_PASS" size="15" />
            </label></td>
          </tr>
        </table><br /><label>
          
        <div align="center">
          <input type="submit" name="Submit" value="Connexion" />
        </div>
        </label>
        
        <p><?php echo $warning; ?></p>
        <p align="center"><a href="#">Mot de passe oubli&eacute;?</a></p>
      </form>
    </ul>
</div>
  <div class="relatedLinks">
    <h3>Entit&eacute;s Nationales </h3>
    <ul>
      <li><a href="entites1.php",'content'><!--<a href="javascript:ajaxpage('entites.php', 'content');">-->Entites gouvernementales </a></li>
      <li><a href="entites.php?type=nongouv"><!--<a href="javascript:ajaxpage('entites.php', 'content');">-->Entit&eacute;s non Gouvernemantales</a></li>
      <li><a href="#">Institutions Priv&eacute;es </a></li>
      <li><a href="#">Institutions Publiques </a><a href="#">Soci&eacute;t&eacute;s Anonymes</a></li>
    </ul>
  </div>
  <div class="relatedLinks">
    <h3>Informations sur Individus </h3>
    <ul>
      <li><a href="#">Demographie</a></li>
      <li><a href="#">Statistique</a></li>
      <li><a href="#">Listing...</a></li>
      <li><a href="#">Recherche...</a></li>
      <li><a href="formulaire1.php?type=nongouv"> Enregistrement </a></li>
    </ul>
  </div>
  <div class="style2" id="advert"> 
    <h1 align="center">Actualites </h1>
  </div>
  <div id="headlines">
    <h3>Grands Titres </h3>
    <p> Actualite1 <a href="#">Lire...</a> </p>
    <p>Actualite2 <a href="#">Lire...</a></p>
    <p>Actualite3 <a href="#">Lire...</a></p>
    <p>Actualite4 <a href="#">Lire...</a></p>
  </div>
</div>
<!--end navbar -->
<div id="siteInfo"> <img src="Logo.jpg" width="116" height="49" /> <a href="#">A propos de nous </a> | <a href="#">Plan du Site </a> | <a href="#">R&egrave;gle d'utilisation </a> | <a href="#">Contactez-nous</a> | &copy;2009 SYREN </div>
<br />
</div>
</body>
</html>