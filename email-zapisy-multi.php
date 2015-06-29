<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
  <head>
  <meta http-equiv="Content-Language" content="pl" >
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2" >
  <meta name="robots" content="index,follow" >
  <meta name="keywords" content="" >
  <meta name="description" content="" >
  <script type="text/javascript" src="skrypt-zapisy.js"></script>
  <link rel="Stylesheet" type="text/css" href="style.css" >
  <title>Szkoła Tańca SEMPRETANIEC, Krak&oacute;w - Lyrical Dance</title>
  </head>
  <body>
  <div id="center">

 <div id="logo">
 <object
        classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
        codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0"
        id="top"
        width="899" height="241"
      >
        <param name="movie" value="top.swf">
        <param name="bgcolor" value="#FFFFFF">
        <param name="quality" value="high">
        <param name="seamlesstabbing" value="false">
        <param name="allowscriptaccess" value="samedomain">
        <embed
          type="application/x-shockwave-flash"
          pluginspage="http://www.adobe.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash"
          name="top"
          width="899" height="241"
          src="top.swf"
          bgcolor="#FFFFFF"
          quality="high"
          seamlesstabbing="false"
          allowscriptaccess="samedomain"
        >
          <noembed>
          </noembed>
        </embed>
      </object></div>
  
  <div id="menu">
  <div style="text-align:left;margin-top:23px;margin-left:17px;">
  <dl>
     <dd><a href="index.html" class="menus">STRONA GŁ&Oacute;WNA</a></dd>
    <dd><a href="taniec.html" class="menus">TANIEC</a></dd>
    <dd><a href="fitness.html" class="menus">FITNESS</a></dd>
    <dd><a href="onas.html" class="menus">O NAS</a></dd>
    <dd><a href="kadra.html" class="menus">KADRA</a></dd>
    <dd><a href="grafik.html" class="menus">GRAFIK ZAJĘĆ</a></dd>
    <dd><a href="galeria.html" class="menus">GALERIA</a></dd>
    <dd><a href="cennik.html" class="menus">CENNIK</a></dd>
    <dd><a href="partnerzy.html" class="menus">PARTNERZY</a></dd>
    <dd><a href="warsztaty.html" class="menus">WARSZTATY</a></dd>
    <dd><a href="kontakt.html" class="menus">KONTAKT</a></dd>
  </dl>
  </div>
  </div>
  
  <div id="srodek">
  <div style="width:900px;height:auto;overflow:hidden;">
  <div style="float:right;margin-top:40px;margin-right:25px;margin-bottom:40px;"><img src="photo/mapa.jpg" class="photo1" alt=""></div>
  <div style="text-align:justify;margin-left:45px;margin-top:40px;">
   <br><br><br>
<?php
//sprawdzenie czy załącznik pochodzi z formularza 
if ($_POST["wyslij"]==1) 
{ 
// dane o odbiorcy, nadawcy 
$odbiorca="sempretaniec@sempretaniec.pl"; 
$tytul="Zapisy na Zajęcia";
$nadawca = "admin"; 
$nadawca_mail="user"; 
$imie=$_POST["imie"];
$numer=$_POST["numer"];
$email=$_POST["email"];
$wiadomosc=$_POST["wiadomosc"];
$taniec=$_POST["taniec"];
$grupa=$_POST["grupa"];
foreach ($grupa as $wybranagrupa) $wszystkie_grupy_rodzielone_przecinkami = $wszystkie_grupy_rodzielone_przecinkami . $wybranagrupa .", ";
// treść listu

$tresclistu = "<table border=\"0\" width=\"100%\" border=\"0\" cellpadding=\"1\" cellspacing=\"2\" align=center style=\"font-family: Verdana; font-size: 12px;\"> 
<tr> 
<td>Imię i Nazwisko:</td> 
<td><b>".$imie."</b></td> 
</tr> 
<tr> 
<td>Wiek:</td> 
<td><b>".$wiek."</b></td> 
</tr> 
<tr> 
<td>Numer telefonu:</td> 
<td><b>".$numer."</b></td> 
</tr>
<tr>
<td>Adres Email do korespondencji:</td> 
<td><b>".$email."</b></td> 
</tr>
<tr>
<td>Mieszkam w:</td> 
<td><b>".$miejscowosc."</b></td> 
</tr>
<tr>
<td>Kurs</td>
<td><b>".$taniec."</b></td>
</tr>
<tr>
<td>Grupa:</td>
<td><b>".$wszystkie_grupy_rodzielone_przecinkami."</b></td>
</tr>
<tr>
<td>Uwagi:</td>
<td><b>".$wiadomosc."</b></td> 
<tr> 
<td colspan=\"2\"><br>Proszę nie odpowiadać na tę wiadomość jest wygenerowana automatycznie<br></td>  
</tr>
</table>"; 

// definicja nagł&oacute;wk&oacute;w 
  $naglowki  = "From: $nadawca \n"; 
  $naglowki .= "MIME-Version: 1.0\n"; 
  $naglowki .= "Content-Type: multipart/mixed;\n"; 
  $naglowki .= "\tboundary=\"___$znacznik==\""; 

// nagł&oacute;wki listu 
  $tresc="--___$znacznik==\n"; 
  $tresc .="Content-Type: text/html; charset=\"iso-8859-2\"\n"; 
  $tresc .="Content-Transfer-Encoding: 8bit\n"; 
  $tresc .="\n$tresclistu\n"; 

// wysłanie listu 
     if (mail($odbiorca,$tytul,$tresc,$naglowki)) 
   { 
   print "Wiadomość wysłana dziękujemy"; 
   } 
   else 
   { 
   print "wiadomosc nie wyslana, wystapil blad"; 
   } 
}
?>
  
  <br><br>

  </div></div>
  </div>
  <div id="dol">
  <div style="float:right;margin-top:12px;margin-right:20px;">wykonanie: <a href="http://www.projektowanie-www.info.pl" target="_blank" style="color:#fff;">projektowanie stron www</a></div>
  <div style="text-align:left;margin-top:12px;margin-left:20px;">&copy; SempreTaniec.pl Wszelkie prawa zastrzeżone!</div>
  </div>
  </div>
  </body>
  </html>
 