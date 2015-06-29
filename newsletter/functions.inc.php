<?
define('NL',"\r\n"); // Newline code (record separator)
define('SP',"\t"); // Field separator
define('LNL',strlen(NL)); // Length of newline code
define('LSP',strlen(SP)); // Length of separator code
define('LIN',10); // Length of index
define('LLNE',250); // Max record length (includes msg, nme, id, ip, etc.)

// Opens list file
function openfile($fn) {
  global $fsize, $nextindex, $scount;
  // if file not found, die
  if (!is_file($fn)) die('No file');
  // get filesize
  $fsize = filesize($fn);
  // open file
  $f = @fopen($fn,'r+');
  if ($f === false) die ('File could not be opened. Check permissions');
  // get the two header data
  $nextindex = (int)fgets($f,LIN+LNL+1);
  $scount = (int)fgets($f,LIN+LNL+1);
  return $f;
}

// Changes the item count header
function changecount($f, $nc) {
  $op = ftell($f);
  rewind($f);
  $t = (int)fgets($f,LIN+LNL+1);
  $np = ftell($f);
  $t = (int)fgets($f,LIN+LNL+1);
  fseek($f, $np);
  // This has to be padded because we are editing the top of the file
  fwrite($f, str_pad($t+$nc, LIN, '0', STR_PAD_LEFT));
  fseek($f, $op);
}

// Finds item number $num from beginning. If the number is out of range, 
// the function returns true anyway and the position indicator is left 
// at EOF.
function skiptoitem($f, $num) {
  rewind($f);
  $t = fgets($f,LIN+LNL+1);
  $t = fgets($f,LIN+LNL+1);
  $i = 0;$id = 0;
  while (!feof($f) && $i != $num) {
    $t = fgets($f,LLNE);
    // don't count deleted posts
    if (substr($t,0,1) != '-') $i++;
  }
  return true;
}

// Finds an item by its ID. If it can't be found, false is returned 
// and the marker is moved back to the beginning of the file.
// 0 returns the first record.
function skiptoid($f, $id) {
  skiptoitem($f, 0);
  $i = 0;
  while (!feof($f) && ($i != $id || !is_numeric($i))) {
    $fstart = ftell($f);
    $i = fgets($f,LLNE); // must fetch the whole line
    $i = substr($i, 0, strpos($i, SP)); // only way (ids are not fixed length)
  }
  if ($i == $id) {
    fseek($f, $fstart);
    return true;
  }
  else {
    rewind($f);
    return false;
  }
}

// Reads next address from open list file; returns array
function readitem($f) {
  global $fsize;
  if (ftell($f) >= $fsize) return false;
  do {
    if (feof($f)) return false;
    $titem = fgets($f,LLNE);
  } while (substr($titem,0,1) == '-' || $titem == '');
  // return post
  $titem = explode("\t",$titem);
  $item['id'] = (int)$titem[0];
  $item['addr'] = $titem[1];
  $item['tme'] = (int)$titem[2];
  $item['ip'] = $titem[3];
  $item['filepos'] = ftell($f);
  return $item;
}

// Writes a new item to the file
function writeitem($f, $addr) {
  global $nextindex, $fsize;
  rewind($f);
  // This has to be padded because we are editing the top of the file
  fwrite($f, str_pad($nextindex+1, LIN, '0', STR_PAD_LEFT));
  fseek($f, $fsize);
  $newdata = $nextindex.SP.$addr.SP.time().SP.$_SERVER['REMOTE_ADDR'].NL;
  fwrite($f, $newdata);
  $fsize += strlen($newdata);
  $nextindex++;
  changecount($f, 1);
  return true;
}

// Finds specified ID and marks it deleted
function delitem($f, $id) {
  if (skiptoid($f, $id)) {
    fwrite($f,'-');
    changecount($f, -1);
    skiptoitem($f, 0);
    return true;
  }
  else return false;
}

function closefile($f) {
  fclose($f);
}
?>