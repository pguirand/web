<?php /* Smarty version 2.6.14, created on 2009-03-31 19:56:59
         compiled from gestion_ip.html */ ?>
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

<script language='JavaScript'>
			function ChangeUrlmodif(formulaire)
			{
			if (formulaire.modif.selectedIndex != 0)
			{
			location.href = formulaire.modif.options[formulaire.modif.selectedIndex].value;
			}
			else 
			{
	
			}
			}
			</script>

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
			<h2>Configuration > Gestion des IP  </h2>
			<p align="center"><strong><font color="#990000" size="2" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $this->_tpl_vars['message']; ?>
</font></strong></p>
		 <?php if (( $this->_tpl_vars['desactive'] == 'off' )): ?>

		<p>il y a actuellement <strong><?php echo $this->_tpl_vars['nombre']; ?>
 IP(s)</strong></p>
			<div class="selection_theme">
		<ul class="pages_et_rubriques">
		<form name="formulaire" method="post">
				<center>Sélectionner votre IP : <select name="modif" id="formulaire" onChange='ChangeUrlmodif(this.form)'><?php echo $this->_tpl_vars['smartbox']; ?>
</select></center>
		</form>
		</ul>
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "formulaire-ip.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			
			
</div>
<?php endif; ?>
	</div>
</body>
</html>