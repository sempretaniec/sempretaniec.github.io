<?
require('config.inc.php');
require('functions.inc.php');

// Max execution time of script. This does not include sleep time, so only restricts time 
// allowed for mailing.
set_time_limit(3600);

$type = $_GET['type'];
$addr = stripslashes(urldecode($_GET['email']));

if ($type == 'sub') {
  // subscribe address. Actually, all it does is send the confirmation email
  if (!preg_match('#^([a-z0-9\-_.]+?)@([\w\-]+\.([\w\-\.]+\.)?[\w]+[^\".,?! ])$#i', $addr)) {
    $err = 'Z³y adres mailowy';
  }
  if (!isset($err)) {
    $f = openfile($cfg['listfile']);
    $exists = false;
    while ($item = readitem($f)) {
      if ($item['addr'] == $addr) {$exists = true;break;}
    }
    if ($exists) {
      $err = 'Taki adres mailowy ju¿ znajduje siê na naszej li¶cie';
    }
  }
  if (!isset($err)) {
    // send confirmation email
    $headers = 'From: '.$cfg['from'];
    if ($cfg['headers']) {
      foreach ($cfg['headers'] as $val) $headers .= "\n".$val;
    }
    $headers .= "\n".$cfg['header_plain'];
    if (!@mail($addr, $cfg['subj_conf'], sprintf($cfg['msg_conf'], '?type=confirm&email='.urlencode($addr)), $headers)) {
      $err = 'Wystapi³ bl±d podczas dodawania adresu. Spr&oacute;buj ponownie p&oacute;¼niej';
    }
  }
  if (!isset($err)) {
    // confirmation sent
    if (isset($cfg['returnto_conf']) && $cfg['returnto_conf'] != '') {
      header('Location: '.$cfg['returnto_conf']);
    }
    else { 
      printf($cfg['template'], 'Awaiting confirmation', 'Na podany przez Ciebie adres mailowy, '.$addr.', zosta³ wys³any link potwierdzaj±cy. Nale¿y go klikn±c w celu dokoñczenia subskrybcji.');
    }
  }
  else {
    // problem with subscription
    echoerr($err);
  }
}
elseif ($type == 'unsub') {
  // unsubscribe address
  $f = openfile($cfg['listfile']);
  $exists = false;
  while ($item = readitem($f)) {
    if ($item['addr'] == $addr) {$exists = true;break;}
  }
  if ($exists) {
    delitem($f, $item['id']);
  }
  else {
    $err = 'Nie ma takiego adresu mailowego';
  }
  if (!isset($err)) {
    // unsubscribe successful
    if (isset($cfg['returnto_unsub']) && $cfg['returnto_unsub'] != '') {
      header('Location: '.$cfg['returnto_unsub']);
    }
    else { 
      printf($cfg['template'], 'Unsubscribed', 'Tw&oacute;j adres, '.$addr.' zosta³ usuniety z naszej listy');
    }
  }
  else {
    // problem with unsubscription
    echoerr($err);
  }
}
elseif ($type == 'confirm') {
  // subscribe a confirmed address
  if (!preg_match('#^([a-z0-9\-_.]+?)@([\w\-]+\.([\w\-\.]+\.)?[\w]+[^\".,?! ])$#i', $addr)) {
    $err = 'Your email address appears to be invalid. If you are pasting the URL from your confirmation email, make sure the URL wasn\'t split into two lines.';
  }
  if (!isset($err)) {
    $f = openfile($cfg['listfile']);
    $exists = false;
    while ($item = readitem($f)) {
      if ($item['addr'] == $addr) {$exists = true;break;}
    }
    if ($exists) {
      $err = 'Ten adres mailowy ju¿ znajduje siê na naszej li¶cie';
    }
  }
  if (!isset($err)) {
    // subscribe successful
    writeitem($f, $addr);
    if (isset($cfg['returnto_sub']) && $cfg['returnto_sub'] != '') {
      header('Location: '.$cfg['returnto_sub']);
    }
    else { 
      printf($cfg['template'], 'Subscribed', 'Tw&oacute;j adres mailowy, '.$addr.', zostal dodany do naszej listy. Dziêkujemy.');
    }
  }
  else {
    // problem with subscription
    echoerr($err);
  }
}

function echoerr($err) {
  printf($GLOBALS['cfg']['template'], 'Error', '<font color="red">Error: '.$err.'</font>');
}
?>