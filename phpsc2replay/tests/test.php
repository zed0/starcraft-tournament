<?php

include_once '../sc2replay.php';
include_once '../mpqfile.php';
//include_once 'diff.php';

function diff($a, $b) {
  $i = 0;
  while ($i < strlen($a) && $i < strlen($b)) {
    if ($a[$i] != $b[$i])
      return $i;
    ++$i;
  }
  if ($i == strlen($a) && $i == strlen($b))
    $i = -1;

  return $i;
}

function test_file($file) {
  echo "Testing $file \n";
  $mpq = new MPQFile($file);
  $rep = $mpq->parseReplay();
  if (!$rep) {
    echo "Parse error!";
    return;
  }
  $new = $rep->jsonify();
  if (file_exists($file.'.parsed')) {
    $old = file_get_contents($file.'.parsed');
    $diff = diff($old, $new);
    if ($diff != -1) {
      echo $file . ': position ' . $diff . ' old: >>' . substr($old, $diff - 5, 10) . '<< new: >>' . substr($new, $diff - 5, 10) . "<< ";
      file_put_contents($file . '.new.parsed', $new);
      echo "New content saved as " .$file. ".new.parsed\n";
      //printDiff($old, $new);
    }
  } else {
    file_put_contents($file.'.parsed', $new);
    echo "Content saved as $file.parsed\n";
  }
}

function test_dir($dir) {
  $fs_objs = scandir($dir);
  foreach ($fs_objs as $fs_obj) {
    if ($fs_obj != '.' && $fs_obj != '..' && substr_compare($fs_obj, '.parsed', -7, 7, true) != 0) {
      if (filetype($dir.'/'.$fs_obj) == "dir")
        test_dir($dir.'/'.$fs_obj);
      else
        test_file($dir.'/'.$fs_obj);
    }
  }
}

$fs_objs = scandir('.');
foreach ($fs_objs as $fs_obj) {
  if ($fs_obj != '.' && $fs_obj != '..' && filetype($fs_obj) == "dir") {
    test_dir($fs_obj);
  }
}
