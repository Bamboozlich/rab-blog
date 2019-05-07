<?php

require "../../includes/config.php";

?>

    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Добавление категории</title>

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
    <h1>Добавление категории</h1>
    <form class="form form_adminka" method="POST" action="catadd.php">
        <?php

        $data=$_POST;
        $captcha=false;

        if (isset($data['do_post'])) {


            $errors = array();

            if ($data['category_name'] == '') {
                $errors[] = 'Введите название категории!';
            }




            $categories_names_q=mysqli_query($connection, "SELECT title FROM articles_categories");

            $categories_names=array();
            while ($cat = mysqli_fetch_array($categories_names_q))
            {
                $categories_names[]=$cat['title'];
            }

            if (in_array($data['category_name'], $categories_names)) {

                $errors[] = 'Указанная категория уже существует!';

            }



            if (empty($errors)) {


                $t_catergory_name=trim($data['category_name']);

                if($data['isitmain']=="main")
                {
                    mysqli_query($connection, "INSERT INTO articles_categories (title,is_main) 
                                                                VALUES ('" . $t_catergory_name . "','YES')");
                }
                else
                {
                    mysqli_query($connection, "INSERT INTO articles_categories (title) 
                                                                VALUES ('" . $t_catergory_name . "')");
                }



                echo '<span style="color: green; font-weight: bold;
                                                            margin-bottom: 10px; display: block;">Категория "'.$data['category_name'].'" добавлена</span>'

                ?>
                <meta http-equiv="refresh" content="1">
                <?php


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
                    <input type="text" autocomplete="off" class="form__control" required name="category_name"
                           placeholder="Название категории" value="<?php echo $data['category_name']; ?>">
                </div>
            </div>
        </div>

        <div class="form__group">
            <div class="row">
                <div class="col-md-6">
                    <input type="checkbox" name="isitmain" value="main"/>
                    <label for="ismaindescrpt">Вывести на главную страницу</label>
                </div>
            </div>
        </div>



        <div class="form__group">
            <input type="submit" class="form__control" name="do_post" value="Добавить категорию">
        </div>
    </form>

<?php else : ?>
    <a href="../../pages/adminp/adminka.php">Авторизуйтесь</a>
    <br>
<?php endif; ?>