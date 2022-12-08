<?php /* Smarty version 2.6.14, created on 2009-03-31 19:56:59
         compiled from formulaire-ip.html */ ?>

<center>
<?php if (( $this->_tpl_vars['modif'] == 1 )): ?>

<form name="modif" action="gestionip.php?mod=1&id=<?php echo $this->_tpl_vars['id']; ?>
" method="post" >
<?php else: ?>
<form name="add" action="gestionip.php?ad=1" method="post" >
<?php endif; ?>

<table width="491" border="0"  bgcolor="#CCCCCC">
  <tr>
    <td width="326" bgcolor="#FFFFFF"><strong><font color="#666666" size="2" face="Verdana, Arial, Helvetica, sans-serif">Adresse IP : </font></strong></td>
    <td width="155" bgcolor="#FFFFFF"><div align="center">
        <input name="ip" type="text" id="ip" value="<?php echo $this->_tpl_vars['ip']; ?>
">
      </div>
    </td>
  </tr>

  

    
</table>
<?php if (( $this->_tpl_vars['modif'] == 1 )): ?>
<input name="id" type="hidden" id="id" value="<?php echo $this->_tpl_vars['id']; ?>
">
<input type="submit" name="Submit" value="Modifier l'IP" onclick="return confirm('Êtes-vous sûr(e) de modifier l\'IP ?');">
</form>

<form name="suppr" action="gestionip.php?sup=1&id=<?php echo $this->_tpl_vars['id']; ?>
" method="post" >
<input name="id" type="hidden" id="id" value="<?php echo $this->_tpl_vars['id']; ?>
">
<input type="submit" name="Submit" value="Supprimer l'IP" onclick="return confirm('Êtes-vous sûr(e) de supprimer l\'IP ?');">
</form>
<?php else: ?>
   <input name="id" type="hidden" id="id" value="<?php echo $this->_tpl_vars['id']; ?>
">
<input type="submit" name="Submit" value="Ajouter l'IP">
</form>
<?php endif; ?>

</center>