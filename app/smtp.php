<?php

include "vendor/autoload.php";

//function for smtp start
function send_all_smtp($projects, $effects, $config_smtp){
    if(in_array('smtp',$effects['smtp'])){
        foreach($projects as $project){
            $template_on_send = get_template_smtp($project, $effects['smtp'], $config_smtp['templates']);
            if(!smtp_sender($config_smtp, $template_on_send)){
                echo "sorry! some problem with SMTP\n";
                break;
            }
            echo "send on smtp\n";
        }
    }
}

function smtp_sender($config_smtp, $template){
    $result = 0;
    $transport = (new Swift_SmtpTransport($config_smtp['host'],
    $config_smtp['port'], $config_smtp['protocol']))
    ->setUsername($config_smtp['login'])
    ->setPassword($config_smtp['password']);
    $mailer = new Swift_Mailer($transport);
    
    $message = (new Swift_Message($template['subject']))
            ->setFrom([$config_smtp['fromEmail'] => $config_smtp['name']])
            ->setTo([$config_smtp['toEmail']])
            ->setBody($template['message'], 'text/html');

    $date = date("d.m.Y H:i:s");

    try{
        $result = $mailer->send($message);
        $msg = "\tSMTP Ok:"
            ."\n\t"."\"subject\":".$template['subject']
            ."\n\t"."\"message\":".$template['message'];
        sending_log_write($date, $msg);
    }catch(Swift_TransportException $e){
        $msg = "SMTP connection ERROR";
        error_log_write($date, $msg);
    }
    return $result;
}

function get_template_smtp($project, $effect, $templates){
    $ans = [];
    $name = $project['name'];
    $description = $project['description'];
    
    $template_id = $effect['template_id'];
    $template = $templates[$template_id];
    
    //replace placeholder for subject
    $subject = str_replace("%description%", $description, str_replace("%name%", $name, $template['subject']));
    
    //replace placeholder for message;
    $message = str_replace("%description%", $description, str_replace("%name%", $name, $template['message']));
    
    $ans['subject'] = $subject;
    $ans['message'] = $message;

    return $ans;
}
//function for smtp end