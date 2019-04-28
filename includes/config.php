<?php

$config = array(
    'title' => 'Блог Рабо_тяги',
    'vk_url' => 'https://vk.com/bamboozlich',
    'db' => array(
        'server' => 'localhost:3307',
        'username' => 'root',
        'password' => 'root',
        'name' => 'rab_blog'
    )
);

require 'db.php';

session_start();


?>