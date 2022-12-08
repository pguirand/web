<?php
require_once("functions.php");

$action = $_SERVER['PHP_SELF'];
 affText($_GET['nom']);
 
 concat($_GET['nom']);


?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body><form action="<?php echo $action ?>" method="get"><input name="nom" type="text" /></form>
</body>
</html>