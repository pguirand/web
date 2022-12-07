<?php
#==================================================
#	CRYPTAGE DU MOT DE PASSE
#==================================================
$sql = "select * from usertable where username='" . $_POST['username'] . "'"; 
$result = mysql_query($sql); 
if (mysql_num_rows($result) >= 1) { 
 $error = "please enter another username"; 
 include "creation_usr.php"; 
 exit(); 
} else { 
 $username = $_POST['username']; 
 $userpass = md5($_POST['userpass']); 
 $sql = "insert into usertable values('$username','$userpass')"; 
 mysql_query($sql); 
 include "saveutilok.php"; 
}
?>