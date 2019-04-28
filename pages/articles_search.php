<?php

require "../includes/config.php";

?>

<?php

require "../includes/head.php";

?>

<body>

<div id="wrapper">

    <?php include "../includes/header.php";?>

    <div id="content">
        <div class="container">
            <div class="row">
                <section class="content__left col-md-8">
                    <div class="block">
                        <h3>Результат поиска:</h3>
                        <div class="block__content">
                            <div class="articles articles__horizontal">

                                <?php
                                $post_query=$_POST['query'];
                                if (!empty($post_query)) {

                                    $query = trim($post_query);



                                    $articles=mysqli_query($connection, "SELECT * FROM articles WHERE title LIKE '%$query%'
                                          OR text LIKE '%$query%' ORDER BY id DESC");

                                    var_dump($articles);

                                    if (mysqli_num_rows($articles)<=0)
                                    {
                                        echo 'Нет статей из выбранной категории';
                                    }


                                    while ($art = mysqli_fetch_assoc($articles)) {
                                        ?>
                                        <article class="article">
                                            <div class="article__image"
                                                 style="background-image: url(../static/images/<?php echo $art['image']; ?>);"></div>
                                            <div class="article__info">
                                                <a href="../pages/article.php?id=<?php echo $art['id']; ?>"><?php echo $art['title'];?></a>
                                                <div class="article__info__meta">
                                                    <?php
                                                    $art_cat=false;
                                                    foreach ($categories as $cat)
                                                    {
                                                        if ($cat['id'] == $art['category_id'])
                                                        {
                                                            $art_cat=$cat;
                                                            break;
                                                        }
                                                    }
                                                    ?>
                                                    <small>Категория: <a
                                                                href="../pages/articles.php?category=<?php echo $art_cat['id'];?>"><?php echo $art_cat['title'];?></a></small>
                                                </div>
                                                <div class="article__info__preview">
                                                    <?php echo mb_substr(strip_tags($art['text']),0,100,'UTF-8').'...' ;  ?>
                                                </div>
                                            </div>
                                        </article>

                                        <?php
                                    }



                                }
                                ?>

                            </div>


                </section>
                <section class="content__right col-md-4">
                    <?php include "../includes/sidebar.php"; ?>
                </section>
            </div>
        </div>
    </div>

    <?php include "../includes/footer.php";?>

</div>

</body>
</html>