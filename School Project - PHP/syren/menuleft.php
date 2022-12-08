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
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
<title>SYREN | Syst&egrave;me de Renseignement National</title>
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

	<div id="left">
        <div id="search">
            <form action="<?php echo $searchAction ?>">
              <label>
              <div class="section">
              <div align="center" class="title">
              Recherches </div>
              </div>
               <ul> 
               <li><a href="rech_ent.php">Rechercher entit&eacute;</a></li>
               <a href="list_pub.php">
               <li>Lister publications</li></a>
              </li>
              </ul>
	         
  
                        
             
              <div align="center" id="publications" style="display:none">
              <div align="center" class="idsection"><a href="list_pub.php">Visualiser Publications</a></div></div>
              
            </form>
        </div>
    <div id="section">
          <?php
			if($_SESSION['MM_Username'] == "")
			{
			?>
          <div class="section">
              <div align="center" class="title">
              Session </div>
      </div>
          <form id="form1" name="form1" method="POST" action="<?php echo $loginFormAction; ?>">	
                <table border="0" align="center" class="content">
                  <tr>
                    <td colspan="2"><div align="center"><strong>Connexion</strong></div></td>
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
                <div align="center">
                <label>
                <input type="submit" name="Submit" value="Connexion" align="middle" />
                
</label></div>
                <p><?php echo $warning; ?></p>
                <p align="center"><a href="motpassoublie.php">Mot de passe oubli&eacute;?</a></p>
            </form>
            <?php
			  }
			  ?>
	      </div>
		  <div class="section">
		    <ul><li></li>
		      <li></li>
		      <li><a href="entites.php?type=nongouv">
		        <!--<a href="javascript:ajaxpage('entites.php', 'content');">-->
		        </a></li>
		      
            </ul>
      </div>
      <div class="section">
            <div class="title">Divers</div>
		    <ul>
              <li><a href="actugen.php?">Actualit&eacute;s G&eacute;n&eacute;rales</a></li>
		      <li>Statitisques</li>
		      <li>Centre de sondages</li>
		      <li><a href="forum2/phpBB3/index.php">Forums</a></li>
		    </ul>
      </div>
  </div>
<div class="spacer"></div>