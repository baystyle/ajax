<?php
date_default_timezone_set("Asia/Bangkok");
$date = date("d_m_Y");
$ftp_server = "43.72.52.37";
$ftp_user = "MFD";
$ftp_pass = "Thailand2020";
$ftp_dir="/JJ Catering Menu at Canteen 1/$year_/";
$conn = ftp_connect($ftp_server);

function remove_file($dir_file){
    foreach (glob("$dir_file/*.*") as $filename) {
      //echo "$filename <br>";
      unlink($filename);
    }
  }

function remove($dir){
    remove_file($dir);
    rmdir($dir);
}

function remove_dir($date_dir){
  @remove("../GA_IMG/img_food/STTB_1/Lunch_Menu_$date_dir");
  @remove("../GA_IMG/img_food/STTC_1/Lunch_Menu_$date_dir");
  @remove("../GA_IMG/img_food/STTC_2/Lunch_Menu_$date_dir");
  sleep(4);
}
?>

