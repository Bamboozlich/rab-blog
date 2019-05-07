<?php

require "../../includes/config.php";

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
    <div class="adminka_menu">
    <h2>Управление аккаунтом</h2>
        <ul>
            <li><a href="pass_change.php">Смена пароля</a></li>
            <li><a href="aboutme_change.php">Изменение личной информации</a></li>
        </ul>
    <hr width="50%" align="left">
    <h2>Управление категориями</h2>
        <ul>
            <li><a href="catadd.php">Добавление категорий</a></li>
            <li><a href="catdel.php">Удаление категорий</a></li>
            <li><a href="catupdate.php">Обновление категорий</a></li>
        </ul>
    <hr width="50%" align="left">
    <h2>Управление статьями</h2>
        <ul>
            <li><a href="artadd.php">Добавление статей</a></li>
            <li><a href="artdel.php">Удаление статей</a></li>
            <li><a href="artupdate.php">Обновление статей</a></li>
        </ul>
    <hr width="50%" align="left">
    <h2>Управление комментариями</h2>
    <a href="/">Удаление комментариев</a>
    <p>(Удаление комментариев происходит в режиме администратора</p>
    <p>Перейдите на страницу нужной статьи и удаляйте комментарии нажимая на крестик)</p>
    <hr width="50%" align="left">
    <a href="adminlogout.php">Выйти</a>
    </div>
<?php else : ?>

    <?php

    $data=$_POST;

    if(isset($data['do_login']))
    {
        $user=mysqli_query($connection,"SELECT * FROM admins WHERE login='" . $data['login'] . "'");
        $row_user=mysqli_fetch_array($user);

        if (mysqli_num_rows($user)>0)
        {

            if(password_verify($data['password'],$row_user['password']))
            {
                $_SESSION['logged_admin']=$row_user;
                echo '<div style="color:green;">Вы успешно авторизованы</div><hr>';
                echo "
                <script language='JavaScript' type='text/javascript'>
                function GoIndex() {
                    location='../../pages/adminp/adminka.php';
                }
                setTimeout('GoIndex()',400);
                </script>
             ";
            }
            else
            {
                $errors[]='Пароль введен не верно!';
            }
        }
        else
        {
            $errors[]='Пользователь с таким логином не найден!';
        }

        if (!empty($errors))
        {
            echo '<div style="color:red;">'.array_shift($errors).'</div><hr>';
        }

    }

    ?>

    <div class="center-form">
        <div class="login_form_admin">
            <div class="login_form_admin_border">
                <form action="../../pages/adminp/adminka.php" method="POST">

                    <div>
                        <strong>Ваш логин</strong>
                        <input type="text" name="login" autocomplete="off" value="<?php echo @$data['login']; ?>">
                    </div>

                    <br>

                    <div>
                        <strong>Ваш пароль</strong>
                        <input type="password" name="password" value="<?php echo @$data['password']; ?>">
                    </div>

                    <br>

                    <div class="login_form_admin_button">
                        <button type="submit" name="do_login">Авторизироваться</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
<?php endif; ?>



