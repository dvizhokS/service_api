<?php

//log errors
function error_log_write($date, $msg){
    $file_path = "tmp/error.log";
    $fd = fopen($file_path, 'r+') or die('not open file');
    $new_msg = $date."\n\t".$msg."\n\n".fread($fd, filesize($file_path));
    rewind($fd);
    fwrite($fd, $new_msg);
    fclose($fd);
}

//log sending
function sending_log_write($date, $msg){
    $file_path = "tmp/sending.log";
    $file_size = filesize($file_path);
    $fd = fopen($file_path, 'r+') or die('not open file');
    $new_msg = $date."\n".$msg."\n\n".fread($fd, $file_size);
    rewind($fd);
    fwrite($fd, $new_msg);
    fclose($fd);
}