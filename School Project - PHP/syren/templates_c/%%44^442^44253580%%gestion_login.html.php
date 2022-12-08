<?php /* Smarty version 2.6.14, created on 2009-03-31 19:56:21
         compiled from gestion_login.html */ ?>
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
			<h2>Configuration > Gestion des utilisateurs  </h2>
			<p align="center"><strong><font color="#990000" size="2" ><?php echo $this->_tpl_vars['message']; ?>
</font></strong></p>
			
			 <?php if (( $this->_tpl_vars['gestiondroit'] == 'on' )): ?>
			<p>il y a actuellement <strong><?php echo $this->_tpl_vars['nombre']; ?>
 utilisateur(s)</strong></p>
			 <?php endif; ?>
			 
			 
			 <?php if (( $this->_tpl_vars['gestiondroit'] == 'on' )): ?>
				<div align="left">
				<p> <b>Droit Administrateur : </b></p>
				<li> Tous les droits</li>
				</div>
				  <?php else: ?>
				  <div align="left">
				<p> <b>Droit Modérateur : </b></p>
				<li> Impossible de supprimer </li>
				<li> Impossible de désactiver</li>
				<li> Ne peut modifier son identifiant</li>
				<li> Ne peut gérer les IP</li>
				</div>
			<?php endif; ?>
			
			<div class="selection_theme">
		<ul class="pages_et_rubriques">
		<?php if (( $this->_tpl_vars['gestiondroit'] == 'on' )): ?>
		<form name="formulaire" method="post">
				<center>Sélectionner votre utilisateur : <select name="modif" id="formulaire" onChange='ChangeUrlmodif(this.form)'><?php echo $this->_tpl_vars['smartbox']; ?>
</select></center>
		</form>
		  <?php endif; ?>
		 
		</ul>
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "formulaire-login.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			
			
</div>
	</div>
</body>
</html> 