<?php

$url = 'http://localhost/server_api.php';

$postfields = file_get_contents('test/example.json');
// $postfields = '';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
// curl_setopt($ch, CURLOPT_POST, true);
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
$out = curl_exec($ch);
curl_close($ch);

// echo $out;