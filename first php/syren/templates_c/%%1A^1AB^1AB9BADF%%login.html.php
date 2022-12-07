<?php /* Smarty version 2.6.14, created on 2009-03-31 19:55:59
         compiled from login.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
	<title><?php echo $this->_tpl_vars['titre_page']; ?>
</title>
	<link rel="stylesheet" type="text/css" href="css/general.css" media="screen" />
	
</head>
<body>
	<div class="conteneur_body">
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "logon.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

		
        <div align="center"><font size="5" face="Verdana, Arial, Helvetica, sans-serif">Gestion utilisateurs
</font></div>
        <div align="center">
          <p><font color="#000066" size="3" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $this->_tpl_vars['explication']; ?>
 </font></p>
          <p><font color="#990000" size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><?php echo $this->_tpl_vars['message']; ?>
 </strong></font></p>
        </div>
		<?php if ($this->_tpl_vars['ipcale'] == 1): ?>
      <form action="login.php" method="post"><fieldset><p align="center">
<label for="login">Identifiant :</label>
<input type="text" name="login" id="login" value="" />
</p>
<p align="center">
<label for="password">Mot de passe :</label>
<input type="password" name="password" id="password" value="" />
</p>
<p align="center">
 <input type="hidden" name="valid" value="1" />
  <input type="submit" name="submit" value="Connexion" />
</p>
</fieldset>
</form>
<?php endif; ?>
	</div>
</body>
</html>