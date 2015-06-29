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
</head>
<body>
<div style="font-size: 14pt;">txtList help</div>
<p>
<?
switch ($_GET['pg']) {
  default:
?>
<b>Admin Login</b><br>
Once logged-in, you have access to the various pages of the admin. To go to one of them, simply 
click its link at the top of the page.
<?
    break;
  case 'email':
?>
<b>Send Email</b><br>
This page allows you to send emails to your subscribers. The follow points cover the various 
options:
<ul>
<li>From / Subject / Body
  <ul>Fill these in as you would with any email. The from field can take an address of the form 
      My Name <me@mydomain.com>, which will appear as My Name to many mail clients.</ul>
<li>Send email on completion
  <ul>Tick this box to make the script email a report when it has finished sending emails. This is 
      useful if you have many subscribers and want to be able to leave the admin before it is 
      finished sending, but want confirmation that sending was successful.</ul>
<li>CC to self
  <ul>Tick this box to have the script send a copy of the email to your email address (specified in 
      config.inc.php). This option has no effect if you're doing the 'test send'.</ul>
<li>Send as HTML
  <ul>Tick this box to send the mail as HTML. It simply defines the content as HTML with MIME, and doesn't 
      make it multipart or anything. With this option enabled, many email clients will parse any HTML tags 
      found in the body.</ul>
<li>Test Send
  <ul>Click this button to send the email only to your address (specified in config.inc.php). It 
      will be sent exactly as it would for everyone else, so you can get an idea of how it is 
      formatted.</ul>
<li>Send
  <ul>Click this button to send the email to everyone on your list. Do not click it more than once! 
      You will receive a status message at the top of the page when the operation is completed. 
      You can close the browser while sending is in progress, if it is likely to take a while.</ul>
</ul>
<?
    break;
  case 'archive':
?>
<b>Email Archive</b><br>
This page lists emails you have sent out in the past, providing email archiving is enabled in 
config.inc.php. 
<p>
You can read your archived emails, and resume them if they have failed. 
<?
    break;
  case 'newsub':
?>
<b>Add Subscribers</b><br>
You can add or import subscribers to your list using this tool. 
<p>
You can import addresses that you type or paste into the big textbox, or from a file that you select 
and upload.
<p>
Two types of importing are supported:
<ul>
  <li>CSV format
    <ul>If your existing subscriber list is a plaintext file with each address separated by 
        a specific character or characters, then it's probably in CSV format. You can export lists 
        from Excel and other spreadsheet and database programs in this format. 
        <p>
        To import addresses from CSV text, enter the separator characters in the 
        'Use separator' field. The default is a new-line (\r\n), but yours might be a comma, or semicolon, or tab (\t), etc.
        <p>
    </ul>
  </li>
  <li>Smart parsing
    <ul>If you have a list of email addresses in no particular format, or embedded along with other data, 
        then you should use smart parsing to extract them. An example of a file of embedded addresses 
        is the txtList list file itself - each address appears on its own line, but along with other 
        data.
        <p>
        To extract addresses from text, paste the text or select the file containing it and choose 
        the 'Use smart parsing' option. 
        <p>
        Most of the time, smart parsing will find all the valid addresses present in the text. You 
        should check, however, that it has included all the ones you expected it to. 
    </ul>
  </li>
</ul>
<p>
You can choose whether to list added and / or failed addresses. It is useful to 
tick both if you are using smart parsing, and just failed, or neither, if you are importing from 
a large CSV file that you know works.
   
<?
    break;
  case 'list':
?>
<b>Subscriber List</b><br>
This page lists your current subscribers. It only lists people who confirmed their subscription 
and have not unsubscribed. 
<p>
The IP addresses shown are those from which each person subscribed. They may be useful for 
determining whether a batch of addresses was subscribed by the same person. 
Addresses you import should have the IP 127.0.0.1.
<p>
You can delete subscribers by ticking the checkbox next to each record you want to delete, then 
clicking 'Delete selected'. 
<p>
You can also download the list file itself, for backup purposes. It's a good idea to do this often, 
in case the file is deleted or becomes corrupt.
<?
    break;
}
?>
