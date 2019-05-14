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

<?php

//плохо
$admin=mysqli_query($connection,"SELECT blog_name,vk_url FROM admins  WHERE login='admin'");

$adm = mysqli_fetch_assoc($admin);

$new_title = array(
    'title' => $adm['blog_name'],
    'vk_url' => $adm['vk_url'],
);

$config = array_merge($config, $new_title);

?>

