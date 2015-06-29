<?php
/**
 * Podstawowa konfiguracja WordPressa.
 *
 * Ten plik zawiera konfiguracje: ustawień MySQL-a, prefiksu tabel
 * w bazie danych, tajnych kluczy, używanej lokalizacji WordPressa
 * i ABSPATH. Więćej informacji znajduje się na stronie
 * {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Kodeksu. Ustawienia MySQL-a możesz zdobyć
 * od administratora Twojego serwera.
 *
 * Ten plik jest używany przez skrypt automatycznie tworzący plik
 * wp-config.php podczas instalacji. Nie musisz korzystać z tego
 * skryptu, możesz po prostu skopiować ten plik, nazwać go
 * "wp-config.php" i wprowadzić do niego odpowiednie wartości.
 *
 * @package WordPress
 */

// ** Ustawienia MySQL-a - możesz uzyskać je od administratora Twojego serwera ** //
/** Nazwa bazy danych, której używać ma WordPress */
define('DB_NAME', '04281504_0000001');

/** Nazwa użytkownika bazy danych MySQL */
define('DB_USER', '04281504_0000001');

/** Hasło użytkownika bazy danych MySQL */
define('DB_PASSWORD', '12Stronghold12');

/** Nazwa hosta serwera MySQL */
define('DB_HOST', 'localhost');

/** Kodowanie bazy danych używane do stworzenia tabel w bazie danych. */
define('DB_CHARSET', 'utf8');

/** Typ porównań w bazie danych. Nie zmieniaj tego ustawienia, jeśli masz jakieś wątpliwości. */
define('DB_COLLATE', '');

/**#@+
 * Unikatowe klucze uwierzytelniania i sole.
 *
 * Zmień każdy klucz tak, aby był inną, unikatową frazą!
 * Możesz wygenerować klucze przy pomocy {@link https://api.wordpress.org/secret-key/1.1/salt/ serwisu generującego tajne klucze witryny WordPress.org}
 * Klucze te mogą zostać zmienione w dowolnej chwili, aby uczynić nieważnymi wszelkie istniejące ciasteczka. Uczynienie tego zmusi wszystkich użytkowników do ponownego zalogowania się.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '{.OtJ?S+eQv=gnri;pCpp:VCiy|E,0*X|o$pi,0Bq(<?6aqd`FH,eiXOeZ)%H@.p');
define('SECURE_AUTH_KEY',  'D+Z$U$*Kk#mt| lPw|-~dq$R0A@R/b6/jpeP?JgVMk9?fl0pA5r76yyMk7<yGoHw');
define('LOGGED_IN_KEY',    '|oHQ+R+w6(,aL%u0DC~s9+>zJY0H=[?p+JbNQxg.j5XY_l x KE oo855$Z~$>DE');
define('NONCE_KEY',        'GJ9>^+VrIdc$^b}A1}MI?XhCe-~zDPb4EkZU@%*pa4Rn;Qj}Z#(OR`1Ly/Kh;Dxm');
define('AUTH_SALT',        'D+F?ttTR-Baj=^@4,eFo:Di,SOOg/!V+#eq T!OLUXMyMif4n~nBdyFe^3Vj2= L');
define('SECURE_AUTH_SALT', 'f!VuVv).:<jC4~|+G+EHcT;B2LzfaTZ//x^S-37UnS)8OtDTrB%%+l3TCDi?8:LJ');
define('LOGGED_IN_SALT',   'TF(oj`d|$4/k?*U__])k&[-z LJLyx(Esvtf%?%V) >+^^H`e);aF]#Au+tP.aw-');
define('NONCE_SALT',       '+`I90hyiFdJ(k+rYF35|IcmwOP;ufXW;c&`S,el.C++Vj_e^^GTuc-$X?- +D>tK');

/**#@-*/

/**
 * Prefiks tabel WordPressa w bazie danych.
 *
 * Możesz posiadać kilka instalacji WordPressa w jednej bazie danych,
 * jeżeli nadasz każdej z nich unikalny prefiks.
 * Tylko cyfry, litery i znaki podkreślenia, proszę!
 */
$table_prefix  = 'wp_';

/**
 * Kod lokalizacji WordPressa, domyślnie: angielska.
 *
 * Zmień to ustawienie, aby włączyć tłumaczenie WordPressa.
 * Odpowiedni plik MO z tłumaczeniem na wybrany język musi
 * zostać zainstalowany do katalogu wp-content/languages.
 * Na przykład: zainstaluj plik de_DE.mo do katalogu
 * wp-content/languages i ustaw WPLANG na 'de_DE', aby aktywować
 * obsługę języka niemieckiego.
 */
define('WPLANG', 'pl_PL');

/**
 * Dla programistów: tryb debugowania WordPressa.
 *
 * Zmień wartość tej stałej na true, aby włączyć wyświetlanie ostrzeżeń
 * podczas modyfikowania kodu WordPressa.
 * Wielce zalecane jest, aby twórcy wtyczek oraz motywów używali
 * WP_DEBUG w miejscach pracy nad nimi.
 */
define('WP_DEBUG', false);

/* To wszystko, zakończ edycję w tym miejscu! Miłego blogowania! */

/** Absolutna ścieżka do katalogu WordPressa. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Ustawia zmienne WordPressa i dołączane pliki. */
require_once(ABSPATH . 'wp-settings.php');
