<?php

require "../../includes/config.php";

?>

    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Добавление статьи</title>

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
    <h1>Добавление статьи</h1>
    <form class="form form_adminka" method="POST" action="artadd.php">
        <?php

        $data=$_POST;
        $captcha=false;

        if (isset($data['do_post'])) {


            $errors = array();

            if ($data['title'] == '') {
                $errors[] = 'Введите название статьи!';
            }

            if ($data['image'] == '') {
                $errors[] = 'Укажите название изображения!';
            }

            if ($data['text'] == '') {
                $errors[] = 'Введите текст статьи!';
            }

            if ($data['category_id'] == '') {
                $errors[] = 'Укажите категорию статьи!';
            }

            $filename = '../../static/images/';
            $filename .= $data['image'];

            if (!(file_exists($filename))) {

                $errors[] = 'Указанное изображение не было найдено!';
            }


            $categories_id_q=mysqli_query($connection, "SELECT id FROM articles_categories");

            $categories_id=array();
            while ($cat = mysqli_fetch_array($categories_id_q))
            {
                $categories_id[]=$cat['id'];
            }

            if (!(in_array($data['category_id'], $categories_id))) {

                $errors[] = 'Указанная категория не допустима!';

            }



            if (empty($errors)) {

                $t_title=trim($data['title']);
                $t_image=trim($data['image']);
                $t_text=trim($data['text']);
                $t_catergory_id=trim($data['category_id']);

                mysqli_query($connection, "INSERT INTO articles (title,image,text,category_id,pubdate,views) 
                                                                VALUES ('" . $t_title . "','" . $t_image . "','" . $t_text . "','" . $t_catergory_id . "',NOW(),0)");


                echo '<span style="color: green; font-weight: bold;
                                                            margin-bottom: 10px; display: block;">Статья "'.$data['title'].'" добавлена</span>';


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
                           placeholder="Заголовок статьи" value="<?php echo $data['title']; ?>">
                </div>
            </div>
        </div>


        <?php include "../../pages/adminp/cattable.php";?>


        <div class="form__group">
            <div class="row">
                <div class="col-md-6">
                    <input type="text" autocomplete="off" class="form__control" required name="category_id"
                           placeholder="ID категории" value="<?php echo $data['category_id']; ?>">
                </div>
            </div>
        </div>

        <div class="form__group">
            <div class="row">
                <div class="col-md-6">
                    <input type="text" autocomplete="off" class="form__control" required name="image"
                           placeholder="Название изображения c расширением из папки static/images" value="<?php echo $data['image']; ?>">
                </div>
            </div>
        </div>

        <div class="form__group">
        <textarea name="text" autocomplete="off" required class="form__control area_spec_admin"
                  placeholder="Текст статьи..."><?php echo $data['text']; ?></textarea>
        </div>
        <div class="form__group">
            <input type="submit" class="form__control" name="do_post" value="Добавить статью">
        </div>
    </form>

<?php else : ?>
    <a href="../../pages/adminp/adminka.php">Авторизуйтесь</a>
    <br>
<?php endif; ?>