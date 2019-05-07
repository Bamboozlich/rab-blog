<?php

require "../../includes/config.php";

?>



<?php if(isset($_SESSION['logged_admin'])) : ?>

<?php


$categories_exist = true;
$categories_q = mysqli_query($connection, "SELECT * FROM articles_categories");

if (mysqli_num_rows($categories_q) <= 0) {
    $categories_exist = false;
}

$categories = array();
while ($cat = mysqli_fetch_assoc($categories_q)) {
    $categories[] = $cat;
}

?>
<div>
    <?php
    if ($categories_exist) {
        ?>

        <table border="1" style="margin-bottom: 15px">

            <thead>
            <th>id<?php echo '&nbsp &nbsp &nbsp' ?></th>
            <th>categories</th>
            </thead>


            <?php


            foreach ($categories as $cat) {
                ?>

                <tbody>
                <td><?= $cat['id'] ?></td>
                <td><?= $cat['title'] ?></td>
                </tbody>

                <?php

            } ?>

        </table>

        <?php
    } else {
        echo '<hr><div style="color:red;">Категории отсутствуют!</div><hr>';
    }

    ?>

<?php else : ?>
    <a href="../../pages/adminp/adminka.php">Авторизуйтесь</a>
    <br>
<?php endif; ?>
