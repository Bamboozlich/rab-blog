<?php

require "includes/config.php";

?>

<?php

require "includes/head.php";

?>

<body>

  <div id="wrapper">

      <?php include "includes/header.php";?>

    <div id="content">
      <div class="container">
        <div class="row">
          <section class="content__left col-md-8">
            <div class="block">
              <a href="pages/articles.php">Все записи</a>
              <h3>Новейшее_в_блоге</h3>
              <div class="block__content">
                <div class="articles articles__horizontal">

                    <?php
                        $articles=mysqli_query($connection, "SELECT * FROM articles ORDER BY id DESC LIMIT 10");
                    ?>

                    <?php
                    while ($art = mysqli_fetch_assoc($articles)) {
                        ?>
                        <article class="article">
                            <div class="article__image"
                                 style="background-image: url(static/images/<?php echo $art['image']; ?>);"></div>
                            <div class="article__info">
                                <a href="pages/article.php?id=<?php echo $art['id']; ?>"><?php echo $art['title'];?></a>
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
                                                href="pages/articles.php?category=<?php echo $art_cat['id'];?>"><?php echo $art_cat['title'];?></a></small>
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
              </div>
            </div>

              <?php

              $main_categories=mysqli_query($connection,"SELECT * FROM articles_categories WHERE is_main='YES'");

              while ($mcat = mysqli_fetch_assoc($main_categories)) {
                  ?>

                  <div class="block">
                      <a href="pages/articles.php?category=<?php echo $mcat['id']?>">Все записи</a>
                      <h3><?php echo $mcat['title']?> [Новейшее]</h3>
                      <div class="block__content">
                          <div class="articles articles__horizontal">

                              <?php
                              $this_cat=$mcat['id'];
                              $articles=mysqli_query($connection, "SELECT * FROM articles WHERE category_id=$this_cat ORDER BY id DESC LIMIT 6");
                              ?>

                              <?php
                              while ($art = mysqli_fetch_assoc($articles)) {
                                  ?>
                                  <article class="article">
                                      <div class="article__image"
                                           style="background-image: url(static/images/<?php echo $art['image']; ?>);"></div>
                                      <div class="article__info">
                                          <a href="/pages/article.php?id=<?php echo $art['id']; ?>"><?php echo $art['title'];?></a>
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
                                                          href="pages/articles.php?category=<?php echo $art_cat['id'];?>"><?php echo $art_cat['title'];?></a></small>
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
                      </div>
                  </div>

              <?php
              }
              ?>





          </section>
          <section class="content__right col-md-4">
              <?php include "includes/sidebar.php";?>
          </section>
        </div>
      </div>
    </div>

      <?php include "includes/footer.php";?>

  </div>

</body>
</html>