<?php 

$config['siteName'] = 'Default Name';

$config['age'] = 20;

$config['address'] = [
    'line'  => 'Line 1',
    'city' =>  'Lagos',
    'country' => 'Nigeria'
];


$db['default']['host'] = 'example.com';
$db['default']['username'] = 'root';
$db['default']['password'] = 'root';


return [$config, $db];