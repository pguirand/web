<?php /* Smarty version 2.6.14, created on 2009-03-31 19:56:42
         compiled from formulaire-ajout-groupe.html */ ?>

<center>
<?php if (( $this->_tpl_vars['modif'] == 1 )): ?>

<form name="modif" action="gestiongroupes.php?mod=1&idgroupe=<?php echo $this->_tpl_vars['idgroupe']; ?>
" method="post" >
<?php else: ?>
<form name="add" action="gestiongroupes.php?ad=1" method="post" >
<?php endif; ?>

<table width="491" border="0"  bgcolor="#CCCCCC">
  <tr>
    <td width="326" bgcolor="#FFFFFF"><strong><font color="#666666" size="2" face="Verdana, Arial, Helvetica, sans-serif">Nom
      du groupe : </font></strong></td>
    <td width="155" bgcolor="#FFFFFF"><div align="center">
        <input name="groupe" type="text" id="groupe" value="<?php echo $this->_tpl_vars['groupe']; ?>
">
      </div>
    </td>
  </tr>

  

   
</table>
<?php if (( $this->_tpl_vars['modif'] == 1 )): ?>
<input type="submit" name="Submit" value="Modifier le groupe" onclick="return confirm('Êtes-vous sûr(e) de modifier le groupe ?');">
</form>

	<?php if (( ! empty ( $this->_tpl_vars['lock'] ) )): ?>
	<input type="submit" name="Submit" value="Supprimer le groupe"  onclick="alert('Suppression impossible plusieurs utilisateurs sont attaché à ce groupe');">
	 <?php else: ?>
	 <form name="suppr" action="gestiongroupes.php?sup=1&idgroupe=<?php echo $this->_tpl_vars['idgroupe']; ?>
" method="post" >
	 <input type="submit" name="Submit" value="Supprimer le groupe" onclick="return confirm('Êtes-vous sûr(e) de supprimer le groupe ?');">
	 </form>
	 <?php endif; ?>


<?php else: ?>
<input type="submit" name="Submit" value="Ajouter un groupe">
</form>
<?php endif; ?>

</center>