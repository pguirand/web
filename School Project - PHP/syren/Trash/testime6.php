<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>test time 2</title>
</head>

<body>
<?php
//Date récupérer
$jour = "05";
$mois = "07";
$annee = "2005";

//Conversions timestamp ...
$timestamp = mktime(0,0,0,$mois,$jour,$annee);
$dates = date("D/M/Y",$timestamp);
echo $dates;

?>
<br>
<?php
$jour = "05";
$mois = "07";
$annee = "2005";
$date = $jour.'.'.$mois.'.'.$annee;
$timestamp = strtotime($date); //Transforme la date contenue dans une string en un timstemap
echo date('m/d/Y h:i:s', $timestamp); //Affiche bien 05.07.2005
?>
<br>
<?php
$date = strtotime("01/12/2008 17.18");
echo date('m-d-Y h:i:s A',$date);
?>

</body>
</html>
