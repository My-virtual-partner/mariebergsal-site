<?php 
 $file_name="order_log/".$_GET["order-id"].'_orderfile.txt';
 global $current_user;
 
 $arbetorder_file=$_FILES;
  foreach ($arbetorder_file['files']['name'] as $f => $name) {
      $extension = pathinfo($name, PATHINFO_EXTENSION);
       $wp_upload_dir = wp_upload_dir();
       $path = $wp_upload_dir['path'] . '/';
       $new_filename[] = $name . cvf_td_generate_random_code(3) . '.' . $extension;
  }
  if(!empty($new_filename)){
  $arbets_files=$new_filename;
  }else{
      $arbets_files='';
  }
 if(!empty($json_data)){
     $image_data=$json_data;
 }else{
     $image_data='';
 }
 $data=array('all_post_data'=>$_POST,'image_data'=>$image_data,'arbets_image'=>$arbets_files);
  $new_log_entry = [
        'user' => $current_user->user_email,
        'timestamp' => time(),
        'log_action' => $data
    ];
  $json_log = json_encode($new_log_entry, JSON_PRETTY_PRINT);
//  print_r($json_log);die;
$createfile=fopen("$file_name","a+") or die("there is a problem");
fwrite($createfile,$json_log);
fclose($createfile);


?>