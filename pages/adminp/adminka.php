<?php

require "../../includes/config.php";

echo 'Админка';

?>

    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Панель администратора</title>

        <!-- Bootstrap Grid -->
        <link rel="stylesheet" type="text/css" href="../../media/assets/bootstrap-grid-only/css/grid12.css">

        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">

        <!-- Custom -->
        <link rel="stylesheet" type="text/css" href="../../media/css/style.css">
        <link rel="stylesheet" type="text/css" href="../../media/css/adminp.css">

        
    </head>
    <body>



    </body>
    </html>

<?php if(isset($_SESSION['logged_admin'])) : ?>
    <p><strong>Авторизован</strong></p>
    <p><strong>C возвращением, <?php echo $_SESSION['logged_admin']['login']; ?>!</strong></p>
    <h2>Управление аккаунтом</h2>
    <a href="pass_change.php"><h3>Смена пароля</h3></a>
    <a href="aboutme_change.php"><h3>Изменение личной информации</h3></a>
    <hr width="50%" align="left">
    <h2>Управление категориями</h2>
    <a href="catadd.php"><h3>Добавление категорий</h3></a>
    <a href="catdel.php"><h3>Удаление категорий</h3></a>
    <a href="catupdate.php"><h3>Обновление категорий</h3></a>
    <hr width="50%" align="left">
    <h2>Управление статьями</h2>
    <a href="artadd.php"><h3>Добавление статей</h3></a>
    <a href="artdel.php"><h3>Удаление статей</h3></a>
    <a href="artupdate.php"><h3>Обновление статей</h3></a>
    <hr width="50%" align="left">
    <a href="../adminlogout.php">Выйти</a>
<?php else : ?>
    <a href="../../pages/adminlogin.php">Авторизуйтесь</a>
    <br>
<?php endif; ?>



