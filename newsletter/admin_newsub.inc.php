<?if (!defined('IN_ADMIN')) die('This page cannot be accessed out of context.');

if (isset($_POST['sub'])) {
  $add = stripslashes($_POST['add']);
  $sep = fixsep($_POST['sep']);
  $parse = (int)$_POST['parse'];
  $err = '';
  $afname = $_FILES['addfile']['name'];
  $aftmp = $_FILES['addfile']['tmp_name'];
  $showsucc = (int)$_POST['showsucc'];
  $showfail = (int)$_POST['showfail'];
  
  if ($afname && is_uploaded_file($aftmp)) {
    // it's a file upload, so read it
    $fp = @fopen($aftmp, 'r');
    if ($fp === false) die ('Uploaded file could not be opened.');
    $add = fread($fp, filesize ($aftmp)); // just replace existing add value
  }
  
  if ($add == '') $err = 'No addresses specified.';
  
  if (!$err) {
    $f = openfile($cfg['listfile']);				  // open list
    $existing = array();
    $succ = array();
    $fail = array(); $done = false; $i = 0;
    while ($item = readitem($f)) $existing[$item['addr']] = true; // read existing addresses
    if (!$parse) {
      // we're doing CSV-style parsing
      $adds = explode($sep, $add);	// split into addresses
      foreach ($adds as $email) {
        $email = fixemail($email);
        if ($email == '') continue;
        // check address is not already in list
        if (isset($existing[$email])) {
          $fail[$i]['addr'] = htmlspecialchars($email);
          $fail[$i]['reason'] = 'Already in list';
        }
        // check each address is correct
        elseif (!preg_match('#^([a-z0-9\-_.]+?)@([\w\-]+\.([\w\-\.]+\.)?[\w]+[^\".,?! ])$#i', $email)) {
          $fail[$i]['addr'] = htmlspecialchars($email);
          $fail[$i]['reason'] = 'Invalid';
        }
        else {
          // add to list, and existing emails array
          writeitem($f, $email);
          $existing[$email] = true;
          $succ[] = $email;
        }
        $i++;
      }
    }
    else {
      // we're doing "intelligent" parsing using this regex!
      $str = preg_match_all("#\b([a-z0-9\-_.]+?)@([\w\-]+\.([\w\-\.]+\.)?[\w]+\b)#i", $add, $adds);
      $j = 0;
      for ($i=0;$i<count($adds[0]);$i++) {
        $email = fixemail($adds[0][$i]);
        if (isset($existing[$email])) {
          $fail[$j]['addr'] = htmlspecialchars($email);
          $fail[$j]['reason'] = ' Already in list';
        }
        else {
          // add to list, and existing emails array
          //echo $email.'<br>';
          writeitem($f, $email);
          $existing[$email] = true;
          $succ[] = $email;
        }
        $j++;
      }
    }
    $done = true;
  }
}

?>
<script language="JavaScript">
function chkForm(obj) {
  if (obj.add.value != '' && obj.addfile.value != '') {
    return confirm('You have entered text in both the address and the file fields. If you continue, the address field will be ignored.');
  }
  else return true;
}
</script>
<table border="0" cellpadding="0" cellspacing="0" width="400" align="center">
<tr><td>
<?
if ($done) {
  // DONE. Write status
?>
<div align="center"><font color="green"><b>Operation complete</b></font><br>
<?if (count($succ) > 0) {?><b><?=count($succ)?></b> addresses added successfully<?} else {?>No addresses added<?}?><br>
<?if (count($fail) > 0) {?><b><?=count($fail)?></b> addresses failed<?}?>
<p>
<table border="0" cellpadding="0" cellspacing="0">
<tr>
<?
  if (count($succ) > 0 && $showsucc) {
?>
<td valign="top">
<table border="0" cellpadding="2" cellspacing="1" style="border: #dedede 1px solid">
<tr><td bgcolor="#dedede">Added addresses</td></tr>
<?
    foreach ($succ as $val) {
      echo '<tr><td>'.$val.'</td></tr>';
    }
?>
</table>
</td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
<?
  }
  if (count($fail) > 0 && $showfail) {
?>
<td valign="top">
<table border="0" cellpadding="2" cellspacing="1" style="border: #dedede 1px solid">
<tr><td bgcolor="#dedede">Failed addresses</td><td bgcolor="#dedede">&nbsp; Reason</td></tr>
<?
    foreach ($fail as $val) {
      echo '<tr><td>'.$val['addr'].'</td><td>&nbsp; '.$val['reason'].'</td></tr>';
    }
?>
</table>
</td>
<?
  }
?>
</tr>
</table>
<?
}
elseif ($err) {
?>
<div align="center"><font color="red"><b><?=$err?></b></font></div>
<?}?>
<form name="add" action="<?=$_SERVER['PHP_SELF']?>?<?=$_SERVER['QUERY_STRING']?>" method="post" enctype="multipart/form-data">
Enter one or more addresses below, in CSV format, or parsable.
<textarea name="add" cols="80" rows="5" class="txtbox"></textarea>
<div align="center"><p><b>OR</b><p></div>

Select a text file containing the addresses to be added.
<input type="file" name="addfile" size="36">

<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td>
<input type="checkbox" name="showsucc" value="1" id="chk_showsucc" <?=($showsucc)?'checked':''?>><label for="chk_showsucc">Show added emails</label><br>
<input type="checkbox" name="showfail" value="1" id="chk_showfail" <?=($showfail || !isset($showfail))?'checked':''?>><label for="chk_showfail">Show failed emails</label>
</td><td align="right">
<input type="radio" name="parse" value="0" id="chk_parse0" <?=(!$parse)?'checked':''?> onClick="JavaScript:this.form.sep.disabled = false"><label for="chk_parse0"> Use separator:</label> <input type="text" name="sep" size="6" value="\n" <?=($parse)?'disabled':''?>><br>
<input type="radio" name="parse" value="1" id="chk_parse1" <?=($parse)?'checked':''?> onClick="JavaScript:this.form.sep.disabled = true"><label for="chk_parse1"> Use smart parsing</label>
</td></table>

<p>
<div align="center">
<input type="submit" name="sub" value="Add Addresses" onClick="return chkForm(this.form)">
</div>
</form>


</td></table>

<?

function fixsep($sep) {
  // fix up the separator string
  $sep = trim($sep);
  if ($sep == '') return ' ';
  else {
    $sep = stripslashes($sep);
    $sep = str_replace('\t', "\t", $sep);
    $sep = str_replace('\n', "\n", $sep);
    $sep = str_replace('\r', "\r", $sep);
    return $sep;
  }
}

function fixemail($email) {
  // get rid of unnecessary characters
  $email = trim($email);
  $email = str_replace("\t", '', $email);
  $email = str_replace("\n", '', $email);
  $email = str_replace("\r", '', $email);
  return $email;
}