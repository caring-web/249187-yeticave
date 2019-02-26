<?php
$config = [
    'sitename' => 'YetiCave',  //имя сайта
    'timezone' => 'Europe/Moscow',  //часовой пояс
    'avatar_path' => 'uploads/avatars/',  //путь к аватарам пользователей
    'lot_img_path' => 'uploads/lots/'  //путь к изображениям лотов
];

date_default_timezone_set($config['timezone']);
