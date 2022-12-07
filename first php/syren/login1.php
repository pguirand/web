<?php require_once('Connections/connex.php'); ?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['user'])) {
  $loginUsername=$_POST['user'];
  $password=$_POST['password'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "login.php?result=yes";
  $MM_redirectLoginFailed = "login.php?result=no";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_connex, $connex);
  
  $LoginRS__query=sprintf("SELECT user, pass FROM utilisateurs WHERE user='%s' AND pass='%s'",
    get_magic_quotes_gpc() ? $loginUsername : addslashes($loginUsername), get_magic_quotes_gpc() ? $password : addslashes($password)); 
   
  $LoginRS = mysql_query($LoginRS__query, $connex) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>
<?php
if (isset($_GET['result']))
	{
		 $r = $_GET['result'];
	

if ($r == "yes")
	echo $warning = "Good login";
	else  echo $warning = "Bad login";
	}
?>
<body>
<?php //echo $warning; ?>
<form id="form1" name="form1" method="POST" action="<?php echo $loginFormAction; ?>">
  <table width="200" border="1">
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>u</td>
      <td><label>user
        <input name="username" type="text" id="username" />
      </label></td>
    </tr>
    <tr>
      <td>p</td>
      <td><label>pass
          <input name="password" type="password" id="password" />
      </label></td>
    </tr>
  </table>
  <label>go
  <input type="submit" name="Submit" value="Submit" />
  </label>
</form>

<a href="#" onclick="document.getElementById('lesdetails').style.display='block'">details</a>
<div id="lesdetails" style="display:none">tous les details que tu veux</div>
</body>
</html>
