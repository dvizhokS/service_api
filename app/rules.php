<?php

$rules = json_decode(file_get_contents('app/rules.json'),true)['rules'][0];

$operator = $rules["operator"];
$conditions = $rules["conditions"];
$rules_effects = $rules["effects"];

$rules_type_effects = [];
foreach($rules_effects as $effect){
    $rules_type_effects[$effect['type']] = $effect;
}
