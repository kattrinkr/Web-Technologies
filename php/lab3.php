<?php
$count = 0;

function dirCheck($dir, $file, &$count, $time, $timeto) {
  $dir_resource = opendir($dir);
  while (($file_name = readdir($dir_resource)) !== false) {
    $full_name = $dir.'/'.$file_name;
    if (is_file($full_name)) {
      if (strpos($file_name, $file) !== false) {
        if (date('Y.m.d H:i:s',filectime($full_name)) > date('Y.m.d H:i:s',strtotime($time)) && date('Y.m.d H:i:s',filectime($full_name)) < date('Y.m.d H:i:s',strtotime($timeto)) !== false) {
          echo $file_name.' ';
          echo filesize($full_name).' ('.round(filesize($full_name)/1024,2).' Kb) ';
          echo date('Y.m.d H:i:s',filectime($full_name)).'<br/>';
          $count++;
        }
      } 
    } 
else if (is_dir($full_name) && ($file_name != ".") && ($file_name != "..")) dirCheck($full_name, $file, $count, $time, $timeto);
  }
  closedir($dir_resource);
}

if (!empty ($_POST['DirName']) && !empty ($_POST['CreateTime']) && !empty ($_POST['CreateTimeTo']) && !empty ($_POST['FileName'])) {
  $dir=($_POST['DirName']);
  $time=($_POST['CreateTime']);
  $timeto=($_POST['CreateTimeTo']);
  $file=($_POST['FileName']);

  if (!is_dir($dir)) {
    echo "<script> alert ('Такого каталога не существует.'); </script>";
    echo "<script>window.location='../lab3.html';</script>";
    exit;
  }
  if (!preg_match('/^(0[1-9]|[12][0-9]|3[01])[-\.](0[1-9]|1[012])[-\.](19|20)\d\d/',$time) || !preg_match('/^(0[1-9]|[12][0-9]|3[01])[-\.](0[1-9]|1[012])[-\.](19|20)\d\d/',$timeto)) {
    echo "<script> alert ('Неверный формат даты.'); </script>";
    echo "<script>window.location='../lab3.html';</script>";
    exit;
  } else {
  $dir_resource = opendir($dir);
  if ($dir_resource === NULL) {
    echo "<script> alert ('Не удалось открыть каталог.'); </script>";
    echo "<script>window.location='../lab3.html';</script>";
    exit;
  }

  while (($file_name = readdir($dir_resource)) !== false) {
    $full_name = $dir.'/'.$file_name;
    if (is_file($full_name)) {
      if (strpos($file_name, $file) !== false) {
        if (date('Y.m.d H:i:s',filectime($full_name)) > date('Y.m.d H:i:s',strtotime($time)) && date('Y.m.d H:i:s',filectime($full_name)) < date('Y.m.d H:i:s',strtotime($timeto)) !== false) {
          echo $file_name.' ';
          echo filesize($full_name).' ('.round(filesize($full_name)/1024,2).' Kb) ';
          echo date('Y.m.d H:i:s',filectime($full_name)).'<br/>';
          $count++;
        }
      }
    } else if (is_dir($full_name)) dirCheck($full_name, $file, $count, $time, $timeto);
  }
  closedir($dir_resource);
  if ($count === 0) {
    echo "<script> alert ('Нет файлов в данном каталоге или нет файлов с заданным сочетанием.'); </script>";
    echo "<script>window.location='../lab3.html';</script>";
    exit;   
    }
  }
} else {
    echo "<script> alert ('Не все поля заполнены.'); </script>";
    echo "<script>window.location='../lab3.html';</script>";
    exit;
  }
?>
