<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_connex = "localhost";
$database_connex = "syren";
$username_connex = "root";
$password_connex = "";
$connex = mysql_pconnect($hostname_connex, $username_connex, $password_connex) or trigger_error(mysql_error(),E_USER_ERROR); 
?>