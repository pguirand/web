<?php /* Smarty version 2.6.14, created on 2009-03-31 19:56:13
         compiled from gestionconfig.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
	<title><?php echo $this->_tpl_vars['titre_page']; ?>
</title>
	<link rel="stylesheet" type="text/css" href="css/general.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="css/pages_et_rubrique.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="css/choix_theme.css" media="screen" />
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
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "smenuconfig.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		<div class="interface">
			<h2>Gestion des configurations</h2>
			<p>C'est ici que vous pouvez gérer les configurations, voir les configurations ainsi que les modifiés</p>
			<h3></h3>
			
		</div>
	</div>
</body>
</html>