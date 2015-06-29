<?
require('config.inc.php');
require('functions.inc.php');

define('IN_ADMIN',true);

session_name('txtlist');
session_start();
  
if (isset($_POST['logsub'])) {
  if ($_POST['uname'] == $cfg['uname'] && $_POST['pword'] == $cfg['pword']) {
    $_SESSION['lin'] = true;
  }
  else {
    $err = 'Invalid username or password';
  }
}
elseif ($_GET['do'] == 'logout') {
  $_SESSION = array();
  session_destroy();
}
// write header
?>
<html>
<head>
<title>txtList admin</title>
<style type="text/css">
body {
  font-family: Arial, sans-serif;
  font-size: 10pt;
}
td {
  font-family: Arial, sans-serif;
  font-size: 10pt;
}
.txtbox {
  font-family: Arial, sans-serif;
  font-size: 10pt;
}
.smalltxt {
  font-size: 8pt;
  color: #cdcdcd;
}
A {
  color: #C43232;
}
.smalltxt A {
  color: #cdcdcd;
}
</style>
<script language="JavaScript">
function phelp(pg) {
  window.open('admin_help.php?pg='+pg,'help','width=400,height=500,resizable=yes,toolbars=no,scrollbars=yes,status=no');
}
</script>
</head>
<body>
<?
if ($_SESSION['lin']) {
  // we are logged in.
  function writemenu($item) {
    $items = array(
    'email' => 'send email', 
    'archive' => 'email archive',
    'newsub' => 'add subscribers', 
    'list' => 'subscriber list', 
    'logout' => 'log out'
    );
    foreach ($items as $a => $b) {
      if (isset($str)) $str .= ' &middot; ';else $str = '';
      $str .= ($a == $item)?'<b>':'<a href="admin.php?do='.$a.'&'.strip_tags(SID).'">';
      $str .= $b;
      $str .= ($a == $item)?'</b>':'</a>';
    }
    return $str;
  }
?>
<div style="font-size: 14pt;" align="center">txtList admin</div>
<div align="center"><?=writemenu($_GET['do'])?> &middot <a href="JavaScript:phelp('<?=$_GET['do']?>')">help</a></div>
<hr width="300" size="1" noshade color="#cdcdcd">
<p>
<?
  
  if ($_GET['do'] == 'email') {
    // ---------------------------- EMAIL SUBSCRIBERS
    require('admin_email.inc.php');
  }
  elseif ($_GET['do'] == 'archive') {
    // ---------------------------- EMAIL ARCHIVE
    require('admin_archive.inc.php');
  }
  elseif ($_GET['do'] == 'list') {
    // ---------------------------- LIST SUBSCRIBERS
    require('admin_list.inc.php');
  }
  elseif ($_GET['do'] == 'newsub') {
    // ---------------------------- ADD SUBSCRIBERS
    require('admin_newsub.inc.php');
  }
  else {
    // ---------------------------- DISPLAY MENU
?>
<center>You are logged-in. Choose a function from the list above</center>
<p>
<?
    if (ini_get('safe_mode')) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="400" align="center">
<tr><td>
<p><center><font color="red"><b>Note:</b></font> PHP is running in safe mode. This means txtList 
cannot set the script time limit itself.<p>
<?
      if (ini_get('max_execution_time') == 0) {
?>
However, currently PHP is not set up to impose a time limit, so this may not be a problem.
<?
      }
      else {
?>
Your current time limit is <?=ini_get('max_execution_time')?> seconds. This may not be enough if you 
intend to email large numbers of subscribers.
<?
      }
?>
</td></tr></table>
<?
    }
  }
}
elseif ($_GET['do'] == 'logout') {
  // ---------------------------- JUST LOGGED-OUT
?>
<div style="font-size: 14pt;" align="center">txtList admin</div>
<hr width="50%" size="1" noshade color="#cdcdcd">
<p>
<div align="center">
You have been logged-out successfully. 
<p>
<a href="admin.php">Click here</a> to log-in again.
</div>
<?
}
else {
  // ---------------------------- LOGIN FORM
?>
<div style="font-size: 14pt;" align="center">txtList admin</div>
<hr width="50%" size="1" noshade color="#cdcdcd">
<p>
<form name="txtlist" action="admin.php?do=<?=$_GET['do']?>" method="post">
<table border="0" cellpadding="4" cellspacing="0" bgcolor="#efefef" align="center" style="border: #dedede 3px double;">
<?=(isset($err))?'<tr><td colspan="2" align="center"><font color="red">'.$err.'</font></td></tr>':''?>
<tr><td>username:</td><td><input type="text" name="uname" value="" size="20" maxlength="100"></td></tr>
<tr><td>password:</td><td><input type="password" name="pword" value="" size="20" maxlength="100"></td></tr>
<tr><td colspan="2" align="center"><input type="submit" name="logsub" value="login"></td></tr>
</table>
</form>
<?
}
// footer
?>
<br><br><br>
<hr width="300" size="1" noshade color="#cdcdcd">
<div class="smalltxt" align="center">powered by <a href="http://txtbox.co.za/p_txtlist.php">txtList</a> &middot; copyright &copy; 2004, Txtbox</div>

</body>
</html>
