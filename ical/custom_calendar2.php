<?php
/**
CHANGELOG:

Edit by Damian // 16-09-1014
Przywrócenie skryptu js od Google + mała zmiana w css

**/

//$your_google_calendar="https://www.google.com/calendar/embed?src=usa__en@holiday.calendar.google.com&gsessionid=OK";
/*
$your_google_calendar="https://www.google.com/calendar/embed?src=pki27nglipcm11crmei6t1nh5c%40group.calendar.google.com&ctz=Europe/Warsaw&gsessionid=OK";
$your_google_calendar="https://www.google.com/calendar/embed?"
."showTitle=0&showNav=0&showTabs=0&showCalendars=0&showTz=0&mode=WEEK&wkst=2&ctz=Europe/Warsaw&gsessionid=OK"
."&src=odc2lc1jagou97t36j4k8eaabo@group.calendar.google.com"
."&src=rorgf24jk2fg3bu1u209b60h88@group.calendar.google.com"
."&color=%23A32929";
*/
$src='https://www.google.com/calendar/embed?'
.'showTitle=0&showNav=0&showTabs=0&showCalendars=0&showTz=0&mode=WEEK&wkst=2&bgcolor=%23FFFFFF&showPrint=0&'
.'src=bq1lelqa523bsino05r9p3njkg%40group.calendar.google.com&color=%230D7813&'
.'src=q6rg7mgh7t6ro73hutbqire2lk%40group.calendar.google.com&color=%23BE6D00&'
.'ctz=Europe%2FWarsaw';

$your_google_calendar = $src;

$url= parse_url($your_google_calendar);
$google_domain = $url['scheme'].'://'.$url['host'].dirname($url['path']).'/';
// Load and parse Google's raw calendar
$dom = new DOMDocument();
$dom->loadHTMLfile($your_google_calendar);

$footer = $dom->getElementById('footer1');
if($footer != null)
    $dom = $dom->removeChild($footer);

$body = $dom->getElementsByTagName('body')->item(0);
$body->setAttribute('style', "");

// Change Google's CSS file to use absolute URLs (assumes there's only one element)
$css = $dom->getElementsByTagName('link')->item(0);
$css_href = $css->getAttribute('href');
$css->setAttribute('href', $google_domain . $css_href);
$css->setAttribute('href', "./custom_calendar.acid.css");

/*
// Change Google's JS file to use absolute URLs
$scripts = $dom->getElementsByTagName('script');

foreach ($scripts as $script) {
$js_src = $script->getAttribute('src');
//echo "DEBUG : " . $js_src . "\n";
//if ($js_src) $script->setAttribute('src', $google_domain . $js_src);
if ($js_src) $script->setAttribute('src', "./custom_calendar.acid.js");
}

// Create a link to a new CSS file called custom_calendar.css
$element = $dom->createElement('link');
$element->setAttribute('type', 'text/css');
$element->setAttribute('rel', 'stylesheet');
$element->setAttribute('href', './custom_calendar.acid.css');

// Append this link at the end of the element
$head = $dom->getElementsByTagName('head')->item(0);
$head->appendChild($element);
/***/

// Export the HTML
$str = $dom->saveHTML();
//$str = str_replace("&lt;", "<", $str);
//$str = str_replace("&gt;", ">", $str);
//$str = str_replace("&#39;", "'", $str);

$str = str_replace("[br]", "<br/>", $str);
$str = str_replace("[small]", "<small>", $str);
$str = str_replace("[/small]", "</small>", $str);

echo $str;
/**/
?>