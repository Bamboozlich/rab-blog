<?php

require "../../includes/config.php";

?>

    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Удаление категории</title>

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
    <h1>Удаление категории</h1>
    <form class="form form_adminka" method="POST" action="catdel.php">
        <?php

        $data=$_POST;

        if (isset($data['do_post'])) {


            $errors = array();


            if ($data['category_id'] == '') {
                $errors[] = 'Укажите категорию статьи!';
            }


            $categories_id_q=mysqli_query($connection, "SELECT id FROM articles_categories");

            $categories_id=array();
            while ($cat = mysqli_fetch_array($categories_id_q))
            {
                $categories_id[]=$cat['id'];
            }

            if (!(in_array($data['category_id'], $categories_id))) {

                $errors[] = 'Указанная категория не существует!';

            }



            if (empty($errors)) {


                $t_catergory_id=trim($data['category_id']);


                mysqli_query($connection, "DELETE FROM articles WHERE category_id='".$t_catergory_id."'");

                mysqli_query($connection, "DELETE FROM articles_categories WHERE id='".$t_catergory_id."'");


                echo '<span style="color: green; font-weight: bold;
                                                            margin-bottom: 10px; display: block;">Категория c ID = "'.$data['category_id'].'" - удалена</span>';


            } else {
                echo '<span style="color: red; font-weight: bold;
                                                            margin-bottom: 10px; display: block;">' . $errors['0'] . '</span>';

            }
        }

        ?>


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
            <input type="submit" class="form__control" name="do_post" value="Удалить категорию">
        </div>
    </form>

<?php else : ?>
    <a href="../../pages/adminp/adminka.php">Авторизуйтесь</a>
    <br>
<?php endif; ?>