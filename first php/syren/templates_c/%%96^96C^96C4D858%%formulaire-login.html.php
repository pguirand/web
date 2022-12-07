<?php /* Smarty version 2.6.14, created on 2009-03-31 19:56:22
         compiled from formulaire-login.html */ ?>

<center>
<?php if (( $this->_tpl_vars['modif'] == 1 )): ?>

<form name="modif" action="gestionlogin.php?mod=1&id=<?php echo $this->_tpl_vars['id']; ?>
" method="post" >
<?php else: ?>
<form name="add" action="gestionlogin.php?ad=1" method="post" >
<?php endif; ?>


<table width="491" border="0"  bgcolor="#CCCCCC">


 <tr>
    <td width="326" bgcolor="#FFFFFF"><strong><font color="#666666" size="2" face="Verdana, Arial, Helvetica, sans-serif">Groupe associé</font></strong></td>
    <td width="155" bgcolor="#FFFFFF"><div align="center">
	
	<select name="groupe" id="groupe" >
        <?php echo $this->_tpl_vars['groupelist']; ?>

	</select>
      </div>
    </td>
  </tr>

 <tr>
    <td width="326" bgcolor="#FFFFFF"><strong><font color="#666666" size="2" face="Verdana, Arial, Helvetica, sans-serif">Nom
      : </font></strong></td>
    <td width="155" bgcolor="#FFFFFF"><div align="center">
        <input name="nom" type="text" id="nom" value="<?php echo $this->_tpl_vars['nom']; ?>
">
      </div>
    </td>
  </tr>
  
   <tr>
    <td width="326" bgcolor="#FFFFFF"><strong><font color="#666666" size="2" face="Verdana, Arial, Helvetica, sans-serif">Prénom
      : </font></strong></td>
    <td width="155" bgcolor="#FFFFFF"><div align="center">
        <input name="prenom" type="text" id="prenom" value="<?php echo $this->_tpl_vars['prenom']; ?>
">
      </div>
    </td>
  </tr>
   <?php if (( $this->_tpl_vars['gestiondroit'] == 'on' )): ?>
  <tr>
    <td width="326" bgcolor="#FFFFFF"><strong><font color="#666666" size="2" face="Verdana, Arial, Helvetica, sans-serif">Nom
      d'utilisateur : </font></strong></td>
    <td width="155" bgcolor="#FFFFFF"><div align="center">
        <input name="identifiant" type="text" id="identifiant" value="<?php echo $this->_tpl_vars['identifiant']; ?>
">
      </div>
    </td>
  </tr>
   <?php endif; ?>
  <tr>
    <td width="326" bgcolor="#FFFFFF"><strong><font color="#666666" size="2" face="Verdana, Arial, Helvetica, sans-serif">Mot de passe : </font></strong></td>
    <td width="155" bgcolor="#FFFFFF"><div align="center">
        <input name="passe" type="password" id="passe" value="<?php echo $this->_tpl_vars['passe']; ?>
">
      </div>
    </td>
  </tr>
   <tr>
    <td width="326" bgcolor="#FFFFFF"><strong><font color="#666666" size="2" face="Verdana, Arial, Helvetica, sans-serif">Adresse e-mail : </font></strong></td>
    <td width="155" bgcolor="#FFFFFF"><div align="center">
        <input name="email" type="text" id="email" value="<?php echo $this->_tpl_vars['email']; ?>
">
      </div>
    </td>
  </tr>
  
  
    <?php if (( $this->_tpl_vars['gestiondroit'] == 'on' )): ?>
<tr>
    <td width="326" bgcolor="#FFFFFF"><strong><font color="#666666" size="2" face="Verdana, Arial, Helvetica, sans-serif">Actif / Inactif : </font></strong></td>
    <td width="155" bgcolor="#FFFFFF"><div align="left">
	<?php if (( $this->_tpl_vars['active'] == 'on' )): ?>
	<input name="status" type="radio" value="1" checked > Actif 
	<input name="status" type="radio" value="0"  > Inactif
	 <?php endif; ?>
	
	<?php if (( $this->_tpl_vars['active'] == 'off' )): ?>
	<input name="status" type="radio" value="1"  > Actif 
	<input name="status" type="radio" value="0" checked > Inactif
	  <?php endif; ?>
	  
	  <?php if (( empty ( $this->_tpl_vars['active'] ) )): ?>
	 	<input name="status" type="radio" value="1"  > Actif 
	<input name="status" type="radio" value="0"  > Inactif
	 <?php endif; ?>
	 
	<br> 
	
      </div>
    </td>
  </tr>
    <?php endif; ?>
  
  
  <?php if (( $this->_tpl_vars['gestiondroit'] == 'on' )): ?>
<tr>
    <td width="326" bgcolor="#FFFFFF"><strong><font color="#666666" size="2" face="Verdana, Arial, Helvetica, sans-serif">Droit utilisateur : </font></strong></td>
    <td width="155" bgcolor="#FFFFFF"><div align="left">
	<?php if (( $this->_tpl_vars['admin'] == 'on' )): ?>
	<input name="droit" type="radio" value="1" checked > Administrateur 
	  <?php else: ?>
	<input name="droit" type="radio" value="1"  > Administrateur 
	  <?php endif; ?>
	
	<br> 
	<?php if (( $this->_tpl_vars['util'] == 'on' )): ?>
	<input name="droit" type="radio" value="2" checked > Modérateur
	<?php else: ?>
		<input name="droit" type="radio" value="2"  > Modérateur
    <?php endif; ?>
      </div>
    </td>
  </tr>
    <?php endif; ?>
</table>

   <?php if (( $this->_tpl_vars['gestiondroit'] == 'on' )): ?>
   <?php if (( $this->_tpl_vars['modif'] == 1 )): ?>
<input name="id" type="hidden" id="id" value="<?php echo $this->_tpl_vars['id']; ?>
">
<input type="submit" name="Submit" value="Modifier l'utilisateur" onclick="return confirm('Êtes-vous sûr(e) de modifier l\'utilisateur ?');">
</form>

<form name="suppr" action="gestionlogin.php?sup=1&id=<?php echo $this->_tpl_vars['id']; ?>
" method="post" >
<input name="id" type="hidden" id="id" value="<?php echo $this->_tpl_vars['id']; ?>
">
<input type="submit" name="Submit" value="Supprimer l'utilisateur" onclick="return confirm('Êtes-vous sûr(e) de supprimer l\'utilisateur ?');">
</form>
<?php else: ?>
   <input name="id" type="hidden" id="id" value="<?php echo $this->_tpl_vars['id']; ?>
">
<input type="submit" name="Submit" value="Ajouter l'utilisateur">
</form>
<?php endif; ?>
<?php else: ?>
<input name="id" type="hidden" id="id" value="<?php echo $this->_tpl_vars['id']; ?>
">
<input type="submit" name="Submit" value="Modifier l'utilisateur" onclick="return confirm('Êtes-vous sûr(e) de modifier l\'utilisateur ?');">
</form>
<?php endif; ?>
</center>