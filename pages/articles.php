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
                        <h3>Все статьи</h3>
                        <div class="block__content">
                            <div class="articles articles__horizontal">

                                <?php

                                $page=1;
                                $per_page=4;

                                if (isset($_GET['page']))
                                {
                                    $page=(int)$_GET['page'];
                                }


                                if (isset($_GET['category']))
                                {
                                    $cat_exist=true;
                                    $category=(int)$_GET['category'];

                                    $total_count_q=mysqli_query($connection, "SELECT COUNT(id) as total_count FROM articles WHERE category_id=$category");
                                    $total_count=mysqli_fetch_assoc($total_count_q);
                                    $total_count=$total_count['total_count'];

                                    $total_pages=ceil($total_count/$per_page);
                                    if ($page<=1 || $page>$total_pages)
                                    {
                                        $page=1;
                                    }

                                    $offset = ($per_page * $page) - $per_page;
                                    //1  (4*1)-4 = 0
                                    //2  (4*2)-4 = 4
                                    //3  (4*3)-4 = 8


                                    $articles=mysqli_query($connection, "SELECT * FROM articles WHERE category_id=$category ORDER BY id DESC LIMIT $offset , $per_page");

                                    $articles_exist=true;

                                    if (mysqli_num_rows($articles)<=0)
                                    {
                                        $articles_exist=false;
                                        ?>

                                        <article class="article">
                                            <p>По вашему запросу статей не обнаружено</p>
                                        </article>

                                        <?php

                                    }

                                }
                                else
                                {
                                    $total_count_q=mysqli_query($connection, "SELECT COUNT(id) as total_count FROM articles");
                                    $total_count=mysqli_fetch_assoc($total_count_q);
                                    $total_count=$total_count['total_count'];

                                    $total_pages=ceil($total_count/$per_page);
                                    if ($page<=1 || $page>$total_pages)
                                    {
                                        $page=1;
                                    }

                                    $offset = ($per_page * $page) - $per_page;
                                    //1  (4*1)-4 = 0
                                    //2  (4*2)-4 = 4
                                    //3  (4*3)-4 = 8


                                    $articles=mysqli_query($connection, "SELECT * FROM articles ORDER BY id DESC LIMIT $offset , $per_page");

                                    $articles_exist=true;

                                    if (mysqli_num_rows($articles)<=0)
                                    {
                                        $articles_exist=false;
                                        ?>

                                        <article class="article">
                                            <p>Нет статей</p>
                                        </article>

                                        <?php

                                    }

                                }

                                ?>

                                <?php
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
                                ?>




                            </div>
                            <?php

                            if ($articles_exist&&!$cat_exist) {
                                echo '<div class="paginator">';
                                if ($page > 1) {

                                    echo '<a href="../pages/articles.php?page=' . ($page - 1) . '">&laquo;Предыдущая страница ('.($page-1).') </a> &nbsp &nbsp';
                                }
                                if ($page < $total_pages) {
                                    echo '<a href="../pages/articles.php?page=' . ($page + 1) . '">Следующая страница ('.($page+1).')&raquo;</a>';
                                }
                                echo '</div>';
                            }
                            else if ($articles_exist)
                            {
                                echo '<div class="paginator">';
                                if ($page > 1) {
                                    echo '<a href="../pages/articles.php?category='.$category.'&page=' . ($page - 1) . '">&laquo;Предыдущая страница ('.($page-1).') </a> &nbsp &nbsp';
                                }
                                if ($page < $total_pages) {
                                    echo '<a href="../pages/articles.php?category='.$category.'&page=' . ($page + 1) . '">Следующая страница ('.($page+1).')&raquo;</a>';
                                }
                                echo '</div>';
                            }
                            ?>
                        </div>
                    </div>








                </section>
                <section class="content__right col-md-4">
                    <?php include "../includes/sidebar.php";?>
                </section>
            </div>
        </div>
    </div>

    <?php include "../includes/footer.php";?>

</div>

</body>
</html>