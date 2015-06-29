<?
// Change these login details first!
$cfg['uname'] = 'struna12';
$cfg['pword'] = '1struna1';

// The default FROM address, and the address subscription confirmation emails will come from.
$cfg['from'] = 'sempretaniec@sempretaniec.pl';

// The address to which CC'd emails and test emails will be sent.
$cfg['ccaddress'] = 'sempretaniec@sempretaniec.pl';

// When sending, txtList will pause every pauseinterval'th email, for pausetime seconds.
$cfg['pauseinterval'] = 100;

// Number of seconds to pause at each pauseinterval.
$cfg['pausetime'] = 3;

// The file storing the list of email addresses. Move it for security.
$cfg['listfile'] = 'list.txt';

// The subject of the confirmation email
$cfg['subj_conf'] = 'Potwierdzenie subskrybcji newslettera SEMPRE';

// The body of the confirmation email. Note the confirmation URL: it must point to the same place 
// the subscribe / unsubscribe form does, and the %s characters must appear at the end.
$cfg['msg_conf'] = "Witamy,

Prosimy o potwierdzenie subskrybcji naszego newslettera.
Kliknij w link ponbi¿ej

Dziêkujemy
SEMPRE Taniec & Fitness

Confirm: http://sempretaniec.pl/newsletter/%s";

// These three values are optional URLs to which to redirect, instead of displaying the default 
// success messages. Currently, error messages are always displayed in the standard 
// template. Note: URLs must be absolute, e.g. http://mysite.com/subscribe.html, not subscribe.html

// Page to redirect to after confirmation email is sent.
$cfg['returnto_conf'] = '';

// Page to redirect to after successful subscription.
$cfg['returnto_sub'] = '';

// Page to redirect to after unsubscription.
$cfg['returnto_unsub'] = '';

// This is the default template for success and error pages. The two '%s' identifiers are replaced 
// by the title and body of the page, in that order. Use %% to represent literal %.
$cfg['template'] = '
<html><head><title>txtList: %s</title>
<style type="text/css">
body {font-family: Arial; font-size: 10pt;}
.smalltxt A {font-size: 8pt; color: #cdcdcd;position:absolute;top:85%%;left:65%%}
</style></head><body>
<div align="center"> 
%s
<br><br><br><br><a href="JavaScript:window.close()">Close</a></div><br><div align="right" class="smalltxt"><a href="http://txtbox.co.za/p_txtlist.php" target="_new">powered by txtList</a></div></body></html>';

// Additional headers to apply to outgoing emails.
$cfg['headers'][] = 'Mime-Version: 1.0';
$cfg['headers'][] = 'Content-Transfer-Encoding: 8bit';

// The HTML and plaintext headers are applied depending on the mail type. You may need to change 
// the charset attribute if you use a different character set.
$cfg['header_html'] = 'Content-type: text/html; charset="iso-8859-1"';
$cfg['header_plain'] = 'Content-type: text/plain; charset="iso-8859-1"';

// Specifies whether to archive emails sent to the list. This must be on for send resuming to be an 
// option. true = on, false = off.
$cfg['savemail'] = true;

// Specifies the directory to which to save archived emails. Do not include a trailing slash! 
// If you want to indicate the current directory, use '.'
$cfg['savemailto'] = 'archive';

// Specifies whether to save resume data as emails are sent. If disabled, you cannot  
// resume a failed send. This option has no effect unless savemail is on. true = on, false = off.
$cfg['enableresume'] = true;

?>