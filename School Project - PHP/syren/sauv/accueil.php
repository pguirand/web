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

if (isset($_POST['username'])) {
  $loginUsername=$_POST['username'];
  $password=$_POST['password'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "accueil.php?result=yes";
  $MM_redirectLoginFailed = "accueil.php?result=no";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_connex, $connex);
  
  $LoginRS__query=sprintf("SELECT username, password FROM utilisateurs WHERE username='%s' AND password='%s'",
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
<title>Untitled Document</title>
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
#Layer3 {
	position:absolute;
	left:785px;
	top:6px;
	width:212px;
	height:36px;
	z-index:2;
}
.style2 {color: #330099}
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
	else  $warning = "<div id='erreurlogin'>Bad login</div>";
	}
?>
</head>
<!-- The structure of this file is exactly the same as 2col_rightNav.html;
     the only difference between the two is the stylesheet they use -->
<body>
<div class="style1" id="Layer2">
  <div align="center" id="message">Mot de passe ou utilisateur incorrect </div>
</div>
<div id="Layer3" align="right">
  <h3>
    <?php 

$heure_actuelle = date('d/m/Y H:i:s'); 
echo " ". $heure_actuelle; 

?>
  </h3>
</div>
<div id="masthead">
  <h1 id="siteName">SYREN</h1>
  <div id="globalNav"> <a href="administration.php">Actualit&eacute;s</a> | <a href="#">Culture </a> | <a href="#">Ev&egrave;nements </a> | <a href="#">Centre Statistique </a> | <a href="#">Forums </a> | <a href="#">Recherche</a> | <a href="#">Aide & Assistance </a> </div>
</div>
<!-- end masthead -->
<div id="content">
  <div id="breadCrumb"> <a href="#">breadcrumb</a> / <a href="#">breadcrumb</a> / <a href="#">breadcrumb</a> / </div>
  <h2 id="pageName">SYREN - Systeme de Renseignement National </h2>
  <div class="feature">
    <h3>Pr&eacute;ambule </h3>
    <p align="justify">Avec  le d&eacute;veloppement des Nouvelles Technologies de l&rsquo;Information et de la Communication (NTIC), l&rsquo;informatique se r&eacute;v&egrave;le un outil important et  indispensable dans la gestion des donn&eacute;es et le traitement des informations,  dans les institutions ou entreprises. Cependant, cet outil reste encore  inexploit&eacute; par bon nombre d&rsquo;institutions (ou entreprises) en Ha&iuml;ti, malgr&eacute; les  multiples efforts d&eacute;ploy&eacute;s dans le domaine pour rendre plus efficaces les  travaux de ces derniers; d&rsquo;autant plus, certains ne poss&egrave;dent pas un syst&egrave;me  informatique. En analysant minutieusement la structure du traitement de  l&rsquo;information du syst&egrave;me de renseignement National Ha&iuml;tien, nous avons constat&eacute;  qu&rsquo;elle est confront&eacute;e &agrave; de nombreux probl&egrave;mes. Notre travail, relativement &agrave;  sa mission, coiffe un &eacute;ventail d&rsquo;Institutions, soit cinq (5) grandes entit&eacute;s,  et plusieurs sous-entit&eacute;s, avec des droits et interactions entre ces derni&egrave;res.&nbsp; Donc, la gestion d&rsquo;un tel syst&egrave;me exige une  coh&eacute;rence relationnelle entre ces diff&eacute;rents entit&eacute;s et sous-entit&eacute;s. Cependant  il y a des failles qui portent les institutions &agrave; faire face &agrave; des contraintes  &agrave; plusieurs niveaux. Ces inconv&eacute;nients ou imperfections constituent u	n obstacle  de grande envergure dans la marche ad&eacute;quate et la gestion d&rsquo;un syst&egrave;me de  renseignement national. </p>
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
      <li>Contr&ocirc;le de fraude.</li>
    </ul>
    <p>

    </p>
    <p>&nbsp;</p>
  </div>
</div>
<!--end content -->
<div id="navBar">
  <div id="search">
    <form action="#">
      <label>Recherche Rapide </label>
      <input name="searchFor" type="text" size="20" />
      <input name="goButton" type="submit" value="go" />
    </form>
  </div>
  <div id="sectionLinks">
    <ul>
      <form id="form1" name="form1" method="POST" action="<?php echo $loginFormAction; ?>">
        <table width="160" border="0">
          <tr>
            <td colspan="2"><div align="center"><strong>Login </strong></div></td>
          </tr>
          <tr>
            <td width="71">username</td>
            <td width="113"><label>
              <input name="username" type="text" id="username" size="15" /></label></td>
          </tr>
          <tr>
            <td>password</td>
            <td><label>
              <input name="password" type="password" id="password" size="15" /></label></td>
          </tr>
        </table><br /><label>
          
          <input type="submit" name="Submit" value="Connexion" />
          
        </label>
        
        <p><?php echo $warning; ?></p>
        <p><a href="#">Mot de passe oubli&eacute;?</a></p>
      </form>
    </ul>
</div>
  <div class="feature">
    <div class="relatedLinks">
    <h3>Entit&eacute;s Nationales </h3>
    <ul>
      <li><a href="entites1.php">	Entites gouvernementales </a></li>
      <li><a href="entites.php?type=nongouv"><!--<a href="javascript:ajaxpage('entites.php', 'content');">-->Entit&eacute;s non Gouvernemantales</a></li>
      <li><a href="#">Institutions Priv&eacute;es </a></li>
      <li><a href="#">Institutions Publiques </a><a href="#">Soci&eacute;t&eacute;s Anonymes</a></li>
    </ul>
  </div>
  <div class="relatedLinks">
    <h3>Informations sur Individus </h3>
    <ul><li><a href="#">Demographie</a></li>
      <li><a href="#">Statistique</a></li>
      <li><a href="#">Listing...</a></li>
      <li><a href="#">Recherche...</a></li>
	
      <li><a href="formulaire1.php?type=nongouv">	Enregistrement  </a></li>
    </ul>
  </div>
  <div id="advert"></div>
  <div id="headlines">
    <h3>&nbsp;</h3>
    </div>
</div>
<!--end navbar -->
<div id="siteInfo"></div>
<br />
</body>
</html>
