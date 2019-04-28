<?php

require "../../includes/config.php";

?>

    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Обновление категории</title>

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
        <h1>Обновление категории</h1>

        <?php
        $categories = mysqli_query($connection, "SELECT * FROM articles_categories");

        if (mysqli_num_rows($categories) <= 0) {
            $categories_exist = false;
            echo 'Категории отсутствуют!';

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
                    <a href="../../pages/adminp/catupdate.php?category=<?php echo $cat['id']; ?>"><?php echo $cat['title']; ?></a>
                </td>
                </tbody>

                <?php
            }
            ?>

            </table>

            <?php

        }
    }



   else {

       $this_cat=(int)$_GET['category'];

       $categories_names_q = mysqli_query($connection, "SELECT title FROM articles_categories");
       $categories_names = array();
       while ($cat = mysqli_fetch_array($categories_names_q)) {
           $categories_names[] = $cat['title'];
       }

       $this_category = mysqli_query($connection, "SELECT * FROM articles_categories WHERE id=$this_cat");
       $cat = mysqli_fetch_assoc($this_category);

        ?>

       <a href="catupdate.php">&laquo;Назад</a>
       <h1>Обновление категории "<?php echo $cat['title']; ?>"</h1>
        <form class="form form_adminka" method="POST" action="catupdate.php?category=<?php echo $this_cat; ?>">
            <?php

            $data = $_POST;
            $captcha = false;

            if (isset($data['do_post'])) {


                $errors = array();

                if ($data['category_name'] == '') {
                    $errors[] = 'Введите название категории!';
                }

                if (in_array($data['category_name'], $categories_names)) {

                    $errors[] = 'Указанная категория уже существует!';

                }


                if (empty($errors)) {


                    $t_catergory_name = trim($data['category_name']);

                    if ($data['isitmain'] == "main") {
                        mysqli_query($connection, "UPDATE articles_categories SET title='$t_catergory_name',is_main='YES' 
                                                                WHERE id='$this_cat'");
                    } else {
                        mysqli_query($connection, "UPDATE articles_categories SET title='$t_catergory_name'
                                                                WHERE id='$this_cat'");
                    }


                    echo '<span style="color: green; font-weight: bold;
                                                            margin-bottom: 10px; display: block;">Категория "' . $data['category_name'] . '" обновлена</span>';

                    ?>
                    <meta http-equiv="refresh" content="1">
                    <?php

                } else {
                    echo '<span style="color: red; font-weight: bold;
                                                            margin-bottom: 10px; display: block;">' . $errors['0'] . '</span>';

                }
            }

            ?>


            </div>


            <div class="form__group">
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" autocomplete="off" class="form__control" required name="category_name"
                               placeholder="Название категории" value="<?php echo $cat['title']; ?>">
                    </div>
                </div>
            </div>

            <div class="form__group">
                <div class="row">
                    <div class="col-md-6">
                        <?php

                        if ($cat['is_main'] != 'YES') {

                            ?>
                            <input type="checkbox" name="isitmain" value="main"/>
                            <?php
                        } else {
                            ?>
                            <input type="checkbox" name="isitmain" value="main" checked/>
                            <?php
                        }
                        ?>
                        <label for="ismaindescrpt">Вывести на главную страницу</label>
                    </div>
                </div>
            </div>


            <div class="form__group">
                <input type="submit" class="form__control" name="do_post" value="Обновить категорию">
            </div>
        </form>

        <?php
    }
    ?>

<?php else : ?>
    <a href="../../pages/adminlogin.php">Авторизуйтесь</a>
    <br>
<?php endif; ?>