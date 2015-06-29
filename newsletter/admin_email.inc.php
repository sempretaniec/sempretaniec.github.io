<?if (!defined('IN_ADMIN')) die('This page cannot be accessed out of context.');

// Archives email so it can be reused or resent. Allows for resumed sends.
function savemail ($from, $subj, $body, $startid, $ashtml) {
  global $cfg;
  // Open a most probably unique file.
  $unique = time().mt_rand(10,99);
  $m = @fopen($cfg['savemailto'].'/eml_'.$unique.'.txt', 'wb');
  if ($m === false) return false;

  fwrite($m, time()."\r\n");			// timestamp 
  fwrite($m, $startid."\r\n");			// startid
  fwrite($m, '0'."\r\n");			// endid (placeholder)
  fwrite($m, (($ashtml)?'1':'0')."\r\n");	// as HTML flag
  fwrite($m, '0'."\r\n");			// 'to' bitflags (placeholder)
  fwrite($m, $from."\r\n");			// from
  fwrite($m, $subj."\r\n");			// subject
  fwrite($m, $body);				// body
  
  fclose($m);
  return $unique;
}

if (isset($_POST['emailsub']) || isset($_POST['emailsubtest'])) {
  $from = stripslashes($_POST['from']);
  $subj = stripslashes($_POST['subj']);
  $body = stripslashes($_POST['body']);
  //$url = ($_POST['url']=='http://')?'':stripslashes($_POST['url']);
  $cc = (int)$_POST['cc'];
  $ashtml = (int)$_POST['ashtml'];
  $emaildone = (int)$_POST['emaildone'];
  $startnum = (int)$_POST['startnum'];
  $startpos = (int)$_POST['startpos'];

  $start = time();
    
  // better checking...
  if ($from == '') $err = 'No from email specified';
  if ($body == '' && $url == '') $err = 'No body text entered';
    
  if (!isset($err)) {
    // set headers
    $headers = "From: ".$from."\n";
    if ($ashtml) $headers .= $cfg['header_html'];
    else $headers .= $cfg['header_plain'];
    if ($cfg['headers']) {
      foreach ($cfg['headers'] as $val) $headers .= "\n".$val;
    }
    
    if (isset($_POST['emailsub'])) {
      // fetch addresses and process
      $succ = 0; $fail = 0;
      if ($cc) {
        // send CC email if needed
        if (@mail($cfg['ccaddress'], $subj, $body, $headers)) $succ++;
        else $fail++;
      }
      $f = openfile($cfg['listfile']);
      if ($startnum > 0) {
        // skip to specified record and start there.
        skiptoitem($f, $startnum);
      }
      if ($startpos > 0) {
        // startpos is used for resuming. It will override any startnum value.
        fseek($f, $startpos);
      }
      if ($cfg['savemail'] && !$_POST['resume']) {
        // save this email only if it's not a resume and it is configured for.
        if (($mfile = savemail($from, $subj, $body, $startid, $ashtml)) === false) $err = 'Could not save email. Check directory exists and permissions are set correctly.';
      }
      if (!isset($err)) {
        // create temp file for resume data
        if ($cfg['enableresume'] && $cfg['savemail']) {
          if ($_POST['resume']) {
            $fr = @fopen($cfg['savemailto'].'/tmp_'.substr($_POST['resume'],4), 'wb');
          }
          else {
            $fr = @fopen($cfg['savemailto'].'/tmp_'.$mfile.'.txt', 'wb');
          }
          if ($fr === false) $err = 'Could not create or open temp file. Check directory permissions.';
        }
        if (!isset($err)) {
          // WE'RE READY TO SEND!!!
          $cnt = 0;
          while ($item = readitem($f)) {
            // pause if we're on a multiple of the pause interval
            if ($cfg['pauseinterval'] > 0 && $cnt%(int)$cfg['pauseinterval'] == 0 && $cnt != 0) {
              sleep((int)$cfg['pausetime']);
            }
            // fetch addresses and send
            if (@mail($item['addr'], $subj, $body, $headers)) $succ++;
            else $fail++;
            $cnt++;
            // update the temp file with resume info
            if ($cfg['enableresume'] && $cfg['savemail']) {
              rewind($fr);
              fwrite($fr, $item['id']."\r\n");
            }
          }
        }
        if ($cfg['enableresume'] && $cfg['savemail']) {
          // mailing is done, so we delete the temp file
          // or, if this is a resume, delete the old temp file
          fclose($fr);
          if ($_POST['resume']) {
            unlink($cfg['savemailto'].'/'.'tmp_'.substr($_POST['resume'],4));
          }
          else {
            unlink($cfg['savemailto'].'/tmp_'.$mfile.'.txt');
          }
        }
      }
    }
    else {
      // send CC test email only
      if (@mail($cfg['ccaddress'], $subj, $body, $headers)) $succ++;
      else $fail++;
    }
    if ($emaildone) {
      $ebody = "Emailing to subscribers completed with this result:\n";
      $ebody .= (int)$succ." email(s) sent successfully.\n";
      $ebody .= (int)$fail." email(s) failed to send.\n\n";
      $ebody .= "Emailing began at ".date('H:i:s', $start)." and finished at ".date('H:i:s')."\n";
      $ebody .= "Process took ".round((time()-$start)/60, 0)." minutes, ".((time()-$start)%60)." seconds";
      if (@mail($cfg['ccaddress'], 'Mailing complete', $ebody, "From: ".$from)) $succ++;
      else $fail++;
    }
  }
?>
<div align="center"><b>
<?
  // results
  if (isset($err)) {
?><font color="red">Error: <?=$err?></font><?
  } else {
    if ($succ+$fail == 0) {?>No addresses found - no emails sent<?}
    if ($succ > 0) {?><font color="green"><?=$succ?> email(s) sent successfully</font><br><?}
    if ($fail > 0) {?><font color="red"><?=$fail?> email(s) failed to send</font><?}
  }
}
?>
</b></div>
<?
if ($_GET['resume']) {
  // we are resuming a failed send
  // start by getting email
  $fp = @fopen($cfg['savemailto'].'/'.$_GET['resume'], 'rb');
  if ($fp === false) die('Mail file could not be opened. Either it is not a archived email, or file permissions are incorrect.');
  $fcont = fread($fp, filesize($cfg['savemailto'].'/'.$_GET['resume']));
  fclose($fp);

  // check this is a failed email and get failure point
  $fp = @fopen($cfg['savemailto'].'/'.'tmp_'.substr($_GET['resume'],4), 'rb');
  if ($fp === false) die('Resume file could not be opened. Either this email did not fail, or file permissions are incorrect.');
  $startpos = (int)fgets($fp, 80);
  fclose($fp);  

  $remail = explode("\n", $fcont);
  $from = $remail[5];
  $subj = $remail[6];
  $body = '';
  for ($i=7;$i<count($remail);$i++) {
    $body .= $remail[$i];
  }
?>
<div align="center"><b>Resuming Send</b><br>To resume the send of this email, click 'send', below.</div>
<?
}
?>
<form name="email" action="admin.php?do=email&<?=strip_tags(SID)?>" method="post">
<input type="hidden" name="startpos" value="<?=(isset($startpos))?$startpos:0?>">
<input type="hidden" name="resume" value="<?=$_GET['resume']?>">
<table border="0" cellpadding="4" cellspacing="0" bgcolor="#efefef" align="center" style="border: #dedede 3px double;">
<tr><td>From:</td><td><input type="text" name="from" size="40" maxlength="100" value="<?=($from=='')?$cfg['from']:$from?>"></td>
  <td><input type="checkbox" name="emaildone" value="1" id="chk_emaildone" <?=($emaildone)?'checked':''?>> <label for="chk_emaildone">Send email on completion</label>&nbsp;</td>
  <td><input type="checkbox" name="cc" value="1" id="chk_cc" <?=(isset($cc) && $cc == 0)?'':'checked'?>> <label for="chk_cc">CC to self</label></td></tr>
<tr><td>Subject:</td><td><input type="text" name="subj" size="40" maxlength="200" value="<?=($subj)?$subj:''?>"></td>
  <td><?/*Start at #: <input type="text" name="startnum" size="8" maxlength="12" <?if ($_GET['resume']) echo 'disabled value="resume"'; elseif (isset($startid)) echo 'value="'.$startid.'"'; else echo 'value="0"';?>>*/?>&nbsp;</td>
  <td><input type="checkbox" name="ashtml" value="1" id="chk_ashtml" <?=($ashtml)?'checked':''?>> <label for="chk_ashtml">Send as HTML</label></td></tr>
<tr><td colspan="4"><textarea name="body" cols="100" rows="20" class="txtbox"><?=(isset($body))?$body:''?></textarea></td></tr>
<tr><td><!--OR from URL:</td><td><input type="text" name="url" value="http://" size="40" maxlength="200">-->&nbsp;</td>
<td colspan="3" align="right"><input type="submit" name="emailsubtest" value=" test send ">&nbsp;&nbsp;<input type="submit" name="emailsub" value=" send " onClick="return confirm('Are you sure? After confirming, please do not click the send or send test buttons! You are free to close the window after you click OK.')"></td></tr>
</table>
</form>