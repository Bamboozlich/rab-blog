<?php

require "../../includes/config.php";

?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Смена пароля</title>

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

<a href="adminka.php">&laquo;Назад</a>
<h1>Смена пароля</h1>
<form  class="form form_adminka" action="pass_change.php" method="POST">


    <?php

    $data=$_POST;

    if(isset($data['do_pass_change']))
    {




        $errors = array();


        if ($data['password']=='')
        {
            $errors[]='Введите пароль!';
        }

        if ($data['password_2']=='')
        {
            $errors[]='Введите пароль!';
        }

        if ($data['password_2']!=$data['password'])
        {
            $errors[]='Повторный пароль введен не верно!';
        }






        if (empty($errors)) {


            $t_password=trim($data['password']);
            $hash_t_password = password_hash($t_password,PASSWORD_DEFAULT);

            $login=$_SESSION['logged_admin']['login'];

            mysqli_query($connection, "UPDATE admins SET password='$hash_t_password' WHERE login='$login'");


            echo "
                <script language='JavaScript' type='text/javascript'>
                function GoIndex() {
                    location='../../pages/adminp/adminka.php';
                }
                setTimeout('GoIndex()',200);
                </script>
             ";

            echo '<span style="color: green; font-weight: bold;
                                                            margin-bottom: 10px; display: block;">Смена пароля прошла усешно</span>';




        } else {
            echo '<span style="color: red; font-weight: bold;
                                                            margin-bottom: 10px; display: block;">' . $errors['0'] . '</span>';

        }
    }

    ?>








    <div class="form__group">
        <div class="row">
            <div class="col-md-6">
                <input type="password" minlength="6"  class="form__control" required name="password"
                       placeholder="Введите пароль" value="<?php echo $data['password']; ?>">
            </div>
        </div>
    </div>

    <div class="form__group">
        <div class="row">
            <div class="col-md-6">
                <input type="password" minlength="6"  class="form__control" required name="password_2"
                       placeholder="Введите пароль ещё раз" value="<?php echo $data['password_2']; ?>">
            </div>
        </div>
    </div>

    <div class="form__group">
        <input type="submit" class="form__control" name="do_pass_change" value="Сменить пароль">
    </div>

</form>




<?php else : ?>
    <a href="../../pages/adminp/adminka.php">Авторизуйтесь</a>
    <br>
<?php endif; ?>