               +----------------+
               |  txtList v1.5  |  [txtbox.co.za]
               +----------------+

txtList is a no-frills mailing list system that is 
quick and easy to put on your site and just as easy 
to work with. It stores its address list in a text 
file, so no database is required. 

In this file:
 + Installation
 + Usage
 + Changelog
 + Todo


[+][ INSTALLATION ]

 * Extract all the files to their own folder.
 * Open config.inc.php, and choose a username and 
   password. Also make sure you enter the various 
   email addresses correctly, as well as the 
   confirmation URL.
 * Look at example.html for the HTML you need to 
   create your subscribe / unsubscribe form.
 * When you copy-paste the subscribe form to 
   your site's pages, make sure you change the 
   action="./index.php" attribute so it points to your txtList 
   folder (e.g. action="txtlist/index.php")
 * Upload the files to your site, and CHMOD list.txt 
   to 777, so the script can write to it.
 * CHMOD the archive directory to 777.
 * Test subscribe / unsubscribe with your own email 
   address, and test mailing.


[+][ USAGE ]

Visitors can use your subscribe / unsubscribe form to 
add themselves to your list. First they are sent a 
confirmation email with an activation URL they have to 
visit before they are subscribed. They will then receive 
any emails you send to the list until they unsubscribe.

To get to the admin, just visit /txtlist/admin.php. Enter 
the username and password you set in config.inc.php to log in. 

The 'send email' page allows you to send emails to your list. 
Read the help on that page for more information.


[+][ CHANGELOG ]

 * v1.5 [04-06-20]
   - Added email archiving ability.
   - Added failed send resume feature!
   - Improved subscriber list page.
   - Added basic template support for subscription pages.

 * v1.1 r1 [04-05-24]
   - Fixed the mail format checking (thanks Justin!)

 * v1.1 [04-05-17]
   - Fixed the 'headers already sent' problem on unsubscribe.
   - Added a couple of mail headers to improve compatibility.

 * v1.0 [04-05-09]
   - First release.