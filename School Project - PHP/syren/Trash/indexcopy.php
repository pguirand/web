<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style10 {font-size: 10px}
.style2 {font-size: 9%}
#search {		background-color:#eee;
}
.style12 {font-size: 12px}
.style13 {color: #3131DF}
.style14 {color: #6F39B0}
.style15 {color: #FFFFFF}
-->
</style>
</head>

<body>
<div class="screen">
		<div id="header">
			En tete
		</div>
		<div id="menutop"><a href="entites3.php">Entit&eacute;s</a> | <a href="#">Individus</a> | <a href="#">Actualit&eacute;s </a> | <a href="#">Utilisateurs </a> | <a href="#">Ev&egrave;nements </a> | <a href="#">Culture </a> | <a href="#">Forums </a> |<a href="#">Centre Statistique </a> | <a href="#">Recherche</a> |
          <div style="position:absolute; left: 702px; top: 46px; width: 536px; height: 23px;">
            <div align="left">
              <p align="right"><span class="style12">Vous &ecirc;tes connect&eacute;(e) en tant que</span> <span class="style13"><a href="#"><?php echo $_SESSION['MM_Username'] ?> </a></span><span class="style14">|<span class="style15">-</span></span><a href="#">Deconnexion ? </a></p>
            </div>
          </div>
		</div>
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

              <form id="form1" name="form1" method="post" action="<?php echo $loginFormAction; ?>">
                <table border="0">
                  <tr>
                    <td colspan="2"><div align="center"><strong>Login </strong></div></td>
                  </tr>
                  <tr>
                    <td>Utilisateur</td>
                    <td><label>
                      <input name="NOM_UTIL" type="text" id="NOM_UTIL" size="15" />
                    </label></td>
                  </tr>
                  <tr>
                    <td>Mot de passe </td>
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
	      </div>
		  <div class="section">
            <div class="title">Entit&eacute;s Nationales</div>
		    <ul>
              <li><a href="entites1.php",'content'>
                <!--<a href="javascript:ajaxpage('entites.php', 'content');">-->
                Entites gouvernementales </a></li>
		      <li><a href="entites.php?type=nongouv">
		        <!--<a href="javascript:ajaxpage('entites.php', 'content');">-->
		        Entit&eacute;s non Gouvernemantales</a></li>
		      <li><a href="#">Institutions Priv&eacute;es </a></li>
		      <li><a href="#">Institutions Publiques </a><a href="#">Soci&eacute;t&eacute;s Anonymes</a></li>
	        </ul>
	      </div>
		  <div class="section">
            <h3>Informations sur Individus </h3>
		    <ul>
              <li><a href="#">Demographie</a></li>
		      <li><a href="#">Statistique</a></li>
		      <li><a href="#">Listing...</a></li>
		      <li><a href="#">Recherche...</a></li>
		      <li><a href="formulaire1.php?type=nongouv"> Enregistrement </a></li>
	        </ul>
	      </div>
	  </div>
		<div id="right">
		  <?php
if($_GET['search'] == "")
	{
?>
          
            <h3>Pr&eacute;ambule </h3>
            <p align="justify">Avec  le d&eacute;veloppement des Nouvelles Technologies de l&rsquo;Information et de la<a href="#"></a> Communication (NTIC), l&rsquo;informatique se r&eacute;v&egrave;le un outil important et  indispensable dans la gestion des donn&eacute;es et le traitement des informations,  dans les institutions ou entreprises. Cependant, cet outil reste encore  inexploit&eacute; par bon nombre d&rsquo;institutions (ou entreprises) en Ha&iuml;ti, malgr&eacute; les  multiples efforts d&eacute;ploy&eacute;s dans le domaine pour rendre plus efficaces les  travaux de ces derniers; d&rsquo;autant plus, certains ne poss&egrave;dent pas un syst&egrave;me  informatique. En analysant minutieusement la structure du traitement de  l&rsquo;information du syst&egrave;me de renseignement National Ha&iuml;tien, nous avons constat&eacute;  qu&rsquo;elle est confront&eacute;e &agrave; de nombreux probl&egrave;mes. Notre travail, relativement &agrave;  sa mission, coiffe un &eacute;ventail d&rsquo;Institutions, soit cinq (5) grandes entit&eacute;s,  et plusieurs sous-entit&eacute;s, avec des droits et interactions entre ces derni&egrave;res.&nbsp; Donc, la gestion d&rsquo;un tel syst&egrave;me exige une  coh&eacute;rence relationnelle entre ces diff&eacute;rents entit&eacute;s et sous-entit&eacute;s. Cependant  il y a des failles qui portent les institutions &agrave; faire face &agrave; des contraintes  &agrave; plusieurs niveaux. Ces inconv&eacute;nients ou imperfections constituent un obstacle  de grande envergure dans la marche ad&eacute;quate et la gestion d&rsquo;un syst&egrave;me de  renseignement national. </p>
         
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
		      <li>Contr&ocirc;le de fraude. </li>
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
		<div class="spacer"></div>
		<div id="footer">
			<div class="content">
			<img src="Logo.jpg" width="116" height="49" /> <a href="#">A propos de nous </a> | <a href="#">Plan du Site </a> | <a href="#">R&egrave;gle d'utilisation </a> | <a href="#">Contactez-nous</a> | &copy;2009 SYREN
			</div>
		</div>
	</div>
</body>
</html>
