<?php require_once('Connections/connex.php'); ?><?php
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
  $MM_redirectLoginSuccess = "accueil.php?result=yes";
  $MM_redirectLoginFailed = "accueil.php?result=no";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_connex, $connex);
  
  $LoginRS__query=sprintf("SELECT NOM_UTIL, MOT_PASS FROM utilisateur WHERE NOM_UTIL='%s' AND MOT_PASS='%s'",
    get_magic_quotes_gpc() ? $loginUsername : addslashes($loginUsername), get_magic_quotes_gpc() ? $password : addslashes($password)); 
   
  $LoginRS = mysql_query($LoginRS__query, $connex) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- DW6 -->
<head>
<!-- Copyright 2005 Macromedia, Inc. All rights reserved. -->
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>SYREN | Syst?me de Renseignement National</title>
<link rel="stylesheet" href="2col_leftNav.css" type="text/css" />
<script type="text/javascript">

/***********************************************
* Dynamic Ajax Content- ? Dynamic Drive DHTML code library (www.dynamicdrive.com)
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
.style7 {
	color: #0000FF;
	font-style: italic;
}
.style8 {color: #0000FF}
.style9 {font-size: x-large; font-family: Verdana, Arial, Helvetica, sans-serif; font-style: italic; }
#Layer3 {
	position:absolute;
	left:867px;
	top:147px;
	width:119px;
	height:811px;
	z-index:0;
}
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
<div class="style1" id="Layer2">
  <div align="center" id="message">Mot de passe ou utilisateur incorrect </div>
</div>
<div id="Layer3"></div>
<div id="masthead">
  <h1 id="siteName"><span class="style3"><span class="style6">SYREN</span> <span class="style6"><span class="style8">|</span></span></span><span class="style7">Syst&egrave;me de Renseignement National </span></h1>
  <div id="globalNav">
  <a href="administration.php">Entit&eacute;s</a> | 
  <a href="#">Individus</a> | 
  <a href="#">Entit&eacute;s </a> | 
  <a href="#">Culture </a> |
  <a href="#">Ev&egrave;nements </a> |
  <a href="#">Culture </a> | 
  <a href="#">Forums </a> | 
  <a href="#">Centre Statistique </a> | 
  <a href="#">Recherche</a> | 
  </div>
</div>
<!-- end masthead -->
<div id="content">
  <div id="breadCrumb"></div>
  <h2 id="pageName">SYREN - Systeme de Renseignement National </h2>
  <div class="feature"> <img src="Logo.jpg" alt="" width="230" height="118" />
    <h1 class="style9">Interface Administrateur </h1>
    <p align="justify">Dans ce module sont effectu&eacute;es toutes les t&acirc;ches administratives du Systeme de Renseignement National. Toutes les fonctions sont peuvent y &ecirc;tre enregistr&eacute;es, supprim&eacute;es ou modifi&eacute;es. </p>
    <p align="justify">Les operations realis&eacute;es &agrave; des niveaux inf&eacute;rieures sont certaines fois supervis&eacute;es par l'administration avant d'etre approuv&eacute;es. Ce module est donc a la fois un module de supervision, de controle, d'enregistrement et d'administration.</p>
    <p align="justify">Chaque entite possede une cellule d'administration gerant les operations locales. Une cellule d'administration globale ou Super Administrateur se charge d'administrer tous les modules du systeme. </p>
    <p align="justify">L'Administrateur local lors de certaines operations doit obtenir l'approbation de l'administration globale avant de proceder.</p>
    <p align="justify">Cette cellule a aussi a gerer les utilisateurs selon des controles sur ceux-ci. Ce controle se fera a partir d'un module d'indicateur de performances contenant plusieurs sous-modueles (ponctualite, taux d'erreurs, vitesse d'execution, suivi de protocoles etc). De ce fait des promotions ou primes seront offerts aux meilleurs utilisateurs, tout comme des avertissement aux moins performants. </p>
  </div>
  <div class="story">
    <p>&nbsp;</p>
    <hr />
    <p>&nbsp;</p>
  </div>
</div>
<!--end content -->
<div id="navBar">
  <div id="search">
    <form action="#">
      	  <label>
      <div align="center">
        <div align="center">
          <table width="147" height="40" border="0.5" class="style1">
            <tr>
              <td width="153"><div align="center"><strong>Recherche Rapide</strong></div></td>
            </tr>
          </table>
        </div>
      </div>
      </label>
      <div align="center">
        <table width="164">
          <tr>
            <td><label>
              <input type="radio" name="Search" value="entite" />
              Entit?s</label></td>
          </tr>
          <tr>
            <td><label>
              <input type="radio" name="Search" value="indiv" />
              Individus</label></td>
          </tr>
          <tr>
            <td height="26"><label>
              <input type="radio" name="Search" value="util" />
              Utilisateurs</label></td>
          </tr>
          <tr>
            <td><label>
              <input type="radio" name="Search" value="infos" />
              Publications</label></td>
          </tr>
        </table>
      </div>
      <p align="center">
        <input name="searchFor" type="text" size="30" />
      </p>
      <p align="center">
        <input name="goButton" type="submit" value="Chercher" />
      </p>
    </form>
  </div>
  <div id="sectionLinks">
    <ul>
      
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
</body>
</html>