<?php

require "../../includes/config.php";

?>

    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Измненеие названия блога</title>

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


<?php

$login=$_SESSION['logged_admin']['login'];

$admin=mysqli_query($connection,"SELECT vk_url FROM admins  WHERE login='$login'");

$adm = mysqli_fetch_assoc($admin);

?>


<?php if(isset($_SESSION['logged_admin'])) : ?>

    <a href="adminka.php">&laquo;Назад</a>
    <h1>Удаление категории</h1>
    <form class="form form_adminka" method="POST" action="vk_url_change.php">
        <?php

        $data=$_POST;

        if (isset($data['do_post'])) {


            $errors = array();


            if ($data['vk_url'] == '') {
                $errors[] = 'Укажите новую ссылку ВКонтакте!';
            }






            if (empty($errors)) {


                $t_vk_url=trim($data['vk_url']);


                mysqli_query($connection, "UPDATE admins SET vk_url='$t_vk_url' WHERE login='$login'");




                echo '<span style="color: green; font-weight: bold;
                                                            margin-bottom: 10px; display: block;">Ваша новая ссылка ВКонтакте - "'.$data['vk_url'].'"</span>';

                ?>
                <meta http-equiv="refresh" content="1">
                <?php

            } else {
                echo '<span style="color: red; font-weight: bold;
                                                            margin-bottom: 10px; display: block;">' . $errors['0'] . '</span>';

            }
        }

        ?>


        <div class="form__group">
            <div class="row">
                <div class="col-md-6">
                    <input type="text" autocomplete="off" class="form__control" required name="vk_url"
                           placeholder="Ссылка ВКонтакте" value="<?php echo $adm['vk_url']; ?>">
                </div>
            </div>
        </div>

        <div class="form__group">
            <input type="submit" class="form__control" name="do_post" value="Изменить ссылку">
        </div>
    </form>

<?php else : ?>
    <a href="../../pages/adminp/adminka.php">Авторизуйтесь</a>
    <br>
<?php endif; ?>