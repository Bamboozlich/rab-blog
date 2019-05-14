<?php

require "../../includes/config.php";

?>

    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Редактирование личной страницы</title>

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

$admin=mysqli_query($connection,"SELECT slogan,image,text FROM admins  WHERE login='$login'");

$adm = mysqli_fetch_assoc($admin);

?>


<?php if(isset($_SESSION['logged_admin'])) : ?>

    <a href="adminka.php">&laquo;Назад</a>
    <h1>Добавление статьи</h1>
    <form class="form form_adminka" method="POST" action="aboutme_change.php">
        <?php

        $data=$_POST;


        if (isset($data['do_post'])) {


            $errors = array();

            if ($data['title'] == '') {
                $errors[] = 'Сообщите ваш девиз!';
            }

            if ($data['image'] == '') {
                $errors[] = 'Укажите название изображения!';
            }

            if ($data['text'] == '') {
                $errors[] = 'Напишите что-нибудь о себе!';
            }



            $filename = '../../static/images/';
            $filename .= $data['image'];

            if (!(file_exists($filename))) {

                $errors[] = 'Указанное изображение не было найдено!';
            }






            if (empty($errors)) {

                $t_title=trim($data['title']);
                $t_image=trim($data['image']);
                $t_text=trim($data['text']);


                mysqli_query($connection, "UPDATE admins SET slogan='$t_title',image='$t_image',text='$t_text' WHERE login='$login'");


                echo '<span style="color: green; font-weight: bold;
                                                            margin-bottom: 10px; display: block;">Информация обновлена</span>';

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
                    <input type="text" autocomplete="off" class="form__control" required name="title"
                           placeholder="Ваш девиз" value="<?php echo $adm['slogan'] ?>">
                </div>
            </div>
        </div>

        <div class="form__group">
            <div class="row">
                <div class="col-md-6">
                    <input type="text" autocomplete="off" class="form__control" required name="image"
                           placeholder="Название изображения c расширением из папки static/images" value="<?php echo $adm['image'] ?>">
                </div>
            </div>
        </div>

        <div class="form__group">
        <textarea name="text" autocomplete="off" required class="form__control area_spec_admin"
                  placeholder="Напишите людям о себе..."><?php echo $adm['text'] ?></textarea>
        </div>
        <div class="form__group">
            <input type="submit" class="form__control" name="do_post" value="Изменить информацию">
        </div>
    </form>



<?php else : ?>
    <a href="../../pages/adminp/adminka.php">Авторизуйтесь</a>
    <br>
<?php endif; ?>