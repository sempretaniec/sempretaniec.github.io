<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
  <head>
  <meta http-equiv="Content-Language" content="pl" >
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2" >
  <meta name="robots" content="index,follow" >
  <meta name="keywords" content="" >
  <meta name="description" content="" >
  <script type="text/javascript" src="skrypt.js"></script>
  <link rel="Stylesheet" type="text/css" href="style.css" >
  <title>Szkoła Tańca SEMPRETANIEC, Krak&oacute;w</title>
  </head>
  <body>
  <div id="center">
  <div id="logo"><img src="photo/t1.jpg" class="photo1" alt=""></div>
  <div id="logo2"><img src="photo/t2.jpg" class="photo1" alt=""></div>
  <div id="logo3"><img src="photo/t3.jpg" class="photo1" alt=""></div>
  <div id="menu">
  <div style="text-align:left;margin-top:23px;margin-left:17px;">
  <dl>
    <dd><a href="taniec.html" class="menus">TANIEC</a></dd>
    <dd><a href="fitness.html" class="menus">FITNESS</a></dd>
    <dd><a href="aktu.html" class="menus">AKTUALNOŚCI</a></dd>
    <dd><a href="index.html" class="menus">O NAS</a></dd>
    <dd><a href="kadra.html" class="menus">KADRA INSTRUKTORSKA</a></dd>
    <dd><a href="grafik.html" class="menus">GRAFIK ZAJĘĆ</a></dd>
    <dd><a href="galeria.html" class="menus">GALERIA</a></dd>
    <dd><a href="cennik.html" class="menus">CENNIK</a></dd>
    <dd><a href="firma.html" class="menus">DLA FIRM</a></dd>
    <dd><a href="kontakt.html" class="menus">KONTAKT</a></dd>
  </dl>
  </div>
  </div>
  
  <div id="srodek">
  <div style="width:900px;height:auto;overflow:hidden;">
  <div style="float:right;margin-top:40px;margin-right:25px;margin-bottom:40px;"><img src="photo/mapa.jpg" class="photo1" alt=""></div>
  <div style="text-align:justify;margin-left:45px;margin-top:40px;">

<?php
//sprawdzenie czy załącznik pochodzi z formularza 
if ($_POST["wyslij"]==1) 
{ 
// dane o odbiorcy, nadawcy 
$odbiorca="sempretaniec@sempretaniec.pl"; 
$tytul="Zapisy na Fitness";
$nadawca = "sempretaniec@sempretaniec.pl"; 
$nadawca_mail="user"; 
$imie=$_POST["imie"];
$numer=$_POST["numer"];
$email=$_POST["email"];
$wiadomosc=$_POST["wiadomosc"];
$taniec=$_POST["taniec"];
$grupa=$_POST["grupa"];

// treść listu 
$tresclistu = "<table border=\"0\" width=\"100%\" border=\"0\" cellpadding=\"1\" cellspacing=\"2\" align=center style=\"font-family: Verdana; font-size: 12px;\"> 
<tr> 
<td>Imię i Nazwisko:</td> 
<td><b>".$imie."</b></td> 
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
<td><b>".$grupa."</b></td>
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
 