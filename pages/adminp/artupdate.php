<?php

require "../../includes/config.php";

?>

    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Обновление статьи</title>

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

     <?php



    if (!isset($_GET['category'])) {

        ?>

        <a href="adminka.php">&laquo;Назад</a>
        <h1>Обновление статьи</h1>

        <?php

        $articles = mysqli_query($connection, "SELECT * FROM articles");
        $categories = mysqli_query($connection, "SELECT * FROM articles_categories");


        if (mysqli_num_rows($articles) <= 0) {
            $articles_exist = false;
            echo 'Статьи отсутствуют!';

        } else {

            ?>
            <table border="1" style="margin: 10px">

            <thead>
            <th>id<?php echo '&nbsp &nbsp &nbsp' ?></th>
            <th>title</th>
            </thead>
            <?php

            while ($cat = mysqli_fetch_assoc($categories)) {

                ?>

                <tbody>
                <td><?= $cat['id'] ?></td>
                <td>
                    <a href="../../pages/adminp/artupdate.php?category=<?php echo $cat['id']; ?>"><?php echo $cat['title']; ?></a>
                </td>
                </tbody>

                <?php
            }
            ?>

            </table>

            <?php

        }
    }
    else if (!isset($_GET['article']))
    {
        ?>
        <a href="artupdate.php">&laquo;Назад</a>
        <h1>Обновление статьи</h1>
        <table border="1" style="margin: 10px">

            <thead>
            <th>id<?php echo '&nbsp &nbsp &nbsp' ?></th>
            <th>title</th>
            </thead>
            <?php
            $category=(int)$_GET['category'];
            $this_articles = mysqli_query($connection, "SELECT * FROM articles WHERE category_id=$category");
            while ($art = mysqli_fetch_assoc($this_articles)) {

                ?>

                <tbody>
                <td><?= $art['id'] ?></td>
                <td>
                    <a href="../../pages/adminp/artupdate.php?category=<?php echo $art['category_id']; ?>&article=<?php echo $art['id']; ?>"><?php echo $art['title']; ?></a>
                </td>
                </tbody>

                <?php
            }
            ?>

        </table>
        <?php

    }
    else
    {
        $this_cat=(int)$_GET['category'];
        $this_art=(int)$_GET['article'];

        $this_article=mysqli_query($connection, "SELECT * FROM articles WHERE id=$this_art");
        $art = mysqli_fetch_assoc($this_article);

        ?>
        <a href="artupdate.php?category=<?php echo $this_cat; ?>">&laquo;Назад</a>
        <h1>Обновление статьи "<?php echo $art['title']; ?>"</h1>

        <form class="form form_adminka" method="POST" action="artupdate.php?category=<?php echo $this_cat; ?>&article=<?php echo $this_art; ?>">
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

                    $art_pubdate=$art['pubdate'];
                    $art_views=$art['views'];

                    mysqli_query($connection, "UPDATE articles SET title='$t_title',image='$t_image',text='$t_text',category_id='$t_catergory_id',pubdate='$art_pubdate',views='$art_views'
                                                                WHERE id='$this_art'");


                    echo '<span style="color: green; font-weight: bold;
                                                            margin-bottom: 10px; display: block;">Статья "'.$data['title'].'" обновлена</span>';

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
                               placeholder="Заголовок статьи" value="<?php echo $art['title']; ?>">
                    </div>
                </div>
            </div>

            <?php include "../../pages/adminp/cattable.php";?>

            <div class="form__group">
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" autocomplete="off" class="form__control" required name="category_id"
                               placeholder="ID категории" value="<?php echo $art['category_id']; ?>">
                    </div>
                </div>
            </div>

            <div class="form__group">
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" autocomplete="off" class="form__control" required name="image"
                               placeholder="Название изображения c расширением из папки static/images" value="<?php echo $art['image']; ?>">
                    </div>
                </div>
            </div>

            <div class="form__group">
        <textarea  name="text" autocomplete="off" required class="form__control area_spec_admin"
                  placeholder="Текст статьи..."><?php echo $art['text']; ?></textarea>
            </div>
            <div class="form__group">
                <input type="submit" class="form__control" name="do_post" value="Обновить статью">
            </div>
        </form>

        <?php
    }

    ?>






<?php else : ?>
    <a href="../../pages/adminp/adminka.php">Авторизуйтесь</a>
    <br>
<?php endif; ?>