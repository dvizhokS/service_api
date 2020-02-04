<?php

include "app/rules.php";
include "app/config.php";
include "app/log.php";
include "app/smtp.php";
include "app/telegram.php";

$config_smtp = $config_effects['smtp'];
$config_telegram = $config_effects['telegram'];

if ($_SERVER["REQUEST_METHOD"] != "POST"){
    include "app/page_404.php";
}

$json = file_get_contents('php://input');
$projects = json_decode($json, true)["projects"];

if(is_null($projects)){
    include "app/page_404.php";
}

$proj_on_sending = [];

chek_conditions($operator, $conditions, $projects);

send_all_smtp($proj_on_sending, $rules_type_effects, $config_smtp);
send_all_telegram($proj_on_sending, $rules_type_effects, $config_telegram);

function is_condition($project, $condition){
    switch ($condition["condition"]){
        case "equal":
            return (int)($project[$condition["key"]] == $condition["val"]);
        case "inArray":
            return (int)in_array($condition["val"], $project[$condition["key"]]);
        case "moreThan":
            return (int)($project[$condition["key"]] > $condition["val"]);
        case "lessThan":
            return (int)($project[$condition["key"]] < $condition["val"]);
    }
}

function chek_conditions($operator, $conditions, $projects){
    global $proj_on_sending;
    switch ($operator){
        case "and":
            foreach($projects as $project){
                $is_condition = [];
                foreach($conditions as $condition){
                    array_push($is_condition ,is_condition($project, $condition));
                }
                if(!in_array(0, $is_condition)){
                    array_push($proj_on_sending, $project);
                }
            }
        break;

        case "or":
            foreach($projects as $project){
                $is_condition = [];
                foreach($conditions as $condition){
                    array_push($is_condition ,is_condition($project, $condition));
                }
                if(in_array(1, $is_condition)){
                    array_push($proj_on_sending, $project);
                }
            }
        break;

        default:
            include "app/page_404.php";
    }
}




echo PHP_EOL."Good".PHP_EOL;