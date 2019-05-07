<?php

require "../../includes/config.php";

?>

    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Удаление статьи</title>

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
    <h1>Удаление статьи</h1>
    <form class="form form_adminka" method="POST" action="artdel.php">
        <?php

        $data=$_POST;


        if (isset($data['do_post'])) {


            $errors = array();


            if ($data['article_id'] == '') {
                $errors[] = 'Укажите категорию статьи!';
            }


            $articles_id_q=mysqli_query($connection, "SELECT id FROM articles");

            $articles_id=array();
            while ($cat = mysqli_fetch_array($articles_id_q))
            {
                $articles_id[]=$cat['id'];
            }

            if (!(in_array($data['article_id'], $articles_id))) {

                $errors[] = 'Указанной статьи не существует!';

            }



            if (empty($errors)) {


                $t_article_id=trim($data['article_id']);

                mysqli_query($connection, "DELETE FROM articles WHERE id='".$t_article_id."'");


                echo '<span style="color: green; font-weight: bold;
                                                            margin-bottom: 10px; display: block;">Статья с ID = "'.$data['article_id'].'" - удалена</span>';


            } else {
                echo '<span style="color: red; font-weight: bold;
                                                            margin-bottom: 10px; display: block;">' . $errors['0'] . '</span>';

            }
        }

        ?>


        <?php


        $articles_exist=true;
        $articles_q=mysqli_query($connection, "SELECT * FROM articles");

        if (mysqli_num_rows($articles_q)<=0)
        {
            $articles_exist=false;
        }

        $articles=array();
        while ($art = mysqli_fetch_assoc($articles_q))
        {
            $articles[]=$art;
        }
        ?>
        <div>
        <?php
        if($articles_exist){
            ?>
            <table border="1" style="margin-bottom: 15px">

                <thead>
                    <th>id<?php echo '&nbsp &nbsp &nbsp'?></th>
                    <th>article</th>
                </thead>




                <?php





                foreach ($articles as $art) {
                    ?>

                    <tbody>
                        <td><?= $art['id'].' '?></td>
                        <td><?= $art['title'] ?></td>
                    </tbody>

                    <?php

                } ?>

            </table>

            <?php
        }
        else{
            echo '<hr><div style="color:red;">Категории отсутствуют!</div><hr>';
        }

        ?>
        </div>

        <div class="form__group">
            <div class="row">
                <div class="col-md-6">
                    <input type="text" autocomplete="off" class="form__control" required name="article_id"
                           placeholder="ID статьи" value="<?php echo $data['article_id']; ?>">
                </div>
            </div>
        </div>

        <div class="form__group">
            <input type="submit" class="form__control" name="do_post" value="Удалить статью">
        </div>
    </form>

<?php else : ?>
    <a href="../../pages/adminp/adminka.php">Авторизуйтесь</a>
    <br>
<?php endif; ?>