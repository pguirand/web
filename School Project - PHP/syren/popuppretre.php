<?php require_once('Connections/connex.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}


#	LANCEMENT DE LA RECHERCHE
#	================================

#	LANCEMENT DU CODE :
$rechByNifAction = $_SERVER['PHP_SELF'];

#	VERIFICATION DU TYPE DE LA RECHERCHE
if (isset($_GET['choixId']))
	{
	$rechFlag = "oui";
		switch($_GET['choixId'])
			{
				case	"NIF"			:	$champs = "NUM_NIF";
											break;
				case	"CIF"			:	$champs = "NUM_CIF";
											break;
				case	"NUM_PASSPORT"	:	$champs = "NUM_PASSPORT";
											break;		
			}
		
		/*$maxRows_rechByNif = 4;
		$pageNum_rechByNif = 0;
		if (isset($_GET['pageNum_rechByNif'])) {
		  $pageNum_rechByNif = $_GET['pageNum_rechByNif'];
		}
		$startRow_rechByNif = $pageNum_rechByNif * $maxRows_rechByNif;
		*/
		$colname_rechByNif = "-1";
		if (isset($_GET['NUM_NIF'])) {
		  $colname_rechByNif = $_GET['NUM_NIF'];
		}		
			mysql_select_db($database_connex, $connex);
			$query_rechByNif = sprintf("SELECT * FROM individu WHERE ".$champs." = %s ORDER BY ".$champs." ASC", GetSQLValueString(			$colname_rechByNif, "text"));
			$rechByNif = mysql_query($query_rechByNif, $connex) or die(mysql_error());
			$row_rechByNif = mysql_fetch_assoc($rechByNif);
			$totalRows_rechByNif = mysql_num_rows($rechByNif);		
	}
/*if (isset($_GET['totalRows_rechByNif'])) {
  $totalRows_rechByNif = $_GET['totalRows_rechByNif'];
} else {
  $all_rechByNif = mysql_query($query_rechByNif);
  $totalRows_rechByNif = mysql_num_rows($all_rechByNif);
}
$totalPages_rechByNif = ceil($totalRows_rechByNif/$maxRows_rechByNif)-1;*/
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>

<title>Untitled Document</title>


<script language="JavaScript" type="text/javascript">

function setMaster() {
var form2 = opener.document.form2;
var popForm = document.popForm;
var currEl;
for (var i=0; i<popForm.length; i++) {
currEl = popForm[i];
if (form2[currEl.name]) {
form2[currEl.name].value = popForm[currEl.name].value;
}
}
if (opener && !opener.closed) opener.focus();
self.close();
}

</script>


<link href="css/style.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style10 {
	font-size: small
}
#search {		background-color:#eee;
}

body{width:295px; height:351px;} 
-->
</style>


<style type="text/css">
<!--
#apDiv1 {
	position:absolute;
	left:728px;
	top:551px;
	width:138px;
	height:30px;
	z-index:1;
}
-->
</style>
</head>

<body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0" marginwidth="0" marginheight="0"> 
	      
<div id="popupscreen">
       
	        
<div id="popupbody">


  <h2 align="center" class="style10">PROCESSUS D'ENREGISTREMENT D'	INDIVIDU</h2>
  <form id="form2" name="form2" method="GET" action="<?php echo $rechByNifAction; ?>">
                 
                  <h3 align="center">Recherche Individu</h3>
<table width="52%" height="156" border="1" align="center" >
                    <tr class="head">
                      <td colspan="2"><div align="center">IDENTIFIANT</div></td>
                    </tr>
                    <tr>
                      <td width="147"><label>
                        <input name="NUM_NIF" type="text" id="NUM_NIF" value="<?php echo $_GET['NUM_NIF'] ?>" maxlength="22" />
                      </label></td>
                      <td width="161"><p>
                        <label>
                          <input name="choixId" type="radio" id="RadioGroup1_0" value="NIF" 
						  	<?php 
								if($_GET['choixId'] == "NIF") 
						  			echo "checked='checked'";
								else if($_GET['choixId'] == "")
						  			echo "checked='checked'";
							?>  />
                          NIF</label>
                        <br />
                        <label>
                        <input type="radio" name="choixId" value="CIF" <?php if($_GET['choixId'] == "CIF") echo "checked='checked'" ?>  id="RadioGroup1_1" />
                          CIN</label>
                        <br />
                        <label>
                        <input type="radio" name="choixId" value="NUM_PASSPORT" <?php if($_GET['choixId'] == "NUM_PASSPORT") echo "checked='checked'" ?>  id="RadioGroup1_2" />
                          No Passeport</label>
                        <br />
                      </p></td>
                    </tr>
                    <tr>
                      <td><input type="submit" name="button" id="button" value="Rechercher" /></td>
                      <td><label>
                        <input type="reset" name="button2" id="button2" value="Reset" />
                      </label></td>
                    </tr>
                  </table>
  </form>


<?php
#	AFFoui ICHER LE RESULTAT SI LA RECHERCHE EST EFFECTUEE
#	======================================================
if (isset($_GET['NUM_NIF']) && ($row_rechByNif['NOM_IND'] != ""))
	{
?>
  <div align="center">
   <div class="logoutok"> NIF VALIDE </div><BR>
   <div class="fonce">Résultats</div> 
    <table border="1" id="comliste">
      <tr class="head">
	  <?php
if ($champs == "NUM_NIF")
		{ ?>       
      	<td>NIF</td>
        <?php } 
if($champs == "NUM_CIF") {?>         
        <td>CIN</td>
        <?php }
if($champs == "NUM_PASSPORT"){?>         
        <td>No PASSEPORT</td>
        <?php }?>
        <td>NOM_IND</td>
        <td>PRENOM_IND</td>
        <td>SEXE_IND</td>
      </tr>
      <tr><?php
      	if($champs == "NUM_NIF") {?>
      	<td><?php echo $row_rechByNif['NUM_NIF']; ?></td><?php }
        if($champs == "NUM_CIF") {?>
        <td><?php echo $row_rechByNif['NUM_CIF']; ?></td><?php }
        if($champs == "NUM_PASSPORT") {?>
        <td><?php echo $row_rechByNif['NUM_PASSPORT']; ?></td><?php } ?>
        <td><?php echo $row_rechByNif['NOM_IND']; ?></td>
        <td><?php echo $row_rechByNif['PRENOM_IND']; ?></td>
        <td><?php echo $row_rechByNif['SEXE_IND']; ?></td>
      </tr>
</table>


<form name="popForm" onsubmit="setMaster()">
                <input name="lnamep" type="hidden" value="<?php echo $row_rechByNif['NOM_IND']; ?>">
<br>
<input name="fnamep" type="hidden" value="<?php echo $row_rechByNif['PRENOM_IND'];?>" /><br>
<input name="idp" type="hidden" value="<?php echo $row_rechByNif['ID_IND'];?>"/>
<input type="submit" value="Selectionner">
</form>

    <br><br>
<?php /*?>        <a href="creation_usr.php?ID_IND=<?php echo $row_rechByNif['ID_IND']."&NOM_IND=".$row_rechByNif['NOM_IND'] ?>" onclick="">Creer le user</a>  </div><?php */?>

  <?php /*?><?php
$stringnif = $_GET['NUM_NIF'];
echo $stringnif;
$nbchar = strlen($stringnif);?><br>
<?php
if ($nbchar = 10) 
	echo "NIF Invalide";
else
	echo "NIF Valide";
echo $nbchar; 
?><?php */?>
<?php
	}
	else if ($rechFlag == "oui")
$warning = "<div class='logindenied'>Veuillez rentrer un numero d'identifiant</div>";
echo $warning;
?>
</div>
</div>
  <div class="spacer"></div>
		</div>

</body>
</html>
<?php /*?>
<?php
mysql_free_result($rechByNif);

mysql_free_result($loggedUser);
?>
<?php */?>