<?if (!defined('IN_ADMIN')) die('This page cannot be accessed out of context.');

// open the archive directory
$d = @opendir($cfg['savemailto'].'/');
if ($d === false) die('Could not open mail archive. Check directory permissions.');

if (isset($_GET['read'])) {
  $fp = @fopen($cfg['savemailto'].'/'.$_GET['read'], 'rb');
  if ($fp === false) die('Mail file could not be opened. Check file permissions');
  $fcont = fread($fp, filesize($cfg['savemailto'].'/'.$_GET['read']));
  fclose($fp);
  
  if (is_file($cfg['savemailto'].'/'.'tmp_'.substr($fmail,4))) $status = false;
  else $status = true;

  $remail = explode("\n", $fcont);
  $from = $remail[5];
  $subj = $remail[6];
  $body = '';
  for ($i=7;$i<count($remail);$i++) {
    $body .= $remail[$i];
  }
?>
<table border="0" cellpadding="0" cellspacing="0" align="center">
<tr><td>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td>
<table border="0" cellpadding="4" cellspacing="0" bgcolor="#efefef" align="left" style="border: #dedede 3px double;">
<tr><td>From:</td><td><?=$from?></td>
<tr><td>Subject:</td><td><?=$subj?></td>
</table>
</td><td align="center">&nbsp; Status: 
<?if ($status) {?>
<font color="green"><b>sent</b></font></td></tr>
<?} else {?>
<font color="red"><b>failed</b></font><br>[<a href="admin.php?do=email&resume=<?=$_GET['read']?>">Resume</a>]</td></tr>
<?}?>
</table>
</td></tr><tr><td>&nbsp;
<table border="0" cellpadding="4" cellspacing="0" bgcolor="#efefef" align="center" style="border: #dedede 3px double;">
<tr><td><?=$body?></td></tr>
</table>
</td></tr></table>
<?  
}
else {
  $email = array();
  $i = 0;
  while (($fmail = readdir($d)) !== false) { 
    if (substr($fmail,0,3) == 'eml') {
      $fp = @fopen($cfg['savemailto'].'/'.$fmail, 'rb');
      if ($fp === false) die('Mail file could not be opened. Check file permissions');
      $fcont = fread($fp, 512); // first 512 should be enough
      $lines = explode("\n", $fcont);
      $email[$i]['name'] = $fmail;
      $email[$i]['tme'] = $lines[0];
      $email[$i]['subj'] = $lines[6];
    
      if (is_file($cfg['savemailto'].'/'.'tmp_'.substr($fmail,4))) $email[$i]['status'] = false;
      else $email[$i]['status'] = true;
    
      $i++;
      fclose($fp);
    }
  }

  if (count($email) == 0) {
    echo '<center><i>No emails found.</i></center>';
    if (!$cfg['savemail']) echo '<center><i>txtList is not configured to archive emails.</i></center>';
  } 
  else {
    function cmp($a, $b) {
      return strcmp($b['tme'], $a['tme']);
    }
    usort($email, "cmp");    
    $perpg = 20;
    $pgs = ceil(count($email)/$perpg);
    $pg = $_GET['pg'];
    if (!isset($pg) || $pg < 1 || $pg > $pgs) $pg = 1;
?>
<table border="0" cellpadding="0" cellspacing="0" align="center">
<tr><td align="right">
<center><?=($pg-1>0)?'<a href="admin.php?do=archive&pg='.($pg-1).'&'.strip_tags(SID).'">&laquo</a>':''?> Page <?=$pg?> of <?=$pgs?> (<?=count($email)?> total) <?=($pg+1<=$pgs)?'<a href="admin.php?do=archive&pg='.($pg+1).'&'.strip_tags(SID).'">&raquo</a>':''?></center>
<table border="0" cellpadding="4" cellspacing="0" bgcolor="#efefef" style="border: #dedede 3px double;" width="100%">
<tr><td align="center"><b>subject</b></td><td align="center"><b>status</b></td><td align="center"><b>date sent</b></td></tr>
<?     
    for ($i=($pg-1)*$perpg;$i<$pg*$perpg && $i<count($email);$i++) {
      $cnt = ($cnt)?false:true;
?>
<tr>
<td bgcolor="<?=($cnt)?'#ffffff':'#f4f4f4'?>"><a href="admin.php?do=archive&read=<?=$email[$i]['name']?>"><?=$email[$i]['subj']?></a><?if (!$email[$i]['status']) {?>[<a href="admin.php?do=email&resume=<?=$email[$i]['name']?>">resume</a>]<?}?></td>
<td bgcolor="<?=($cnt)?'#ffffff':'#f4f4f4'?>"><?=($email[$i]['status'])?'<font color="green">sent</font>':'<font color="red">failed</font>'?></td>
<td bgcolor="<?=($cnt)?'#ffffff':'#f4f4f4'?>"><?=date('Y-m-d H:i', $email[$i]['tme'])?></td>
</tr>
<?
    }
?>
</table>
<center><?=($pg-1>0)?'<a href="admin.php?do=archive&pg='.($pg-1).'&'.strip_tags(SID).'">&laquo</a>':''?> Page <?=$pg?> of <?=$pgs?> (<?=count($email)?> total) <?=($pg+1<=$pgs)?'<a href="admin.php?do=archive&pg='.($pg+1).'&'.strip_tags(SID).'">&raquo</a>':''?></center>
</td></tr>
</table>
</form>
<?
  }
}
?>

