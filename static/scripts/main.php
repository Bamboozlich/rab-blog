<?php

function showDate($time) { // Определяем количество и тип единицы измерения
    $time = time() - $time; // to get the time since that moment
    $time = ($time<1)? 1 : $time;
    if ($time < 60) {
        return 'меньше минуты назад';
    } elseif ($time < 3600) {
        return dimension((int)($time/60), 'i');
    } elseif ($time < 86400) {
        return dimension((int)($time/3600), 'G');
    } elseif ($time < 2592000) {
        return dimension((int)($time/86400), 'j');
    } elseif ($time < 31104000) {
        return dimension((int)($time/2592000), 'n');
    } elseif ($time >= 31104000) {
        return dimension((int)($time/31104000), 'Y');
    }
}

function dimension($time, $type) { // Определяем склонение единицы измерения
    $dimension = array(
        'i' => array('минут', 'минуту', 'минуты'),
        'G' => array('часов', 'час', 'часа'),
        'j' => array('дней', 'день', 'дня'),
        'n' => array('месяцев', 'месяц', 'месяца', 'месяц'),
        'Y' => array('лет', 'год', 'года')
    );
    if ($time >= 5 && $time <= 20)
        $n = 0;
    else if ($time == 1 || $time % 10 == 1)
        $n = 1;
    else if (($time <= 4 && $time >= 1) || ($time % 10 <= 4 && $time % 10 >= 1))
        $n = 2;
    else
        $n = 0;
    return $time.' '.$dimension[$type][$n]. ' назад';

}

function deleteComment($connection,$id) {
    mysqli_query($connection, "DELETE FROM comments WHERE id='".$id."'");
}


?>