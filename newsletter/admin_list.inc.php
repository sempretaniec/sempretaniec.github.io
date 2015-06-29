<?if (!defined('IN_ADMIN')) die('This page cannot be accessed out of context.');

if (isset($_POST['delsel'])) {
  $f = openfile($cfg['listfile']);
  $del = 0;
  // delete all checked addresses
  foreach ($_POST as $key => $val) {
    if (substr($key,0,4) == 'del_') {
      delitem($f, (int)$val);
      $del++;
    }
  } 
  if ($del > 0) echo '<center><font color="green"><b>'.$del.' addresses deleted</b></font></center>';
  else echo '<center><font color="red"><b>no addresses selected</b></font></center>';
}

$f = openfile($cfg['listfile']);
$subs = array();$i = 0;
while ($item = readitem($f)) {
  $subs[$i]['id'] = $item['id'];
  $subs[$i]['addr'] = $item['addr'];
  $subs[$i]['tme'] = $item['tme'];
  $subs[$i]['ip'] = $item['ip'];
  $i++;
}
if (count($subs) == 0) {
  echo '<center><i>No subscribers found</i></center>';
} 
else {
  function cmp($a, $b) {
    return strcmp($a['addr'], $b['addr']);
  }
  usort($subs, "cmp");    
  $perpg = 20;
  $pgs = ceil(count($subs)/$perpg);
  $pg = $_GET['pg'];
  if (!isset($pg) || $pg < 1 || $pg > $pgs) $pg = 1;
?>

<center><a href="<?=$cfg['listfile']?>">download raw list file</a></center>

<form name="del" action="<?=$_SERVER['PHP_SELF']?>?<?=$_SERVER['QUERY_STRING']?>" method="post">
<table border="0" cellpadding="0" cellspacing="0" align="center">
<tr><td align="right">
<center><?=($pg-1>0)?'<a href="admin.php?do=list&pg='.($pg-1).'&'.strip_tags(SID).'">&laquo</a>':''?> Page <?=$pg?> of <?=$pgs?> (<?=count($subs)?> total) <?=($pg+1<=$pgs)?'<a href="admin.php?do=list&pg='.($pg+1).'&'.strip_tags(SID).'">&raquo</a>':''?></center>
<input type="submit" name="delsel" value="Delete selected">
<table border="0" cellpadding="4" cellspacing="0" bgcolor="#efefef" style="border: #dedede 3px double;" width="100%">
<tr><td align="center"><b>id</b></td><td align="center"><b>email address</b></td><td align="center"><b>subscribe time</b></td><td align="center"><b>ip</b></td><td align="right"><b>del</b></td></tr>
<?     
  for ($i=($pg-1)*$perpg;$i<$pg*$perpg && $i<count($subs);$i++) {
    $cnt = ($cnt)?false:true;
?>
<tr>
<td bgcolor="<?=($cnt)?'#ffffff':'#f4f4f4'?>"><?=$subs[$i]['id']?></td>
<td bgcolor="<?=($cnt)?'#ffffff':'#f4f4f4'?>"><?=$subs[$i]['addr']?></td>
<td bgcolor="<?=($cnt)?'#ffffff':'#f4f4f4'?>"><?=date('Y-m-d H:i', $subs[$i]['tme'])?></td>
<td bgcolor="<?=($cnt)?'#ffffff':'#f4f4f4'?>"><?=$subs[$i]['ip']?></td>
<td bgcolor="<?=($cnt)?'#ffffff':'#f4f4f4'?>" align="right"><input type="checkbox" name="del_<?=$subs[$i]['id']?>" value="<?=$subs[$i]['id']?>" style="margin: -2px"></td>
</tr>
<?
  }
?>
</table>
<input type="submit" name="delsel" value="Delete selected">
<center><?=($pg-1>0)?'<a href="admin.php?do=list&pg='.($pg-1).'&'.strip_tags(SID).'">&laquo</a>':''?> Page <?=$pg?> of <?=$pgs?> (<?=count($subs)?> total) <?=($pg+1<=$pgs)?'<a href="admin.php?do=list&pg='.($pg+1).'&'.strip_tags(SID).'">&raquo</a>':''?></center>
</td></tr>
</table>
</form>
<?
}
?>
