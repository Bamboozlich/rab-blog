<?php

//TODO: СДЕЛАТЬ ФОРМУ ПО ЦЕНТРУ В РАМКЕ

require "../includes/config.php";

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
            //var_dump($_SESSION);
            echo '<div style="color:green;">Вы успешно авторизованы</div><hr>';
            //echo '<div style="color:blue;"><a href="/">Главная</a></div><hr>';
            echo "
                <script language='JavaScript' type='text/javascript'>
                function GoIndex() {
                    location='../pages/adminp/adminka.php';
                }
                setTimeout('GoIndex()',200);
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

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Вход в панель администратора</title>

    <!-- Bootstrap Grid -->
    <link rel="stylesheet" type="text/css" href="../media/assets/bootstrap-grid-only/css/grid12.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">

    <!-- Custom -->
    <link rel="stylesheet" type="text/css" href="../media/css/style.css">
    <link rel="stylesheet" type="text/css" href="../media/css/adminp.css">

</head>
<body>
<div class="login_form_admin_border">
    <div class="login_form_admin">
        <form action="../pages/adminlogin.php" method="POST">

            <p>
            <p><strong>Ваш логин</strong></p>
            <input type="text" name="login" autocomplete="off" value="<?php echo @$data['login']; ?>">
            </p>

            <br>

            <p>
            <p><strong>Ваш пароль</strong></p>
            <input type="password" name="password" value="<?php echo @$data['password']; ?>">
            </p>

            <br>

            <p>
                <button type="submit" name="do_login" >Авторизироваться</button>
            </p>

        </form>
    </div>
</div>
</body>
</html>


