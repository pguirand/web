<?php /* Smarty version 2.6.14, created on 2009-03-31 19:56:10
         compiled from accueil.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
	<title><?php echo $this->_tpl_vars['titre_page']; ?>
</title>
	<link rel="stylesheet" type="text/css" href="css/general.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="css/pages_et_rubrique.css" media="screen" />
</head>
<body>
	<div class="conteneur_body">
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "logon.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		<ul class="utilisateur">
			
			<li class="deconnexion"><a href="<?php echo $this->_tpl_vars['liendeco']; ?>
"><?php echo $this->_tpl_vars['deco']; ?>
</a></li>
		</ul>
		<div class="after_utilisateur"></div>
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "menu.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

		<div class="interface">
		
			<h2><?php echo $this->_tpl_vars['title_base']; ?>
</h2>
			<p>Bienvenue sur l'interface de gestion Utilisateur</p>
			<p><?php echo $this->_tpl_vars['note']; ?>
</p>
			<p><?php echo $this->_tpl_vars['explication']; ?>
</p>
			
			
		<br>
			<p><?php echo $this->_tpl_vars['sessionactive']; ?>
</p>
			
			
			
	
		</div>
	</div>
</body>
</html>