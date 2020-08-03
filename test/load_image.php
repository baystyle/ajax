<?php
date_default_timezone_set("Asia/Bangkok");
$date = date("d_m_Y");
$date2 = (explode("_",$date));
$year_ = ($date2[2]);

$ftp_server = "43.72.52.37";
$ftp_user = "MFD";
$ftp_pass = "Thailand2020";
$ftp_dir="/JJ Catering Menu at Canteen 1/$year_/";
$conn = ftp_connect($ftp_server);
$code = "";
$code = $_GET['code'];

@$img_dir = scandir('../');
$status_img_dir;
for($i=0;$i<count($img_dir);$i++){
    if($img_dir[$i] == 'GA_IMG'){
        $status_img_dir = 1;
    break;
    }else{
        $status_img_dir = 0;
    }
}

if($status_img_dir == 0){
    mkdir("../GA_IMG/img_food/STTB_1", 0777, true);
    mkdir("../GA_IMG/img_food/STTC_1", 0777, true);
    mkdir("../GA_IMG/img_food/STTC_2", 0777, true);
    //echo "create directory image...";
}

if($code == 'STTB_1' || $code == 'STTC_1' || $code == 'STTC_2'){
    $status_cuernt_dir;
    $status_server_dir;
    $current_dir = "../GA_IMG/img_food/$code/Lunch_Menu_$date";
    $defualt_dir = "GA_IMG/img_food/$code/default";

    $check_cuernt_dir = dir("../GA_IMG/img_food/$code");
    
    while(false !== ($entry = $check_cuernt_dir->read())) {
        if($entry != "default" || $entry != "." || $entry != ".."){
            if ("../GA_IMG/img_food/$code/$entry" == $current_dir){
                $status_cuernt_dir = 1;
                break;
            }
            else{ 
                $status_cuernt_dir = 0;
                $status_server_dir = 0;
            }
        }
       
     }

    if($conn){
        ftp_login($conn,$ftp_user,$ftp_pass);
        ftp_chdir($conn,$ftp_dir."/$code");
        $files = ftp_nlist($conn,'.');
        for($i=0;$i<count($files);$i++){
            //if($files[$i] == "Lunch_Menu_$date"){
            if($files[$i] == "Lunch_Menu_16_07_2020"){
                $status_server_dir = 1;
            break;
            }else{
                $status_server_dir = 0;
            }
        }

        if($status_cuernt_dir == 0 && $status_server_dir == 1){
            //$ftp_dir="/JJ Catering Menu at Canteen 1/$year_/$code/Lunch_Menu_$date";
            $ftp_dir="/JJ Catering Menu at Canteen 1/2020/$code/Lunch_Menu_16_07_2020";
            ftp_chdir($conn,$ftp_dir);
            $img_file = ftp_nlist($conn,'.');
            $timing_curent_dir = count($img_file);
            mkdir("../GA_IMG/img_food/$code/Lunch_Menu_".$date, 0777, true);
                for($i=0;$i<count($img_file);$i++){
                    if(strripos($img_file[$i],".JPG") != null || strripos($img_file[$i],".PNG") != null){
                        ftp_get($conn,$img_file[$i],$img_file[$i],FTP_BINARY);
                        rename($img_file[$i],$current_dir.'/'.$img_file[$i]);
                    }
                }
        }
    }

    @$images_files = scandir($current_dir);
    @$default_images_files = scandir($defualt_dir);
    $timing_default_dir = count($default_images_files);

    $data['status_cuernt_dir'] = $status_cuernt_dir;
    $data['status_server_dir'] = $status_server_dir;
    $data['images_files'] = $images_files;
    $data['default_images_files'] = $default_images_files;
    $data['current_dir'] = $current_dir;
    $data['defualt_dir'] = $defualt_dir;
    $data['code'] = $code;
    $data['conn'] = $connect_internet;
    
    if(count($images_files) != 1)
        $data['timing'] = count($images_files)-2;
    else
        $data['timing'] = count($default_images_files)-2;

    echo json_encode($data);
}else{
    echo "non code";
}

if($conn)
    ftp_quit($conn);
?> 