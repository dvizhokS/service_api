<?php

// include "log.php";

//function for telegram bot start
function send_all_telegram($projects, $effects, $config_telegram){
    
    if(in_array('telegram',$effects['telegram'])){
        foreach($projects as $project){
            $template_on_send = get_template_telegram($project, $effects['telegram'], $config_telegram['templates']);
            
            if(!telegram_sender($config_telegram, $template_on_send)){
                echo "sorry! some problem with Telegram\n";
                break;
            }
            echo "send on telegram\n";
        }
    }

}

function telegram_sender($config_telegram, $template){
    $result = 0;
    
    $botApiToken = $config_telegram['token'];
    $data = [
        'chat_id' => $config_telegram['chat_id'],
        'text' => $template
    ];
    $query = "https://api.telegram.org/bot{$botApiToken}/sendMessage?".http_build_query($data);
    
    $date = date("d.m.Y H:i:s");
    
    if(file_get_contents($query)){
        $msg = "\ttelegram send is Ok"."\n\t".$template;
        sending_log_write($date, $msg);
        $result = 1;
    }else{
        $msg = "Telegram connection ERROR";
        error_log_write($date, $msg);
        $result = 0;
    }
    return $result;
}

function get_template_telegram($project, $effect, $templates){
    $id = $project['id'];
    $name = $project['name'];
    
    // $placeholders = [$name, $description];
    $template_id = $effect['template_id'];
    $template = $templates[$template_id];
    
    //replace placeholder for message
    $message = str_replace("%id%", $id, str_replace("%name%", $name, $template['message']));
    
    return $message;
}

//function for telegram bot end