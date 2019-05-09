<?php

require "../includes/config.php";
require_once "../static/libs/recaptchalib.php";

?>

<?php

require "../includes/head.php";
include '../static/scripts/main.php';

?>

<body>

<div id="wrapper">

    <?php include "../includes/header.php";?>

    <?php


        $article=mysqli_query($connection,"SELECT * FROM articles WHERE id=" . (int)$_GET['id']);


        if (mysqli_num_rows($article)<=0)
        {
            ?>

            <div id="content">
                <div class="container">
                    <div class="row">
                        <section class="content__left col-md-8">
                            <div class="block">
                                <h3>Статья не найдена</h3>
                                <div class="block__content">
                                    <img class="image_large" src="../static/images/default.jpg">
                                    <div class="full-text text_simple_article">
                                        Запрашиваемая статья не найдена
                                    </div>
                                </div>
                            </div>

                        </section>
                        <section class="content__right col-md-4">
                            <?php include "../includes/sidebar.php";?>
                        </section>
                    </div>
                </div>
            </div>

            <?php

        }
        else
        {
            $art = mysqli_fetch_assoc($article);
            mysqli_query($connection, "UPDATE articles SET views = views + 1 WHERE id = " . (int) $art['id']);
            ?>

            <div id="content">
                <div class="container">
                    <div class="row">
                        <section class="content__left col-md-8">
                            <div class="block">
                                <a><?php echo $art['views'];?> просмотров</a>
                                <h3><?php echo $art['title'];?></h3>
                                <div class="block__content">
                                    <img class="image_large" src="../static/images/<?php echo $art['image'] ?>">
                                    <div class="full-text text_simple_article">
                                        <?php echo $art['text'];?>
                                    </div>
                                    <div id="pubdate" class="pub_date pubdate_opacity">
                                        <?php echo 'Публикация от ' . $art['pubdate'] . ''; ?>
                                    </div>

                                </div>
                            </div>


                            <div id="response">
                            <?php

                            $data=$_POST;

                            //var_dump($data);

                            if (isset($data['do_post'])) {


                                $errors = array();

                                if ($data['name'] == '') {
                                    $errors[] = 'Введите имя!';
                                }

                                if ($data['nickname'] == '') {
                                    $errors[] = 'Введите ваш никнейм!';
                                }

                                if ($data['email'] == '') {
                                    $errors[] = 'Введите Email!';
                                }

                                if ($data['text'] == '') {
                                    $errors[] = 'Введите текст комментария!';
                                }


                                if (empty($errors)) {

                                    $secret = "6LeikpkUAAAAALGvEMNr6An65AadcfiqCk5mG7um";

                                    // пустой ответ
                                    $response = null;

                                    // проверка секретного ключа
                                    $reCaptcha = new ReCaptcha($secret);

                                    // if submitted check response
                                    if ($data["g-recaptcha-response"]) {
                                        $response = $reCaptcha->verifyResponse(
                                            $_SERVER["REMOTE_ADDR"],
                                            $data["g-recaptcha-response"]);
                                    }

                                    if ($response != null && $response->success) {
                                        $captcha = true;
                                    }

                                    if ($captcha == true) {

                                        $t_name=trim($_POST['name']);
                                        $t_nickname=trim($_POST['nickname']);
                                        $t_email=trim($_POST['email']);
                                        $t_text=trim($_POST['text']);
                                        mysqli_query($connection,"INSERT INTO comments (author,nickname,email,text,pubdate,articles_id) 
                                                                VALUES ('".$t_name."','".$t_nickname."','".$t_email."','".$t_text."',NOW(),'".$art['id']."')");




                                        echo '<span style="color: green; font-weight: bold;
                                                            margin-bottom: 10px; display: block;">Комментарий добавлен</span>';

                                        ?>

                                        <?php



                                    } else {
                                        echo '<span style="color: red; font-weight: bold;
                                                            margin-bottom: 10px; display: block;">Капча не пройдена</span>';

                                    }


                                } else {
                                    echo '<span style="color: red; font-weight: bold;
                                                            margin-bottom: 10px; display: block;">' . $errors['0'] . '</span>';

                                }
                            }
                            ?>
                            </div>



                            <div class="block" id="comments">
                                <a href="#comment-add-form">Добавить свой</a>
                                <h3>Комментарии</h3>
                                <div class="block__content">
                                    <div class="articles articles__vertical">

                                        <?php
                                        $comments = mysqli_query($connection, "SELECT * FROM comments WHERE articles_id=
                                                                                      " . (int) $art['id'] ." ORDER BY id DESC");

                                        if (mysqli_num_rows($comments)<=0)
                                        {
                                            echo "Нет комментариев!";
                                        }

                                        ?>



                                        <?php

                                        while ($comment = mysqli_fetch_assoc($comments)) {
                                            ?>
                                            <article class="article">
                                                <div class="article__image"
                                                     style="background-image: url(https://www.gravatar.com/avatar/<?php echo md5($comment['email']); ?>s=125)"></div>
                                                <div class="article__info">
                                                    <a href="/pages/article.php?id=<?php echo $comment['articles_id']; ?>"><?php echo $comment['nickname']; ?></a>
                                                    <?php if(isset($_SESSION['logged_admin'])) : ?>
                                                        <div class="comment_time_ago_logadmin">
                                                            <?php echo 'опубликовано ' . showDate(strtotime($comment['pubdate'])) . ''; ?>
                                                        </div>
                                                        <div class="comment_delete">
                                                            <?php
                                                            $id_comment=$comment['id'];
                                                            if (isset($data['delete_comment_'.$id_comment.''])) {
                                                                deleteComment($connection, $id_comment);
                                                                ?>
                                                                <meta http-equiv="refresh"
                                                                      content="0; URL=../pages/article.php?id=<?php echo $art['id'];?>">
                                                                <?php
                                                            }
                                                            ?>
                                                            <form id="delCom" action="../pages/article.php?id=<?php echo $art['id'];?>#pubdate" method="POST">
                                                                <button type="submit" name="delete_comment_<?php echo $comment['id']?>"></button>
                                                            </form>
                                                        </div>
                                                    <?php else : ?>
                                                        <div class="comment_time_ago">
                                                            <?php echo 'опубликовано ' . showDate(strtotime($comment['pubdate'])) . ''; ?>
                                                        </div>
                                                    <?php endif; ?>
                                                    <div class="article__info__meta">

                                                    </div>
                                                    <div class="article__info__preview">
                                                        <?php echo strip_tags($comment['text']); ?>
                                                    </div>
                                                </div>
                                            </article>
                                            <?php
                                        }
                                        ?>

                                    </div>
                                </div>
                            </div>


                            <div class="block" id="comment-add-form">
                                <h3>Добавить комментарий</h3>
                                <div class="block__content">
                                    <form id="new_comment_form" class="form" method="POST" action="../pages/article.php?id=<?php echo $art['id'];?>#pubdate">

                                        <div id="op_result"> </div>



                                        <div class="form__group">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <input type="text" minlength="4" maxlength="25"  autocomplete="off" class="form__control" required name="name" placeholder="Имя" value="<?php echo $data['name'];?>">
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" minlength="4" maxlength="25" autocomplete="off" class="form__control" required name="nickname" placeholder="Никнейм" value="<?php echo $data['nickname'];?>">
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="email" autocomplete="off" class="form__control" required name="email" placeholder="Почта" value="<?php echo $data['email'];?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form__group">
                                            <textarea minlength="10"  class="form__control area_comment_spec" name="text" autocomplete="off" required placeholder="Текст комментария ..."><?php echo $data['text'];?></textarea>
                                        </div>
                                        <div class="g-recaptcha captcha_spec" data-sitekey="6LeikpkUAAAAAHtvE-ecvAEF_ZEYDQwS8EWmXgcP"  data-theme="dark"></div>
                                        <div class="form__group">
                                            <input type="submit" class="form__control" name="do_post" value="Добавить комментарий">
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </section>
                        <section class="content__right col-md-4">
                            <?php include "../includes/sidebar.php";?>
                        </section>
                    </div>
                </div>
            </div>

            <?php
        }

    ?>



    <?php include "../includes/footer.php";?>

</div>

</body>
</html>