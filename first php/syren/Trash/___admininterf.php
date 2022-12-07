<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
include("includes/logoutCode.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
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


<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="screen">
		<div id="header">
		  <p>&nbsp;</p>
		  <p>&nbsp;</p>
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
<?php
if ($_SESSION['MM_Username'] == "")
	{
?>
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
                <a href="<?php echo $logoutAction ?>">Log out</a>
        <p><?php echo $warning; ?></p>
                <p align="center"><a href="#">Mot de passe oubli&eacute;?</a></p>
            </form>
<?php
	}
?>
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
            <div class="loginbar">
          	<div class="text">
          		Bienvenue, <span class="fonce">
				<?php 
				echo $_SESSION['MM_Username']; 
				?></span></div>
            <span class="logout"><a href="
			<?php 
			echo $logoutAction 
			?>">Deconnexion</a></span>
          <div class="spacer"></div>
          </div>
		  <p></p>
		  <div id="menutop">
		  	<ul id="MenuBar2" class="MenuBarHorizontal">
		  		<li><a href="./">Accueil</a></li>
		  		<li><a class="MenuBarItemSubmenu" href="#">Entites</a>
		  			<ul>
		  				<li><a href="#">Rechercher</a></li>
		  				<li><a href="rech_entites.php">Lister</a></li>
		  				<li><a href="/syren/saveentites.php">Enregistrer</a></li>
	  				</ul>
	  			</li>
		  		<li><a href="#">Actualites</a></li>
		  		<li><a class="MenuBarItemSubmenu" href="#">Evenements</a>
		  			<ul>
		  				<li><a class="MenuBarItemSubmenu" href="#">Item 3.1</a>
		  					<ul>
		  						<li><a href="#">Item 3.1.1</a></li>
		  						<li><a href="#">Item 3.1.2</a></li>
	  						</ul>
	  					</li>
		  				<li><a href="#">Item 3.2</a></li>
		  				<li><a href="#">Item 3.3</a></li>
	  				</ul>
	  			</li>
		  		<li><a href="#">Culture</a></li>
		  		<li><a href="#">Forums</a></li>
	  		</ul>
</div>
		  <h3>&nbsp;</h3>
            <h3>&nbsp;</h3>
            <?php
	}

?>
        </div>
		<div class="spacer"></div>
		<div id="footer">
			<div class="content">
			<img src="Logo.jpg" width="116" height="49" /> <a href="#">A propos de nous </a> | <a href="#">Plan du Site </a> | <a href="#">R&egrave;gle d'utilisation </a> | <a href="#">Contactez-nous</a> | &copy;2009 SYREN
			</div>
		</div>
</div>
<script type="text/javascript">
<!--
var MenuBar2 = new Spry.Widget.MenuBar("MenuBar2", {imgDown:"/syren/SpryAssets/SpryMenuBarDownHover.gif", imgRight:"/syren/SpryAssets/SpryMenuBarRightHover.gif"});
//-->
</script>
</body>
</html>
