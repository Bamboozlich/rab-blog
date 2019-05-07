<footer id="footer">
    <div class="container">
        <div class="footer__logo">
            <h1><?php echo $config['title']?></h1>
        </div>
        <nav class="footer__menu">
            <ul>
                <li><a href="/">Главная</a></li>
                <li><a href="../pages/about_me.php">Обо мне</a></li>
                <li><a href="<?php echo $config['vk_url'];?>" target="_blank"><i class="fa fa-vk fa-fw fa-2x"></i>Я Вконтакте</a></li>
                <li><a href="../pages/copyright.php">Правообладателям</a></li>
            </ul>
        </nav>
    </div>
    <script>
        //функция для выделения активного элемента меню
        for (var i = 0; i < document.links.length; i++) {
            if (document.links[i].href == document.URL) {
                document.links[i].className = 'active';
            }
        }
    </script>
</footer>