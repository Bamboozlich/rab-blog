<?php

require "../includes/config.php";

?>

<?php

require "../includes/head.php";

?>

<?php
$login=$_SESSION['logged_admin']['login'];

$article=mysqli_query($connection,"SELECT slogan,image,text FROM admins  WHERE login='$login'");

$art = mysqli_fetch_assoc($article);

?>

<div id="wrapper">

    <?php include "../includes/header.php";?>

    <div id="content">
        <div class="container">
            <div class="row">
                <section class="content__left col-md-8">
                    <div class="block">
                        <h3>Обо мне</h3>
                        <div class="block__content">
                            <img class="image_large" src="../static/images/<?php echo $art['image'] ?>">

                            <div class="full-text" align="justify">
                                <h1><?php echo $art['slogan'] ?></h1>
                                <div class="full-text text_simple_article">
                                    <?php echo $art['text'] ?>
                                </div>

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

    <?php include "../includes/footer.php";?>

</div>

</body>
</html>