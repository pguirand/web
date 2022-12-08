<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>TEST TIME</title>
</head>
<?php
$date_string = mktime(0,0,0,date("m"),date("d"),date("Y"));
// nombre de jour que vous voulez à ajouter ici c'est 60 jours
$nombre_jour = 60;
// vous pouvez déduire la date d'aujourd'hui en remplaçant le signe + en -
$timestamp = $date_string + ($nombre_jour * 86400);
$nouvelle_date = date("Y-m-d", $timestamp);

// pour afficher la nouvelle date
echo $nouvelle_date."<br>";
$h= date("Y-m-d", $date_string);
echo $h;

?> <br><br>
<?php
$date1 = strtotime("12-12-2008");
$date2 = strtotime("05-12-2008");
$date = $date1 - $date2;
$heure = $date/3600;
$jour = $date/86400;
echo $date1;
echo $date2;
echo "la difference entre les deux date est de ".$jour." jours; soit ".$heure." heures";
?>
<body>
</body>
</html>
